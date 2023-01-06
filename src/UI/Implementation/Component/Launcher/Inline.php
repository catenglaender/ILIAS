<?php

declare(strict_types=1);

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

namespace ILIAS\UI\Implementation\Component\Launcher;

use ILIAS\UI\Implementation\Component\ComponentHelper;
use ILIAS\Data\Link;
use ILIAS\UI\Component as C;
use ILIAS\UI\Component\Input\Field\Group;
use ILIAS\UI\Component\Legacy\Legacy;
use ILIAS\UI\Implementation\Component\Input\Container\Form;
use Psr\Http\Message\ServerRequestInterface;

class Inline implements C\Launcher\Inline
{
    use ComponentHelper;

    protected Form\Factory $form_factory;
    protected Link $target;
    protected string $description = '';
    protected ?string $error_note = null;
    /**
     * @var null | Icon | ProgressMeeter
     */
    protected $status = null;
    protected ?string $label = null;
    protected bool $launchable = true;
    protected ?Form\Form $form = null;
    protected \Closure $evaluation;
    protected ?Legacy $instruction = null;
    protected ?ServerRequestInterface $request = null;

    public function __construct(
        Form\Factory $form_factory,
        Link $target
    ) {
        $this->form_factory = $form_factory;
        $this->target = $target;
        $this->evaluation = fn () => true;
    }

    public function getTarget(): Link
    {
        return $this->target;
    }

    public function withDescription(string $description): self
    {
        $clone = clone $this;
        $clone->description = $description;
        return $clone;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function withInputs(Group $fields, \Closure $evaluation, Legacy $instruction = null): self
    {
        $clone = clone $this;
        $clone->form = $this->form_factory->standard(
            (string)$this->getTarget()->getURL(), //should the launcher submit to itself?
            [$fields]
        );
        $clone->evaluation = $evaluation;
        $clone->instruction = $instruction;
        return $clone;
    }

    public function getForm(): ?Form\Form
    {
        return $this->form;
    }
    public function getEvaluation(): \Closure
    {
        return $this->evaluation;
    }

    public function getInstruction(): ?Legacy
    {
        return $this->instruction;
    }

    /**
     * @param Icon | ProgressMeter $status
     */
    public function withStatus(C\Component $status): self
    {
        $check =  array($status);
        $this->checkArgListElements("status", $check, self::ALLOWED_STATUS_COMPONENTS);

        $clone = clone $this;
        $clone->status = $status;
        return $clone;
    }
    public function getStatus(): ?C\Component
    {
        return $this->status;
    }

    public function withButtonLabel(string $label, bool $launchable = true): self
    {
        $clone = clone $this;
        $clone->label = $label;
        $clone->launchable = $launchable;
        return $clone;
    }

    public function getButtonLable(): ?string
    {
        return $this->label;
    }

    public function isLaunchable(): bool
    {
        return $this->launchable;
    }

    public function withRequest(ServerRequestInterface $request)
    {
        $clone = clone $this;
        $clone->request = $request;
        return $clone;
    }

    public function getData()
    {
        if ($this->request && $this->request->getMethod() == "POST") {
            $form = $this->form->withRequest($this->request);
            return $form->getData();
        }
        return null;
    }

    public function withErrorNote(string $error_note): self
    {
        $clone = clone $this;
        $clone->error_note = $error_note;
        return $clone;
    }

    public function getErrorNote(): ?string
    {
        return $this->error_note;
    }
}
