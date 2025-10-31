<?php

declare(strict_types=1);

namespace WechatWorkJssdkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class JssdkController extends AbstractController
{
    #[Route(path: '/wechat/work/test/jssdk', methods: ['GET'])]
    public function __invoke(): Response
    {
        return $this->render('@WechatWorkJssdk/demo.html.twig');
    }
}
