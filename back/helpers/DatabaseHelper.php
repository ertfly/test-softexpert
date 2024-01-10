<?php

namespace Helpers;

use Exception;
use PDO;
use Medoo\Medoo;

class DatabaseHelper
{
    /**
     * @var Medoo
     */
    private static $instance;

    /**
     * @return Medoo
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new Medoo([
                'database_type' => getenv('DB_DRIVER'),
                'database_name' => getenv('DB_NAME'),
                'server' => getenv('DB_HOST'),
                'username' => getenv('DB_USER'),
                'password' => getenv('DB_PASS'),
                'port' => getenv('DB_PORT'),
                'charset' => getenv('DB_CHARSET'),
                'option' => [
                    PDO::ATTR_CASE => PDO::CASE_NATURAL,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                ]
            ]);
        }

        return self::$instance;
    }

    public static function closeInstance()
    {
        if (!is_null(self::$instance)) {
            self::$instance = null;
        }
    }
}
