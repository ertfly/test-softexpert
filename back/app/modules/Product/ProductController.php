<?php

namespace App\Modules\Product;

use Business\Product\Entity\ProductEntity;
use Business\Product\Repository\ProductCategoryRepository;
use Business\Product\Repository\ProductRepository;
use Business\Product\Rule\ProductRule;
use Exception;
use Helpers\FormValidation\FormValidationHelper;
use Helpers\NumberHelper;
use Helpers\RequestHelper;

class ProductController
{
    public function index()
    {
        $rows = [];
        $filter = [];
        $pagination = ProductRepository::allWithPagination($filter, RequestHelper::get('pg'));
        foreach ($pagination->getRows() as $a) {
            /**
             * @var ProductEntity $a
             */

            $rows[] = [
                'id' => $a->getId(),
                'name' => $a->getName(),
                'category' => $a->getCategory()->getName(),
                'price' => $a->getPrice(true),
                'cost' => $a->getCost(true),
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
        $row = ProductRepository::byId($id);
        if (!$row->getId() || $row->getTrash()) {
            throw new Exception('Registro não encontrado!');
        }

        responseApi([
            'name' => $row->getName(),
            'categoryId' => $row->getCategoryId(),
            'category' => $row->getCategory()->getName(),
            'price' => $row->getPrice(true),
            'cost' => $row->getCost(true),
        ]);
    }

    public function post()
    {
        $urldecode = RequestHelper::get('urldecode') ? true : false;

        $name = RequestHelper::json('name', 'Nome', [FormValidationHelper::REQUIRED], null, $urldecode);

        $category = ProductCategoryRepository::byId(RequestHelper::json('categoryId', 'Categoria', [FormValidationHelper::REQUIRED]));

        $price = RequestHelper::json('price', 'Preço', [FormValidationHelper::REQUIRED], null, $urldecode);
        $price = NumberHelper::toDecimal($price, 2);
        if ($price < 0) {
            throw new Exception('Preço não pode ser menor que zero!');
        }

        $cost = RequestHelper::json('cost', 'Custo', [FormValidationHelper::REQUIRED], null, $urldecode);
        $cost = NumberHelper::toDecimal($cost, 2);
        if ($cost < 0) {
            throw new Exception('Custo não pode ser menor que zero!');
        }

        $row = (new ProductEntity)
            ->setCategoryId($category->getId())
            ->setName($name)
            ->setPrice($price)
            ->setCost($cost);

        ProductRule::insert($row);

        responseApi([
            'msg' => 'Registro criado com sucesso!'
        ]);
    }

    public function put($id)
    {
        $urldecode = RequestHelper::get('urldecode') ? true : false;

        $row = ProductRepository::byId($id);
        if (!$row->getId() || $row->getTrash()) {
            throw new Exception('Registro não encontrado!');
        }

        $name = RequestHelper::json('name', 'Nome', [FormValidationHelper::REQUIRED], null, $urldecode);

        $category = ProductCategoryRepository::byId(RequestHelper::json('categoryId', 'Categoria', [FormValidationHelper::REQUIRED]));

        $price = RequestHelper::json('price', 'Preço', [FormValidationHelper::REQUIRED], null, $urldecode);
        $price = NumberHelper::toDecimal($price, 2);
        if ($price < 0) {
            throw new Exception('Preço não pode ser menor que zero!');
        }

        $cost = RequestHelper::json('cost', 'Custo', [FormValidationHelper::REQUIRED], null, $urldecode);
        $cost = NumberHelper::toDecimal($cost, 2);
        if ($cost < 0) {
            throw new Exception('Custo não pode ser menor que zero!');
        }

        $row
            ->setCategoryId($category->getId())
            ->setName($name)
            ->setPrice($price)
            ->setCost($cost);

        ProductRule::update($row);

        responseApi([
            'msg' => 'Registro alterado com sucesso!'
        ]);
    }

    public function delete($id)
    {
        $row = ProductRepository::byId($id);
        if (!$row->getId() || $row->getTrash()) {
            throw new Exception('Registro não encontrado!');
        }

        ProductRule::delete($row);

        responseApi([
            'msg' => 'Registro excluído com sucesso!'
        ]);
    }
}
