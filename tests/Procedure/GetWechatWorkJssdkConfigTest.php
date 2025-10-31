<?php

namespace WechatWorkJssdkBundle\Tests\Procedure;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\JsonRPC\Core\Tests\AbstractProcedureTestCase;
use Tourze\JsonRPCLockBundle\Procedure\LockableProcedure;
use WechatWorkJssdkBundle\Procedure\GetWechatWorkJssdkConfig;

/**
 * @internal
 */
#[CoversClass(GetWechatWorkJssdkConfig::class)]
#[RunTestsInSeparateProcesses]
final class GetWechatWorkJssdkConfigTest extends AbstractProcedureTestCase
{
    protected function onSetUp(): void
    {
        // 自定义初始化逻辑
    }

    public function testExtendsLockableProcedure(): void
    {
        $reflection = new \ReflectionClass(GetWechatWorkJssdkConfig::class);

        $this->assertTrue($reflection->isSubclassOf(LockableProcedure::class));
    }

    public function testHasRequiredProperties(): void
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

    public function testHasExecuteMethod(): void
    {
        $reflection = new \ReflectionClass(GetWechatWorkJssdkConfig::class);

        $this->assertTrue($reflection->hasMethod('execute'));

        $method = $reflection->getMethod('execute');
        $this->assertTrue($method->isPublic());
    }

    public function testConstructorHasCorrectParameters(): void
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

    public function testExecute(): void
    {
        $reflection = new \ReflectionClass(GetWechatWorkJssdkConfig::class);
        $executeMethod = $reflection->getMethod('execute');

        $this->assertTrue($executeMethod->isPublic());

        $returnType = $executeMethod->getReturnType();
        if (null !== $returnType) {
            $typeName = $returnType instanceof \ReflectionNamedType ? $returnType->getName() : (string) $returnType;
            $this->assertEquals('array', $typeName);
        }

        $this->assertCount(0, $executeMethod->getParameters());
    }
}
