<?php

namespace InfyOm\LaravelCalendarEvents;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Infyomlabs\LaravelCalendarEvents\Skeleton\SkeletonClass
 */
class LaravelCalendarEventsFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-calendar-events';
    }
}
