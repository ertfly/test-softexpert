<?php

namespace Business\Product\Rule;

use Business\Product\Entity\ProductEntity;
use Exception;
use Helpers\DatabaseHelper;
use Helpers\DateHelper;

class ProductRule
{
    public static function insert(ProductEntity &$record)
    {
        if ($record->getId()) {
            throw new Exception('Esse método serve inserir registros e não alterar');
        }
        $record->insert();
    }
    public static function update(ProductEntity &$record)
    {
        if (!$record->getId()) {
            throw new Exception('Esse método serve alterar registros e não inserir');
        }
        $record
            ->setUpdatedAt(DateHelper::now())
            ->update();
    }
    public static function delete(ProductEntity &$record)
    {
        if (!$record->getId()) {
            throw new Exception('Esse método serve alterar registros e não inserir');
        }

        self::update($record);
        $record->delete();
    }
    public static function install()
    {
        $db = DatabaseHelper::getInstance();
        $db->query('
        CREATE TABLE IF NOT EXISTS public.'. ProductEntity::TABLE .' (
            id uuid NOT NULL,
            category_id uuid not null,
            "name" varchar(150) not null,
            price numeric(10,2) not null,
            cost numeric(10,2) not null,
            created_at timestamp NOT NULL,
            updated_at timestamp NULL,
            trash boolean not null,
            CONSTRAINT '. ProductEntity::TABLE .'_pk PRIMARY KEY (id)
        )');
        $db->query('CREATE INDEX IF NOT EXISTS '. ProductEntity::TABLE .'_category_id_idx ON public.'. ProductEntity::TABLE .' (category_id)');
        $db->query('CREATE INDEX IF NOT EXISTS '. ProductEntity::TABLE .'_name_idx ON public.'. ProductEntity::TABLE .' ("name")');
        $db->query('CREATE INDEX IF NOT EXISTS '. ProductEntity::TABLE .'_trash_idx ON public.'. ProductEntity::TABLE .' (trash)');
    }
}
