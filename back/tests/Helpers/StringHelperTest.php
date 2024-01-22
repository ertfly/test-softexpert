<?php

namespace Tests\Helpers;

use Helpers\FormValidation\FormValidationHelper;
use Helpers\StringHelper;
use PHPUnit\Framework\TestCase;

class StringHelperTest extends TestCase
{
    public function testShouldUniqueToken()
    {
        $token1 = StringHelper::token();
        $token2 = StringHelper::token();
        $this->assertNotEquals($token1, $token2);
    }
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

    public function testShouldPasswordEqual()
    {
        $pass1 = StringHelper::password('123456');
        $pass2 = StringHelper::password('123456');
        $this->assertEquals($pass1, $pass2);
    }

    public function testShouldPasswordNotEqual()
    {
        $pass1 = StringHelper::password('123456');
        $pass2 = StringHelper::password('654321');
        $this->assertNotEquals($pass1, $pass2);
    }

    public function testShouldNewGuid()
    {
        $isGuid = false;
        if (preg_match("/^(?:\\{{0,1}(?:[0-9a-fA-F]){8}-(?:[0-9a-fA-F]){4}-(?:[0-9a-fA-F]){4}-(?:[0-9a-fA-F]){4}-(?:[0-9a-fA-F]){12}\\}{0,1})$/", StringHelper::newGuid())) {
            $isGuid = true;
        }

        $this->assertTrue($isGuid);
    }

    public function testShouldPathClass()
    {
        $this->assertEquals('Helpers\FormValidation', StringHelper::parentFolderByClass(FormValidationHelper::class));
    }

    public function testShouldRemoveInvisibleCharacters()
    {
        $this->assertEquals('test', StringHelper::removeInvisibleCharacters('te' . chr(0) . 'st'));
    }

    public function testShouldFormatCpfCnpj()
    {
        $this->assertEquals('123.456.789-01', StringHelper::formatCpfCnpj('12345678901'));
        $this->assertEquals('12.345.678/9012-34', StringHelper::formatCpfCnpj('12345678901234'));
    }

    public function testShouldUri()
    {
        $this->assertEquals('test', StringHelper::uri('test'));
        $this->assertEquals('test-test', StringHelper::uri('test test'));
        $this->assertEquals('test-test', StringHelper::uri('test-test'));
    }

    public function testShouldRemoveAccents()
    {
        $this->assertEquals('aeiou', StringHelper::removeAccents('áéíóú'));
        $this->assertEquals('aeiou', StringHelper::removeAccents('àèìòù'));
        $this->assertEquals('aeiou', StringHelper::removeAccents('âêîôû'));
        $this->assertEquals('ao', StringHelper::removeAccents('ãõ'));
        $this->assertEquals('aeiou', StringHelper::removeAccents('äëïöü'));
        $this->assertEquals('aeiou', StringHelper::removeAccents('ÁÉÍÓÚ'));
        $this->assertEquals('aeiou', StringHelper::removeAccents('ÀÈÌÒÙ'));
        $this->assertEquals('aeiou', StringHelper::removeAccents('ÂÊÎÔÛ'));
        $this->assertEquals('ao', StringHelper::removeAccents('ÃÕ'));
        $this->assertEquals('aeiou', StringHelper::removeAccents('ÄËÏÖÜ'));
    }
}
