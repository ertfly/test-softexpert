<?php declare(strict_types=1);

namespace Tests\Helpers;

use Helpers\StringHelper;
use PHPUnit\Framework\TestCase;

class StringHelperTest extends TestCase
{
    public function testShouldIsNotNull()
    {
        $this->assertNotNull(StringHelper::null('test'));
        $this->assertNotNull(StringHelper::null(0));
        $this->assertNotNull(StringHelper::null(0.3));
        $this->assertNotNull(StringHelper::null(false));
        $this->assertNotNull(StringHelper::null(true));
    }

    public function testShouldIsNull()
    {
        $this->assertNull(StringHelper::null(''));
        $this->assertNull(StringHelper::null(null));
    }
}
