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

namespace ILIAS\UI\Component\Question;

use ILIAS\UI\Component\Question\AnswerSlot;
use ILIAS\UI\Component\Question\QuestionPrompt;

interface Factory
{
    /**
     * ---
     * description:
     *   purpose: >
     *      This is the visual representation of a question with one or multiple answer options in an e-learning or
     *      survey context. The nature of the question (Single Choice, Checkbox,...) depends fully on the given
     *      Answer Slots.
     *      A Question can be rendered in either an editable or a locked mode. In editable mode, the participant of
     *      a test uses this component to submit their answer. Locked mode is intended for reviewing a participant's
     *      answer. In this mode only, the best possible answer (if one was provided by the question's author) may be
     *      shown in comparison to the answer entered by a test participant.
     *   composition: >
     *      The Question component consists out of
     *          - a title headline,
     *          - a question prompt with the posed question or media provided by the author of the question
     *          - and a form where a participant's answer can be given or is already given.
     *      The Question component may display additional information about the questions status or evaluation through
     *      glyphs (checkbox, x-mark, attention-sign), message boxes with hints or feedback, or colors (green for
     *      success, red for failure states).
     *      In editable mode: If given to a Sequence Navigator, the submit button will be part of the Sequence
     *      Navigator's Segment Bar. Otherwise, a form submit button will be rendered as part of the Question.
     *  effect: >
     *      In its default, editable mode, the question's form can be operated like any corresponding UI Field Input.
     *      Error messages may be given not only to indicate an invalid input, but an incorrect answer.
     *  rules:
     *      wording:
     *          1: >
     *              Question titles SHOULD NOT contain the question as it is not shown in all contexts. It is meant as
     *              an identifier.
     *          2: >
     *              Question prompts MUST contain the actual question.
     *          3: >
     *              Answer Slot labels must not contain the question put instructions or specifics about its input.
     * accessibility:
     *      1: >
     *          You MUST NOT use QuestionStatus to display anything not concerning the status flags you set, because
     *          invisible help texts may be inserted to guide screen readers. When you misuse a status message for
     *          giving general hints, the screen reader instruction might not match and confuse users.
     *
     *
     * ---
     * @param string $title
     * @param QuestionPrompt\QuestionPrompt $prompt
     * @param array<AnswerSlot\AnswerSlot> $answerSlots
     * @return Question
     */
    public function question(string $postUrl, string $title, QuestionPrompt\QuestionPrompt $prompt, array $answerSlots): Question;

    /**
     * ---
     * description:
     *   purpose: >
     *      This is the Question Prompt element shown as part of the Question. It holds the actual text or media the
     *      participant of a test has to react to.
     *   composition: >
     *      In its simplest form a prompt can just be a markdown text. More complex prompt objects may contain pictures
     *      or videos.
     *
     * ---
     * @return QuestionPrompt\Factory
     */
    public function questionPrompt(): QuestionPrompt\Factory;

    /**
     * ---
     * description:
     *   purpose: >
     *      This is a single input element or input group that participants can use to respond to a question.
     *   composition: >
     *      Answer Slots look like various Form Input Fields depending on what the posed Question requires.
     *
     * ---
     * @return AnswerSlot\Factory
     */
    public function answerSlot(): AnswerSlot\Factory;

    /**
     * ---
     * description:
     *   purpose: >
     *      This is an object with information about the Evaluation or WorklowStatus of a Question or an Answer Slot.
     *      It will apply conditional styling to the element it is given to.
     *   composition: >
     *      Applying a QuestionStatus to a Question or AnswerSlot may cause status glyphs to appear (e.g. checkmarks)
     *      and change the colors in the rendering (e.g. to indicate success or failure or that the answer has been
     *      finalized).
     *
     * ---
     * @return QuestionStatus\Factory
     */
    public function questionStatus(): QuestionStatus\Factory;
}
