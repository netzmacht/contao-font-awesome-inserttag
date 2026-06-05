<?php

declare(strict_types=1);

namespace Netzmacht\Contao\FontAwesomeInsertTag\EventListener;

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;

use function array_filter;
use function array_map;
use function array_pad;
use function array_shift;
use function explode;
use function implode;
use function preg_match;
use function sprintf;
use function substr;
use function substr_count;

final readonly class HookListener
{
    /**
     * @param string $iconTemplate  The icon template.
     * @param string $stackTemplate The stack template.
     * @param string $defaultStyle  The default style used for the fa insert tag.
     */
    public function __construct(
        private string $iconTemplate,
        private string $stackTemplate,
        private string $defaultStyle = 'fa',
    ) {
    }

    /**
     * Replace the insert tag.
     *
     * @param string $tag The insert tag.
     */
    #[AsHook('replaceInsertTag')]
    public function onReplaceInsertTags(string $tag): bool|string
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
     */
    private function replaceIconInsertTag(string $tag): string
    {
        $delimiter     = substr_count($tag, '::') > 1 ? '::' : ':';
        [$style, $tag] = array_pad(explode('::', $tag, 2), 2, '');

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
     */
    private function replaceIconStackInsertTag(string $tag): string
    {
        $parts = explode('::', $tag);
        $style = substr(array_shift($parts), 0, -6);
        $parts = array_pad($parts, 3, '');

        $firstIcon  = $this->createIcon($style, $parts[0]);
        $secondIcon = $this->createIcon($style, $parts[1]);
        $classes    = '';

        /** @psalm-suppress RiskyTruthyFalsyComparison */
        if (! empty($parts[2])) {
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
     * @param string           $style     The icon style.
     * @param string           $tag       Given raw icon tag with or without the fa:: prefix.
     * @param non-empty-string $delimiter Delimiter for each icon value.
     */
    private function createIcon(string $style, string $tag, string $delimiter = ':'): string
    {
        if ($style === 'fa') {
            $style = $this->defaultStyle;
        }

        $parts   = explode($delimiter, $tag);
        $parts   = array_pad($parts, 2, '');
        $classes = $style . ' ' . $this->createClassList($parts[0], $parts[1]);

        return sprintf($this->iconTemplate, $classes);
    }

    /**
     * Create classes list by adding fa prefix for thirst param.
     *
     * @param string      $faClasses    Classes which should get fa prefix separated by space.
     * @param string|null $extraClasses Extra classes separated by space.
     */
    private function createClassList(string $faClasses, string|null $extraClasses = null): string
    {
        $faClasses = array_map(
            static function (string $class): string {
                return 'fa-' . $class;
            },
            array_filter(
                explode(' ', $faClasses),
            ),
        );

        $classes = implode(' ', $faClasses);

        /** @psalm-suppress RiskyTruthyFalsyComparison */
        if (! empty($extraClasses)) {
            $classes .= ' ' . $extraClasses;
        }

        return $classes;
    }
}
