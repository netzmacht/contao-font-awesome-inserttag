<?php

/**
 * This files is part of the contao-font-awesome-inserttag extension.
 *
 * @package   netzmacht-contao-font-awesome-inserttag
 * @author    David Molineus <david.molineus@netzmacht.de>
 * @copyright 2017-2021 netzmacht David Molineus. All rights reserved.
 * @license   LGPL-3.0-or-later https://github.com/netzmacht/contao-font-awesome-inserttag/blob/master/LICENSE
 */

declare(strict_types=1);

namespace Netzmacht\Contao\FontAwesomeInsertTag\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration.
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
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
