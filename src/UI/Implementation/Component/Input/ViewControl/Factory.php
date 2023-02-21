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
use ILIAS\Data;

/**
 * Factory for View Controls
 */
class Factory implements VCInterface\Factory
{
    protected SignalGeneratorInterface $signal_generator;

    public function __construct(
        SignalGeneratorInterface $signal_generator
    ) {
        $this->signal_generator = $signal_generator;
    }

    public function fieldSelection(
        array $options,
        string $label = VCInterface\FieldSelection::DEFAULT_DROPDOWN_LABEL,
        string $button_label = VCInterface\FieldSelection::DEFAULT_BUTTON_LABEL
    ): VCInterface\FieldSelection {
        return new FieldSelection($this->signal_generator, $options, $label, $button_label);
    }

    public function sortation(
        array $options,
        string $aspect = null,
        string $direction = null
    ): VCInterface\Sortation {
        return new Sortation(
            $this->signal_generator,
            new Data\Factory(),
            $options,
            $aspect,
            $direction
        );
    }

    public function pagination(
        int $offset,
        int $length
    ): VCInterface\Pagination {
        return new Pagination(
            $this->signal_generator,
            new Data\Factory(),
            $offset,
            $length
        );
    }
}
