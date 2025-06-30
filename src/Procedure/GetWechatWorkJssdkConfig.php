<?php

namespace WechatWorkJssdkBundle\Procedure;

use Carbon\CarbonImmutable;
use Tourze\JsonRPC\Core\Attribute\MethodDoc;
use Tourze\JsonRPC\Core\Attribute\MethodExpose;
use Tourze\JsonRPC\Core\Attribute\MethodParam;
use Tourze\JsonRPC\Core\Attribute\MethodTag;
use Tourze\JsonRPC\Core\Exception\ApiException;
use Tourze\JsonRPCLockBundle\Procedure\LockableProcedure;
use WechatWorkBundle\Repository\AgentRepository;
use WechatWorkBundle\Repository\CorpRepository;
use WechatWorkBundle\Service\WorkService;
use WechatWorkJssdkBundle\Request\Ticket\GetAgentJsApiTicketRequest;
use WechatWorkJssdkBundle\Request\Ticket\GetCorpJsApiTicketRequest;

/**
 * @see https://developer.work.weixin.qq.com/document/path/90506
 */
#[MethodTag(name: '企业微信')]
#[MethodDoc(summary: '(企业)获取config接口注入权限验证配置')]
#[MethodExpose(method: 'GetWechatWorkJssdkConfig')]
class GetWechatWorkJssdkConfig extends LockableProcedure
{
    #[MethodParam(description: '企业ID')]
    public string $corpId;

    #[MethodParam(description: '应用ID')]
    public string $agentId;

    #[MethodParam(description: '当前网页的URL， 不包含#及其后面部分')]
    public string $url;

    public function __construct(
        private readonly CorpRepository $corpRepository,
        private readonly AgentRepository $agentRepository,
        private readonly WorkService $workService,
    ) {
    }

    public function execute(): array
    {
        $corp = $this->corpRepository->findOneBy([
            'corpId' => $this->corpId,
        ]);
        if ($corp === null) {
            throw new ApiException('找不到企业信息');
        }

        $agent = $this->agentRepository->findOneBy([
            'corp' => $corp,
            'agentId' => $this->agentId,
        ]);
        if ($agent === null) {
            throw new ApiException('找不到应用信息');
        }

        $noncestr = uniqid();
        $timestamp = CarbonImmutable::now()->getTimestamp();

        $request = new GetCorpJsApiTicketRequest();
        $request->setAgent($agent);
        $response = $this->workService->request($request);
        $ticket = $response['ticket'];

        $signStr = "jsapi_ticket={$ticket}&noncestr={$noncestr}&timestamp={$timestamp}&url={$this->url}";
        $signature = sha1($signStr);
        $corpConfig = [
            'beta' => true, // 必须这么写，否则wx.invoke调用形式的jsapi会有问题
            'appId' => $agent->getCorp()->getCorpId(),
            'timestamp' => $timestamp,
            'nonceStr' => $noncestr,
            'signature' => $signature,
        ];

        $request = new GetAgentJsApiTicketRequest();
        $request->setAgent($agent);
        $response = $this->workService->request($request);
        $ticket = $response['ticket'];

        $signStr = "jsapi_ticket={$ticket}&noncestr={$noncestr}&timestamp={$timestamp}&url={$this->url}";
        $signature = sha1($signStr);
        $agentConfig = [
            'corpid' => $agent->getCorp()->getCorpId(),
            'agentid' => $agent->getAgentId(),
            'timestamp' => $timestamp,
            'nonceStr' => $noncestr,
            'signature' => $signature,
        ];

        return [
            'corp' => $corpConfig,
            'agent' => $agentConfig,
        ];
    }
}
