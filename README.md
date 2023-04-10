## laravel hupun
为 Laravel 提供的万里牛ERP开放接口的 PHP SDK

#### 安装
第一步：执行 composer 命令下载包 `composer require weiaibaicai/hupun`

第二步：把 HupunServiceProvider 添加到 `config/app.php`  
```php
'providers' => [
	Weiaibaicai\Hupun\HupunServiceProvider::class,
],
```

第三步：把 Hupun 添加到 `config/app.php`
```php
'aliases' => [
	'Hupun' => Weiaibaicai\Hupun\Facades\Hupun::class,
],
```

第四步：执行 artisan 命令发布配置文件`php artisan vendor:publish --provider="Weiaibaicai\Hupun\HupunServiceProvider"`

第五步：去 .env 添加如下配置
```php
# open接口的key
HUPUN_OPEN_KEY=openAppKey
# open接口的秘钥
HUPUN_OPEN_SECRET=open秘钥
# open接口的请求域名
HUPUN_OPEN_URL=https://open-api.hupun.com/api
# open接口的消息通道
HUPUN_OPEN_LOG_CHANNEL=single
# 打印请求结果日志
HUPUN_OPEN_API_IS_LOG_RESULT=1

# b2c接口的key
HUPUN_B2C_KEY=b2cAppKey
# b2c接口的秘钥
HUPUN_B2C_SECRET=b2c秘钥
# b2c接口的请求域名
HUPUN_B2C_URL=https://erp-open.hupun.com/api
# b2c接口的消息通道
HUPUN_B2C_LOG_CHANNEL=single
# 打印请求结果日志
HUPUN_B2C_API_IS_LOG_RESULT=1
```

#### 接口调用
```php
use Weiaibaicai\Hupun\Facades\Hupun;
use Weiaibaicai\Hupun\Client;

//调用单笔查询库存的接口
$params = [
    'page'  => 1,
    'limit' => 20,
    'start' => '2023-03-22 00:00:00',
    'end'   => '2023-03-29 00:00:00',
];
//调用的三种方式
dd(Hupun::getInventoriesErp($params)); 
dd(Client::make()->getInventoriesErp($params));
dd(Client::make()->execute('/inventories/erp', $params, 'get', false));

```

#### b2c签名校验
```php
use Weiaibaicai\Hupun\Client;

//取出参数
$params = $request->all();
//验签
$sign = Arr::get($params, 'sign');
unset($params['sign']);
$client = (new Client())->make();
$client->useConfig('b2c');
$newSign = $client->generateSign($params);
if ($newSign === $sign) {
    //todo: 去实现个人业务
}

```
