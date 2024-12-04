<?php

declare(strict_types=1);

namespace ILIAS\UI\examples\Input\Field\SearchableSelect;

/**
 * ---
 * description: >
 *   Example shows a searchable select input with a radio field component given to it.
 *
 * expected output: >
 *   ILIAS shows the rendered Component.
 * ---
 */

function radio(): string
{
    global $DIC;
    $ui = $DIC->ui()->factory();
    $renderer = $DIC->ui()->renderer();
    $request = $DIC->http()->request();

    $options = array(
        "1" => "Welcome (External Guest)",
        "2" => "Welcome (Office)",
        "3" => "Welcome (International)",
        "4" => "Reminder Expiration",
        "5" => "Reminder Deadline",
        "6" => "Passed",
        "7" => "Failed - Try Again",
        "8" => "Failed Permanently",
        "9" => "Notification for Trainer",
        "10" => "Notification for Leader",
        "11" => "Notification for Staff",
        "12" => "Hotel Booking Request",
        "13" => "Hotel Booking Information Participant",
        "14" => "Hotel Booking Information Trainer",
    );

    $single_select = $ui->input()->field()->radio("Templates", "check an option");

    foreach ($options as $value => $label) {
        $single_select = $single_select->withOption((string)$value, (string)$label);
    }

    $searchableSelect = $ui->input()->field()->searchableSelect(
       "Email Text", $single_select);

    $form = $ui->input()->container()->form()->standard('#', [$searchableSelect]);

    if ($request->getMethod() == "POST") {
        $form = $form->withRequest($request);
        $result = $form->getData();
    } else {
        $result = "No result yet.";
    }

    return
        $renderer->render($form) . '</br><pre>' . print_r($result, true ) . '</pre>';
}
