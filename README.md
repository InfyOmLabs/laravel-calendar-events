<h1 align="center"><img src="https://assets.infyom.com/open-source/infyom-logo.png" alt="InfyOm"></h1>

Laravel Calendar Recurring Events
==========================

[![Total Downloads](https://poser.pugx.org/infyomlabs/laravel-calendar-events/downloads)](https://packagist.org/packages/infyomlabs/laravel-calendar-events)
[![Monthly Downloads](https://poser.pugx.org/infyomlabs/laravel-calendar-events/d/monthly)](https://packagist.org/packages/infyomlabs/laravel-calendar-events)
[![Daily Downloads](https://poser.pugx.org/infyomlabs/laravel-calendar-events/d/daily)](https://packagist.org/packages/infyomlabs/laravel-calendar-events)
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

## Support Us

We have created [14+ Laravel packages](https://github.com/InfyOmLabs) and invested a lot of resources into creating these all packages and maintaining them.

You can support us by either sponsoring us or buying one of our paid products. Or help us by spreading the word about us on social platforms via tweets and posts.

### Sponsors

[Become a sponsor](https://opencollective.com/infyomlabs#sponsor) and get your logo on our README on Github with a link to your site.

<a href="https://opencollective.com/infyomlabs#sponsor"><img src="https://opencollective.com/infyomlabs/sponsors.svg?width=890"></a>

### Backers

[Become a backer](https://opencollective.com/infyomlabs#backer) and get your image on our README on Github with a link to your site.

<a href="https://opencollective.com/infyomlabs#backer"><img src="https://opencollective.com/infyomlabs/backers.svg?width=890"></a>

### Buy our Paid Products

[![InfyJobs](https://assets.infyom.com/open-source/infyjobs-banner.png)](https://1.envato.market/P0ONVj)

You can also check out our other paid products on [CodeCanyon](https://codecanyon.net/user/infyomlabs/portfolio).


### Follow Us

- [Twitter](https://twitter.com/infyom)
- [Facebook](https://www.facebook.com/infyom)
- [LinkedIn](https://in.linkedin.com/company/infyom-technologies)
- [Youtube](https://www.youtube.com/channel/UC8IvwfChD6i7Wp4yZp3tNsQ)
- [Contact Us](https://infyom.com/contact-us)
