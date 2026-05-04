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

namespace ILIAS\UI\Component\Question\QuestionStatus;

use ILIAS\UI\Component\QuestionStatus\Evaluation;
use ILIAS\UI\Component\QuestionStatus\QuestionStatus;
use ILIAS\UI\Component\QuestionStatus\WorkflowStatus;

interface Factory
{
    /**
     * ---
     * description:
     *   purpose: >
     *      Contains status information about an entire Question or one of its AnswerSlot elements.
     *
     *   composition: >
     *      When given to a Question or an AnswerSlot, it may cause some conditional styling to be applied.
     *
     * ---
     * @param array<Evaluation|WorkflowStatus> $status_enums
     * @param string $message
     * @return QuestionStatus
     */
    public function questionStatus(array $status_enums, string $message): QuestionStatus;
}
