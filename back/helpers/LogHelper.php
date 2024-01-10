<?php

namespace Helpers;

use Exception;

if (!getenv('PATH_LOGS')) {
    throw new Exception('PATH_LOGS is not .env');
}

class LogHelper
{
    public static function debug($name, $msg)
    {
        if (is_array($msg)) {
            $msg = json_encode($msg, JSON_PRETTY_PRINT);
        }
        $content = 'DEBUG(' . $name . ' ' . date('Y-m-d H:i:s') .  '): ' . $msg . chr(10);
        @file_put_contents(getenv('PATH_LOGS') . 'debug_' . date('Ymd') . '.log', $content, FILE_APPEND | LOCK_EX);
    }

    public static function error($name, $msg)
    {
        if (is_array($msg)) {
            $msg = json_encode($msg, JSON_PRETTY_PRINT);
        }
        $content = 'ERROR(' . $name . ' ' . date('Y-m-d H:i:s') .  '): ' . $msg . chr(10);
        @file_put_contents(getenv('PATH_LOGS') . 'error_' . date('Ymd') . '.log', $content, FILE_APPEND | LOCK_EX);
    }

    public static function log($name, $msg)
    {
        if (is_array($msg)) {
            $msg = json_encode($msg, JSON_PRETTY_PRINT);
        }
        $content = 'LOG(' . $name . ' ' . date('Y-m-d H:i:s') .  '): ' . $msg . chr(10);
        @file_put_contents(getenv('PATH_LOGS') . 'log_' . date('Ymd') . '.log', $content, FILE_APPEND | LOCK_EX);
    }
}
