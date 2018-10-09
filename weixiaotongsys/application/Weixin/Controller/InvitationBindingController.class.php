<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
session_start();
header( 'Content-Type:text/html;charset=utf-8 ');  
class InvitationBindingController extends WeixinbaseController
{

    function accept(){
        if(I("appid") and I("schoolid") and I("stu_name") and I("bindingkey")){
            $id = I("appid");//公众号ID
            $schoolid = I("schoolid");//学校ID
            $_SESSION["schoolid"] = $schoolid;
            $_SESSION["stu_name"] = I("stu_name");
            $_SESSION["bindingkey"] = I("bindingkey");
            $result = M("wxmanage")->where("id = $id")->find();
            $appid = $result["wx_appid"];
            $appsecret = $result["wx_appsecret"];
            $_SESSION["APPID"] = $appid; //获取公众号的APPID
            $_SESSION["APPSECRET"] = $appsecret; //获取公众号的 APPSECRET

            if($result){
                //这个链接是获取code的链接 链接会带上code参数
                $http = "http://".$_SERVER['HTTP_HOST'].__ROOT__;
                $REDIRECT_URI = "$http/index.php/weixin/InvitationBinding/getCode";
                $REDIRECT_URI = urlencode($REDIRECT_URI);
//                 $scope = "snsapi_base";
                $scope = "snsapi_userinfo";
                $state = md5(mktime());
                $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$_SESSION["APPID"]."&redirect_uri=".$REDIRECT_URI."&response_type=code&scope=".$scope."&state=".$state."#wechat_redirect";
                header("location:$url");
            }
        }
    }
		//用户同意之后就获取code  通过获取code可以获取一切东西了  机智如我
    function getCode(){
        //获取code
        $code = $_GET["code"];
        //用code获取access_yoken
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$_SESSION["APPID"]."&secret=".$_SESSION["APPSECRET"]."&code=".$code."&grant_type=authorization_code";
        //这里可以获取全部的东西  access_token openid scope
        $res = $this->https_request($url);
        $res  = json_decode($res,true);
        $openid = $res["openid"];
        $access_token = $res["access_token"];
        //这里是获取用户信息
        $url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
        $res = $this->https_request($url);
        $res = json_decode($res,true);

        //把用户的信息写入session 以备查用
        $weixin = $res["openid"];
        //sex
        $sex = $res["sex"];
        //头像
        $headimg = $res["headimgurl"];
        //昵称
        $nickname = $res["nickname"];
        $_SESSION["user"]['weixin'] = $weixin;
        $_SESSION["user"]['sex'] = $sex;
        $_SESSION["user"]['headimg'] = $headimg;
        $_SESSION["user"]['nickname'] = $nickname;
        $http = "http://".$_SERVER['HTTP_HOST'].__ROOT__;
        header("location:".$http."/index.php/weixin/InvitationBinding/build");

    }

    //跳转家长绑定页面
    public function build(){
        $studentid=$_SESSION["stu_name"];//学生id
        $student = M("student_info")->where(array('userid'=>$studentid))->find(); //查找学生信息
        //dump($student);
        $stu_name = $student["stu_name"]; //学生姓名
        $bindingkey=$_SESSION["bindingkey"] ;//绑定码
        $openid =  $_SESSION["user"]['weixin'];
        $headimg = $_SESSION["user"]['headimg'];//微信头像
        $nickname = $_SESSION["user"]['nickname'];//微信昵称
        $schoolid = $_SESSION["schoolid"]; //学校ID
        $this->assign("schoolid",$schoolid);
        $this->assign("stu_name",$stu_name);
        $this->assign("bindingkey",$bindingkey);
        $this->assign("headimg",$headimg);
        $this->assign("nickname",$nickname);
        $this->display();


    }
    //家长绑定处理
    public function buildings()
    {
        if(empty($_SESSION["user"]['weixin']) or empty($_SESSION["APPID"]) or empty($_SESSION["schoolid"])){
            $ret = format_ret(0,"页面停留过久,请关闭后重新打开");
            echo json_encode($ret);
            die();
        }
        $sid = I("schoolid");
        //如果没有这个关系 就看user表中是否纯在这个userid
        $stu_name = I("stu_name");
        $name = I("name");
        $phone = I("phone");
        $relation = I("relation");
        $build_number = I("number");
        //判断接受过来的值
        //先查学生表里面有没有这个学生  如果有就继续如果没有就pass
        $stu_res = M("student_info")->where("stu_name = '$stu_name' AND bindingkey = $build_number")->find();

        $manage_id = $_SESSION["manage_id"];//公众号ID
        //查询公众号绑定的学校
        if($stu_res){
            $schoolid = $stu_res["schoollid"];

            if($schoolid!==$sid){
                $content="不能绑定其他学校的学生";
                $this->Write_Weixin_StuLog($sid,$_SESSION["APPID"],$stu_name,$build_number,$name,$relation,$phone,2,$content);
                $ret = format_ret(0, "不能绑定其他学校的学生");
                echo json_encode($ret);
                die();
            }
        }


        //判断学生信息是否正确
        if (!$stu_res) {
            $content="学生信息核实失败,请您核实学生姓名/绑定码";
            $this->Write_Weixin_StuLog($sid,$_SESSION["APPID"],$stu_name,$build_number,$name,$relation,$phone,2,$content);
            $ret = format_ret(0, "学生信息核实失败,请您核实学生姓名/绑定码");
            echo json_encode($ret);
            die();
        }
        $stu_id = $stu_res['userid'];

        //判断学生的这个关系是否被绑定
        $where['a.studentid'] = $stu_id;


        if($relation==1 or $relation==2){
            if($relation==1){
                $appellation="爸爸";
            }
            if($relation==2){
                $appellation="妈妈";
            }
            $where['a.appellation'] = trim($appellation);
            //$rel_res = M("relation_stu_user")->where($where)->select();
            $rel_res = M("relation_stu_user as a")->join("wxt_xctuserwechat as b on a.userid=b.userid")->where($where)->select();
            if ($rel_res) {
                $content="该关系已经被绑定";
                $this->Write_Weixin_StuLog($sid,$_SESSION["APPID"],$stu_name,$build_number,$name,$relation,$phone,2,$content);
                $ret = format_ret(0, "该关系已经被绑定");
                echo json_encode($ret);
                die();
            }
        }
        if($relation==1){
            $relation="爸爸";
            $relations=1;
        }
        if($relation==2){
            $relation="妈妈";
            $relations=2;
        }
        if($relation==3){
            $relation="姑姑";
            $relations=3;
        }
        if($relation==4){
            $relation="奶奶";
            $relations=4;
        }

        $ret = M("relation_stu_user")->where(array("studentid"=>$stu_id))->select();
        $rets = count($ret);
        if ($rets>5){
            $content="绑定名额已经用完";
            $this->Write_Weixin_StuLog($sid,$_SESSION["APPID"],$stu_name,$build_number,$name,$relations,$phone,2,$content);
            $ret = format_ret(0, "绑定名额已经用完");
            echo json_encode($ret);
            die();
        }
        //写一个查询语句  查一下用户是否在用户表中
        $weixin = $_SESSION['user']['weixin'];
        $appid = $_SESSION["APPID"];
        // 根据微信和APPID判断该用户否存在
        $use_res = M("xctuserwechat")->where(array("weixin"=>$weixin,"appid"=>$appid))->order("id desc")->select();
        if(count($use_res)){
            foreach ($use_res as $value){
                $userid = $value["userid"]; //家长ID
                //这个微信号是否已经绑定了这个学生
                $sereach = M("relation_stu_user")->where("studentid = '$stu_id' AND userid = '$userid'")->select();
                if ($sereach) {
                    //如果有就返回说只能绑定一个
                    $content="该微信号已经绑定过这个孩子";
                    $this->Write_Weixin_StuLog($sid,$_SESSION["APPID"],$stu_name,$build_number,$name,$relations,$phone,2,$content);
                    $ret = format_ret(0, "该微信号已经绑定过这个孩子!");
                    echo json_encode($ret);
                    die();
                }
            }
        }

        //判断手机号码是否已经跟其他微信号绑定
        $users = M("wxtuser")->where(array("phone"=>$phone))->field("phone,id")->find();
        //        if(count($users)){
//            $weixinuser = M("xctuserwechat")->where(array("userid"=>$users["id"]))->find();
//            if(count($weixinuser) and $weixinuser["weixin"]==$weixin){
//                $ret = format_ret(0, "该手机号码已经绑定过其他微信关系,不能使用!");
//                echo json_encode($ret);
//                die();
//            }
//        }
        if(count($users)){
            $weixinuser = M("xctuserwechat")->where(array("userid"=>$users["id"],"appid"=>$appid))->find();
            if(count($weixinuser) and $weixinuser["weixin"]==$weixin){
                $content="该手机号码已经绑定过其他微信关系,不能使用!";
                $this->Write_Weixin_StuLog($sid,$_SESSION["APPID"],$stu_name,$build_number,$name,$relations,$phone,2,$content);
                $ret = format_ret(0, "该手机号码已经绑定过其他微信关系,不能使用!");
                echo json_encode($ret);
                die();
            }
        }
        $weixinwhere["a.phone"]=$phone;
        $weixinwhere["b.weixin"]=$weixin;
        $weixinwhere["b.appid"]=$appid;
        //根据微信和APPID、手机号码判断该用户否存在
        $wexinuser = M("wxtuser as a")->join("wxt_xctuserwechat as b on a.id=b.userid")->where($weixinwhere)->field("b.*")->find();
        if(count($wexinuser)){
            //存在,添加学生关系表relation（存在，说明之前用同一个手机号同一个微信号绑定过别的角色）
            $relation_data["userid"] =  $wexinuser["userid"];
            $relation_data["studentid"] = $stu_id;
            $relation_data['appellation'] = $relation;
            $relation_data["time"] = mktime();
            $relation_data["name"] = $name;
            $relation_data["phone"] = $phone;
            $rela_add_res = M("relation_stu_user")->add($relation_data); //增加一条关系
            //判断是否插入成功如果成功就返回成功 如果失败就返回失败了 请重试
            if ($rela_add_res) {
                $content="绑定成功";
                $this->Write_Weixin_StuLog($sid,$_SESSION["APPID"],$stu_name,$build_number,$name,$relations,$phone,1,$content);
                $ret = format_ret(1,"绑定成功");
                echo json_encode($ret);
                die();
            } else {
                $content="家属关系添加有误,请联系管理员";
                $this->Write_Weixin_StuLog($sid,$_SESSION["APPID"],$stu_name,$build_number,$name,$relations,$phone,2,$content);
                $ret = format_ret(0,"家属关系添加有误,请联系管理员");
                echo json_encode($ret);
                die();
            }
        }else{
            $user = M("wxtuser")->where("phone=$phone")->find();//查看原来是否存在导入数据
            if (count($user)) {
                $res = M("relation_stu_user")->where(array("userid"=>$user["id"],"studentid"=>$stu_id))->find();
                if(count($res)){
                    //存在,判断relation是否存在,存在表示之前导入过,添加一条微信关系记录,
                    $userid = $user["id"];
                    $schoolid = $stu_res["schoollid"];
                    $wechat_data["userid"] = $user["id"];
                    $wechat_data["weixin"] = $_SESSION["user"]['weixin'];
                    $wechat_data["appid"] = $_SESSION["APPID"];
                    $wechat_data["createtime"] = time();

                    $result = R('Apps/QiNiu/photo_upload', array($_SESSION["user"]['headimg']));
                    $photo = $result["data"]["filename"];
                    $user_data["photo"] = $photo;
                    $array = M("wxtuser")->where(array("id" => $userid))->save($user_data);
                    $arr = M("xctuserwechat")->add($wechat_data);
                    //粉丝关注表 修改学校ID
                    M("wechat_school_openid")->where(array("openid" => $weixin, "appid" => $appid))->save(array("schoolid" => $schoolid));
                    $content="绑定成功";
                    $this->Write_Weixin_StuLog($sid,$_SESSION["APPID"],$stu_name,$build_number,$name,$relations,$phone,1,$content);
                    $ret = format_ret(1, "绑定成功");
                    echo json_encode($ret);
                    die();
                }

                //不存在,添加一条user微信关系记录、添加一条relation记录
                $userid = $user["id"];
                $schoolid = $stu_res["schoollid"];
                $wechat_data["userid"] = $user["id"];
                $wechat_data["weixin"] = $_SESSION["user"]['weixin'];
                $wechat_data["appid"] = $_SESSION["APPID"];
                $wechat_data["createtime"] = time();

                $result = R('Apps/QiNiu/photo_upload', array($_SESSION["user"]['headimg']));
                $photo = $result["data"]["filename"];
                $user_data["photo"] = $photo;
                $array = M("wxtuser")->where(array("id" => $userid))->save($user_data);//修改头像
                $arr = M("xctuserwechat")->add($wechat_data);//添加微信记录

                $relation_data["userid"] =  $userid;
                $relation_data["studentid"] = $stu_id;
                $relation_data['appellation'] = $relation;
                $relation_data["time"] = mktime();
                $relation_data["name"] = $name;
                $relation_data["phone"] = $phone;
                $rela_add_res = M("relation_stu_user")->add($relation_data); //增加一条关系

                //粉丝关注表 修改学校ID
                M("wechat_school_openid")->where(array("openid" => $weixin, "appid" => $appid))->save(array("schoolid" => $schoolid));
                if($arr) {
                    $content="绑定成功";
                    $this->Write_Weixin_StuLog($sid,$_SESSION["APPID"],$stu_name,$build_number,$name,$relations,$phone,1,$content);
                    $ret = format_ret(1, "绑定成功");
                    echo json_encode($ret);
                    die();
                }else{
                    $content="绑定微信公众号关系失败,请联系管理员";
                    $this->Write_Weixin_StuLog($sid,$_SESSION["APPID"],$stu_name,$build_number,$name,$relations,$phone,2,$content);
                    $ret = format_ret(0, "绑定微信公众号关系失败,请联系管理员");
                    echo json_encode($ret);
                    die();
                }



            }else{
                //不存在,在新增一个user用户、添加一条user微信关系记录、添加一条relation记录
                $user_data['phone'] = $phone;
                $user_data['name'] = $name;
                $result = R('Apps/QiNiu/photo_upload', array($_SESSION["user"]['headimg']));
                $photo = $result["data"]["filename"];
                $user_data["photo"] = $photo;
                $user_data["create_time"] = mktime();
                $user_data["sex"] = 1;
                $user_data["schoolid"] = $stu_res["schoollid"];
                $user_data["password"] = md5(substr($phone,-6));
                //user表插入 然后再relation表创建东西
                $user_add_res = M("wxtuser")->add($user_data);
                if ($user_add_res) {
                    //往公众号 微信ID表 加数据
                    $wechat_data["userid"] = $user_add_res;
                    $wechat_data["weixin"] = $_SESSION["user"]['weixin'];
                    $wechat_data["appid"] = $_SESSION["APPID"];
                    $wechat_data["createtime"] = time();
                    $arr = M("xctuserwechat")->add($wechat_data);
                    $schoolid = $user_data["schoolid"];
                    //粉丝关注表 修改学校ID
                    M("wechat_school_openid")->where(array("openid" => $weixin, "appid" => $appid))->save(array("schoolid" => $schoolid));
                    //关系表里面加数据
                    $_SESSION['userid'] = $user_add_res;
                    $relation_data["studentid"] = $stu_id;
                    $relation_data["userid"] = $user_add_res;
                    $relation_data["appellation"] = $relation;
                    $relation_data["time"] = mktime();
                    $relation_data["name"] = $name;
                    $relation_data["phone"] = $phone;
                    $relation_add_res = M("relation_stu_user")->add($relation_data);
                } else {
                    $content="用户信息添加失败,请联系管理员!";
                    $this->Write_Weixin_StuLog($sid,$_SESSION["APPID"],$stu_name,$build_number,$name,$relations,$phone,2,$content);
                    $ret = format_ret(0, "用户信息添加失败,请联系管理员!");
                    echo json_encode($ret);
                    die();
                }
                $content="绑定成功!";
                $this->Write_Weixin_StuLog($sid,$_SESSION["APPID"],$stu_name,$build_number,$name,$relations,$phone,1,$content);
                $ret = format_ret(1, "绑定成功");
                echo json_encode($ret);
                die();

            }

        }

    }
    //跳转到老师绑定页面
    public function Tbuild(){
        $schoolid = $_SESSION["schoolid"]; //学校ID
        $this->assign("schoolid",$schoolid);
        $headimg = $_SESSION["user"]['headimg'];
        $nickname = $_SESSION["user"]['nickname'];
        $this->assign("headimg",$headimg);
        $this->assign("nickname",$nickname);
        $this->display();
    }


    //老师绑定处理
    public function Tbuilds(){

        if(empty($_SESSION["user"]['weixin']) or empty($_SESSION["APPID"]) or empty($_SESSION["schoolid"])){
            $ret = format_ret(0, "页面停留过久,请关闭后重新打开");
            echo json_encode($ret);
            die();
        }
        $sid = I("schoolid");
        $phone = I("name");//手机号码
        $number = I("card");//绑定码
        //根据手机号码在wxtuser表中查找用户是否存在
        $result = M("wxtuser")->where(array('phone'=>$phone))->find();
        if(empty($result)){

            $ret= $this->format_ret(0,"不存在这个手机号码");
            echo json_encode($ret);
            return;
        }
        $userid = $result['id'];//获取用户ID
        $query = M('teacher_info')->where(array("teacherid"=>$userid,"bindingkey"=>$number))->find();
        $schoolid = $query["schoolid"];

        if(empty($query)){
            $ret= $this->format_ret(0,"绑定码有问题，请联系学校管理员");
            echo json_encode($ret);
            return;
        }

        if($schoolid!==$sid){
            $ret = format_ret(0, "不能绑定其他学校的老师");
            echo json_encode($ret);
            die();
        }

        $weixin = $_SESSION["user"]["weixin"];//微信ID
        $appid = $_SESSION["APPID"];
        if(empty($weixin)){
            $ret = $this->format_ret(0,"绑定失败");
            echo json_encode($ret);
            return;
        }
        $data["photo"] = $_SESSION["user"]["headimg"];//微信头像
        if(empty($data["photo"])){
            $ret = $this->format_ret(0,"绑定失败");
            echo json_encode($ret);
            return;
        }else{
            //$photo = $this->test($_SESSION["user"]['headimg']);//将图片下载到本地
            $result = R('Apps/QiNiu/photo_upload',array($_SESSION["user"]['headimg']));
            $photo = $result["data"]["filename"];
            $data["photo"] = $photo;
        }
        $data["create_time"] = mktime();
        $array= M("wxtuser")->where(array("id" => $userid))->save($data);
        if($array){
            $wechat_data["userid"] =   $userid;
            $wechat_data["weixin"] =  $_SESSION["user"]['weixin'];
            $wechat_data["appid"] =  $_SESSION["APPID"];
            $wechat_data["createtime"] =  time();
            $arr = M("xctuserwechat")->add($wechat_data);
            //粉丝关注表 修改学校ID
            M("wechat_school_openid")->where(array("openid"=>$weixin,"appid"=>$appid))->save(array("schoolid"=>$schoolid));
        }
        if ($array){
            $ret = $this->format_ret(1,"绑定成功");
            echo json_encode($ret);
            return;
        }else{
            $ret = $this->format_ret(0,"绑定失败");
            echo json_encode($ret);
            return;
        }

    }
//写入绑定日志
    public function Write_Weixin_StuLog($schoolid,$appid,$stu_name,$bindingkey,$par_name,$relation,$phone,$status,$content)
    {
        $log_data["schoolid"] =  $schoolid;
        $log_data["bindingtype"] =  1;
        $log_data["appid"] =  $appid;
        $log_data["stu_name"] = $stu_name;
        $log_data["bindingkey"] =  $bindingkey;
        $log_data["par_name"] =  $par_name;
        $log_data["relation"] =  $relation;
        $log_data["phone"] =  $phone;
        $log_data["status"] =  $status;
        $log_data["content"] =  $content;
        $log_data["binddate"] =  date("Y-m-d",time());
        $log_data["bind_datetime"] =  date("Y-m-d H:i:s",time());
        $log_data["bind_datetime_int"] =  time();
        $logres = M("wxbinding_log")->add($log_data);
    }

    //教师绑定日志写入

    public function format_ret($status, $data = '')
    {
        if ($status) {
            //成功
            return array('status' => 'success', 'data' => $data);
        } else {
            //验证失败
            return array('status' => 'error', 'data' => $data);
        }
    }
    function https_request($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

}