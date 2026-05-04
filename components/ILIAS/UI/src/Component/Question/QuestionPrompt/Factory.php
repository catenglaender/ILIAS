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

namespace ILIAS\UI\Component\Question\QuestionPrompt;

interface Factory
{
    /**
     * ---
     * description:
     *   purpose: >
     *      The Question Markdown prompt shows the text of a question. Markdown markup will be rendered, so the text can
     *      have bold, italic, headline and list elements and everything else supported by the current
     *      Markdown Renderer.
     *   composition: >
     *      A text with simple formatting applied.
     *
     * ---
     * @param string $raw_markdown
     * @return Markdown
     */
    public function markdown(string $raw_markdown): Markdown;
}
