<?php

namespace foxpay\exception;

class FoxPayException extends \Exception
{

    public function __construct(array $error, string $msg = null)
    {
        if($msg){
            $error['message'] = $msg . $error['message'];
        }

        $this->code = $error['code'];
        $this->message = $error['message'];

        parent::__construct($error['message'], $error['code'] . $error['message']);
    }
}