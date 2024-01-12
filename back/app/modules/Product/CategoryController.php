<?php

namespace App\Modules\Product;

use Business\Product\Entity\ProductCategoryEntity;
use Business\Product\Repository\ProductCategoryRepository;
use Business\Product\Rule\ProductCategoryRule;
use Exception;
use Helpers\FormValidation\FormValidationHelper;
use Helpers\NumberHelper;
use Helpers\RequestHelper;

class CategoryController
{
    public function index()
    {
        $rows = [];
        $filter = [];
        $pagination = ProductCategoryRepository::allWithPagination($filter, RequestHelper::get('pg'));
        foreach ($pagination->getRows() as $a) {
            /**
             * @var ProductCategoryEntity $a
             */

            $rows[] = [
                'id' => $a->getId(),
                'name' => $a->getName(),
                'fee' => $a->getFee(true),
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
        $row = ProductCategoryRepository::byId($id);
        if (!$row->getId() || $row->getTrash()) {
            throw new Exception('Registro não encontrado!');
        }

        responseApi([
            'name' => $row->getName(),
            'fee' => $row->getFee(true),
        ]);
    }

    public function post()
    {
        $urldecode = RequestHelper::get('urldecode') ? true : false;

        $name = RequestHelper::json('name', 'Nome', [FormValidationHelper::REQUIRED], null, $urldecode);

        $fee = RequestHelper::json('fee', 'Taxa', [FormValidationHelper::REQUIRED], null, $urldecode);
        $fee = NumberHelper::toDecimal($fee, 2);
        $fee = doubleval($fee) / doubleval(100);

        $row = (new ProductCategoryEntity)
            ->setName($name)
            ->setFee($fee);

        ProductCategoryRule::insert($row);

        responseApi([
            'msg' => 'Registro criado com sucesso!'
        ]);
    }

    public function put($id)
    {
        $urldecode = RequestHelper::get('urldecode') ? true : false;

        $row = ProductCategoryRepository::byId($id);
        if (!$row->getId() || $row->getTrash()) {
            throw new Exception('Registro não encontrado!');
        }

        $name = RequestHelper::json('name', 'Nome', [FormValidationHelper::REQUIRED], null, $urldecode);

        $fee = RequestHelper::json('fee', 'Taxa', [FormValidationHelper::REQUIRED], null, $urldecode);
        $fee = NumberHelper::toDecimal($fee, 2);
        $fee = doubleval($fee) / doubleval(100);

        $row
            ->setName($name)
            ->setFee($fee);

        ProductCategoryRule::update($row);

        responseApi([
            'msg' => 'Registro alterado com sucesso!'
        ]);
    }

    public function delete($id)
    {
        $row = ProductCategoryRepository::byId($id);
        if (!$row->getId() || $row->getTrash()) {
            throw new Exception('Registro não encontrado!');
        }

        ProductCategoryRule::delete($row);

        responseApi([
            'msg' => 'Registro excluído com sucesso!'
        ]);
    }

    public function select()
    {
        $rows = [];
        $filter = [];
        foreach (ProductCategoryRepository::all($filter) as $a) {
            /**
             * @var ProductCategoryEntity $a
             */

            $rows[] = [
                'id' => $a->getId(),
                'description' => $a->getName(),
            ];
        }
        responseApi($rows);
    }
}
