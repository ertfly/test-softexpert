<?php

use Helpers\DatabaseHelper;
use Helpers\FormHelper;
use Helpers\RequestHelper;
use Helpers\ResponseHelper;
use Helpers\SessionHelper;

/**
 * @param string|null $index Parameter index name
 * @param string|null $defaultValue Default return value
 * @param array ...$methods Default methods
 * @return array|string|null
 */
function input($index = null, $defaultValue = null, $method)
{
    $value = null;
    if ($index !== null) {
        switch ($method) {
            case 'get':
                $value = RequestHelper::get($index);
                break;
            case 'post':
                $value = RequestHelper::post($index);
                break;
            case 'json':
                $value = RequestHelper::json($index);
                break;
            default:
                $value = RequestHelper::get($index);
                break;
        }
        if (!$value) {
            return $defaultValue;
        }
    }
    return $value;
}


function url($name, ?array $getParams = null, array $exclude = [])
{
    foreach ($exclude as $key) {
        if (isset($getParams[$key]))
            unset($getParams[$key]);
    }
    return '/' . trim($name, '/') . (!is_null($getParams) ? '?' . http_build_query($getParams) : '');
}

function urlAbsolute($name = null, ?array $getParams = null, array $exclude = [])
{

    $protocol = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? "https://" : "http://";
    $domainName = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '/');
    $base = $protocol . $domainName;
    if (getenv('BASE_URL')) {
        $base = getenv('BASE_URL');
    }
    return rtrim($base . url($name, $getParams, $exclude), '/');
}

function sessionItem($key, $defaultValue = null, $delete = false)
{
    $value = SessionHelper::item('action', $delete);
    if (!$value) {
        return $defaultValue;
    }

    return $value;
}

/**
 * Undocumented function
 *
 * @param array $data
 * @param integer $code
 * @param string $msg
 * @return array
 */
function responseApi(array $data, $code = 0, $msg = 'Success')
{
    DatabaseHelper::closeInstance();
    
    ResponseHelper::json([
        'response' => [
            'code' => $code,
            'msg' => $msg,
        ],
        'data' => $data,
    ]);
}

/**
 * Undocumented function
 *
 * @param \Exception $e
 * @return array
 */
function responseApiError(\Exception $e)
{
    DatabaseHelper::closeInstance();

    $code = 1;
    if ($e->getCode() > 0) {
        $code = $e->getCode();
    }
    ResponseHelper::json([
        'response' => [
            'code' => $code,
            'msg' => $e->getMessage(),
        ],
        'data' => null,
    ]);
}
