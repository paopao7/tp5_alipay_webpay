<?php
namespace app\Index\Validate;
use think\Validate;

class Config extends Validate{
    protected $rule = [
        ['app_id','require','请输入app_id'],
        ['notify_url','require','请输入异步通知地址'],
        ['return_url','require','请输入同步跳转地址'],
        ['alipay_public_key','require','请输入支付宝公钥'],
        ['merchant_private_key','require','请输入应用私钥']
    ];
}