<?php

namespace WechatWorkJssdkBundle\Tests\Service;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Symfony\Component\Routing\RouteCollection;
use Tourze\PHPUnitSymfonyKernelTest\AbstractIntegrationTestCase;
use WechatWorkJssdkBundle\Service\AttributeControllerLoader;

/**
 * @internal
 */
#[CoversClass(AttributeControllerLoader::class)]
#[RunTestsInSeparateProcesses]
final class AttributeControllerLoaderTest extends AbstractIntegrationTestCase
{
    protected function onSetUp(): void
    {
        // No specific setup needed
    }

    private function createLoader(): AttributeControllerLoader
    {
        return self::getService(AttributeControllerLoader::class);
    }

    public function testLoadReturnsRouteCollection(): void
    {
        $loader = $this->createLoader();
        $result = $loader->load(null);

        $this->assertInstanceOf(RouteCollection::class, $result);
        $this->assertGreaterThan(0, $result->count());
    }

    public function testAutoloadReturnsRouteCollection(): void
    {
        $loader = $this->createLoader();
        $result = $loader->autoload();

        $this->assertInstanceOf(RouteCollection::class, $result);
        $this->assertGreaterThan(0, $result->count());
    }

    public function testSupportsReturnsFalse(): void
    {
        $loader = $this->createLoader();
        $this->assertFalse($loader->supports('any-resource'));
        $this->assertFalse($loader->supports('any-resource', 'any-type'));
    }

    public function testAutoloadIncludesControllers(): void
    {
        $loader = $this->createLoader();
        $result = $loader->autoload();

        $routes = $result->all();
        $routePaths = array_map(static fn ($route) => $route->getPath(), $routes);

        $this->assertContains('/wechat/work/test/jssdk', $routePaths);
        $this->assertContains('/wechat/work/test/launch-code/{name}', $routePaths);
    }
}
