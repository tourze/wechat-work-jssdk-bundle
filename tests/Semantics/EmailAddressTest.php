<?php

namespace WechatWorkJssdkBundle\Tests\Semantics;

use PHPUnit\Framework\TestCase;
use WechatWorkJssdkBundle\Semantics\EmailAddress;
use WechatWorkJssdkBundle\Semantics\SemanticsInterface;

class EmailAddressTest extends TestCase
{
    private EmailAddress $emailAddress;

    protected function setUp(): void
    {
        $this->emailAddress = new EmailAddress();
    }

    public function test_implements_semantics_interface(): void
    {
        $this->assertInstanceOf(SemanticsInterface::class, $this->emailAddress);
    }

    public function test_getValue_returns_correct_value(): void
    {
        $this->assertEquals(2, $this->emailAddress->getValue());
    }

    public function test_getTitle_returns_correct_title(): void
    {
        $this->assertEquals('邮箱地址', $this->emailAddress->getTitle());
    }

    public function test_getValue_returns_integer(): void
    {
        $this->assertIsInt($this->emailAddress->getValue());
    }

    public function test_getTitle_returns_string(): void
    {
        $this->assertIsString($this->emailAddress->getTitle());
    }

    public function test_getValue_is_consistent(): void
    {
        $firstCall = $this->emailAddress->getValue();
        $secondCall = $this->emailAddress->getValue();
        
        $this->assertEquals($firstCall, $secondCall);
    }

    public function test_getTitle_is_consistent(): void
    {
        $firstCall = $this->emailAddress->getTitle();
        $secondCall = $this->emailAddress->getTitle();
        
        $this->assertEquals($firstCall, $secondCall);
    }

    public function test_multiple_instances_return_same_values(): void
    {
        $anotherEmailAddress = new EmailAddress();
        
        $this->assertEquals($this->emailAddress->getValue(), $anotherEmailAddress->getValue());
        $this->assertEquals($this->emailAddress->getTitle(), $anotherEmailAddress->getTitle());
    }
} 