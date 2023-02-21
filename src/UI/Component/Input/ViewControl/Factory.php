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

namespace ILIAS\UI\Component\Input\ViewControl;

/**
 * This describes the factory for (view-)controls.
 */
interface Factory
{
    /**
     * ---
     * description:
     *   purpose: >
     *      Field Selection is used to limit a visualization of data to a choice of aspects,
     *      e.g. in picking specific columns of a table or fields of a diagram.
     *   composition: >
     *      A Field Selection uses a Multiselect Input wrapped in a dropdown.
     *      A Standard Button is used to submit the user's choice.
     *   effect: >
     *      When operating the dropdown, the Multiselect is shown.
     *      The dropdown is being closed upon submission or by clicking outside of it.
     * ---
     * @param array<string,string> $options
     * @param string $label
     * @return \ILIAS\UI\Component\Input\ViewControl\FieldSelection
     */
    public function fieldSelection(
        array $options,
        string $label = FieldSelection::DEFAULT_DROPDOWN_LABEL,
        string $button_label = FieldSelection::DEFAULT_BUTTON_LABEL
    ): FieldSelection;

    /**
     * ---
     * description:
     *   purpose: >
     *      Sortation is used XXX
     *   composition: >
     *      XXX
     *   effect: >
     *      XXX
     * ---
     * @param array<string,string> $options
     * @param string $label
     * @return \ILIAS\UI\Component\Input\ViewControl\Sortation
     */
    public function sortation(
        array $options,
        string $aspect = null,
        string $direction = null
    ): Sortation;

    /**
     * ---
     * description:
     *   purpose: >
     *      Sortation is used XXX
     *   composition: >
     *      XXX
     *   effect: >
     *      XXX
     * ---
     * @param array<string,string> $options
     * @param string $label
     * @return \ILIAS\UI\Component\Input\ViewControl\Pagination
     */
    public function pagination(
        int $offset,
        int $length
    ): Pagination;
}
