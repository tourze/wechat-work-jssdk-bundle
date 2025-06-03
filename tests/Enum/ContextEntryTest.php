<?php

namespace WechatWorkJssdkBundle\Tests\Enum;

use PHPUnit\Framework\TestCase;
use Tourze\EnumExtra\Itemable;
use Tourze\EnumExtra\Labelable;
use Tourze\EnumExtra\Selectable;
use WechatWorkJssdkBundle\Enum\ContextEntry;

class ContextEntryTest extends TestCase
{
    public function test_implements_required_interfaces(): void
    {
        $this->assertInstanceOf(Labelable::class, ContextEntry::NORMAL);
        $this->assertInstanceOf(Itemable::class, ContextEntry::NORMAL);
        $this->assertInstanceOf(Selectable::class, ContextEntry::NORMAL);
    }

    public function test_enum_values(): void
    {
        $this->assertEquals('contact_profile', ContextEntry::CONTACT_PROFILE->value);
        $this->assertEquals('single_chat_tools', ContextEntry::SINGLE_CHAT_TOOLS->value);
        $this->assertEquals('group_chat_tools', ContextEntry::GROUP_CHAT_TOOLS->value);
        $this->assertEquals('chat_attachment', ContextEntry::CHAT_ATTACHMENT->value);
        $this->assertEquals('single_kf_tools', ContextEntry::SINGLE_KF_TOOLS->value);
        $this->assertEquals('normal', ContextEntry::NORMAL->value);
    }

    public function test_enum_labels(): void
    {
        $this->assertEquals('从联系人详情进入', ContextEntry::CONTACT_PROFILE->getLabel());
        $this->assertEquals('从单聊会话的工具栏进入', ContextEntry::SINGLE_CHAT_TOOLS->getLabel());
        $this->assertEquals('从群聊会话的工具栏进入', ContextEntry::GROUP_CHAT_TOOLS->getLabel());
        $this->assertEquals('从会话的聊天附件栏进入', ContextEntry::CHAT_ATTACHMENT->getLabel());
        $this->assertEquals('从微信客服的工具栏进入', ContextEntry::SINGLE_KF_TOOLS->getLabel());
        $this->assertEquals('除以上场景之外进入，例如工作台，聊天会话等', ContextEntry::NORMAL->getLabel());
    }

    public function test_all_cases_covered(): void
    {
        $expectedCases = [
            'CONTACT_PROFILE',
            'SINGLE_CHAT_TOOLS',
            'GROUP_CHAT_TOOLS',
            'CHAT_ATTACHMENT',
            'SINGLE_KF_TOOLS',
            'NORMAL'
        ];
        
        $actualCases = array_map(fn($case) => $case->name, ContextEntry::cases());
        
        $this->assertEquals($expectedCases, $actualCases);
        $this->assertCount(6, ContextEntry::cases());
    }

    public function test_from_string_value(): void
    {
        $this->assertEquals(ContextEntry::NORMAL, ContextEntry::from('normal'));
        $this->assertEquals(ContextEntry::CONTACT_PROFILE, ContextEntry::from('contact_profile'));
    }

    /**
     * @dataProvider invalidValueProvider
     */
    public function test_from_invalid_value_throws_exception(string $invalidValue): void
    {
        $this->expectException(\ValueError::class);
        
        ContextEntry::from($invalidValue);
    }

    public static function invalidValueProvider(): array
    {
        return [
            ['invalid'],
            [''],
            ['contact'],
            ['normal_invalid'],
        ];
    }

    public function test_tryFrom_valid_values(): void
    {
        $this->assertEquals(ContextEntry::NORMAL, ContextEntry::tryFrom('normal'));
        $this->assertEquals(ContextEntry::CONTACT_PROFILE, ContextEntry::tryFrom('contact_profile'));
    }

    public function test_tryFrom_invalid_values(): void
    {
        $this->assertNull(ContextEntry::tryFrom('invalid'));
        $this->assertNull(ContextEntry::tryFrom(''));
        $this->assertNull(ContextEntry::tryFrom('contact'));
    }
} 