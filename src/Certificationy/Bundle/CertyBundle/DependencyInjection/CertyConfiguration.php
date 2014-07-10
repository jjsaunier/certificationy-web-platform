<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Bundle\CertyBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;

class CertyConfiguration
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerBuilder
     */
    protected $container;

    /**
     * @var array
     */
    protected $defaultClasses = array(
        'description' => 'Certificationy\Bundle\CertyBundle\Process\Certification\DescriptionStep',
        'quiz' => 'Certificationy\Bundle\CertyBundle\Process\Certification\QuizStep',
        'final' => 'Certificationy\Bundle\CertyBundle\Process\Certification\FinalStep'
    );

    /**
     * @param ContainerBuilder $container
     */
    public function __construct(ContainerBuilder $container)
    {
        $this->container = $container;
    }

    /**
     * @param array $providerConfig
     */
    public function buildProvider(Array $providerConfig)
    {
        if (isset($providerConfig['file'])) {
            $this->container->setParameter('certy_file_provider_root_dir', $providerConfig['file']['root_dir']);
        }
    }

    /**
     * @param array $scenarioConfig
     */
    public function buildScenario(Array $scenarioConfig)
    {
        $this->container->setParameter('certy_scenario_class', $scenarioConfig['class']);
    }

    /**
     * @param array $stepsConfig
     */
    public function buildSteps(Array $stepsConfig)
    {
        $parameters = array();

        foreach ($this->defaultClasses as $stepName => $stepClass) {
            $class = isset($stepsConfig[$stepName])
                ? $stepsConfig[$stepName]
                : $stepClass
            ;

            $parameters[$stepName] = $class;
        }

        $this->container->setParameter('certy_certification_step_classes', $parameters);
    }
}
