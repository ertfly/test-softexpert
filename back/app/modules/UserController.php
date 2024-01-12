<?php

namespace App\Modules;

use Business\Register\Entity\UserEntity;
use Business\Register\Repository\UserRepository;
use Business\Register\Rule\UserRule;
use Exception;
use Helpers\FormValidation\FormValidationHelper;
use Helpers\RequestHelper;
use Helpers\StringHelper;

class UserController
{
    public function index()
    {
        $rows = [];
        $filter = [];
        $pagination = UserRepository::allWithPagination($filter, RequestHelper::get('pg'));
        foreach ($pagination->getRows() as $a) {
            /**
             * @var UserEntity $a
             */

            $rows[] = [
                'id' => $a->getId(),
                'fullname' => $a->getFullname(),
                'email' => $a->getEmail(),
                'createdAt' => $a->getCreatedAt(true),
            ];
        }
        responseApi([
            'rows' => $rows,
            'total' => $pagination->getTotal(),
            'pagination' => $pagination->getJson()
        ]);
    }

    public function view($id)
    {
        $row = UserRepository::byId($id);
        if (!$row->getId()) {
            throw new Exception('Registro não encontrado!');
        }

        responseApi([
            'fullname' => $row->getFullname(),
            'email' => $row->getEmail(),
        ]);
    }

    public function post()
    {
        $urldecode = RequestHelper::get('urldecode') ? true : false;

        $fullname = RequestHelper::json('fullname', 'Nome Completo', [FormValidationHelper::REQUIRED], null, $urldecode);
        $email = RequestHelper::json('email', 'E-mail', [FormValidationHelper::REQUIRED, FormValidationHelper::EMAIL], null, $urldecode);

        $checkEmail = UserRepository::byEmail($email);
        if ($checkEmail->getId()) {
            throw new Exception('E-mail informado já possue cadastro!');
        }

        $pass = RequestHelper::json('pass', 'Senha', [FormValidationHelper::REQUIRED], null, $urldecode);
        $passConfirm = RequestHelper::json('passConfirm', 'Confirmação da Senha', [FormValidationHelper::REQUIRED], null, $urldecode);

        if (StringHelper::password($pass) !== StringHelper::password($passConfirm)) {
            throw new Exception('Confirmação de senha inválido!');
        }

        $row = (new UserEntity)
            ->setFullname($fullname)
            ->setEmail($email)
            ->setPass(StringHelper::password($pass));

        UserRule::insert($row);

        responseApi([
            'msg' => 'Registro criado com sucesso!'
        ]);
    }

    public function put($id)
    {
        $urldecode = RequestHelper::get('urldecode') ? true : false;

        $row = UserRepository::byId($id);
        if (!$row->getId()) {
            throw new Exception('Registro não encontrado!');
        }

        $fullname = RequestHelper::json('fullname', 'Nome Completo', [FormValidationHelper::REQUIRED], null, $urldecode);
        $email = RequestHelper::json('email', 'E-mail', [FormValidationHelper::REQUIRED, FormValidationHelper::EMAIL], null, $urldecode);

        $checkEmail = UserRepository::byEmail($email);
        if ($checkEmail->getId() && $checkEmail->getId() != $row->getId()) {
            throw new Exception('E-mail informado já possue cadastro!');
        }

        $pass = RequestHelper::json('pass', null, null, null, $urldecode);
        $passConfirm = RequestHelper::json('passConfirm');
        if (StringHelper::null($pass) && StringHelper::null($passConfirm)) {
            if (StringHelper::password($pass) !== StringHelper::password($passConfirm)) {
                throw new Exception('Confirmação de senha inválido!');
            }
            $row->setPass(StringHelper::password($pass));
        }

        $row
            ->setFullname($fullname)
            ->setEmail($email);

        UserRule::update($row);

        responseApi([
            'msg' => 'Registro alterado com sucesso!'
        ]);
    }

    public function delete($id)
    {
        $row = UserRepository::byId($id);
        if (!$row->getId()) {
            throw new Exception('Registro não encontrado!');
        }

        UserRule::destroy($row);

        responseApi([
            'msg' => 'Registro excluído com sucesso!'
        ]);
    }
}
