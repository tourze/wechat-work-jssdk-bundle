<?php

namespace WechatWorkJssdkBundle\Tests\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use WechatWorkJssdkBundle\DependencyInjection\WechatWorkJssdkExtension;

class WechatWorkJssdkExtensionTest extends TestCase
{
    private WechatWorkJssdkExtension $extension;
    private ContainerBuilder $container;

    protected function setUp(): void
    {
        $this->extension = new WechatWorkJssdkExtension();
        $this->container = new ContainerBuilder();
    }

    public function test_implements_extension_interface(): void
    {
        $this->assertInstanceOf(ExtensionInterface::class, $this->extension);
    }

    public function test_load_with_empty_config(): void
    {
        $this->extension->load([], $this->container);
        
        // 应该能正常加载而不抛出异常
        $this->assertTrue(true);
    }

    public function test_load_services_configuration(): void
    {
        $this->extension->load([], $this->container);
        
        // 检查是否有服务定义被加载
        $this->assertGreaterThan(0, count($this->container->getDefinitions()));
    }

    public function test_get_alias(): void
    {
        $this->assertEquals('wechat_work_jssdk', $this->extension->getAlias());
    }

    public function test_container_compilation(): void
    {
        $this->extension->load([], $this->container);
        
        // 应该能正常编译而不抛出异常
        $this->container->compile();
        
        $this->assertTrue($this->container->isCompiled());
    }
} 