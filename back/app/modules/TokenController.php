<?php

namespace App\Modules;

use Helpers\SessionHelper;
use Helpers\StringHelper;

class TokenController
{
    public function post(){
        $token = StringHelper::token();
        SessionHelper::create($token);
        SessionHelper::init('api', $token);
        SessionHelper::data('accessIp', $_SERVER['REMOTE_ADDR'] ?? null);
        SessionHelper::data('accessBrowser', $_SERVER['HTTP_USER_AGENT'] ?? null);

        responseApi([
            'token' => $token,
        ]);
    }
}
