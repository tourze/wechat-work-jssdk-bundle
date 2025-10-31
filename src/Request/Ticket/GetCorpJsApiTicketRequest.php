<?php

declare(strict_types=1);

namespace WechatWorkJssdkBundle\Request\Ticket;

use HttpClientBundle\Request\ApiRequest;
use HttpClientBundle\Request\CacheRequest;
use WechatWorkBundle\Request\AgentAware;
use WechatWorkJssdkBundle\Exception\AgentNotSetException;

/**
 * 获取企业的jsapi_ticket
 *
 * 生成签名之前必须先了解一下jsapi_ticket，jsapi_ticket是H5应用调用企业微信JS接口的临时票据。
 * 正常情况下，jsapi_ticket的有效期为7200秒，通过access_token来获取。
 * 由于获取jsapi_ticket的api调用次数非常有限（一小时内，一个企业最多可获取400次，且单个应用不能超过100次），频繁刷新jsapi_ticket会导致api调用受限，影响自身业务，开发者必须在自己的服务全局缓存jsapi_ticket。
 *
 * @see https://developer.work.weixin.qq.com/document/path/90506
 */
class GetCorpJsApiTicketRequest extends ApiRequest implements CacheRequest
{
    use AgentAware;

    public function getRequestPath(): string
    {
        return '/cgi-bin/get_jsapi_ticket';
    }

    /**
     * @return array<string, mixed>
     */
    public function getRequestOptions(): array
    {
        return [];
    }

    public function getCacheKey(): string
    {
        $agent = $this->getAgent();
        if (null === $agent) {
            throw new AgentNotSetException('Agent is not set');
        }

        return "GetWechatWorkJssdkConfig-corp-{$agent->getAgentId()}";
    }

    public function getCacheDuration(): int
    {
        return 60 * 10;
    }
}
