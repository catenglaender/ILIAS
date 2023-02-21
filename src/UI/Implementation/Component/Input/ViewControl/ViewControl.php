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
use ILIAS\UI\Implementation\Component\ComponentHelper;
use ILIAS\UI\Implementation\Component\Triggerer;
use ILIAS\UI\Implementation\Component\JavaScriptBindable;
use ILIAS\Refinery\Transformation;
use ILIAS\UI\Component\Signal;
use ILIAS\UI\Implementation\Component\Input\NameSource;

abstract class ViewControl implements VCInterface\ViewControl
{
    use ComponentHelper;
    use JavaScriptBindable;
    use Triggerer;

    protected Signal $change_signal;
    protected $value;
    protected ?string $name = null;

    public function withOnChange(Signal $change_signal): self
    {
        $clone = clone $this;
        $clone->change_signal = $change_signal;
        return $clone;
    }

    public function getOnChangeSignal(): ?Signal
    {
        return $this->change_signal ?? null;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function withValue($value): self
    {
        $clone = clone $this;
        $clone->value = $value;
        return $clone;
    }

    public function withNameFrom(NameSource $source)
    {
        $clone = clone $this;
        $clone->name = $source->getNewName();
        return $clone;
    }

    public function getName(): ?string
    {
        return $this->name;
    }


    public function withAdditionalTransformation(Transformation $trafo)
    {
    }
}
