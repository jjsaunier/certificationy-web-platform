<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Bundle\CertyBundle\Process\Certification;

use Certificationy\Component\Certy\Model\Certification;
use Sylius\Bundle\FlowBundle\Process\Builder\ProcessBuilderInterface;
use Sylius\Bundle\FlowBundle\Process\Scenario\ProcessScenarioInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Scenario extends ContainerAware implements ProcessScenarioInterface
{
    /**
     * @var Certification
     */
    protected $certification;

    /**
     * @param Certification $certification
     */
    public function setCertification(Certification $certification)
    {
        $this->certification = $certification;
    }

    /**
     * Builds the whole process.
     *
     * @param ProcessBuilderInterface $builder
     */
    public function build(ProcessBuilderInterface $builder)
    {
        $steps = $this->container->getParameter('certy_certification_step_classes');

        foreach ($steps as $name => $class) {
            $step = new $class;
            $step->setCertification($this->certification);
            $builder->add($name, $step);
        }
    }
}
