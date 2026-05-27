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
use ILIAS\UI\Component\Input\Field\Numeric;
use ILIAS\UI\Component\Input\Input;
use ILIAS\UI\Implementation\Component\Input\InputData;
use DateInterval;
use Closure;
use ILIAS\Language\Language;
use InvalidArgumentException;

use function PHPUnit\Framework\isInstanceOf;

/**
 * This implements the LengthOfTime input group.
 */
class LengthOfTime extends Group implements C\Input\Field\LengthOfTime
{
    protected Factory $field_factory;
    protected LengthOfTimeFieldPatterns $field_pattern;
    protected Language $lng;
    public bool $isUsingRecommendedOverflow;

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
        $this->lng = $lng;
        $this->field_pattern = $field_pattern;
        $this->isUsingRecommendedOverflow = false;

        $inputs = []; // cannot build real inputs yet because $lng & $refinery aren't ready
        parent::__construct($data_factory, $refinery, $lng, $inputs, $label, $byline);

        $this->setInputs($this->buildInputs());

        $this->addBaseTransformation(); // trafo to DateInterval is base for all subsequent trafos
    }

    /**
     * Builds the children inputs needed for the current field pattern
     * @return array<int, Numeric>
     */
    private function buildInputs(): array
    {
        // to not throw errors for empty strings, just turn them to 0
        $trafo_null = $this->refinery->custom()->transformation(
            fn($value) => $value ?? 0
        );

        $numeric = $this->field_factory->numeric("placeholder", null)
            ->withAdditionalTransformation($trafo_null);
        return match ($this->field_pattern) {
            LengthOfTimeFieldPatterns::minutesSeconds => [
                $numeric->withLabel($this->lng->txt('minutes'))
                    ->withDedicatedName('minutes'),
                $numeric->withLabel($this->lng->txt('seconds'))
                    ->withDedicatedName('seconds'),
            ],
            LengthOfTimeFieldPatterns::hoursMinutes => [
                $numeric->withLabel($this->lng->txt('hours'))
                    ->withDedicatedName('hours'),
                $numeric->withLabel($this->lng->txt('minutes'))
                    ->withDedicatedName('minutes'),
            ],
            LengthOfTimeFieldPatterns::hoursMinutesSeconds => [
                $numeric->withLabel($this->lng->txt('hours'))
                    ->withDedicatedName('hours'),
                $numeric->withLabel($this->lng->txt('minutes'))
                    ->withDedicatedName('minutes'),
                $numeric->withLabel($this->lng->txt('seconds'))
                    ->withDedicatedName('seconds'),
            ],
            LengthOfTimeFieldPatterns::daysHoursMinutes => [
                $numeric->withLabel($this->lng->txt('days'))
                    ->withDedicatedName('days'),
                $numeric->withLabel($this->lng->txt('hours'))
                    ->withDedicatedName('hours'),
                $numeric->withLabel($this->lng->txt('minutes'))
                    ->withDedicatedName('minutes'),
            ],
        };
    }

    public function withRecommendedTimeOverflow(): self
    {
        $clone = clone $this;
        $clone->addOverflowTransformation();
        $clone->isUsingRecommendedOverflow = true;
        if ($clone->getValue()) {
            $clone = $clone->withValue($this->getValue());
        }
        return $clone;
    }

    public function isUsingRecommendedTimeOverflow(): bool
    {
        return $this->isUsingRecommendedOverflow;
    }

    /**
     * @param mixed $value may be DateInterval or array matching field_pattern
     * @return $this
     */
    public function withValue($value): self
    {
        if (is_array($value) && !($this->isClientSideValueOk($value))) {
            throw new InvalidArgumentException(
                "Too many or too few elements in array. It doesn't match the field_pattern."
            );
        } elseif (is_array($value)) {
            $value = $this->arrayToDateInterval($value, $this->field_pattern);
        } elseif (!$value instanceof DateInterval) {
            throw new InvalidArgumentException(
                "Value is neither an array nor DateInterval."
            );
        }
        // only DateIntervals after this point

        if (!$this->isDateIntervalFieldPatternMatch($value)) {
            throw new InvalidArgumentException(
                "DateInterval values MUST match field_pattern e.g. if it's hoursMinutes,
                the DateInterval MUST not have y, d, s values greater than 0."
            );
        }

        $clone = clone $this;

        // if trafos still return a DateInterval, let's use it, because it probably contains a desired time overflow
        $value_from_trafos = $this->applyOperationsTo($value)->value();
        $clone->value = $value_from_trafos instanceof DateInterval ? $value_from_trafos : $value;

        $clone->value = $this->applyOperationsTo($value)->value(); // applies time overflows if given as trafos

        $inputs = $clone->getInputs();
        $filled_inputs = $this->fillInputsFromDateInterval($inputs, $clone->value);
        $clone->setInputs($filled_inputs);

        return $clone;
    }

    /**
     * Takes the children inputs and fills them with values from a DateInterval.
     * You MUST NOT use this function unless the Date Interval matches the field_pattern.
     * Units that have no corresponding child field will be dropped without recalculation.
     * @param array<Input|Numeric> $inputs
     * @param DateInterval $pattern_matched_interval
     * @return array<Input|Numeric>
     */
    protected function fillInputsFromDateInterval(array $inputs, DateInterval $pattern_matched_interval): array
    {
        return match ($this->field_pattern) {
            LengthOfTimeFieldPatterns::minutesSeconds => [
                $inputs[0]->withValue($pattern_matched_interval->i),
                $inputs[1]->withValue($pattern_matched_interval->s),
            ],
            LengthOfTimeFieldPatterns::hoursMinutes => [
                $inputs[0]->withValue($pattern_matched_interval->h),
                $inputs[1]->withValue($pattern_matched_interval->i),
            ],
            LengthOfTimeFieldPatterns::hoursMinutesSeconds => [
                $inputs[0]->withValue($pattern_matched_interval->h),
                $inputs[1]->withValue($pattern_matched_interval->i),
                $inputs[2]->withValue($pattern_matched_interval->s),
            ],
            LengthOfTimeFieldPatterns::daysHoursMinutes => [
                $inputs[0]->withValue($pattern_matched_interval->d),
                $inputs[1]->withValue($pattern_matched_interval->h),
                $inputs[2]->withValue($pattern_matched_interval->i),
            ],
        };
    }

    /**
     * @inheritdoc
     */
    protected function isClientSideValueOk($value): bool
    {
        if (!$this->isArrayFieldPatternMatch($value)) {
            return false;
        }

        return true;
    }

    /**
     * Returns an array with time values by descending units (e.g. hour > minute > seconds).
     * Units not in the field_pattern will be left behind. There is no calculation or reformatting.
     * DateInterval methods return 0 when that value was never provided to the DateInterval.
     * @param DateInterval $date_interval
     * @param LengthOfTimeFieldPatterns $field_pattern
     * @return array<int>
     */
    public static function dateIntervalToArray(DateInterval $date_interval, LengthOfTimeFieldPatterns $field_pattern): array
    {
        return match ($field_pattern) {
            LengthOfTimeFieldPatterns::minutesSeconds => [ $date_interval->i, $date_interval->s ],
            LengthOfTimeFieldPatterns::hoursMinutes => [ $date_interval->h, $date_interval->i ],
            LengthOfTimeFieldPatterns::hoursMinutesSeconds => [ $date_interval->h, $date_interval->i, $date_interval->s ],
            LengthOfTimeFieldPatterns::daysHoursMinutes => [ $date_interval->d, $date_interval->h, $date_interval->i ],
        };
    }

    /**
     * Based on the current field_pattern expects an array with one value per field pattern unit
     * @param array<int|string> $array
     * @param $field_pattern
     * @return DateInterval
     */
    public static function arrayToDateInterval(array $array, LengthOfTimeFieldPatterns $field_pattern): DateInterval
    {
        $array = array_values($array); // keys may vary, order is the same

        $result = match ($field_pattern) {
            LengthOfTimeFieldPatterns::minutesSeconds => new DateInterval(
                "PT" . $array[0] . "M" . $array[1] . "S"
            ),
            LengthOfTimeFieldPatterns::hoursMinutes => new DateInterval(
                "PT" . $array[0] . "H" . $array[1] . "M"
            ),
            LengthOfTimeFieldPatterns::hoursMinutesSeconds => new DateInterval(
                "PT" . $array[0] . "H" . $array[1] . "M" . $array[2] . "S"
            ),
            LengthOfTimeFieldPatterns::daysHoursMinutes => new DateInterval(
                "P" . $array[0] . "DT" . $array[1] . "H" . $array[2] . "M"
            )
        };
        return $result;
    }

    /**
     * @param array<string|int> $values
     * @param LengthOfTimeFieldPatterns|null $field_pattern
     * @return bool
     */
    public function isArrayFieldPatternMatch(
        array $values,
        ?LengthOfTimeFieldPatterns $field_pattern = null,
    ): bool {
        $this->checkArgListElements("values", $values, ['string', 'int']);
        if (!$field_pattern) {
            $field_pattern = $this->field_pattern;
        }
        return match ($field_pattern) {
            LengthOfTimeFieldPatterns::minutesSeconds,
            LengthOfTimeFieldPatterns::hoursMinutes => (count($values) === 2),
            LengthOfTimeFieldPatterns::daysHoursMinutes,
            LengthOfTimeFieldPatterns::hoursMinutesSeconds => (count($values) === 3),
        };
    }

    public function isDateIntervalFieldPatternMatch(
        DateInterval $date_interval,
        ?LengthOfTimeFieldPatterns $field_pattern = null
    ): bool {
        if (!$field_pattern) {
            $field_pattern = $this->field_pattern;
        }
        return match ($field_pattern) {
            LengthOfTimeFieldPatterns::minutesSeconds => (!(
                $date_interval->y > 0 ||
                $date_interval->m > 0 ||
                $date_interval->d > 0 ||
                $date_interval->h > 0 ||
                $date_interval->f > 0
            )),
            LengthOfTimeFieldPatterns::hoursMinutes => (!(
                $date_interval->y > 0 ||
                $date_interval->m > 0 ||
                $date_interval->d > 0 ||
                $date_interval->s > 0 ||
                $date_interval->f > 0
            )),
            LengthOfTimeFieldPatterns::daysHoursMinutes => (!(
                $date_interval->y > 0 ||
                $date_interval->m > 0 ||
                $date_interval->s > 0 ||
                $date_interval->f > 0
            )),
            LengthOfTimeFieldPatterns::hoursMinutesSeconds => (!(
                $date_interval->y > 0 ||
                $date_interval->m > 0 ||
                $date_interval->d > 0 ||
                $date_interval->f > 0
            )),
        };
    }



    public function getValue()
    {
        return $this->value;
    }

    /**
     * The parent method distributes values to children's withInput and the Length of Time's content,
     * and attaches errors to individual fields if necessary.
     * Different from most Group subclasses, the LengthOfTime input has a global DateInterval representing the value of
     * all the inputs together. Therefor, we don't fetch from the child inputs as it is usually done in Groups.
     * Consequently, we have to explicitly build the ->value, run the LengthOfTime's group trafos and populate the child
     * inputs once again as the TimeOverflow may have changed every individual value.
     * As long as the operations have returned a DateInterval as ->content, we use this DateInterval. If consumers add a
     * trafo that doesn't return a DateInterval, we fetch the values from the inputs to at least honor their trafos.
     * @param InputData $input
     * @return self
     * @throws \Exception
     */
    public function withInput(InputData $input): self
    {
        // distributes InputData to children, runs their operations,
        // collects array of children values as Length of Time content
        // runs Length of Time operations on this content array, so $this->content is fully done
        $clone = parent::withInput($input);

        // Now building the value for rendering
        if ($clone->content->value() instanceof DateInterval) {
            // if trafos (which may be modified by the consumer) still return DateIntervals, let's take those
            // would include the default and/or the consumer's own time overflow solutions
            $value = $clone->content->value();
        } else {
            // fallback: construct input from transformed children values (which most groups do anyway)
            // fails-safe, but disregards trafos of the group completely
            $values_with_children_operations = [];
            foreach ($clone->getInputs() as $input) {
                $values_with_children_operations[] = $input->value;
            }
            $value = self::arrayToDateInterval(
                $values_with_children_operations,
                $this->field_pattern,
            );
        }

        $clone->value = $value;

        $inputs = $clone->getInputs();
        $filled_inputs = $this->fillInputsFromDateInterval($inputs, $clone->value);
        $clone->setInputs($filled_inputs);

        return $clone;
    }

    /**
     * @param int $valueLowerField
     * @param int $valueHigherField
     * @param int $stepLowerToHigher
     * @return array<int>
     */
    protected function handleOverflowingTimeValues(int $valueLowerField, int $valueHigherField, int $stepLowerToHigher = 60): array
    {
        $normalizedHigherField = $valueHigherField;
        $normalizedHigherField += intval($valueLowerField / $stepLowerToHigher);
        $normalizedLowerField = $valueLowerField % $stepLowerToHigher;
        return [$normalizedLowerField, $normalizedHigherField];
    }

    /**
     * @param array<int> $valuesOrderOfAscendingUnits
     * @param array<int> $overflow_steps
     * @return array<int>
     */
    protected function handleMultipleOverflowingTimeValues(
        array $valuesOrderOfAscendingUnits,
        array $overflow_steps
    ): array {
        if (count($valuesOrderOfAscendingUnits) !== count($overflow_steps) + 1) {
            throw new InvalidArgumentException(
                "To convert overflowing time values provide n values and n-1 step sizes between them"
            );
        }

        foreach ($overflow_steps as $index => $step) {
            [$valuesOrderOfAscendingUnits[$index], $valuesOrderOfAscendingUnits[$index + 1]] =
                $this->handleOverflowingTimeValues(
                    $valuesOrderOfAscendingUnits[$index],
                    $valuesOrderOfAscendingUnits[$index + 1],
                    $step
                );
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

    protected function handleDateIntervalValueOverflows(DateInterval $v): DateInterval
    {
        $array = self::dateIntervalToArray($v, $this->field_pattern);

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


        return self::arrayToDateInterval($result, $this->field_pattern);
    }

    protected function addBaseTransformation(): void
    {
        $date_interval_trafo = $this->refinery->custom()->transformation(function (array|DateInterval $v): DateInterval {
            return ($v instanceof DateInterval) ? $v : self::arrayToDateInterval($v, $this->field_pattern);
        });
        $this->setAdditionalTransformation($date_interval_trafo);
    }

    protected function addOverflowTransformation(): void
    {
        $date_interval_trafo = $this->refinery->custom()->transformation(function (DateInterval $v): DateInterval {
            return $this->handleDateIntervalValueOverflows($v);
        });
        $this->setAdditionalTransformation($date_interval_trafo);
    }

    public function isComplex(): bool
    {
        return true;
    }

    public function getFieldPattern(): LengthOfTimeFieldPatterns
    {
        return $this->field_pattern;
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
