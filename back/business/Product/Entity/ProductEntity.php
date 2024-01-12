<?php

namespace Business\Product\Entity;

use Business\Product\Repository\ProductCategoryRepository;
use Helpers\BooleanHelper;
use Helpers\DateHelper;
use Helpers\EntityHelper;
use Helpers\NumberHelper;
use Helpers\StringHelper;

class ProductEntity extends EntityHelper
{
    const TABLE = 'products';

    protected $id;
    protected $category_id;
    protected $name;
    protected $price;
    protected $cost;
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
    public function getCategoryId()
    {
        return $this->category_id;
    }
    public function setCategoryId($categoryId)
    {
        $this->category_id = StringHelper::null($categoryId);

        return $this;
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
    public function getPrice($format = false)
    {
        if (is_null($this->price)) {
            $this->price = doubleval(0);
        }
        if ($format) {
            return number_format($this->price, 2, ',', '.');
        }
        return $this->price;
    }
    public function setPrice($price)
    {
        $this->price = NumberHelper::doubleNull($price);

        return $this;
    }
    public function getCost($format = false)
    {
        if (is_null($this->cost)) {
            $this->cost = doubleval(0);
        }
        if ($format) {
            return number_format($this->cost, 2, ',', '.');
        }
        return $this->cost;
    }
    public function setCost($cost)
    {
        $this->cost = NumberHelper::doubleNull($cost);

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
            'category_id' => $this->getCategoryId(),
            'name' => $this->getName(),
            'price' => $this->getPrice(),
            'cost' => $this->getCost(),
            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getUpdatedAt(),
            'trash' => $this->getTrash(),
        ];
    }

    /**
     * Undocumented variable
     *
     * @var ProductCategoryEntity
     */
    private $category;

    /**
     * Get undocumented variable
     *
     * @return  ProductCategoryEntity
     */
    public function getCategory()
    {
        if (is_null($this->category)) {
            $this->category = ProductCategoryRepository::byId($this->category_id);
        }
        return $this->category;
    }
}
