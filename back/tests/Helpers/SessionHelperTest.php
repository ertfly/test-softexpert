<?php

namespace Tests\Helpers;

use Helpers\SessionHelper;
use Helpers\StringHelper;
use PHPUnit\Framework\TestCase;

class SessionHelperTest extends TestCase
{
    public function testShouldInitializeSession()
    {
        $token = StringHelper::token();
        SessionHelper::create($token);
        SessionHelper::init('app', $token);
        SessionHelper::destroy();

        $this->assertTrue(true);
    }

    public function testShouldSetDataInSession()
    {
        $token = StringHelper::token();
        SessionHelper::create($token);
        SessionHelper::init('app', $token);
        SessionHelper::data('name', 'John Doe');

        
        $test = false;
        if(SessionHelper::item('name') == 'John Doe') {
            $test = true;
        }
        $this->assertTrue($test);

        SessionHelper::destroy();
    }
}
