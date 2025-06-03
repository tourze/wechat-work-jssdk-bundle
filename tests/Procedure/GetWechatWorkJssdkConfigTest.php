<?php

namespace WechatWorkJssdkBundle\Tests\Procedure;

use PHPUnit\Framework\TestCase;
use Tourze\JsonRPCLockBundle\Procedure\LockableProcedure;
use WechatWorkJssdkBundle\Procedure\GetWechatWorkJssdkConfig;

class GetWechatWorkJssdkConfigTest extends TestCase
{
    public function test_extends_lockable_procedure(): void
    {
        $reflection = new \ReflectionClass(GetWechatWorkJssdkConfig::class);
        
        $this->assertTrue($reflection->isSubclassOf(LockableProcedure::class));
    }

    public function test_has_required_properties(): void
    {
        $reflection = new \ReflectionClass(GetWechatWorkJssdkConfig::class);
        
        $this->assertTrue($reflection->hasProperty('corpId'));
        $this->assertTrue($reflection->hasProperty('agentId'));
        $this->assertTrue($reflection->hasProperty('url'));
        
        // 检查属性的可见性
        $corpIdProperty = $reflection->getProperty('corpId');
        $agentIdProperty = $reflection->getProperty('agentId');
        $urlProperty = $reflection->getProperty('url');
        
        $this->assertTrue($corpIdProperty->isPublic());
        $this->assertTrue($agentIdProperty->isPublic());
        $this->assertTrue($urlProperty->isPublic());
    }

    public function test_has_execute_method(): void
    {
        $reflection = new \ReflectionClass(GetWechatWorkJssdkConfig::class);
        
        $this->assertTrue($reflection->hasMethod('execute'));
        
        $method = $reflection->getMethod('execute');
        $this->assertTrue($method->isPublic());
    }

    public function test_constructor_has_correct_parameters(): void
    {
        $reflection = new \ReflectionClass(GetWechatWorkJssdkConfig::class);
        $constructor = $reflection->getConstructor();
        
        $this->assertNotNull($constructor);
        $this->assertCount(3, $constructor->getParameters());
        
        $parameters = $constructor->getParameters();
        $this->assertEquals('corpRepository', $parameters[0]->getName());
        $this->assertEquals('agentRepository', $parameters[1]->getName());
        $this->assertEquals('workService', $parameters[2]->getName());
    }
} 