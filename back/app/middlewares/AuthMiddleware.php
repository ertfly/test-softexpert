<?php

namespace App\Middlewares;

use App\Constants\ResponseConstant;
use Exception;
use Helpers\RequestHelper;
use Helpers\SessionHelper;

class AuthMiddleware
{
    public static function handler()
    {
        applyCors();
        
        if (RequestHelper::getHeader('appKey') != getenv('APP_KEY')) {
            responseApiError((new Exception('credentials invalid', ResponseConstant::NOT_ACTION)));
        }

        SessionHelper::init('api', RequestHelper::getHeader('token'));
        SessionHelper::data('accessIp', $_SERVER['REMOTE_ADDR'] ?? null);

        if (!SessionHelper::item('user.id')) {
            responseApiError(new Exception('Sua sessão foi finalizada, realize o acesso novamente!', ResponseConstant::LOGIN));
        }
    }
}
