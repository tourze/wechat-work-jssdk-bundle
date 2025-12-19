<?php

declare(strict_types=1);

namespace WechatWorkJssdkBundle\Tests\Param;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validation;
use Tourze\JsonRPC\Core\Contracts\RpcParamInterface;
use WechatWorkJssdkBundle\Param\GetWechatWorkJssdkConfigParam;

/**
 * GetWechatWorkJssdkConfigParam 单元测试
 *
 * @internal
 */
#[CoversClass(GetWechatWorkJssdkConfigParam::class)]
final class GetWechatWorkJssdkConfigParamTest extends TestCase
{
    public function testImplementsRpcParamInterface(): void
    {
        $param = new GetWechatWorkJssdkConfigParam(
            corpId: 'corp123',
            agentId: 'agent456',
            url: 'https://example.com/page',
        );

        $this->assertInstanceOf(RpcParamInterface::class, $param);
    }

    public function testConstructorWithAllParameters(): void
    {
        $param = new GetWechatWorkJssdkConfigParam(
            corpId: 'corp123',
            agentId: 'agent456',
            url: 'https://example.com/page',
        );

        $this->assertSame('corp123', $param->corpId);
        $this->assertSame('agent456', $param->agentId);
        $this->assertSame('https://example.com/page', $param->url);
    }

    public function testClassIsReadonly(): void
    {
        $reflection = new \ReflectionClass(GetWechatWorkJssdkConfigParam::class);

        $this->assertTrue($reflection->isReadOnly());
    }

    public function testPropertiesArePublicReadonly(): void
    {
        $reflection = new \ReflectionClass(GetWechatWorkJssdkConfigParam::class);

        $properties = ['corpId', 'agentId', 'url'];

        foreach ($properties as $propertyName) {
            $property = $reflection->getProperty($propertyName);
            $this->assertTrue($property->isPublic(), "{$propertyName} should be public");
            $this->assertTrue($property->isReadOnly(), "{$propertyName} should be readonly");
        }
    }

    public function testValidationFailsWhenCorpIdIsBlank(): void
    {
        $param = new GetWechatWorkJssdkConfigParam(
            corpId: '',
            agentId: 'agent456',
            url: 'https://example.com/page',
        );

        $validator = Validation::createValidatorBuilder()
            ->enableAttributeMapping()
            ->getValidator();

        $violations = $validator->validate($param);

        $this->assertGreaterThan(0, count($violations));
    }

    public function testValidationPassesWithValidParameters(): void
    {
        $param = new GetWechatWorkJssdkConfigParam(
            corpId: 'corp123',
            agentId: 'agent456',
            url: 'https://example.com/page',
        );

        $validator = Validation::createValidatorBuilder()
            ->enableAttributeMapping()
            ->getValidator();

        $violations = $validator->validate($param);

        $this->assertCount(0, $violations);
    }

    public function testHasMethodParamAttributes(): void
    {
        $reflection = new \ReflectionClass(GetWechatWorkJssdkConfigParam::class);
        $constructor = $reflection->getConstructor();

        $this->assertNotNull($constructor);

        foreach ($constructor->getParameters() as $parameter) {
            $attrs = $parameter->getAttributes(\Tourze\JsonRPC\Core\Attribute\MethodParam::class);
            $this->assertNotEmpty($attrs, "Parameter {$parameter->getName()} should have MethodParam attribute");
        }
    }
}
