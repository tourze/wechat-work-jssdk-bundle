<?php

namespace WechatWorkJssdkBundle\Tests\Semantics;

use PHPUnit\Framework\TestCase;
use WechatWorkJssdkBundle\Semantics\SemanticsInterface;

class SemanticsInterfaceTest extends TestCase
{
    public function test_interface_exists(): void
    {
        $this->assertTrue(interface_exists(SemanticsInterface::class));
    }

    public function test_interface_has_required_methods(): void
    {
        $reflection = new \ReflectionClass(SemanticsInterface::class);
        
        $this->assertTrue($reflection->hasMethod('getValue'));
        $this->assertTrue($reflection->hasMethod('getTitle'));
    }

    public function test_getValue_method_signature(): void
    {
        $reflection = new \ReflectionClass(SemanticsInterface::class);
        $method = $reflection->getMethod('getValue');
        
        $this->assertEquals('getValue', $method->getName());
        $this->assertTrue($method->isPublic());
        $this->assertFalse($method->isStatic());
    }

    public function test_getTitle_method_signature(): void
    {
        $reflection = new \ReflectionClass(SemanticsInterface::class);
        $method = $reflection->getMethod('getTitle');
        
        $this->assertEquals('getTitle', $method->getName());
        $this->assertTrue($method->isPublic());
        $this->assertFalse($method->isStatic());
    }

    public function test_interface_can_be_implemented(): void
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