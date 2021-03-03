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

namespace Netzmacht\Contao\FontAwesomeInsertTag\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Netzmacht\Contao\FontAwesomeInsertTag\NetzmachtFontAwesomeInsertTagBundle;

/**
 * Class Plugin.
 */
class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(NetzmachtFontAwesomeInsertTagBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }
}
