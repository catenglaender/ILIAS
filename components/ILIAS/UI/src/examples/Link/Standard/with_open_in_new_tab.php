<?php

declare(strict_types=1);

namespace ILIAS\UI\examples\Link\Standard;

/**
 * ---
 * description: >
 *   Example for rendering a standard link that opens to a new viewport.
 *
 * expected output: >
 *   ILIAS shows a link with the title "Goto ILIAS in new tab/window". Clicking the link opens the website www.ilias.de
 *   in a new browser window or tab.
 * ---
 */
function with_open_in_new_tab()
{
    global $DIC;
    $f = $DIC->ui()->factory();
    $renderer = $DIC->ui()->renderer();

    $link = $f->link()->standard("Goto ILIAS", "http://www.ilias.de")
                ->withOpenInNewViewport(true);
    return $renderer->render($link);
}
