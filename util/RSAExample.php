<?php

namespace foxpay\util;

class RSAExample
{

    /**
     * 拼接需要签名的内容
     * Author: Tao.
     *
     * @param array $data 需签名的字段内容
     *
     * @return string
     */
    public function getSign(array $data)
    {
        $string = '';

        ksort($data); //键值排序

        foreach($data as $k => $v){
            $string = "{$string}$k=$v&";
        }

        if(strlen($string) > 0){
            $string = substr($string,0,strlen($string) - 1);
        }

        return $string;
    }

    /**
     * 拼接需要签名的内容  为null值的不参与排序
     * @param array $data
     * @return false|string
     */
    public function getSign2(array $data)
    {
        $string = '';

        ksort($data); //键值排序

        foreach($data as $k => $v){
            if(is_null($v)){
                continue;
            }
            $string = $string . $k . '=' . $v . '&';
        }

        if(strlen($string) > 0){
            $string = substr($string,0,strlen($string) - 1);
        }

        return $string;
    }

    //私钥格式化
    public function formatPriKey(string $priKey) :string
    {
        return "-----BEGIN PRIVATE KEY-----\n".chunk_split($priKey, 64,"\n").'-----END PRIVATE KEY-----';
    }

    //公钥格式化
    public function formatPubKey(string $pubKey) :string
    {
        return "-----BEGIN PUBLIC KEY-----\n".chunk_split($pubKey, 64,"\n").'-----END PUBLIC KEY-----';
    }

    //私钥签名
    public function get_private_sign(string $sign_str,string $private_key,$signature_alg=OPENSSL_ALGO_SHA1):string
    {
        $private_key = openssl_pkey_get_private($private_key);//加载密钥
        if (!$private_key) {
            throw new \Exception('私钥不可用');
        }
        openssl_sign($sign_str,$signature,$private_key,$signature_alg);//生成签名
        return base64_encode($signature);
    }

    //公钥验签
    public function public_verify(string $data,string $sign,$public_key,$signature_alg=OPENSSL_ALGO_SHA1):bool
    {
        $public_key = openssl_pkey_get_public($public_key);
        $verify = openssl_verify($data, base64_decode($sign), $public_key, $signature_alg);
        return $verify == 1;//false or true
    }

    public function public_verify2(string $data,string $sign,$public_key,$signature_alg=OPENSSL_ALGO_SHA1)
    {
        $public_key = openssl_pkey_get_public($public_key);
        if(!$public_key){
            throw new \Exception('公钥不可用');
        }
        $verify = openssl_verify($data, base64_decode($sign), $public_key, $signature_alg);
        return $verify == 1;//false or true
    }

    //公钥加密
    public function get_public_sign(string $sign_str,string $public_key,$signature_alg=OPENSSL_ALGO_SHA1):string
    {
        $public_key = openssl_pkey_get_public($public_key);//加载密钥
        if (!$public_key) {
            throw new \Exception('公钥不可用');
        }
        openssl_public_encrypt($sign_str,$signature,$public_key,$signature_alg);
        return base64_encode($signature);
    }

    //私钥解密
    public function private_decode(string $sign_str,string $private_key,$signature_alg=OPENSSL_ALGO_SHA1):string
    {

        $private_key = openssl_pkey_get_private($private_key);
        if (!$private_key) {
            throw new \Exception('私钥不可用');
        }
        $return_de = openssl_private_decrypt(base64_decode($sign_str), $decrypted, $private_key);
        if (!$return_de) {
            throw new \Exception('解密失败,请检查RSA秘钥');
        }

        return $decrypted;
    }
}