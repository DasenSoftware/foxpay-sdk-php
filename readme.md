#  FoxPay PHP SDK

## 简介

- 此sdk为方便php开发人员对接foxpay平台收银台功能

- 已实现功能

  - 创建订单

  - 查询订单

  - 关闭订单

  - 查询资产


## 版本要求

PHP 要求 PHP 7.0 及以上。


## 安装

### 手动安装

源码下载：[foxpay-sdk](https://github.com/dasen-software/foxpay-sdk.git )


#### 依赖拓展

- curl

## 项目使用

### config配置
路径：  foxpay/config/FoxPayAppConfig
```php

class FoxPayAppConfig
{
    //appid
    const appId = 'xxxxxxx';

    //私钥字符串  (默认先选用私钥字符串)
    const privateKey = '';

    //私钥文件位置
    const privateKeyFile = 'C:\Users\40488\Downloads\2023-7-10\private2.pem';

    //公钥字符串 (默认先选用公钥字符串)
    const publicKey = '';

    //公钥文件位置
    const publicKeyFile = '';

    //请求域名
    const url = 'https://your_domain.com';
}
```


### 使用示例

```php
    //创建订单参数   
    $orderCreateParam = [
      'subject' => 'test2',   //必须
      'order_no' => 'test2',  //必须
      'amount' => '1.2',   //必须
      'notify_url' => '',  //选传
      'redirect_url' => '',  //选传
      'time_out' => 5,   //必传
      'locale' => 'zh-CN',  //必传
      'remark' => 'test'   //选传
    ];

    //查询订单参数    trade_no/order_no二选一必传
    $queryOrderParam = [
      'trade_no' => '',    
      'order_no' => 'test'
    ];
    
    //关闭订单参数  trade_no/order_no二选一必传
    $closeOrderParam = [
       'trade_no' => 'test',
       'order_no' => 'test'
    ];
    
    //提现凭证获取参数
    $transParamPrepareParam = [
        'order_no' => 'test233',  //必须
        'amount' => '1.2',  //必须
        'to_address' => '0x3810fe9f57f2f792a1522088c1a62d14cd5b86c4',  //必须
        'notify_url' => '',  //选传
        'remark' => ''  //选传
        'gas_type' => '2'  //必传  手续费扣除：2 交易金额 3 账户余额,从service.transPrepare(transParamPrepareParam)获取
    ]; 
    
    //提现确认参数
    $transParam = [
        'trans_token' => '8f230fa553b9434f9d19848d1e7ac42dwpg9ym',  //必须
    ];
    
    //提现记录查询参数     trade_no/order_no二选一必传
    $getTransParam = [
        'trade_no' => '', 
        'order_no' => 'test233'
    ];
    
    $service = new \foxpay\service\FoxOrderService();
    
    //创建订单
    $data = $service->orderCreate($orderCreateParam);
    //查询订单
    $data = $service->orderQuery($queryOrderParam);
    //关闭订单
    $data = $service->closeOrder($closeOrderParam);
    //查询资产
    $data = $service->getBalance();
    //提现凭证获取
    $data = $service->transPrepare($transParamPrepareParam);
    //提现确认
    $data = $service->trans($transParam);
    //提现记录查询
    $data = $service->getTrans($getTransParam);
```