<?php

/**
 * 后台首页
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
class MobileMessageController extends TeacherbaseController {

    function _initialize() {
        parent::_initialize();

    }

    public function index() { 
       $schoolid = $_SESSION["schoolid"];

        $class=M('school_class')->field("id,classname")->where("schoolid=$schoolid")->order("id")->select();
        $student=M('class_relationship')
        ->alias("d")
        ->join("wxt_wxtuser w ON d.userid=w.id")
        ->field("w.id,w.name")
        ->order("w.id ASC")
        ->select();

        $this->assign("class",$class);
        $this->assign("student",$student);
       	$this->display("message");  
    }
    public function lists(){
        $search=I('search');
        $begintime=I("begintime");
        $endtime=I("endtime");
        $begin=strtotime($begintime);
        $end=strtotime($endtime);
        if($search){
            $where["title"]=array('LIKE',"%".$search."%");
        }
        if($begintime && $endtime){
            $where["create_time"]=array(array('EGT',$begin),array('ELT',$end));
        }
        $list=M('mobile_message')->order("id")->select();
        $count=M('mobile_message')->where($where)->count();    
        $page = $this->page($count, 20);
        $this->assign("Page", $page->show('Admin'));
        $this->assign("current_page",$page->GetCurrentPage());
        $this->assign("list",$list);
        $this->display();
    }
    public function message(){
        //用户ID
        $userid= I("userid");
        //密码
        $pwd ="111111";
        $content=I('content');
        $studentid=I('sl');
        $classid=I('cla');
        if($studentid){
            $phone=array();
            foreach ($studentid as &$item) {
                $uid=$item;
                $where["r.studentid"]=$uid;
                $where["r.type"]=1;
                $num=M('wxtuser')
                ->alias("m")
                ->join("wxt_relation_stu_user r ON m.id=r.userid")
                ->where("id=$uid")
                ->getField('m.phone');
                array_push($phone,$num);
            }
        }
        if($classid){
            $phone=array();
            $where["classid"]=array("in",$classid);
            $sid=M('class_relationship')->field("userid")->where($where)->select();
            foreach ($sid as &$item) {
                $uid=$item;
                $where["r.studentid"]=$uid;
                $where["r.type"]=1;
                $num=M('wxtuser')
                ->alias("m")
                ->join("wxt_relation_stu_user r ON m.id=r.userid")
                ->where("id=$uid")
                ->getField('m.phone');
                array_push($phone,$num);
            }
        }
        //生成随机六位数
        $code = I('content');
        //拼接短信内容
        $data =$code;
        // md5加密
        $sign =md5($userid ."|".$pwd."|" .$phone);
        //登录信息
        $post_data = array();
        $post_data['usr'] = iconv('GB2312', 'GB2312',$userid);
        $post_data['extdsrcid'] = iconv('GB2312', 'GB2312',"888888");
        $post_data['mobile'] = $phone;
        $post_data['sms']=mb_convert_encoding("$data",'GBK', 'auto');
        $post_data['sign'] = $sign;
        $url='http://60.190.233.237:6088/wmim/SMSSendYD?'; 
        $o="";
        //生成发送链接
        foreach ($post_data as $k=>$v){
           $o.= "$k=".urlencode($v)."&";
        }
        //去掉最后一个&
        $post_data=substr($o,0,-1);
        $this_header = array("content-type: application/x-www-form-urlencoded; charset=gbk");
        //初始化$ch
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_HTTPHEADER,$this_header);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $result = curl_exec($ch);
        // //将验证码发送到数据库
        $noteCode = M("mobile_message");
        $noteCode->add(array("userid"=>$userid,"mobile"=>$phone,"message_content"=>$code,"status"=>2,"is_show"=>1,"create_time"=>ti));
        
        // //返回短信发送状态及验证码
        $ret = $this->format_ret(1,array('code'=>$code));
        // echo $post_data;
        echo json_encode($ret);
        exit;
    }
}

