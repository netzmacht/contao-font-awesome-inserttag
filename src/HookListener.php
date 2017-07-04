<?php

/**
 * @package    contao-font-awesome-inserttag
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2015-2017 netzmacht David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\FontAwesomeInsertTag;

/**
 * Class HookListener.
 *
 * @package Netzmacht\Contao\FontAwesomeInsertTag
 */
class HookListener
{
    /**
     * Icon template.
     *
     * @var string
     */
    private $iconTemplate;

    /**
     * Icon stack template.
     *
     * @var string
     */
    private $stackTemplate;

    /**
     * HookListener constructor.
     *
     * @param string $iconTemplate  The icon template.
     * @param string $stackTemplate The stack template.
     */
    public function __construct($iconTemplate, $stackTemplate)
    {
        $this->iconTemplate  = $iconTemplate;
        $this->stackTemplate = $stackTemplate;
    }

    /**
     * Replace the insert tag.
     *
     * @param string $tag The insert tag.
     *
     * @return bool|string
     */
    public function onReplaceInsertTags($tag)
    {
        if (strpos($tag, 'fa::') === 0) {
            return $this->replaceIconInsertTag($tag);

        }

        if (strpos($tag, 'fa-stack::') === 0) {
            return $this->replaceIconStackInsertTag($tag);

        }

        return false;
    }

    /**
     * Replace the icon insert tag.
     *
     * Supported are following options:
     * {{fa::phone}}
     * {{fa::phone 4x muted}}                   every entry sperated by space get an fa- prefix.
     * {{fa::phone rotate-90 large:pull-left}}  2nd param is added as class without prefix.
     * {{fa::phone rotate-90 large::pull-left}} 2nd param is added as class without prefix using old syntax.
     *
     * @param string $tag The given tag.
     *
     * @return string
     */
    private function replaceIconInsertTag($tag)
    {
        if (substr_count($tag, '::') > 1) {
            return $this->createIcon($tag, true, '::');
        }

        return $this->createIcon($tag, true);
    }

    /**
     * Replace the icon stack insert tag.
     *
     * The insert tag follows the same options used for the icon insert tag. Additionally each icon is separated by "::"
     * It's also possible to add classes for the stack itself as third param separated by "::".
     *
     * {{fa-stack::icon-one:extra-class::icon-two:extra-class::stack-classes:extra-class}}
     *
     * @param string $tag The given tag.
     *
     * @return string
     */
    private function replaceIconStackInsertTag($tag)
    {
        // Remove fa-stack::
        $tag   = substr($tag, 10);
        $parts = explode('::', $tag);
        $parts = array_pad($parts, 3, '');

        $firstIcon  = $this->createIcon($parts[0]);
        $secondIcon = $this->createIcon($parts[1]);
        $classes    = '';

        if (!empty($parts[2])) {
            $classes = explode(':', $parts[2]);
            $classes = array_pad($classes, 2, '');
            $classes = $this->createClassList($classes[0], $classes[1]);

            if ($classes) {
                $classes = ' ' . $classes;
            }
        }

        return sprintf($this->stackTemplate, $classes, $firstIcon, $secondIcon);
    }

    /**
     * Create the icon based on the icon template.
     *
     * @param string $tag             Given raw icon tag with or without the fa:: prefix.
     * @param bool   $removeInsertTag If true the fa:: prefix is expected to be there.
     * @param string $delimiter       Delimiter for each icon value.
     *
     * @return string
     */
    private function createIcon($tag, $removeInsertTag = false, $delimiter = ':')
    {
        if ($removeInsertTag) {
            $tag = substr($tag, 4);
        }

        $parts   = explode($delimiter, $tag);
        $parts   = array_pad($parts, 2, '');
        $classes = $this->createClassList($parts[0], $parts[1]);

        if (!$classes) {
            return '';
        }

        return sprintf($this->iconTemplate, $classes);
    }

    /**
     * Create classes list by adding fa prefix for thirst param.
     *
     * @param string      $faClasses    Classes which should get fa prefix separated by space.
     * @param string|null $extraClasses Extra classes separated by space.
     *
     * @return string
     */
    private function createClassList($faClasses, $extraClasses = null)
    {
        $faClasses = array_map(
            function ($class) {
                return 'fa-' . $class;
            },
            array_filter(
                explode(' ', $faClasses)
            )
        );

        $classes = implode(' ', $faClasses);

        if (!empty($extraClasses)) {
            $classes .= ' ' . $extraClasses;
        }

        return $classes;
    }
}
