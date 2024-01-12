<?php

use Business\Product\Rule\ProductCategoryRule;
use Business\Product\Rule\ProductRule;
use Business\Register\Entity\UserEntity;
use Business\Register\Repository\UserRepository;
use Business\Register\Rule\UserRule;
use Helpers\StringHelper;

UserRule::install();
ProductCategoryRule::install();
ProductRule::install();

// add user default
$fullname = 'User Test';
$email = 'test@test.com';
$pass = StringHelper::password('123456');
$user = UserRepository::byEmail($email)
    ->setFullname($fullname)
    ->setEmail($email)
    ->setPass($pass);
    
if (!$user->getId()) {
    $user->insert();
} else {
    $user->update();
}
