<?php

/**
 * @package    contao-font-awesome-inserttag
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017 netzmacht David Molineus. All rights reserved.
 * @filesource
 *
 */

namespace Netzmacht\Contao\FontAwesomeInsertTag\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration.
 *
 * @package Netzmacht\Contao\FontAwesomeInsertTag\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('netzmacht_font_awesome_insert_tag');

        $treeBuilder
            ->getRootNode()
            ->children()
                ->scalarNode('icon_template')
                ->end()
                ->scalarNode('stack_template')
                ->end()
                ->scalarNode('default_style')
                ->defaultValue('fa')
                ->end()
                ->end();

        return $treeBuilder;
    }
}
