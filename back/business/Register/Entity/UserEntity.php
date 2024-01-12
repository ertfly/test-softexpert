<?php

namespace Business\Register\Entity;

use Helpers\DateHelper;
use Helpers\EntityHelper;
use Helpers\StringHelper;

class UserEntity extends EntityHelper
{
    const TABLE = 'users';

    protected $id;
    protected $fullname;
    protected $email;
    protected $pass;
    protected $created_at;
    protected $updated_at;

    public function setId($id)
    {
        $this->id = StringHelper::null($id);
        return $this;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getFullname($first = false)
    {
        if ($first && !is_null($this->fullname)) {
            $arr = explode(' ', $this->fullname);
            return $arr[0] ?? null;
        }
        return $this->fullname;
    }
    public function setFullname($fullname)
    {
        $this->fullname = StringHelper::null($fullname);

        return $this;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = StringHelper::null($email);

        return $this;
    }
    public function getPass()
    {
        return $this->pass;
    }
    public function setPass($pass)
    {
        $this->pass = StringHelper::null($pass);

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
    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'fullname' => $this->getFullname(),
            'email' => $this->getEmail(),
            'pass' => $this->getPass(),
            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getUpdatedAt(),
        ];
    }
}
