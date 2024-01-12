<?php

namespace Business\Sale\Repository;

use Business\Sale\Entity\OrderItemEntity;
use Helpers\DatabaseHelper;
use Helpers\StringHelper;
use PDO;

class OrderItemRepository
{
    /**
     * Return row database by id
     * 
     * @param string|null $id
     * @return OrderItemEntity
     */
    public static function byId($id)
    {
        $db = DatabaseHelper::getInstance();
        $row = $db->query('select * from ' . OrderItemEntity::TABLE . ' where id = :id limit 1', ['id' => StringHelper::null($id)])->fetchObject(OrderItemEntity::class);

        if ($row === false) {
            return new OrderItemEntity();
        }
        return $row;
    }

    /**
     * Retorna todos os registros do banco
     * 
     * @return OrderItemEntity[]
     */
    public static function all(array $filters = [], $orderBy = ' a.created_at asc ')
    {
        $db = DatabaseHelper::getInstance();
        $where = ' a.trash is false ';
        $bind = [];

        if (isset($filters['orderId']) && StringHelper::null($filters['orderId']) != null) {
            $where .= ' and a.order_id = :orderId ';
            $bind['orderId'] = StringHelper::null($filters['orderId']);
        }

        $rows = $db->query('
        select a.* 
        from ' . OrderItemEntity::TABLE . ' a 
        where ' . $where . ' ORDER BY ' . $orderBy, $bind)->fetchAll(PDO::FETCH_CLASS, OrderItemEntity::class);

        return $rows;
    }
}
