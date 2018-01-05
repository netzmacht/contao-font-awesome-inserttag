<?php

/**
 * @package    contao-font-awesome-inserttag
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017 netzmacht David Molineus. All rights reserved.
 * @filesource
 *
 */

namespace Netzmacht\Contao\FontAwesomeInsertTag\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Class NetzmachtFontAwesomeInsertTagExtension.
 *
 * @package Netzmacht\Contao\FontAwesomeInsertTag\DependencyInjection
 */
class NetzmachtFontAwesomeInsertTagExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );

        $loader->load('config.yml');
        $loader->load('services.yml');
    }
}
