<?php

namespace Apps\Controller;
use Common\Controller\AppBaseController;
/**
 * 首页
 */

class PutSmsController extends AppBaseController {

	//发送群发短信
    public function SendQFSms(){
        ignore_user_abort(true);
        $messageid = $_GET["message_id"];
        $user = M("MessageSms")->where("message_id = $messageid")->select();//获取要发送短信的对象
        $message = M("UserMessage")->where("id = $messageid")->find();//获取要发送的内容
        $sms = new \Common\Controller\SmsController();//实例化短信类
        $sendphone = '';
        $ids = "";
        foreach ($user as $value) {
            $phone='';
            $phone_status='';
            if ($value[isstudent] == 1) {
                $stuid = $value[receiver_user_id];

                //查找学生所有家长手机号
                $student_phone = M("relation_stu_user")
                    ->where("studentid = '$stuid' ")
                    ->field('phone')
                    ->select();

                foreach ($student_phone as $val){
                    $phone .= $val[phone].",";
                    $phonestatus = $sms->IsPhone($val[phone]);

                    $phone_status .= $val[phone].":".$phonestatus['msg']."。";//保存手机号验证状态
                    if($phonestatus['status']) {
                        $sendphone .= $val[phone] . ",";//拼接所有手机号
                    }
                }

            }else{
                $phone = $value['receiver_user_phone'];
                $phonestatus = $sms->IsPhone($phone);
                $phone_status .= $phone.":".$phonestatus['msg']."。";//保存手机号验证状态

                if($phonestatus['status']) {
                    $sendphone .= $phone . ",";//拼接所有手机号
                }

            }
            $data['receiver_user_phone']=$phone;
            $data['phone_status']=$phone_status;
            $changid=$value['id'];
            M("MessageSms")->where("id = '$changid'")->save($data);
            $ids[] = $changid;
            $schoolid = $value['schoolid'];
        }
        $count=substr_count($sendphone,',');
        $sendphone = rtrim($sendphone,',');
        $sendtatus = $this->CountCompare($count,$schoolid);
        if($sendtatus == 2 ){
            foreach ($user as $val) {
                $changids=$val['id'];
                $data['phone_status']='学校剩余短信量不足，取消发送';
                M("MessageSms")->where("id = '$changids'")->save($data);
            }
            exit;
        }
        if($sendtatus == 3 ){
            foreach ($user as $val) {
                $changids=$val['id'];
                $data['phone_status']='学校尚未开通短信业务';
                M("MessageSms")->where("id = '$changids'")->save($data);
            }
            exit;
        }

        if($sendphone && ($sendtatus ==1))  {
            $SendStatus = $sms->SendSms($sendphone, $message['message_content'], 3);
            $where['id'] = array('in', $ids);
            $datas['send_sms_id'] = $SendStatus;
            M("MessageSms")->where($where)->save($datas);
        }
    exit;
    }
    //发送群发个性短信
    public function SendGXSms(){
        ignore_user_abort(true);

        $messageid = $_POST;
        $sms = new \Common\Controller\SmsController();//实例化短信类
        foreach ($messageid as $key=>$value)
        {
            $user = M("MessageSms")->where("message_id = $value")->find();//获取要发送短信的对象
            $message = M("UserMessage")->where("id = $value")->find();//获取要发送的内容
            $sendphone = '';

            if ($user[isstudent] == 1) {  //如果是学生
                $stuid = $user[receiver_user_id];

                //查找学生所有家长手机号
                $student_phone = M("relation_stu_user")
                    ->where("studentid = '$stuid' ")
                    ->field('phone')
                    ->select();

                foreach ($student_phone as $val){
                    $phone .= $val[phone].",";
                    $phonestatus = $sms->IsPhone($val[phone]);

                    $phone_status .= $val[phone].":".$phonestatus['msg']."。";//保存手机号验证状态
                    if($phonestatus['status']) {
                        $sendphone .= $val[phone] . ",";//拼接所有手机号
                    }
                }

            }else{
                $phone = $user['receiver_user_phone'];
                $phonestatus = $sms->IsPhone($phone);
                $phone_status .= $phone.":".$phonestatus['msg']."。";//保存手机号验证状态

                if($phonestatus['status']) {
                    $sendphone .= $phone . ",";//拼接所有手机号
                }

            }

            $data['receiver_user_phone']=$phone;
            $data['phone_status']=$phone_status;
            $changid=$user['id'];
            M("MessageSms")->where("id = '$changid'")->save($data);
            $schoolid= $user['schoolid'];
            $count=substr_count($sendphone,',');
            $sendtatus = $this->CountCompare($count,$schoolid);
            if($sendtatus == 2 ){
                    $datas['phone_status']='学校剩余短信量不足，取消发送';
                    M("MessageSms")->where("id = '$changid'")->save($datas);
                continue;;
            }
            if($sendtatus == 3 ){
                    $datas['phone_status']='学校尚未开通短信业务';
                    M("MessageSms")->where("id = '$changid'")->save($datas);
                continue;;
            }
            if($sendtatus ==1) {
                $sendphone = rtrim($sendphone, ',');
                if ($sendphone) {
                    $SendStatus = $sms->SendSms($sendphone, $message['message_content'], 4);
                    $where['id'] = $changid;
                    $datas['send_sms_id'] = $SendStatus;
                    M("MessageSms")->where($where)->save($datas);
                }
            }
        }
        exit;
    }

    /**校验学校剩余短信发送量是否足够
     * @param $count
     * @param $schoolid*
     * 返回 1，正常 ，2 ，剩余短信量不够，3，未开通短信业务
     */
    private function CountCompare($count,$schoolid){
        $message = M("SmsSchool")->where("schoolid = $schoolid")->find();//获取要发送的内容
        if (empty($message)){
            return 3;
        }
        $month = date('Y-m',time());
        $messages = M("SmsSchool")->where("schoolid = $schoolid and month = '$month'")->find();
        if(empty($messages)){
            $messagea = M("SmsSchool")->where("schoolid = $schoolid")->order("id desc")->find();
            $num = M("SchoolProduct")
                ->alias('sp')
                ->join("wxt_product p ON p.id=sp.productid")
                ->where("sp.schoolid = $schoolid and sp.producttype = 1")->order("sp.id desc")->field("p.num")->find();
            if(empty($num[num])){
                $num[num]=0;
            }
            if($messagea) {
                if ($messagea[lognum] > $messagea[taocannum]) {
                    $numss = $messagea[num] - $messagea[lognum] + $num[num];
                } else {
                    $numss = $messagea[num] - $messagea[taocannum] + $num[num];
                }
            }else{
                $numss = $num[num];
            }
            $data['schoolid'] = $schoolid;
            $data['num'] = $numss;
            $data['lognum'] = 0;
            $data['taocannum'] = $num[num];
            $data['month'] = $month;
            M("SmsSchool")->add($data);
        }
        $nownum = $messages[lognum]+$count;
        if($nownum <= $messages[num]){
            $datas[lognum]=$nownum;
            M("SmsSchool")->where("schoolid = $schoolid and month = '$month'")->save($datas);
            return 1;
        }else{
            return 2;
        }
    }

}