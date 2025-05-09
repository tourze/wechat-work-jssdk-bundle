<?php

namespace WechatWorkJssdkBundle\Tests\Integration;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use WechatWorkJssdkBundle\WechatWorkJssdkBundle;

class WechatWorkJssdkIntegrationTest extends KernelTestCase
{
    protected static function getKernelClass(): string
    {
        return IntegrationTestKernel::class;
    }

    protected function setUp(): void
    {
        self::bootKernel();
    }

    public function testBundleInitialization(): void
    {
        $kernel = self::$kernel;
        
        // 验证Bundle是否正确注册
        $bundles = $kernel->getBundles();
        $this->assertArrayHasKey('WechatWorkJssdkBundle', $bundles);
        $this->assertInstanceOf(WechatWorkJssdkBundle::class, $bundles['WechatWorkJssdkBundle']);
    }
} 