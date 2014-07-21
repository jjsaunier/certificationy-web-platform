<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Bundle\TrainingBundle\Manager;

use Certificationy\Component\Certy\Builder\Builder;
use Certificationy\Component\Certy\Context\CertificationContext;
use Certificationy\Component\Certy\Factory\CertificationFactory;

class CertificationManager
{
    /**
     * @var \Certificationy\Component\Certy\Factory\CertificationFactory
     */
    protected $factory;

    /**
     * @var Builder
     */
    protected $builder;

    /**
     * @param CertificationFactory $factory
     */
    public function __construct(CertificationFactory $factory, Builder $builder)
    {
        $this->factory = $factory;
        $this->builder = $builder;
    }

    /**
     * @param $name
     *
     * @return \Certificationy\Component\Certy\Model\Certification
     */
    public function getCertification($name)
    {
        return $this->factory->createNamed($name, $this->getContext($name), array('yaml'));
    }

    /**
     * @param $name
     *
     * @return CertificationContext
     */
    public function getContext($name)
    {
        $context = new CertificationContext($name);

        /**
         * Not implemented means no effect.
         */
        if ($name === 'symfony2') {
//            Automatically computed with listener
//            $context->setNumberOfQuestions(100);
//            $context->setRequiredScore(50);
            $context->setLabel('Symfony 2');
            $context->setAvailableLanguages(array('en' => 'English')); //not implemented
            $context->setLanguage('en'); //not implemented
            $context->setDebug(true);
            $context->setAvailableLevels(array(
                'easy' => 'Easy',
                'normal' => 'Normal',
                'medium' => 'Medium',
                'hard' => 'Hard',
                'very_hard' => 'Very hard',
                'stof' => 'Stof'
            ));
            $context->setLevel('default'); //not implemented
            $context->setThreshold(array( //not implemented on display
                array('newbie' => 30),
                array('beginner' => 45),
                array('not_bad' => 50),
                array('good' => 75),
                array('very_good' => 85),
                array('expert' => 95),
                array('jesus_christ' => 100)
            ));
        }

        return $context;
    }
}
