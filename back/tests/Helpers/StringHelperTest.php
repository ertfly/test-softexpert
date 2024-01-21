<?php declare(strict_types=1);

namespace Tests\Helpers;

use Helpers\StringHelper;
use PHPUnit\Framework\TestCase;

class StringHelperTest extends TestCase
{
    public function testShouldIsNotNull()
    {
        $this->assertNotNull(StringHelper::null('test'));
    }
}
