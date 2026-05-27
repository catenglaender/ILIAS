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

require_once(__DIR__ . "/../../../../../../../vendor/composer/vendor/autoload.php");
require_once(__DIR__ . "/../../../Base.php");
require_once(__DIR__ . "/InputTest.php");
require_once(__DIR__ . "/CommonFieldRendering.php");

use ILIAS\UI\Component\Input\Field;
use ILIAS\UI\Implementation as I;
use ILIAS\UI\Implementation\Component\Input\ArrayInputData;
use ILIAS\UI\Component\Input\Field\LengthOfTimeFieldPatterns;
use ILIAS\UI\Implementation\Component\Input\Field\LengthOfTime as LengthOfTimeImpl;
use ILIAS\UI\Implementation\Component\Input\InputData;
use PHPUnit\Framework\Attributes\DataProvider;

class LengthOfTimeInputTest extends ILIAS_UI_TestBase
{
    use CommonFieldRendering;
    protected DefNamesource $name_source;

    public function getUIFactory(): NoUIFactory
    {
        $factory = new class () extends NoUIFactory {
            public I\Component\SignalGenerator $sig_gen;

            public function messageBox(): I\Component\MessageBox\Factory
            {
                return new I\Component\MessageBox\Factory();
            }
        };
        $factory->sig_gen = new I\Component\SignalGenerator();
        return $factory;
    }


    public function setUp(): void
    {
        $this->name_source = new DefNamesource();
    }

    public function testImplementsFactoryInterface(): void
    {
        $f = $this->getFieldFactory();
        $length_of_time_field = $f->lengthOfTime("label", "byline");

        $this->assertInstanceOf(\ILIAS\UI\Component\Input\Container\Form\FormInput::class, $length_of_time_field);
        $this->assertInstanceOf(Field\LengthOfTime::class, $length_of_time_field);
    }

    public function testUtilIsArrayFieldPatternMatch(): void
    {
        $f = $this->getFieldFactory();
        $length_of_time_field_2_fields = $f->lengthOfTime("label", "byline", Field\LengthOfTimeFieldPatterns::hoursMinutes);
        $length_of_time_field_3_fields = $f->lengthOfTime("label", "byline", Field\LengthOfTimeFieldPatterns::hoursMinutesSeconds);

        $array_2_fields = [
            "field_1" => "3",
            "field_2" => "20",
        ];
        $array_3_fields = [
            "field_1" => "3",
            "field_2" => "20",
            "field_3" => "47",
        ];

        $this->assertTrue(
            $length_of_time_field_2_fields->isArrayFieldPatternMatch($array_2_fields)
        );
        $this->assertFalse(
            $length_of_time_field_2_fields->isArrayFieldPatternMatch($array_3_fields)
        );
        $this->assertTrue(
            $length_of_time_field_3_fields->isArrayFieldPatternMatch($array_3_fields)
        );
        $this->assertFalse(
            $length_of_time_field_3_fields->isArrayFieldPatternMatch($array_2_fields)
        );
    }

    public function testUtilDateIntervalToArray(): void
    {
        $this->assertEquals(
            [1,30],
            LengthOfTimeImpl::dateIntervalToArray(
                DateInterval::createFromDateString("1 hour 30 minutes"),
                LengthOfTimeFieldPatterns::hoursMinutes,
            )
        );
    }

    public function testUtilArrayToDateInterval(): void
    {
        $date_interval = new DateInterval("PT2H45M");
        $actual = LengthOfTimeImpl::dateIntervalToArray(
            $date_interval,
            LengthOfTimeFieldPatterns::hoursMinutes
        );
        $this->assertEquals(
            [2, 45],
            $actual
        );
    }

    public function testFillInputs(): void
    {
        $f = $this->getFieldFactory();

        $original_date_interval = new DateInterval("PT2H85M30S");

        $length_of_time_field = $f->lengthOfTime(
            "label",
            "byline",
            Field\LengthOfTimeFieldPatterns::hoursMinutesSeconds,
        )->withValue( // this privately calls fillInputsFromDateInterval()
            $original_date_interval
        );

        $inputs_1 = $length_of_time_field->getInputs();

        $this->assertEquals(
            [$original_date_interval->h, $original_date_interval->i, $original_date_interval->s],
            [$inputs_1[0]->getValue(), $inputs_1[1]->getValue(), $inputs_1[2]->getValue()],
        );

        // do some processing to cause changing input fields, also re-fills inputs
        $length_of_time_field = $length_of_time_field->withRecommendedTimeOverflow();

        $expected_date_interval_2 = new DateInterval("PT3H25M30S");

        $inputs_2 = $length_of_time_field->getInputs();

        $this->assertEquals(
            [$expected_date_interval_2->h, $expected_date_interval_2->i, $expected_date_interval_2->s],
            [$inputs_2[0]->getValue(), $inputs_2[1]->getValue(), $inputs_2[2]->getValue()],
        );
    }

    public function testUtilIsDateIntervalFieldPatternMatch(): void
    {
        $f = $this->getFieldFactory();
        $length_of_time_minutes_seconds = $f->lengthOfTime(
            "label",
            "byline",
            Field\LengthOfTimeFieldPatterns::minutesSeconds
        );
        $length_of_time_hours_minutes = $f->lengthOfTime(
            "label",
            "byline",
            Field\LengthOfTimeFieldPatterns::hoursMinutes
        );
        $length_of_time_days_hours_minutes = $f->lengthOfTime(
            "label",
            "byline",
            Field\LengthOfTimeFieldPatterns::daysHoursMinutes
        );
        $length_of_time_hours_minutes_seconds = $f->lengthOfTime(
            "label",
            "byline",
            Field\LengthOfTimeFieldPatterns::hoursMinutesSeconds
        );

        // MINUTES & SECONDS
        $date_interval_minutes_seconds_invalid = new DateInterval("P1YT11M30S");
        $date_interval_minutes_seconds_valid = new DateInterval("PT11M30S");

        $this->assertFalse(
            $length_of_time_minutes_seconds->isDateIntervalFieldPatternMatch(
                $date_interval_minutes_seconds_invalid
            ),
        );
        $this->assertTrue(
            $length_of_time_minutes_seconds->isDateIntervalFieldPatternMatch(
                $date_interval_minutes_seconds_valid
            ),
        );

        // HOURS & MINUTES
        $date_interval_hours_minutes_invalid = new DateInterval("PT2H11M20S");
        $date_interval_hours_minutes_valid = new DateInterval("PT2H11M");

        $this->assertFalse(
            $length_of_time_hours_minutes->isDateIntervalFieldPatternMatch(
                $date_interval_hours_minutes_invalid
            ),
        );
        $this->assertTrue(
            $length_of_time_hours_minutes->isDateIntervalFieldPatternMatch(
                $date_interval_hours_minutes_valid
            ),
        );

        // DAYS, HOURS & MINUTES
        $date_interval_days_hours_minutes_invalid = new DateInterval("P1WT2H11M20S");
        $date_interval_days_hours_minutes_valid = new DateInterval("P3DT2H11M");

        $this->assertFalse(
            $length_of_time_days_hours_minutes->isDateIntervalFieldPatternMatch(
                $date_interval_days_hours_minutes_invalid
            ),
        );
        $this->assertTrue(
            $length_of_time_days_hours_minutes->isDateIntervalFieldPatternMatch(
                $date_interval_days_hours_minutes_valid
            ),
        );

        // HOURS, MINUTES & SECONDS
        $date_interval_hours_minutes_seconds_invalid = new DateInterval("P1DT1H11M20S");
        $date_interval_hours_minutes_seconds_valid = new DateInterval("PT1H90M67S");

        $this->assertFalse(
            $length_of_time_hours_minutes_seconds->isDateIntervalFieldPatternMatch(
                $date_interval_hours_minutes_seconds_invalid
            ),
        );
        $this->assertTrue(
            $length_of_time_hours_minutes_seconds->isDateIntervalFieldPatternMatch(
                $date_interval_hours_minutes_seconds_valid
            ),
        );
    }

    public static function provideValueArrays(): array
    {
        return [
            // MINUTES & SECONDS
            'minutes_seconds_invalid_too_many' => [
            'field_pattern' => 'minutes_seconds',
            'value' => ["days" => "14", "hours" => "2", "minutes" => "27"],
            'expect_throw' => true,
            ],
            'minutes_seconds_invalid_too_few' => [
                'field_pattern' => 'minutes_seconds',
                'value' => ["minutes" => "2"],
                'expect_throw' => true,
            ],
            'minutes_seconds_valid' => [
                'field_pattern' => 'minutes_seconds',
                'value' => ["minutes" => "2", "seconds" => "27"],
                'expect_throw' => false,
            ],
            // HOURS & MINUTES
            'hours_minutes_invalid_too_many' => [
                'field_pattern' => 'hours_minutes',
                'value' => ["days" => "14", "hours" => "2", "minutes" => "27"],
                'expect_throw' => true,
            ],
            'hours_minutes_invalid_too_few' => [
                'field_pattern' => 'hours_minutes',
                'value' => ["hours" => "2"],
                'expect_throw' => true,
            ],
            'hours_minutes_valid' => [
                'field_pattern' => 'hours_minutes',
                'value' => ["hours" => "2", "minutes" => "27"],
                'expect_throw' => false,
            ],
            // HOURS, MINUTES & SECONDS
            'hours_minutes_seconds_invalid_too_many' => [
                'field_pattern' => 'hours_minutes_seconds',
                'value' => ["days" => "14", "hours" => "2", "minutes" => "27", "seconds" => "52"],
                'expect_throw' => true,
            ],
            'hours_minutes_seconds_invalid_too_few' => [
                'field_pattern' => 'hours_minutes_seconds',
                'value' => ["hours" => "2"],
                'expect_throw' => true,
            ],
            'hours_minutes_seconds_valid' => [
                'field_pattern' => 'hours_minutes_seconds',
                'value' => ["hours" => "2", "minutes" => "27", "seconds" => "39"],
                'expect_throw' => false,
            ],
            // DAYS, HOURS & MINUTES
            'days_hours_minutes_invalid_too_many' => [
                'field_pattern' => 'days_hours_minutes',
                'value' => ["days" => "14", "hours" => "2", "minutes" => "27", "seconds" => "52"],
                'expect_throw' => true,
            ],
            'days_hours_minutes_invalid_too_few' => [
                'field_pattern' => 'days_hours_minutes',
                'value' => ["hours" => "2"],
                'expect_throw' => true,
            ],
            'days_hours_minutes_valid' => [
                'field_pattern' => 'days_hours_minutes',
                'value' => ["days" => "7", "hours" => "12", "minutes" => "42"],
                'expect_throw' => false,
            ],
        ];
    }

    #[DataProvider('provideValueArrays')]
    public function testWithValueArray(string $field_name, $value_array, $expect_throw): void
    {
        $f = $this->getFieldFactory();
        $length_of_time_field = null;

        if ($field_name === 'minutes_seconds') {
            $length_of_time_field = $f->lengthOfTime(
                "label",
                "byline",
                Field\LengthOfTimeFieldPatterns::minutesSeconds,
            );

        } elseif ($field_name === 'hours_minutes') {
            $length_of_time_field = $f->lengthOfTime(
                "label",
                "byline",
                Field\LengthOfTimeFieldPatterns::hoursMinutes,
            );
        } elseif ($field_name === 'hours_minutes_seconds') {
            $length_of_time_field = $f->lengthOfTime(
                "label",
                "byline",
                Field\LengthOfTimeFieldPatterns::hoursMinutesSeconds
            );
        } elseif ($field_name === 'days_hours_minutes') {
            $length_of_time_field = $f->lengthOfTime(
                "label",
                "byline",
                Field\LengthOfTimeFieldPatterns::daysHoursMinutes
            );
        }


        if ($expect_throw) {
            $this->expectException(InvalidArgumentException::class);
            $length_of_time_field->withValue($value_array);
        } else {
            $length_of_time_field = $length_of_time_field->withValue($value_array);
            $this->assertEquals(
                array_values($value_array),
                LengthOfTimeImpl::dateIntervalToArray(
                    $length_of_time_field->getValue(),
                    $length_of_time_field->getFieldPattern()
                )
            );
        }
    }

    public static function provideOverflowingTimeValueArrays(): array
    {
        return [
            'minutes_seconds_valid' => [
                'field_pattern' => 'minutes_seconds',
                'value' => ["minutes" => "2", "seconds" => "83"],
                'expected_array' => [ "minutes" => "3", "seconds" => "23" ],
            ],
            'hours_minutes_valid' => [
                'field_pattern' => 'hours_minutes',
                'value' => ["hours" => "2", "minutes" => "83"],
                'expected_array' => [ "hours" => "3", "minutes" => "23" ],
            ],
            'hours_minutes_seconds_valid' => [
                'field_pattern' => 'hours_minutes_seconds',
                'value' => ["hours" => "2", "minutes" => "83", "seconds" => "61"],
                'expected_array' => [ "hours" => "3", "minutes" => "24", "seconds" => "1" ],
            ],
            'days_hours_minutes_valid' => [
                'field_pattern' => 'days_hours_minutes',
                'value' => ["days" => "1", "hours" => "26", "minutes" => "83"],
                'expected_array' => ["days" => "2", "hours" => "3", "minutes" => "23" ],
            ],
        ];
    }

    #[DataProvider('provideOverflowingTimeValueArrays')]
    public function testWithOverflowingValues($field_pattern, $value_array, $expected_array): void
    {
        $f = $this->getFieldFactory();
        $length_of_time_field = null;

        if ($field_pattern === 'minutes_seconds') {
            $length_of_time_field = $f->lengthOfTime(
                "label",
                "byline",
                Field\LengthOfTimeFieldPatterns::minutesSeconds
            );
        } elseif ($field_pattern === 'hours_minutes') {
            $length_of_time_field = $f->lengthOfTime(
                "label",
                "byline",
                Field\LengthOfTimeFieldPatterns::hoursMinutes
            );
        } elseif ($field_pattern === 'hours_minutes_seconds') {
            $length_of_time_field = $f->lengthOfTime(
                "label",
                "byline",
                Field\LengthOfTimeFieldPatterns::hoursMinutesSeconds
            );
        } elseif ($field_pattern === 'days_hours_minutes') {
            $length_of_time_field = $f->lengthOfTime(
                "label",
                "byline",
                Field\LengthOfTimeFieldPatterns::daysHoursMinutes
            );
        }

        $length_of_time_field = $length_of_time_field->withRecommendedTimeOverflow()
                                                        ->withValue($value_array);
        $this->assertEquals(
            array_values($expected_array),
            LengthOfTimeImpl::dateIntervalToArray(
                $length_of_time_field->getValue(),
                $length_of_time_field->getFieldPattern()
            )
        );
    }

    public static function provideValueDateInterval(): array
    {
        return [
            // MINUTES & SECONDS
            'minutes_seconds_invalid_too_many' => [
                'field_pattern' => 'minutes_seconds',
                'value' => new DateInterval("P1DT14H2M27S"),
                'expect_throw' => true,
            ],
            'minutes_seconds_valid_too_few' => [
                'field_pattern' => 'minutes_seconds',
                // does not throw because DateInterval adds "0" values
                'value' => new DateInterval("PT1M"),
                'expect_throw' => false,
            ],
            'minutes_seconds_valid' => [
                'field_pattern' => 'minutes_seconds',
                'value' => new DateInterval("PT1M30S"),
                'expect_throw' => false,
            ],
            // HOURS & MINUTES
            'hours_minutes_invalid_too_many' => [
                'field_pattern' => 'hours_minutes',
                'value' => new DateInterval("P1DT2H27M"),
                'expect_throw' => true,
            ],
            'hours_minutes_valid_too_few' => [
                'field_pattern' => 'hours_minutes',
                // does not throw because DateInterval adds "0" values
                'value' => new DateInterval("PT2H"),
                'expect_throw' => false,
            ],
            'hours_minutes_valid' => [
                'field_pattern' => 'hours_minutes',
                'value' => new DateInterval("PT2H27M"),
                'expect_throw' => false,
            ],
            // HOURS, MINUTES & SECONDS
            'hours_minutes_seconds_invalid_too_many' => [
                'field_pattern' => 'hours_minutes_seconds',
                'value' => new DateInterval("P14DT1H2M27S"),
                'expect_throw' => true,
            ],
            'hours_minutes_seconds_valid_too_few' => [
                'field_pattern' => 'hours_minutes_seconds',
                // does not throw because DateInterval adds "0" values
                'value' => new DateInterval("PT2H"),
                'expect_throw' => false,
            ],
            'hours_minutes_seconds_valid' => [
                'field_pattern' => 'hours_minutes_seconds',
                'value' => new DateInterval("PT2H27M39S"),
                'expect_throw' => false,
            ],
            // DAYS, HOURS & MINUTES
            'days_hours_minutes_invalid_too_many' => [
                'field_pattern' => 'days_hours_minutes',
                'value' => new DateInterval("P14DT2H2M27S"),
                'expect_throw' => true,
            ],
            'days_hours_minutes_valid_too_few' => [
                'field_pattern' => 'days_hours_minutes',
                // does not throw because DateInterval adds "0" values
                'value' => new DateInterval("PT2H"),
                'expect_throw' => false,
            ],
            'days_hours_minutes_valid' => [
                'field_pattern' => 'days_hours_minutes',
                'value' => new DateInterval("P7DT12H42M"),
                'expect_throw' => false,
            ],
        ];
    }

    #[DataProvider('provideValueDateInterval')]
    public function testWithValueDateInterval(string $field_name, $value, $expect_throw): void
    {
        $f = $this->getFieldFactory();
        $length_of_time_field = null;

        if ($field_name === 'minutes_seconds') {
            $length_of_time_field = $f->lengthOfTime(
                "label",
                "byline",
                Field\LengthOfTimeFieldPatterns::minutesSeconds,
            );

        } elseif ($field_name === 'hours_minutes') {
            $length_of_time_field = $f->lengthOfTime(
                "label",
                "byline",
                Field\LengthOfTimeFieldPatterns::hoursMinutes,
            );
        } elseif ($field_name === 'hours_minutes_seconds') {
            $length_of_time_field = $f->lengthOfTime(
                "label",
                "byline",
                Field\LengthOfTimeFieldPatterns::hoursMinutesSeconds
            );
        } elseif ($field_name === 'days_hours_minutes') {
            $length_of_time_field = $f->lengthOfTime(
                "label",
                "byline",
                Field\LengthOfTimeFieldPatterns::daysHoursMinutes
            );
        }


        if ($expect_throw) {
            $this->expectException(InvalidArgumentException::class);
            $length_of_time_field->withValue($value);
        } else {
            $length_of_time_field = $length_of_time_field->withValue($value);
            $this->assertEquals(
                LengthOfTimeImpl::dateIntervalToArray(
                    $value,
                    $length_of_time_field->getFieldPattern()
                ),
                LengthOfTimeImpl::dateIntervalToArray(
                    $length_of_time_field->getValue(),
                    $length_of_time_field->getFieldPattern()
                ),
            );
        }
    }

    public function testWithInput(): void
    {
        $f = $this->getFieldFactory();
        $length_of_time_input = $f->lengthOfTime(
            "label",
            "byline",
            LengthOfTimeFieldPatterns::minutesSeconds
        )->withValue(new DateInterval("PT1M10S")) // original value set by consumer
            ->withNameFrom($this->name_source);

        $input_data = $this->createMock(InputData::class);
        $input_data
            ->expects($this->atLeastOnce())
            ->method("getOr")
            ->willReturn("2", "30"); // new value set by user request

        $length_of_time_input = $length_of_time_input->withInput($input_data);

        $this->assertEquals(
            ["2", "30"],
            [$length_of_time_input->getValue()->i, $length_of_time_input->getValue()->s]
        );
    }

    public function testWithOverflowingInput(): void
    {
        $f = $this->getFieldFactory();
        $length_of_time_input = $f->lengthOfTime(
            "label",
            "byline",
            LengthOfTimeFieldPatterns::minutesSeconds
        )->withValue(new DateInterval("PT1M10S")) // original value set by consumer
        ->withNameFrom($this->name_source)
        ->withRecommendedTimeOverflow();

        $input_data = $this->createMock(InputData::class);
        $input_data
            ->expects($this->atLeastOnce())
            ->method("getOr")
            ->willReturn("2", "90"); // new value set by user request

        $length_of_time_input = $length_of_time_input->withInput($input_data);

        $this->assertEquals(
            ["3", "30"],
            [$length_of_time_input->getValue()->i, $length_of_time_input->getValue()->s]
        );
    }

    public function provideRenderVariety2fields(): array
    {
        return [
            'renderDateTimeHoursMinutesOverflow' => [
                'field_pattern' => LengthOfTimeFieldPatterns::hoursMinutes,
                'value' => new DateInterval("PT1H90M"),
                'use_overflow' => true,
                'expect_field_values' => ['2', '30'],
                'expect_child_label_1' => "hours",
                'expect_child_label_2' => "minutes",
            ],
            'renderDateTimeHoursMinutesNoOverflow' => [
                'field_pattern' => LengthOfTimeFieldPatterns::hoursMinutes,
                'value' => new DateInterval("PT1H90M"),
                'use_overflow' => false,
                'expect_field_values' => ['1', '90'],
                'expect_child_label_1' => "hours",
                'expect_child_label_2' => "minutes",
            ],
            'renderDateTimeMinutesSecondsOverflow' => [
                'field_pattern' => LengthOfTimeFieldPatterns::minutesSeconds,
                'value' => new DateInterval("PT1M90S"),
                'use_overflow' => true,
                'expect_field_values' => ['2', '30'],
                'expect_child_label_1' => "minutes",
                'expect_child_label_2' => "seconds",
            ],
            'renderDateTimeMinutesSecondsNoOverflow' => [
                'field_pattern' => LengthOfTimeFieldPatterns::minutesSeconds,
                'value' => new DateInterval("PT1M90S"),
                'use_overflow' => false,
                'expect_field_values' => ['1', '90'],
                'expect_child_label_1' => "minutes",
                'expect_child_label_2' => "seconds",
            ],
        ];
    }

    #[DataProvider('provideRenderVariety2fields')]
    public function testRender2fields(
        $field_pattern,
        $value,
        $use_overflow,
        $expect_field_values,
        $expect_child_label_1,
        $expect_child_label_2
    ): void {
        $f = $this->getFieldFactory();
        $length_of_time_input = $f->lengthOfTime("label", "byline", $field_pattern)
                                ->withNameFrom($this->name_source)
                                ->withValue($value);
        if ($use_overflow) {
            $result_feedback_html = '<div class="c-input-length-of-time__calc-message hidden" aria-hidden="true"><div class="alert alert-info" role="status"><div class="ilAccHeadingHidden">info_message</div>time_length_conversion_info<span class="c-input-length-of-time__result"></span></div></div><output class="sr-only c-input-length-of-time__calc-message-sr" aria-atomic="true"> time_length_conversion_info_screen_reader<span class="c-input-length-of-time__result"></span></output>';
            $length_of_time_input = $length_of_time_input->withRecommendedTimeOverflow();
            $js_id = 'id_4';
        } else {
            $result_feedback_html = '';
            $js_id = null;
        }

        $field_1 = $this->getFormWrappedHtml(
            'numeric-field-input',
            $expect_child_label_1,
            '<input id="id_2" type="number" value="' . $expect_field_values[0] . '" name="name_0/' . $expect_child_label_1 . '_1" class="c-field-number" />',
            null,
            'id_2',
            null,
            "name_0/" . $expect_child_label_1 . "_1",
        );
        $field_2 = $this->getFormWrappedHtml(
            'numeric-field-input',
            $expect_child_label_2,
            '<input id="id_3" type="number" value="' . $expect_field_values[1] . '" name="name_0/' . $expect_child_label_2 . '_2" class="c-field-number" />',
            null,
            'id_3',
            null,
            "name_0/" . $expect_child_label_2 . "_2",
        );
        $expected = $this->getFormWrappedHtml(
            'length-of-time-field-input',
            'label',
            '<div id="id_1" class="c-input-length-of-time ' . $length_of_time_input->getFieldPattern()->value . '">'
                . $field_1
                . $field_2
                . $result_feedback_html
            . '</div>',
            'byline',
            'id_1',
            $js_id,
        );
        $this->assertEquals($expected, $this->render($length_of_time_input));
    }
}
