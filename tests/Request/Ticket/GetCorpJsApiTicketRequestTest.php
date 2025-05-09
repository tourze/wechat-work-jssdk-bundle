<?php

namespace WechatWorkJssdkBundle\Tests\Request\Ticket;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use WechatWorkBundle\Entity\Agent;
use WechatWorkJssdkBundle\Request\Ticket\GetCorpJsApiTicketRequest;

class GetCorpJsApiTicketRequestTest extends TestCase
{
    private GetCorpJsApiTicketRequest $request;
    private MockObject $agent;

    protected function setUp(): void
    {
        $this->request = new GetCorpJsApiTicketRequest();
        
        // 创建Agent模拟对象
        $this->agent = $this->createMock(Agent::class);
        $this->agent->method('getAgentId')->willReturn('test_agent_id');
        
        // 设置Agent
        $this->request->setAgent($this->agent);
    }

    public function testGetRequestPath(): void
    {
        // 验证请求路径是否正确
        $this->assertEquals('/cgi-bin/get_jsapi_ticket', $this->request->getRequestPath());
    }

    public function testGetRequestOptions(): void
    {
        // 验证请求选项是否正确
        $options = $this->request->getRequestOptions();
        $this->assertIsArray($options);
        $this->assertEmpty($options);
    }

    public function testGetCacheKey(): void
    {
        // 验证缓存键是否包含代理ID
        $cacheKey = $this->request->getCacheKey();
        $this->assertStringContainsString('test_agent_id', $cacheKey);
        $this->assertEquals('GetWechatWorkJssdkConfig-corp-test_agent_id', $cacheKey);
    }

    public function testGetCacheDuration(): void
    {
        // 验证缓存持续时间是否正确（10分钟）
        $duration = $this->request->getCacheDuration();
        $this->assertEquals(600, $duration); // 60 * 10 = 600秒
    }
} 