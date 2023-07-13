<?php

namespace foxpay\config;

class FoxPayAppConfig
{
    //appid
    const appId = '7IJNKYVX';

    //私钥字符串  (默认先选用私钥字符串)
    const privateKey = '';

    //私钥文件位置
    const privateKeyFile = 'C:\Users\40488\Downloads\2023-7-10\private2.pem';

    //公钥字符串 (默认先选用公钥字符串)
    const publicKey = '';

    //公钥文件位置
    const publicKeyFile = 'C:\Users\40488\Downloads\2023-7-10\public2.pem';

    //请求域名
    const url = '';

    //获取全部参数
    public static function getConfig() : array
    {
        return [
            'appId' => self::appId,
            'privateKey' => self::privateKey,
            'privateKeyFile' => self::privateKeyFile,
            'publicKey' => self::publicKey,
            'publicKeyFile' => self::publicKeyFile,
            'url' => self::url
        ];
    }
}