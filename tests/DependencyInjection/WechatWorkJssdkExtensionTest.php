<?php

namespace WechatWorkJssdkBundle\Tests\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use WechatWorkJssdkBundle\DependencyInjection\WechatWorkJssdkExtension;

class WechatWorkJssdkExtensionTest extends TestCase
{
    private ContainerBuilder $container;
    private WechatWorkJssdkExtension $extension;

    protected function setUp(): void
    {
        $this->container = new ContainerBuilder();
        $this->extension = new WechatWorkJssdkExtension();
    }

    public function testLoadExtension(): void
    {
        $this->extension->load([], $this->container);

        // 验证服务定义是否正确加载
        $this->assertTrue(
            $this->container->hasDefinition('WechatWorkJssdkBundle\Procedure\GetWechatWorkJssdkConfig') ||
            $this->container->hasAlias('WechatWorkJssdkBundle\Procedure\GetWechatWorkJssdkConfig')
        );
    }

    public function testServiceDefinition(): void
    {
        $this->extension->load([], $this->container);

        $procedureDefinition = $this->container->getDefinition('WechatWorkJssdkBundle\Procedure\GetWechatWorkJssdkConfig');

        // 验证服务是否是自动装配的
        $this->assertTrue($procedureDefinition->isAutowired());

        // 验证服务是否是自动配置的
        $this->assertTrue($procedureDefinition->isAutoconfigured());
    }
}
