<?php

namespace WechatWorkJssdkBundle\Tests\Request\Session;

use HttpClientBundle\Request\ApiRequest;
use HttpClientBundle\Tests\Request\RequestTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use WechatWorkJssdkBundle\Request\Session\GetLaunchCodeRequest;

/**
 * @internal
 */
#[CoversClass(GetLaunchCodeRequest::class)]
final class GetLaunchCodeRequestTest extends RequestTestCase
{
    private GetLaunchCodeRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new GetLaunchCodeRequest();
    }

    public function testExtendsApiRequest(): void
    {
        $this->assertInstanceOf(ApiRequest::class, $this->request);
    }

    public function testGetRequestPathReturnsCorrectPath(): void
    {
        $this->assertEquals('/cgi-bin/get_launch_code', $this->request->getRequestPath());
    }

    public function testSetOperatorUserIdAndGetOperatorUserId(): void
    {
        $userId = 'test@example.com';

        $this->request->setOperatorUserId($userId);

        $this->assertEquals($userId, $this->request->getOperatorUserId());
    }

    public function testSetSingleChatAndGetSingleChat(): void
    {
        $singleChat = ['userid' => 'user123'];

        $this->request->setSingleChat($singleChat);

        $this->assertEquals($singleChat, $this->request->getSingleChat());
    }

    public function testSetSingleChatWithEmptyArray(): void
    {
        $this->request->setSingleChat([]);

        $this->assertEquals([], $this->request->getSingleChat());
    }

    public function testSetSingleChatWithMultipleFields(): void
    {
        $singleChat = [
            'userid' => 'user123',
            'name' => 'Test User',
            'extra' => 'data',
        ];

        $this->request->setSingleChat($singleChat);

        $this->assertEquals($singleChat, $this->request->getSingleChat());
    }

    public function testGetRequestOptionsWithValidData(): void
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

    public function testGetRequestOptionsStructure(): void
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

    public function testDefaultSingleChatIsEmptyArray(): void
    {
        $this->assertEquals([], $this->request->getSingleChat());
    }

    public function testOperatorUserIdWithSpecialCharacters(): void
    {
        $userId = 'test+user@example.com';

        $this->request->setOperatorUserId($userId);

        $this->assertEquals($userId, $this->request->getOperatorUserId());
    }

    public function testSingleChatPreservesArrayKeys(): void
    {
        $singleChat = [
            'userid' => 'user123',
            'department' => 'IT',
            'role' => 'developer',
        ];

        $this->request->setSingleChat($singleChat);
        $result = $this->request->getSingleChat();

        $this->assertArrayHasKey('userid', $result);
        $this->assertArrayHasKey('department', $result);
        $this->assertArrayHasKey('role', $result);
    }
}
