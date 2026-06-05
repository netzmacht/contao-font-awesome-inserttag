<?php

declare(strict_types=1);

namespace Netzmacht\Contao\FontAwesomeInsertTag\DependencyInjection;

use Override;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    #[Override]
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('netzmacht_font_awesome_insert_tag');
        $rootNode    = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->scalarNode('icon_template')
                  ->info('The icon template')
                ->end()
                ->scalarNode('stack_template')
                    ->info('The template for icon stacks')
                ->end()
                ->scalarNode('default_style')
                    ->info('The default template style')
                    ->defaultValue('fa')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
