<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Bundle\CertyBundle\Process\Certification;

use Sylius\Bundle\FlowBundle\Process\Builder\ProcessBuilderInterface;
use Sylius\Bundle\FlowBundle\Process\Scenario\ProcessScenarioInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Scenario extends ContainerAware implements ProcessScenarioInterface
{
    /**
     * @var string
     */
    protected $certificationName;

    /**
     * @param string $name
     */
    public function setCertificationName($name)
    {
        $this->certificationName = $name;
    }

    /**
     * Builds the whole process.
     *
     * @param ProcessBuilderInterface $builder
     */
    public function build(ProcessBuilderInterface $builder)
    {
        $steps = $this->container->getParameter('certy_certification_step_classes');
        $factory = $this->container->get('certy.certification.factory');

        foreach($steps as $name => $class){
            $step = new $class;
            $step->setCertification($certification = $factory->createNamed($this->certificationName));

            $builder->add($name, $step);
        }
    }
}