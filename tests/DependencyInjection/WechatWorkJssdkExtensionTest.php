<?php

declare(strict_types=1);

namespace WechatWorkJssdkBundle\Tests\DependencyInjection;

use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Tourze\PHPUnitSymfonyUnitTest\AbstractDependencyInjectionExtensionTestCase;
use WechatWorkJssdkBundle\DependencyInjection\WechatWorkJssdkExtension;

/**
 * @internal
 */
#[CoversClass(WechatWorkJssdkExtension::class)]
final class WechatWorkJssdkExtensionTest extends AbstractDependencyInjectionExtensionTestCase
{
    public function testImplementsExtensionInterface(): void
    {
        $extension = new WechatWorkJssdkExtension();
        $this->assertInstanceOf(ExtensionInterface::class, $extension);
    }

    public function testLoadWithEmptyConfig(): void
    {
        $container = new ContainerBuilder();
        $container->setParameter('kernel.environment', 'test');
        $extension = new WechatWorkJssdkExtension();

        $extension->load([], $container);

        // 验证容器中至少有一些服务定义被加载
        $this->assertNotEmpty($container->getDefinitions());
    }

    public function testGetAlias(): void
    {
        $extension = new WechatWorkJssdkExtension();
        $this->assertEquals('wechat_work_jssdk', $extension->getAlias());
    }

    public function testContainerCompilation(): void
    {
        $container = new ContainerBuilder();
        $container->setParameter('kernel.environment', 'test');
        $extension = new WechatWorkJssdkExtension();

        $extension->load([], $container);

        // 应该能正常编译而不抛出异常
        $container->compile();

        $this->assertTrue($container->isCompiled());
    }
}
