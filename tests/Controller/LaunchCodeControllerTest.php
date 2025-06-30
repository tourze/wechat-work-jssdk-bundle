<?php

namespace WechatWorkJssdkBundle\Tests\Controller;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tourze\WechatWorkContracts\AgentInterface;
use Tourze\WechatWorkContracts\CorpInterface;
use WechatWorkBundle\Repository\AgentRepository;
use WechatWorkBundle\Repository\CorpRepository;
use WechatWorkBundle\Service\WorkService;
use WechatWorkJssdkBundle\Controller\LaunchCodeController;
use WechatWorkJssdkBundle\Request\Session\GetLaunchCodeRequest;

class LaunchCodeControllerTest extends TestCase
{
    private LaunchCodeController $controller;
    /** @var CorpRepository&MockObject */
    private CorpRepository $corpRepository;
    /** @var AgentRepository&MockObject */
    private AgentRepository $agentRepository;
    /** @var WorkService&MockObject */
    private WorkService $workService;

    protected function setUp(): void
    {
        $this->corpRepository = $this->createMock(CorpRepository::class);
        $this->agentRepository = $this->createMock(AgentRepository::class);
        $this->workService = $this->createMock(WorkService::class);

        $this->controller = new LaunchCodeController(
            $this->corpRepository,
            $this->agentRepository,
            $this->workService
        );
    }

    public function test_invoke_returns_launch_code_response(): void
    {
        $request = new Request();
        $request->query->set('corpId', 'test-corp-id');
        $request->query->set('agentId', 'test-agent-id');

        $corp = $this->createMock(CorpInterface::class);
        $agent = $this->createMock(AgentInterface::class);

        $this->corpRepository->expects($this->once())
            ->method('find')
            ->with('test-corp-id')
            ->willReturn($corp);

        $this->agentRepository->expects($this->once())
            ->method('findOneBy')
            ->with([
                'corp' => $corp,
                'agentId' => 'test-agent-id',
            ])
            ->willReturn($agent);

        $this->workService->expects($this->once())
            ->method('request')
            ->with($this->isInstanceOf(GetLaunchCodeRequest::class))
            ->willReturn(['launch_code' => 'test-launch-code']);

        $response = $this->controller->__invoke('test-user', $request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertSame('wxwork://launch?launch_code=test-launch-code', $response->getContent());
    }

    public function test_invoke_with_no_agent_id_gets_first_agent(): void
    {
        $request = new Request();
        $request->query->set('corpId', 'test-corp-id');

        $corp = $this->createMock(CorpInterface::class);
        $agent = $this->createMock(AgentInterface::class);

        $this->corpRepository->expects($this->once())
            ->method('find')
            ->with('test-corp-id')
            ->willReturn($corp);

        $this->agentRepository->expects($this->once())
            ->method('findOneBy')
            ->with(
                ['corp' => $corp],
                ['id' => 'ASC']
            )
            ->willReturn($agent);

        $this->workService->expects($this->once())
            ->method('request')
            ->with($this->isInstanceOf(GetLaunchCodeRequest::class))
            ->willReturn(['launch_code' => 'test-launch-code']);

        $response = $this->controller->__invoke('test-user', $request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertSame('wxwork://launch?launch_code=test-launch-code', $response->getContent());
    }

    public function test_invoke_fallback_to_find_by_corp_id(): void
    {
        $request = new Request();
        $request->query->set('corpId', 'test-corp-id');
        $request->query->set('agentId', 'test-agent-id');

        $corp = $this->createMock(CorpInterface::class);
        $agent = $this->createMock(AgentInterface::class);

        $this->corpRepository->expects($this->once())
            ->method('find')
            ->with('test-corp-id')
            ->willReturn(null);

        $this->corpRepository->expects($this->once())
            ->method('findOneBy')
            ->with(['corpId' => 'test-corp-id'])
            ->willReturn($corp);

        $this->agentRepository->expects($this->once())
            ->method('findOneBy')
            ->with([
                'corp' => $corp,
                'agentId' => 'test-agent-id',
            ])
            ->willReturn($agent);

        $this->workService->expects($this->once())
            ->method('request')
            ->with($this->isInstanceOf(GetLaunchCodeRequest::class))
            ->willReturn(['launch_code' => 'test-launch-code']);

        $response = $this->controller->__invoke('test-user', $request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertSame('wxwork://launch?launch_code=test-launch-code', $response->getContent());
    }
}