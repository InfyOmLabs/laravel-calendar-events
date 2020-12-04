<?php

namespace InfyOm\LaravelCalendarEvents;

class CalendarEventRecurrencePattern extends BaseDTO
{
    /** @var int */
    public $event_id;

    /** @var string */
    public $recurring_type;

    /** @var int */
    public $max_occurrences;

    /** @var int */
    public $repeat_interval;

    /** @var array */
    public $repeat_by_days; // ["MO", "TU", "WE", "TH", "FR", "SA", "SU"]

    /** @var array */
    public $repeat_by_months; // [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]

    /**
     * @param string $frequency
     * @throws \Exception
     */
    public function setRecurringType(string $frequency)
    {
        if (!in_array($frequency, RecurringFrequencyType::$recurringTypes)) {
            throw new \Exception("Invalid Frequency");
        }

        $this->recurring_type = $frequency;
    }

    /**
     * @param int $dayInterval
     */
    public function repeatDaily(int $dayInterval = 1)
    {
        $this->recurring_type = RecurringFrequencyType::RECURRING_TYPE_DAILY;
        $this->repeat_interval = $dayInterval;
    }

    /**
     * @param int $weekInterval
     */
    public function repeatWeekly(int $weekInterval = 1)
    {
        $this->recurring_type = RecurringFrequencyType::RECURRING_TYPE_WEEKLY;
        $this->repeat_interval = $weekInterval;
    }

    /**
     * @param int $monthInterval
     */
    public function repeatMonthly(int $monthInterval = 1)
    {
        $this->recurring_type = RecurringFrequencyType::RECURRING_TYPE_MONTHLY;
        $this->repeat_interval = $monthInterval;
    }

    /**
     * @param int $yearInterval
     */
    public function repeatYearly(int $yearInterval = 1)
    {
        $this->recurring_type = RecurringFrequencyType::RECURRING_TYPE_YEARLY;
        $this->repeat_interval = $yearInterval;
    }

    /**
     * @param int $maxOccurrences
     */
    public function setMaxOccurrences(int $maxOccurrences)
    {
        $this->max_occurrences = $maxOccurrences;
    }

    /**
     * @param int $repeatInterval
     */
    public function setRepeatInterval(int $repeatInterval)
    {
        $this->repeat_interval = $repeatInterval;
    }

    /**
     * @param array $repeatDays
     * @throws \Exception
     */
    public function setRepeatDays(array $repeatDays)
    {
        $validDays = ["MO", "TU", "WE", "TH", "FR", "SA", "SU"];

        foreach ($repeatDays as $day) {
            if (!in_array($day, $validDays)) {
                throw new \Exception("Day $day is not a valid Day");
            }
        }

        $this->repeat_by_days = $repeatDays;
    }

    /**
     * @param array $repeatMonths
     * @throws \Exception
     */
    public function setRepeatMonths(array $repeatMonths)
    {
        $validMonths = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];

        foreach ($repeatMonths as $month) {
            if (!in_array($month, $validMonths)) {
                throw new \Exception("Month $month is not a valid Month");
            }
        }

        $this->repeat_by_months = $repeatMonths;
    }
}
