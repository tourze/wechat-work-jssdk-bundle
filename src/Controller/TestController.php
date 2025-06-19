<?php

namespace WechatWorkJssdkBundle\Controller;

use Doctrine\Common\Collections\Criteria;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use WechatWorkBundle\Entity\AccessTokenAware;
use WechatWorkBundle\Repository\AgentRepository;
use WechatWorkBundle\Repository\CorpRepository;
use WechatWorkBundle\Service\WorkService;
use WechatWorkJssdkBundle\Request\Session\GetLaunchCodeRequest;

#[Route(path: '/wechat/work/test')]
class TestController extends AbstractController
{
    public function __construct(
        private readonly CorpRepository $corpRepository,
        private readonly AgentRepository $agentRepository,
        private readonly WorkService $workService,
    ) {
    }

    #[Route(path: '/launch-code/{name}')]
    public function launchCode(string $name, Request $request): Response
    {
        $agent = $this->getAgent($request);

        $request = new GetLaunchCodeRequest();
        $request->setAgent($agent);
        $request->setOperatorUserId('dev@gzcrm.cn');
        $request->setSingleChat([
            'userid' => $name,
        ]);
        $response = $this->workService->request($request);

        return new Response("wxwork://launch?launch_code={$response['launch_code']}");
    }

    protected function getAgent(Request $request): AccessTokenAware
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

    #[Route(path: '/jssdk')]
    public function jssdk(): Response
    {
        return $this->render('@WechatWorkJssdk/demo.html.twig');
    }
}
