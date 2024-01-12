<?php

namespace App\Modules;

use App\Constants\ResponseConstant;
use Exception;
use Helpers\FormValidation\FormValidationHelper;
use Helpers\RequestHelper;
use Helpers\SessionHelper;

class AuthController
{
    public function get()
    {
        $name = SessionHelper::item('user.name');
        $logged = SessionHelper::item('user.id') ? true : false;
            
        responseApi([
            'name' => $name ? $name : '',
            'logged' => $logged,
        ]);
    }

    public function post()
    {
        try {
            $email = RequestHelper::json('email', 'E-mail', [FormValidationHelper::REQUIRED, FormValidationHelper::EMAIL]);
            $pass = RequestHelper::json('pass', 'Senha', [FormValidationHelper::REQUIRED]);

            $name = 'Eric';
            SessionHelper::data('user.name', $name);
            SessionHelper::data('user.id', '1');

            responseApi([
                'name' => $name,
                'logged' => true,
            ]);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), ResponseConstant::NOT_ACTION);
        }
    }

    public function delete()
    {
        SessionHelper::delete('user.name');
        SessionHelper::delete('user.id');
        responseApi([]);
    }
}
