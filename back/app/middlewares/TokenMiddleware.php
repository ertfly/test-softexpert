<?php

namespace App\Middlewares;

use App\Constants\ResponseConstant;
use Exception;
use Helpers\RequestHelper;
use Helpers\SessionHelper;

class TokenMiddleware
{
    public static function handler()
    {
        applyCors();
        
        if (RequestHelper::getHeader('appKey') != getenv('APP_KEY')) {
            responseApiError((new Exception('credentials invalid', ResponseConstant::NOT_ACTION)));
        }

        SessionHelper::init('api', RequestHelper::getHeader('token'));
        SessionHelper::data('accessIp', $_SERVER['REMOTE_ADDR'] ?? null);
    }
}
