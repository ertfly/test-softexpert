<?php

namespace Business\Register\Rule;

use Business\Register\Entity\CustomerEntity;
use Exception;
use Helpers\DatabaseHelper;
use Helpers\DateHelper;

class CustomerRule
{
    public static function insert(CustomerEntity &$record)
    {
        if ($record->getId()) {
            throw new Exception('Esse método serve inserir registros e não alterar');
        }
        $record->insert();
    }
    public static function update(CustomerEntity &$record)
    {
        if (!$record->getId()) {
            throw new Exception('Esse método serve alterar registros e não inserir');
        }
        $record
            ->setUpdatedAt(DateHelper::now())
            ->update();
    }
    public static function delete(CustomerEntity &$record)
    {
        if (!$record->getId()) {
            throw new Exception('Esse método serve alterar registros e não inserir');
        }
        $record->delete();
    }
    public static function install()
    {
        $db = DatabaseHelper::getInstance();
        $db->query('
        CREATE TABLE IF NOT EXISTS public.' . CustomerEntity::TABLE . ' (
            id uuid NOT NULL,
            fullname varchar(250) NOT NULL,
            email varchar(250) NOT NULL,
            created_at timestamp NOT NULL,
            updated_at timestamp NULL,
            trash boolean not null,
            CONSTRAINT ' . CustomerEntity::TABLE . '_pk PRIMARY KEY (id)
        )');
        $db->query('CREATE INDEX IF NOT EXISTS ' . CustomerEntity::TABLE . '_fullname_idx ON public.' . CustomerEntity::TABLE . ' (fullname)');
        $db->query('CREATE INDEX IF NOT EXISTS ' . CustomerEntity::TABLE . '_email_idx ON public.' . CustomerEntity::TABLE . ' (email)');
    }
}
