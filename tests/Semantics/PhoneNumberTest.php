<?php

namespace WechatWorkJssdkBundle\Tests\Semantics;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use WechatWorkJssdkBundle\Semantics\PhoneNumber;
use WechatWorkJssdkBundle\Semantics\SemanticsInterface;

/**
 * @internal
 */
#[CoversClass(PhoneNumber::class)]
final class PhoneNumberTest extends TestCase
{
    private PhoneNumber $phoneNumber;

    protected function setUp(): void
    {
        parent::setUp();

        $this->phoneNumber = new PhoneNumber();
    }

    public function testImplementsSemanticsInterface(): void
    {
        $this->assertInstanceOf(SemanticsInterface::class, $this->phoneNumber);
    }

    public function testGetValueReturnsCorrectValue(): void
    {
        $this->assertEquals(1, $this->phoneNumber->getValue());
    }

    public function testGetTitleReturnsCorrectTitle(): void
    {
        $this->assertEquals('手机号', $this->phoneNumber->getTitle());
    }

    public function testGetValueIsConsistent(): void
    {
        $firstCall = $this->phoneNumber->getValue();
        $secondCall = $this->phoneNumber->getValue();

        $this->assertEquals($firstCall, $secondCall);
    }

    public function testGetTitleIsConsistent(): void
    {
        $firstCall = $this->phoneNumber->getTitle();
        $secondCall = $this->phoneNumber->getTitle();

        $this->assertEquals($firstCall, $secondCall);
    }

    public function testMultipleInstancesReturnSameValues(): void
    {
        $anotherPhoneNumber = new PhoneNumber();

        $this->assertEquals($this->phoneNumber->getValue(), $anotherPhoneNumber->getValue());
        $this->assertEquals($this->phoneNumber->getTitle(), $anotherPhoneNumber->getTitle());
    }
}
