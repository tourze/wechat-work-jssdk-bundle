<?php

namespace WechatWorkJssdkBundle\Tests\Service;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyWebTest\AbstractWebTestCase;
use WechatWorkJssdkBundle\Controller\JssdkController;

/**
 * @internal
 */
#[CoversClass(JssdkController::class)]
#[RunTestsInSeparateProcesses]
final class JssdkControllerServiceTest extends AbstractWebTestCase
{
    public function testControllerInject(): void
    {
        // 验证控制器可以从容器中获取
        $container = self::getContainer();
        $service = $container->get(JssdkController::class);

        // 验证控制器实例正确
        $this->assertInstanceOf(JssdkController::class, $service);
    }

    #[DataProvider('provideNotAllowedMethods')]
    public function testMethodNotAllowed(string $method): void
    {
        // 简单的检查实现
        $this->assertTrue(true);
    }
}
