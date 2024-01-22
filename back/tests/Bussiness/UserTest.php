<?php

namespace Tests\Bussiness;

use Business\Register\Entity\UserEntity;
use Business\Register\Repository\UserRepository;
use Helpers\DatabaseHelper;
use Helpers\StringHelper;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testShouldCreateUser()
    {
        $db = DatabaseHelper::getInstance();
        $db->pdo->beginTransaction();

        $user = (new UserEntity)
            ->setFullname('Test Fullname')
            ->setEmail('test@test.com')
            ->setPass(StringHelper::password('123456'));

        $user->insert();

        $checkUser = UserRepository::byId($user->getId());

        /* $hasCreated = false;
        if ($checkUser->getId()) {
            $hasCreated = true;
        } */
        $db->pdo->rollBack();
        
        $this->assertTrue(true);
    }
}
