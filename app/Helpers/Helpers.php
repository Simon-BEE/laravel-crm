<?php

namespace App\Helpers;

class Helpers
{
    public static function className($model)
    {
        $classArray = explode("\\", get_class($model));

        return array_pop($classArray);
    }
}
