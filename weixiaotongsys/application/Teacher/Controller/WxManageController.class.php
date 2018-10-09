<?php
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
class WxManageController extends TeacherbaseController{
    protected $menu_model;

    function _initialize() {
        parent::_initialize();
        $this->menu_model = D("Common/wechat_menu"); //自定义菜单表
        $this->auto_model = D("Common/wechat_auto_reply");//自动回复表
        $this->material_model = D("Common/wechat_material");//素材表
        $this->Region=D("Common/city");//区域表
    }


    //菜单列表
    public  function menu_index(){
        //dump($_SESSION);
        $schoolid = $_SESSION["schoolid"];
        $wxmanage = M('wxmanage_school')->where("schoolid=$schoolid")->find();
        $manage_id = $wxmanage['manage_id']; //公众号ID  搜索条件

        $manage = M('wxmanage')->where("id =$manage_id ")->find();
        if($manage["is_public"]==1)
        {
            $this->error("统一公众号,前台不可配置菜单");
        }
        $_SESSION["manage_id"] = $manage_id;
        $_SESSION["appid"] = $manage["wx_appid"];  //获取ADDID
        $_SESSION["appsecret"] = $manage["wx_appsecret"]; //获取appsecret
        $_SESSION["wx_name"] = $manage["wx_name"];

        $name = I("menu_name");
        if($name)
        {
            $where['a.name'] = array("like","%".trim($name)."%");;
            $this->assign("name", $name);
        }
//        $where['a.manage_id'] = $manage_id;
//        $count = M('wechat_menu as a')->
//        join("wxt_wxmanage as b on a.manage_id = b.id")->
//        where($where)->
//        field("a.*,b.wx_name")->order("a.manage_id,a.menulevel,a.orderby")->count();
//        $page = $this->page($count,20);

        $menulist = M('wechat_menu as a')->
        join("wxt_wxmanage as b on a.manage_id = b.id")->
        where($where)->
        //limit($page->firstRow . ',' . $page->listRows)->
        field("a.*,b.wx_name")->order("a.manage_id,a.menulevel,a.orderby")->select();

        $this->assign('menulist',$menulist);
//        $this->assign("Page", $page->show('Admin'));
        $this->display("menu_index");
    }
    //添加自定义菜单
    public  function custommenu(){
        //拉取公众号
//        $wxmanage = M('wxmanage')->select();
//        $this->assign('wxmanage',$wxmanage);
        $this->assign('manage_id',$_SESSION["manage_id"]);
        $this->assign('wx_name',$_SESSION["wx_name"]);
        $this->display("menuadd");
    }

    //自定义菜单提交
    public function custommenu_post(){

            $manage_id=I("manage_id");//公众号ID
            $data["manage_id"]=$manage_id;

            $parentid=I("parentid"); //父ID
            if($parentid){
                $data["parentid"]=$parentid;
            }

            if($parentid==0){ //是否为一级菜单
                $data["menulevel"]=1;
                $menulist = M('wechat_menu')->where("manage_id =$manage_id and parentid=0")->select();
                if(count($menulist)>=3){
                    $this->error("一级菜单最多为三个");
                }
            }else{
                $menulist = M('wechat_menu')->where("manage_id =$manage_id and parentid=$parentid")->select();
                if(count($menulist)>=5){
                    $this->error("二级级菜单最多为五个");
                }
                $data["menulevel"]=2;
            }

            $name=I("name");    //菜单名称
            if($name){
                $data["name"]=$name;
            }else{
                $this->error("请选择菜单名称");
            }

            $orderby=I("orderby"); //排序
            if($orderby){
                $data["orderby"]=$orderby;
            }else{
                $this->error("请填写排序");
            }

            $typeid=I("typeid");  //菜单类型
            if($typeid){
                $data["typeid"]=$typeid;
            }else{
                $this->error("请选择菜单类型");
            }
            switch($typeid)
            {
                case 1:
                    $keyword =I("keyword");//关键字回复
                    $data["keyword"]=$keyword;
                    break;
                case 2:
                    $url =I("url");//链接 URL
                    $data["url"]=$url;
                    if(preg_match('/^^((https|http|ftp|rtsp|mms)?:\/\/)[^\s]+$/',$data["url"])==0){
                        $this->error("请输入完整的网址");
                    }
                    break;
                case 3:
                    $event=I("event");//菜单事件
                    $data["event"]=$event;
                    break;
                case 4:
                    $phone=I("phone");//电话
                    $data["telephone"]=$phone;
                    break;
                case 5:
                    $location=I("location");//地址位置
                    $data["location"]=$location;
                    break;
                case 6:
                    $url =I("redirect_url");//链接 URL
                    $data["url"]=$url;
                    if(preg_match('/^^((https|http|ftp|rtsp|mms)?:\/\/)[^\s]+$/',$data["url"])==0){
                        $this->error("请输入完整的网址");
                    }
                    break;
//                case 7:
//                    $event='mod';
//                    break;
                default:
                    $event='-';
                    break;
            }
            //建议网址的合法性
//        $a = preg_match('/^^((https|http|ftp|rtsp|mms)?:\/\/)[^\s]+$/',$data["url"]);
//            var_dump($a);
//            die();


            $result=$this->menu_model->add($data);
            if($result){
                $res = $this->createMenu($manage_id);
//                dump($res);
//                die();
                if(empty($res)){
                    $this->success("生成菜单成功,请重新关注公众号即可查看!");
                }else{
                    $arr = M('wechat_menu')->where("id=$result")->delete();//删除
                    $this->error("生成菜单失败");
                }

            }

    }

    //修改自定义菜单
    public  function custommenu_edit(){
        //拉取公众号
        $manage_id = I("manage_id");
        $id = I("id");//菜单ID
        $parentid = I("parentid");
        $wxmanage = M('wxmanage')->where("id =  $manage_id")->find();
        $manage_id = I("manage_id");
        $menu = M('wechat_menu')->where("manage_id = $manage_id")->order("parentid")->select();//菜单列表

        $menulist = M('wechat_menu')->where("id =  $id ")->find();
        $this->assign('menu',$menu);
        $this->assign('parentid',$parentid);
        $this->assign('wxmanage',$wxmanage);
        $this->assign('menulist',$menulist);
        $this->display("menuedit");
    }

    //自定义菜单修改提交
    public function custommenu_edit_post(){
        $id = I("id");
        $manage_id=I("manage_id");//公众号ID
        if($manage_id){
            $data["manage_id"]=$manage_id;
            $manage = M('wxmanage')->where("id =$manage_id ")->find();
            $_SESSION["appid"] = $manage["wx_appid"];  //获取ADDID
            $_SESSION["appsecret"] = $manage["wx_appsecret"]; //获取appsecret
        }else{
            $this->error("请选择公众号");
        }

        $parentid=I("parentid"); //父ID
        if($parentid){
            $data["parentid"]=$parentid;
        }

        if($parentid==0){ //是否为一级菜单
            $data["menulevel"]=1;
            $menulist = M('wechat_menu')->where("manage_id =$manage_id and parentid=0")->select();
            if(count($menulist)>=4){
                $this->error("一级菜单最多为三个");
            }
        }else{
            $menulist = M('wechat_menu')->where("manage_id =$manage_id and parentid=$parentid")->select();
            if(count($menulist)>=6){
                $this->error("二级级菜单最多为五个");
            }
            $data["menulevel"]=2;
        }

        $name=I("name");    //菜单名称
        if($name){
            $data["name"]=$name;
        }else{
            $this->error("请选择菜单名称");
        }

        $orderby=I("orderby"); //排序
        if($orderby){
            $data["orderby"]=$orderby;
        }else{
            $this->error("请填写排序");
        }

        $typeid=I("typeid");  //菜单类型
        if($typeid){
            $data["typeid"]=$typeid;
        }else{
            $this->error("请选择菜单类型");
        }
        switch($typeid)
        {
            case 1:
                $keyword =I("keyword");//关键字回复
                $data["keyword"]=$keyword;
                break;
            case 2:
                $url =I("url");//链接 URL
                $data["url"]=$url;
                if(preg_match('/^^((https|http|ftp|rtsp|mms)?:\/\/)[^\s]+$/',$data["url"])==0){
                    $this->error("请输入完整的网址");
                }
                break;
            case 3:
                $event=I("event");//菜单事件
                $data["event"]=$event;
                break;
            case 4:
                $phone=I("phone");//电话
                $data["telephone"]=$phone;
                break;
            case 5:
                $location=I("location");//地址位置
                $data["location"]=$location;
                break;
            case 6:
                $url =I("redirect_url");//链接 URL
                $data["url"]=$url;
                if(preg_match('/^^((https|http|ftp|rtsp|mms)?:\/\/)[^\s]+$/',$data["url"])==0){
                    $this->error("请输入完整的网址");
                }
                break;
//                case 7:
//                    $event='mod';
//                    break;
            default:
                $event='-';
                break;
        }

        $result=$this->menu_model->where("id=$id")->save($data);
        if($result){
            $res = $this->createMenu($manage_id);
            //dump($res)
            if(empty($res)){
                $this->success("生成菜单成功,请重新关注公众号即可查看!",U("menu_index"));
            }else{
                $this->error("生成菜单失败");
            }
        }

    }



    public  function menu_delete(){
        $id = I("get.id",0,"intval");
        $manage_id = I("manage_id");

        $res = M('wechat_menu')->where("id=$id")->delete();//删除本条数据
        $arr = M('wechat_menu')->where("parentid=$id")->delete();//删除子类
//        if ( $res!==false) {
//            $res = $this->createMenu($manage_id);//生成菜单
//            echo $res;
//            $this->success("删除成功！");
//        } else {
//            $this->error("删除失败！");
//        }
            $res = $this->createMenu($manage_id);
            if(empty($res)){
                $this->success("删除菜单成功,请重新关注公众号即可查看!");
            }else{
                $this->error("删除菜单失败");
            }

    }

    //菜单列表
    public  function menu_list(){
        $manage_id = I("manage_id");
        $menulist = M('wechat_menu')->where("manage_id = $manage_id")->order("parentid")->select();
        echo json_encode($menulist);
    }

    //创建自定义菜单
    public function createMenu($manage_id)
    {
        $menu=array();
        $r = M('wechat_menu')->where("parentid = 0 and manage_id=$manage_id")->order("orderby asc")->limit(0,5)->select();
        foreach($r as $key => $_r)
        {

            $parentid  = $_r['id'];
            $children=M('wechat_menu')->where("parentid =  $parentid and manage_id=$manage_id")->order("orderby asc")->limit(0,5)->select();
            if(!$children)
            {
                if($_r['typeid']==1)
                {
                    $menu['button'][$key]=array('name'=>urlencode($_r['name']),'type'=>'click','key'=>urlencode($_r['keyword']));
                }

                if($_r['typeid']==2 || $_r['typeid']==6)
                {
                    $menu['button'][$key]=array('name'=>urlencode($_r['name']),'type'=>'view','url'=>htmlspecialchars_decode($_r['url']));
                }

                if($_r['typeid']==3)
                {
                    $menu['button'][$key]=array('name'=>urlencode($_r['name']),'type'=>urlencode($_r['event']),'key'=>'rselfmenu_'.$key.'_0');
                }
//
//                if($_r['typeid']==4)
//                {
//                    $menu['button'][$key]=array('name'=>urlencode($_r['name']),'type'=>'view','url'=>format_url(U(MOD,'tel',array('tel'=>$_c['telephone']))));
//                }
//
//                if($_r['typeid']==5)
//                {
//                    $menu['button'][$key]=array('name'=>urlencode($_r['name']),'type'=>'view','url'=>format_url(U(MOD,'map',array('coord'=>$_r['location']))));
//                }
//
//                if($_r['typeid']==7)
//                {
//                    $menu['button'][$key]=array('name'=>urlencode($_r['name']),'type'=>'view','url'=>format_url(U($_r['mod'])));
//                }
            }
            else
            {
                $c=array();
                foreach($children as $k => $_c)
                {
                    if($_c['typeid']==1)
                    {
                        $c[$k]=array('name'=>urlencode($_c['name']),'type'=>'click','key'=>urlencode($_c['keyword']));
                    }

                    if($_c['typeid']==2 || $_c['typeid']==6)
                    {
                        $c[$k]=array('name'=>urlencode($_c['name']),'type'=>'view','url'=>htmlspecialchars_decode($_c['url']));
                    }

                    if($_c['typeid']==3)
                    {
                        $c[$k]=array('name'=>urlencode($_c['name']),'type'=>urlencode($_c['event']),'key'=>'rselfmenu_'.$key.'_'.$k);
                    }

//                    if($_c['typeid']==4)
//                    {
//                        $c[$k]=array('name'=>urlencode($_c['name']),'type'=>'view','url'=>format_url(U(MOD,'tel',array('tel'=>$_c['telephone']))));
//                    }
//
//                    if($_c['typeid']==5)
//                    {
//                        $c[$k]=array('name'=>urlencode($_c['name']),'type'=>'view','url'=>format_url(U(MOD,'map',array('coord'=>$_r['location']))));
//                    }
//
//                    if($_c['typeid']==7)
//                    {
//                        $c[$k]=array('name'=>urlencode($_c['name']),'type'=>'view','url'=>format_url(U($_c['mod'])));
//                    }
                }
                $menu['button'][$key]=array('name'=>urlencode($_r['name']),'sub_button'=>$c);
            }

        }

      //  dump($menu);
        //dump(urldecode(stripslashes(json_encode($menu))));
        //die();
        $token = $this->getAccess_token();
        $url='https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$token;
        $output=(array)json_decode($this->http_request($url,urldecode(stripslashes(json_encode($menu)))));
        //print_r( $menu);
        return $output['errcode'];
       //$a =  urldecode(stripslashes(json_encode($menu)));
       // $resource = fopen("./log.txt","w+");
         //           fwrite($resource, $a."\r\n");
        //return $output;
    }

    //获取 access_token
    function getAccess_token()
    {
        $appid = $_SESSION["appid"];
        $appsecret = $_SESSION["appsecret"];

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
           // dump($jsoninfo);
            //die();
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


    public function manage_school(){
        $manage_id=I("manage_id");//公众号ID
        if($manage_id){
           $result =  M("wxmanage_school  as a")->
           join("wxt_school as b on a.schoolid=b.schoolid")->
          where("a.manage_id= $manage_id")->field("b.school_name,b.schoolid")->select();
           echo json_encode($result);
        }
    }








}

