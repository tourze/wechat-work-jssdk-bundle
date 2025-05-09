<?php

namespace WechatWorkJssdkBundle\Tests\Enum;

use PHPUnit\Framework\TestCase;
use WechatWorkJssdkBundle\Enum\ContextEntry;

class ContextEntryTest extends TestCase
{
    public function testEnumValues(): void
    {
        // 测试所有枚举值是否存在且正确
        $this->assertEquals('contact_profile', ContextEntry::CONTACT_PROFILE->value);
        $this->assertEquals('single_chat_tools', ContextEntry::SINGLE_CHAT_TOOLS->value);
        $this->assertEquals('group_chat_tools', ContextEntry::GROUP_CHAT_TOOLS->value);
        $this->assertEquals('chat_attachment', ContextEntry::CHAT_ATTACHMENT->value);
        $this->assertEquals('single_kf_tools', ContextEntry::SINGLE_KF_TOOLS->value);
        $this->assertEquals('normal', ContextEntry::NORMAL->value);
    }

    public function testGetLabel(): void
    {
        // 测试每个枚举的标签是否正确
        $this->assertEquals('从联系人详情进入', ContextEntry::CONTACT_PROFILE->getLabel());
        $this->assertEquals('从单聊会话的工具栏进入', ContextEntry::SINGLE_CHAT_TOOLS->getLabel());
        $this->assertEquals('从群聊会话的工具栏进入', ContextEntry::GROUP_CHAT_TOOLS->getLabel());
        $this->assertEquals('从会话的聊天附件栏进入', ContextEntry::CHAT_ATTACHMENT->getLabel());
        $this->assertEquals('从微信客服的工具栏进入', ContextEntry::SINGLE_KF_TOOLS->getLabel());
        $this->assertEquals('除以上场景之外进入，例如工作台，聊天会话等', ContextEntry::NORMAL->getLabel());
    }

    public function testEnumCases(): void
    {
        // 测试获取所有枚举项
        $cases = ContextEntry::cases();
        
        $this->assertCount(6, $cases);
        $this->assertContains(ContextEntry::CONTACT_PROFILE, $cases);
        $this->assertContains(ContextEntry::SINGLE_CHAT_TOOLS, $cases);
        $this->assertContains(ContextEntry::GROUP_CHAT_TOOLS, $cases);
        $this->assertContains(ContextEntry::CHAT_ATTACHMENT, $cases);
        $this->assertContains(ContextEntry::SINGLE_KF_TOOLS, $cases);
        $this->assertContains(ContextEntry::NORMAL, $cases);
    }

    public function testSelectItems(): void
    {
        // 使用getItem方法构建类似selectItems的数据，用于测试
        $items = [];
        foreach (ContextEntry::cases() as $case) {
            $items[] = [
                'value' => $case->value,
                'label' => $case->getLabel(),
            ];
        }
        
        $this->assertCount(6, $items);
        
        // 检查第一项的结构
        $firstItem = $items[0];
        $this->assertArrayHasKey('value', $firstItem);
        $this->assertArrayHasKey('label', $firstItem);
        
        // 检查特定项的内容
        $normalItem = array_filter($items, function($item) {
            return $item['value'] === 'normal';
        });
        
        $this->assertNotEmpty($normalItem);
        $normalItem = reset($normalItem);
        $this->assertEquals('除以上场景之外进入，例如工作台，聊天会话等', $normalItem['label']);
    }
} 