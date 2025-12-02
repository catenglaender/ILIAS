<?php

declare(strict_types=1);

namespace ILIAS\UI\examples\Listing\Property;

/**
 * ---
 * expected output: >
 *   ILIAS shows the rendered Component.
 * ---
 */
function base()
{
    global $DIC;
    $f = $DIC->ui()->factory();
    $renderer = $DIC->ui()->renderer();

    $props = $f->listing()->property()
        ->withProperty('Title', 'Some Title')
        ->withProperty('number', '7')
        ->withProperty(
            'status',
            $renderer->render(
                $f->symbol()->icon()->custom('./assets/images/learning_progress/in_progress.svg', 'incomplete'),
            ) . ' in progress',
            false
        )
        ->withProperty("date of upload", "21.03.2026", false, $f->symbol()->glyph()->calendar());

    $props2 = $props->withItems([
        ['a', "1"],
        ['y', "25", false],
        ['link', $f->link()->standard('Goto ILIAS', 'http://www.ilias.de')],
        ['approved', 'yes', true, null, $f->symbol()->glyph()->apply()],
    ]);

    return $renderer->render([
            $props,
            $f->divider()->horizontal(),
            $props2
    ]);
}
