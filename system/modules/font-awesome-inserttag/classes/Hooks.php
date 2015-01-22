<?php

/**
 * @package    contao-font-awesome-inserttag
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\FontAwesomeInsertTag;

/**
 * Hooks contains the insert tag hook.
 *
 * @package Netzmacht\Contao\FontAwesomeInsertTag
 */
class Hooks
{
    /**
     * Replace the insert tag.
     *
     * Supported are followin options:
     * {{fa::phone}}
     * {{fa::phone 4x muted}}                       every entry sperated by space get an fa- prefix
     * {{fa::phone rotate-90 large::pull-left}}     2nd param is added as class without prefix
     *
     * @param string $tag The insert tag.
     *
     * @return bool|string
     */
    public function replaceInsertTags($tag)
    {
        if (strpos($tag, 'fa::') !== 0) {
            return false;
        }

        $parts = explode('::', $tag);
        $class = str_replace(' ', ' fa-', $parts[1]);

        if(isset($parts[2])) {
            $class .= ' ' . $parts[2];
        }

        if (!$class) {
            return '';
        }

        return sprintf($GLOBALS['TL_CONFIG']['faInsertTagTemplate'], $class);
    }
}
