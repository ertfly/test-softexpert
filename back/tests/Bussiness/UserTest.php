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
        $this->assertEquals($user->getId(), $checkUser->getId());
        $db->pdo->rollBack();
    }

    public function testShouldUpdateUser()
    {
        $db = DatabaseHelper::getInstance();
        $db->pdo->beginTransaction();

        $user = (new UserEntity)
            ->setFullname('Test Fullname')
            ->setEmail('test@test.com')
            ->setPass(StringHelper::password('123456'));

        $user->insert();

        $userUpdater = UserRepository::byId($user->getId());

        $userUpdater->setEmail('change@test.com');
        $userUpdater->update();

        $checkUser = UserRepository::byId($user->getId());
        $this->assertNotEquals($checkUser->getEmail(), $user->getEmail());
        $db->pdo->rollBack();
    }
}
