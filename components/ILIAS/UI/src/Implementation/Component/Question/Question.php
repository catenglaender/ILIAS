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

namespace ILIAS\UI\Implementation\Component\Question;

use ILIAS\UI\Component\Question as IntQuestion;
use ILIAS\UI\Component\Question\AnswerSlot\AnswerSlot as IntAnswerSlot;
use ILIAS\UI\Component\Question\QuestionPrompt\QuestionPrompt as IntQuestionPrompt;
use ILIAS\UI\Component\QuestionStatus\QuestionStatus;
use ILIAS\UI\Implementation\Component\Input as ImplInput;
use Psr\Http\Message\ServerRequestInterface;

class Question extends ImplInput\Container\Container implements IntQuestion\Question
{
    /**
     * @inheritDoc
     */
    protected function extractRequestData(ServerRequestInterface $request): ImplInput\InputData
    {
        return new ImplInput\PostDataFromServerRequest($request);
    }

    /**
     * @inheritDoc
     */
    public function withTitle(string $title): IntQuestion\Question
    {
        // TODO: Implement withTitle() method.
    }

    /**
     * @inheritDoc
     */
    public function getTitle(): IntQuestion\Question
    {
        // TODO: Implement getTitle() method.
    }

    /**
     * @inheritDoc
     */
    public function withName(string $name): IntQuestion\Question
    {
        // TODO: Implement withName() method.
    }

    /**
     * @inheritDoc
     */
    public function withQuestionPrompt(string|IntQuestionPrompt $prompt): IntQuestion\Question
    {
        // TODO: Implement withQuestionPrompt() method.
    }

    /**
     * @inheritDoc
     */
    public function withAnswerSlots(array $answerSlots): IntQuestion\Question
    {
        // TODO: Implement withAnswerSlots() method.
    }

    /**
     * @inheritDoc
     */
    public function withAdditionalAnswerSlot(IntAnswerSlot $answerSlot): IntQuestion\Question
    {
        // TODO: Implement withAdditionalAnswerSlot() method.
    }

    /**
     * @inheritDoc
     */
    public function setStatus(QuestionStatus $status): IntQuestion\Question
    {
        // TODO: Implement setStatus() method.
    }

    /**
     * @inheritDoc
     */
    public function withLockedMode(bool $lock = true, bool $showBestPossibleAnswers = false): IntQuestion\Question
    {
        // TODO: Implement withLockedMode() method.
    }

    public function getQuestionPrompt(): IntQuestionPrompt
    {
        // TODO
    }

    /**
     * @return array<AnswerSlot>
     */
    public function getAnswerSlots(): array
    {
        // TODO
    }

    /**
     * @return array{locked: bool, showBestPossibleAnswer: bool}
     */
    public function getLockedModeState(): array
    {
        // TODO
    }
}
