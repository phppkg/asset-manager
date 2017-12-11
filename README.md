# php 前端资源管理


## 项目地址

- **github** https://github.com/inhere/php-asset-manager.git

**注意：**

- 代码是要求 `php >= 7` 的

## 安装

- 使用 composer

编辑 `composer.json`，在 `require` 添加

```
"inhere/asset-manager": "dev-master",
```

然后执行: `composer update`

- 直接拉取

```
git clone https://github.com/inhere/php-asset-manager.git // github
```

## 快速开始

## php 输出资源

```php
$router = new \Inhere\Route\ORouter;
$router->get('/assets/(css|js)/([\w.-]+)\.(css|js)', AssetController::class . '@output', [

]);
```

## License

MIT
