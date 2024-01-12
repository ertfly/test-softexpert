<?php

namespace Business\Sale\Rule;

use Business\Sale\Entity\OrderEntity;
use Exception;
use Helpers\DatabaseHelper;
use Helpers\DateHelper;

class OrderRule
{
    public static function insert(OrderEntity &$record)
    {
        if ($record->getId()) {
            throw new Exception('Esse método serve inserir registros e não alterar');
        }
        $record->insert();
    }
    public static function update(OrderEntity &$record)
    {
        if (!$record->getId()) {
            throw new Exception('Esse método serve alterar registros e não inserir');
        }
        $record
            ->setUpdatedAt(DateHelper::now())
            ->update();
    }
    public static function delete(OrderEntity &$record)
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
        CREATE TABLE IF NOT EXISTS public.' . OrderEntity::TABLE . ' (
            id uuid NOT NULL,
            customer_id uuid NOT NULL,
            type varchar(250) NOT NULL,
            total numeric(10,2) NOT NULL,
            cost numeric(10,2) NOT NULL,
            fee numeric(10,2) NOT NULL,
            profit numeric(10,2) NOT NULL,
            created_at timestamp NOT NULL,
            updated_at timestamp NULL,
            trash boolean not null,
            CONSTRAINT ' . OrderEntity::TABLE . '_pk PRIMARY KEY (id)
        )');
        $db->query('CREATE INDEX IF NOT EXISTS ' . OrderEntity::TABLE . '_customer_id_idx ON public.' . OrderEntity::TABLE . ' (customer_id)');
        $db->query('CREATE INDEX IF NOT EXISTS ' . OrderEntity::TABLE . '_type_idx ON public.' . OrderEntity::TABLE . ' ("type")');
        $db->query('CREATE INDEX IF NOT EXISTS ' . OrderEntity::TABLE . '_trash_idx ON public.' . OrderEntity::TABLE . ' ("trash")');
    }
}
