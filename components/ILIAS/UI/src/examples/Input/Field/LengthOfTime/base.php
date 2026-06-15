<?php

declare(strict_types=1);

namespace ILIAS\UI\examples\Input\Field\LengthOfTime;

use DateInterval;
use ILIAS\UI\Component\Input\Field\LengthOfTimeFieldPatterns;
use ILIAS\UI\Implementation\Component\Input\Field\LengthOfTime;
use ILIAS\UI\URLBuilder;

/**
 * ---
 * description: >
 *   This example shows how to create and render a basic input field and attach it to a form.
 *   It does not contain any data processing.
 *
 * expected output: >
 *   ILIAS shows an input field titled "Basic Input". You can enter letters and numbers.
 * ---
 */
function base()
{
    global $DIC;
    $http = $DIC->http();
    $ui = $DIC->ui()->factory();
    $renderer = $DIC->ui()->renderer();
    $df = new \ILIAS\Data\Factory();
    $request = $DIC->http()->request();
    $get_request = $http->wrapper()->query();

    $DIC->ctrl()->setParameterByClass(
        'ilsystemstyledocumentationgui',
        'example_name',
        'base'
    );
    $form_action = $DIC->ctrl()->getFormActionByClass('ilsystemstyledocumentationgui');

    $time_interval = DateInterval::createFromDateString("1 hour 67 minutes");
    $field_pattern = LengthOfTimeFieldPatterns::hoursMinutes;


    $length_of_time_field = $ui->input()->field()->lengthOfTime("Session duration", null, $field_pattern)
                        ->withValue($time_interval);
    $form = $ui->input()->container()->form()->standard(
        $form_action,
        [
            $length_of_time_field,
        ],
    );

    // simulates a form processing endpoint:
    if ($request->getMethod() == "POST"
        && array_key_exists('example_name', $request->getQueryParams())
        && $request->getQueryParams()['example_name'] == 'base') {
        $form = $form->withRequest($request);
        $result = $form->getData();
    } else {
        $result = "No result yet.";
    }


    return '<pre>' . print_r($result, true) . '</pre>' .
        $renderer->render($form) . "<br/> ";
    // return json_encode($time_interval->format("%H:%I"));
}
