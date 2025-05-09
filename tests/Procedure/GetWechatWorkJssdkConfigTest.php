<?php

namespace WechatWorkJssdkBundle\Tests\Procedure;

use Carbon\Carbon;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tourze\JsonRPC\Core\Exception\ApiException;
use WechatWorkBundle\Entity\Agent;
use WechatWorkBundle\Entity\Corp;
use WechatWorkBundle\Repository\AgentRepository;
use WechatWorkBundle\Repository\CorpRepository;
use WechatWorkBundle\Service\WorkService;
use WechatWorkJssdkBundle\Procedure\GetWechatWorkJssdkConfig;
use WechatWorkJssdkBundle\Request\Ticket\GetAgentJsApiTicketRequest;
use WechatWorkJssdkBundle\Request\Ticket\GetCorpJsApiTicketRequest;

class GetWechatWorkJssdkConfigTest extends TestCase
{
    private GetWechatWorkJssdkConfig $procedure;
    private MockObject $corpRepository;
    private MockObject $agentRepository;
    private MockObject $workService;
    private MockObject $corp;
    private MockObject $agent;

    protected function setUp(): void
    {
        // 创建Mock对象
        $this->corpRepository = $this->createMock(CorpRepository::class);
        $this->agentRepository = $this->createMock(AgentRepository::class);
        $this->workService = $this->createMock(WorkService::class);
        
        // 创建被测试的过程实例
        $this->procedure = new GetWechatWorkJssdkConfig(
            $this->corpRepository,
            $this->agentRepository,
            $this->workService
        );
        
        // 设置测试参数
        $this->procedure->corpId = 'test_corp_id';
        $this->procedure->agentId = 'test_agent_id';
        $this->procedure->url = 'https://example.com/test';

        // 创建和配置Corp和Agent Mock
        $this->corp = $this->createMock(Corp::class);
        $this->corp->method('getCorpId')->willReturn('test_corp_id');
        
        $this->agent = $this->createMock(Agent::class);
        $this->agent->method('getAgentId')->willReturn('test_agent_id');
        $this->agent->method('getCorp')->willReturn($this->corp);
    }

    public function testExecute_withValidParams(): void
    {
        // 配置仓库Mock返回
        $this->corpRepository->method('findOneBy')->willReturn($this->corp);
        $this->agentRepository->method('findOneBy')->willReturn($this->agent);
        
        // 配置工作服务Mock返回
        $this->workService->expects($this->exactly(2))
            ->method('request')
            ->willReturnCallback(function($request) {
                if ($request instanceof GetCorpJsApiTicketRequest) {
                    return ['ticket' => 'corp_jsapi_ticket'];
                } elseif ($request instanceof GetAgentJsApiTicketRequest) {
                    return ['ticket' => 'agent_jsapi_ticket'];
                }
                return null;
            });

        // 固定随机数和时间戳以便于测试
        Carbon::setTestNow(Carbon::createFromTimestamp(1609459200)); // 2021-01-01 00:00:00
        
        // 执行方法
        $result = $this->procedure->execute();
        
        // 验证结果
        $this->assertIsArray($result);
        $this->assertArrayHasKey('corp', $result);
        $this->assertArrayHasKey('agent', $result);
        
        // 验证corp配置
        $this->assertArrayHasKey('beta', $result['corp']);
        $this->assertArrayHasKey('appId', $result['corp']);
        $this->assertArrayHasKey('timestamp', $result['corp']);
        $this->assertArrayHasKey('nonceStr', $result['corp']);
        $this->assertArrayHasKey('signature', $result['corp']);
        $this->assertEquals('test_corp_id', $result['corp']['appId']);
        $this->assertEquals(1609459200, $result['corp']['timestamp']);
        
        // 验证agent配置
        $this->assertArrayHasKey('corpid', $result['agent']);
        $this->assertArrayHasKey('agentid', $result['agent']);
        $this->assertArrayHasKey('timestamp', $result['agent']);
        $this->assertArrayHasKey('nonceStr', $result['agent']);
        $this->assertArrayHasKey('signature', $result['agent']);
        $this->assertEquals('test_corp_id', $result['agent']['corpid']);
        $this->assertEquals('test_agent_id', $result['agent']['agentid']);
        $this->assertEquals(1609459200, $result['agent']['timestamp']);
    }

    public function testExecute_withInvalidCorpId(): void
    {
        // 配置仓库Mock返回空Corp
        $this->corpRepository->method('findOneBy')->willReturn(null);
        
        // 期望抛出API异常
        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('找不到企业信息');
        
        // 执行方法
        $this->procedure->execute();
    }

    public function testExecute_withInvalidAgentId(): void
    {
        // 配置仓库Mock
        $this->corpRepository->method('findOneBy')->willReturn($this->corp);
        $this->agentRepository->method('findOneBy')->willReturn(null);
        
        // 期望抛出API异常
        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('找不到应用信息');
        
        // 执行方法
        $this->procedure->execute();
    }

    protected function tearDown(): void
    {
        // 清除Carbon的测试时间
        Carbon::setTestNow();
    }
} 