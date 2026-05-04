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

interface Checkbox extends AnswerSlot
{
    /**
     * Checkboxes can only be checked (true) or not checked (false).
     * @return bool
     */
    public function getValue(): bool;

    /**
     * In the use case of a quiz this is the value that will be evaluated as correct.
     * May be shown in a comparison view next to the user's input.
     * @return bool
     */
    public function withBestPossibleValue(): bool;
}
