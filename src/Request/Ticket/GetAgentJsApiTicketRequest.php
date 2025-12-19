<?php

declare(strict_types=1);

namespace WechatWorkJssdkBundle\Request\Ticket;

use HttpClientBundle\Request\ApiRequest;
use HttpClientBundle\Request\CacheRequest;
use WechatWorkBundle\Request\AgentAware;
use WechatWorkJssdkBundle\Exception\AgentNotSetException;

/**
 * 获取应用的jsapi_ticket
 *
 * 应用的jsapi_ticket用于计算agentConfig（参见“通过agentConfig注入应用的权限”）的签名，签名计算方法与上述介绍的config的签名算法完全相同，但需要注意以下区别：
 * 1. 签名的jsapi_ticket必须使用以下接口获取。且必须用wx.agentConfig中的agentid对应的应用去获取access_token。
 * 2. 签名用的noncestr和timestamp必须与wx.agentConfig中的nonceStr和timestamp相同。
 *
 * 正常情况下，应用的jsapi_ticket的有效期为7200秒，通过access_token来获取。由于获取jsapi_ticket的api调用次数非常有限（一小时内，每个应用不能超过100次），频繁刷新jsapi_ticket会导致api调用受限，影响自身业务，开发者必须在自己的服务全局缓存应用的jsapi_ticket。
 *
 * config注入的是企业的身份与权限，而agentConfig注入的是应用的身份与权限。
 * 尤其是当调用者为第三方服务商时，通过config无法准确区分出调用者是哪个第三方应用，而在部分场景下，又必须严谨区分出第三方应用的身份，此时即需要通过agentConfig来注入应用的身份信息。
 *
 * 解释：
 * 企业的身份与权限：用于帮助企业微信客户端了解当前是 哪个企业 正在申请接口调用权限
 * 应用的身份与权限：用于帮助企业微信客户端了解当前是 哪个第三方应用 正在申请接口调用权限
 *
 * @see https://developer.work.weixin.qq.com/document/path/90506
 * @see https://developer.work.weixin.qq.com/document/14932 通过agentConfig注入应用的权限
 */
final class GetAgentJsApiTicketRequest extends ApiRequest implements CacheRequest
{
    use AgentAware;

    public function getRequestPath(): string
    {
        return '/cgi-bin/ticket/get';
    }

    /**
     * @return array{query: array{type: 'agent_config'}}
     */
    public function getRequestOptions(): array
    {
        return [
            'query' => [
                'type' => 'agent_config',
            ],
        ];
    }

    public function getCacheKey(): string
    {
        $agent = $this->getAgent();
        if (null === $agent) {
            throw new AgentNotSetException('Agent is not set');
        }

        return "GetWechatWorkJssdkConfig-agent-{$agent->getAgentId()}";
    }

    public function getCacheDuration(): int
    {
        return 60 * 10;
    }
}
