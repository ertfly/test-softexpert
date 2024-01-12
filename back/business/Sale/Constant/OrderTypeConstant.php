<?php

namespace Business\Sale\Constant;

use Exception;

class OrderTypeConstant
{
    const BUDGET = 'budget';
    const SALE = 'sale';

    private static $options = [
        self::BUDGET => 'Orçamento',
        self::SALE => 'Venda',
    ];

    public static function getOptions()
    {
        return self::$options;
    }

    public static function getOption($key)
    {
        if (!isset(self::$options[$key])) {
            throw new Exception('Option ' . self::class . ' ' . $key . ' not found!');
        }

        return self::$options[$key];
    }

    public static function hasOption($key)
    {
        if (!isset(self::$options[$key])) {
            return false;
        }

        return true;
    }
}
