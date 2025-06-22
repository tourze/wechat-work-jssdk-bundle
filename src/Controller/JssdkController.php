<?php

namespace WechatWorkJssdkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class JssdkController extends AbstractController
{
    #[Route(path: '/wechat/work/test/jssdk')]
    public function __invoke(): Response
    {
        return $this->render('@WechatWorkJssdk/demo.html.twig');
    }
}