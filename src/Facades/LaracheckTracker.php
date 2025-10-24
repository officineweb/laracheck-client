<?php

namespace Laracheck\Client\Facades;

use Illuminate\Support\Facades\Facade;

class LaracheckTracker extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor()
    {
        return 'laracheck';
    }
}
