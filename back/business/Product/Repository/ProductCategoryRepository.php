<?php

namespace Business\Product\Repository;

use Business\Product\Entity\ProductCategoryEntity;
use Helpers\DatabaseHelper;
use Helpers\PaginationHelper;
use Helpers\StringHelper;
use PDO;

class ProductCategoryRepository
{
    /**
     * Return row database by id
     * 
     * @param string|null $id
     * @return ProductCategoryEntity
     */
    public static function byId($id)
    {
        $db = DatabaseHelper::getInstance();
        $row = $db->query('select * from ' . ProductCategoryEntity::TABLE . ' where id = :id limit 1', ['id' => StringHelper::null($id)])->fetchObject(ProductCategoryEntity::class);

        if ($row === false) {
            return new ProductCategoryEntity();
        }
        return $row;
    }

    /**
     * @param string $url
     * @param array $filters
     * @param int $page
     * @param string $varPg
     * @param integer $perPage
     * @return PaginationHelper
     */
    public static function allWithPagination($filters = array(), $page, $perPage = 12, $orderBy = ' a.name asc ')
    {
        $db = DatabaseHelper::getInstance();

        $bind = array();
        $where = " trash = false ";

        $total = $db->query('
        select count(1) as total 
        from ' . ProductCategoryEntity::TABLE . ' a 
        where ' . $where, $bind)->fetch();

        $pagination = new PaginationHelper($total['total'], $page, $perPage);

        $rows = $db->query('
        select a.* 
        from ' . ProductCategoryEntity::TABLE . ' a 
        where ' . $where . ' 
        order by ' . $orderBy . ' 
        limit ' . $perPage . ' OFFSET ' . $pagination->getOffset(), $bind)->fetchAll(PDO::FETCH_CLASS, ProductCategoryEntity::class);

        $pagination->setRows($rows);
        return $pagination;
    }

    /**
     * Retorna todos os registros do banco
     * 
     * @return ProductCategoryEntity[]
     */
    public static function all(array $filters = [], $orderBy = ' a.name asc ')
    {
        $db = DatabaseHelper::getInstance();
        $where = ' a.trash is false ';
        $bind = [];

        $rows = $db->query('
        select a.* 
        from ' . ProductCategoryEntity::TABLE . ' a 
        where ' . $where . ' ORDER BY ' . $orderBy, $bind)->fetchAll(PDO::FETCH_CLASS, ProductCategoryEntity::class);

        return $rows;
    }
}
