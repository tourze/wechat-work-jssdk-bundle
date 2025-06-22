<?php

namespace WechatWorkJssdkBundle\Tests\Semantics;

use PHPUnit\Framework\TestCase;
use WechatWorkJssdkBundle\Semantics\RedPacket;
use WechatWorkJssdkBundle\Semantics\SemanticsInterface;

class RedPacketTest extends TestCase
{
    private RedPacket $redPacket;

    protected function setUp(): void
    {
        $this->redPacket = new RedPacket();
    }

    public function test_implements_semantics_interface(): void
    {
        $this->assertInstanceOf(SemanticsInterface::class, $this->redPacket);
    }

    public function test_getValue_returns_correct_value(): void
    {
        $this->assertEquals(3, $this->redPacket->getValue());
    }

    public function test_getTitle_returns_correct_title(): void
    {
        $this->assertEquals('红包', $this->redPacket->getTitle());
    }



    public function test_getValue_is_consistent(): void
    {
        $firstCall = $this->redPacket->getValue();
        $secondCall = $this->redPacket->getValue();
        
        $this->assertEquals($firstCall, $secondCall);
    }

    public function test_getTitle_is_consistent(): void
    {
        $firstCall = $this->redPacket->getTitle();
        $secondCall = $this->redPacket->getTitle();
        
        $this->assertEquals($firstCall, $secondCall);
    }

    public function test_multiple_instances_return_same_values(): void
    {
        $anotherRedPacket = new RedPacket();
        
        $this->assertEquals($this->redPacket->getValue(), $anotherRedPacket->getValue());
        $this->assertEquals($this->redPacket->getTitle(), $anotherRedPacket->getTitle());
    }
} 