<?php

namespace Tests\Bussiness;

use Business\Register\Entity\CustomerEntity;
use Business\Register\Repository\CustomerRepository;
use Helpers\DatabaseHelper;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{
    public function testShouldCreateCustomer()
    {
        $db = DatabaseHelper::getInstance();
        $db->pdo->beginTransaction();

        $customer = (new CustomerEntity)
            ->setFullname('Test Fullname')
            ->setEmail('test@test.com');

        $customer->insert();

        $checkCustomer = CustomerRepository::byId($customer->getId());
        $this->assertEquals($customer->getId(), $checkCustomer->getId());
        $db->pdo->rollBack();
    }

    public function testShouldUpdateUser()
    {
        $db = DatabaseHelper::getInstance();
        $db->pdo->beginTransaction();

        $customer = (new CustomerEntity)
            ->setFullname('Test Fullname')
            ->setEmail('test@test.com');

        $customer->insert();

        $customerUpdater = CustomerRepository::byId($customer->getId());

        $customerUpdater->setEmail('change@test.com');
        $customerUpdater->update();

        $checkUser = CustomerRepository::byId($customer->getId());
        $this->assertNotEquals($checkUser->getEmail(), $customer->getEmail());
        $db->pdo->rollBack();
    }
}
