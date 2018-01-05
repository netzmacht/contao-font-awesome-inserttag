<?php

/**
 * @package    contao-font-awesome-inserttag
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2015-2017 netzmacht David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

/*
 * Register the hook.
 */

$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = ['font_awesome_inserttag.hook_listener', 'onReplaceInsertTags'];
