<?php

namespace App\Modules;

use App\Constants\ResponseConstant;
use Business\Register\Repository\UserRepository;
use Exception;
use Helpers\FormValidation\FormValidationHelper;
use Helpers\RequestHelper;
use Helpers\SessionHelper;
use Helpers\StringHelper;

class AuthController
{
    public function get()
    {
        $name = '';
        $logged = false;

        $user = UserRepository::byId(SessionHelper::item('user.id'));
        if($user->getId()){
            $name = $user->getFullname(true);
            $logged = true;
        }

        responseApi([
            'name' => $name,
            'logged' => $logged,
        ]);
    }

    public function post()
    {
        try {
            $email = RequestHelper::json('email', 'E-mail', [FormValidationHelper::REQUIRED, FormValidationHelper::EMAIL]);
            $pass = RequestHelper::json('pass', 'Senha', [FormValidationHelper::REQUIRED]);

            $user = UserRepository::byEmail($email);
            if (!$user->getId()) {
                throw new Exception('Usuário ou Senha inválido.');
            }

            if (StringHelper::password($pass) != $user->getPass()) {
                throw new Exception('Usuário ou Senha inválido.');
            }

            SessionHelper::data('user.id', $user->getId());

            responseApi([
                'name' => $user->getFullname(true),
                'logged' => true,
            ]);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), ResponseConstant::NOT_ACTION);
        }
    }

    public function delete()
    {
        SessionHelper::delete('user.id');
        responseApi([]);
    }
}
