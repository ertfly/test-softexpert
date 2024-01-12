<?php

namespace App\Modules;

use Business\Register\Entity\CustomerEntity;
use Business\Register\Repository\CustomerRepository;
use Business\Register\Rule\CustomerRule;
use Exception;
use Helpers\FormValidation\FormValidationHelper;
use Helpers\RequestHelper;

class CustomerController
{
    public function index()
    {
        $rows = [];
        $filter = [];
        $pagination = CustomerRepository::allWithPagination($filter, RequestHelper::get('pg'));
        foreach ($pagination->getRows() as $a) {
            /**
             * @var CustomerEntity $a
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
        $row = CustomerRepository::byId($id);
        if (!$row->getId() || $row->getTrash()) {
            throw new Exception('Registro não encontrado!');
        }

        responseApi([
            'id' => $row->getId(),
            'fullname' => $row->getFullname(),
            'email' => $row->getEmail(),
        ]);
    }

    public function post()
    {
        $urldecode = RequestHelper::get('urldecode') ? true : false;

        $fullname = RequestHelper::json('fullname', 'Nome', [FormValidationHelper::REQUIRED], null, $urldecode);
        $email = RequestHelper::json('email', 'E-mail', [FormValidationHelper::REQUIRED, FormValidationHelper::EMAIL]);

        $checkEmail = CustomerRepository::byEmail($email);
        if ($checkEmail->getId()) {
            throw new Exception('E-mail informado já possue cadastro!');
        }

        $row = (new CustomerEntity)
            ->setFullname($fullname)
            ->setEmail($email);

        CustomerRule::insert($row);

        responseApi([
            'msg' => 'Registro criado com sucesso!'
        ]);
    }

    public function put($id)
    {
        $urldecode = RequestHelper::get('urldecode') ? true : false;

        $row = CustomerRepository::byId($id);
        if (!$row->getId() || $row->getTrash()) {
            throw new Exception('Registro não encontrado!');
        }

        $fullname = RequestHelper::json('fullname', 'Nome', [FormValidationHelper::REQUIRED], null, $urldecode);
        $email = RequestHelper::json('email', 'E-mail', [FormValidationHelper::REQUIRED, FormValidationHelper::EMAIL]);

        $checkEmail = CustomerRepository::byEmail($email);
        if ($checkEmail->getId() && $checkEmail->getId() != $row->getId()) {
            throw new Exception('E-mail informado já possue cadastro!');
        }

        $row
            ->setFullname($fullname)
            ->setEmail($email);

        CustomerRule::update($row);

        responseApi([
            'msg' => 'Registro alterado com sucesso!'
        ]);
    }

    public function delete($id)
    {
        $row = CustomerRepository::byId($id);
        if (!$row->getId() || $row->getTrash()) {
            throw new Exception('Registro não encontrado!');
        }

        CustomerRule::delete($row);

        responseApi([
            'msg' => 'Registro excluído com sucesso!'
        ]);
    }
}
