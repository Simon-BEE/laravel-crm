<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class SearchFacades extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'search';
    }
}
