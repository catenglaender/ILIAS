<?php

declare(strict_types=1);

namespace ILIAS\UI\examples\Input\Field\SearchableSelect;

/**
 * ---
 * description: >
 *   Example shows a searchable select input with a radio field component given to it. The radio field option labels
 *   include html code to simulate a picker for page editor content style.
 *
 * expected output: >
 *   ILIAS shows the rendered Component.
 * ---
 */

function select_contentstyles(): string
{
    global $DIC;
    $ui = $DIC->ui()->factory();
    $renderer = $DIC->ui()->renderer();
    $request = $DIC->http()->request();

    $template1 = <<<HTML
<div class="ilc_section_Card" style="min-height: auto;">Card</div>
HTML;

    $template2 = <<<HTML
<div class="ilc_section_Citation" style="min-height: auto;">Citation</div>
HTML;

    $template3 = <<<HTML
<div class="ilc_section_Example" style="min-height: auto;">Example</div>
HTML;

    $template4 = <<<HTML
<div class="ilc_section_Excursus" style="min-height: auto;">Excursus</div>
HTML;

    $content_style_css = <<<HTML
<style>
div.ilc_section_Card,
a.ilc_section_Card {
  min-height: 250px;
  position: relative;
  margin: 15px;
  padding-top: 15px;
  padding-right: 15px;
  padding-bottom: 15px;
  padding-left: 15px;
  box-shadow: 5px 5px 40px rgba(0, 0, 0, 0.2);
  border-radius: 15px;
  max-width: 400px;
}
div.ilc_section_Citation,
a.ilc_section_Citation {
  padding-right: 30px;
  padding-top: 35px;
  margin-bottom: 10px;
  margin-top: 40px;
  position: relative;
  border-width: 2px;
  border-color: #4C6586;
  border-style: solid;
  background-color: #FFFFFF;
  border-radius: 3px;
  position: relative !important;
  padding-left: 20px;
  padding-bottom: 15px;
}
div.ilc_section_Citation::before,
a.ilc_section_Citation::before {
  background-color: #eceff4;
  left: 15px;
  background-position: center center;
  border-width: 2px;
  border-color: #FFFFFF;
  border-style: solid;
  content: "";
  display: block;
  border-radius: 50px;
  background-image: url("assets/images/citation.svg");
  background-repeat: no-repeat;
  position: absolute;
  top: -32px;
  width: 60px;
  height: 60px;
}
    
div.ilc_section_Example,
a.ilc_section_Example {
  padding-right: 30px;
  padding-bottom: 15px;
  padding-left: 20px;
  background-position: left center;
  margin-bottom: 10px;
  margin-top: 40px;
  position: relative;
  border-width: 2px;
  border-color: #4C6586;
  border-style: solid;
  border-radius: 3px;
  position: relative !important;
  padding-top: 35px;
}
div.ilc_section_Example::before,
a.ilc_section_Example::before {
  background-color: #eceff4;
  background-position: center center;
  left: 15px;
  background-image: url("assets/images/example.svg");
  background-repeat: no-repeat;
  position: absolute;
  top: -32px;
  width: 60px;
  height: 60px;
  border-width: 2px;
  border-color: #FFFFFF;
  border-style: solid;
  right: 0px;
  content: "";
  display: block;
  border-radius: 50px;
}
div.ilc_section_Excursus,
a.ilc_section_Excursus {
  padding-right: 30px;
  margin-bottom: 10px;
  margin-top: 40px;
  border-style: solid;
  border-width: 2px;
  position: relative;
  padding-top: 35px;
  border-color: #4C6586;
  padding-left: 20px;
  border-radius: 3px;
  position: relative !important;
  padding-bottom: 15px;
}
div.ilc_section_Excursus::before,
a.ilc_section_Excursus::before {
  border-width: 2px;
  border-color: #FFFFFF;
  border-style: solid;
  background-color: #eceff4;
  background-position: center center;
  left: 15px;
  content: "";
  display: block;
  border-radius: 50px;
  background-image: url("assets/images/excursus.svg");
  background-repeat: no-repeat;
  position: absolute;
  top: -32px;
  width: 60px;
  height: 60px;
}
</style>
HTML;

    $options = array(
        "1" => $template1,
        "2" => $template2,
        "3" => $template3,
        "4" => $template4,
    );

    $single_select = $ui->input()->field()->radio("Content Style", "Edit and add more styles by using a custom content style.");


    foreach ($options as $value => $label) {
        $single_select = $single_select->withOption((string)$value, (string)$label);
    }

    $single_select = $single_select->withValue((string)"2");

    $searchableSelect = $ui->input()->field()->searchableSelect(
       "Section Style", $single_select);

    $form = $ui->input()->container()->form()->standard('#', [$searchableSelect]);

    if ($request->getMethod() == "POST") {
        $form = $form->withRequest($request);
        $result = $form->getData();
    } else {
        $result = "No result yet.";
    }

    return
        $renderer->render($form) . '</br><pre>' . print_r($result, true ) . '</pre>' . $content_style_css;
}
