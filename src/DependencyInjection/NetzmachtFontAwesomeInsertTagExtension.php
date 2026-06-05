<?php

declare(strict_types=1);

namespace Netzmacht\Contao\FontAwesomeInsertTag\DependencyInjection;

use Override;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

final class NetzmachtFontAwesomeInsertTagExtension extends Extension
{
    #[Override]
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config'),
        );

        $loader->load('config.yaml');
        $loader->load('services.yaml');

        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        $container->setParameter('netzmacht_font_awesome_insert_tag.default_style', $config['default_style']);

        if (isset($config['icon_template'])) {
            $container->setParameter('netzmacht_font_awesome_insert_tag.icon_template', $config['icon_template']);
        }

        if (! isset($config['stack_template'])) {
            return;
        }

        $container->setParameter('netzmacht_font_awesome_insert_tag.stack_template', $config['stack_template']);
    }
}
