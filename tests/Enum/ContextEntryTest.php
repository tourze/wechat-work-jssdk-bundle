<?php

namespace WechatWorkJssdkBundle\Tests\Enum;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Tourze\EnumExtra\Itemable;
use Tourze\EnumExtra\Labelable;
use Tourze\EnumExtra\Selectable;
use Tourze\PHPUnitEnum\AbstractEnumTestCase;
use WechatWorkJssdkBundle\Enum\ContextEntry;

/**
 * @internal
 */
#[CoversClass(ContextEntry::class)]
final class ContextEntryTest extends AbstractEnumTestCase
{
    public function testImplementsRequiredInterfaces(): void
    {
        $this->assertInstanceOf(Labelable::class, ContextEntry::NORMAL);
        $this->assertInstanceOf(Itemable::class, ContextEntry::NORMAL);
        $this->assertInstanceOf(Selectable::class, ContextEntry::NORMAL);
    }

    public function testEnumValues(): void
    {
        $this->assertEquals('contact_profile', ContextEntry::CONTACT_PROFILE->value);
        $this->assertEquals('single_chat_tools', ContextEntry::SINGLE_CHAT_TOOLS->value);
        $this->assertEquals('group_chat_tools', ContextEntry::GROUP_CHAT_TOOLS->value);
        $this->assertEquals('chat_attachment', ContextEntry::CHAT_ATTACHMENT->value);
        $this->assertEquals('single_kf_tools', ContextEntry::SINGLE_KF_TOOLS->value);
        $this->assertEquals('normal', ContextEntry::NORMAL->value);
    }

    public function testEnumLabels(): void
    {
        $this->assertEquals('从联系人详情进入', ContextEntry::CONTACT_PROFILE->getLabel());
        $this->assertEquals('从单聊会话的工具栏进入', ContextEntry::SINGLE_CHAT_TOOLS->getLabel());
        $this->assertEquals('从群聊会话的工具栏进入', ContextEntry::GROUP_CHAT_TOOLS->getLabel());
        $this->assertEquals('从会话的聊天附件栏进入', ContextEntry::CHAT_ATTACHMENT->getLabel());
        $this->assertEquals('从微信客服的工具栏进入', ContextEntry::SINGLE_KF_TOOLS->getLabel());
        $this->assertEquals('除以上场景之外进入，例如工作台，聊天会话等', ContextEntry::NORMAL->getLabel());
    }

    public function testAllCasesCovered(): void
    {
        $expectedCases = [
            'CONTACT_PROFILE',
            'SINGLE_CHAT_TOOLS',
            'GROUP_CHAT_TOOLS',
            'CHAT_ATTACHMENT',
            'SINGLE_KF_TOOLS',
            'NORMAL',
        ];

        $actualCases = array_map(fn ($case) => $case->name, ContextEntry::cases());

        $this->assertEquals($expectedCases, $actualCases);
        $this->assertCount(6, ContextEntry::cases());
    }

    public function testFromStringValue(): void
    {
        $this->assertEquals(ContextEntry::NORMAL, ContextEntry::from('normal'));
        $this->assertEquals(ContextEntry::CONTACT_PROFILE, ContextEntry::from('contact_profile'));
    }

    #[DataProvider('customInvalidValueProvider')]
    public function testFromInvalidValueThrowsException(string $invalidValue): void
    {
        $this->expectException(\ValueError::class);

        ContextEntry::from($invalidValue);
    }

    /**
     * @return array<string, array<string>>
     */
    public static function customInvalidValueProvider(): array
    {
        return [
            'invalid value' => ['invalid'],
            'empty string' => [''],
            'contact value' => ['contact'],
            'normal invalid' => ['normal_invalid'],
        ];
    }

    public function testTryFromValidValues(): void
    {
        $this->assertEquals(ContextEntry::NORMAL, ContextEntry::tryFrom('normal'));
        $this->assertEquals(ContextEntry::CONTACT_PROFILE, ContextEntry::tryFrom('contact_profile'));
    }

    public function testTryFromInvalidValues(): void
    {
        $this->assertNull(ContextEntry::tryFrom('invalid'));
        $this->assertNull(ContextEntry::tryFrom(''));
        $this->assertNull(ContextEntry::tryFrom('contact'));
    }

    public function testToArray(): void
    {
        $expected = [
            'value' => 'contact_profile',
            'label' => '从联系人详情进入',
        ];
        $this->assertEquals($expected, ContextEntry::CONTACT_PROFILE->toArray());

        $expected = [
            'value' => 'single_chat_tools',
            'label' => '从单聊会话的工具栏进入',
        ];
        $this->assertEquals($expected, ContextEntry::SINGLE_CHAT_TOOLS->toArray());

        $expected = [
            'value' => 'group_chat_tools',
            'label' => '从群聊会话的工具栏进入',
        ];
        $this->assertEquals($expected, ContextEntry::GROUP_CHAT_TOOLS->toArray());

        $expected = [
            'value' => 'chat_attachment',
            'label' => '从会话的聊天附件栏进入',
        ];
        $this->assertEquals($expected, ContextEntry::CHAT_ATTACHMENT->toArray());

        $expected = [
            'value' => 'single_kf_tools',
            'label' => '从微信客服的工具栏进入',
        ];
        $this->assertEquals($expected, ContextEntry::SINGLE_KF_TOOLS->toArray());

        $expected = [
            'value' => 'normal',
            'label' => '除以上场景之外进入，例如工作台，聊天会话等',
        ];
        $this->assertEquals($expected, ContextEntry::NORMAL->toArray());
    }
}
