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

/**
 * Enum helper for valid status states and translated labels
 */
enum WorkflowStatus: string
{
    case NEVER_SEEN = "never seen before";
    case SEEN_BUT_NEVER_ANSWERED = "seen before but never answered";
    case ANSWERED_BEFORE = "answered before";
    case ANSWER_MARKED_FINAL = "answered marked final";
    case EVALUATED = "evaluated";
    case EVALUATION_MARKED_FINAL = "evaluation marked final";
}
