<?php

declare(strict_types=1);

namespace WechatWorkJssdkBundle\Request\Session;

use HttpClientBundle\Request\ApiRequest;
use WechatWorkBundle\Request\AgentAware;

/**
 * 获取launch_code
 *
 * @see https://developer.work.weixin.qq.com/document/path/94346
 */
final class GetLaunchCodeRequest extends ApiRequest
{
    use AgentAware;

    /**
     * @var string 当前操作者的userid，生成的最终链接，必须是操作者打开，其他人打开是无效的
     */
    private string $operatorUserId;

    /**
     * @var array<string, string> 需要发起单聊对象的userid，仅支持企业内部成员
     */
    private array $singleChat = [];

    public function getRequestPath(): string
    {
        return '/cgi-bin/get_launch_code';
    }

    /**
     * @return array{json: array{operator_userid: string, single_chat: array<string, string>}}
     */
    public function getRequestOptions(): array
    {
        return [
            'json' => [
                'operator_userid' => $this->getOperatorUserId(),
                'single_chat' => $this->getSingleChat(),
            ],
        ];
    }

    public function getOperatorUserId(): string
    {
        return $this->operatorUserId;
    }

    public function setOperatorUserId(string $operatorUserId): void
    {
        $this->operatorUserId = $operatorUserId;
    }

    /**
     * @return array<string, string>
     */
    public function getSingleChat(): array
    {
        return $this->singleChat;
    }

    /**
     * @param array<string, string> $singleChat
     */
    public function setSingleChat(array $singleChat): void
    {
        $this->singleChat = $singleChat;
    }
}
