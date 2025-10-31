<?php

declare(strict_types=1);

namespace WechatWorkJssdkBundle\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyKernelTest\AbstractBundleTestCase;
use WechatWorkJssdkBundle\WechatWorkJssdkBundle;

/**
 * @internal
 */
#[CoversClass(WechatWorkJssdkBundle::class)]
#[RunTestsInSeparateProcesses]
final class WechatWorkJssdkBundleTest extends AbstractBundleTestCase
{
}
