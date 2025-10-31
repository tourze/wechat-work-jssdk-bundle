<?php

namespace WechatWorkJssdkBundle\Tests\Semantics;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use WechatWorkJssdkBundle\Semantics\EmailAddress;
use WechatWorkJssdkBundle\Semantics\SemanticsInterface;

/**
 * @internal
 */
#[CoversClass(EmailAddress::class)]
final class EmailAddressTest extends TestCase
{
    private EmailAddress $emailAddress;

    protected function setUp(): void
    {
        parent::setUp();

        $this->emailAddress = new EmailAddress();
    }

    public function testImplementsSemanticsInterface(): void
    {
        $this->assertInstanceOf(SemanticsInterface::class, $this->emailAddress);
    }

    public function testGetValueReturnsCorrectValue(): void
    {
        $this->assertEquals(2, $this->emailAddress->getValue());
    }

    public function testGetTitleReturnsCorrectTitle(): void
    {
        $this->assertEquals('邮箱地址', $this->emailAddress->getTitle());
    }

    public function testGetValueIsConsistent(): void
    {
        $firstCall = $this->emailAddress->getValue();
        $secondCall = $this->emailAddress->getValue();

        $this->assertEquals($firstCall, $secondCall);
    }

    public function testGetTitleIsConsistent(): void
    {
        $firstCall = $this->emailAddress->getTitle();
        $secondCall = $this->emailAddress->getTitle();

        $this->assertEquals($firstCall, $secondCall);
    }

    public function testMultipleInstancesReturnSameValues(): void
    {
        $anotherEmailAddress = new EmailAddress();

        $this->assertEquals($this->emailAddress->getValue(), $anotherEmailAddress->getValue());
        $this->assertEquals($this->emailAddress->getTitle(), $anotherEmailAddress->getTitle());
    }
}
