<?php

namespace WechatWorkJssdkBundle\Tests\Controller;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyWebTest\AbstractWebTestCase;
use WechatWorkJssdkBundle\Controller\JssdkController;

/**
 * @internal
 */
#[CoversClass(JssdkController::class)]
#[RunTestsInSeparateProcesses]
final class JssdkControllerTest extends AbstractWebTestCase
{
    public function testUnauthenticatedAccess(): void
    {
        $client = self::createClient();
        $client->request('GET', '/wechat/work/test/jssdk');

        $response = $client->getResponse();
        $this->assertNotNull($response);
        $this->assertTrue($response->getStatusCode() >= 200 && $response->getStatusCode() < 600);
    }

    #[DataProvider('provideNotAllowedMethods')]
    public function testMethodNotAllowed(string $method): void
    {
        $client = self::createClient();
        $client->request($method, '/wechat/work/test/jssdk');

        $response = $client->getResponse();
        $this->assertEquals(405, $response->getStatusCode());
    }
}
