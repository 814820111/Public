<?php

namespace Apps\Controller;
use Common\Controller\AppBaseController;
/**
 * 首页
 */
class ResetPasswordController extends AppBaseController {

    function _initialize() {
        parent::_initialize();
    }

	//发送验证码
    public function SendVcode(){
        $phone=trim(I("phone"));
        $sms = new \Common\Controller\SmsController();
        $type='2';
        $identity='1';
        //校验手机号是否符合规则
        $isphone=$sms->IsPhone($phone,$type,$identity);

        if(!$isphone['status']){
            $info['status'] = false;
            $info['info'] = $isphone['msg'];
            echo json_encode($info);
            exit;
        }
        $code = rand(100000, 999999);
        //拼接短信内容
        $msg = "您好！您正在进行重置密码操作，验证码为：" . $code;

        $VCode = M("sms_vcode");
        $date["mobile"] = $phone;
        $date["type"] = 2;
        $date["vcode"] = $code;
        $date["send_date"] = date('Y-m-d H:i:s', time());
        $date["send_datetime"] = time();
        $VCode->add($date);

        $sms->SendSms($phone,$msg,$type);
        $info['status'] = true;
        $info['info'] = "验证码发送成功";
        if(!empty($isphone['imfo'])){
            $num=$isphone['imfo']+1;
            $info['info'] = '发送成功！今日已发送'.$num.'条，同一号码一天只允许发送5条短信';
        }
        echo json_encode($info);

    }
    //修改密码
    public function ResetPwd(){
        $Password = trim(I('password'));
        $phone = trim(I('phone'));
        $vcode = trim(I('vcode'));
        if(strlen($Password) < 6){
            $info['status'] = false;
            $info['info'] = "请输入6位以上的密码";
            echo json_encode($info);
            exit;
        }
        $id=M('wxtuser')
            ->where("phone='$phone'")
            ->field('id')
            ->find();

        if(empty($id['id'])){
            $info['status'] = false;
            $info['info'] = "此号码不存在";
            echo json_encode($info);
            exit;
        }

        $isvcode=$this->Vcode($phone,$vcode);
        if(!$isvcode['status']){
            echo json_encode($isvcode);
            exit;
        }

        $rel = M('wxtuser')->where("id= '$id[id]' ")->setField('password',md5($Password));

        if ($rel < 1) {
            $info['status'] = true;
            $info['info'] = '密码不能与上次相同';
            echo json_encode($info);exit;
        }

        $info['status'] = true;
        $info['info'] = '修改成功';
        echo json_encode($info);exit;
    }

    //验证验证码
    public function Vcode($phone,$vcode){
        //已在$sms->IsPhone($phone,1) 中判断过是否为老师
        $where['mobile']=$phone;
        $where['type']=2;//类型为首页忘记密码
        $resault = M('sms_vcode')->where($where)->order('id desc')->find();
        $info['status'] = true;
        $info['info'] = '验证成功';
        if(empty($resault)){
            $info['status'] = false;
            $info['info'] = '请先发送验证码';
        }
        if($resault['vcode'] !== $vcode){
            $info['status'] = false;
            $info['info'] = '验证码错误，请重新输入';
        }
        $now=time();
        $send_datetime=$resault['send_datetime'];
        if(($now-$send_datetime)>3600){
            $info['status'] = false;
            $info['info'] = '请先发送验证码';
        }
        if(($now-$send_datetime)>300){
            $info['status'] = false;
            $info['info'] = '验证码超时，请重新发送';
        }
        return $info;
    }
}