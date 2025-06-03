<?php

namespace WechatWorkJssdkBundle\Tests\Controller;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use WechatWorkJssdkBundle\Controller\TestController;

class TestControllerTest extends TestCase
{
    public function test_extends_abstract_controller(): void
    {
        $reflection = new \ReflectionClass(TestController::class);
        
        $this->assertTrue($reflection->isSubclassOf(AbstractController::class));
    }

    public function test_has_route_attribute(): void
    {
        $reflection = new \ReflectionClass(TestController::class);
        $attributes = $reflection->getAttributes();
        
        $this->assertGreaterThan(0, count($attributes));
    }

    public function test_has_launch_code_method(): void
    {
        $reflection = new \ReflectionClass(TestController::class);
        
        $this->assertTrue($reflection->hasMethod('launchCode'));
        
        $method = $reflection->getMethod('launchCode');
        $this->assertTrue($method->isPublic());
        
        // 检查方法参数
        $parameters = $method->getParameters();
        $this->assertCount(2, $parameters);
        $this->assertEquals('name', $parameters[0]->getName());
        $this->assertEquals('request', $parameters[1]->getName());
    }

    public function test_has_jssdk_method(): void
    {
        $reflection = new \ReflectionClass(TestController::class);
        
        $this->assertTrue($reflection->hasMethod('jssdk'));
        
        $method = $reflection->getMethod('jssdk');
        $this->assertTrue($method->isPublic());
        $this->assertCount(0, $method->getParameters());
    }

    public function test_has_get_agent_method(): void
    {
        $reflection = new \ReflectionClass(TestController::class);
        
        $this->assertTrue($reflection->hasMethod('getAgent'));
        
        $method = $reflection->getMethod('getAgent');
        $this->assertTrue($method->isProtected());
        
        $parameters = $method->getParameters();
        $this->assertCount(1, $parameters);
        $this->assertEquals('request', $parameters[0]->getName());
    }

    public function test_constructor_has_correct_parameters(): void
    {
        $reflection = new \ReflectionClass(TestController::class);
        $constructor = $reflection->getConstructor();
        
        $this->assertNotNull($constructor);
        $this->assertCount(3, $constructor->getParameters());
        
        $parameters = $constructor->getParameters();
        $this->assertEquals('corpRepository', $parameters[0]->getName());
        $this->assertEquals('agentRepository', $parameters[1]->getName());
        $this->assertEquals('workService', $parameters[2]->getName());
    }
} 