<?php

namespace Business\Product\Rule;

use Business\Product\Entity\ProductCategoryEntity;
use Exception;
use Helpers\DatabaseHelper;
use Helpers\DateHelper;

class ProductCategoryRule
{
    public static function insert(ProductCategoryEntity &$record)
    {
        if ($record->getId()) {
            throw new Exception('Esse método serve inserir registros e não alterar');
        }
        $record->insert();
    }
    public static function update(ProductCategoryEntity &$record)
    {
        if (!$record->getId()) {
            throw new Exception('Esse método serve alterar registros e não inserir');
        }
        $record
            ->setUpdatedAt(DateHelper::now())
            ->update();
    }
    public static function delete(ProductCategoryEntity &$record)
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
        CREATE TABLE IF NOT EXISTS public.'. ProductCategoryEntity::TABLE .' (
            id uuid NOT NULL,
            "name" varchar(150) not null,
            fee numeric(8,4) not null,
            created_at timestamp NOT NULL,
            updated_at timestamp NULL,
            trash boolean not null,
            CONSTRAINT '. ProductCategoryEntity::TABLE .'_pk PRIMARY KEY (id)
        )');
        $db->query('CREATE INDEX IF NOT EXISTS '. ProductCategoryEntity::TABLE .'_name_idx ON public.'. ProductCategoryEntity::TABLE .' ("name")');
        $db->query('CREATE INDEX IF NOT EXISTS '. ProductCategoryEntity::TABLE .'_trash_idx ON public.'. ProductCategoryEntity::TABLE .' (trash)');
    }
}
