
<?php

namespace App\Helpers;

class Dates
{
    public static function prettyDate($date)
    {
        return date('d F Y', strtotime($date));
    }
}
