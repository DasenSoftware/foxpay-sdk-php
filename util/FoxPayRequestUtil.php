<?php

namespace foxpay\util;

use foxpay\enum\CodeEnum;
use foxpay\exception\FoxPayException;
use foxpay\util\RSAExample;
use foxpay\util\HttpRequestUtil;

class FoxPayRequestUtil
{
    /**
     * @param string $url 请求地址
     * @param array $param  请求参数
     * @param array $config  用用配置项
     * @return void
     */
    public static function orderRequest(string $url,array $param, array $config, string $method = 'POST')
    {
        if(!$config['appId']){
            throw new FoxPayException(CodeEnum::CONFIG_NOT_NULL,'appId');
        }

        if(!$config['url']){
            throw new FoxPayException(CodeEnum::CONFIG_NOT_NULL,'url');
        }

        $privateKey = $config['privateKey'];  //私钥
        $publicKey = $config['publicKey'];    //公钥

        if(!$privateKey && !$publicKey){
            //读取参数
            $publicKey = file_get_contents($config['publicKeyFile']);
            $privateKey = file_get_contents($config['privateKeyFile']);

            if(!$publicKey || !$privateKey){  //读取文件异常
                throw new FoxPayException(CodeEnum::FILE_ERROR,'public_key or private_key');
            }
        }else{
            $rsae = new RSAExample();
            $publicKey = $rsae->formatPubKey($publicKey);
            $privateKey = $rsae->formatPriKey($privateKey);
        }

        if(!$privateKey || !$publicKey){
            throw new FoxPayException(CodeEnum::CONFIG_ERROR,'privateKey or publicKey');
        }

        $url = $config['url'] . $url;

        return self::doOrderRequest($url,$param,$config['appId'],$publicKey,$privateKey,$method);
    }

    /**
     * @param string $url
     * @param array $param
     * @param string $appId
     * @param string $publicKey
     * @param string $privateKey
     * @param string $method
     * @return mixed
     * @throws \Exception
     */
    public static function doOrderRequest(string $url,array $param,string $appId,string $publicKey,string $privateKey,string $method = 'POST')
    {
        //请求参数头
        $headers = [];

        $headers['app_id'] = $appId;

        $rsaeExample = new RSAExample();

        if($param){     //加密请求参数
            $string_param = $rsaeExample->getSign2($param);
            $headers['sign'] = $rsaeExample->get_private_sign($string_param,$privateKey);
        }

        //构建请求参数
        $httpRequest = new HttpRequestUtil();

        if($method == 'POST'){
            $response = $httpRequest->post($url,$param,$headers);
        }else{
            $response = $httpRequest->get($url,$headers);
        }

        if($response['code'] == CodeEnum::SUCCESS['code']){   //操作成功
            if($response['header_sign']){     //校验签名
                $sign_str = $rsaeExample->getSign2($response['data']); //获取签名字符串
                $res = $rsaeExample->public_verify($sign_str,$response['header_sign'],$publicKey);  //验签
                if(!$res){  //验签未通过
                    throw new FoxPayException(CodeEnum::RESPONSE_SIGN_ERROR);
                }
            }
        }

        return ['code'=>$response['code'],'message'=>$response['message'],'data'=>$response['data']];
    }
}