<?php

namespace InfyOm\LaravelCalendarEvents\Tests;

use InfyOm\LaravelCalendarEvents\LaravelCalendarEventsServiceProvider;
use Orchestra\Testbench\TestCase;

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
