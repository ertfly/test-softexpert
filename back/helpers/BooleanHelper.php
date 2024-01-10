<?php

namespace Helpers;

class BooleanHelper
{

    public static function null($var)
    {
        if (!is_double($var) && !is_int($var) && !is_string($var) && !is_bool($var) && trim($var) == '') {
            return null;
        }

        return boolval($var);
    }
}
