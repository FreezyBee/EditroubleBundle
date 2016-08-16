<?php

namespace FreezyBee\EditroubleBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package FreezyBee\EditroubleBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('editrouble');

        $rootNode
            ->children()
                ->scalarNode('role')->defaultValue('ROLE_ADMIN')->end()
                ->scalarNode('info_message')->defaultValue('Zadejte text...')->end()
            ->end();

        return $treeBuilder;
    }
}
