<?php

namespace WechatWorkJssdkBundle\Tests\Procedure;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\JsonRPCLockBundle\Procedure\LockableProcedure;
use Tourze\PHPUnitJsonRPC\AbstractProcedureTestCase;
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

        // 检查构造函数参数（依赖注入）
        $constructor = $reflection->getConstructor();
        $this->assertNotNull($constructor);

        $parameters = $constructor->getParameters();
        $this->assertCount(4, $parameters);

        // 检查构造函数参数类型
        $userManagerParam = $parameters[0];
        $corpRepositoryParam = $parameters[1];
        $agentRepositoryParam = $parameters[2];
        $workServiceParam = $parameters[3];

        $this->assertEquals('userManager', $userManagerParam->getName());
        $this->assertFalse($userManagerParam->isOptional());

        $this->assertEquals('corpRepository', $corpRepositoryParam->getName());
        $this->assertTrue($corpRepositoryParam->isOptional());

        $this->assertEquals('agentRepository', $agentRepositoryParam->getName());
        $this->assertTrue($agentRepositoryParam->isOptional());

        $this->assertEquals('workService', $workServiceParam->getName());
        $this->assertTrue($workServiceParam->isOptional());
    }

    public function testHasExecuteMethod(): void
    {
        $reflection = new \ReflectionClass(GetWechatWorkJssdkConfig::class);

        $this->assertTrue($reflection->hasMethod('execute'));

        $method = $reflection->getMethod('execute');
        $this->assertTrue($method->isPublic());
    }

    public function testExecute(): void
    {
        $reflection = new \ReflectionClass(GetWechatWorkJssdkConfig::class);
        $executeMethod = $reflection->getMethod('execute');

        $this->assertTrue($executeMethod->isPublic());

        $returnType = $executeMethod->getReturnType();
        if (null !== $returnType) {
            $typeName = $returnType instanceof \ReflectionNamedType ? $returnType->getName() : (string) $returnType;
            $this->assertEquals('Tourze\JsonRPC\Core\Result\ArrayResult', $typeName);
        }

        $this->assertCount(1, $executeMethod->getParameters());
    }
}
