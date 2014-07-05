<?php
namespace Certificationy\Bundle\CertyBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $root = $treeBuilder->root('certificationy_certy');
        $root->children()
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
