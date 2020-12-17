# Laravel Calendar Recurring Events

[![Total Downloads](https://poser.pugx.org/infyomlabs/laravel-calendar-events/downloads)](https://packagist.org/packages/infyomlabs/laravel-calendar-events)
[![Monthly Downloads](https://poser.pugx.org/infyomlabs/laravel-calendar-events/d/monthly)](https://packagist.org/packages/infyomlabs/laravel-calendar-events)
[![Daily Downloads](https://poser.pugx.org/infyomlabs/laravel-calendar-events/d/daily)](https://packagist.org/packages/infyomlabs/laravel-calendar-events)
![Test](https://github.com/InfyOmLabs/laravel-calendar-events/workflows/Tests/badge.svg)
[![License](https://poser.pugx.org/infyomlabs/laravel-calendar-events/license)](https://packagist.org/packages/infyomlabs/laravel-calendar-events)

Calculate Laravel Calendar Recurring Events.
No need to store all millions of possible future events into Database.
No Cron needed to Generate Monthly events for the Database.

1. Create `CalendarEvent` Object from your Laravel Eloquent Model
2. Specify Recurring Pattern (Daily, Weekly, Monthly, Yearly along with options)
3. Calculate Future Event Occurrences as per your need by,
    1. Next Number of Occurrences
    2. Between Given Dates

## Installation

You can install the package via composer:

```bash
composer require infyomlabs/laravel-calendar-events
```

## Usage

``` php
 use InfyOm\LaravelCalendarEvents\CalendarEvent;
 use InfyOm\LaravelCalendarEvents\CalendarEventRecurrencePattern;

 $event = new CalendarEvent([
     [
         'id' => 1,
         'title' => 'Daily Repeat End on 30 Jan',
         'description' => 'Daily Repeat End on 30 Jan',
         'start_date' => '2021-01-10',
         'end_date' => '2021-01-20', // nullable
         'start_time' => '10:00:00',
         'end_time' => '12:00:00',
         'is_full_day' => false,
         'is_recurring' => true,
         'location' => 'Surat, India', // extra field. It will be automatically added to meta
         'meta' => [
             'ticket_required' => true
         ]
     ]
 ]);
 
 $event->recurring_pattern = new CalendarEventRecurrencePattern([
     'recurring_type' => RecurringFrequencyType::RECURRING_TYPE_DAILY,
     'max_occurrences' => 10, // Maximum 10 Occurrences
     'repeat_interval' => 1, // Repeat Daily
     'repeat_by_days' => ["MO", "WE", "SU"], // only repeat on Monday, Wednesday and Sunday
     'repeat_by_months' => [],
 ]);

 // Retrieve next 5 events. Returns CalendarEvent array.
 $event->getNextEvents(5);

 // Retrieve all events between 5th Jan to 15th Jan. Returns CalendarEvent array.
 $event->getEventsBetween('2021-01-05', '2021-01-15');

 // Retrieve next 2 Occurrences. Returns \Recurr\Recurrence array
 $event->getNextOccurrences(2);
 
 // If you Laravel Eloquent model matches the field names with above field name
 $event = new CalendarEvent($calendarModle);
```

You can also call direct functions on `CalendarEvent` class,

```php
 $event = new CalendarEvent([
     [
         'id' => 1,
         'title' => 'Daily Repeat End on 30 Jan',
         'description' => 'Daily Repeat End on 30 Jan',
         'start_time' => '10:00:00',
         'end_time' => '12:00:00',
         'location' => 'Surat, India', // extra field. It will be automatically added to meta
         'meta' => [
             'ticket_required' => true
         ]
     ]
 ]);

 $event->setStartDate(\Carbon\Carbon::parse('2021-01-10'));
 $event->setEndDate(\Carbon\Carbon::parse('2021-01-20'));
 $event->makeFullDay();
 $event->makeRecurring();

 $recurringPattern = new CalendarEventRecurrencePattern();
 $recurringPattern->repeatDaily();
 $recurringPattern->setMaxOccurrences(10);
 $recurringPattern->setRepeatInterval(2);
 $recurringPattern->setRepeatDays(["MO", "WE", "SU"]);

 $event->recurring_pattern = $recurringPattern;
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security-related issues, please email labs@infyom.com instead of using the issue tracker.

## Credits

- [InfyOmLabs](https://github.com/infyomlabs)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
