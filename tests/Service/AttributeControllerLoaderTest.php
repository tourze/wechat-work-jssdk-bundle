<?php

namespace WechatWorkJssdkBundle\Tests\Service;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\RouteCollection;
use WechatWorkJssdkBundle\Service\AttributeControllerLoader;

class AttributeControllerLoaderTest extends TestCase
{
    private AttributeControllerLoader $loader;

    protected function setUp(): void
    {
        $this->loader = new AttributeControllerLoader();
    }

    public function test_load_returns_route_collection(): void
    {
        $result = $this->loader->load(null);

        $this->assertInstanceOf(RouteCollection::class, $result);
        $this->assertGreaterThan(0, $result->count());
    }

    public function test_autoload_returns_route_collection(): void
    {
        $result = $this->loader->autoload();

        $this->assertInstanceOf(RouteCollection::class, $result);
        $this->assertGreaterThan(0, $result->count());
    }

    public function test_supports_returns_false(): void
    {
        $this->assertFalse($this->loader->supports('any-resource'));
        $this->assertFalse($this->loader->supports('any-resource', 'any-type'));
    }

    public function test_autoload_includes_controllers(): void
    {
        $result = $this->loader->autoload();

        $routes = $result->all();
        $routePaths = array_map(static fn($route) => $route->getPath(), $routes);

        $this->assertContains('/wechat/work/test/jssdk', $routePaths);
        $this->assertContains('/wechat/work/test/launch-code/{name}', $routePaths);
    }
}