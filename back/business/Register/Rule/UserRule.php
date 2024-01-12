<?php

namespace Business\Register\Rule;

use Business\Register\Entity\UserEntity;
use Exception;
use Helpers\DatabaseHelper;
use Helpers\DateHelper;

class UserRule
{
    public static function insert(UserEntity &$record)
    {
        if ($record->getId()) {
            throw new Exception('Esse método serve inserir registros e não alterar');
        }
        $record->insert();
    }
    public static function update(UserEntity &$record)
    {
        if (!$record->getId()) {
            throw new Exception('Esse método serve alterar registros e não inserir');
        }
        $record
            ->setUpdatedAt(DateHelper::now())
            ->update();
    }
    public static function install()
    {
        $db = DatabaseHelper::getInstance();
        $db->query('
        CREATE TABLE IF NOT EXISTS public.' . UserEntity::TABLE . ' (
            id uuid NOT NULL,
            fullname varchar(250) NOT NULL,
            email varchar(250) NOT NULL,
            pass varchar(64) NULL,
            created_at timestamp NOT NULL,
            updated_at timestamp NULL,
            CONSTRAINT ' . UserEntity::TABLE . '_pk PRIMARY KEY (id)
        )');
        $db->query('CREATE INDEX IF NOT EXISTS ' . UserEntity::TABLE . '_fullname_idx ON public.' . UserEntity::TABLE . ' (fullname)');
        $db->query('CREATE INDEX IF NOT EXISTS ' . UserEntity::TABLE . '_email_idx ON public.' . UserEntity::TABLE . ' (email)');
    }
}
