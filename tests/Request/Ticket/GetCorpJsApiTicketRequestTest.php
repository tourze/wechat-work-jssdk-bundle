<?php

declare(strict_types=1);

namespace WechatWorkJssdkBundle\Tests\Request\Ticket;

use HttpClientBundle\Request\ApiRequest;
use HttpClientBundle\Request\CacheRequest;
use HttpClientBundle\Tests\Request\RequestTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use WechatWorkJssdkBundle\Request\Ticket\GetAgentJsApiTicketRequest;
use WechatWorkJssdkBundle\Request\Ticket\GetCorpJsApiTicketRequest;

/**
 * @internal
 */
#[CoversClass(GetCorpJsApiTicketRequest::class)]
final class GetCorpJsApiTicketRequestTest extends RequestTestCase
{
    private GetCorpJsApiTicketRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new GetCorpJsApiTicketRequest();
    }

    public function testExtendsApiRequest(): void
    {
        $this->assertInstanceOf(ApiRequest::class, $this->request);
    }

    public function testImplementsCacheRequest(): void
    {
        $this->assertInstanceOf(CacheRequest::class, $this->request);
    }

    public function testGetRequestPathReturnsCorrectPath(): void
    {
        $this->assertEquals('/cgi-bin/get_jsapi_ticket', $this->request->getRequestPath());
    }

    public function testGetRequestOptionsReturnsEmptyArray(): void
    {
        $options = $this->request->getRequestOptions();

        $this->assertIsArray($options);
        $this->assertEmpty($options);
    }

    public function testGetCacheDurationReturnsCorrectDuration(): void
    {
        $this->assertEquals(600, $this->request->getCacheDuration()); // 60 * 10
    }

    public function testCacheDurationIsReasonable(): void
    {
        $duration = $this->request->getCacheDuration();

        // 缓存时间应该在合理范围内（1分钟到1小时）
        $this->assertGreaterThanOrEqual(60, $duration);
        $this->assertLessThanOrEqual(3600, $duration);
    }

    public function testCacheDurationMatchesAgentRequest(): void
    {
        $agentRequest = new GetAgentJsApiTicketRequest();

        // 两个请求的缓存时间应该相同
        $this->assertEquals($agentRequest->getCacheDuration(), $this->request->getCacheDuration());
    }
}
