<?php

namespace Business\Register\Repository;

use Business\Register\Entity\CustomerEntity;
use Helpers\DatabaseHelper;
use Helpers\PaginationHelper;
use Helpers\StringHelper;
use PDO;

class CustomerRepository
{
    /**
     * Return row database by id
     * 
     * @param string|null $id
     * @return CustomerEntity
     */
    public static function byId($id)
    {
        $db = DatabaseHelper::getInstance();
        $row = $db->query('select * from ' . CustomerEntity::TABLE . ' where id = :id limit 1', ['id' => StringHelper::null($id)])->fetchObject(CustomerEntity::class);

        if ($row === false) {
            return new CustomerEntity();
        }
        return $row;
    }

    /**
     * @param string $email
     * @return CustomerEntity
     */
    public static function byEmail($email)
    {
        $db = DatabaseHelper::getInstance();
        $row = $db->query('select * from ' . CustomerEntity::TABLE . ' where email = :email limit 1', ['email' => mb_convert_case($email, MB_CASE_LOWER)])->fetchObject(CustomerEntity::class);

        if ($row === false) {
            return new CustomerEntity();
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
    public static function allWithPagination($filters = array(), $page = 1, $perPage = 12, $orderBy = ' a.fullname asc ')
    {
        $db = DatabaseHelper::getInstance();

        $bind = array();
        $where = " trash = false ";

        $total = $db->query('
        select count(1) as total 
        from ' . CustomerEntity::TABLE . ' a 
        where ' . $where, $bind)->fetch();

        $pagination = new PaginationHelper($total['total'], $page, $perPage);

        $rows = $db->query('
        select a.* 
        from ' . CustomerEntity::TABLE . ' a 
        where ' . $where . ' 
        order by ' . $orderBy . ' 
        limit ' . $perPage . ' OFFSET ' . $pagination->getOffset(), $bind)->fetchAll(PDO::FETCH_CLASS, CustomerEntity::class);

        $pagination->setRows($rows);
        return $pagination;
    }
}
