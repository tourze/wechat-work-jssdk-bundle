<?php

namespace WechatWorkJssdkBundle\Tests\Exception;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\PHPUnitBase\AbstractExceptionTestCase;
use WechatWorkJssdkBundle\Exception\AgentNotSetException;

/**
 * @internal
 */
#[CoversClass(AgentNotSetException::class)]
final class AgentNotSetExceptionTest extends AbstractExceptionTestCase
{
    public function testExceptionExtendsException(): void
    {
        $exception = new AgentNotSetException();
        $this->assertInstanceOf(\Exception::class, $exception);
    }

    public function testDefaultMessage(): void
    {
        $exception = new AgentNotSetException();
        $this->assertEquals('Agent is not set', $exception->getMessage());
    }

    public function testCustomMessage(): void
    {
        $message = 'Custom agent error';
        $exception = new AgentNotSetException($message);
        $this->assertEquals($message, $exception->getMessage());
    }

    public function testDefaultCode(): void
    {
        $exception = new AgentNotSetException();
        $this->assertEquals(0, $exception->getCode());
    }

    public function testCustomCode(): void
    {
        $code = 123;
        $exception = new AgentNotSetException('Test message', $code);
        $this->assertEquals($code, $exception->getCode());
    }

    public function testPreviousException(): void
    {
        $previous = new \RuntimeException('Previous error');
        $exception = new AgentNotSetException('Test message', 0, $previous);
        $this->assertSame($previous, $exception->getPrevious());
    }
}
