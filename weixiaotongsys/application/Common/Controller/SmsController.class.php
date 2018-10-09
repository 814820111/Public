<?php

namespace Common\Controller;
use Think\Controller;
/**
 * 发送短信
 * 先用IsPhone 判断手机号
 * 在SendSms发送短信
 */
class SmsController extends Controller {
    /*
    * 发送短信
     * $phone 手机号
     * $msg 短信内容
     * $type 保存到数据库的标识 0:未指定，1:老师重置密码，2忘记密码
    */
    public function SendSms($phone,$msg,$type = '0'){
        //发送短信
       $result = $this->send_SMS($phone,$msg);
        //保存日志
       $log = $this->Smslog($phone,$msg,$type,$result[code]);
        return $log;
    }

    /*发送短信
     * $phone 手机号码
     * $msg 短信内容
     */
    public function send_SMS($phone,$msg)
    {
        //用户ID
        $userid = "201803140955";
        //密码
        $pwd = "1Nm[8BaP2X";
        // md5加密
        $channel_key = md5($userid . "|" . $pwd . "|" . $phone);
        //登录信息
        $post_data = array();
        $post_data['mobile'] = $phone;
        $post_data['channel_id'] = $userid ;
        $post_data['channel_key'] = $channel_key;
        $post_data['sign'] = "智校园";
        $post_data['message'] = $msg;
        //$url = 'http://116.62.125.48:8081/api1/ent/sendSMSCN?';
        $url = "https://api.caowuzi.cn/api1/ent/sendSMSCN?";
        $headers = array("Content-type: application/json;charset='utf-8'","Accept: application/json","Cache-Control: no-cache","Pragma: no-cache");
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60); //设置超时
       // $url = '这里为请求地址';
        if(0 === strpos(strtolower($url), 'https')) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); //对认证证书来源的检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); //从证书中检查SSL加密算法是否存在
        }
        curl_setopt($ch, CURLOPT_POST, TRUE);
        $data = array(0=>1,1=>2);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $rtn = curl_exec($ch);//CURLOPT_RETURNTRANSFER 不设置  curl_exec返回TRUE 设置  curl_exec返回json(此处) 失败都返回FALSE
        curl_close($ch);

        $result = json_decode($rtn,true);

        return $result;
    }

    /*保存发送日志
    *   $phone手机号
     *  $msg 发送的内容
     *  $type 类型 0:未设定 1：老师重置密码 2：忘记密码
     *  $code 短信接口返回的状态码，详见文档
     */
    public function Smslog($phone,$msg,$type,$code)
    {
        $log_data["mobile"] =  $phone;
        $log_data["type"] =  $type;
        $log_data["code"] =  $code;
        $log_data["content"] =  $msg;
        $log_data["send_dateday"] = date('Y-m-d', time());
        $log_data["send_date"] =  date("Y-m-d H:i:s",time());
        $log_data["send_datetime"] =  time();
        $logres = M("sms_log")->add($log_data);
        return $logres;
    }

    /*验证手机号
   *   $phone手机号
     * $type 短信类型，为空表示不限制发送次数
     * $identity 身份，1:教师
     *返回数组$isphone
     * $arr['status'] 校验状态
     * $arr['msg'] 信息
     * $arr['imfo'] 默认空，提示今日剩余短信次数
    */
    public function IsPhone($phone,$type = null,$identity = null)
    {
        $arr['status']=true;
        $arr['msg']="手机号校验通过";
        //判断是否为手机号
        if($phone == "13000000000"){
            $arr['status']=false;
            $arr['msg']="该用户手机号为13000000000";
            return $arr;
        }
        $is_mobile=$this->is_mobile($phone);
        if(!$is_mobile){
            $arr['status']=false;
            $arr['msg']="请输入正确的手机号";
            return $arr;
        }

        $id=M('wxtuser')->where("phone='$phone'")->field('id')->find();
        if(empty($id['id'])) {
            $arr['status'] = false;
            $arr['msg'] = "不存在此号码的用户";
            return $arr;
        }
            //判断该手机号是否存在该身份用户，1:教师
        switch ($identity) {
            case 1:
                $teacherid=M('teacher_info')->where("teacherid='$id[id]'")->field('id')->find();
                if(empty($teacherid['id'])) {
                    $arr['status'] = false;
                    $arr['msg'] = "不存在此电话号码的教师";
                    return $arr;
                }
            default:
                ;
        }
        if(!empty($type)){
            $nowday = date('Y-m-d', time());
            $nowtime =  time()-60;
            $onemin=M('sms_log')->where("mobile='$phone' and send_datetime > '$nowtime' and type='$type' ")->field('id')->find();
            if($onemin['id']) {
                $arr['status'] = false;
                $arr['msg'] = "同一号码一分钟只允许发送一次短信";
                return $arr;
            }
            $oneday=M('sms_log')->where("mobile='$phone' and send_dateday = '$nowday' and type='$type' ")->field('id')->count();
            if( $oneday >4 ) {
                $arr['status'] = false;
                $arr['msg'] = "今日短信发送次数已达限额";
                return $arr;
            }
            if( $oneday >2 ) {
                $arr['imfo'] = $oneday;
            }
        }

        return $arr;
    }
    /*验证手机号
  *   $phone手机号
   */
    public function is_mobile( $phone ) {
        $search = '/^13[0-9]{1}[0-9]{8}$|15[0189]{1}[0-9]{8}$|189[0-9]{8}$/';
        if ( preg_match( $search, $phone ) ) {
            return ( true );
        } else {
            return ( false );
        }
    }
}