<?php


namespace InfyOm\LaravelCalendarEvents;


class RecurringFrequencyType
{
    const RECURRING_TYPE_DAILY = 'DAILY';
    const RECURRING_TYPE_WEEKLY = 'WEEKLY';
    const RECURRING_TYPE_MONTHLY = 'MONTHLY';
    const RECURRING_TYPE_YEARLY = 'YEARLY';

    static $recurringTypes = [
        self::RECURRING_TYPE_DAILY,
        self::RECURRING_TYPE_WEEKLY,
        self::RECURRING_TYPE_MONTHLY,
        self::RECURRING_TYPE_YEARLY,
    ];
}
