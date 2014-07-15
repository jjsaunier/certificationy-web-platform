<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Bundle\TrainingBundle\Manager;

use Certificationy\Component\Certy\Context\CertificationContext;
use Certificationy\Component\Certy\Factory\CertificationFactory;

class CertificationManager
{
    /**
     * @var \Certificationy\Component\Certy\Factory\CertificationFactory
     */
    protected $factory;

    /**
     * @param CertificationFactory $factory
     */
    public function __construct(CertificationFactory $factory)
    {
        $this->factory = $factory;
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
    protected function getContext($name)
    {
        $context = new CertificationContext($name);

        if ($name === 'symfony2') {
            $context->setNumberOfQuestions(100);
            $context->setScore(50);
            $context->setLabel('Symfony 2');
            $context->setLanguage('en');
            $context->setDebug(true);

            $context->setThreshold(array(
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
