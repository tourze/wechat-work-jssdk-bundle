<?php

namespace WechatWorkJssdkBundle\Controller;

use Doctrine\Common\Collections\Criteria;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Tourze\WechatWorkContracts\AgentInterface;
use WechatWorkBundle\Repository\AgentRepository;
use WechatWorkBundle\Repository\CorpRepository;
use WechatWorkBundle\Service\WorkService;
use WechatWorkJssdkBundle\Request\Session\GetLaunchCodeRequest;

class LaunchCodeController extends AbstractController
{
    public function __construct(
        private readonly CorpRepository $corpRepository,
        private readonly AgentRepository $agentRepository,
        private readonly WorkService $workService,
    ) {
    }

    #[Route(path: '/wechat/work/test/launch-code/{name}')]
    public function __invoke(string $name, Request $request): Response
    {
        $agent = $this->getAgent($request);

        $launchCodeRequest = new GetLaunchCodeRequest();
        $launchCodeRequest->setAgent($agent);
        $launchCodeRequest->setOperatorUserId('dev@gzcrm.cn');
        $launchCodeRequest->setSingleChat([
            'userid' => $name,
        ]);
        $response = $this->workService->request($launchCodeRequest);

        return new Response("wxwork://launch?launch_code={$response['launch_code']}");
    }

    protected function getAgent(Request $request): ?AgentInterface
    {
        $corp = $this->corpRepository->find($request->query->get('corpId'));
        if ($corp === null) {
            $corp = $this->corpRepository->findOneBy([
                'corpId' => $request->query->get('corpId'),
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
        ], ['id' => Criteria::ASC]);
    }
}