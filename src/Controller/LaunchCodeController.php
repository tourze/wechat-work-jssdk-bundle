<?php

declare(strict_types=1);

namespace WechatWorkJssdkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Tourze\WechatWorkContracts\AgentInterface;
use WechatWorkBundle\Repository\AgentRepository;
use WechatWorkBundle\Repository\CorpRepository;
use WechatWorkBundle\Service\WorkService;
use WechatWorkJssdkBundle\Request\Session\GetLaunchCodeRequest;

final class LaunchCodeController extends AbstractController
{
    public function __construct(
        private readonly ?CorpRepository $corpRepository = null,
        private readonly ?AgentRepository $agentRepository = null,
        private readonly ?WorkService $workService = null,
    ) {
    }

    #[Route(path: '/wechat/work/test/launch-code/{name}', methods: ['GET'])]
    public function __invoke(string $name, Request $request): Response
    {
        if (null === $this->workService) {
            return new Response('WechatWorkBundle is not available', 503);
        }

        $agent = $this->getAgent($request);

        $launchCodeRequest = new GetLaunchCodeRequest();
        $launchCodeRequest->setAgent($agent);
        $launchCodeRequest->setOperatorUserId('dev@gzcrm.cn');
        $launchCodeRequest->setSingleChat([
            'userid' => $name,
        ]);
        /** @var array{launch_code: string} $response */
        $response = $this->workService->request($launchCodeRequest);

        return new Response("wxwork://launch?launch_code={$response['launch_code']}");
    }

    private function getAgent(Request $request): ?AgentInterface
    {
        if (null === $this->corpRepository || null === $this->agentRepository) {
            return null;
        }

        $corpId = $request->query->get('corpId');

        // 先尝试按主键ID查找（如果是数字）
        if (is_numeric($corpId)) {
            $corp = $this->corpRepository->findOneBy(['id' => (int) $corpId]);
        } else {
            $corp = null;
        }

        // 如果按ID找不到，再按corpId字段查找
        if (null === $corp) {
            $corp = $this->corpRepository->findOneBy([
                'corpId' => $corpId,
            ]);
        }

        if ($request->query->has('agentId')) {
            return $this->agentRepository->findOneBy([
                'corp' => $corp,
                'agentId' => $request->query->get('agentId'),
            ]);
        }

        // 默认拿第一个
        return $this->agentRepository->findOneBy([
            'corp' => $corp,
        ], ['id' => 'ASC']);
    }
}
