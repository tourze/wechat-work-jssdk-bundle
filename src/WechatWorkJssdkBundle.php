<?php

declare(strict_types=1);

namespace WechatWorkJssdkBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Tourze\BundleDependency\BundleDependencyInterface;
use Tourze\JsonRPCLockBundle\JsonRPCLockBundle;
use Tourze\RoutingAutoLoaderBundle\RoutingAutoLoaderBundle;
use WechatWorkBundle\WechatWorkBundle;

class WechatWorkJssdkBundle extends Bundle implements BundleDependencyInterface
{
    public static function getBundleDependencies(): array
    {
        return [
            JsonRPCLockBundle::class => ['all' => true],
            RoutingAutoLoaderBundle::class => ['all' => true],
            WechatWorkBundle::class => ['all' => true],
        ];
    }
}
