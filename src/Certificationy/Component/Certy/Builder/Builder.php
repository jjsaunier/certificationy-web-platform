<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
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
use Certificationy\Component\Certy\Model\Question;

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
     * @param CollectorInterface $collector
     */
    public function __construct(CollectorInterface $collector = null)
    {
        $this->collector = null === $collector ? new Collector() : $collector;
        $this->builderPass = array();
        $this->cache = array();
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

        foreach ($this->collector->getResources() as $resource) {
            $resourceContent = $resource->getContent();

            $category = new Category();
            $category->setLabel($resourceContent['category']);
            $category->setName($resource->getName());

            foreach ($resourceContent['questions'] as $questionContent) {
                $question = new Question();
                $question->setLabel($questionContent['question']);

                foreach ($questionContent['answers'] as $answerContent) {
                    $answer = new Answer();
                    $answer->setLabel($answerContent['value']);
                    $answer->setExpected($answerContent['correct']);

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
        $oid = spl_object_hash($context);

        if (!isset($this->cache[$oid])) {
            foreach ($this->builderPass as $pass) {
                $this->collector->addResources($pass->execute($this, $context));
            }

            $this->cache[$oid] = $this->normalize($context);
        }

        return $this->cache[$oid];
    }
}
