<?php

namespace WechatWorkJssdkBundle\Tests\Semantics;

use PHPUnit\Framework\TestCase;
use Tourze\EnumExtra\SelectDataFetcher;
use WechatWorkJssdkBundle\Semantics\EmailAddress;
use WechatWorkJssdkBundle\Semantics\PhoneNumber;
use WechatWorkJssdkBundle\Semantics\RedPacket;
use WechatWorkJssdkBundle\Semantics\SemanticsInterface;
use WechatWorkJssdkBundle\Semantics\SemanticsList;

class SemanticsListTest extends TestCase
{
    private SemanticsList $semanticsList;

    protected function setUp(): void
    {
        // 模拟tagged iterator
        $providers = [
            new PhoneNumber(),
            new EmailAddress(),
            new RedPacket(),
        ];
        $this->semanticsList = new SemanticsList($providers);
    }

    public function test_implements_select_data_fetcher(): void
    {
        $this->assertInstanceOf(SelectDataFetcher::class, $this->semanticsList);
    }

    public function test_genSelectData_returns_array(): void
    {
        $result = $this->semanticsList->genSelectData();
    }

    public function test_genSelectData_contains_all_providers(): void
    {
        $result = $this->semanticsList->genSelectData();
        
        $this->assertCount(3, $result);
    }

    public function test_genSelectData_has_correct_structure(): void
    {
        $result = $this->semanticsList->genSelectData();
        
        foreach ($result as $item) {
            $this->assertArrayHasKey('label', $item);
            $this->assertArrayHasKey('text', $item);
            $this->assertArrayHasKey('value', $item);
            $this->assertArrayHasKey('name', $item);

            $this->assertIsInt($item['value']);
        }
    }

    public function test_genSelectData_sorted_by_value(): void
    {
        $result = $this->semanticsList->genSelectData();
        
        // 检查是否按value排序：手机号(1), 邮箱地址(2), 红包(3)
        $this->assertEquals(1, $result[0]['value']);
        $this->assertEquals(2, $result[1]['value']);
        $this->assertEquals(3, $result[2]['value']);
    }

    public function test_genSelectData_correct_content(): void
    {
        $result = $this->semanticsList->genSelectData();
        
        // 检查手机号
        $phoneItem = array_filter($result, fn($item) => $item['value'] === 1)[0];
        $this->assertEquals('手机号', $phoneItem['label']);
        $this->assertEquals('手机号', $phoneItem['text']);
        $this->assertEquals('手机号', $phoneItem['name']);
        
        // 检查邮箱地址
        $emailItem = array_filter($result, fn($item) => $item['value'] === 2)[1];
        $this->assertEquals('邮箱地址', $emailItem['label']);
        $this->assertEquals('邮箱地址', $emailItem['text']);
        $this->assertEquals('邮箱地址', $emailItem['name']);
        
        // 检查红包
        $redPacketItem = array_filter($result, fn($item) => $item['value'] === 3)[2];
        $this->assertEquals('红包', $redPacketItem['label']);
        $this->assertEquals('红包', $redPacketItem['text']);
        $this->assertEquals('红包', $redPacketItem['name']);
    }

    public function test_genSelectData_with_empty_providers(): void
    {
        $emptySemanticsList = new SemanticsList([]);
        $result = $emptySemanticsList->genSelectData();
        $this->assertEmpty($result);
    }

    public function test_genSelectData_maintains_interface_contract(): void
    {
        $result = $this->semanticsList->genSelectData();
        
        foreach ($result as $item) {
            // 确保label和text、name相同（按照代码逻辑）
            $this->assertEquals($item['label'], $item['text']);
            $this->assertEquals($item['label'], $item['name']);
        }
    }

    public function test_constructor_accepts_semantics_interface(): void
    {
        $mockSemantics = $this->createMock(SemanticsInterface::class);
        $mockSemantics->method('getTitle')->willReturn('测试语义');
        $mockSemantics->method('getValue')->willReturn(999);
        
        $semanticsList = new SemanticsList([$mockSemantics]);
        $result = $semanticsList->genSelectData();
        
        $this->assertCount(1, $result);
        $this->assertEquals('测试语义', $result[0]['label']);
        $this->assertEquals(999, $result[0]['value']);
    }
} 