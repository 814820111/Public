<?php
namespace Apps\Controller;
use Admin\Controller\MailBoxController;
use Common\Controller\WeixinbaseController;
header("Content-type: text/html; charset=utf-8"); 
//信息模板的推送
class TimingController extends WeixinbaseController
{
    private $url = "11111111";

    function _initialize()
    {

        $this->cook_url = "http://mp.zhixiaoyuan.net";
    }
   function index()
   {  

       $time = date('Y-m-d H:i',time());

       
       $plantimeint = strtotime($time);



       $plantim = M("plantimming")->where("plantimeint = $plantimeint and status = 1")->field("id,type,connent,contentid,schoolid,senduserid,plantime")->order("level")->select();

       // $plantim = M("plantimming")->where("id = 190")->order("level desc")->field("id,type,connent,contentid,schoolid,senduserid")->select();

       if($plantim){
     
         // $rowNo = 1
         // $error_info = array();
           foreach ($plantim as $key => $value) {
                 //消息类型 
                 $type = $value['type'];
                 //计划id
                 $planid = $value['id'];
                 //消息内容
                 $content = $value['connent'];
                 //文章iD
                 $message_id = $value['contentid'];
                 //学校节省查找
                 $schoolid = $value['schoolid'];
                 // var_dump($message_id);

                 $wxmanage = M('wxmanage_school')->alias("a")->join("wxt_wxmanage b ON a.manage_id = b.id")->where("a.schoolid = $schoolid")->field("b.wx_appid,b.wx_appsecret")->find();

                 $appid = $wxmanage['wx_appid'];

                 $appsecret = $wxmanage['wx_appsecret'];


                 //发送者ID
                 $senduserid = $value['senduserid'];
                 $complete = M("plantimming")->where("id = $planid")->save(array("status"=>4)); 
             
              switch ($type) {
                case '1':
                 $result = $this->message($planid,$senduserid,$content,$message_id,$schoolid,$appid,$appsecret);
                          
                  break;
                case '2':
                 $result = $this->notice($planid,$senduserid,$content,$message_id,$schoolid,$appid,$appsecret);
                
                case '3':
                    //h5页面传送时间
                    $cook_time = date('Y-m-d',strtotime($value['plantime']));

                 $result = $this->cookmanage($planid,$senduserid,$content,$message_id,$schoolid,$appid,$appsecret,$cook_time);
                  
                default:
                  break;


              }

           }

         }


   }
  
     //信息群发
    public function message($planid,$senduserid,$content,$message_id,$schoolid,$appid,$appsecret)

    {
        $detail = M("plantimmingdetail")->where("plantimmingid = $planid")->select();

        $data['APPID'] = $appid;
        $data['APPSECRET'] = $appsecret;
    
        $count = count($detail);
        

        foreach ($detail as $key => $value) {
          $type = $value['type'];


          if($type==1)
          {
            // var_dump($schoolid);
           // $userid = $value['receiveuserid'];     
           $url = "http://mp.zhixiaoyuan.net/index.php/Apps/sendTpl/classNotice";
    
          
           $data['schoolid'] = $schoolid;
           $data['message_id'] = $message_id;
           $data['userid'] = $senduserid;
           $data['classid'] = $value['classid'];
           $data['uisid'] = $value['receiveuserid'];
           $data['content'] = $content;
           $b = $this->http_request($url,$data);

          }else{
              $url = "http://mp.zhixiaoyuan.net/index.php/Apps/sendTpl/t_notice";
            // $url = "http://mp.zhixiaoyuan.net/index.php?g=Apps&m=sendTpl&a=t_notice";
            // var_dump($url);
            
              $data['message_id'] = $message_id;
              $data['content'] = $content;
              $data['userid'] =  $senduserid;
              $data['uisid'] = $value['receiveuserid'];
              $data['type'] = 2;
              
              $b = $this->http_request($url,$data);
              

          }
            
           //如果信息发送完 将计划任务修改为完成发送 
            if($key+1 == $count)
            {  

              $complete = M("plantimming")->where("id = $planid")->save(array("status"=>5));

              $message = M("user_message")->where("id=$message_id")->save(array("send_type"=>1));

            }

        }


    }

    public function notice($planid,$senduserid,$content,$message_id,$schoolid,$appid,$appsecret)
    {
      $detail = M("plantimmingdetail")->where("plantimmingid = $planid")->select();

       $count = count($detail);
   
       $result = 0;
        $data['APPID'] = $appid;
        $data['APPSECRET'] = $appsecret;
       // var_dump($result);

      foreach ($detail as $key => $value) {
      
     
         $type = $value['type'];
         if($type==1)
         {
           $url = "http://mp.zhixiaoyuan.net/index.php/Apps/sendTpl/school_notice";
           // $url = "http://mp.zhixiaoyuan.net/index.php?g=Apps&m=sendTpl&a=school_notice";
           $data['noticeid'] = $message_id;
           $data['userid'] = $senduserid;
           $data['type'] = 1;
           $data['uisid'] = $value['receiveuserid'];
           $data['content'] = $content;

         echo   $b = $this->http_request($url,$data);

         }else{
          $url = "http://mp.zhixiaoyuan.net/index.php/Apps/sendTpl/t_notice";
          // $url = "http://mp.zhixiaoyuan.net/index.php?g=Apps&m=sendTpl&a=t_notice";

              $data['message_id'] = $message_id;
              $data['content'] = $content;
              $data['userid'] =  $senduserid;
              $data['uisid'] = $value['receiveuserid'];
              $data['type'] = 3;
             echo $b = $this->http_request($url,$data);
         }  
          if($key+1 == $count)
          {
            $complete = M("plantimming")->where("id = $planid")->save(array("status"=>5));

            $notice = M("notice")->where("id = $message_id")->save(array("send_type"=>1));
          }



      }



    }

//定时食谱发送
    public function cookmanage($planid,$senduserid,$content,$message_id,$schoolid,$appid,$appsecret,$cook_data)
    {

        //查出年级段
        $cookbook = M("cookbook")->where("id = $message_id and schoolid = $schoolid")->find();
//        $grade = M("cookbook")->where("id = $message_id and schoolid = $schoolid")->getField("grade");


        //查出该年级段下的id
        $school_class = M("school_class")->where(array("grade"=>$cookbook['grade'],"schoolid"=>$schoolid))->field("id")->select();


       if(!$school_class)
       {
           return false;
       }
        $classid = "";

        foreach ($school_class as $class)
        {
            $classid .= $class["id"].",";

        }
        //将班级id拼接
        $classid = substr($classid,0,-1);

        if($cookbook['teachertype']==1)
        {
            $teacher = $this->remove_duplicate(M("teacher_class")->alias("class")->join("wxt_teacher_info info ON info.teacherid=class.teacherid")->field("info.name,class.teacherid,class.classid")->where("class.classid in($classid) and info.schoolid = $schoolid")->Distinct(true)->select());

            foreach ($teacher as $val)
            {
                $teacher_url = $this->cook_url ."/index.php/Apps/sendTpl/timing_cook";
                $teacher_data['APPID'] = $appid;
                $teacher_data['APPSECRET'] = $appsecret;
                $teacher_data['tid'] = $val['teacherid'];
                $teacher_data['teacher_name'] = $val['name'];
                $teacher_data['classid'] = $val['classid'];
                $teacher_data['schoolid'] = $schoolid;
                $teacher_data['userid'] = $senduserid;
                $teacher_data['content'] = $content;
                $teacher_data['date'] = $cook_data;
                $teacher_data['type'] = 2;

                $this->http_request($teacher_url,$teacher_data);
            }
        }



        $detail = M("class_relationship")->alias("c")->join("wxt_student_info as info ON c.userid=info.userid")->where("c.classid in($classid) and c.schoolid = $schoolid")->field("info.classid,info.stu_name,info.userid")->select();

        $count = count($detail);
         $data['APPID'] = $appid;
        $data['APPSECRET'] = $appsecret;
//        exit();

       foreach ($detail as $key => $value) {
           $url = $this->cook_url ."/index.php/Apps/sendTpl/timing_cook";
           $data['noticeid'] = $message_id;
           $data['userid'] = $senduserid;
           $data['schoolid'] = $schoolid;
           $data['classid'] = $value['classid'];
           $data['receiveusername'] = $value['stu_name'];
           // $data['type'] = 1;
           $data['tid'] = $value['userid'];
           $data['content'] = $content;
           $data['date'] = $cook_data;
           $data['type'] = 1;

           $b = $this->http_request($url,$data);

//          echo $b;

            if($key+1 == $count)
              {
                $complete = M("plantimming")->where("id = $planid")->save(array("status"=>5));
                  M("cookbook")->where("id = $message_id and schoolid = $schoolid")->save(array("timingtype"=>2));
              }

           // echo $b;
       
       }



    }

   //去重二维数组
    function remove_duplicate($array){
        $result=array();
        foreach ($array as $key => $value) {
            $has = false;
            foreach($result as $val){
                if($val['teacherid']==$value['teacherid']){
                   $has = true;
                 break;
                 }
               }
            if(!$has)
     $result[]=$value;
       }
        return $result;
   }
   public  function http_request($url, $data = array())
    {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
  // post数据
      curl_setopt($ch, CURLOPT_POST, 1);
  // 把post的变量加上
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
      $output = curl_exec($ch);
      curl_close($ch);
      return $output;
    }
	    //定时计划 把face图片 上传到七牛云
    public function face_qiniu_upload()
    {
                             $resource = fopen("./log.txt","a+");


        $where["photo_state"] = 1; //表示图片还没上传到七牛云
        $where["type"] = 1; //表示已录入的人
        $record = M("face_record")->where($where)->select();



        if(empty($record)){
            return;
        }
//        return;
        foreach ($record as $value)
        {
            $schoolid = $value["schoolid"]; //学校ID
            $photoUrl = $value["photourl"]; //face网址

            $url = "http://mp.zhixiaoyuan.net/Apps/QiNiu/face_upload";
            $data["schoolid"] = $schoolid;
            $data["photoUrl"] = trim($photoUrl);

            $query = $this->exit_file($data["photoUrl"]);
           // $a = print_r($result,true);
           // fwrite($resource, $query.date('Y-m-d H:i:s', time())."\r\n");

            //当$query未true时,表示face图片存在
            if($query==true)
            {
                $result = $this->http_request($url,$data);

                $photolist = json_decode($result,true);


//                $a = var_dump($result);
                //fwrite($resource, $photolist["status"].date('Y-m-d H:i:s', time())."\r\n");

                //status为1  表示图片上传七牛云成功
                if($photolist["status"]=="success")
                {

                    $qiniu_photoUrl = $photolist["data"]; //返回的七牛云图片
                    //修改人脸识别的七牛云图片
                    M("face_record")->where(array("photoUrl"=>$photoUrl))->save(array("qiniu_photoUrl"=>$qiniu_photoUrl,"photo_state"=>2));

                    //把学生考勤表的图片换成七牛云图片
                    M("attendances")->where(array("leavepicture"=>$photoUrl))->save(array("leavepicture"=>$qiniu_photoUrl));


                    //把老师考勤表的图片换成七牛云图片
                    M("teacher_attendances")->where(array("leavepicture"=>$photoUrl))->save(array("leavepicture"=>$qiniu_photoUrl));

                }
            }


        }
    }

    //判断图片是否存在
    public function exit_file($url){
        $opts=array(
            'http'=>array(
                'method'=>'HEAD',
                'timeout'=>2
            ));
        file_get_contents($url,false,stream_context_create($opts));
        if ($http_response_header[0] == 'HTTP/1.1 200 OK') {
            return true;
        } else {
            return false;
        }
    }




}