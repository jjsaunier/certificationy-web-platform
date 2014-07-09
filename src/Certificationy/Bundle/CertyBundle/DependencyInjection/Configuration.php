<?php
namespace Certificationy\Bundle\CertyBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * @var string
     */
    protected $defaultScenarioClass = 'Certificationy\Bundle\CertyBundle\Process\Certification\CertificationScenario';

    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $root = $treeBuilder->root('certificationy_certy');
        $root->children()
            ->arrayNode('scenario')
                ->children()
                    ->scalarNode('class')->defaultValue($this->defaultScenarioClass)->end()
                ->end()
            ->end()
            ->arrayNode('steps')
                ->prototype('scalar')->end()
            ->end()
            ->scalarNode('debug')->end()
            ->arrayNode('provider')
                ->children()
                    ->arrayNode('file')
                        ->children()
                            ->scalarNode('root_dir')->defaultValue('')
                        ->end()
                    ->end()
                ->end()
            ->end()
            ->cannotBeEmpty()
            ->isRequired()
        ->end();

        return $treeBuilder;
    }
}
