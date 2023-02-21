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

namespace ILIAS\UI\Implementation\Component\Input\ViewControl;

use ILIAS\UI\Component\Input\ViewControl as VCInterface;
use ILIAS\UI\Implementation\Component\SignalGeneratorInterface;
use ILIAS\UI\Component\Signal;

class FieldSelection extends ViewControl implements VCInterface\FieldSelection
{
    protected Signal $internal_selection_signal;
    protected array $options;
    protected string $label;
    protected string $button_label;

    public function __construct(
        SignalGeneratorInterface $signal_generator,
        array $options,
        string $label,
        string $button_label
    ) {
        $this->internal_selection_signal = $signal_generator->create();
        $this->options = $options;
        $this->label = $label;
        $this->button_label = $button_label;
    }

    public function getDropdownLabel(): string
    {
        return $this->label;
    }

    public function getButtonLabel(): string
    {
        return $this->button_label;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function getInternalSignal(): Signal
    {
        return $this->internal_selection_signal;
    }

    public function withValue($value): self
    {
        $clone = clone $this;
        $clone->value = explode(',', $value);
        return $clone;
    }
    public function getValue()
    {
        return $this->value ?? [];
    }
}
