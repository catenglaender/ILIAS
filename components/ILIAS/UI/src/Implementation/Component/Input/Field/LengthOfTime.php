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

namespace ILIAS\UI\Implementation\Component\Input\Field;

use ILIAS\UI\Component as C;
use ILIAS\Data\Factory as DataFactory;
use ILIAS\Refinery as Refinery;
use ILIAS\Refinery\Constraint;
use ILIAS\UI\Component\Input\Field\LengthOfTimeFieldPatterns;
use ILIAS\UI\Implementation\Component\ComponentHelper;
use ILIAS\UI\Implementation\Component\Input\FormInputNameSource;
use ILIAS\UI\Implementation\Component\Input\Input;
use ILIAS\UI\Implementation\Component\Input\InputData;
use ILIAS\UI\Implementation\Component\Input\NameSource;
use ILIAS\UI\Implementation\Component\JavaScriptBindable;
use DateTimeImmutable;
use DateInterval;
use Closure;
use ILIAS\Language\Language;
use InvalidArgumentException;
use Twig\Error\Error;

use function PHPUnit\Framework\isInstanceOf;

/**
 * This implements the duration input group.
 */
class LengthOfTime extends Group implements C\Input\Field\LengthOfTime
{
    protected Factory $field_factory;
    protected LengthOfTimeFieldPatterns $field_pattern;
    protected Language $lng;
    protected NameSource $name_source;

    public function __construct(
        DataFactory $data_factory,
        Refinery\Factory $refinery,
        Language $lng,
        Factory $field_factory,
        string $label,
        ?string $byline,
        LengthOfTimeFieldPatterns $field_pattern,
    ) {
        $this->field_factory = $field_factory;
        $this->field_pattern = $field_pattern;
        $this->lng = $lng;
        $this->name_source = new FormInputNameSource();
        $inputs = [];

        parent::__construct($data_factory, $refinery, $lng, $inputs, $label, $byline);
        $this->addTransformation();
        $this->addValidation();
        $this->setInputs($this->buildInputs());
    }

    private function buildInputs(): array
    {
        // TODO: give children a constraint that they cannot be "" or fractions
        $numeric = $this->field_factory->numeric("placeholder", null);
        return match ($this->field_pattern) {
            LengthOfTimeFieldPatterns::minutesSeconds => [
                $this->field_factory->numeric($this->lng->txt('minutes'), null)
                    ->withDedicatedName('minutes'),
                $this->field_factory->numeric($this->lng->txt('seconds'), null)
                    ->withDedicatedName('seconds')
            ],
            LengthOfTimeFieldPatterns::hoursMinutes => [
                $numeric->withLabel($this->lng->txt('hours'))
                    ->withDedicatedName('hours'),
                $numeric->withLabel($this->lng->txt('minutes'))
                    ->withDedicatedName('minutes')
            ],
            LengthOfTimeFieldPatterns::hoursMinutesSeconds => [
                $this->field_factory->numeric($this->lng->txt('hours'), null)
                    ->withDedicatedName('hours'),
                $this->field_factory->numeric($this->lng->txt('minutes'), null)
                    ->withDedicatedName('minutes'),
                $this->field_factory->numeric($this->lng->txt('seconds'), null)
                    ->withDedicatedName('seconds'),
            ],
            LengthOfTimeFieldPatterns::daysHoursMinutes => [
                $this->field_factory->numeric($this->lng->txt('days'), null)
                    ->withDedicatedName('days'),
                $this->field_factory->numeric($this->lng->txt('hours'), null)
                    ->withDedicatedName('hours'),
                $this->field_factory->numeric($this->lng->txt('minutes'), null)
                    ->withDedicatedName('minutes'),
            ],
            default => throw new InvalidArgumentException(
                "Unknown field pattern '{$this->field_pattern}'"
            ),
        };
    }

    public function dateIntervalToArray($date_interval): array
    {
        return match ($this->field_pattern) {
            LengthOfTimeFieldPatterns::minutesSeconds => [ $date_interval->i, $date_interval->s ],
            LengthOfTimeFieldPatterns::hoursMinutes => [ $date_interval->h, $date_interval->i ],
            LengthOfTimeFieldPatterns::hoursMinutesSeconds => [ $date_interval->h, $date_interval->i, $date_interval->s ],
            LengthOfTimeFieldPatterns::daysHoursMinutes => [ $date_interval->d, $date_interval->h, $date_interval->m ],
        };
    }

    public function arrayToDateInterval($array): DateInterval
    {
        return match ($this->field_pattern) {
            LengthOfTimeFieldPatterns::minutesSeconds => DateInterval::createFromDateString(
                $array[0] ?? 0 . " minutes " . $array[1] . " seconds"
            ),
            LengthOfTimeFieldPatterns::hoursMinutes => DateInterval::createFromDateString(
                $array[0] . " hours " . $array[1] . " minutes"
            ),
            LengthOfTimeFieldPatterns::hoursMinutesSeconds => DateInterval::createFromDateString(
                $array[0] . " hours " . $array[1] . " minutes " . $array[2] . " seconds"
            ),
            LengthOfTimeFieldPatterns::daysHoursMinutes => DateInterval::createFromDateString(
                $array[0] . " days " . $array[1] . " hours " . $array[2] . " minutes"
            )
        };
    }

    public function withValue($value): self
    {
        $this->checkArg("value", $this->isClientSideValueOk($value), "Display value does not match input type.");
        $clone = clone $this;
        $value = $this->handleDateIntervalValueOverflows($value);
        $clone->value = $value;
        $input_values = $this->dateIntervalToArray($value);
        foreach ($this->getInputs() as $k => $i) {
            $clone->inputs[$k] = $i->withValue($input_values[$k]);
        }
        return $clone;
    }

    public function withInput(InputData $input): self
    {
        if (empty($this->getInputs())) {
            return $this;
        }

        // test if any child input throws an error
        foreach ($this->getInputs() as $key => $in) {
            $inputs[$key] = $in->withInput($input);
            if ($inputs[$key]->getContent()->isError()) {
                // todo handle children error
            }
        }

        $clone = clone $this;

        // overall content value
        $data_keys = array_map(fn($child_input) => $child_input->getName(), $clone->getInputs());
        $request_values = array_map(fn($data_key) => $input->getOr($data_key, 0), $data_keys);
        $request_values_as_date_time = $this->arrayToDateInterval($request_values);
        $clone->content = $clone->applyOperationsTo($request_values_as_date_time);

        if ($clone->content->isError()) {
            $clone->setError("" . $clone->content->error());
        }

        // passing values to inputs
        $clone = $clone->withValue($request_values_as_date_time);

        return $clone;
    }

    public function getValue()
    {
        return $this->value;
    }

    protected function handleOverflowingTimeValues(int $valueLowerField, int $valueHigherField, int $stepLowerToHigher = 60): array
    {
        $normalizedHigherField = $valueHigherField;
        $normalizedHigherField += intval($valueLowerField / $stepLowerToHigher);
        $normalizedLowerField = $valueLowerField % $stepLowerToHigher;
        return [$normalizedLowerField, $normalizedHigherField];
    }
    protected function handleMultipleOverflowingTimeValues(array $valuesOrderOfAscendingUnits, array $overflow_steps): array
    {
        if (count($valuesOrderOfAscendingUnits) !== count($overflow_steps) + 1) {
            throw new InvalidArgumentException(
                "To convert overflowing time values provide n values and n-1 step sizes between them"
            );
        }
        $num_of_operations = count($overflow_steps);
        for ($current_step_index = 0; $current_step_index < $num_of_operations; $current_step_index++) {
            $normalizedValues = $this->handleOverflowingTimeValues(
                $valuesOrderOfAscendingUnits[$current_step_index],
                $valuesOrderOfAscendingUnits[$current_step_index + 1],
                $overflow_steps[$current_step_index],
            );
            $valuesOrderOfAscendingUnits[$current_step_index] = $normalizedValues[$current_step_index];
            $valuesOrderOfAscendingUnits[$current_step_index + 1] = $normalizedValues[$current_step_index + 1];
        }
        return $valuesOrderOfAscendingUnits;
    }

    protected function getConstraintForRequirement(): ?Constraint
    {
        if ($this->requirement_constraint !== null) {
            return $this->requirement_constraint;
        }

        return null;
    }

    protected function addValidation(): void
    {
        $txt_id = 'length_of_time_data_pattern_mismatch';
        $error = fn(callable $txt, $value) => $txt($txt_id, $value);

        $is_ok = function ($value) {
            return true;
        };

        $array_check = $this->refinery->custom()->constraint(
            $is_ok,
            $error
        );
        $this->setAdditionalTransformation($array_check);
    }

    protected function handleDateIntervalValueOverflows($v): DateInterval
    {
        $array = $this->dateIntervalToArray($v);

        $result = match ($this->field_pattern) {
            LengthOfTimeFieldPatterns::hoursMinutes,
            LengthOfTimeFieldPatterns::minutesSeconds => array_reverse(
                $this->handleOverflowingTimeValues($array[1], $array[0])
            ),
            LengthOfTimeFieldPatterns::hoursMinutesSeconds => array_reverse(
                $this->handleMultipleOverflowingTimeValues([$array[2], $array[1], $array[0]], [60, 60])
            ),
            LengthOfTimeFieldPatterns::daysHoursMinutes => array_reverse(
                $this->handleMultipleOverflowingTimeValues([$array[2], $array[1], $array[0]], [60, 24])
            )
        };

        return $this->arrayToDateInterval($result);
    }

    protected function addTransformation(): void
    {
        $date_interval = $this->refinery->custom()->transformation(function ($v): ?DateInterval {
            return $this->handleDateIntervalValueOverflows($v);
        });
        $this->setAdditionalTransformation($date_interval);
    }

    /**
     * @inheritdoc
     */
    protected function isClientSideValueOk($value): bool
    {
        return ($value instanceof DateInterval);
    }

    public function isComplex(): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function withFieldPattern(LengthOfTimeFieldPatterns $field_pattern): C\Input\Field\LengthOfTime
    {
        $clone = clone $this;
        $clone->field_pattern = $field_pattern;
        $clone->setInputs($clone->buildInputs());
        return $clone;
    }

    /**
     * @inheritDoc
     */
    public function getUpdateOnLoadCode(): Closure
    {
        return fn($id) => "$('#$id').on('input', function(event) {
				il.UI.input.onFieldUpdate(event, '$id', $('#$id').val());
			});
			il.UI.input.onFieldUpdate(event, '$id', $('#$id').val());";
    }
}
