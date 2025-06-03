<?php

namespace WechatWorkJssdkBundle\Tests\Semantics;

use PHPUnit\Framework\TestCase;
use WechatWorkJssdkBundle\Semantics\PhoneNumber;
use WechatWorkJssdkBundle\Semantics\SemanticsInterface;

class PhoneNumberTest extends TestCase
{
    private PhoneNumber $phoneNumber;

    protected function setUp(): void
    {
        $this->phoneNumber = new PhoneNumber();
    }

    public function test_implements_semantics_interface(): void
    {
        $this->assertInstanceOf(SemanticsInterface::class, $this->phoneNumber);
    }

    public function test_getValue_returns_correct_value(): void
    {
        $this->assertEquals(1, $this->phoneNumber->getValue());
    }

    public function test_getTitle_returns_correct_title(): void
    {
        $this->assertEquals('手机号', $this->phoneNumber->getTitle());
    }

    public function test_getValue_returns_integer(): void
    {
        $this->assertIsInt($this->phoneNumber->getValue());
    }

    public function test_getTitle_returns_string(): void
    {
        $this->assertIsString($this->phoneNumber->getTitle());
    }

    public function test_getValue_is_consistent(): void
    {
        $firstCall = $this->phoneNumber->getValue();
        $secondCall = $this->phoneNumber->getValue();
        
        $this->assertEquals($firstCall, $secondCall);
    }

    public function test_getTitle_is_consistent(): void
    {
        $firstCall = $this->phoneNumber->getTitle();
        $secondCall = $this->phoneNumber->getTitle();
        
        $this->assertEquals($firstCall, $secondCall);
    }

    public function test_multiple_instances_return_same_values(): void
    {
        $anotherPhoneNumber = new PhoneNumber();
        
        $this->assertEquals($this->phoneNumber->getValue(), $anotherPhoneNumber->getValue());
        $this->assertEquals($this->phoneNumber->getTitle(), $anotherPhoneNumber->getTitle());
    }
} 