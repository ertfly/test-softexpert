<?php

namespace Business\Sale\Repository;

use Business\Sale\Entity\OrderEntity;
use Helpers\DatabaseHelper;
use Helpers\PaginationHelper;
use Helpers\StringHelper;
use PDO;

class OrderRepository
{
    /**
     * Return row database by id
     * 
     * @param string|null $id
     * @return OrderEntity
     */
    public static function byId($id)
    {
        $db = DatabaseHelper::getInstance();
        $row = $db->query('select * from ' . OrderEntity::TABLE . ' where id = :id limit 1', ['id' => StringHelper::null($id)])->fetchObject(OrderEntity::class);

        if ($row === false) {
            return new OrderEntity();
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
    public static function allWithPagination($filters = array(), $page, $perPage = 12, $orderBy = ' a.fullname asc ')
    {
        $db = DatabaseHelper::getInstance();

        $bind = array();
        $where = " trash = false ";

        if (isset($filters['customerId']) && StringHelper::null($filters['customerId']) != null) {
            $where .= " and customer_id = :customerId ";
            $bind['customerId'] = StringHelper::null($filters['customerId']);
        }

        $total = $db->query('
        select count(1) as total 
        from ' . OrderEntity::TABLE . ' a 
        where ' . $where, $bind)->fetch();

        $pagination = new PaginationHelper($total['total'], $page, $perPage);

        $rows = $db->query('
        select a.* 
        from ' . OrderEntity::TABLE . ' a 
        where ' . $where . ' 
        order by ' . $orderBy . ' 
        limit ' . $perPage . ' OFFSET ' . $pagination->getOffset(), $bind)->fetchAll(PDO::FETCH_CLASS, OrderEntity::class);

        $pagination->setRows($rows);
        return $pagination;
    }
}
