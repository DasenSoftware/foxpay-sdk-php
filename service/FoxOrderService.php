<?php

namespace foxpay\service;

use foxpay\config\FoxPayAppConfig;
use foxpay\enum\CodeEnum;
use foxpay\exception\FoxPayException;
use foxpay\util\FoxPayRequestUtil;

class FoxOrderService
{

    //创建订单地址
    const ORDER_CREATE_URL = '/sdk/application/createApplicationOrder';
    //查询订单地址
    const ORDER_QUERY_URL = '/orderQuery';
    //关闭订单地址
    const CLOSE_ORDER_URL = '/sdk/application/closeApplicationOrder';
    //查询金额地址
    const GET_BALANCE_URL = '/sdk/application/getBalance';
    //提现凭证获取
    const TRANS_PREPARE_URL = '/sdk/application/transPrepare';
    //提现确认
    const TRANS_URL = '/sdk/application/trans';
    //提现记录查询
    const GET_TRANS_URL = '/sdk/application/getTrans';


    //创建订单
    public function orderCreate(array $data)
    {
        if (!$data) {
            throw new FoxPayException(CodeEnum::PARAM_NOT_NULL);
        }

        if(!$data['order_no']){
            throw new FoxPayException(CodeEnum::PARAM_ERROR,'order_no');
        }

        if(!$data['subject']){
            throw new FoxPayException(CodeEnum::PARAM_ERROR,'subject');
        }

        if(!$data['amount']){
            throw new FoxPayException(CodeEnum::PARAM_ERROR,'amount');
        }

        if(!$data['time_out']){
            throw new FoxPayException(CodeEnum::PARAM_ERROR,'time_out');
        }

        if(!$data['locale']){
            throw new FoxPayException(CodeEnum::PARAM_ERROR,'locale');
        }

        return FoxPayRequestUtil::orderRequest(self::ORDER_CREATE_URL,$data,FoxPayAppConfig::getConfig());
    }

    //查询订单
    public function orderQuery(array $data)
    {
        if (!$data) {
            throw new FoxPayException(CodeEnum::PARAM_NOT_NULL);
        }

        if(!$data['order_no'] && !$data['trade_no']){
            throw new FoxPayException(CodeEnum::PARAM_ERROR,'order_no or trade_no');
        }

        return FoxPayRequestUtil::orderRequest(self::ORDER_QUERY_URL,$data,FoxPayAppConfig::getConfig());
    }

    //关闭订单
    public function closeOrder(array $data)
    {
        if (!$data) {
            throw new FoxPayException(CodeEnum::PARAM_NOT_NULL);
        }

        if(!$data['order_no'] && !$data['trade_no']){
            throw new FoxPayException(CodeEnum::PARAM_ERROR,'order_no or trade_no');
        }

        return FoxPayRequestUtil::orderRequest(self::CLOSE_ORDER_URL,$data,FoxPayAppConfig::getConfig());
    }

    //查询金额
    public function getBalance()
    {
        return FoxPayRequestUtil::orderRequest(self::GET_BALANCE_URL,[],FoxPayAppConfig::getConfig(),'GET');
    }

    //提现凭证获取
    public function transPrepare(array $data)
    {
        if (!$data) {
            throw new FoxPayException(CodeEnum::PARAM_NOT_NULL);
        }

        if(!$data['order_no']){
            throw new FoxPayException(CodeEnum::PARAM_ERROR,'order_no');
        }

        if(!$data['amount']){
            throw new FoxPayException(CodeEnum::PARAM_ERROR,'amount');
        }

        if(!$data['to_address']){
            throw new FoxPayException(CodeEnum::PARAM_ERROR,'to_address');
        }

        return FoxPayRequestUtil::orderRequest(self::TRANS_PREPARE_URL,$data,FoxPayAppConfig::getConfig());
    }

    //提现确认
    public function trans(array $data)
    {
        if (!$data) {
            throw new FoxPayException(CodeEnum::PARAM_NOT_NULL);
        }

        if(!$data['trans_token']){
            throw new FoxPayException(CodeEnum::PARAM_ERROR,'order_no');
        }

        return FoxPayRequestUtil::orderRequest(self::TRANS_URL,$data,FoxPayAppConfig::getConfig());
    }

    //提现记录查询
    public function getTrans(array $data)
    {
        if (!$data) {
            throw new FoxPayException(CodeEnum::PARAM_NOT_NULL);
        }

        if(!$data['trade_no'] && !$data['order_no']){
            throw new FoxPayException(CodeEnum::PARAM_ERROR,'order_no or trade_no');
        }

        return FoxPayRequestUtil::orderRequest(self::GET_TRANS_URL,$data,FoxPayAppConfig::getConfig());
    }
}