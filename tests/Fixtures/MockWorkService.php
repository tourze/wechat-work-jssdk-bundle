<?php

namespace WechatWorkJssdkBundle\Tests\Fixtures;

use WechatWorkBundle\Service\WorkService;

/**
 * 测试用的模拟 WorkService
 */
class MockWorkService extends WorkService
{
    public function __construct()
    {
        // 空构造函数，避免依赖
    }

    public function request(object $request): array
    {
        // 返回模拟的响应数据
        return [
            'ticket' => 'mock_ticket_' . uniqid(),
        ];
    }
}
