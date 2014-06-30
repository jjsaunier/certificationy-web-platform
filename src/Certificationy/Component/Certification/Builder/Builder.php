<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certification\Builder;

use Certificationy\Component\Certification\Collector\Collector;
use Certificationy\Component\Certification\Collector\CollectorInterface;
use Certificationy\Component\Certification\Context\CertificationContext;
use Certificationy\Component\Certification\Model\Answer;
use Certificationy\Component\Certification\Model\Category;
use Certificationy\Component\Certification\Model\Certification;
use Certificationy\Component\Certification\Model\Question;

class Builder
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
     * @var CertificationContext
     */
    protected $certificationContext;

    /**
     * @var bool
     */
    protected $initialized;

    /**
     * @param CertificationContext $certificationContext
     * @param CollectorInterface   $collector
     */
    public function __construct(CertificationContext $certificationContext, CollectorInterface $collector = null)
    {
        $this->collector = null === $collector ? new Collector() : $collector;
        $this->builderPass = array();
        $this->certificationContext = $certificationContext;
        $this->initialized = false;
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
     * @return Certification
     */
    protected function normalize()
    {
        $certification = static::createCertification();

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
                    $answer->setLabel($answerContent);
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
     * @return Certification
     * @throws \Exception
     */
    public function build()
    {
        if (true === $this->initialized) {
            throw new \Exception('Build already done for this instance :(');
        }

        $this->initialized = true;

        foreach ($this->builderPass as $pass) {
            $this->collector->addResources($pass->execute($this, $this->certificationContext));
        }

        return $this->normalize();
    }
}
