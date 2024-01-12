<?php

namespace Business\Product\Entity;

use Helpers\BooleanHelper;
use Helpers\DateHelper;
use Helpers\EntityHelper;
use Helpers\NumberHelper;
use Helpers\StringHelper;

class ProductCategoryEntity extends EntityHelper
{
    const TABLE = 'product_categories';

    protected $id;
    protected $name;
    protected $fee;
    protected $created_at;
    protected $updated_at;
    protected $trash;

    public function setId($id)
    {
        $this->id = StringHelper::null($id);
        return $this;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = StringHelper::null($name);

        return $this;
    }
    public function getFee()
    {
        if(is_null($this->fee)){
            $this->fee = doubleval(0);
        }
        return $this->fee;
    }
    public function setFee($fee)
    {
        $this->fee = NumberHelper::doubleNull($fee);

        return $this;
    }
    public function getCreatedAt($format = false, $f = 'd/m/Y H:i:s')
    {
        if (is_null($this->created_at)) {
            $this->created_at = DateHelper::now();
        }
        if ($format) {
            return date($f, strtotime($this->created_at));
        }
        return $this->created_at;
    }
    public function setCreatedAt($createdAt)
    {
        $this->created_at = StringHelper::null($createdAt);

        return $this;
    }
    public function getUpdatedAt($format = false, $f = 'd/m/Y H:i:s')
    {
        if ($format && !is_null($this->updated_at)) {
            return date($f, strtotime($this->updated_at));
        }
        return $this->updated_at;
    }
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = StringHelper::null($updatedAt);

        return $this;
    }
    public function getTrash()
    {
        if (is_null($this->trash)) {
            $this->trash = false;
        }
        return $this->trash;
    }
    public function setTrash($trash)
    {
        $this->trash = BooleanHelper::null($trash);

        return $this;
    }
    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'fee' => $this->getFee(),
            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getUpdatedAt(),
            'trash' => $this->getTrash(),
        ];
    }
}
