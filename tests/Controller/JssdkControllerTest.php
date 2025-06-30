<?php

namespace WechatWorkJssdkBundle\Tests\Controller;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Twig\Loader\ArrayLoader;
use WechatWorkJssdkBundle\Controller\JssdkController;

class JssdkControllerTest extends TestCase
{
    public function test_invoke_returns_response(): void
    {
        $twig = new Environment(new ArrayLoader([
            '@WechatWorkJssdk/demo.html.twig' => '<html><body>Demo content</body></html>'
        ]));
        
        $container = new Container();
        $container->set('twig', $twig);
        
        $controller = new JssdkController();
        $controller->setContainer($container);
        
        $response = $controller->__invoke();
        
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('Demo content', $response->getContent());
    }
}