<?php

declare(strict_types=1);

namespace WechatWorkJssdkBundle\Procedure;

use Carbon\CarbonImmutable;
use Tourze\JsonRPC\Core\Attribute\MethodDoc;
use Tourze\JsonRPC\Core\Attribute\MethodExpose;
use Tourze\JsonRPC\Core\Attribute\MethodTag;
use Tourze\JsonRPC\Core\Contracts\RpcParamInterface;
use Tourze\JsonRPC\Core\Result\ArrayResult;
use Tourze\JsonRPC\Core\Exception\ApiException;
use Tourze\JsonRPCLockBundle\Procedure\LockableProcedure;
use Tourze\UserServiceContracts\UserManagerInterface;
use WechatWorkBundle\Repository\AgentRepository;
use WechatWorkBundle\Repository\CorpRepository;
use WechatWorkBundle\Service\WorkService;
use WechatWorkJssdkBundle\Param\GetWechatWorkJssdkConfigParam;
use WechatWorkJssdkBundle\Request\Ticket\GetAgentJsApiTicketRequest;
use WechatWorkJssdkBundle\Request\Ticket\GetCorpJsApiTicketRequest;

/**
 * @see https://developer.work.weixin.qq.com/document/path/90506
 */
#[MethodTag(name: '企业微信')]
#[MethodDoc(summary: '(企业)获取config接口注入权限验证配置')]
#[MethodExpose(method: 'GetWechatWorkJssdkConfig')]
final class GetWechatWorkJssdkConfig extends LockableProcedure
{
    public function __construct(
        private readonly UserManagerInterface $userManager,
        private readonly ?CorpRepository $corpRepository = null,
        private readonly ?AgentRepository $agentRepository = null,
        private readonly ?WorkService $workService = null,
    ) {
    }

    /**
     * @phpstan-param GetWechatWorkJssdkConfigParam $param
     */
    public function execute(GetWechatWorkJssdkConfigParam|RpcParamInterface $param): ArrayResult
    {
        // 检查 WechatWorkBundle 是否可用
        if (null === $this->corpRepository || null === $this->agentRepository || null === $this->workService) {
            throw new ApiException('企业微信服务不可用，请检查配置');
        }

        $corp = $this->corpRepository->findOneBy([
            'corpId' => $param->corpId,
        ]);
        if (null === $corp) {
            throw new ApiException('找不到企业信息');
        }

        $agent = $this->agentRepository->findOneBy([
            'corp' => $corp,
            'agentId' => $param->agentId,
        ]);
        if (null === $agent) {
            throw new ApiException('找不到应用信息');
        }

        $noncestr = uniqid();
        $timestamp = CarbonImmutable::now()->getTimestamp();

        $request = new GetCorpJsApiTicketRequest();
        $request->setAgent($agent);
        /** @var array{ticket: string} $response */
        $response = $this->workService->request($request);
        $ticket = $response['ticket'];

        $signStr = "jsapi_ticket={$ticket}&noncestr={$noncestr}&timestamp={$timestamp}&url={$param->url}";
        $signature = sha1($signStr);
        $corpConfig = [
            'beta' => true, // 必须这么写,否则wx.invoke调用形式的jsapi会有问题
            'appId' => $corp->getCorpId(),
            'timestamp' => $timestamp,
            'nonceStr' => $noncestr,
            'signature' => $signature,
        ];

        $request = new GetAgentJsApiTicketRequest();
        $request->setAgent($agent);
        /** @var array{ticket: string} $response */
        $response = $this->workService->request($request);
        $ticket = $response['ticket'];

        $signStr = "jsapi_ticket={$ticket}&noncestr={$noncestr}&timestamp={$timestamp}&url={$param->url}";
        $signature = sha1($signStr);
        $agentConfig = [
            'corpid' => $corp->getCorpId(),
            'agentid' => $agent->getAgentId(),
            'timestamp' => $timestamp,
            'nonceStr' => $noncestr,
            'signature' => $signature,
        ];

        return new ArrayResult([
            'corp' => $corpConfig,
            'agent' => $agentConfig,
        ]);
    }
}
