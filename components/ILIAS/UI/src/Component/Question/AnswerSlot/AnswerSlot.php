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

namespace ILIAS\UI\Component\Question\AnswerSlot;

use ILIAS\UI\Component\Question\Evaluation;
use ILIAS\UI\Component\Input\Input;
use ILIAS\UI\Component\Question\WorkflowStatus;
use ILIAS\UI\Component\QuestionStatus\QuestionStatus;

interface AnswerSlot extends Input
{
    /**
     * Set a descriptive label for the Answer Slot. This SHOULD NOT be the question.
     * @param string $label
     * @return self
     */
    public function withLabel(string $label): self;

    /**
     * If you want to mark the Answer Slot e.g. as CORRECT (from the Evaluation enum) and/or
     * NEVER_SEEN (from the WorkflowStatus enum) you must set this explicitly using a QuestionStatus object.
     * This object MAY contain a status message as well. It applies conditional styling to the AnswerSlot.
     * This component does not track or evaluate questions in any way automatically. Even if value and bestPossibleValue
     * are equal, you still need to set this status to mark the Answer Slot as correct (or anything else).
     * @param QuestionStatus|null $status
     * @return self
     */
    public function setStatus(?QuestionStatus $status): self;

    /**
     * A hint message gives a user some help about the subject of the question (e.g. "Think in terms of the climate, not
     * the weather.")
     * @param string|null $text
     * @return self
     */
    public function withHint(?string $text): self;

    /**
     * The byline can give instructions to the user about the specific Answer Slot input e.g. ("This input is case-
     * sensitive.")
     * @param string|null $text
     * @return self
     */
    public function withInstruction(?string $text): self;
}
