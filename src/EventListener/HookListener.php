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

namespace Netzmacht\Contao\FontAwesomeInsertTag\EventListener;

/**
 * Class HookListener.
 */
final class HookListener
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
    public function __construct(string $iconTemplate, string $stackTemplate)
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
    public function onReplaceInsertTags(string $tag)
    {
        if (preg_match('/^fa([bsrl]?)\:\:/', $tag)) {
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
     * Supported are following options where STYLE is a value of [fa,fas,fal,fab].
     * {{STYLE::phone}}
     * {{STYLE::phone 4x muted}}                   every entry sperated by space get an fa- prefix.
     * {{STYLE::phone rotate-90 large:pull-left}}  2nd param is added as class without prefix.
     * {{STYLE::phone rotate-90 large::pull-left}} 2nd param is added as class without prefix using old syntax.
     *
     * @param string $tag The given tag.
     *
     * @return string
     */
    private function replaceIconInsertTag(string $tag): string
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
    private function replaceIconStackInsertTag(string $tag): string
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
            $classes = $this->createClassList('fa', $classes[0], $classes[1]);

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
    private function createIcon(string $tag, bool $removeInsertTag = false, string $delimiter = ':'): string
    {
        if ($removeInsertTag) {
            $parts = explode('::', $tag, 2);
            $style = $parts[0];
            $tag   = $parts[1];
        } else {
            $style = 'fa';
        }

        $parts   = explode($delimiter, $tag);
        $parts   = array_pad($parts, 2, '');
        $classes = $style . ' ' . $this->createClassList($style, $parts[0], $parts[1]);

        if (!$classes) {
            return '';
        }

        return sprintf($this->iconTemplate, $classes);
    }

    /**
     * Create classes list by adding fa prefix for thirst param.
     *
     * @param string      $style        Icon style.
     * @param string      $faClasses    Classes which should get fa prefix separated by space.
     * @param string|null $extraClasses Extra classes separated by space.
     *
     * @return string
     */
    private function createClassList(string $style, string $faClasses, ?string $extraClasses = null): string
    {
        $faClasses = array_map(
            function ($class) use ($style) {
                return $style . '-' . $class;
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
