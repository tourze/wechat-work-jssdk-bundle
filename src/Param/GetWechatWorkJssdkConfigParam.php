<?php

declare(strict_types=1);

namespace WechatWorkJssdkBundle\Param;

use Symfony\Component\Validator\Constraints as Assert;
use Tourze\JsonRPC\Core\Attribute\MethodParam;
use Tourze\JsonRPC\Core\Contracts\RpcParamInterface;

/**
 * GetWechatWorkJssdkConfig Procedure 的参数对象
 *
 * 用于获取config接口注入权限验证配置
 */
readonly class GetWechatWorkJssdkConfigParam implements RpcParamInterface
{
    public function __construct(
        #[MethodParam(description: '企业ID')]
        #[Assert\NotBlank]
        public string $corpId,

        #[MethodParam(description: '应用ID')]
        #[Assert\NotBlank]
        public string $agentId,

        #[MethodParam(description: '当前网页的URL， 不包含#及其后面部分')]
        #[Assert\NotBlank]
        public string $url,
    ) {
    }
}
