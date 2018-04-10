<?php
namespace app\index\controller;
use app\index\model\Record;
use app\index\model\Config;
use think\Controller;
use paopao7\alipay\DataHandle;

class Index extends Controller
{
    //首页面
    public function index()
    {
        $where['id'] = array('eq',1);
        $user = model("Users")->where($where)->find();

        $this->assign('user',$user);
        return view();
    }

    //记录页面
    public function record(){
        //获取账户余额
        $user = model('Users')->where('id=1')->find();

        $this->assign('user',$user);

        $where_record['user_id'] = array('eq',1);
        $list = Record::where($where_record)->order('id DESC')->paginate(10);

        $this->assign('list',$list);
        $this->assign("page",$list->render());
        return $this->fetch();
    }

    //配置页面
    public function config(){
        $where['id'] = array('eq',1);
        $result = model('Config')->where($where)->find();

        $this->assign('result',$result);
        return view();
    }

    //保存配置数据
    public function save_config(){
        $model = model('Config');


        $validate_flag = $this->validate($_POST,'Config');

        if($validate_flag === true){
            $flag = $model->save($_POST,['id'=>1]);

            if($flag){
                $this->success("配置成功",url("Index/Index/index"));
            }else{
                $this->error($validate_flag,url("Index/Index/config"));
            }
        }else{
            $this->error($validate_flag,url("Index/Index/config"));
        }

    }

    //支付调用
    public function pay_action(){
        //获取需要支付的金额
        $money = $_POST['money'];

        if(!preg_match("/^\d+\.?\d{0,2}$/",$money) || $money == 0){
            $this->error("充值金额有误，请重新输入",url("Index/Index/index"));
        }

        //查询配置表是否已完成配置
        $model_config = model('Config');
        $where_config['id'] = array('eq',1);

        $config_result = $model_config->where($where_config)->find();

        if(!$config_result or !$config_result['app_id'] or !$config_result['notify_url'] or !$config_result['return_url'] or !$config_result['alipay_public_key'] or !$config_result['merchant_private_key']){
            $this->error("配置信息不完整",url("Index/Index/index"));
        }

        //生成订单编号
        $out_trade_no = uniqid();

        //填写需要写入的数据
        $data = array(
            'user_id'=>1,
            'order_no'=> $out_trade_no,
            'money'=>$money
        );

        //写入充值记录表
        $model =  model('Record');

        $result  = $model->data($data)->save();

        //调用vendor下paopao7\alipay_webpay\DataHandle.php文件
        $webpay = new DataHandle();

        return $webpay->go_pay($money,$out_trade_no);
    }

    //该方法为接受支付宝回传参数以及修改对应订单状态的方法
    public function get_post(){
        $data = $_POST;//接受支付宝回调参数

        //将回调参数写入数据库，以供调试使用
        //调试时将数据库对应表中的json写死在这里，然后转化为数组
        /*
         * $data = '{"gmt_create":"2018-04-09 16:32:22","charset":"UTF-8".....}';
         * $data = json_decode($data,true);
         * */


        /*$model = model('Tmp');

        $new_data['post_data'] = json_encode($_POST);//回调参数为数组类型，需转化为json.
        $new_data['create_time'] = date('Y-m-d H:i:s',time());

        $flag = $model->data($new_data)->save();*/


        $webpay = new DataHandle();

        $result = $webpay->check_sign($data);

        //校验成功
        if($result){
            //根据订单号查询充值记录
            $model = model('Record');

            $where_order['order_no'] = array('eq',$_POST['out_trade_no']);
            $order_info = $model->where($where_order)->find();

            //该订单不存在
            if(!$order_info){
                echo "fail";
                return;
                //回传的金额不存在或者和查询到的订单的金额不一致
            }else if(!$_POST['total_amount'] || $_POST['total_amount'] != $order_info['money']){
                echo "fail";
                return;
                //回传状态不正确
            }else if($_POST['trade_status'] != "TRADE_SUCCESS"){
                echo "fail";
                return;
            }else{
                //根据订单号修改订单表数据
                $result = $this->change_order_data($_POST['out_trade_no']);

                if($result == true){
                    echo "success";
                }else{
                    echo "fail";
                    return;
                }
            }
        }else {
            //验证失败
            echo "fail";
        }

    }

    ////根据订单号修改订单表数据以及用户表金额数据
    public function change_order_data($out_trade_no){

        //根据订单号查询充值记录
        $model = model('Record');

        $where_order['order_no'] = array('eq',$out_trade_no);
        $order_info = $model->where($where_order)->find();

        //修改订单状态
        $new_data['status'] = 1;
        $new_data['update_time'];
        $flag1 = $model->save($new_data,['order_no'=>$out_trade_no]);//修改订单状态

        //更新用户余额信息
        $model_user = model('Users');
        $where_user['id'] = array('eq',$order_info['user_id']);

        $flag2 = $model_user->where($where_user)->setInc('money',$order_info['money']);

        if($flag1 and $flag2){
            return true;
        }else{
            return false;
        }


    }
}
