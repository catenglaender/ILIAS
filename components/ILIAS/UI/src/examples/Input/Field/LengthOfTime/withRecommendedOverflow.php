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
 *   The Length of Time field is set to have values overflow to the next available unit.
 *
 * expected output: >
 *   ILIAS shows multiple sets of Length of Time fields. The units vary from group to group.
 *   The bylines explain which values should be visible in the fields.
 *   When writing values into the field and exceeding the conversion step to the next available unit, time values
 *   will be re-calculated (60 seconds = 1 minute, 60 minutes = 1 hour, 24 hours = 1 day)
 * ---
 */
function withRecommendedOverflow()
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
        'with_overflow'
    );
    $form_action = $DIC->ctrl()->getFormActionByClass('ilsystemstyledocumentationgui');

    $blueprints = [
        [
            "name" => "Lesson duration",
            "byline" =>
                "This field was given 1:67 as the initial value, which overflows to 2:07
                because recommendedTimeOverflow has been set."
            ,
            "date_interval" => DateInterval::createFromDateString("1 hour 67 minutes"),
            "field_pattern" => LengthOfTimeFieldPatterns::hoursMinutes,
        ],
        [
            "name" => "Break duration",
            "byline" =>
                "This field was given 0:90 as the initial value, which overflows to 1:30
                because recommendedTimeOverflow has been set."
            ,
            "date_interval" => DateInterval::createFromDateString("0 minutes 90 seconds"),
            "field_pattern" => LengthOfTimeFieldPatterns::minutesSeconds,
        ],
        [
            "name" => "Business trip duration",
            "byline" =>
                "This field was given 0:50:68 as the initial value, which overflows to 2:03:08
                because recommendedTimeOverflow has been set."
            ,
            "date_interval" => DateInterval::createFromDateString("50 hours 68 minutes"),
            "field_pattern" => LengthOfTimeFieldPatterns::daysHoursMinutes,
        ],
        [
            "name" => "Video duration",
            "byline" =>
                "This field was given 1:90:90 as the initial value, which overflows to 2:31:30
                because recommendedTimeOverflow has been set."
            ,
            "date_interval" => DateInterval::createFromDateString("1 hour 90 minutes 90 seconds"),
            "field_pattern" => LengthOfTimeFieldPatterns::hoursMinutesSeconds,
        ],
    ];

    $fields = [];
    foreach ($blueprints as $blueprint) {
        $fields[] = $ui->input()->field()->lengthOfTime($blueprint["name"], $blueprint["byline"], $blueprint["field_pattern"])
                        ->withValue($blueprint["date_interval"])
                        ->withRecommendedTimeOverflow();
    }

    $form = $ui->input()->container()->form()->standard(
        $form_action,
        $fields,
    );

    // simulates a form processing endpoint:
    if ($request->getMethod() == "POST"
        && array_key_exists('example_name', $request->getQueryParams())
        && $request->getQueryParams()['example_name'] == 'with_overflow') {
        $form = $form->withRequest($request);
        $result = $form->getData();
    } else {
        $result = "No result yet.";
    }


    return '<pre>' . print_r($result, true) . '</pre>' .
        $renderer->render($form);
}
