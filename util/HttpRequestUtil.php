<?php

namespace foxpay\util;

class HttpRequestUtil
{
    /*
        * url:访问路径
        * headers: 头部参数
        * */
    public function get(string $url,array $headers = [])
    {
        $header = array('Content-Type: application/json; charset=utf-8');

        foreach($headers as $k => $v){
            $header[] = "{$k}:{$v}";
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
        $output = curl_exec($ch);
        curl_close($ch);
        return json_decode($output,true);
    }

    /*
    * url:访问路径
    * array:要传递的数组
    * headers: 头部参数
    * */
    public function post(string $url,array $data,array $headers = [])
    {
        $data  = json_encode($data);

        $header = array('Content-Type: application/json; charset=utf-8', 'Content-Length:' . strlen($data));

        foreach($headers as $k => $v){
            $header[] = "{$k}:{$v}";
        }

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

        curl_setopt($curl, CURLOPT_POST, 1);

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        curl_setopt($curl, CURLOPT_HEADER, 1);

        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $res = curl_exec($curl);

        $headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);

        curl_close($curl);

        $headerStr = mb_substr($res, 0, $headerSize);
        $responseHeader = $this->headerHandler($headerStr);

        $responseBody = json_decode(mb_substr($res, $headerSize), true);

        if( isset($responseHeader['sign']) && $responseHeader['sign']){
            $responseBody['header_sign'] = $responseHeader['sign'];
        }

        return $responseBody;
    }


    public function headerHandler($headerStr) {

        $headerArr = explode("\r\n", $headerStr);

        if (empty($headerArr)) {
            return [];
        }

        $ret = [];

        foreach ($headerArr as $headerLine) {
            // HTTP响应头是以:分隔key和value的
            $split = explode(':', $headerLine, 2);
            if (count($split) > 1) {
                $key = trim($split[0]);
                $value = trim($split[1]);
                $ret[$key] = $value;
            }
        }

        return $ret;
    }
}