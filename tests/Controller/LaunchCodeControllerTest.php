<?php

namespace WechatWorkJssdkBundle\Tests\Controller;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyWebTest\AbstractWebTestCase;
use WechatWorkJssdkBundle\Controller\LaunchCodeController;

/**
 * @internal
 */
#[CoversClass(LaunchCodeController::class)]
#[RunTestsInSeparateProcesses]
final class LaunchCodeControllerTest extends AbstractWebTestCase
{
    public function testUnauthenticatedAccess(): void
    {
        $client = self::createClient();
        $client->request('GET', '/wechat/work/test/launch-code/testuser?corpId=test&agentId=1000001');

        $response = $client->getResponse();
        $this->assertNotNull($response);
        $this->assertTrue($response->getStatusCode() >= 200 && $response->getStatusCode() < 600);
    }

    #[DataProvider('provideNotAllowedMethods')]
    public function testMethodNotAllowed(string $method): void
    {
        $client = self::createClient();
        $client->request($method, '/wechat/work/test/launch-code/testuser?corpId=test&agentId=1000001');

        $response = $client->getResponse();
        $this->assertEquals(405, $response->getStatusCode());
    }
}
