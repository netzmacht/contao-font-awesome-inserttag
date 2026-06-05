<?php

declare(strict_types=1);

namespace Netzmacht\Contao\FontAwesomeInsertTag\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Netzmacht\Contao\FontAwesomeInsertTag\NetzmachtFontAwesomeInsertTagBundle;
use Override;

final class Plugin implements BundlePluginInterface
{
    /** {@inheritDoc} */
    #[Override]
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(NetzmachtFontAwesomeInsertTagBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }
}
