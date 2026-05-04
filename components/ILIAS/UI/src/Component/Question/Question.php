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

use ILIAS\UI\Component\Input\Container\Container;
use ILIAS\UI\Component\Question\AnswerSlot\AnswerSlot;
use ILIAS\UI\Component\Question\QuestionPrompt\QuestionPrompt;
use ILIAS\UI\Component\QuestionStatus\QuestionStatus;

interface Question extends Container
{
    /**
     * The full title commonly displayed to clearly identify the question (like "Mendel's Observations: Colors
     * of the Pea Flower"). This SHOULD NOT be the question itself as the title is not shown by the default Renderer.
     * It may be shown in some lists and tables assembled from Question objects.
     * @param string $title
     * @return self
     */
    public function withTitle(string $title): self;

    /**
     * The default Question's Renderer does not render the title. Give it to the surrounding (like a Panel) instead.
     * @param string $title
     * @return self
     */
    public function getTitle(): self;

    /**
     * A shorthand for identifying or organizing the question (like "Biology 101 / Evolution / Genetic of Peas / 2").
     * This is also not shown by the default Question Renderer, but may be shown in some lists and tables.
     * @param string $name
     * @return self
     */
    public function withName(string $name): self;

    /**
     * The area which presents the question a user is supposed to respond to below.
     * The most simple form is just a text posing a question.
     * @param string|QuestionPrompt $prompt
     * @return self
     */
    public function withQuestionPrompt(string|QuestionPrompt $prompt): self;

    /**
     * Answer Slots are the elements a user interacts with when responding to a question.
     * Those are similar to form inputs with extended functionality to provide feedback and hints.
     * @param array<AnswerSlot> $answerSlots
     */
    public function withAnswerSlots(array $answerSlots): self;

    /**
     * Allows to append another Answer Slot. Could be used to add repeating final options like "keep private" or
     * "none of the above" below an array of options.
     * @param AnswerSlot $answerSlot
     * @return self
     */
    public function withAdditionalAnswerSlot(AnswerSlot $answerSlot): self;

    /**
     * To provide a QuestionStatus containing information about the Evaluation, WorkflowStatus and an EvaluationMessage.
     * Any information provided here may change heavily how the Question is presented (e.g. a CORRECT evaluation may
     * add checkmark glyphs and use green colors to indicate success).
     * The Question UI Component will never automatically make assumptions about the evaluation of the Answer Slots.
     * Neither Errors nor QuestionStatus applied to Answer Slots will bubble up. You must provide them explicitly.
     * @param QuestionStatus $status
     * @return self
     */
    public function setStatus(QuestionStatus $status): self;

    /**
     * This flag disables all inputs within Answer Slots, so they are read-only. This is meant to render evaluation and
     * print views. You can also set a flag to show the best possible answer next to the input provided by a user.
     * In this state, the question MUST NOT be submittable.
     * You SHOULD only toggle this on if you have reason to believe that Answer Slots have peen provided both a
     * value from past user input and the best possible answer.
     * @param bool $lock
     * @param bool $showBestPossibleAnswers
     * @return self
     */
    public function withLockedMode(bool $lock = true, bool $showBestPossibleAnswers = false): self;
}
