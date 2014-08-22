<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Component\Certy\Builder;

use Certificationy\Component\Certy\Collector\Collector;
use Certificationy\Component\Certy\Collector\CollectorInterface;
use Certificationy\Component\Certy\Context\CertificationContextInterface;
use Certificationy\Component\Certy\Model\Answer;
use Certificationy\Component\Certy\Model\Category;
use Certificationy\Component\Certy\Model\Certification;
use Certificationy\Component\Certy\Model\Metrics;
use Certificationy\Component\Certy\Model\Question;
use Psr\Log\LoggerInterface;

class Builder implements BuilderInterface
{
    /**
     * @var BuilderPassInterface[]
     */
    protected $builderPass;

    /**
     * @var CollectorInterface
     */
    protected $collector;

    /**
     * @var Certification[]
     */
    protected $cache;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param CollectorInterface $collector
     */
    public function __construct(CollectorInterface $collector = null)
    {
        $this->collector = null === $collector ? new Collector() : $collector;
        $this->builderPass = [];
        $this->cache = [];
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger = null)
    {
        $this->logger = $logger;
    }

    /**
     * @return Certification
     */
    public static function createCertification()
    {
        return new Certification();
    }

    /**
     * @param BuilderPassInterface $builderPass
     *
     * @return $this
     */
    public function addBuilderPass(BuilderPassInterface $builderPass)
    {
        if (null !== $this->logger) {
            $this->logger->debug(sprintf(
                'Builder pass %s loaded',
                get_class($builderPass)
            ));
        }

        $this->builderPass[] = $builderPass;

        return $this;
    }

    /**
     * @param CertificationContextInterface $context
     *
     * @return Certification
     */
    protected function normalize(CertificationContextInterface $context)
    {
        $certification = static::createCertification();
        $certification->setContext($context);

        if (null !== $this->logger) {
            $this->logger->debug(sprintf('Normalize %s', $context->getName()));
        }

        $flattenResources = $this->collector->getFlattenResources($context->getName());

        //Should I throw Exception like NoResourcesCollectedException ?
        if(empty($flattenResources)){
            return $certification;
        }

        $metrics = $certification->getMetrics();

        foreach ($this->collector->getFlattenResources($context->getName()) as $resource) {

            if ($resource->getCertificationName() !== $context->getName()) {
                continue;
            }

            $resourceContent = $resource->getContent();

            if (empty($resourceContent)) {
                continue;
            }

            if (null !== $this->logger) {
                $this->logger->debug(
                    sprintf(
                        'Adding resource %s on certification %s',
                        $resource->getResourceName(),
                        $resource->getCertificationName()
                    ),
                    $resource->getContent()
                );
            }

            $category = new Category();
            $category->setLabel($resourceContent['category']);
            $category->setName($resource->getResourceName());
            $metrics->increment(Metrics::CATEGORY);

            if (empty($resourceContent['questions'])) {
                $resourceContent['questions'] = [];
            }

            foreach ($resourceContent['questions'] as $questionContent) {
                $question = new Question();
                $question->setLabel($questionContent['question']);
                $metrics->increment(Metrics::QUESTION);

                foreach ($questionContent['answers'] as $answerContent) {
                    $answer = new Answer();
                    $answer->setLabel($answerContent['value']);
                    $answer->setExpected($answerContent['correct']);
                    $metrics->increment(Metrics::ANSWER);

                    $question->addAnswer($answer);
                }

                $category->addQuestion($question);
            }

            $certification->addCategory($category);
        }

        return $certification;
    }

    /**
     * @param CertificationContextInterface $context
     *
     * @return Certification
     */
    public function build(CertificationContextInterface $context)
    {
        if ($this->collector->isDirty()) {
            $this->collector->release();
        }

        if (null !== $this->logger) {
            $this->logger->debug(sprintf(
                'Build certification %s',
                $context->getName()
            ));
        }

        $oid = md5(serialize($context)); //It's not based of object instance, but on his content.

        if (!isset($this->cache[$oid])) {
            foreach ($this->builderPass as $pass) {
                $pass->setCollector($this->collector);
                $pass->execute($this, $context);
            }

            $this->cache[$oid] = $this->normalize($context);
        }

        return $this->cache[$oid];
    }

    /**
     * @return Collector|CollectorInterface
     */
    public function getCollector()
    {
        return $this->collector;
    }
}
