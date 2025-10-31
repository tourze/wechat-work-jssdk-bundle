<?php

declare(strict_types=1);

namespace WechatWorkJssdkBundle\Enum;

use Tourze\EnumExtra\Itemable;
use Tourze\EnumExtra\ItemTrait;
use Tourze\EnumExtra\Labelable;
use Tourze\EnumExtra\Selectable;
use Tourze\EnumExtra\SelectTrait;

/**
 * H5页面的入口环境枚举
 *
 * @see https://developer.work.weixin.qq.com/document/path/94315
 */
enum ContextEntry: string implements Labelable, Itemable, Selectable
{
    use SelectTrait;
    use ItemTrait;
    case CONTACT_PROFILE = 'contact_profile';
    case SINGLE_CHAT_TOOLS = 'single_chat_tools';
    case GROUP_CHAT_TOOLS = 'group_chat_tools';
    case CHAT_ATTACHMENT = 'chat_attachment';
    case SINGLE_KF_TOOLS = 'single_kf_tools';
    case NORMAL = 'normal';

    public function getLabel(): string
    {
        return match ($this) {
            self::CONTACT_PROFILE => '从联系人详情进入',
            self::SINGLE_CHAT_TOOLS => '从单聊会话的工具栏进入',
            self::GROUP_CHAT_TOOLS => '从群聊会话的工具栏进入',
            self::CHAT_ATTACHMENT => '从会话的聊天附件栏进入',
            self::SINGLE_KF_TOOLS => '从微信客服的工具栏进入',
            self::NORMAL => '除以上场景之外进入，例如工作台，聊天会话等',
        };
    }
}
