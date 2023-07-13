<?php

namespace foxpay\enum;

class CodeEnum
{
    const SUCCESS = ['code' => 10000, 'message' => "成功"];
    const CONFIG_NOT_NULL = ['code' => 61000,'message' => "配置不能为空"];
    const PARAM_NOT_NULL = ['code' => 61001,'message' => "请求参数对象不能为空"];
    const RESPONSE_SIGN_ERROR = ['code' => 61002,'message' => "响应签名异常"];
    const REQUEST_SIGN_ERROR = ['code' => 61003,'message' => "请求签名异常"];
    const PARAM_ERROR = ['code' => 61004,'message' => "参数异常"];
    const CONFIG_ERROR = ['code' => 61005,'message' => "配置异常"];
    const FILE_ERROR = ['code' => 61006,'message' => "读取文件异常"];

    private $code;

    private $message;

}