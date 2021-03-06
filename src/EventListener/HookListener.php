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

use function array_pad;
use function array_shift;
use function explode;
use function preg_match;
use function sprintf;
use function substr;
use function substr_count;
use function var_dump;

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
     * The default style used for the fa insert tag. Useful for Font Awesome 5 support.
     *
     * @var string
     */
    private $defaultStyle;

    /**
     * HookListener constructor.
     *
     * @param string $iconTemplate  The icon template.
     * @param string $stackTemplate The stack template.
     * @param string $defaultStyle  The default style used for the fa insert tag.
     */
    public function __construct(string $iconTemplate, string $stackTemplate, string $defaultStyle = 'fa')
    {
        $this->iconTemplate  = $iconTemplate;
        $this->stackTemplate = $stackTemplate;
        $this->defaultStyle  = $defaultStyle;
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

        if (preg_match('/^fa([bsrl]?)-stack\:\:/', $tag)) {
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
        $delimiter     = substr_count($tag, '::') > 1 ? '::' : ':';
        [$style, $tag] = explode('::', $tag, 2);

        return $this->createIcon($style, $tag, $delimiter);
    }

    /**
     * Replace the icon stack insert tag.
     *
     * The insert tag follows the same options used for the icon insert tag. Additionally each icon is separated by "::"
     * It's also possible to add classes for the stack itself as third param separated by "::".
     *
     * Supported are following options where STYLE is a value of [fa,fas,fal,fab].
     * {{STYLE-stack::icon-one:extra-class::icon-two:extra-class::stack-classes:extra-class}}
     *
     * @param string $tag The given tag.
     *
     * @return string
     */
    private function replaceIconStackInsertTag(string $tag): string
    {
        $parts = explode('::', $tag);
        $style = substr(array_shift($parts), 0, -6);
        $parts = array_pad($parts, 3, '');

        $firstIcon  = $this->createIcon($style, $parts[0]);
        $secondIcon = $this->createIcon($style, $parts[1]);
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
     * @param string $style     The icon style.
     * @param string $tag       Given raw icon tag with or without the fa:: prefix.
     * @param string $delimiter Delimiter for each icon value.
     *
     * @return string
     */
    private function createIcon(string $style, string $tag, string $delimiter = ':'): string
    {
        if ($style === 'fa') {
            $style = $this->defaultStyle;
        }

        $parts   = explode($delimiter, $tag);
        $parts   = array_pad($parts, 2, '');
        $classes = $style . ' ' . $this->createClassList($parts[0], $parts[1]);

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
    private function createClassList(string $faClasses, ?string $extraClasses = null): string
    {
        $faClasses = array_map(
            static function (string $class): string {
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
