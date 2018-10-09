<?php

/**
 * 后台首页  日常管理
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;

class ArticleManageController extends AdminbaseController {

    protected $school_column_model;
    protected $school_article_model;

    function _initialize() {
        parent::_initialize();
        $this->school_model = D("Common/School");
        $this->wxtuser_model = D("Common/wxtuser");
        $this->wxt_agent_model=D("Common/agent");
        $this->schoolnotice_model=D("Common/schoolnotice");

        $this->school_article_model = M("School_web_article");
        $this->school_column_model = M("School_column");
    }

    public function index() {
        $this->_lists();
        $this->_getTree();
        $this->display("");
    }
    private  function _lists(){
        $Province=role_admin();
        $this->assign("Province",$Province);



        $pro = I("province"); //地区

        if($pro){
            $this->assign("province",$pro);
        }

        $citys = I("citys");
        if($citys){
            $this->assign("new_citys",$citys);
        }

        $message_type = I("message_type");
        if($message_type){
            $this->assign("new_message_type",$message_type);
        }

        $schoolid = I("schoolid"); //学校
        if($schoolid){
            $where["s.schoolid"]=$schoolid;

            $schoolid= I("schoolid");

            $this->assign("schoolid",$schoolid);
        }else{
            $where["s.schoolid"]=0;
        }
        $column_id = I("columnid");
        if($column_id){
            $where["a.column_id"]=$column_id;
            $this->assign("columnid",$column_id);
        }

        if($pro && $citys)
        {
            //写入缓存
            write_condition($pro,$citys,$message_type,$schoolid,$this->only_code);

        }
        $cache_data = get_condition_cache($this->only_code);
        $this->assign("cache_data",$cache_data);

        $count = $this->school_article_model
            ->alias("a")
            ->join("wxt_school_column s ON a.column_id=s.id")
            ->join("wxt_school school on s.schoolid=school.schoolid")
            ->where($where)
            ->field("a.*,s.name,school.school_name,s.schoolid")
            ->count();
        $page = $this->page($count,20);
        $article = $this->school_article_model
            ->alias("a")
            ->join("wxt_school_column s ON a.column_id=s.id")
            ->join("wxt_school school on s.schoolid=school.schoolid")
            ->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)
            ->field("a.*,s.name,school.school_name,s.schoolid")
            ->select();
        //查询该学校所有的栏目
        $this->assign("Page", $page->show('Admin'));
        $this->assign("articles",$article);

    }

    //获取栏目
    public function get_column()
    {
        $schoolid= I("schoolid");
        $column = $this->school_column_model->where(array("schoolid"=>$schoolid,"column_type"=>1))->select();
        $result = $this->getCate($column,0);
        foreach ($result as &$val)
        {
            $val["name"] = str_repeat('&nbsp', $val['count'] * 5).'|--'.$val['name'];
        }
        echo json_encode(array('data'=> $result,'message'=>'10000'));
    }

    function getCate($data, $id, $count = 0)
    {
        static $res = array();
        foreach ($data as $val) {
            if ($val['parentid'] == $id) {
                $val['count'] = $count;
                //var_dump($val['pid']);
                //var_dump($val);
                $res[] = $val;
                $this->getCate($data, $val['id'], $count + 1);
            }
        }
        return $res;
    }

//------------------增加文章----------------
  function add(){


      $Province=role_admin();
      $this->assign("Province",$Province);

      $pro = I("province"); //地区

      if($pro){
          $this->assign("province",$pro);
      }

      $citys = I("citys");
      if($citys){
          $this->assign("new_citys",$citys);
      }

      $message_type = I("message_type");
      if($message_type){
          $this->assign("new_message_type",$message_type);
      }


      $schoolid = I("schoolid"); //学校
      if($schoolid){
          $column = $this->school_column_model->where(array("schoolid"=>$schoolid,"column_type"=>1))->select();
          $result = $this->getCate($column,0);
          foreach ($result as &$val)
          {
              $val["name"] = str_repeat('&nbsp', $val['count'] * 5).'|--'.$val['name'];
          }

         // dump($result);
          $this->assign("column",$result);
//          $this->assign("column",$column);
          $this->assign("schoolid",$schoolid);

      }else{
          $where["a.schoolid"]=0;
      }

      if($pro && $citys)
      {
          //写入缓存
          write_condition($pro,$citys,$message_type,$schoolid,$this->only_code);

      }
      $cache_data = get_condition_cache($this->only_code);
      $this->assign("cache_data",$cache_data);
      $this->display();
    }
    
//    function add_post(){
////      dump($_POST);
////      die();
////        dump($_SESSION);
////        die();
//        $checktype= $_POST["checktype"];
//            if(empty($_POST['columnid'])){
//                $this->error("请至少选择一个分类栏目！");
//            }
//            $notice['smeta'] = $_POST['smeta']['thumb'];
//            $notice['post_date']=date("Y-m-d H:i:s",time());
//            $notice['schoolid']=$_POST['schoolid'];
////            $notice['userid'] = $_SESSION['USER_ID'];
//            $notice['userid'] = 0;
//            if(empty($_POST['smeta']['thumb'])){
//
//                $notice['smeta']="http://ow3hm6y11.bkt.clouddn.com/img12.png";
//            }
//
//            $notice['istop'] = $_POST['post']['istop'];
//            $notice['column_id'] = $_POST['columnid'];
//            $notice['create_time']= time();
//            $notice['post_excerpt'] = $_POST['post']['post_excerpt'];
//            $notice['post_title'] = $_POST['post']['post_title'];
//            $notice['post_content']=htmlspecialchars_decode($_POST['post']['post_content']);
//            $result=$this->school_article_model->add($notice);
//            $notice['post_status'] = $_POST['post']['post_status'];
//
//
//            if ($result!==false) {
//
//                if($checktype)
//                {
//                    $articleid = $result;
//                    $column_id =$_POST['columnid'];
//                    $userid = 0;
//                    $content =$_POST['post']['post_excerpt'];
//                    $this->wechat_push($articleid,$_POST['schoolid'],$column_id,$userid,$content,$notice['post_title'],1,"");
//                }
//
//                $this->success("保存成功！",U("index"));
//            } else {
//                $this->error("保存失败！");
//            }
//
//    }

    //文章提交
    public function add_post(){
        $checktype= $_POST["checktype"];
        if(empty($_POST['columnid'])){
            $this->error("请至少选择一个分类栏目！");
        }
        $notice['smeta'] = $_POST['smeta']['thumb'];
        $notice['post_date']=date("Y-m-d H:i:s",time());
        $notice['schoolid']=$_POST['schoolid'];
//            $notice['userid'] = $_SESSION['USER_ID'];
        $notice['userid'] = 0;
        if(empty($_POST['smeta']['thumb'])){

            $notice['smeta']="http://ow3hm6y11.bkt.clouddn.com/img12.png";
        }

        $notice['istop'] = $_POST['post']['istop'];
        $notice['column_id'] = $_POST['columnid'];
        $notice['create_time']= time();
        $notice['post_excerpt'] = $_POST['post']['post_excerpt'];
        $notice['post_title'] = $_POST['post']['post_title'];
        $notice['post_content']=htmlspecialchars_decode($_POST['post']['post_content']);
        $notice['type'] = $_POST['type'];
        $notice['post_status'] = $_POST['post']['post_status'];
        if($_POST['type']==1)   //表示微网站文章
        {

            $result=$this->school_article_model->add($notice);
            if ($result!==false) {

                if($checktype)
                {
                    $articleid = $result;
                    $column_id =$_POST['columnid'];
                    $userid = 0;

                    $content =$_POST['post']['post_excerpt'];
//
                    $this->wechat_push($articleid,$_POST['schoolid'],$column_id,$userid,$content,$notice['post_title'],1,"");
                }

                $this->success("保存成功！",U("index"));
            } else {
                $this->error("保存失败！");
            }
        }

        if($_POST['type']==2)   //表示微信图文
        {
            $articleid=$this->school_article_model->add($notice);
            if($articleid)
            {
                $url = $this->add_thumb_material($notice,$_POST['schoolid'],$articleid);
                if($url)
                {
                    if($checktype)
                    {
                        $column_id =$_POST['column'];
                        $userid = 0;
                        $content =$_POST['post']['post_excerpt'];
                        $this->wechat_push($articleid,$_POST['schoolid'],$column_id,$userid,$content,$notice['post_title'],2,$url);
                    }
                    $this->success("添加成功！",U("index"));
                }


            }else{
                $this->error("保存失败！");
            }

        }



    }
    //方法内调用--------------
    function get_fileext($file='')
    {
        return strtolower(substr(strrchr($file,'.'),1));
    }
    //添加微信图文信息
    public function  add_thumb_material($notice,$schoolid,$articleid)
    {
        $_picurl = $notice["smeta"];
        $root = $_SERVER["DOCUMENT_ROOT"]."/uploads/material/";
        //下载图片 到本地
        $imagurl = $this->download($_picurl,$root);
        if($imagurl)
        {
            $filedata = array("media"=>"@".$imagurl);
        }else{
            $rst = $this->school_article_model->where("id=$articleid")->delete();
            $this->error("图片下载失败！");
            //return;
        }

        $wxmanage = M("wxmanage_school as a")->join("wxt_wxmanage as b on a.manage_id = b.id")->where(array("a.schoolid"=>$schoolid))->field("b.wx_appid,b.wx_appsecret")->find();

        $token = $this->getAccessToken($wxmanage["wx_appid"],$wxmanage["wx_appsecret"]);

        //上传封面
        $url = "https://api.weixin.qq.com/cgi-bin/material/add_material?access_token=".$token."&type=image";
        $res = $this->https_request($url,$filedata);
        $newres = (array)json_decode($res);

        //把文章内的图片上传到微信图文上
        preg_match_all('/<img([ ]+)src="([^\"]+)"/i',stripslashes($notice['post_content']),$matches);

//        dump($matches);

        if($matches[2])
        {
            foreach($matches[2] as $key => $val)
            {
                if ( strpos( $val, 'qpic.cn' ) === false ) {

                    $root = $_SERVER["DOCUMENT_ROOT"]."/uploads/material/";
                    //下载图片 到本地
                    $imagurl = $this->download($val,$root);
                    if($imagurl)
                    {
                        $filedata = array("media"=>"@".$imagurl);
                        $url='https://api.weixin.qq.com/cgi-bin/media/uploadimg?access_token='.$token;

                        if(is_file($imagurl) && in_array(strtolower($this->get_fileext($imagurl)),array('jpg','png')))
                        {
                            $output=(array)json_decode($this->http_media_request($url,$filedata));
                            // dump($output);

                            if(isset($output['url']))
                            {
                                $notice['post_content']=str_replace($val,$output['url'],$notice['post_content']);
//                        dump(str_replace($val,$output['url'],$notice['post_content']));
                                $savedata["post_content"] = $notice['post_content'];
                            }
                        }
                    }

                }

            }
            $notice['post_content'] = str_replace( '"', '\"',  $notice['post_content'] );
            $notice['post_content'] = str_replace( "'", '\'',  $notice['post_content']);
        }


        if(empty($newres["media_id"]))
        {
            $rst = $this->school_article_model->where("id=$articleid")->delete();
            $this->error("上传微信封面失败！");
            //return;
        }

        $thumb_media_id = $newres["media_id"];
        $savedata["picurl"] = $newres["url"];
        $savedata["thumb_media_id"] = $thumb_media_id;

        //添加微信图文
        $data['title']=urlencode($notice['post_title']);
        $data['thumb_media_id'] = $thumb_media_id;
//        $data['author']=$_POST['author'];
        $data['digest']=urlencode($notice['post_excerpt']);
        $data['show_cover_pic']=1;
        $data['content']=urlencode(htmlspecialchars_decode($notice['post_content']));
        $data['content_source_url']="";

        $url="https://api.weixin.qq.com/cgi-bin/material/add_news?access_token=".$token;
        $data = array(
            "articles"=>array($data),
        );//这里一定要注意
        $data = urldecode(json_encode($data));
        $result = $this->http_request($url,$data);
        $news_result = json_decode($result, true);
        // dump($news_result); //返回 "media_id":MEDIA_ID QVqFyY4hY4_xpPf_lO2OG1fIslTDY4wzkgg72IOeoDo
        if(empty($news_result["media_id"]))
        {
            $rst = $this->school_article_model->where("id=$articleid")->delete();
            $this->error("上传微信图文失败！");
            //return;
        }
        $media_id = $news_result["media_id"];
        $savedata["media_id"] = $media_id;

        $get_url = "https://api.weixin.qq.com/cgi-bin/material/get_material?access_token=".$token;
        $getdata["media_id"] = $media_id;
        $getres = $this->https_request($get_url,json_encode($getdata));
        $get_material = array(json_decode($getres));
//            echo $get_material[0]["news_item"][0]["url"];
//            dump($get_material);

        if($get_material['errcode'])
        {
            $rst = $this->school_article_model->where("id=$articleid")->delete();
            $this->error("获取url失败！");
            return;
        }

        foreach ($get_material as $materialvalue){
            $materialvalue=(array)$materialvalue;
            foreach ($materialvalue["news_item"] as $value){
                $value=(array)$value;

                $savedata["url"] = $value["url"];
            }
        }
//            dump($savedata);
//        die();
        $saveresult=$this->school_article_model->where(array("id"=>$articleid))->save($savedata);
        if ($saveresult!==false) {

            return $savedata["url"];
//                $this->success("添加成功！",U("index"));
        } else {
            $rst = $this->school_article_model->where("id=$articleid")->delete();
            $this->error("添加失败！");
        }





    }

    //-----方法内调用----------------
    public function download($url, $path)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        $file = curl_exec($ch);
        curl_close($ch);
        $filename = pathinfo($url, PATHINFO_BASENAME);
        $resource = fopen($path . $filename, 'a');
        $file = fwrite($resource, $file);
        fclose($resource);
        if($file){
            return $path . $filename;
        }else{
            return false;
        }


    }

    //https请求（支持GET和POST）
    protected function https_request($url, $data = null)
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
    function http_request($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);

        if (!empty($data))
        {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($data))
            );
        }

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

    function http_media_request($url, $data = array())
    {
        $ch = curl_init();

        if (class_exists('CURLFile'))
        {
            curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true);
        }
        else
        {
            if (defined('CURLOPT_SAFE_UPLOAD'))
            {
                curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
            }
        }
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_POST,true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    function getAccessToken($appid,$appsecret)
    {
//        $appid = $this->appId;
//        $appsecret = $this->appSecret;

        $result = M("wxmanage")->where("wx_appid = '$appid'")->find(); //令牌刷新时间

        $time = $result["token_expire_int"]; //令牌过期时间
        //第一次是access_token不存在 就重新获取一个
        if (time()>$time  || empty($time)) {
            //获取token
//            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . APPID . "&secret=" . APPSECRET;
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appid . "&secret=" . $appsecret;
            //获取token
            $ch  = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($ch);
            curl_close($ch);
            $jsoninfo                   = json_decode($output, true);
            $access_token               = $jsoninfo["access_token"];
            //重新写进 数据库
            $data["token_expire_timeint"] = time();
            $data["authorizer_access_token"]       = $access_token;
            $data["token_expire_int"]       = time()+6500;
            $data["token_refresh_timeint"]       = time();
            $res   = M("wxmanage")->where("wx_appid = '$appid'")->save($data);
        } else {
            $arr = M("wxmanage")->where("wx_appid = '$appid'")->find();
            $access_token = $arr["authorizer_access_token"];
        }
        return $access_token;
    }

    public function find_userid($schoolid,$is_public,$appid)
    {
        if($is_public==1)  //统一公众号
        {
            $teacher = M("teacher_info")->where(array("schoolid"=>$schoolid))->field("teacherid")->select();
            foreach ($teacher as $value)
            {
                $newteacher[] = $value["teacherid"];
            }
            $student = M("student_info as a")->join("wxt_relation_stu_user as b on a.userid=b.studentid")->where(array("a.schoollid"=>$schoolid))->field("b.userid")->select();
            foreach ($student as $value)
            {
                $newstudent[] = $value["userid"];
            }

            $newarr = array_unique(array_filter(array_merge($newteacher,$newstudent)));
            return  implode(",",$newarr);
        }else{  //单一公众号

            $wechat = M("xctuserwechat")->where(array("appid"=>$appid))->field("userid")->select();
            foreach ($wechat as $value)
            {
                $newwechat[] = $value["userid"];
            }
            $newarr = array_unique(array_filter($newwechat));
            return  implode(",",$newarr);
        }

     // return "2431,10040";
    }

    public function wechat_push($articleid,$schoolid,$column_id,$userid,$content,$title,$urltype,$articleurl)
    {

        $wxmanage = M("wxmanage_school as a")->join("wxt_wxmanage as b on a.manage_id = b.id")->where(array("a.schoolid"=>$schoolid))->field("b.wx_appid,b.wx_appsecret,b.is_public")->find();
        $appid = $wxmanage["wx_appid"];
        $appsecret = $wxmanage["wx_appsecret"];
        $is_public = $wxmanage["is_public"];

        $uisid = $this->find_userid($schoolid,$is_public,$appid);
        $data["uisid"] = $uisid;  //接收人ID

        $data['APPID'] = $appid;
        $data['APPSECRET'] = $appsecret;

        $school = M("school")->where(array("schoolid"=>$schoolid))->field("school_name")->find();  //学校名称
        $teacher = M("teacher_info")->where(array("schoolid"=>$schoolid,"teacherid"=>$userid))->field("name")->find();//老师名字

        //发送人

        $url = "http://mp.zhixiaoyuan.net/index.php/Apps/sendTpl/article_Notice";
        $data['schoolid'] = $schoolid;
        $data['articleid'] = $articleid;
        $data['userid'] = $userid;
        $data['column_id'] = $column_id;
        $data['type'] = 1;
        $data['content'] = $content;
        $data['school_name'] = $school["school_name"];
        $data['teachername'] = $teacher["name"];
        $data['title'] = $title;
        $data['urltype'] = $urltype;
        $data['articleurl'] = $articleurl;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置是否返回response header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        //当需要通过curl_getinfo来获取发出请求的header信息时，该选项需要设置为true
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        // 把post的变量加上
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($ch);
        $request_header = curl_getinfo( $ch, CURLINFO_HEADER_OUT);
        //dump($response);dump($request_header);die;
        curl_close($ch);
        return $response;

    }
    //修改微信图文信息
    public function edit_thumb_material($notice,$schoolid,$articleid)
    {
        $article = $this->school_article_model->where(array("id"=>$articleid))->find();
        if($article["smeta"]==$notice['smeta'] && $article["post_title"]==$notice['post_title'] && $article["post_excerpt"]==$notice['post_excerpt'] && $article["post_content"]==$notice['post_content']){

//            print_r($locadata);
            $result=$this->school_article_model->save($notice);
            if ($result!==false) {
                $this->success("保存成功！",U("index"));
            } else {
                $this->error("保存失败！");
            }

        }

//        dump($article);

        $wxmanage = M("wxmanage_school as a")->join("wxt_wxmanage as b on a.manage_id = b.id")->where(array("a.schoolid"=>$schoolid))->field("b.wx_appid,b.wx_appsecret")->find();

        $token = $this->getAccessToken($wxmanage["wx_appid"],$wxmanage["wx_appsecret"]);

//        echo  $article["smeta"];
//        echo $notice['smeta'];
        //如果封面变了 就得修改封面图片  重新调用微信 上传封面
        if($article["smeta"]!==$notice['smeta'])
        {
//            echo "11111";
            $_picurl = $notice["smeta"];
            $root = $_SERVER["DOCUMENT_ROOT"]."/uploads/material/";
            //下载图片 到本地
            $imagurl = $this->download($_picurl,$root);
            if($imagurl)
            {
                $filedata = array("media"=>"@".$imagurl);

                //上传封面
                $url = "https://api.weixin.qq.com/cgi-bin/material/add_material?access_token=".$token."&type=image";
                $res = $this->https_request($url,$filedata);
                $newres = (array)json_decode($res);

                // dump($newres);
                if($newres["media_id"])
                {

                    $thumb_media_id = $newres["media_id"];
//                    $savedata["picurl"] = $newres["url"];
                    $savedata["thumb_media_id"] = $newres["media_id"];
                    $locadata["thumb_media_id"] = $newres["media_id"];
                    $locadata["picurl"] = $newres["url"];
                }else{
                    $this->error("修改封面图文失败！");
                }

            }else{
                $this->error("图片下载失败！");
                //return;
            }
        }else{
            $savedata["thumb_media_id"] = $article["thumb_media_id"];
        }

        //die();
        if($article["post_title"]!==$notice['post_title'])
        {
            $savedata["title"] = urlencode($notice['post_title']);
            $locadata["post_title"] =$notice['post_title'];
        }else{
            $savedata["title"] = urlencode($article["post_title"]);
        }

        if($article["post_excerpt"]!==$notice['post_excerpt'])
        {
            $savedata["digest"] = urlencode($notice['post_excerpt']);
            $locadata["post_excerpt"] =$notice['post_excerpt'];
        }else{
            $savedata["digest"] = urlencode($article["post_excerpt"]);
        }

        $savedata["show_cover_pic"] =1;
        $savedata['content_source_url']="";

        if($article["post_content"]!==$notice['post_content'])
        {
            preg_match_all('/<img([ ]+)src="([^\"]+)"/i',stripslashes($notice['post_content']),$matches);


            if($matches[2])
            {
                foreach($matches[2] as $key => $val)
                {
                    if ( strpos( $val, 'qpic.cn' ) === false ) {

                        $root = $_SERVER["DOCUMENT_ROOT"]."/uploads/material/";
                        //下载图片 到本地
                        $imagurl = $this->download($val,$root);
                        if($imagurl)
                        {
                            $filedata = array("media"=>"@".$imagurl);
                            $url='https://api.weixin.qq.com/cgi-bin/media/uploadimg?access_token='.$token;

                            if(is_file($imagurl) && in_array(strtolower($this->get_fileext($imagurl)),array('jpg','png')))
                            {
                                $output=(array)json_decode($this->http_media_request($url,$filedata));
                                // dump($output);

                                if(isset($output['url']))
                                {
                                    $notice['post_content']=str_replace($val,$output['url'],$notice['post_content']);

                                }
                            }
                        }

                    }


                }
                $locadata["post_content"] = $notice['post_content'];

                $notice['post_content'] = str_replace( '"', '\"',  $notice['post_content'] );
                $notice['post_content'] = str_replace( "'", '\'',  $notice['post_content']);
                $savedata["content"] = urlencode(htmlspecialchars_decode($notice['post_content']));

            }else{
                $locadata["post_content"]=$notice['post_content'];
            }
        }


        $url="https://api.weixin.qq.com/cgi-bin/material/update_news?access_token=".$token;
        $data = array(
            "media_id"=>$article["media_id"],
            "index"=>0,
            "articles"=>$savedata,
        );//这里一定要注意


        // $output=(array)json_decode(http_request($url,urldecode(json_encode($data))));
        $data = urldecode(json_encode($data,true));

        // die();
        $result = $this->http_request($url,$data);
        $news_result = json_decode($result, true);
        // dump($news_result);
        //die();
//            echo "111";
        // dump($news_result); //返回 "media_id":MEDIA_ID QVqFyY4hY4_xpPf_lO2OG1fIslTDY4wzkgg72IOeoDo
        if($news_result["errcode"]==0)
        {
            $locadata["post_status"] = $notice['post_status'];
            $locadata["column_id"] = $notice['column_id'];
            $locadata["istop"] = $notice['istop'];
            $locadata["create_time"] = $notice['create_time'];
            $locadata["smeta"] = $notice['smeta'];
            $locadata["post_date"] = $notice['post_date'];
            $locadata["userid"] = $notice['userid'];
            $locadata["id"]=$articleid;

            //print_r($locadata);
            $result=$this->school_article_model->save($locadata);
//            dump($result);

            $this->success("修改微信图文成功！");
            //return;
        }else{
            $this->error("修改微信图文失败！");
        }




    }
    //方法内调用...---------------------------------------------------------------
//------------------增加文章----------------

//------------------更新文章开始----------------
    public function edit(){
        $province = I("province");
      $citys = I('citys');

      $message_type = I('message_type');
      $schoolids = I("schoolids");

      if($province && $citys)
      {
          //写入缓存
          write_condition($province,$citys,$message_type,$schoolids,$this->only_code);

      }
      $cache_data = get_condition_cache($this->only_code);
      $this->assign("cache_data",$cache_data);

        $id=  intval(I("id"));
        $schoolid=I("schoolid");
        $notice = $this->school_article_model->where(array("id"=>$id))->find();
        $this->assign("notice",$notice);
//        $this->assign("smeta",json_decode($post['smeta'],true));
        $column = $this->school_column_model->where("schoolid = $schoolid and column_type=1")->select();
        $result = $this->getCate($column,0);
        foreach ($result as &$val)
        {
            $val["name"] = str_repeat('&nbsp', $val['count'] * 5).'|--'.$val['name'];
        }

        $this->assign("column",$result);
        //$this->assign("column",$column);
        // $this->assign("term",$term_relationship);
        $this->display();
    }
    
    public function edit_post(){
//        dump($_POST);
//        die();

            $notice['id']=intval(I("notice_id"));
            if(empty($_POST['column'])){
                $this->error("请至少选择一个分类栏目！");
            }
            $notice['smeta'] = $_POST['smeta']['thumb'];
            $notice['istop'] = $_POST['post']['istop'];
            $notice['post_date']=date("Y-m-d H:i:s",time());
//            $notice['schoolid']=$_SESSION['schoolid'];
//            $notice['userid'] = 0;
            if(empty($_POST['smeta']['thumb'])){

                $notice['smeta']="http://ow3hm6y11.bkt.clouddn.com/img12.png";
            }
            $notice['column_id'] = $_POST['column'];
            $column = M("school_column")->where(array("id"=>$notice['column_id']))->field("schoolid")->find();

            $notice['create_time']= time();
            $notice['post_title'] = $_POST['post']['post_title'];
            $notice['post_status'] = $_POST['post']['post_status'];
            $notice['post_excerpt'] = $_POST['post']['post_excerpt'];
            $notice['type'] = $_POST['type'];
            $notice['post_content']=htmlspecialchars_decode($_POST['post']['post_content']);
                if($_POST['type']==1)   //表示微网站文章
                {
                    $result=$this->school_article_model->save($notice);
                    if ($result!==false) {
                        $this->success("保存成功！",U("index"));
                    } else {
                        $this->error("保存失败！");
                    }
                }

                if($_POST['type']==2)   //表示微信图文信息
                {
                    $schoolid = $column ["schoolid"];
                    $this->edit_thumb_material($notice,$schoolid,$notice['id']);

                }

    }
   
//------------------更新文章结束----------------

//------------------删除文章------------------------
    function delete(){
         $id=intval($_GET['id']);
        //var_dump($id);
        if ($id) {
            $rst = $this->school_article_model->where("id=$id")->delete();
            if ($rst) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            }
        } else {
            $this->error('数据传入失败！');
        }
        //$this->error('该功能暂时未开通！');
    }

    //排序
    public function listorders() {
        $status = parent::_listorders($this->job_model);
        if ($status) {
            $this->success("排序更新成功！");
        } else {
            $this->error("排序更新失败！");
        }
    }
//-------------------------审核-------------------------
    function check(){
        if(isset($_POST['ids']) && $_GET["check"]){
            $data["post_status"]=1;
            
            $tids=join(",",$_POST['ids']);
            $objectids=$this->job_model->field("id")->where("id in ($tids)")->select();
            $ids=array();
            foreach ($objectids as $id){
                $ids[]=$id["id"];
            }
            $ids=join(",", $ids);
            if ( $this->job_model->where("id in ($ids)")->save($data)!==false) {
                $this->success("审核成功！");
            } else {
                $this->error("审核失败！");
            }
        }
        if(isset($_POST['ids']) && $_GET["uncheck"]){
            
            $data["post_status"]=0;
            $tids=join(",",$_POST['ids']);
            $objectids=$this->job_model->field("id")->where("id in ($tids)")->select();
            $ids=array();
            foreach ($objectids as $id){
                $ids[]=$id["id"];
            }
            $ids=join(",", $ids);
            if ( $this->job_model->where("id in ($ids)")->save($data)) {
                $this->success("取消审核成功！");
            } else {
                $this->error("取消审核失败！");
            }
        }
    }

    private function _getTree(){
		$schoolid=empty($_REQUEST['school'])?0:intval($_REQUEST['school']);
		$result = $this->school_model->field("schoolid ,school_name as name")->order(array("schoolid"=>"asc"))->select();
		$tree = new \Tree();
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		foreach ($result as $r) {
			$r['id']=$r['schoolid'];
			$r['selected']=$schoolid==$r['id']?"selected":"";
			$array[] = $r;
		}
		
		$tree->init($array);
		$str="<option value='\$id' \$selected>\$spacer\$name</option>";
		$taxonomys = $tree->get_tree(0, $str);
		$this->assign("taxonomys", $taxonomys);
	}
}