<?php

namespace WechatWorkJssdkBundle\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use WechatWorkJssdkBundle\WechatWorkJssdkBundle;

class WechatWorkJssdkBundleTest extends TestCase
{
    public function test_extends_bundle(): void
    {
        $bundle = new WechatWorkJssdkBundle();
        
        $this->assertInstanceOf(Bundle::class, $bundle);
    }

    public function test_bundle_name(): void
    {
        $bundle = new WechatWorkJssdkBundle();
        
        $this->assertEquals('WechatWorkJssdkBundle', $bundle->getName());
    }

    public function test_bundle_namespace(): void
    {
        $bundle = new WechatWorkJssdkBundle();
        
        $this->assertEquals('WechatWorkJssdkBundle', $bundle->getNamespace());
    }

    public function test_bundle_path(): void
    {
        $bundle = new WechatWorkJssdkBundle();
        $expectedPath = dirname(__DIR__) . '/src';
        
        $this->assertEquals($expectedPath, $bundle->getPath());
    }
} 