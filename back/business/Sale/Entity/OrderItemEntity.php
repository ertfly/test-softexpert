<?php

namespace Business\Sale\Entity;

use Business\Product\Entity\ProductEntity;
use Business\Product\Repository\ProductRepository;
use Business\Sale\Repository\OrderRepository;
use Helpers\BooleanHelper;
use Helpers\DateHelper;
use Helpers\EntityHelper;
use Helpers\NumberHelper;
use Helpers\StringHelper;

class OrderItemEntity extends EntityHelper
{
    const TABLE = 'order_items';

    protected $id;
    protected $order_id;
    protected $product_id;
    protected $qty;
    protected $price;
    protected $cost;
    protected $fee;
    protected $total;
    protected $total_cost;
    protected $total_fee;
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
    public function getOrderId()
    {
        return $this->order_id;
    }
    public function setOrderId($orderId)
    {
        $this->order_id = StringHelper::null($orderId);

        return $this;
    }
    public function getProductId()
    {
        return $this->product_id;
    }
    public function setProductId($productId)
    {
        $this->product_id = StringHelper::null($productId);

        return $this;
    }
    public function getQty()
    {
        if (is_null($this->qty)) {
            $this->qty = 1;
        }
        return $this->qty;
    }
    public function setQty($qty)
    {
        $this->qty = NumberHelper::intNull($qty);

        return $this;
    }
    public function getPrice($format = false)
    {
        if ($format && !is_null($this->price)) {
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
        if ($format && !is_null($this->cost)) {
            return number_format($this->cost, 2, ',', '.');
        }
        return $this->cost;
    }
    public function setCost($cost)
    {
        $this->cost = NumberHelper::doubleNull($cost);

        return $this;
    }
    public function getFee($format = false)
    {
        if ($format && !is_null($this->fee)) {
            return number_format($this->fee, 2, ',', '.');
        }
        return $this->fee;
    }
    public function setFee($fee)
    {
        $this->fee = NumberHelper::doubleNull($fee);

        return $this;
    }
    public function getTotal($format = false)
    {
        if ($format && !is_null($this->total)) {
            return number_format($this->total, 2, ',', '.');
        }
        return $this->total;
    }
    public function setTotal($total)
    {
        $this->total = NumberHelper::doubleNull($total);

        return $this;
    }
    public function getTotalCost($format = false)
    {
        if ($format && !is_null($this->total_cost)) {
            return number_format($this->total_cost, 2, ',', '.');
        }
        return $this->total_cost;
    }
    public function setTotalCost($totalCost)
    {
        $this->total_cost = NumberHelper::doubleNull($totalCost);

        return $this;
    }
    public function getTotalFee($format=false)
    {
        if($format && !is_null($this->total_fee)){
            return number_format($this->total_fee, 2, ',', '.');
        }
        return $this->total_fee;
    }
    public function setTotalFee($totalFee)
    {
        $this->total_fee = NumberHelper::doubleNull($totalFee);

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
            'order_id' => $this->getOrderId(),
            'product_id' => $this->getProductId(),
            'qty' => $this->getQty(),
            'price' => $this->getPrice(),
            'cost' => $this->getCost(),
            'fee' => $this->getFee(),
            'total' => $this->getTotal(),
            'total_cost' => $this->getTotalCost(),
            'total_fee' => $this->getTotalFee(),
            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getUpdatedAt(),
            'trash' => $this->getTrash(),
        ];
    }

    /**
     * Undocumented variable
     *
     * @var OrderEntity
     */
    private $order;

    /**
     * Get undocumented variable
     *
     * @return  OrderEntity
     */
    public function getOrder()
    {
        if (is_null($this->order)) {
            $this->order = OrderRepository::byId($this->order_id);
        }
        return $this->order;
    }

    /**
     * Undocumented variable
     *
     * @var ProductEntity
     */
    private $product;

    /**
     * Get undocumented variable
     *
     * @return  ProductEntity
     */
    public function getProduct()
    {
        if (is_null($this->product)) {
            $this->product = ProductRepository::byId($this->product_id);
        }
        return $this->product;
    }
}
