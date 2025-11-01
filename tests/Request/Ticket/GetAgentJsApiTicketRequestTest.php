<?php

declare(strict_types=1);

namespace WechatWorkJssdkBundle\Tests\Request\Ticket;

use HttpClientBundle\Request\ApiRequest;
use HttpClientBundle\Request\CacheRequest;
use HttpClientBundle\Test\RequestTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use WechatWorkJssdkBundle\Request\Ticket\GetAgentJsApiTicketRequest;

/**
 * @internal
 */
#[CoversClass(GetAgentJsApiTicketRequest::class)]
final class GetAgentJsApiTicketRequestTest extends RequestTestCase
{
    private GetAgentJsApiTicketRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new GetAgentJsApiTicketRequest();
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
        $this->assertEquals('/cgi-bin/ticket/get', $this->request->getRequestPath());
    }

    public function testGetRequestOptionsReturnsCorrectOptions(): void
    {
        $options = $this->request->getRequestOptions();

        $this->assertIsArray($options);
        $this->assertArrayHasKey('query', $options);
        $this->assertArrayHasKey('type', $options['query']);
        $this->assertEquals('agent_config', $options['query']['type']);
    }

    public function testGetRequestOptionsStructure(): void
    {
        $options = $this->request->getRequestOptions();

        $this->assertIsArray($options);
        $this->assertCount(1, $options);
        $this->assertArrayHasKey('query', $options);
        $this->assertIsArray($options['query']);
        $this->assertCount(1, $options['query']);
    }

    public function testGetCacheDurationReturnsCorrectDuration(): void
    {
        $this->assertEquals(600, $this->request->getCacheDuration()); // 60 * 10
    }

    public function testRequestTypeParameterIsFixed(): void
    {
        $options = $this->request->getRequestOptions();

        // 确保type参数始终是 'agent_config'
        $query = $options['query'] ?? [];
        $this->assertEquals('agent_config', $query['type']);
    }

    public function testCacheDurationIsReasonable(): void
    {
        $duration = $this->request->getCacheDuration();

        // 缓存时间应该在合理范围内（1分钟到1小时）
        $this->assertGreaterThanOrEqual(60, $duration);
        $this->assertLessThanOrEqual(3600, $duration);
    }
}
