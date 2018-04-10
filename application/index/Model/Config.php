<?php
namespace app\index\model;
use think\Model;

class Config extends Model
{
    protected $update = ['update_time'];

    protected function setUpdateTimeAttr(){
        return time();
    }
}