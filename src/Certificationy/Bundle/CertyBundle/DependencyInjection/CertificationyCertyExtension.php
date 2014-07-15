<?php
namespace Certificationy\Bundle\CertyBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class CertificationyCertyExtension extends Extension
{
    /**
     * @param array            $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $certyConfig = new CertyConfiguration($container);

        //Build provider config
        if (isset($config['provider'])) {
            $certyConfig->buildProvider($config['provider']);
        }

        //Build scenario config
        if (isset($config['scenario'])) {
            $certyConfig->buildScenario($config['scenario']);
        }

        //Build step config
        if (isset($config['steps'])) {
            $certyConfig->buildSteps($config['steps']);
        }

        //Debug
        $container->setParameter('certy_debug', $config['debug']);

        //Calculator
        if (isset($config['calculator'])) {
            $certyConfig->buildCalculator($config['calculator']);
        }

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config/services'));
        $loader->load('certificationy.yml');
        $loader->load('form.yml');
        $loader->load('event.yml');
        $loader->load('twig.yml');
    }
}
