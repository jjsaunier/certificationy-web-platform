<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Bundle\CertyBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class ScenarioCompilerPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $contextRegistry = $container->get('certy.certification.context_registry');

        foreach ($contextRegistry->getCertificationNames() as $name) {
            $scenarioDefinition = new Definition('Certificationy\Bundle\CertyBundle\Process\Certification\Scenario');
            $scenarioDefinition->addMethodCall('setContainer', array(new Reference('service_container')));
            $scenarioDefinition->addMethodCall('setCertificationName', array($name));
            $scenarioDefinition->addTag('sylius.process.scenario', array('alias' => $name));

            $container->setDefinition('certy.certification.'.$name.'.scenario', $scenarioDefinition);
        }
    }
}
