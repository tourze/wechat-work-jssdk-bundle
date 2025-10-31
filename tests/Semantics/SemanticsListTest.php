<?php

namespace WechatWorkJssdkBundle\Tests\Semantics;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\EnumExtra\SelectDataFetcher;
use Tourze\PHPUnitSymfonyKernelTest\AbstractIntegrationTestCase;
use WechatWorkJssdkBundle\Semantics\SemanticsList;

/**
 * @internal
 */
#[CoversClass(SemanticsList::class)]
#[RunTestsInSeparateProcesses]
final class SemanticsListTest extends AbstractIntegrationTestCase
{
    protected function onSetUp(): void
    {
        // No specific setup needed
    }

    private function createSemanticsList(): SemanticsList
    {
        // 获取容器中的服务
        return self::getService(SemanticsList::class);
    }

    public function testImplementsSelectDataFetcher(): void
    {
        $semanticsList = $this->createSemanticsList();
        $this->assertInstanceOf(SelectDataFetcher::class, $semanticsList);
    }

    public function testGenSelectDataReturnsArray(): void
    {
        $semanticsList = $this->createSemanticsList();
        $result = $semanticsList->genSelectData();
        $this->assertIsArray($result);
    }

    public function testGenSelectDataContainsAllProviders(): void
    {
        $semanticsList = $this->createSemanticsList();
        $result = $semanticsList->genSelectData();

        $this->assertCount(3, $result);
    }

    public function testGenSelectDataHasCorrectStructure(): void
    {
        $semanticsList = $this->createSemanticsList();
        $result = $semanticsList->genSelectData();

        foreach ($result as $item) {
            $this->assertArrayHasKey('label', $item);
            $this->assertArrayHasKey('text', $item);
            $this->assertArrayHasKey('value', $item);
            $this->assertArrayHasKey('name', $item);

            $this->assertIsString($item['value']);
        }
    }

    public function testGenSelectDataSortedByValue(): void
    {
        $semanticsList = $this->createSemanticsList();
        $result = iterator_to_array($semanticsList->genSelectData());

        // 检查是否按value排序：手机号(1), 邮箱地址(2), 红包(3)
        $this->assertEquals('1', $result[0]['value']);
        $this->assertEquals('2', $result[1]['value']);
        $this->assertEquals('3', $result[2]['value']);
    }

    public function testGenSelectDataCorrectContent(): void
    {
        $semanticsList = $this->createSemanticsList();
        $result = iterator_to_array($semanticsList->genSelectData());

        // 检查手机号
        $phoneItems = array_values(array_filter($result, fn ($item) => '1' === $item['value']));
        $this->assertCount(1, $phoneItems);
        $phoneItem = $phoneItems[0];
        $this->assertEquals('手机号', $phoneItem['label']);
        $this->assertEquals('手机号', $phoneItem['text']);
        $this->assertEquals('手机号', $phoneItem['name']);

        // 检查邮箱地址
        $emailItems = array_values(array_filter($result, fn ($item) => '2' === $item['value']));
        $this->assertCount(1, $emailItems);
        $emailItem = $emailItems[0];
        $this->assertEquals('邮箱地址', $emailItem['label']);
        $this->assertEquals('邮箱地址', $emailItem['text']);
        $this->assertEquals('邮箱地址', $emailItem['name']);

        // 检查红包
        $redPacketItems = array_values(array_filter($result, fn ($item) => '3' === $item['value']));
        $this->assertCount(1, $redPacketItems);
        $redPacketItem = $redPacketItems[0];
        $this->assertEquals('红包', $redPacketItem['label']);
        $this->assertEquals('红包', $redPacketItem['text']);
        $this->assertEquals('红包', $redPacketItem['name']);
    }

    public function testGenSelectDataMaintainsInterfaceContract(): void
    {
        $semanticsList = $this->createSemanticsList();
        $result = $semanticsList->genSelectData();

        foreach ($result as $item) {
            // 确保label和text、name相同（按照代码逻辑）
            $this->assertEquals($item['label'], $item['text']);
            $this->assertEquals($item['label'], $item['name']);
        }
    }
}
