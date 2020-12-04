<?php

namespace InfyOm\LaravelCalendarEvents;

use Illuminate\Database\Eloquent\Model;

class BaseDTO
{
    public function __construct($attributes = [])
    {
        if ($attributes instanceof Model) {
            $attributes = $attributes->toArray();
        }

        foreach ($attributes as $attribute => $value) {
            if (property_exists($this, $attribute)) {
                $this->{$attribute} = $value;
            } else {
                if (property_exists($this, 'meta')) {
                    $this->meta[$attribute] = $value;
                }
            }
        }
    }
}
