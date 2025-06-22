<?php

namespace WechatWorkJssdkBundle\Tests\Request\Ticket;

use HttpClientBundle\Request\ApiRequest;
use HttpClientBundle\Request\CacheRequest;
use PHPUnit\Framework\TestCase;
use WechatWorkJssdkBundle\Request\Ticket\GetAgentJsApiTicketRequest;

class GetAgentJsApiTicketRequestTest extends TestCase
{
    private GetAgentJsApiTicketRequest $request;

    protected function setUp(): void
    {
        $this->request = new GetAgentJsApiTicketRequest();
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
        $this->assertEquals('/cgi-bin/ticket/get', $this->request->getRequestPath());
    }

    public function test_getRequestOptions_returns_correct_options(): void
    {
        $options = $this->request->getRequestOptions();
        
        $this->assertIsArray($options);
        $this->assertArrayHasKey('query', $options);
        $this->assertArrayHasKey('type', $options['query']);
        $this->assertEquals('agent_config', $options['query']['type']);
    }

    public function test_getRequestOptions_structure(): void
    {
        $options = $this->request->getRequestOptions();
        
        $this->assertIsArray($options);
        $this->assertCount(1, $options);
        $this->assertArrayHasKey('query', $options);
        $this->assertIsArray($options['query']);
        $this->assertCount(1, $options['query']);
    }

    public function test_getCacheDuration_returns_correct_duration(): void
    {
        $this->assertEquals(600, $this->request->getCacheDuration()); // 60 * 10
    }


    public function test_request_type_parameter_is_fixed(): void
    {
        $options = $this->request->getRequestOptions();
        
        // 确保type参数始终是 'agent_config'
        $this->assertEquals('agent_config', $options['query']['type']);
    }

    public function test_cache_duration_is_reasonable(): void
    {
        $duration = $this->request->getCacheDuration();
        
        // 缓存时间应该在合理范围内（1分钟到1小时）
        $this->assertGreaterThanOrEqual(60, $duration);
        $this->assertLessThanOrEqual(3600, $duration);
    }
} 