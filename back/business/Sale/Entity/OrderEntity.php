<?php

namespace Business\Sale\Entity;

use Business\Register\Repository\CustomerRepository;
use Business\Sale\Constant\OrderTypeConstant;
use Helpers\BooleanHelper;
use Helpers\DateHelper;
use Helpers\EntityHelper;
use Helpers\NumberHelper;
use Helpers\StringHelper;

class OrderEntity extends EntityHelper
{
    const TABLE = 'orders';

    protected $id;
    protected $customer_id;
    protected $type;
    protected $total;
    protected $cost;
    protected $fee;
    protected $profit;
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
    public function getCustomerId()
    {
        return $this->customer_id;
    }
    public function setCustomerId($customerId)
    {
        $this->customer_id = StringHelper::null($customerId);

        return $this;
    }
    public function getType($text = false)
    {
        if ($text && !is_null($this->type)) {
            return OrderTypeConstant::getOption($this->type);
        }
        return $this->type;
    }
    public function setType($type)
    {
        $this->type = StringHelper::null($type);

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
    public function getProfit($format = false)
    {
        if ($format && !is_null($this->profit)) {
            return number_format($this->profit, 2, ',', '.');
        }
        return $this->profit;
    }
    public function setProfit($profit)
    {
        $this->profit = NumberHelper::doubleNull($profit);

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
            'customer_id' => $this->getCustomerId(),
            'type' => $this->getType(),
            'total' => $this->getTotal(),
            'cost' => $this->getCost(),
            'fee' => $this->getFee(),
            'profit' => $this->getProfit(),
            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getUpdatedAt(),
            'trash' => $this->getTrash(),
        ];
    }

    /**
     * Undocumented variable
     *
     * @var CustomerEntity
     */
    private $customer;

    /**
     * Get undocumented variable
     *
     * @return  CustomerEntity
     */
    public function getCustomer()
    {
        if (is_null($this->customer)) {
            $this->customer = CustomerRepository::byId($this->customer_id);
        }
        return $this->customer;
    }
}
