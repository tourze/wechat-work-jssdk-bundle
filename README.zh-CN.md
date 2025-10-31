# 企业微信 JSSDK Bundle

[English](README.md) | [中文](README.zh-CN.md)

[![Latest Version](https://img.shields.io/packagist/v/tourze/wechat-work-jssdk-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/wechat-work-jssdk-bundle)
[![License](https://img.shields.io/packagist/l/tourze/wechat-work-jssdk-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/wechat-work-jssdk-bundle)
[![Build Status](https://img.shields.io/github/actions/workflow/status/tourze/php-monorepo/ci.yml?branch=master&style=flat-square)](https://github.com/tourze/php-monorepo/actions)
[![Quality Score](https://img.shields.io/scrutinizer/g/tourze/php-monorepo.svg?style=flat-square)](https://scrutinizer-ci.com/g/tourze/php-monorepo)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/tourze/php-monorepo.svg?style=flat-square)](https://scrutinizer-ci.com/g/tourze/php-monorepo)
[![Total Downloads](https://img.shields.io/packagist/dt/tourze/wechat-work-jssdk-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/wechat-work-jssdk-bundle)

一个提供企业微信 JSSDK 集成的 Symfony 包，支持配置生成、签名验证和语义标注功能。

## 特性

- **JSSDK 配置生成**: 生成企业微信 JSSDK 配置，包含正确的签名验证
- **JSON-RPC API**: 通过 JSON-RPC 端点暴露 JSSDK 配置
- **语义标注**: 支持电话号码、邮箱、红包等语义标签
- **测试界面**: 内置测试控制器用于验证 JSSDK 功能
- **票据管理**: 自动处理企业和应用的 JS API 票据
- **Symfony 集成**: 完全集成 Symfony 框架和依赖注入

## 安装

```bash
composer require tourze/wechat-work-jssdk-bundle
```

## 快速开始

### 1. 基本配置

在 `config/bundles.php` 中添加 bundle：

```php
<?php

return [
    // ... 其他 bundles
    WechatWorkJssdkBundle\WechatWorkJssdkBundle::class => ['all' => true],
];
```

### 2. 生成 JSSDK 配置

该 bundle 提供了一个 JSON-RPC 过程来生成 JSSDK 配置：

```php
<?php

use WechatWorkJssdkBundle\Procedure\GetWechatWorkJssdkConfig;

// 通过 JSON-RPC 调用
$config = $jsonRpcClient->call('GetWechatWorkJssdkConfig', [
    'corpId' => 'your-corp-id',
    'agentId' => 'your-agent-id',
    'url' => 'https://your-domain.com/current-page'
]);

// 返回结果：
// [
//     'corp' => [
//         'beta' => true,
//         'appId' => 'corp-id',
//         'timestamp' => 1234567890,
//         'nonceStr' => 'random-string',
//         'signature' => 'generated-signature'
//     ],
//     'agent' => [
//         'corpid' => 'corp-id',
//         'agentid' => 'agent-id',
//         'timestamp' => 1234567890,
//         'nonceStr' => 'random-string',
//         'signature' => 'generated-signature'
//     ]
// ]
```

### 3. 前端集成

在前端使用生成的配置：

```javascript
// 配置企业微信 JSSDK
wx.config({
    beta: config.corp.beta,
    debug: false,
    appId: config.corp.appId,
    timestamp: config.corp.timestamp,
    nonceStr: config.corp.nonceStr,
    signature: config.corp.signature,
    jsApiList: ['getCurExternalContact', 'selectExternalContact']
});

// 配置应用特定功能
wx.agentConfig({
    corpid: config.agent.corpid,
    agentid: config.agent.agentid,
    timestamp: config.agent.timestamp,
    nonceStr: config.agent.nonceStr,
    signature: config.agent.signature,
    jsApiList: ['getCurExternalContact', 'selectExternalContact']
});
```

### 4. 测试界面

访问测试界面 `/wechat/work/test/jssdk` 来验证 JSSDK 功能。

## API 参考

### JSON-RPC 过程

#### GetWechatWorkJssdkConfig

生成企业微信集成的 JSSDK 配置。

**参数：**
- `corpId` (string): 企业ID
- `agentId` (string): 应用ID
- `url` (string): 当前页面URL（不包含#及其后面部分）

**返回值：**
- `corp` (array): 企业级配置
- `agent` (array): 应用级配置

### 语义标注

该 bundle 支持常见数据类型的语义标注：

- `EmailAddress`: 邮箱地址验证和格式化
- `PhoneNumber`: 电话号码验证和格式化
- `RedPacket`: 红包相关语义

## 系统要求

- PHP 8.1 或更高版本
- Symfony 6.4 或更高版本
- 企业微信 Bundle (`tourze/wechat-work-bundle`)
- JSON-RPC Core (`tourze/json-rpc-core`)

## 贡献

请参阅 [CONTRIBUTING.md](CONTRIBUTING.md) 了解详情。

## 许可证

MIT 许可证。请参阅 [License File](LICENSE) 了解更多信息。
