<?php

namespace Helpers;

use Helpers\DatabaseHelper;
use Helpers\StringHelper;
use Medoo\Medoo;

abstract class EntityHelper
{
    abstract public function setId($id);
    abstract public function getId();
    abstract public function toArray();

    /**
     * Undocumented function
     *
     * @return void
     */
    public function insert()
    {
        if (!$this->getId()) {
            $this->setId(StringHelper::newGuid());
        }

        DatabaseHelper::getInstance()
            ->insert(static::TABLE, $this->toArray());
        return;
    }

    /**
     * Undocumented function
     *
     * @param Medoo $db
     * @return void
     */
    public function update()
    {
        DatabaseHelper::getInstance()
            ->update(static::TABLE, $this->toArray(), [
                'id' => $this->getId(),
            ]);
    }

    /**
     * Undocumented function
     *
     * @param Medoo $db
     * @return void
     */
    public function delete()
    {
        DatabaseHelper::getInstance()
            ->update(static::TABLE, ['trash' => true], [
                'id' => $this->getId(),
            ]);
    }

    /**
     * Undocumented function
     *
     * @param Medoo $db
     * @return void
     */
    public function destroy()
    {
        DatabaseHelper::getInstance()
            ->delete(static::TABLE, [
                'id' => $this->getId(),
            ]);
    }
    
    public function fromArray(array $arr)
    {
        foreach ($arr as $f => $v) {
            if (property_exists($this, $f)) {
                $this->$f = $v;
            }
        }
    }
}
