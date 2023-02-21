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
use ILIAS\Data;

class Sortation extends ViewControl implements VCInterface\Sortation
{
    protected Signal $internal_selection_signal;
    protected Data\Factory $data_factory;
    protected array $options;
    protected string $aspect;
    protected string $direction;

    public function __construct(
        SignalGeneratorInterface $signal_generator,
        Data\Factory $data_factory,
        array $options,
        ?string $aspect,
        ?string $direction
    ) {
        $this->internal_selection_signal = $signal_generator->create();
        $this->data_factory = $data_factory;
        $this->options = $options;
        if (is_null($aspect) || is_null($direction)) {
            list($aspect, $direction) = explode(':', current(array_keys($options)));
        }
        $this->aspect = $aspect;
        $this->direction = $direction;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function getInternalSignal(): Signal
    {
        return $this->internal_selection_signal;
    }

    /**
     * @param string($aspect, $direction) $value
     */
    public function withValue($value): self
    {
        list($aspect, $direction) = explode(':', $value);
        $clone = clone $this;
        $clone->aspect = $aspect;
        $clone->direction = $direction;
        return $clone;
    }

    public function getValue()
    {
        return $this->data_factory->order(
            $this->aspect,
            $this->direction
        );
    }
}
