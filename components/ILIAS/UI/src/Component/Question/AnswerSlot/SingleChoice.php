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

interface SingleChoice extends AnswerSlot
{
    /**
     * Includes each option of the Radio group with a label and the provided value.
     * @return array<array{label: string, value: string}>
     */
    public function getValue(): array;

    /**
     * In the use case of a quiz this is the value that will be evaluated as correct.
     * May be shown in a comparison view next to the user's input.
     * @return array<array{label: string, value: string}>
     */
    public function withBestPossibleValue(): array;
}
