<?php

namespace Helpers;

use Exception;
use Helpers\LogHelper;
use Helpers\StringHelper;

if (!getenv('PATH_TMP')) {
    throw new Exception('PATH_TMP is not .env');
}

if (!getenv('PATH_ROUTINES')) {
    throw new Exception('PATH_ROUTINES is not .env');
}

class RoutineHelper
{
    public static function execute($command, $data = [], $debug = false)
    {
        if (!is_file(getenv('PATH_ROUTINES') . $command . '.php')) {
            throw new Exception('Arquivo de rotina não existe');
        }

        $token = StringHelper::token();

        if (count($data) > 0) {
            file_put_contents(getenv('PATH_TMP') . $token . '.tmp', json_encode($data));
        }
        $strCommand = '/usr/bin/php ' . getenv('PATH_ROUTINES') . $command . '.php' .  (count($data) > 0 ? ' "' . $token . '.tmp"' : '') . ' &';
        $handle = popen($strCommand, 'r');
        if ($debug) {
            $output = $strCommand . '\n';
            if ($handle) {
                while ($tmp = fgets($handle)) {
                    $output .= $tmp;
                }
                $output .= "\n\nResult = " . pclose($handle);
            }
            LogHelper::debug('RoutineHelper', $output);
        } else {
            pclose($handle);
        }
    }

    public static function close($tmpFile)
    {
        @unlink(getenv('PATH_TMP') . $tmpFile);
    }

    public static function isRuning($command)
    {
        $output = shell_exec('/bin/ps aux');
        if (strpos($output, $command . '.php ') !== false) {
            return true;
        }

        return false;
    }

    public static function stop($command)
    {
        $strCommand = '/usr/bin/pkill -f "' . getenv('PATH_ROUTINES') . $command . '.php"';
        $handle = popen($strCommand, 'r');
        pclose($handle);
    }

    public static function crontab($commands)
    {
        $arr = explode(chr(10), trim($commands));
        foreach ($arr as &$a) {
            $a = trim($a);
        }
        $content = implode(chr(10), $arr) . chr(10);
        file_put_contents(getenv('PATH_TMP') . 'crontab' . '.tmp', $content);
        $strCommand = '/bin/sh ' . getenv('PATH_ROOT') . 'crontab.sh';
        $handle = popen($strCommand, 'r');
        pclose($handle);

        $output = shell_exec('/usr/bin/crontab -l');
        sleep(2);
    }
}
