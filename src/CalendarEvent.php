<?php

namespace InfyOm\LaravelCalendarEvents;

use Carbon\Carbon;
use Recurr\DateExclusion;
use Recurr\Recurrence;
use Recurr\Rule;
use Recurr\Transformer\ArrayTransformer;

class CalendarEvent extends BaseDTO
{
    /** @var int */
    public $id;

    /** @var string */
    public $title;

    /** @var string */
    public $description;

    /** @var Carbon */
    public $start_date;

    /** @var Carbon */
    public $end_date;

    /** @var string */
    public $start_time;

    /** @var string */
    public $end_time;

    /** @var bool */
    public $is_full_day;

    /** @var bool */
    public $is_recurring;

    /** @var array */
    public $meta;

    /** @var array|\DateTime[]|DateExclusion[] */
    public $excluded_dates;

    /** @var CalendarEventRecurrencePattern */
    public $recurring_pattern;

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);

        if (!empty($this->start_date)) {
            $this->start_date = Carbon::parse($this->start_date);
        }

        if (!empty($this->end_date)) {
            $this->end_date = Carbon::parse($this->end_date);
        }
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * @param Carbon $startDate
     */
    public function setStartDate(Carbon $startDate)
    {
        $this->start_date = $startDate;
    }

    /**
     * @param Carbon $endDate
     */
    public function setEndDate(Carbon $endDate)
    {
        $this->end_date = $endDate;
    }

    /**
     * @param bool $fullDay
     */
    public function makeFullDay($fullDay = true)
    {
        $this->is_full_day = $fullDay;
    }

    /**
     * @param bool $recurring
     */
    public function makeRecurring($recurring = true)
    {
        $this->is_recurring = $recurring;
    }

    /**
     * @param Rule $rule
     * @param int|null $numberOfOccurrences
     * @return Rule
     */
    private function applyCount(Rule $rule, $numberOfOccurrences = null): Rule
    {
        if (!is_null($numberOfOccurrences)) {
            $rule->setCount($numberOfOccurrences);
        } else {
            if (!empty($this->recurring_pattern->max_occurrences)) {
                $rule->setCount($this->recurring_pattern->max_occurrences);
            }
        }

        return $rule;
    }

    /**
     * @param Rule $rule
     * @return Rule
     */
    private function applyStartDate(Rule $rule): Rule
    {
        $startDate = Carbon::parse($this->start_date)->setTimeFromTimeString($this->start_time);
        $rule->setStartDate($startDate);

        return $rule;
    }

    /**
     * @param Rule $rule
     * @return Rule
     */
    private function applyEndDate(Rule $rule): Rule
    {
        if (!empty($this->end_date)) {
            $endDate = Carbon::parse($this->end_date)->setTimeFromTimeString($this->end_time);
            $rule->setUntil($endDate);
        }

        return $rule;
    }

    /**
     * @param Rule $rule
     * @return Rule
     * @throws \Recurr\Exception\InvalidRRule
     */
    private function applyRepeatDays(Rule $rule): Rule
    {
        if (!empty($this->recurring_pattern->repeat_by_days)) {
            $rule->setByDay($this->recurring_pattern->repeat_by_days);
        }

        return $rule;
    }

    /**
     * @param Rule $rule
     * @return Rule
     */
    private function applyRepeatMonths(Rule $rule): Rule
    {
        if (!empty($recurringPattern->repeat_by_months)) {
            $rule->setByMonth($recurringPattern->repeat_by_months);
        }

        return $rule;
    }

    /**
     * @param Rule $rule
     * @return Rule
     */
    private function applyExcludedDates(Rule $rule): Rule
    {
        if (!empty($this->excluded_dates)) {
            $rule->setExDates($this->excluded_dates);
        }

        return $rule;
    }

    /**
     * @param Rule $rule
     * @return Rule
     * @throws \Recurr\Exception\InvalidArgument
     */
    private function updateRuleFromConfig(Rule $rule): Rule
    {
        $rule->setWeekStart(config('laravel-calendar-events.week_starts'));
        return $rule;
    }

    /**
     * @param null $numberOfOccurrences
     * @return Recurrence[]
     * @throws \Exception
     */
    public function getNextOccurrences($numberOfOccurrences = null): array
    {
        if (empty($this->end_date) and is_null($numberOfOccurrences) and empty($this->recurring_pattern->max_occurrences)) {
            throw new \Exception("Either End Date or Number of Occurrences is required");
        }

        if (!$this->is_recurring or empty($this->recurring_pattern->recurring_type)) {
            return [];
        }

        $rule = new Rule();
        $this->updateRuleFromConfig($rule);
        $rule->setFreq($this->recurring_pattern->recurring_type);
        $this->applyCount($rule, $numberOfOccurrences);
        $this->applyStartDate($rule);
        $this->applyEndDate($rule);
        $rule->setInterval($this->recurring_pattern->repeat_interval);
        $this->applyRepeatDays($rule);
        $this->applyRepeatMonths($rule);
        $this->applyExcludedDates($rule);

        $transformer = new ArrayTransformer();

        return $transformer->transform($rule)->toArray();
    }

    /**
     * @param int|null $numberOfEvents
     * @return CalendarEvent[]
     * @throws \Exception
     */
    public function getNextEvents($numberOfEvents = null): array
    {
        $nextOccurrences = $this->getNextOccurrences($numberOfEvents);

        /** @var CalendarEvent[] $events */
        $events = [];

        foreach ($nextOccurrences as $nextOccurrence) {
            $event = clone $this;
            $event->start_date = Carbon::parse($nextOccurrence->getStart())->setTimeFromTimeString($this->start_time);
            $event->end_date = Carbon::parse($nextOccurrence->getEnd())->setTimeFromTimeString($this->end_time);
            $events[] = $event;
        }

        return $events;
    }

    /**
     * @param Carbon|\DateTime|string $startDate
     * @param Carbon|\DateTime|string $endDate
     * @param int|null $numberOfEvents
     * @return CalendarEvent[]
     * @throws \Exception
     */
    public function getEventsBetween($startDate, $endDate, $numberOfEvents = null): array
    {
        $orgEvent = clone $this;

        if ($this->start_date > $endDate or !empty($this->end_date) and $startDate > $this->end_date) {
            return [];
        }

        if ($startDate > $this->start_date) {
            $this->start_date = Carbon::parse($startDate);
        }

        if (empty($this->end_date)) {
            $this->end_date = Carbon::parse($endDate);
        } else {
            if ($this->end_date > $endDate) {
                $this->end_date = Carbon::parse($endDate);
            }
        }

        $events = $this->getNextEvents($numberOfEvents);

        $this->start_date = $orgEvent->start_date;
        $this->end_date = $orgEvent->end_date;

        return $events;
    }
}
