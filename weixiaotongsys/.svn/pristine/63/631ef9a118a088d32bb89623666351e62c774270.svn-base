<?php
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class WxManageController extends AdminbaseController{
    protected $menu_model;

    function _initialize() {
        parent::_initialize();
        $this->menu_model = D("Common/wechat_menu"); //自定义菜单表
        $this->auto_model = D("Common/wechat_auto_reply");//自动回复表
        $this->material_model = D("Common/wechat_material");//素材表
        $this->Region=D("Common/city");//区域表
    }

    //公众号列表
    public function index(){

        $wxmanage = M('wxmanage')->field("id,wx_name")->select();//拉取公众号
        $this->assign('wxmanage',$wxmanage);

        $manage_id = I('manage_id'); //公众号ID  搜索条件
        if (!empty($manage_id)){
            $where['w.id'] = $manage_id;
            $this->assign("manage_id", $manage_id);
        }
        $wx = M('wxmanage')
            ->alias('w')->
            //->join('wxt_school as s on s.schoolid = w.schoolid')
           // ->field('w.*, s.school_name')
             where($where)
            ->order('w.id desc')
            ->select();
        $count = count($wx);
        $page = $this->page($count, 15);
        $wx = M('wxmanage')
            ->alias('w')->  where($where)
            //->join('wxt_school as s on s.schoolid = w.schoolid')
           // ->field('w.*, s.school_name')
            ->limit($page->firstRow . ',' . $page->listRows)
            ->order('w.id desc')
            ->select();
	    //dump($wx);
        $this->assign('page', $page->show('Admin'));
	    $this->assign('wx', $wx);
		$this->display();
	}

	//公众号添加
	public function add(){
        $tegion=$this->Region->where("parent=0")->field("term_id,name")->select();//拉取市级
        $this->assign("tegion",$tegion);

        //获取所有的学校
//        $schools = M('school')->field('schoolid, school_name')->select();
//        $this->assign('schools', $schools);
		$this->display();
	}
    //地级划分
    public function Provinces(){
        $Province=I("Province");
        $Shisheng=$this->Region->where("parent=$Province")->select();
        // var_dump($Shisheng);
        if (!empty($Shisheng)){
            $ret = $this->format_ret(1,$Shisheng);
            echo json_encode($ret);
        }else{
            $ret = format_ret(0,"parms lost");
            echo json_encode($ret);
        }
    }
    //模板列表
    function tindex(){
        $school = M('school')->field("schoolid,school_name")->select();//拉取公众号
        $this->assign('school',$school);

        $schoolid = I('schoolid'); //公众号ID  搜索条件
        if (!empty($schoolid)){
            $where['w.schoolid'] = $schoolid;
            $this->assign("schoolid", $schoolid);
        }

        $wx = M('template')
            ->alias('w')
            ->join('wxt_school as s on s.schoolid = w.schoolid')
            ->  where($where)
            ->field('w.*, s.school_name')
            ->order('w.id desc')
            ->select();
        $count = count($wx);
        $page = $this->page($count, 15);
        $wx = M('template')
            ->alias('w')
            ->join('wxt_school as s on s.schoolid = w.schoolid')
            ->  where($where)
            ->field('w.*, s.school_name')
            ->limit($page->firstRow . ',' . $page->listRows)
            ->order('w.id desc')
            ->select();
        //dump($wx);
        $this->assign('page', $page->show('Admin'));
        $this->assign('wx', $wx);
        $this->display("tindex");
    }

    function template_add(){
        //获取所有的学校
        $wxmanage = M('wxmanage')->field("id,wx_name,wx_appid")->select();//拉取公众号
        $this->assign('wxmanage', $wxmanage);
        $schools = M('school')->field('schoolid, school_name')->select();
        $this->assign('schools', $schools);
        $this->display();
    }
    function template_post(){

        $name = I('name');
        $appid =I('appid');
        $app_name =I('app_name');
        $schoolid= I('schoolid');
        $template_id= trim(I('template_id'));
        $type = I("type");
        if(empty($appid)){
            $this->error("请选择公众号");
        }

        if(empty($schoolid)){
            $this->error("请选择学校");
        }

        if(empty($template_id)){
            $this->error("请填写模板ID");
        }

        $arr = array(
                        'name'=>$name,
                        'appid'=>$appid,
                        'app_name'=>$app_name,
                        'schoolid'=>$schoolid,
                        'template_id'=>$template_id,
                        'type'=>$type,
                        'create_time'=>time()
                    );
        $a = M('template')->add($arr);
                    //var_dump($a);exit;
                    $this->success("添加成功！", U("tindex"));



    }
    //公众号添加提交
	function add_post(){
		if(IS_POST){
			if (M('wxmanage')->create()){
				if ($id = M('wxmanage')->add()) {
				    $name = I('name');
				    $urls = parse_url(I('url'));
				    $url = $urls['scheme'].'://'.$urls['host'].'?id='.$id;
				    $token = I('token');
				    $EncodingAESKey = $_POST['EncodingAESKey'];
				    $arr = array(
				        'name'=>$name,
                        'url'=>$url,
                        'token'=>$token,
                        'EncodingAESKey'=>$EncodingAESKey,
                        'wxmanage_id'=>$id
                    );
				    $a = M('wxserver')->add($arr);
				    //var_dump($a);exit;
					$this->success("添加成功！", U("index"));
				} else {
					$this->error("添加失败！");
				}
			} else {
				$this->error(M('wxmanage')->getError());
			}
		
		}
	}

	//公众号修改
	function edit(){
		$id=I("get.id");
        $wx = M('wxmanage')
            ->alias('w')
            ->where("w.id = $id")
            ->join('wxt_wxserver as ws on w.id = ws.wxmanage_id')
            ->field('w.*,ws.id as server_id,ws.name,ws.url,ws.token,encodingaeskey')
            ->find();
//        dump($wx);
//        exit;
        //获取所有的学校
        //$schools = M('school')->field('schoolid, school_name')->select();
       // $this->assign('schools', $schools);
		$this->assign('wx',$wx);
		$this->display();
	}

	//公众号修改提交
	function edit_post(){
		if (IS_POST) {
            $name = I('name');
//            $urls = parse_url(I('url'));
//            $url = $urls['scheme'].'://'.$urls['host'].'?id='.I('id');
            $url = I('url');
            $token = I('token');
            $EncodingAESKey = $_POST['EncodingAESKey'];
            $server = array(
                'id'=>I('server_id'),
                'name'=>$name,
                'url'=>$url,
                'token'=>$token,
                'EncodingAESKey'=>$EncodingAESKey,
                'wxmanage_id'=>I('id')
            );
            M('wxserver')->save($server);

			if (M('wxmanage')->create()) {
				if (M('wxmanage')->save()!==false) {
					$this->success("保存成功！", U("index"));
				} else {
					$this->error("保存失败！");
				}
			} else {
				$this->error(M('wxmanage')->getError());
			}
		}
	}
	
	/**
	 *  删除
	 */
	function delete(){
		$id = I("get.id",0,"intval");
        M('wxserver')->where("wxmanage_id=$id")->delete();
		if (M('wxmanage')->delete($id)!==false) {
			$this->success("删除成功！");
		} else {
			$this->error("删除失败！");
		}
	}
    /**
     *  删除
     */
    function tdelete(){
        $id = I("get.id",0,"intval");
        M('template')->where("id=$id")->delete();
        if (M('template')->delete($id)!==false) {
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }
	public function check() {

        $id = I("get.id",0,"intval");
        $update = M('wxmanage')->where("id=$id")->save(array('status'=>1));
        if ($update){
            $this->success("修改成功！");
        }else{
            $this->error("删除失败！");
        }
//        $wx = M('wxmanage')
//            ->alias('w')
//            ->where("w.id = $id")
//            ->join('wxt_school as s on s.schoolid = w.schoolid')
//            ->field('w.*, s.school_name')
//            ->find();
//        $server = M('wxserver')->field('id, name')->select();
//        //dump($server);
//        $this->assign('server', $server);
//        $this->assign('wx',$wx);
//	    $this->display();
    }

    public function checks()
    {

        $id = I("get.id", 0, "intval");
        $update = M('wxmanage')->where("id=$id")->save(array('status' => 0));
        if ($update) {
            $this->success("修改成功！");
        } else {
            $this->error("删除失败！");
        }
    }

    public function getInfo(){
	    $id = I('id');
	    if ($id){
            $wx = M('wxserver')->where("id = $id")->find();
            echo json_encode($wx);
        }
    }

    public function checkUrl()
    {
//        $id = I('id');
//        $wx = M('wxserver')->where("id = $id")->find();
//        $obj = new WechatCallBackApi();
        // 第三方发送消息给公众平台
    }

    //获取第三方平台component_access_token
    public function componentAccessToken() {

    }

    //学校公众号添加
    public function  manage_school_add(){
        $schools = M('school')->field('schoolid, school_name')->select();
        $this->assign('schools', $schools);
        $this->display();
    }

    //拉取公众号
    public function manage_list(){
        $is_public = I("is_public"); //是否为自己的公众号
        $wxmanage = M('wxmanage')->where("is_public = $is_public")->select();
        echo json_encode($wxmanage);
    }

    //公众号学校关联提交
    function manage_post(){
        $schoolid= I('schoolid');
        $manage_id= I('manage_id');

        $arr = array(
            'schoolid'=>$schoolid,
            'manage_id'=>$manage_id,
            'create_time'=>time()
        );
        $wxmanages = M("wxmanage_school")->where(array("manage_id"=>$manage_id,"schoolid"=>$schoolid))->find();
        if($wxmanages)
        {
            $this->error("该记录已存在,无需添加!");
        }
        $res= M('wxmanage_school')->add($arr);
        if($res){
            $this->school_sceneqrcode_post($manage_id,$schoolid);
            $this->success("添加成功");
        }else{
            $this->error("添加失败");
        }


    }



    //学校公众号挂钩时候提交二维码
    public function school_sceneqrcode_post($manage_id,$schoolid)
    {
        if($manage_id){
            $data["manage_id"]=$manage_id;
            $manage = M('wxmanage')->where("id =$manage_id ")->find();
            $_SESSION["appid"] = $manage["wx_appid"];  //获取ADDID
            $_SESSION["appsecret"] = $manage["wx_appsecret"]; //获取appsecret
        }else{
            $this->error("请选择公众号");
        }

        if($schoolid){
            $data["schoolid"]=$schoolid;
        }else{
            $this->error("请选择学校");
        }


            $school = M("school")->where(array("schoolid"=>$schoolid))->find();
            $data["scene_name"]=$school["school_name"];



        $data["typeid"]=1;
        $data["createtime"]=time();

        $result=M("wechat_qrcode")->add($data);
        if($result){
            $arr = $this->sceneqrcodeCreate($result);
            if($arr["ticket"]){
                $data["ticket"] = $arr["ticket"];
                $res=M("wechat_qrcode")->where("scene_id= $result")->save($data);
                //$this->success("生成成功");
            }else{
                M("wechat_qrcode")->where("scene_id= $result")->delete(); // 删除数据
                    $this->success("二维码生成成功");
            }
        }else{
            $this->success("二维码生成成功");
        }
    }



    public function manage_school_list(){
        $school = M('school')->field("schoolid,school_name")->select();//拉取公众号
        $this->assign('school',$school);

        $schoolid = I('schoolid'); //公众号ID  搜索条件
        if (!empty($schoolid)){
            $where['w.schoolid'] = $schoolid;
            $this->assign("schoolid", $schoolid);
        }

        $wx = M('wxmanage_school')
            ->alias('w')
            ->join('wxt_school as s on s.schoolid = w.schoolid')
            ->join('wxt_wxmanage as a on w.manage_id = a.id')
            ->  where($where)
            ->field('w.id as sid,w.create_time as time,s.school_name,a.wx_name')
            ->order('w.id desc')
            ->select();
        $count = count($wx);
        $page = $this->page($count, 15);
        $wx = M('wxmanage_school')
            ->alias('w')
            ->join('wxt_school as s on s.schoolid = w.schoolid')
            ->join('wxt_wxmanage as a on w.manage_id = a.id')
            ->  where($where)
            ->field('w.id as sid,w.create_time as time, s.school_name,a.wx_name')
            ->order('w.id desc')
            ->select();
        //dump($wx);
        $this->assign('page', $page->show('Admin'));
        $this->assign('wx', $wx);
        $this->display();
    }

 // 删除学校关系
    function manage_delete(){
        $id = I("get.id",0,"intval");
        M('wxmanage_school')->where("id=$id")->delete();
        if (M('wxmanage_school')->delete($id)!==false) {
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }

    //素材管理列表
    public function material_list(){
        $wxmanage = M('wxmanage')->field("id,wx_name")->select();//拉取公众号
        $this->assign('wxmanage',$wxmanage);

        $manage_id = I('manage_id'); //公众号ID  搜索条件
        if (!empty($manage_id)){
            $where['w.id'] = $manage_id;
            $this->assign("manage_id", $manage_id);
        }
        $wx = M('wxmanage')
            ->alias('w')
            ->where($where)
            ->order('w.id desc')
            ->select();
        $count = count($wx);
        $page = $this->page($count, 15);
        $wx = M('wxmanage')
            ->alias('w')
            ->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)
            ->order('w.id desc')
            ->select();
        //dump($wx);
        $this->assign('page', $page->show('Admin'));
        $this->assign('wx', $wx);
        $this->display();
    }
    //素材管理列表
    public function material_show(){
        $manage_id = I("id"); //公众号ID
        $material = $this->material_model->where("manage_id = $manage_id and group_id=0")->order('orderby asc')->select();//拉取输出列表
//         print_r($material);
         foreach ($material as $key=>&$value){
             $id = $value["id"];
             $result = M("wechat_material")->where("group_id = $id")->select();
             if($result){
                 $value["list"] = $result;
             }
         }
        //dump($material);
        $this->assign('material',$material);
        $this->assign('manage_id',$manage_id);
        $this->display("config-material.tlp");
    }
    //
    //添加素材页面
    public function material_post(){
        $manage_id = I("manage_id");
        $wxmanage = M('wxmanage')->where("id = $manage_id")->select();//拉取公众号
        $this->assign('wxmanage',$wxmanage);

        $this->assign('manage_id',$manage_id);
        $this->display("config-material_post.tlp");
    }

    //素材文章
    public function material_article(){
        $this->display();
    }

    //修改素材页面
    public function material_edit(){
        $id = I("id");
        $material = M('wechat_material')->where("id = $id")->find();//拉取列表
        if(count($material)){
            $childdata = M('wechat_material')->where("group_id = $id")->select();//拉取字图文
            $num = count($childdata)+1;
            $this->assign('num',$num);
            $this->assign('childdata',$childdata);
            $this->assign('manage_id',$material["manage_id"]);
            $this->assign('material',$material);
        }

       // dump($material);
        $this->display("config-material_edit.tlp");
    }

    // 删除图文素材
    function material_delete(){
        $id = I("id");
        $this->material_model->where("id=$id")->delete();
        $this->material_model->where("group_id=$id")->delete();
        if ($this->material_model->delete($id)!==false) {
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }


    //添加图文提交
    public function postMediaMaterial(){
        //dump($_POST);
//        die();
        $manage_id = I("manage_id");//公众号ID
        $Title = I("Title");//标题
        $Author = I("Author");//作者
        $Description = I("Description");//摘要
        $PicUrl = I("PicUrl");//图片地址
        $thumb_media_id = I("thumb_media_id");
        $content = I("content");//内容
        $Url= I("urls");//链接
        $UpdateTime= time();

        $orderby=1;
        $group_id=0;
        foreach($Title as $id => $_title){
                $data["PicUrl"]=$PicUrl[$id];
                $data["Title"]=$Title[$id];
                $data["Author"]=$Author[$id];
                $data["Description"]=$Description[$id];
                $data["thumb_media_id"]=$thumb_media_id[$id];
                $data["content"]=htmlspecialchars_decode($content[$id]);
                $data["Url"]=$Url[$id];
                $data["manage_id"]=$manage_id;
                $data["UpdateTime"]=$UpdateTime;
                $data['orderby']=$orderby;
                if($id==0){
                    $group_id=$this->material_model->add($data);
                }else{
                    $data["group_id"] = $group_id;
                    $this->material_model->add($data);
                }
            $orderby++;
        }
        if($group_id){
            $result = $this->material_model->where("id = $group_id")->select();
            $arr = $this->material_model->where("group_id = $group_id")->select();
            foreach($result as $k => $value){
                if(empty($value["url"])){
                    $id = $value["id"];
                    $url = "http://up.zhixiaoyuan.net/index.php?g=weixin&m=Article&a=index&id=".$id;
                    M("wechat_material")->where("id = $id")->save(array("content_source_url"=>$url,"Url"=>$url));
                }
            }
            foreach($arr as $k => $value){
                if(empty($value["url"])){
                    $id = $value["id"];
                    $url = "http://up.zhixiaoyuan.net/index.php?g=weixin&m=Article&a=index&id=".$id;
                    M("wechat_material")->where("id = $id")->save(array("content_source_url"=>$url,"Url"=>$url));
                }
            }
            $this->success("添加成功!");
        }else{
            $this->error("添加失败");
        }
    }

    //添加图文修改提交
    public function editMediaMaterial(){
//        dump($_POST);
//        die();
        $maid = I("id");//主图文ID
        $materialid= I("materialid");//图文ID
        $manage_id = I("manage");//公众号ID
        $Title = I("Title");//标题

        $Author = I("Author");//作者
        $Description = I("Description");//摘要
        $PicUrl = I("PicUrl");//图片地址
        $thumb_media_id = I("thumb_media_id");
        $content = I("content");//内容
        $Url= I("urls");//链接
        $UpdateTime= time();//修改时间

        foreach($Title as $id => $value)
        {
            $mid = $materialid[$id];
            $data["PicUrl"]=$PicUrl[$id];
            $data["Title"]=$Title[$id];
            $data["Author"]=$Author[$id];
            $data["Description"]=$Description[$id];
            $data["thumb_media_id"]=$thumb_media_id[$id];
            $data["content"]=htmlspecialchars_decode($content[$id]);
            $data["Url"]=$Url[$id];
            $data["UpdateTime"]=$UpdateTime;
            $result=$this->material_model->where("id=$mid")->save($data);
            if($mid==0){
                $data["group_id"]=$maid;
                $data["orderby"]=$id+1;
                $data["manage_id"]=$manage_id;
                $result=$this->material_model->add($data);
            }
        }

        if($result){
            $this->success("修改成功!");
        }else{
            $this->error("修改失败");
        }

    }
//    //添加图文修改提交
//    public function editMediaMaterial(){
//
//        dump($_POST);
//        die();
//        //$manage_id = I("manage_id");
//        $Title = I("Title");
//        $Author = I("Author");
//        $Description = I("Description");
//        $PicUrl = I("PicUrl");
//        $thumb_media_id = I("thumb_media_id");
//        $content = I("content");
//        $Url= I("urls");
//        $UpdateTime= time();
//
//        $id = I("id");
//        $data["PicUrl"]=$PicUrl[0];
//        $data["Title"]=I("p_title");
//        $data["Author"]=I("p_author");
//        $data["Description"]=I("p_description");
//        $data["content"]=$content[0];
//        $data["Url"]=I("p_url");
//        $data["UpdateTime"]=$UpdateTime;
//        $result=$this->material_model->where("id=$id")->save($data);
//        if($result){
//            $this->success("修改成功!");
//        }else{
//            $this->error("修改失败");
//        }
////        }
//    }

    //素材管理列表
    public function autoreply_list(){

        $wxmanage = M('wxmanage')->field("id,wx_name")->select();//拉取公众号
        $this->assign('wxmanage',$wxmanage);

        $manage_id = I('manage_id'); //公众号ID  搜索条件
        if (!empty($manage_id)){
            $where['w.id'] = $manage_id;
            $this->assign("manage_id", $manage_id);
        }
        $wx = M('wxmanage')
            ->alias('w')
            ->where($where)
            ->order('w.id desc')
            ->select();
        $count = count($wx);
        $page = $this->page($count, 15);
        $wx = M('wxmanage')
            ->alias('w')
            ->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)
            ->order('w.id desc')
            ->select();
        //dump($wx);
        $this->assign('page', $page->show('Admin'));
        $this->assign('wx', $wx);
        $this->display();
    }
    //关注自动回复
    public  function subscribereply(){
        $manage_id =  I("id"); //公众号ID

//        $material = M('wechat_material')->where("manage_id = $manage_id")->select();//拉取素材列表
        $material = $this->material_model->where("manage_id = $manage_id and group_id=0")->order('orderby asc')->select();//拉取输出列表
//         print_r($material);
        foreach ($material as $key=>&$value){
            $id = $value["id"];
            $result = M("wechat_material")->where("group_id = $id")->select();
            if($result){
                $value["list"] = $result;
            }
        }
         //print_r($material);
        //查找出已选择的素材
       $auto_material = M('wechat_material as a')->join("wxt_wechat_auto_reply as b on a.id=b.mid")->where("b.manage_id = $manage_id and b.material_type='media' and type='subscribe'")->select();
       if(count($auto_material)){
           foreach ($auto_material as $key=>&$value){
               $id = $value["mid"];
               $result = M("wechat_material")->where("group_id = $id")->select();
               if($result){
                   $value["list"] = $result;
               }
           }
       }
//       dump($auto_material);
       $text_material = M('wechat_auto_reply')->where("manage_id = $manage_id and material_type='text' and type='subscribe'")->find();
        $this->assign('material',$material);
        $this->assign('auto_material',$auto_material);
        $this->assign('text_material',$text_material);
        $this->assign('manage_id',$manage_id);
        $this->display("core-subscribereply.tlp");
    }

    //消息自动回复
    public  function autoreply(){
        $manage_id =  I("id"); //公众号ID

        //$material = M('wechat_material')->where("manage_id = $manage_id")->select();//拉取素材列表

        $material = $this->material_model->where("manage_id = $manage_id and group_id=0")->order('orderby asc')->select();//拉取输出列表
//         print_r($material);
        foreach ($material as $key=>&$value){
            $id = $value["id"];
            $result = M("wechat_material")->where("group_id = $id")->select();
            if($result){
                $value["list"] = $result;
            }
        }
        //查找出已选择的素材
        $auto_material = M('wechat_material as a')->join("wxt_wechat_auto_reply as b on a.id=b.mid")->where("b.manage_id = $manage_id and b.material_type='media' and type='default' and keyword_type='0' ")->select();
        if(count($auto_material)){
            foreach ($auto_material as $key=>&$value){
                $id = $value["mid"];
                $result = M("wechat_material")->where("group_id = $id")->select();
                if($result){
                    $value["list"] = $result;
                }
            }
        }
        $text_material = M('wechat_auto_reply')->where("manage_id = $manage_id and material_type='text' and type='default' and keyword_type='0' ")->find();
        $this->assign('material',$material);
        $this->assign('auto_material',$auto_material);
        $this->assign('text_material',$text_material);
        $this->assign('manage_id',$manage_id);
        $this->display("core-autoreply.tlp");
    }

    //关键字自动回复
    public  function helpreply(){
        $manage_id =  I("id"); //公众号ID
//        $material = M('wechat_material')->where("manage_id = $manage_id")->select();//拉取素材列表
        $material = $this->material_model->where("manage_id = $manage_id and group_id=0")->order('orderby asc')->select();//拉取输出列表
//         print_r($material);
        foreach ($material as $key=>&$value){
            $id = $value["id"];
            $result = M("wechat_material")->where("group_id = $id")->select();
            if($result){
                $value["list"] = $result;
            }
        }
        //查找出已选择的素材
        $auto_material = M('wechat_material as a')->join("wxt_wechat_auto_reply as b on a.id=b.mid")->where("b.manage_id = $manage_id and b.material_type='media' and type='default' and keyword_type>0 ")->select();
        if(count($auto_material)){
            foreach ($auto_material as $key=>&$value){
                $id = $value["mid"];
                $result = M("wechat_material")->where("group_id = $id")->select();
                if($result){
                    $value["list"] = $result;
                }
            }
        }
        $text_material = M('wechat_auto_reply')->where("manage_id = $manage_id and material_type='text' and type='default' and keyword_type>0 ")->find();
        $this->assign('material',$material);
        $this->assign('auto_material',$auto_material);
        $this->assign('text_material',$text_material);
        $this->assign('manage_id',$manage_id);
        $this->display("core-helpreply.tlp");
    }

    //关注自动回复添加
    public function follow_autoreply_post(){
        $manage_id=I("manage_id");//公众号ID
        $material_type = I("material_type");
        if($material_type=="media"){ //表示图文
            $mid = I("mid"); //素材ID
            if(empty($mid)){
                $this->error("请选择图文");
            }else{
                $type=I("type");//事件类型
                $data["type"]=$type;
                $data["mid"] = $mid;
                $data["material_type"] = $material_type;
                $data["manage_id"] = $manage_id;
                //print_r($data);
                //die();
                $this->auto_model->where("manage_id=$manage_id and type='subscribe' and material_type='media'")->delete();
                $this->auto_model->where("manage_id=$manage_id and type='subscribe' and material_type='text'")->delete();
                $result= $this->auto_model->add($data);
                if($result){
                   //
                    $this->success("添加成功！");
                }else{
                    $this->error("添加失败！");
                }
            }
            return;
        }
        if($material_type=="text"){
            //文字自动回复
            $manage_id=I("manage_id");//公众号ID
//            if($manage_id){
            $data["manage_id"]=$manage_id;
            //echo  $manage_id;
            //die();
//            }else{
//                $this->error("请选择公众号");
//            }
            $type=I("type");//事件类型
            if($type){
                $data["type"]=$type;
            }else{
                $this->error("请选择事件类型");
            }
            $content=I("content");//时间类型
            if($content){
                $data["content"]=trim($content);
            }
//            else {
//                $this->error("请填写内容");
//            }
            $data["material_type"] = $material_type;
            M('wechat_auto_reply')->where("manage_id=$manage_id and type='subscribe' and material_type='text'")->delete();
            M('wechat_auto_reply')->where("manage_id=$manage_id and type='subscribe' and material_type='media'")->delete();
            $result=$this->auto_model->add($data);
            if($result){
                $this->success("添加成功");
            }else{
                $this->error("添加失败！");
            }
        }


    }

    //消息自动回复添加
    public function autoreply_post(){
        $manage_id=I("manage_id");//公众号ID
        $material_type = I("material_type");
        if($material_type=="media"){ //表示图文
            $mid = I("mid"); //素材ID
            if(empty($mid)){
                $this->error("请选择图文");
            }else{
                $type=I("type");//事件类型
                $data["type"]=$type;
                $data["mid"] = $mid;
                $data["material_type"] = $material_type;
                $data["manage_id"] = $manage_id;
                //print_r($data);
                //die();
                $this->auto_model->where("manage_id=$manage_id and type='default' and material_type='media' and keyword_type='0' ")->delete();
                $this->auto_model->where("manage_id=$manage_id and type='default' and material_type='text' and keyword_type='0' ")->delete();
                $result= $this->auto_model->add($data);
                if($result){
                    //
                    $this->success("添加成功！");
                }else{
                    $this->error("添加失败！");
                }
            }
            return;
        }
        if($material_type=="text"){
            //文字自动回复
            $manage_id=I("manage_id");//公众号ID
            $data["manage_id"]=$manage_id;
            $type=I("type");//事件类型
            if($type){
                $data["type"]=$type;
            }else{
                $this->error("请选择事件类型");
            }
            $content=I("content");//时间类型
            if($content){
                $data["content"]=trim($content);
            }
//            else{
//                $this->error("请填写内容");
//            }
            $data["material_type"] = $material_type;
            M('wechat_auto_reply')->where("manage_id=$manage_id and type='default' and material_type='text' and keyword_type='0' ")->delete();
            M('wechat_auto_reply')->where("manage_id=$manage_id and type='default' and material_type='media' and keyword_type='0' ")->delete();
            $result=$this->auto_model->add($data);
            if($result){
                $this->success("添加成功");
            }else{
                $this->error("添加失败！");
            }
        }

    }

    //关键字自动回复添加
    public function helpreply_post(){
        $manage_id=I("manage_id");//公众号ID
        $material_type = I("material_type");
        if($material_type=="media"){ //表示图文
            $mid = I("mid"); //素材ID
            if(empty($mid)){
                $this->error("请选择图文");
            }else{
                $keyword=I("keyword");//关键词
                if($keyword){
                    $data["keyword"]=$keyword;
                }
//                else{
//                    $this->error("请填写关键词");
//                }
                $keyword_type=I("keyword_type");//关键词类型
                if($keyword_type){
                    $data["keyword_type"]=$keyword_type;
                }
                $type=I("type");//事件类型
                $data["type"]=$type;
                $data["mid"] = $mid;
                $data["material_type"] = $material_type;
                $data["manage_id"] = $manage_id;
                $this->auto_model->where("manage_id=$manage_id and type='default' and material_type='media' and keyword_type>0 ")->delete();
                $result= $this->auto_model->add($data);
                if($result){
                    //
                    $this->success("添加成功！");
                }else{
                    $this->error("添加失败！");
                }
            }
            return;
        }
        if($material_type=="text"){
            //文字自动回复
            $manage_id=I("manage_id");//公众号ID
            $data["manage_id"]=$manage_id;
            $type=I("type");//事件类型
            if($type){
                $data["type"]=$type;
            }else{
                $this->error("请选择事件类型");
            }
            $content=I("content");//时间类型
            if($content){
                $data["content"]=trim($content);
            }
//            else{
//                $this->error("请填写内容");
//            }
            $keyword=I("keyword");//关键词
            if($keyword){
                $data["keyword"]=$keyword;
            }
//            else{
//                $this->error("请填写关键词");
//            }
            $keyword_type=I("keyword_type");//关键词类型
            if($keyword_type){
                $data["keyword_type"]=$keyword_type;
            }
            $data["material_type"] = $material_type;
            M('wechat_auto_reply')->where("manage_id=$manage_id and type='default' and material_type='text' and keyword_type>0 ")->delete();
            $result=$this->auto_model->add($data);
            if($result){
                $this->success("添加成功");
            }else{
                $this->error("添加失败！");
            }
        }
        //文字自动回复
//        $manage_id=I("manage_id");//公众号ID
//        if($manage_id){
//            $data["manage_id"]=$manage_id;
//            M('wechat_auto_reply')->where("manage_id=$manage_id and type='default'")->delete();
//        }else{
//            $this->error("请选择公众号");
//        }
//        $type=I("type");//事件类型
//        if($type){
//            $data["type"]=$type;
//        }else{
//            $this->error("请选择事件类型");
//        }
//        $content=I("content");//时间类型
//        if($content){
//            $data["content"]=$content;
//        }else{
//            $this->error("请填写内容");
//        }
//
//        $keyword=I("keyword");//关键词
//        if($keyword){
//            $data["keyword"]=$keyword;
//        }else{
//            $this->error("请填写关键词");
//        }
//        $keyword_type=I("keyword_type");//关键词类型
//        if($keyword_type){
//            $data["keyword_type"]=$keyword_type;
//        }
//
//        $result=$this->auto_model->add($data);
//        if($result){
//            $this->success("添加成功！", U("subscribereply"));
//        }else{
//            $this->error("添加失败！", U("subscribereply"));
//        }

    }

    //添加自定义菜单
    public  function custommenu(){
        //拉取公众号
        $wxmanage = M('wxmanage')->select();
        $this->assign('wxmanage',$wxmanage);
        $this->display("menuadd");
    }

    //自定义菜单提交
    public function custommenu_post(){

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

    //菜单列表
    public  function menu_index(){
        $wxmanage = M('wxmanage')->field("id,wx_name")->select();//拉取公众号
        $this->assign('wxmanage',$wxmanage);

        $manage_id = I('manage_id'); //公众号ID  搜索条件
        if (!empty($manage_id)){
            $where['a.manage_id'] = $manage_id;
            $this->assign("manage_id", $manage_id);
        }

        $count = M('wechat_menu as a')->
        join("wxt_wxmanage as b on a.manage_id = b.id")->
        where($where)->
        field("a.*,b.wx_name")->order("a.manage_id,a.menulevel,a.orderby")->count();
        $page = $this->page($count,20);

        $menulist = M('wechat_menu as a')->
        join("wxt_wxmanage as b on a.manage_id = b.id")->
        where($where)->
        limit($page->firstRow . ',' . $page->listRows)->
        field("a.*,b.wx_name")->order("a.manage_id,a.menulevel,a.orderby")->select();

        $this->assign('menulist',$menulist);
        $this->assign("Page", $page->show('Admin'));
        $this->display("menu_index");
    }

    function menu_delete(){
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


    function get_fileext($file='')
    {
        return strtolower(substr(strrchr($file,'.'),1));
    }
    function pw_addslashes($str)
    {
        if(!is_array($str))
        {
            return addslashes($str);
        }

        foreach($str as $key=>$value)
        {
            $str[$key]=pw_addslashes($value);
        }
        return $str;
    }
    /*
		素材
	*/
    static public function postImageMaterial($info)
    {
        //return MySql::insert(DB_PRE.self::$mImageMaterialTable,$info,true);
        $res= M('wechat_image_material')->add($info);
        return $res;
    }

    //获取 access_token
    function getAccess_token()
    {
        $appid = $_SESSION["appid"];
        $appsecret = $_SESSION["appsecret"];
        ///dump($_SESSION);
        //die();
//        $appsecret = "dcf74ff6006349aa18a3badee64657af";
//        $appid = "wx45f1328ec64254b9";
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
    //上传图片
    public function upload(){
//        dump($_FILES);
//        die();
        if ($_FILES){
            $array['date'] = date('YmdHis', mktime());
            $array['name'] = rand(1000, 9999);
            $name = implode($array);//定义一个命名规则

            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   =     3145728888 ;// 设置附件上传大小 3MB
            $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath  =     './uploads/'; // 设置附件上传根目录
            $upload->savePath  =     'microblog/'; // 设置附件上传（子）目录
            $upload->saveName  =     $name;//图片名字
            $upload->autoSub = false;
            // 上传文件
            $info   =   $upload->upload();
            $info["upload_file"]["url"] =str_replace("%2F","/",$info["upload_file"]["url"]);
            //echo  $info;
            echo json_encode($info);
//            if($info){
//                //$this->success("上传成功");
//            }else{
//                $this->error($upload->getError());
//            }

        }else{
            echo "111";
        }

//        return $info;
        //var_dump($info);
//        if ($info){
//           $this->success("上传成功");
//        }else{
//            $this->error($upload->getError());
//
//        }

    }


    //二维码列表
    public function sceneqrcode_list(){
        $wxmanage = M('wxmanage')->field("id,wx_name")->select();//拉取公众号
        $this->assign('wxmanage',$wxmanage);

        $manage_id = I('manage_id'); //公众号ID  搜索条件
        if (!empty($manage_id)){
            $where['a.manage_id'] = $manage_id;
            $this->assign("manage_id", $manage_id);
        }

        $count = M('wechat_qrcode as a')->
        join("wxt_wxmanage as b on a.manage_id = b.id")->
        where($where)->
        field("a.*,b.wx_name")->order("a.manage_id")->count();
        $page = $this->page($count, 15);

        $sceneqrcode = M('wechat_qrcode as a')->
        join("wxt_wxmanage as b on a.manage_id = b.id")->
        where($where)->
        limit($page->firstRow . ',' . $page->listRows)->
        field("a.*,b.wx_name")->order("a.manage_id")->select();

        $this->assign("Page", $page->show('Admin'));
        $this->assign("sceneqrcode",$sceneqrcode);
        $this->display();
    }
    //二维码页面
    public function sceneqrcode_add(){
        //拉取公众号
        $wxmanage = M('wxmanage')->select();
        $this->assign('wxmanage',$wxmanage);
        $this->display();
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

    //二维码页面提交
    public function sceneqrcode_post()
    {
        $manage_id=I("manage_id");//公众号ID
        if($manage_id){
            $data["manage_id"]=$manage_id;
            $manage = M('wxmanage')->where("id =$manage_id ")->find();
            $_SESSION["appid"] = $manage["wx_appid"];  //获取ADDID
            $_SESSION["appsecret"] = $manage["wx_appsecret"]; //获取appsecret
        }else{
            $this->error("请选择公众号");
        }

        $schoolid = I("schoolid");
        if($schoolid){
            $data["schoolid"]=$schoolid;
        }else{
            $this->error("请选择学校");
        }

        $name=I("name");//场景名称
        if($name){
            $data["scene_name"]=$name;
        }else{
            $this->error("请选择场景名称");
        }


//        $keyword=I("keyword");//关键字
//        if($keyword){
//            $data["keyword"]=$keyword;
//        }else{
//            $this->error("请选择菜单类型");
//        }
//        $data["keyword"]=$keyword;
        $data["typeid"]=1;
        $data["createtime"]=time();
//        dump($data);
//        die();
        $result=M("wechat_qrcode")->add($data);
        if($result){
            $arr = $this->sceneqrcodeCreate($result);
//            dump($arr);
//            die();
            if($arr["ticket"]){
                $data["ticket"] = $arr["ticket"];
                $res=M("wechat_qrcode")->where("scene_id= $result")->save($data);
                $this->success("生成成功");
            }else{
                M("wechat_qrcode")->where("scene_id= $result")->delete(); // 删除数据
                $this->error("生成失败");
            }
        }else{
            $this->error("生成失败");
        }
    }
    //生成二维码
    public function sceneqrcodeCreate($id){
        $id=intval($id);
        $token = $this->getAccess_token();
//        dump($token);
//        die();
        $url='https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$token;
        $output=(array)json_decode($this->http_request($url,'{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": '.$id.'}}}'));

        return $output;

//        $output['expiretime']=$output['expire_seconds']?(CLIENT_TIME+$output['expire_seconds']):0;
    }

     public function sceneqrcodeView()
    {

        $id=intval(I("id"));
        $result = M("wechat_qrcode")->where("scene_id=$id")->find();
        if(count($result)){
            $url = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$result["ticket"];
            //return 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$result["ticket"];
            Header("Location: $url");
        }
       // echo $url;
        //$img = file_get_contents($url);
    }

    //二维码删除
    public function sceneqrcode_delete(){
        $id = I("id"); //场景ID
        if(empty($id)){
            $this->error("删除失败！");
            die();
        }
        if($id){
            $result = M("wechat_qrcode")->where("scene_id=$id")->delete();
            if ($result) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            }
        }
    }

    //粉丝首页
    public function fans_list(){
        $wx = M('wxmanage')
            ->alias('w')
            ->order('w.id desc')
            ->select();
        $count = count($wx);
        $page = $this->page($count, 15);
        $wx = M('wxmanage')
            ->alias('w')
            ->limit($page->firstRow . ',' . $page->listRows)
            ->order('w.id desc')
            ->select();
        $this->assign('page', $page->show('Admin'));
        $this->assign('wx', $wx);
        $this->display();
    }

    //粉丝列表
    public function fans_index(){
        $manage_id=I("id");//公众号ID
        if($manage_id){
            $data["manage_id"]=$manage_id;
            $manage = M('wxmanage')->where("id =$manage_id ")->find();
            $_SESSION["appid"] = $manage["wx_appid"];  //获取ADDID
            $_SESSION["appsecret"] = $manage["wx_appsecret"]; //获取appsecret
        }

        $s = M("wechat_fans")->where("manage_id=$manage_id")->select();
        $count = count($s);
        $page = $this->page($count, 10);
        $fans = M("wechat_fans")->where("manage_id=$manage_id")->limit($page->firstRow . ',' . $page->listRows)->select();
        $this->assign('fans', $fans);
        $this->assign('Page', $page->show('Admin'));
        $this->assign('manage_id', $manage_id);//公众号ID
        $this->display();
    }

     public function fansSynchronism()
    {
        $manage_id = I("manage_id");
        $next_openid = "";
        $token = $this->getAccess_token();
        $url='https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$token.'&next_openid='.$next_openid;
        $output=(array)json_decode($this->http_request($url));
        $data=(array)$output['data'];

        if($data['openid'])
        {
            foreach($data['openid'] as $openid)
            {
                $url='https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$token.'&openid='.$openid.'&lang=zh_CN ';
                $useroutput=(array)json_decode($this->http_request($url));
                $useroutput['issubscribe']=$useroutput['subscribe'];
                $useroutput['subscribetime']=$useroutput['subscribe_time'];

                $r =M("wechat_fans")->where(array("openid"=>$openid,"manage_id"=>$manage_id))->find();

                //dump($r);
                if($r)
                {
                    $useroutput["manage_id"] = $manage_id;
                    $id = $r['id'];
                    $a = M("wechat_fans")->where("id= $id")->save($useroutput);
                    //echo $a;
                }
                else
                {
                    $useroutput["manage_id"] = $manage_id;
                    M("wechat_fans")->add($useroutput);
                }
            }
        }
//        dump($output);
//        die();
        //return $output;
        $this->success('刷新成功','fans_index/manage_id'.$manage_id);
    }


}


class Form
{
    static public $mFname='info';

    static public function loadForm($fname='info')
    {
        self::$mFname=$fname;
    }
    function is_image($img='')
    {
        return in_array(strtolower(Form::get_fileext($img)),array('gif','jpg','jpeg','png','bmp'));
    }
    function get_fileext($file='')
    {
        return strtolower(substr(strrchr($file,'.'),1));
    }
    function format_url($str='')
    {
        global $PW;
        return strtolower(substr($str,0,7))=='http://'?$str:$PW['site_url'].(substr($str,0,1)=='/'?substr($str,1):$str);
    }
    static public function image($cnname,$enname,$defaultvalue='',$options='',$regex='limit',$notnull=0,$length='255',$css='')
    {
        return '<div class="upload_div">
					<input type="hidden" name="'.self::$mFname.'['.$enname.']" value="'.$defaultvalue.'" id="upload_hidden_val'.$enname.'">
                    <iframe width="0" height="0" frameborder="0" src="" name="upload_iframe'.$enname.'" id="upload_iframe'.$enname.'"></iframe>
                    <span class="form_file">
                    <div class="file_path" id="upload_path'.$enname.'"></div>
                    <label class="file_btn">本地图片</label>
                    <input type="file" name="upload_file'.$enname.'" id="upload_file'.$enname.'" onChange="selectImageBtn(\''.$enname.'\',\'\');" accept="image/jpeg,image/x-png,image/gif" class="file">
                    &nbsp;
                    <span id="upload_loading'.$enname.'"></span>
                    </span>
                    <div style="clear:both">
                    <img src="'.(Form::is_image($defaultvalue)?Form::format_url($defaultvalue):Form::format_url('statics/images/demo.png')).'?t='.mt_rand().'" id="img_demo'.$enname.'" class="form_file_img_demo">
					</div>
               </div>';
    }

    static public function attachment($cnname,$enname,$defaultvalue='',$options='',$regex='limit',$notnull=0,$length='255',$css='')
    {
        return '<div class="attachment-div">
				<iframe width="0" height="0" frameborder="0" src="" name="attachment_upload_iframe'.$enname.'" style="display:none"></iframe>
				<div>
				外部附件：
				</div>
				<div>
				<input type="text" class="attachment_value" name="'.self::$mFname.'['.$enname.']" value="'.(is_attachment($defaultvalue)?$defaultvalue:'http://').'" id="attachment_value'.$enname.'">
				</div>
				<div>
				您也可以：
				</div>
				<div>
				<input type="file" class="attachment_file" name="attachment_file'.$enname.'" id="attachment_file'.$enname.'" onchange="selectAttachmentBtn(\''.$enname.'\');">
				<span class="attachment_upload_btn" id="attachment_upload_btn'.$enname.'">上传一个'.$cnname.'</span>
				</div>
				<div><font style="color:#ff0000;font-size:12px">上传提示：只允许上传 ZIP\RAR\TAR.GZ 格式的附件</font></div>
		</div>';
    }

    static public function video($cnname,$enname,$defaultvalue='',$options='',$regex='limit',$notnull=0,$length='255',$css='')
    {
        return '<div class="video-div">
			<iframe width="0" height="0" frameborder="0" src="" name="video_upload_iframe'.$enname.'" style="display:none"></iframe>
				<div>
				外部视频：
				</div>
				<div>
				<input type="text" class="video_value" name="'.self::$mFname.'['.$enname.']" value="'.(is_video($defaultvalue)?$defaultvalue:'http://').'" id="video_value'.$enname.'">
				</div>
				<div>
				您也可以：
				</div>
				<div>
				<input type="file" class="video_file" name="video_file'.$enname.'" id="video_file'.$enname.'" onchange="selectVideoBtn(\''.$enname.'\');">
				<span class="video_upload_btn" id="video_upload_btn'.$enname.'">上传一个视频</span>
				</div>
				<div><font style="color:#ff0000;font-size:12px">上传提示：只允许上传 Flv\Swf\Mp4 格式的视频</font></div>
		</div>';
    }

    static public function formFile($cnname,$enname,$defaultvalue='',$options='',$regex='limit',$notnull=0,$length='255',$css='')
    {
        return '<div class="formfile-div">
				<div>
				<input type="hidden" name="'.self::$mFname.'['.$enname.']" value="'.(is_pem($defaultvalue)?$defaultvalue:'').'">
				<input type="file" class="formfile_file" name="'.$enname.'" id="formfile_file'.$enname.'" onchange="selectFormfileBtn(\''.$enname.'\');">
				<span class="formfile_upload_btn" id="formfile_upload_btn'.$enname.'">上传一个'.trim($cnname,'.'.get_fileext($cnname)).'</span> '.(is_pem($defaultvalue)?'<font style="font-size:12px;color:#339933">已上传</font>':'').'
				</div>
				<div><font style="color:#ff0000;font-size:12px">上传提示：'.trim($cnname,'.'.get_fileext($cnname)).'是'.get_fileext($cnname).'格式的文件</font></div>
		</div>';
    }

    static public function images($cnname,$enname,$defaultvalue='',$options='',$regex='limit',$notnull=0,$length='255',$css='')
    {
        global $PW;

        $list='';
        $val=array();
        if($defaultvalue)
        {
            $val=explode(',',$defaultvalue);
            if($val)foreach($val as $k => $v)
            {
                $v=explode('`',$v);
                $list.='<li class="albCt"><img style="border:#EBEBEB 1px solid;max-width:139px;height:100px;" src="'.$v[0].'" alt="'.$v[1].'"/> <input type="hidden" name="urlimgs_'.$enname.'['.$k.']" value="'.$v[0].'" /><span class="thumbpictip"><input type="checkbox" style="cursor:pointer;border:0px" class="common-checkbox" name=deleteimgs_'.$enname.'['.$k.'] value="0" id="checkbox_images_'.$k.'" checked="checked" /></span><div style="margin:0px; padding:0px;margin-top:5px; clear:both"><input type="text" name="nameimgs_'.$enname.'['.$k.']" value="'.$v[1].'" style="border:#EBEBEB 1px solid; font-size:12px;width:135px; line-height:24px;height:24px; padding:2px" placeholder="请输入图片名称" /></div></li>';
            }
        }

        $_SESSION["file_info"] = array();
        return '<input type="hidden" value="'.$value.'" name="'.self::$mFname.'['.$enname.']" />
<script type="text/javascript" src="'.$PW['site_url'].'statics/swfupload/swfupload.js"></script>
<script type="text/javascript" src="'.$PW['site_url'].'statics/swfupload/handlers.js"></script>
<script type="text/javascript">
		var swfu'.$enname.';
		var func_'.$enname.' = window.onload;
		
		window.onload = function () {
			func_'.$enname.' ? func_'.$enname.'() : 0;
			swfu'.$enname.' = new SWFUpload({
				// Backend Settings
				upload_url: "'.$PW['site_url'].'api/upload/swfupload/swfupload.php",
				post_params: {"PHPSESSID": "'.session_id().'"},

				file_size_limit : "20MB",	
				file_types : "*.jpg;*.gif;*.png;*.jpeg",
				file_types_description : "图片文件",
				file_upload_limit : '.(defined('IN_MANAGE')?127:5).',

				swfupload_preload_handler : preLoad,
				swfupload_load_failed_handler : loadFailed,
				file_queue_error_handler : fileQueueError,
				file_dialog_complete_handler : fileDialogComplete,
				upload_progress_handler : uploadProgress,
				upload_error_handler : uploadError,
				upload_success_handler : uploadSuccess,
				upload_complete_handler : uploadComplete,

				button_image_url : "'.$PW['site_url'].'statics/swfupload/images/SmallSpyGlassWithTransperancy_17x18.png",
				button_placeholder_id : "spanButtonPlaceholder'.$enname.'",
				button_width: 95,
				button_height: 18,
				button_text : \'上传图片\',
				button_text_style : ".button {    font: 14px/1.5 \'Microsoft YaHei\';}",
				button_text_top_padding: 2,
				button_text_left_padding: 18,
				button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
				button_cursor: SWFUpload.CURSOR.HAND,
				
				flash_url : "'.$PW['site_url'].'statics/swfupload/swfupload.swf",
				flash9_url : "'.$PW['site_url'].'statics/swfupload/swfupload_FP9.swf",

				custom_settings : {
					upload_target : "divFileProgressContainer'.$enname.'",
					thumbnail_width : "800",
					thumbnail_height : "800",
					fieldid : "'.$enname.'",
					startid : "'.(count($val)+1).'"
				},
				
				// Debug Settings
				debug: false
			});
		};
	</script>
	<style type="text/css">
		.progressBarStatus{padding:0px;margin:0px; color:forestgreen;height: 18px;line-height: 18px;padding-top: 3px;padding-left:8px}
		.progressName{display:none}
		#thumbnails'.$enname.'{padding:0px; margin:0px; clear:both}
		#thumbnails'.$enname.' ul{width:800px; clear:both; margin:0px; list-style:none; padding:0px}
		#thumbnails'.$enname.' ul li{width:150px; float:left; margin:4px; padding:0px; overflow:hidden;position:relative}
		.thumbpictip{position:absolute;left:0px;top:0px;color:#ffffff;padding:0px;height: 20px;font-size:12px;width: 20px;line-height: 20px; text-align: center;}
	</style>
	<div id="content" style="margin-top: 8px;width:800px;overflow:hidden">
		<div style="display:inline-block;line-height:19px;height:19px;border: solid 1px #ccc; background-color: #f7f7f7; padding: 2px;width:80px;float:left ">
			<span id="spanButtonPlaceholder'.$enname.'"></span>
		</div>
		<div style="float:left;padding-left:8px;padding-top:2px;font-size:12px;line-height:20px;height:19px;color:#666">
		点击选择图片
		</div>
	<div id="divFileProgressContainer'.$enname.'"></div>
	<div id="thumbnails'.$enname.'"><ul id="thumbnailsul'.$enname.'">'.$list.'</ul></div></div>
	<div style="clear:both;margin:8px 0px;margin-top:4px;" id="adtips'.$enname.'"><img src="'.$PW['site_url'].'statics/swfupload/images/adshow.png"></div>
	';
    }

    static public function map($cnname,$enname,$defaultvalue='',$options='',$regex='limit',$notnull=0,$length='255',$css='')
    {
        $str=defined('form_map')?'':'<script charset="utf-8" src="http://map.qq.com/api/js?v=2.exp"></script>';
        $str.='<input name="'.self::$mFname.'['.$enname.']" readonly="1" class="map_value" value="'.($defaultvalue?$defaultvalue:'39.916527, 116.397128').'" id="longitude_latitude'.$enname.'"> <input type="button" data-reveal-id="myModal'.$enname.'" class="map_btn" value="标注地图" data-animation="fade">
		<div id="myModal'.$enname.'" class="reveal-modal">
			<h1>地图标注</h1>
			<p>
			<div id="container'.$enname.'" style="width:800px;height:550px"></div>
			<script type="text/javascript">
				function init'.$enname.'() {
					//div容器
					var container = document.getElementById("container'.$enname.'");
					//初始化地图
					var map = new qq.maps.Map(container, {
						// 地图的中心地理坐标
						center: new qq.maps.LatLng('.($defaultvalue?$defaultvalue:'39.916527, 116.397128').'),
						zoom: 12
					});
				  //创建自定义控件
				   var middleControl = document.createElement("div");
					middleControl.style.left="50%";
					middleControl.style.top="250px";
					middleControl.style.position="relative";
					middleControl.style.width="36px";
					middleControl.style.height="36px";
					middleControl.style.zIndex="100000";
				    middleControl.innerHTML =\'<img src="'.PW_PATH.'statics/images/icon-location.png" />\';
				    container.appendChild(middleControl);

					//当地图中心属性更改时触发事件
					qq.maps.event.addListener(map, "center_changed", function() {
						$("#longitude_latitude'.$enname.'").val(map.getCenter());
					});
				}
				init'.$enname.'();
			</script>
			</p>
			<a class="close-reveal-modal">&#215;</a>
		</div>';

        if(!defined('form_map'))
        {
            define('form_map',true);
        }

        return $str;
    }

    static public function dateNoTime($cnname,$enname,$defaultvalue='',$options='',$regex='limit',$notnull=0,$length='255',$css='')
    {
        global $PW;

        $str= defined('form_laydate')?'':'<script src="'.$PW['site_url'].'statics/laydate/laydate.js"></script>';
        $str.='<input name="'.self::$mFname.'['.$enname.']" value="'.date('Y-m-d',$defaultvalue).'" class="laydate-icon" style="padding:3px;" onclick="laydate({istime: false, format: \'YYYY-MM-DD\'})">';

        if(!defined('form_laydate'))
        {
            define('form_laydate',true);
        }

        return $str;
    }

    static public function dateNoTimeArray($cnname,$enname,$defaultvalue='',$options='',$regex='limit',$notnull=0,$length='255',$css='')
    {
        global $PW;

        $str= defined('form_laydate')?'':'<script src="'.$PW['site_url'].'statics/laydate/laydate.js"></script>';
        $str.='<input name="'.self::$mFname.'['.$enname.'][]" value="'.date('Y-m-d',$defaultvalue).'" class="laydate-icon" style="padding:3px;" onclick="laydate({istime: false, format: \'YYYY-MM-DD\'})">';

        if(!defined('form_laydate'))
        {
            define('form_laydate',true);
        }

        return $str;
    }

    static public function dateWithTime($cnname,$enname,$defaultvalue='',$options='',$regex='limit',$notnull=0,$length='255',$css='')
    {
        global $PW;

        $str= defined('form_laydate')?'':'<script src="'.$PW['site_url'].'statics/laydate/laydate.js"></script>';
        $str.='<input name="'.self::$mFname.'['.$enname.']" value="'.date('Y-m-d H:i:s',$defaultvalue).'" class="laydate-icon" style="padding:3px;" onclick="laydate({istime: true, format: \'YYYY-MM-DD hh:mm:ss\'})">';

        if(!defined('form_laydate'))
        {
            define('form_laydate',true);
        }

        return $str;
    }

    static public function dateWithTimeArray($cnname,$enname,$defaultvalue='',$options='',$regex='limit',$notnull=0,$length='255',$css='')
    {
        global $PW;

        $str= defined('form_laydate')?'':'<script src="'.$PW['site_url'].'statics/laydate/laydate.js"></script>';
        $str.='<input name="'.self::$mFname.'['.$enname.'][]" value="'.date('Y-m-d H:i:s',$defaultvalue).'" class="laydate-icon" style="padding:3px;" onclick="laydate({istime: true, format: \'YYYY-MM-DD hh:mm:ss\'})">';

        if(!defined('form_laydate'))
        {
            define('form_laydate',true);
        }

        return $str;
    }

    static public function dateTimeStartToEnd($cnname,$enname,$defaultvalue='',$options='',$regex='limit',$notnull=0,$length='255',$css='')
    {
        global $PW;

        $defaultvalue=explode(',',$defaultvalue);

        $str= defined('form_laydate')?'':'<script src="'.$PW['site_url'].'statics/laydate/laydate.js"></script>';

        $str.= '<input id="start'.$enname.'_'.$PW['i_count'].'" name="'.self::$mFname.'[start'.$enname.']" value="'.($defaultvalue[0]?date('Y-m-d H:i:s',$defaultvalue[0]):date('Y-m-d H:i:s')).'" class="laydate-icon" style="padding:3px;" > - 
				<input id="end'.$enname.'_'.$PW['i_count'].'" name="'.self::$mFname.'[end'.$enname.']" value="'.(isset($defaultvalue[1]) && $defaultvalue[1]?date('Y-m-d H:i:s',$defaultvalue[1]):date('Y-m-d H:i:s',CLIENT_TIME+24*3600)).'" class="laydate-icon" style="padding:3px;" >
				<script>
					var start'.$enname.'_'.$PW['i_count'].' = {
						elem: \'#start'.$enname.'_'.$PW['i_count'].'\',
						format: \'YYYY/MM/DD hh:mm:ss\',
						min: laydate.now(), //设定最小日期为当前日期
						max: \'2099-06-16 23:59:59\', //最大日期
						istime: true,
						istoday: false,
						choose: function(datas){
							 end.min = datas; //开始日选好后，重置结束日的最小日期
							 end.start = datas //将结束日的初始值设定为开始日
						}
					};
					var end'.$enname.'_'.$PW['i_count'].' = {
						elem: \'#end'.$enname.'_'.$PW['i_count'].'\',
						format: \'YYYY/MM/DD hh:mm:ss\',
						min: laydate.now(),
						max: \'2099-06-16 23:59:59\',
						istime: true,
						istoday: false,
						choose: function(datas){
							start.max = datas; //结束日选好后，重置开始日的最大日期
						}
					};
					laydate(start'.$enname.'_'.$PW['i_count'].');
					laydate(end'.$enname.'_'.$PW['i_count'].');
				</script>';
        if(!defined('form_laydate'))
        {
            define('form_laydate',true);
        }
        else
        {
            $PW['i_count']++;
        }
        return $str;
    }

    static public function dateTimeStartToEndArray($cnname,$enname,$defaultvalue='',$options='',$regex='limit',$notnull=0,$length='255',$css='')
    {
        global $PW;

        $defaultvalue=explode(',',$defaultvalue);

        $str= defined('form_laydate')?'':'<script src="'.$PW['site_url'].'statics/laydate/laydate.js"></script>';

        $str.= '<input id="start'.$enname.'_'.$PW['i_count'].'" name="'.self::$mFname.'[start'.$enname.'][]" value="'.($defaultvalue[0]?date('Y-m-d H:i:s',$defaultvalue[0]):date('Y-m-d H:i:s')).'" class="laydate-icon" style="padding:3px;" > - 
				<input id="end'.$enname.'_'.$PW['i_count'].'" name="'.self::$mFname.'[end'.$enname.'][]" value="'.(isset($defaultvalue[1]) && $defaultvalue[1]?date('Y-m-d H:i:s',$defaultvalue[1]):date('Y-m-d H:i:s',CLIENT_TIME+24*3600)).'" class="laydate-icon" style="padding:3px;" >
				<script>
					var start'.$enname.'_'.$PW['i_count'].' = {
						elem: \'#start'.$enname.'_'.$PW['i_count'].'\',
						format: \'YYYY/MM/DD hh:mm:ss\',
						min: laydate.now(), //设定最小日期为当前日期
						max: \'2099-06-16 23:59:59\', //最大日期
						istime: true,
						istoday: false,
						choose: function(datas){
							 end.min = datas; //开始日选好后，重置结束日的最小日期
							 end.start = datas //将结束日的初始值设定为开始日
						}
					};
					var end'.$enname.'_'.$PW['i_count'].' = {
						elem: \'#end'.$enname.'_'.$PW['i_count'].'\',
						format: \'YYYY/MM/DD hh:mm:ss\',
						min: laydate.now(),
						max: \'2099-06-16 23:59:59\',
						istime: true,
						istoday: false,
						choose: function(datas){
							start.max = datas; //结束日选好后，重置开始日的最大日期
						}
					};
					laydate(start'.$enname.'_'.$PW['i_count'].');
					laydate(end'.$enname.'_'.$PW['i_count'].');
				</script>';
        if(!defined('form_laydate'))
        {
            define('form_laydate',true);
        }
        else
        {
            $PW['i_count']++;
        }
        return $str;
    }

    static public function baiduEditor($cnname,$enname,$defaultvalue='',$options='',$regex='limit',$notnull=0,$length='255',$css='')
    {
        global $PW;

        return '<link href="'.__ROOT__.'/statics/phpwechat/umeditor/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">
		<textarea name="'.self::$mFname.'['.$enname.']" id="myEditor'.$enname.'">'.htmlspecialchars($defaultvalue).'</textarea>
		<script type="text/javascript">
			var UEDITOR_SITE_URL="'.$PW['site_url'].'";
		</script>
		<script type="text/javascript" charset="utf-8" src="'.__ROOT__.'/statics/phpwechat/umeditor/umeditor.config.js"></script>
		<script type="text/javascript" charset="utf-8" src="'.__ROOT__.'/statics/phpwechat/umeditor/umeditor.min.js"></script>
		<script type="text/javascript" src="'.__ROOT__.'/statics/phpwechat/umeditor/lang/zh-cn/zh-cn.js"></script>
		<script type="text/javascript">
			var um = UM.getEditor("myEditor'.$enname.'");
		</script>';
    }
}
