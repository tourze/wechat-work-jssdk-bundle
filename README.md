# Wechat Work JSSDK Bundle

[English](README.md) | [中文](README.zh-CN.md)

[![Latest Version](https://img.shields.io/packagist/v/tourze/wechat-work-jssdk-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/wechat-work-jssdk-bundle)
[![License](https://img.shields.io/packagist/l/tourze/wechat-work-jssdk-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/wechat-work-jssdk-bundle)
[![Build Status](https://img.shields.io/github/actions/workflow/status/tourze/php-monorepo/ci.yml?branch=master&style=flat-square)](https://github.com/tourze/php-monorepo/actions)
[![Quality Score](https://img.shields.io/scrutinizer/g/tourze/php-monorepo.svg?style=flat-square)](https://scrutinizer-ci.com/g/tourze/php-monorepo)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/tourze/php-monorepo.svg?style=flat-square)](https://scrutinizer-ci.com/g/tourze/php-monorepo)
[![Total Downloads](https://img.shields.io/packagist/dt/tourze/wechat-work-jssdk-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/wechat-work-jssdk-bundle)

A Symfony bundle that provides WeChat Work (Enterprise WeChat) JSSDK integration with configuration generation, signature verification, and semantic annotation support.

## Features

- **JSSDK Configuration Generation**: Generate WeChat Work JSSDK configuration with proper signature verification
- **JSON-RPC API**: Expose JSSDK configuration through JSON-RPC endpoints
- **Semantic Annotations**: Support for semantic tags like phone numbers, emails, red packets
- **Test Interface**: Built-in test controller for JSSDK functionality verification
- **Ticket Management**: Automatic handling of corp and agent JS API tickets
- **Symfony Integration**: Full integration with Symfony framework and dependency injection

## Installation

```bash
composer require tourze/wechat-work-jssdk-bundle
```

## Quick Start

### 1. Basic Configuration

Add the bundle to your `config/bundles.php`:

```php
<?php

return [
    // ... other bundles
    WechatWorkJssdkBundle\WechatWorkJssdkBundle::class => ['all' => true],
];
```

### 2. Generate JSSDK Configuration

The bundle provides a JSON-RPC procedure to generate JSSDK configuration:

```php
<?php

use WechatWorkJssdkBundle\Procedure\GetWechatWorkJssdkConfig;

// Via JSON-RPC call
$config = $jsonRpcClient->call('GetWechatWorkJssdkConfig', [
    'corpId' => 'your-corp-id',
    'agentId' => 'your-agent-id',
    'url' => 'https://your-domain.com/current-page'
]);

// Returns:
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

### 3. Frontend Integration

Use the generated configuration in your frontend:

```javascript
// Configure WeChat Work JSSDK
wx.config({
    beta: config.corp.beta,
    debug: false,
    appId: config.corp.appId,
    timestamp: config.corp.timestamp,
    nonceStr: config.corp.nonceStr,
    signature: config.corp.signature,
    jsApiList: ['getCurExternalContact', 'selectExternalContact']
});

// Configure agent-specific features
wx.agentConfig({
    corpid: config.agent.corpid,
    agentid: config.agent.agentid,
    timestamp: config.agent.timestamp,
    nonceStr: config.agent.nonceStr,
    signature: config.agent.signature,
    jsApiList: ['getCurExternalContact', 'selectExternalContact']
});
```

### 4. Test Interface

Access the test interface at `/wechat/work/test/jssdk` to verify JSSDK functionality.

## API Reference

### JSON-RPC Procedures

#### GetWechatWorkJssdkConfig

Generate JSSDK configuration for WeChat Work integration.

**Parameters:**
- `corpId` (string): Enterprise ID
- `agentId` (string): Application ID
- `url` (string): Current page URL (without # and following parts)

**Returns:**
- `corp` (array): Corporation-level configuration
- `agent` (array): Agent-level configuration

### Semantic Annotations

The bundle supports semantic annotations for common data types:

- `EmailAddress`: Email address validation and formatting
- `PhoneNumber`: Phone number validation and formatting
- `RedPacket`: Red packet related semantics

## Requirements

- PHP 8.1 or higher
- Symfony 6.4 or higher
- WeChat Work Bundle (`tourze/wechat-work-bundle`)
- JSON-RPC Core (`tourze/json-rpc-core`)

## Contributing

Please see [CONTRIBUTING.md](CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
