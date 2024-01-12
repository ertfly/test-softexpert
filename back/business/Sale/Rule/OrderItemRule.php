<?php

namespace Business\Sale\Rule;

use Business\Sale\Entity\OrderItemEntity;
use Exception;
use Helpers\DatabaseHelper;
use Helpers\DateHelper;

class OrderItemRule
{
    public static function insert(OrderItemEntity &$record)
    {
        if ($record->getId()) {
            throw new Exception('Esse método serve inserir registros e não alterar');
        }
        $record->insert();
    }
    public static function update(OrderItemEntity &$record)
    {
        if (!$record->getId()) {
            throw new Exception('Esse método serve alterar registros e não inserir');
        }
        $record
            ->setUpdatedAt(DateHelper::now())
            ->update();
    }
    public static function delete(OrderItemEntity &$record)
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
        CREATE TABLE IF NOT EXISTS public.' . OrderItemEntity::TABLE . ' (
            id uuid NOT NULL,
            order_id uuid NOT NULL,
            product_id uuid NOT NULL,
            qty numeric(10,2) NOT NULL,
            price numeric(10,2) NOT NULL,
            cost numeric(10,2) NOT NULL,
            fee numeric(10,2) NOT NULL,
            total numeric(10,2) NOT NULL,
            total_cost numeric(10,2) NOT NULL,
            total_fee numeric(10,2) NOT NULL,
            created_at timestamp NOT NULL,
            updated_at timestamp NULL,
            trash boolean not null,
            CONSTRAINT ' . OrderItemEntity::TABLE . '_pk PRIMARY KEY (id)
        )');
        $db->query('CREATE INDEX IF NOT EXISTS ' . OrderItemEntity::TABLE . '_order_id_idx ON public.' . OrderItemEntity::TABLE . ' (order_id)');
        $db->query('CREATE INDEX IF NOT EXISTS ' . OrderItemEntity::TABLE . '_product_id_idx ON public.' . OrderItemEntity::TABLE . ' (product_id)');
        $db->query('CREATE INDEX IF NOT EXISTS ' . OrderItemEntity::TABLE . '_created_at_idx ON public.' . OrderItemEntity::TABLE . ' (created_at)');
        $db->query('CREATE INDEX IF NOT EXISTS ' . OrderItemEntity::TABLE . '_trash_idx ON public.' . OrderItemEntity::TABLE . ' ("trash")');
    }
}
