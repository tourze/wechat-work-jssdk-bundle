<?php

namespace WechatWorkJssdkBundle\Tests\Semantics;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyKernelTest\AbstractIntegrationTestCase;
use WechatWorkJssdkBundle\Semantics\SemanticsInterface;

/**
 * @internal
 */
#[CoversClass(SemanticsInterface::class)]
#[RunTestsInSeparateProcesses]
final class SemanticsInterfaceTest extends AbstractIntegrationTestCase
{
    protected function onSetUp(): void
    {
        // No specific setup needed for interface testing
    }

    public function testInterfaceExists(): void
    {
        $this->assertTrue(interface_exists(SemanticsInterface::class));
    }

    public function testInterfaceHasRequiredMethods(): void
    {
        $reflection = new \ReflectionClass(SemanticsInterface::class);

        $this->assertTrue($reflection->hasMethod('getValue'));
        $this->assertTrue($reflection->hasMethod('getTitle'));
    }

    public function testGetValueMethodSignature(): void
    {
        $reflection = new \ReflectionClass(SemanticsInterface::class);
        $method = $reflection->getMethod('getValue');

        $this->assertEquals('getValue', $method->getName());
        $this->assertTrue($method->isPublic());
        $this->assertFalse($method->isStatic());
    }

    public function testGetTitleMethodSignature(): void
    {
        $reflection = new \ReflectionClass(SemanticsInterface::class);
        $method = $reflection->getMethod('getTitle');

        $this->assertEquals('getTitle', $method->getName());
        $this->assertTrue($method->isPublic());
        $this->assertFalse($method->isStatic());
    }

    public function testInterfaceCanBeImplemented(): void
    {
        $implementation = new class implements SemanticsInterface {
            public function getValue(): int
            {
                return 1;
            }

            public function getTitle(): string
            {
                return 'Test';
            }
        };

        $this->assertInstanceOf(SemanticsInterface::class, $implementation);
        $this->assertEquals(1, $implementation->getValue());
        $this->assertEquals('Test', $implementation->getTitle());
    }
}
