<?php

declare(strict_types=1);

namespace ILIAS\UI\examples\Input\Container\ViewControl\Standard;

use ILIAS\UI\NotImplementedException;

function base()
{
    global $DIC;
    $f = $DIC['ui.factory'];
    $r = $DIC['ui.renderer'];
    $request = $DIC->http()->request();

    $vcs = [
        $f->input()->viewControl()->pagination(17, 5),
        $f->input()->viewControl()->sortation([
            'field1:ASC' => 'Field 1, ascending',
            'field1:DESC' => 'Field 1, descending',
            'field2:ASC' => 'Field 2, ascending'
        ]),
        $f->input()->viewControl()->fieldSelection([
            'field1' => 'Feld 1',
            'field2' => 'Feld 2'
        ], 'shown columns', 'apply')
    ];

    $vc_container = $f->input()->container()->viewControl()->standard($vcs)
        ->withRequest($request);

    return $r->render([$vc_container, $f->divider()->horizontal()]) . print_r($vc_container->getData(), true);
}
