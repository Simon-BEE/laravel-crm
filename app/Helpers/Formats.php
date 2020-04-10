<?php

namespace App\Helpers;

class Formats
{
    public static function formatPrice(int $price)
    {
        return number_format($price, 2, ',', ' ') . ' €';
    }
}
