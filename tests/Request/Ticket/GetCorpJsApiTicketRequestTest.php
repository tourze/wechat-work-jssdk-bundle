<?php

namespace WechatWorkJssdkBundle\Tests\Request\Ticket;

use HttpClientBundle\Request\ApiRequest;
use HttpClientBundle\Request\CacheRequest;
use PHPUnit\Framework\TestCase;
use WechatWorkJssdkBundle\Request\Ticket\GetCorpJsApiTicketRequest;

class GetCorpJsApiTicketRequestTest extends TestCase
{
    private GetCorpJsApiTicketRequest $request;

    protected function setUp(): void
    {
        $this->request = new GetCorpJsApiTicketRequest();
    }

    public function test_extends_api_request(): void
    {
        $this->assertInstanceOf(ApiRequest::class, $this->request);
    }

    public function test_implements_cache_request(): void
    {
        $this->assertInstanceOf(CacheRequest::class, $this->request);
    }

    public function test_getRequestPath_returns_correct_path(): void
    {
        $this->assertEquals('/cgi-bin/get_jsapi_ticket', $this->request->getRequestPath());
    }

    public function test_getRequestOptions_returns_empty_array(): void
    {
        $options = $this->request->getRequestOptions();
        
        $this->assertIsArray($options);
        $this->assertEmpty($options);
    }

    public function test_getCacheDuration_returns_correct_duration(): void
    {
        $this->assertEquals(600, $this->request->getCacheDuration()); // 60 * 10
    }


    public function test_cache_duration_is_reasonable(): void
    {
        $duration = $this->request->getCacheDuration();
        
        // 缓存时间应该在合理范围内（1分钟到1小时）
        $this->assertGreaterThanOrEqual(60, $duration);
        $this->assertLessThanOrEqual(3600, $duration);
    }

    public function test_cache_duration_matches_agent_request(): void
    {
        $agentRequest = new \WechatWorkJssdkBundle\Request\Ticket\GetAgentJsApiTicketRequest();
        
        // 两个请求的缓存时间应该相同
        $this->assertEquals($agentRequest->getCacheDuration(), $this->request->getCacheDuration());
    }
} 