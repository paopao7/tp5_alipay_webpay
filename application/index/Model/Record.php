<?php
namespace app\index\model;
use think\Model;

class Record extends Model
{
    protected $insert = ["type","status","create_time"];
    protected $update = ["update_time"];

    protected function setTypeAttr(){
        return "支付宝支付";
    }

    protected function setStatusAttr(){
        return 0;
    }

    protected function setCreateTimeAttr(){
        return time();
    }

    protected function setUpdateTimeAttr(){
        return time();
    }
}