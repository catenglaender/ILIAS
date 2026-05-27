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
 *   This example shows how to create and render a Lenght Of Time field and attach it to a form.
 *
 * expected output: >
 *   ILIAS shows multiple sets of Length of Time fields. The units vary from group to group.
 *   In this example, the values remain as entered. They are not re-calculated or changed to better fit
 *   into the boundaries of the individual units.
 * ---
 */
function noOverflow()
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
        'no_overflow'
    );
    $form_action = $DIC->ctrl()->getFormActionByClass('ilsystemstyledocumentationgui');

    $blueprints = [
        [
            "name" => "Lesson duration",
            "date_interval" => DateInterval::createFromDateString("1 hour 67 minutes"),
            "field_pattern" => LengthOfTimeFieldPatterns::hoursMinutes,
        ],
        [
            "name" => "Break duration",
            "date_interval" => DateInterval::createFromDateString("0 minutes 90 seconds"),
            "field_pattern" => LengthOfTimeFieldPatterns::minutesSeconds,
        ],
        [
            "name" => "Business trip duration",
            "date_interval" => DateInterval::createFromDateString("50 hours 68 minutes"),
            "field_pattern" => LengthOfTimeFieldPatterns::daysHoursMinutes,
        ],
        [
            "name" => "Video duration",
            "date_interval" => DateInterval::createFromDateString("1 hour 90 minutes 90 seconds"),
            "field_pattern" => LengthOfTimeFieldPatterns::hoursMinutesSeconds,
        ],
    ];

    $fields = [];
    foreach ($blueprints as $blueprint) {
        $fields[] = $ui->input()->field()->lengthOfTime($blueprint["name"], null, $blueprint["field_pattern"])
                        ->withValue($blueprint["date_interval"]);
    }

    $form = $ui->input()->container()->form()->standard(
        $form_action,
        $fields,
    );

    // simulates a form processing endpoint:
    if ($request->getMethod() == "POST"
        && array_key_exists('example_name', $request->getQueryParams())
        && $request->getQueryParams()['example_name'] == 'no_overflow') {
        $form = $form->withRequest($request);
        $result = $form->getData();
    } else {
        $result = "No result yet.";
    }


    return '<pre>' . print_r($result, true) . '</pre>' .
        $renderer->render($form);
}
