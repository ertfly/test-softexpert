<?php

namespace App\Middlewares;

use App\Constants\ResponseConstant;
use Exception;
use Helpers\RequestHelper;

class NoTokenMiddleware
{
    public static function handler()
    {
        if (RequestHelper::getHeader('appKey') != getenv('APP_KEY')) {
            responseApiError((new Exception('credentials invalid', ResponseConstant::NOT_ACTION)));
        }
    }
}
