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

namespace spec\Netzmacht\Contao\FontAwesomeInsertTag\EventListener;

use Netzmacht\Contao\FontAwesomeInsertTag\EventListener\HookListener;
use PhpSpec\ObjectBehavior;

/**
 * Class HookListenerSpec
 *
 * @package spec\Netzmacht\Contao\FontAwesomeInsertTag
 */
class HookListenerSpec extends ObjectBehavior
{
    /**
     * The icon template.
     *
     * @var string
     */
    private $iconTemplate = '<i class="%s" aria-hidden="true"></i>';

    /**
     * The stack template.
     *
     * @var string
     */
    private $stackTemplate = '<span class="fa-stack%s">%s%s</span>';

    /**
     * The default style.
     *
     * @var string
     */
    private $defaultStyle = 'fa';

    public function let(): void
    {
        $this->beConstructedWith($this->iconTemplate, $this->stackTemplate, $this->defaultStyle);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(HookListener::class);
    }

    public function it_parses_icon_insert_tag_with_simple_icon(): void
    {
        $this->shouldReplaceInsertTag(
            '%s::plus',
            '<i class="%s fa-plus" aria-hidden="true"></i>'
        );
    }

    public function it_parses_icon_insert_tag_with_extra_fa_classes(): void
    {
        $this->shouldReplaceInsertTag(
            '%s::plus 2x',
            '<i class="%s fa-plus fa-2x" aria-hidden="true"></i>'
        );
    }

    public function it_parses_icon_insert_tag_with_extra_classes(): void
    {
        $this->shouldReplaceInsertTag(
            '%s::plus:pull-left',
            '<i class="%s fa-plus pull-left" aria-hidden="true"></i>'
        );
    }

    public function it_parses_icon_insert_tag_with_extra_classes_using_double_colon(): void
    {
        $this->shouldReplaceInsertTag(
            '%s::plus::pull-left',
            '<i class="%s fa-plus pull-left" aria-hidden="true"></i>'
        );
    }

    public function it_parses_icon_stack_insert_tag_with_simple_icons(): void
    {
        // phpcs:disable
        $expected = '<span class="fa-stack"><i class="fa fa-square" aria-hidden="true">'
            . '</i><i class="fa fa-plus" aria-hidden="true"></i></span>';
        // phpcs:enable

        $this
            ->onReplaceInsertTags('fa-stack::square::plus')
            ->shouldReturn($expected);
    }

    public function it_parses_icon_stack_insert_tag_with_fa_classes(): void
    {
        // phpcs:disable
        $expected = '<span class="fa-stack"><i class="fa fa-square fa-2x" aria-hidden="true"></i>'
            . '<i class="fa fa-plus fa-1x" aria-hidden="true"></i></span>';
        // phpcs:enable

        $this
            ->onReplaceInsertTags('fa-stack::square 2x::plus 1x')
            ->shouldReturn($expected);
    }

    public function it_parses_icon_stack_insert_tag_with_extra_classes(): void
    {
        // phpcs:disable
        $expected = '<span class="fa-stack"><i class="fa fa-square fa-2x pull-left" aria-hidden="true"></i>'
            . '<i class="fa fa-plus fa-1x pull-right" aria-hidden="true"></i></span>';
        // phpcs:enable

        $this
            ->onReplaceInsertTags('fa-stack::square 2x:pull-left::plus 1x:pull-right')
            ->shouldReturn($expected);
    }

    public function it_parses_icon_stack_insert_tag_with_support_for_stack_classes(): void
    {
        // phpcs:disable
        $expected = '<span class="fa-stack fa-lg"><i class="fa fa-square" aria-hidden="true"></i>'
            . '<i class="fa fa-plus" aria-hidden="true"></i></span>';
        // phpcs:enable

        $this
            ->onReplaceInsertTags('fa-stack::square::plus::lg')
            ->shouldReturn($expected);
    }

    public function it_parses_icon_stack_insert_tag_with_support_for_stack_extra_classes(): void
    {
        // phpcs:disable
        $expected = '<span class="fa-stack fa-lg extra"><i class="fa fa-square" aria-hidden="true"></i>'
            . '<i class="fa fa-plus" aria-hidden="true"></i></span>';
        // phpcs:enable

        $this
            ->onReplaceInsertTags('fa-stack::square::plus::lg:extra')
            ->shouldReturn($expected);
    }

    /**
     * Assert that an insert tag is replaced with the expected result.
     *
     * @param string $insertTag The given insert tag.
     * @param string $result    The expected result.
     *
     * @return void
     */
    private function shouldReplaceInsertTag(string $insertTag, string $result): void
    {
        foreach (['fa', 'far', 'fas', 'fal', 'fab'] as $style) {
            $this
                ->onReplaceInsertTags(sprintf($insertTag, $style))
                ->shouldReturn(sprintf($result, $style));
        }
    }
}
