<?php
namespace Certificationy\Bundle\CertyBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * @var string
     */
    protected $defaultCalculatorClass = 'Certificationy\Component\Certy\Calculator\Calculator';

    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $root = $treeBuilder->root('certificationy_certy');
        $root->children()
            ->arrayNode('calculator')
                ->children()
                    ->scalarNode('class')->defaultValue($this->defaultCalculatorClass)->end()
                    ->scalarNode('delegator')
                        ->defaultValue(null)
                        ->validate()
                        ->ifNotInArray(CertyConfiguration::$acceptedDelegator)
                            ->thenInvalid('Invalid delegator %s')
                        ->end()
                    ->end()
                ->end()
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
        ->end();

        return $treeBuilder;
    }
}
