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

namespace ILIAS\UI\Component\QuestionStatus;

interface QuestionStatus
{
    /**
     * Describes where the current element is currently located in the question workflow like NEVER_SEEN or
     * ANSWERED_BEFORE (see corresponding enum for full list)
     * @param WorkflowStatus $status
     * @return self
     */
    public function withWorkflowStatus(WorkflowStatus $status): self;

    /**
     * Set the Evaluation verdict like CORRECT or INCORRECT (see corresponding enum for full list)
     * @param Evaluation $evaluation
     * @return self
     */
    public function withEvaluationStatus(Evaluation $evaluation): self;

    /**
     * An evaluation message gives a user further written feedback about the question's evaluation.
     * Depending on the exact QuestionStatus given this message may be styled differently (e.g. when the status is
     * CORRECT, the design is green suggesting a success; when INCORRECT, it's red suggesting a failure - accessibility
     * features may add descriptors for screen readers)
     * @param string|null $message
     * @return self
     */
    public function withEvaluationMessage(string|null $message): self;
}
