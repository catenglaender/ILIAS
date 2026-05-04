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

interface Factory
{
    /**
     * ---
     * description:
     *   purpose: >
     *      In this Answer Slot the user has to pick exactly one option from at least two. Use this answer slot to build
     *      true/false or single choice style questions.
     *   composition: >
     *      It looks like the Input Field Radio.
     *  effect: >
     *      In editable mode, this Answer Slot can be operated like any Input Field Radio.
     *      Error messages may be given not to indicate an invalid input, but an incorrect answer.
     *
     * ---
     * @param string $label
     * @param array<int, array{label: string, value: string}> $bestPossibleAnswer
     * @return SingleChoice
     */
    public function singleChoice(string $label, array $bestPossibleAnswer): SingleChoice;

    /**
     * ---
     * description:
     *   purpose: >
     *      In this Answer Slot the user can check one checkbox (from potentially many more in other Answer Slots).
     *      Use this answer slot to build checkbox and multiple choice style questions.
     *   composition: >
     *      It looks like one line of a Multi Select Input.
     *  effect: >
     *      In editable mode, this Answer Slot can be operated like any Input Field Multi-Select.
     *      Error messages may be given not to indicate an invalid input, but an incorrect answer.
     *
     * ---
     * @param string $label
     * @param bool $bestPossibleAnswer
     * @return Checkbox
     */
    public function checkbox(string $label, bool $bestPossibleAnswer): Checkbox;

    /**
     * ---
     * description:
     *   purpose: >
     *      In this Answer Slot the user must enter a numeric values.
     *      Use this answer slot to build questions asking for a number like the result of a calculation.
     *   composition: >
     *      It looks like the Input Field Numeric.
     *  effect: >
     *      In editable mode, this Answer Slot can be operated like any Input Field Numeric.
     *      Error messages may be given not to indicate an invalid input, but an incorrect answer.
     *
     * ---
     * @param string $label
     * @param int $bestPossibleAnswer
     * @return Numeric
     */
    public function numeric(string $label, int $bestPossibleAnswer): Numeric;
}
