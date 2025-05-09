<?php

namespace WechatWorkJssdkBundle\Tests\Semantics;

use PHPUnit\Framework\TestCase;
use WechatWorkJssdkBundle\Semantics\EmailAddress;
use WechatWorkJssdkBundle\Semantics\PhoneNumber;
use WechatWorkJssdkBundle\Semantics\RedPacket;

class SemanticsTest extends TestCase
{
    public function testPhoneNumber(): void
    {
        $phoneNumber = new PhoneNumber();
        
        // 验证标题和值
        $this->assertEquals('手机号', $phoneNumber->getTitle());
        $this->assertIsInt($phoneNumber->getValue());
    }

    public function testEmailAddress(): void
    {
        $emailAddress = new EmailAddress();
        
        // 验证标题和值
        $this->assertEquals('邮箱地址', $emailAddress->getTitle());
        $this->assertIsInt($emailAddress->getValue());
    }

    public function testRedPacket(): void
    {
        $redPacket = new RedPacket();
        
        // 验证标题和值
        $this->assertEquals('红包', $redPacket->getTitle());
        $this->assertIsInt($redPacket->getValue());
    }

    // 由于SemanticsList需要依赖注入tagged services，这个测试需要在集成测试中完成
    // 在单元测试中不能直接测试
} 