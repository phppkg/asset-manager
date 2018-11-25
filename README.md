# php 前端资源管理

[![License](https://img.shields.io/packagist/l/php-comp/asset-manager.svg?style=flat-square)](LICENSE)
[![Php Version](https://img.shields.io/badge/php-%3E=7.0-brightgreen.svg?maxAge=2592000)](https://packagist.org/packages/php-comp/asset-manager)
[![Latest Stable Version](http://img.shields.io/packagist/v/php-comp/asset-manager.svg)](https://packagist.org/packages/php-comp/asset-manager)


## 项目地址

- **github** https://github.com/inhere/php-asset-manager.git

**注意：**

- 代码是要求 `php >= 7` 的

## 安装

- 使用 `composer require`

```bash
composer require php-comp/asset-manager
```

- 使用 `composer.json`

编辑 `composer.json`，在 `require` 添加

```
"php-comp/asset-manager": "dev-master",
```

然后执行: `composer update`

- 直接拉取

```
git clone https://github.com/inhere/php-asset-manager.git // github
```

## 快速开始

## PHP输出资源

```php
$router = new \Inhere\Route\Router;
$router->get('/assets/(css|js)/([\w.-]+)\.(css|js)', AssetController::class . '@output');
```

## License

[MIT](LICENSE)
