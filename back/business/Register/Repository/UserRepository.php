<?php

namespace Business\Register\Repository;

use Business\Register\Entity\UserEntity;
use Helpers\DatabaseHelper;
use Helpers\PaginationHelper;
use Helpers\StringHelper;
use PDO;

class UserRepository
{
    /**
     * Return row database by id
     * 
     * @param string|null $id
     * @return UserEntity
     */
    public static function byId($id)
    {
        $db = DatabaseHelper::getInstance();
        $row = $db->query('select * from ' . UserEntity::TABLE . ' where id = :id limit 1', ['id' => StringHelper::null($id)])->fetchObject(UserEntity::class);

        if ($row === false) {
            return new UserEntity();
        }
        return $row;
    }

    /**
     * @param string $email
     * @return UserEntity
     */
    public static function byEmail($email)
    {
        $db = DatabaseHelper::getInstance();
        $row = $db->query('select * from ' . UserEntity::TABLE . ' where email = :email limit 1', ['email' => mb_convert_case($email, MB_CASE_LOWER)])->fetchObject(UserEntity::class);

        if ($row === false) {
            return new UserEntity();
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
        $where = " 0 = 0 ";

        $total = $db->query('
        select count(1) as total 
        from ' . UserEntity::TABLE . ' a 
        where ' . $where, $bind)->fetch();

        $pagination = new PaginationHelper($total['total'], $page, $perPage);

        $rows = $db->query('
        select a.* 
        from ' . UserEntity::TABLE . ' a 
        where ' . $where . ' 
        order by ' . $orderBy . ' 
        limit ' . $perPage . ' OFFSET ' . $pagination->getOffset(), $bind)->fetchAll(PDO::FETCH_CLASS, UserEntity::class);

        $pagination->setRows($rows);
        return $pagination;
    }
}
