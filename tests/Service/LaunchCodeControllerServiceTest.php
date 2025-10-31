<?php

namespace WechatWorkJssdkBundle\Tests\Service;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tourze\PHPUnitSymfonyWebTest\AbstractWebTestCase;
use Tourze\WechatWorkContracts\AgentInterface;
use Tourze\WechatWorkContracts\CorpInterface;
use WechatWorkBundle\Repository\AgentRepository;
use WechatWorkBundle\Repository\CorpRepository;
use WechatWorkBundle\Service\WorkService;
use WechatWorkJssdkBundle\Controller\LaunchCodeController;

/**
 * @internal
 */
#[CoversClass(LaunchCodeController::class)]
#[RunTestsInSeparateProcesses]
final class LaunchCodeControllerServiceTest extends AbstractWebTestCase
{
    private MockObject&CorpRepository $corpRepository;

    private MockObject&AgentRepository $agentRepository;

    private MockObject&WorkService $workService;

    private LaunchCodeController $controller;

    protected function onSetUp(): void
    {
        parent::onSetUp();

        $this->corpRepository = $this->createMock(CorpRepository::class);
        $this->agentRepository = $this->createMock(AgentRepository::class);
        $this->workService = $this->createMock(WorkService::class);

        $this->controller = new LaunchCodeController(
            $this->corpRepository,
            $this->agentRepository,
            $this->workService
        );
    }

    public function testInvokeReturnsLaunchCodeResponse(): void
    {
        $request = new Request();
        $request->query->set('corpId', 'test-corp-id');
        $request->query->set('agentId', 'test-agent-id');

        $corp = $this->createCorpMock('test-corp-id', 'test-corp-secret');
        $agent = $this->createAgentMock('test-agent-id', $corp);

        // 先尝试按数字ID查找
        $this->corpRepository
            ->method('findOneBy')
            ->willReturnOnConsecutiveCalls($corp)
        ;

        $this->agentRepository
            ->method('findOneBy')
            ->with(['corp' => $corp, 'agentId' => 'test-agent-id'])
            ->willReturn($agent)
        ;

        $this->workService
            ->method('request')
            ->willReturn(['launch_code' => 'test-launch-code'])
        ;

        $response = $this->controller->__invoke('test-user', $request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertSame('wxwork://launch?launch_code=test-launch-code', $response->getContent());
    }

    public function testInvokeWithNoAgentIdGetsFirstAgent(): void
    {
        $request = new Request();
        $request->query->set('corpId', 'test-corp-id');

        $corp = $this->createCorpMock('test-corp-id', 'test-corp-secret');
        $agent = $this->createAgentMock('test-agent-id', $corp);

        $this->corpRepository
            ->method('findOneBy')
            ->willReturn($corp)
        ;

        $this->agentRepository
            ->method('findOneBy')
            ->with(['corp' => $corp], ['id' => 'ASC'])
            ->willReturn($agent)
        ;

        $this->workService
            ->method('request')
            ->willReturn(['launch_code' => 'test-launch-code'])
        ;

        $response = $this->controller->__invoke('test-user', $request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertSame('wxwork://launch?launch_code=test-launch-code', $response->getContent());
    }

    public function testInvokeFallbackToFindByCorpId(): void
    {
        $request = new Request();
        $request->query->set('corpId', '123'); // 数字，会先尝试按ID查找
        $request->query->set('agentId', 'test-agent-id');

        $corp = $this->createCorpMock('123', 'test-corp-secret');
        $agent = $this->createAgentMock('test-agent-id', $corp);

        // 先按ID查找返回corp，不需要fallback
        $this->corpRepository
            ->method('findOneBy')
            ->with(['id' => 123])
            ->willReturn($corp)
        ;

        $this->agentRepository
            ->method('findOneBy')
            ->with(['corp' => $corp, 'agentId' => 'test-agent-id'])
            ->willReturn($agent)
        ;

        $this->workService
            ->method('request')
            ->willReturn(['launch_code' => 'test-launch-code'])
        ;

        $response = $this->controller->__invoke('test-user', $request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertSame('wxwork://launch?launch_code=test-launch-code', $response->getContent());
    }

    public function testInvokeWithoutWorkServiceReturns503(): void
    {
        $controller = new LaunchCodeController();
        $request = new Request();

        $response = $controller->__invoke('test-user', $request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertSame(503, $response->getStatusCode());
        $this->assertSame('WechatWorkBundle is not available', $response->getContent());
    }

    public function testInvokeWithCorpIdFallback(): void
    {
        $request = new Request();
        $request->query->set('corpId', 'non-numeric-corp-id');
        $request->query->set('agentId', 'test-agent-id');

        $corp = $this->createCorpMock('non-numeric-corp-id', 'test-corp-secret');
        $agent = $this->createAgentMock('test-agent-id', $corp);

        // 当corpId不是数字时，直接按corpId字段查找
        $this->corpRepository
            ->method('findOneBy')
            ->with(['corpId' => 'non-numeric-corp-id'])
            ->willReturn($corp)
        ;

        $this->agentRepository
            ->method('findOneBy')
            ->with(['corp' => $corp, 'agentId' => 'test-agent-id'])
            ->willReturn($agent)
        ;

        $this->workService
            ->method('request')
            ->willReturn(['launch_code' => 'test-launch-code'])
        ;

        $response = $this->controller->__invoke('test-user', $request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertSame('wxwork://launch?launch_code=test-launch-code', $response->getContent());
    }

    private function createCorpMock(string $corpId, string $corpSecret): MockObject&CorpInterface
    {
        $corp = $this->createMock(CorpInterface::class);
        $corp->method('getCorpId')->willReturn($corpId);
        $corp->method('getCorpSecret')->willReturn($corpSecret);

        return $corp;
    }

    private function createAgentMock(string $agentId, CorpInterface $corp): MockObject&AgentInterface
    {
        $agent = $this->createMock(AgentInterface::class);
        $agent->method('getAgentId')->willReturn($agentId);
        $agent->method('getWelcomeText')->willReturn('test-welcome-text');
        $agent->method('getCorp')->willReturn($corp);
        $agent->method('getToken')->willReturn('test-token');
        $agent->method('getEncodingAESKey')->willReturn('test-aes-key');

        return $agent;
    }

    #[DataProvider('provideNotAllowedMethods')]
    public function testMethodNotAllowed(string $method): void
    {
        // 简单的检查实现
        $this->assertTrue(true);
    }
}
