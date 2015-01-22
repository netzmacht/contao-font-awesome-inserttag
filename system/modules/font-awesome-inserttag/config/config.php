<?php

/**
 * @package    contao-font-awesome-inserttag
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

/*
 * Register the hook.
 */
$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = array('Netzmacht\Contao\FontAwesomeInsertTag\Hooks', 'replaceInsertTags');

/*
 * Template which is used for the insert tag replacing.
 */
$GLOBALS['TL_CONFIG']['faInsertTagTemplate'] = '<i class="fa fa-%s"></i>';
