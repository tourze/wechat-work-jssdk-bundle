<?php

namespace WechatWorkJssdkBundle\Tests\Request\Session;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use WechatWorkBundle\Entity\Agent;
use WechatWorkJssdkBundle\Request\Session\GetLaunchCodeRequest;

class GetLaunchCodeRequestTest extends TestCase
{
    private GetLaunchCodeRequest $request;
    private MockObject $agent;

    protected function setUp(): void
    {
        $this->request = new GetLaunchCodeRequest();
        
        // 创建Agent模拟对象
        $this->agent = $this->createMock(Agent::class);
        
        // 设置Request属性
        $this->request->setAgent($this->agent);
        $this->request->setOperatorUserId('test_operator');
        $this->request->setSingleChat(['userid' => 'test_user']);
    }

    public function testGetRequestPath(): void
    {
        // 验证请求路径是否正确
        $this->assertEquals('/cgi-bin/get_launch_code', $this->request->getRequestPath());
    }

    public function testGetRequestOptions_withSingleChat(): void
    {
        // 验证请求选项是否正确
        $options = $this->request->getRequestOptions();
        
        $this->assertIsArray($options);
        $this->assertArrayHasKey('json', $options);
        $this->assertArrayHasKey('operator_userid', $options['json']);
        $this->assertArrayHasKey('single_chat', $options['json']);
        
        $this->assertEquals('test_operator', $options['json']['operator_userid']);
        $this->assertEquals(['userid' => 'test_user'], $options['json']['single_chat']);
    }

    public function testSetOperatorUserId(): void
    {
        // 设置新的操作者ID
        $this->request->setOperatorUserId('new_operator');
        
        // 验证是否正确设置
        $this->assertEquals('new_operator', $this->request->getOperatorUserId());
        
        // 验证请求选项是否更新
        $options = $this->request->getRequestOptions();
        $this->assertEquals('new_operator', $options['json']['operator_userid']);
    }

    public function testSetSingleChat(): void
    {
        // 设置新的单聊参数
        $newSingleChat = ['userid' => 'new_user'];
        $this->request->setSingleChat($newSingleChat);
        
        // 验证是否正确设置
        $this->assertEquals($newSingleChat, $this->request->getSingleChat());
        
        // 验证请求选项是否更新
        $options = $this->request->getRequestOptions();
        $this->assertEquals($newSingleChat, $options['json']['single_chat']);
    }

    public function testGetOperatorUserId(): void
    {
        // 验证获取操作者ID
        $this->assertEquals('test_operator', $this->request->getOperatorUserId());
    }

    public function testGetSingleChat(): void
    {
        // 验证获取单聊参数
        $this->assertEquals(['userid' => 'test_user'], $this->request->getSingleChat());
    }
} 