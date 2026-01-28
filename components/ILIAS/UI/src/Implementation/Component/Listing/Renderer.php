<?php

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

declare(strict_types=1);

namespace ILIAS\UI\Implementation\Component\Listing;

use ILIAS\UI\Implementation\Render\AbstractComponentRenderer;
use ILIAS\UI\Implementation\Render\Template;
use ILIAS\UI\Renderer as RendererInterface;
use ILIAS\UI\Component;

/**
 * Class Renderer
 * @package ILIAS\UI\Implementation\Component\Listing\Descriptive
 */
class Renderer extends AbstractComponentRenderer
{
    private const MAX_CHARS_IN_LINE = 260; // fits in 1 line on desktop

    /**
     * @inheritdocs
     */
    public function render(Component\Component $component, RendererInterface $default_renderer): string
    {
        if ($component instanceof Component\Listing\Descriptive) {
            return $this->render_descriptive($component, $default_renderer);
        }

        if ($component instanceof Component\Listing\Property) {
            return $this->renderProperty($component, $default_renderer);
        }

        if ($component instanceof Component\Listing\Ordered) {
            return $this->renderOrdered($component, $default_renderer);
        }

        if ($component instanceof Component\Listing\Unordered) {
            return $this->renderUnordered($component, $default_renderer);
        }

        if ($component instanceof Component\Listing\Inline) {
            return $this->renderInline($component, $default_renderer);
        }

        $this->cannotHandleComponent($component);
    }

    protected function render_descriptive(
        Component\Listing\Descriptive $component,
        RendererInterface $default_renderer
    ): string {
        $tpl = $this->getTemplate("tpl.descriptive.html", true, true);

        foreach ($component->getItems() as $key => $item) {
            if (is_string($item)) {
                $content = $item;
            } else {
                $content = $default_renderer->render($item);
            }

            if (trim($content) != "") {
                $tpl->setCurrentBlock("item");
                $tpl->setVariable("DESCRIPTION", $key);
                $tpl->setVariable("CONTENT", $content);
                $tpl->parseCurrentBlock();
            }
        }
        return $tpl->get();
    }

    protected function renderOrdered(Component\Listing\Ordered $component, RendererInterface $default_renderer): string
    {
        $tpl = $this->getTemplate("tpl.ordered.html", true, true);

        $tpl = $this->fillItems($tpl, $component, $default_renderer);

        return $tpl->get();
    }

    protected function renderUnordered(Component\Listing\Unordered $component, RendererInterface $default_renderer): string
    {
        $tpl = $this->getTemplate("tpl.unordered.html", true, true);

        $tpl = $this->fillItems($tpl, $component, $default_renderer);

        return $tpl->get();
    }

    protected function renderInline(Component\Listing\Inline $component, RendererInterface $default_renderer): string
    {
        $tpl = $this->getTemplate("tpl.inline.html", true, true);

        $tpl = $this->fillItems($tpl, $component, $default_renderer);

        return $tpl->get();
    }

    protected function fillItems(Template $tpl, Component\Listing\Listing $component, RendererInterface $default_renderer): Template
    {
        $items = $component->getItems();

        foreach ($items as $item) {
            $tpl->setCurrentBlock("item");
            (is_string($item)) ? $tpl->setVariable("ITEM", $item) : $tpl->setVariable("ITEM", $default_renderer->render($item));
            $tpl->parseCurrentBlock();
        }

        return $tpl;
    }

    protected function renderProperty(
        Component\Listing\Property $component,
        RendererInterface $default_renderer
    ): string {
        $tpl = $this->getTemplate("tpl.propertylisting.html", true, true);

        foreach ($component->getItems() as $property) {
            list($label, $value, $show_label) = $property;

            $tpl->setCurrentBlock("property");

            if ($show_label) {
                $tpl->setVariable(
                    'LABEL',
                    is_string($label) ? strip_tags($label) : $default_renderer->render($label)
                );
            }

            if (is_string($value) && mb_strlen($value, "UTF-8") >= self::MAX_CHARS_IN_LINE) {
                $show_more_toggle_id = $this->createId();
                $tpl->setVariable("ID_SHOW_MORE_TOGGLE", $show_more_toggle_id);
                $tpl->setVariable("MORE", $this->txt("show_more"));
                $tpl->setVariable("LESS", $this->txt("show_less"));
                $value = strip_tags($value);
            }
            if (!is_string($value)) {
                $value = $default_renderer->render($value);
            }
            $tpl->setVariable("VALUE", $value);

            $tpl->parseCurrentBlock();
        }
        return $tpl->get();
    }
}
