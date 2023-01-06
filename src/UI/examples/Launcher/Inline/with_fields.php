<?php

declare(strict_types=1);

namespace ILIAS\UI\examples\Launcher\Inline;

use ILIAS\Data\URI;

function with_fields()
{
    global $DIC;
    $ui_factory = $DIC['ui.factory'];
    $renderer = $DIC['ui.renderer'];
    $data_factory = new \ILIAS\Data\Factory();
    $request = $DIC->http()->request();
    $ctrl = $DIC['ilCtrl'];

    $url = $data_factory->uri(
        ($_SERVER['REQUEST_SCHEME'] ?? "http") . '://'
        . ($_SERVER['SERVER_NAME'] ?? "localhost") . ':'
        . ($_SERVER['SERVER_PORT'] ?? "80")
        . str_replace('launcher_redirect=1', '', $_SERVER['REQUEST_URI'])
    );

    $target = $data_factory->link('label', $url);
    $icon = $ui_factory->symbol()->icon()->standard('coms', '', 'large');
    $group = $ui_factory->input()->field()->group(
        [
            $ui_factory->input()->field()->text('uid', 'Username'),
            $ui_factory->input()->field()->password('pwd', 'Password')
        ]
    );
    $instruction = $ui_factory->legacy('Fill the form; use password "ilias" to pass');

    $evaluation = function ($data, URI $target) use ($ctrl) {
        if ($data[0][1]->toString() === 'ilias') {
            $ctrl->redirectToURL((string)$target . '&launcher_redirect=1');
        }
        $ctrl->redirectToURL((string)$target);
    };

    $launcher = $ui_factory->launcher()
        ->inline($target)
        ->withDescription('a launcher with fields')
        ->withStatus($icon)
        ->withInputs($group, $evaluation, $instruction)
        ->withRequest($request);

    $result = "not submitted or wrong pass";
    if (array_key_exists('launcher_redirect', $request->getQueryParams())
        && $request->getQueryParams()['launcher_redirect'] == '1'
    ) {
        $result = "<b>sucessfully redirected</b>";
    }
    return $result . "<hr/>" . $renderer->render($launcher);
}
