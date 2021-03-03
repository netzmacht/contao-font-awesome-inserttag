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

/*
 * Register the hook.
 */

$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = ['font_awesome_inserttag.hook_listener', 'onReplaceInsertTags'];
