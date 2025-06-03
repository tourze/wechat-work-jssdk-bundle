<?php

namespace WechatWorkJssdkBundle\Tests\Request\Session;

use HttpClientBundle\Request\ApiRequest;
use PHPUnit\Framework\TestCase;
use WechatWorkJssdkBundle\Request\Session\GetLaunchCodeRequest;

class GetLaunchCodeRequestTest extends TestCase
{
    private GetLaunchCodeRequest $request;

    protected function setUp(): void
    {
        $this->request = new GetLaunchCodeRequest();
    }

    public function test_extends_api_request(): void
    {
        $this->assertInstanceOf(ApiRequest::class, $this->request);
    }

    public function test_getRequestPath_returns_correct_path(): void
    {
        $this->assertEquals('/cgi-bin/get_launch_code', $this->request->getRequestPath());
    }

    public function test_setOperatorUserId_and_getOperatorUserId(): void
    {
        $userId = 'test@example.com';
        
        $this->request->setOperatorUserId($userId);
        
        $this->assertEquals($userId, $this->request->getOperatorUserId());
    }

    public function test_setSingleChat_and_getSingleChat(): void
    {
        $singleChat = ['userid' => 'user123'];
        
        $this->request->setSingleChat($singleChat);
        
        $this->assertEquals($singleChat, $this->request->getSingleChat());
    }

    public function test_setSingleChat_with_empty_array(): void
    {
        $this->request->setSingleChat([]);
        
        $this->assertEquals([], $this->request->getSingleChat());
    }

    public function test_setSingleChat_with_multiple_fields(): void
    {
        $singleChat = [
            'userid' => 'user123',
            'name' => 'Test User',
            'extra' => 'data'
        ];
        
        $this->request->setSingleChat($singleChat);
        
        $this->assertEquals($singleChat, $this->request->getSingleChat());
    }

    public function test_getRequestOptions_with_valid_data(): void
    {
        $userId = 'dev@gzcrm.cn';
        $singleChat = ['userid' => 'testuser'];
        
        $this->request->setOperatorUserId($userId);
        $this->request->setSingleChat($singleChat);
        
        $options = $this->request->getRequestOptions();
        
        $this->assertIsArray($options);
        $this->assertArrayHasKey('json', $options);
        $this->assertArrayHasKey('operator_userid', $options['json']);
        $this->assertArrayHasKey('single_chat', $options['json']);
        
        $this->assertEquals($userId, $options['json']['operator_userid']);
        $this->assertEquals($singleChat, $options['json']['single_chat']);
    }

    public function test_getRequestOptions_structure(): void
    {
        $this->request->setOperatorUserId('test@example.com');
        $this->request->setSingleChat(['userid' => 'user123']);
        
        $options = $this->request->getRequestOptions();
        
        $this->assertIsArray($options);
        $this->assertCount(1, $options);
        $this->assertArrayHasKey('json', $options);
        $this->assertIsArray($options['json']);
        $this->assertCount(2, $options['json']);
    }

    public function test_default_singleChat_is_empty_array(): void
    {
        $this->assertEquals([], $this->request->getSingleChat());
    }

    public function test_operatorUserId_with_special_characters(): void
    {
        $userId = 'test+user@example.com';
        
        $this->request->setOperatorUserId($userId);
        
        $this->assertEquals($userId, $this->request->getOperatorUserId());
    }

    public function test_singleChat_preserves_array_keys(): void
    {
        $singleChat = [
            'userid' => 'user123',
            'department' => 'IT',
            'role' => 'developer'
        ];
        
        $this->request->setSingleChat($singleChat);
        $result = $this->request->getSingleChat();
        
        $this->assertArrayHasKey('userid', $result);
        $this->assertArrayHasKey('department', $result);
        $this->assertArrayHasKey('role', $result);
    }
} 