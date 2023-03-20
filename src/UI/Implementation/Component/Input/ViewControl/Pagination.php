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

class Pagination extends ViewControl implements VCInterface\Pagination
{
    protected const DEFAULT_LIMITS = [5, 10, 25, 50, 100, 250, 500, \PHP_INT_MAX];
    protected Signal $internal_selection_signal;
    protected Data\Factory $data_factory;
    protected int $offset;
    protected int $limit;
    protected array $options;

    public function __construct(
        SignalGeneratorInterface $signal_generator,
        Data\Factory $data_factory,
        int $offset,
        int $limit
    ) {
        $this->internal_selection_signal = $signal_generator->create();
        $this->data_factory = $data_factory;
        $this->offset = $offset;
        $this->limit = $limit;
    }

    public function getRanges(): array
    {
        $ret = [];
        if ($this->limit + 1 > $this->offset) {
            return [$this->data_factory->range(0, $this->limit)];
        }

        foreach (range(0, $this->offset, $this->limit + 1) as $offset) {
            $ret[] = $this->data_factory->range($offset, $this->limit);
        }
        return $ret;
    }

    public function withLimitOptions(array $options): self
    {
        $clone = clone $this;
        $clone->options = $options;
        return $clone;
    }

    public function getLimitOptions(): array
    {
        return $this->options ?? self::DEFAULT_LIMITS;
    }

    public function getInternalSignal(): Signal
    {
        return $this->internal_selection_signal;
    }

    /**
     * @param string($limit:$offset) $value
     */
    public function withValue($value): self
    {
        $this->checkArg("value", $this->isClientSideValueOk($value), "Display value does not match input type.");
        list($offset, $limit) = explode(':', $value);
        $clone = clone $this;
        $clone->offset = (int)$offset;
        $clone->limit = $this->roundToClosestOption((int)$limit);
        return $clone;
    }

    protected function roundToClosestOption(int $limit): int
    {
        return array_reduce(
            $this->getLimitOptions(),
            fn ($a, $b) =>  abs($b - $limit) <= abs($a - $limit) ? $b : $a
        );
    }

    protected function isClientSideValueOk($value): bool
    {
        $v = explode(':', $value);
        return count(array_filter($v, fn ($v) =>is_numeric($v))) === 2;
    }

    public function getValue()
    {
        return $this->data_factory->range(
            $this->offset,
            $this->limit
        );
    }
}
