<?php

declare(strict_types=1);

namespace ILIAS\UI\examples\Input\ViewControl\Pagination;

function with_limit_options()
{
    global $DIC;
    $f = $DIC['ui.factory'];
    $r = $DIC['ui.renderer'];

    $fs = $f->input()->viewControl()->pagination(10, 10)
        ->withLimitOptions([1,2,3,4,5]);

    return $r->render($fs);
}
