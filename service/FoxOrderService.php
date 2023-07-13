<?php

namespace foxpay\service;

use foxpay\config\FoxPayAppConfig;
use foxpay\enum\CodeEnum;
use foxpay\exception\FoxPayException;
use foxpay\util\FoxPayRequestUtil;

class FoxOrderService
{

    //创建订单地址
    const orderCreateUrl = '/sdk/application/createApplicationOrder';
    //查询订单地址
    const orderQueryUrl = 'orderQuery';
    //关闭订单地址
    const closeOrderUrl = '/sdk/application/closeApplicationOrder';
    //查询金额地址
    const getBalanceUrl = '/sdk/application/getBalance';

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

        return FoxPayRequestUtil::orderRequest(self::orderCreateUrl,$data,FoxPayAppConfig::getConfig());
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

        return FoxPayRequestUtil::orderRequest(self::orderQueryUrl,$data,FoxPayAppConfig::getConfig());
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

        return FoxPayRequestUtil::orderRequest(self::closeOrderUrl,$data,FoxPayAppConfig::getConfig());
    }

    //查询金额
    public function getBalance()
    {
        return FoxPayRequestUtil::orderRequest(self::getBalanceUrl,[],FoxPayAppConfig::getConfig(),'GET');
    }
}