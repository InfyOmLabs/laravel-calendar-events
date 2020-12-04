<?php

namespace InfyOm\LaravelCalendarEvents\Tests;

use Orchestra\Testbench\TestCase;
use Infyomlabs\LaravelCalendarEvents\LaravelCalendarEventsServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [LaravelCalendarEventsServiceProvider::class];
    }

    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
