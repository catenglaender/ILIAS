<?php

declare(strict_types=1);

namespace ILIAS\UI\examples\Input\ViewControl\FieldSelection;

function base()
{
    global $DIC;
    $f = $DIC['ui.factory'];
    $r = $DIC['ui.renderer'];

    $fs = $f->input()->viewControl()->fieldSelection(
        [
            'c1' => 'column 1',
            'c2' => 'column 2',
            'x' => '...'
        ],
        'shown columns',
        'apply'
    );

    return $r->render($fs);
}
