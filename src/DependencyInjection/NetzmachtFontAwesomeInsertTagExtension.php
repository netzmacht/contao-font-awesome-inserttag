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

        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        $container->setParameter('font_awesome_inserttag.default_style', $config['default_style']);

        if (isset($config['icon_template'])) {
            $container->setParameter('font_awesome_inserttag.icon_template', $config['icon_template']);
        }

        if (isset($config['stack_template'])) {
            $container->setParameter('font_awesome_inserttag.stack_template', $config['stack_template']);
        }
    }
}
