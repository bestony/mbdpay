# 面包多 Pay -  PHP SDK
[![PHP Composer](https://github.com/bestony/mbdpay/actions/workflows/php.yml/badge.svg)](https://github.com/bestony/mbdpay/actions/workflows/php.yml)[![PHPStan Analyse](https://github.com/bestony/mbdpay/actions/workflows/stylecheck.yml/badge.svg)](https://github.com/bestony/mbdpay/actions/workflows/stylecheck.yml)
## 安装

### 使用 Composer 安装

```bash
composer require bestony/mbdpay
```

### 引入文件安装

使用命令下载文件

```bash
wget  https://raw.githubusercontent.com/bestony/mbdpay/master/src/Client.php
```

并在代码中使用 `require_once "Client.php"` 引入对应的代码

## 使用方式

基本用法可以参考下方代码

```php
$client = new \Bestony\Mbdpay\Client(APPID, APPKEY);
$result = $client->wxH5pay([
            "description" => "testDescription",
            "out_trade_no" => "1234ajs",
            "amount_total" => 1
        ]);
```

更多详细用法，可以参考[调用说明](../../wiki/%E8%B0%83%E7%94%A8%E8%AF%B4%E6%98%8E)或[测试文件](tests/ClientTest.php)

## 测试

1. 设定 `APPID` & `APPKEY` 环境变量

2. 执行测试

```bash
composer test
```

## 更新日志

请查看 [CHANGELOG](CHANGELOG.md) 了解更新信息。

## 参与贡献

请查看 [CONTRIBUTING](.github/CONTRIBUTING.md) 了解更多关于参与贡献的详情。

## 安全风险

如果你发现任何与安全相关问题，可以访问 [安全策略](../../security/policy) 了解如何反馈安全问题。

## 贡献者

- [bestony](https://github.com/bestony)
- [All Contributors](../../contributors)

## 授权

The MIT License (MIT). 请查看 [License File](LICENSE.md) 了解更多信息。
