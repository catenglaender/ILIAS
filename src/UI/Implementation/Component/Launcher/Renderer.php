<?php

declare(strict_types=1);

/**
 * This file is part of ILIAS, a powerful learning management system
 * published by ILIAS open source e-Learning e.V.
 *
 * ILIAS is licensed with the GPL-3.0,
 * see https://www.gnu.org/licenses/gpl-3.0.en.html
 * You should have received a copy of said license along with the
 * source code, too.
 *
 * If this is not the case or you just want to try ILIAS, you'll find
 * us at:
 * https://www.ilias.de
 * https://github.com/ILIAS-eLearning
 *
 *********************************************************************/

namespace ILIAS\UI\Implementation\Component\Launcher;

use ILIAS\UI\Implementation\Render\AbstractComponentRenderer;
use ILIAS\UI\Renderer as RendererInterface;
use ILIAS\UI\Component;

//use ILIAS\UI\Implementation\Render\ResourceRegistry;
//use ILIAS\UI\Implementation\Render\Template;

class Renderer extends AbstractComponentRenderer
{
    public function render(Component\Component $component, RendererInterface $default_renderer): string
    {
        $this->checkComponent($component);
        if ($component instanceof Inline) {
            return $this->renderInline($component, $default_renderer);
        }
    }

    public function renderInline(Component\Component $component, RendererInterface $default_renderer): string
    {
        if ($result = $component->getResult()) {
            $f = $component->getEvaluation();
            $f($result, $component);
        }

        $tpl = $this->getTemplate("tpl.launcher_inline.html", true, true);
        $ui_factory = $this->getUIFactory();

        $target = $component->getTarget()->getURL();
        $label = $component->getButtonLabel();
        $launchable = $component->isLaunchable();

        $start_button = $ui_factory->button()
            ->primary($label, (string) $target);

        if ($form = $component->getForm()) {
            $modal_contents = ($instruction = $component->getInstruction()) ? [$instruction] : [];
            $modal_contents[] = $form;
            $modal = $ui_factory->modal()->roundtrip($label, $modal_contents);
            $tpl->setVariable("FORM", $default_renderer->render($modal));
            $start_button = $start_button->withOnClick($modal->getShowSignal());
        }

        if (!$launchable) {
            $start_button =$start_button->withUnavailableAction();
        }

        if ($status_icon = $component->getStatusIcon()) {
            $tpl->setVariable("STATUS_ICON", $default_renderer->render($status_icon));
        }

        if ($status_message = $component->getStatusMessage()) {
            $tpl->setVariable("STATUS_MESSAGE", $default_renderer->render($status_message));
        }
        $tpl->setVariable("DESCRIPTION", $component->getDescription());
        $tpl->setVariable("BUTTON", $default_renderer->render($start_button));

        return $tpl->get();
    }

    protected function getComponentInterfaceName(): array
    {
        return [
            Inline::class
        ];
    }
}
