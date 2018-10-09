<?php

/**
 * 后台首页  日常管理
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class ClassActivityController extends AdminbaseController {


    function _initialize() {
        parent::_initialize();
        $this->school_model = D("Common/School");
        $this->wxtuser_model = D("Common/wxtuser");
        $this->class_model = D("Common/school_class");
        $this->wxt_agent_model=D("Common/agent");
        $this->activity_model=D("Common/activity");
        $this->entry_model=D("Common/entryactivity");
        $this->microblog_pic_url_model=D("Common/microblog_picture_url");
    }

    public function index() {
        $this->_lists();
        $this->_getTree();
        $this->display("");
    }
private  function _lists($status=1){
        $school_id=0;
        if(!empty($_REQUEST["class"])){
            $class_id=intval($_REQUEST["class"]);
            //$this->assign("school_id",$school_id);
            //$_GET['school_id']=$school_id;
        }
        
        $where_ands=empty($class_id)?array(""):array("id = $class_id");
        $fields=array(
                'start_time'=> array("field"=>"post_date","operator"=>">"),
                'end_time'  => array("field"=>"post_date","operator"=>"<"),
                'keyword'  => array("field"=>"title","operator"=>"like"),
        );

        if(IS_POST){
            
            foreach ($fields as $param =>$val){
                if (isset($_POST[$param]) && !empty($_POST[$param])) {
                    $operator=$val['operator'];
                    $field   =$val['field'];
                    $get=$_POST[$param];
                    $_GET[$param]=$get;
                    if($operator=="like"){
                        $get="%$get%";
                    }
                    array_push($where_ands, "$field $operator '$get'");
                }
            }
        }else{
            foreach ($fields as $param =>$val){
                if (isset($_GET[$param]) && !empty($_GET[$param])) {
                    $operator=$val['operator'];
                    $field   =$val['field'];
                    $get=$_GET[$param];
                    if($operator=="like"){
                        $get="%$get%";
                    }
                    array_push($where_ands, "$field $operator '$get'");
                }
            }
        }
        
        $where= join(" ", $where_ands);
            
        $count=$this->activity_model
        ->where($where)
        ->count();
            
        $page = $this->page($count, 20);
            
        $posts=$this->activity_model
        ->field('id,title,userid,classid,photo,content,create_time,contactman,contactphone,begintime,endtime,isapply,status')
        ->where($where)
        ->limit($page->firstRow . ',' . $page->listRows)
        ->order("id DESC")->select();

        foreach ($posts as &$user) {
             $username=$this->wxtuser_model
            ->alias("user")
            ->join("wxt_microblog_main pic")
            ->where(array("user.id"=>$user['userid']))
            ->field('name')
            ->find();

            $user["username"]=$username["name"];
            unset($user);
        }
         foreach ($posts as &$class) {
             $class_name=$this->class_model
            ->alias("cl")
            ->join("wxt_microblog_main pic")
            ->where(array("cl.schoolid"=>$class['classid']))
            ->field('classname')
            ->find();

            $class["class_name"]=$class_name["classname"];
            unset($class);
        }
         foreach ($posts as &$photo) {
             $smeta=$this->microblog_pic_url_model
            ->alias("p")
            ->join("wxt_microblog_main c")
            ->where(array("p.microblogid"=>$photo['mid']))
            ->field('pictureurl')
            ->find();

            $photo["smeta"]=sp_get_asset_upload_path($smeta["pictureurl"]);
            unset($photo);
        }
//var_dump($posts);
        $this->assign("Page", $page->show('Admin'));
        $this->assign("current_page",$page->GetCurrentPage());
        unset($_GET[C('VAR_URL_PARAMS')]);
        $this->assign("formget",$_GET);
        $this->assign("posts",$posts);
    }

//------------------删除信息------------------------
    function delete(){
         $id=intval($_GET['id']);
        //var_dump($id);
        if ($id) {
            $rst = $this->activity_model->where("id=$id")->delete();
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
/*-----------------------报名情况列表start-------------------*/
    public function entrylist(){
         //班级管理  班级列表
          //var_dump($_GET);
         $id = intval($_GET['id']);     
         if ($id) {
            $entrylist=$this->entry_model
            ->field('id,userid,activityid,fathername,contactphone,age,sex,create_time,status')
            ->where("activityid=$id")
            ->order("id DESC")
            ->select();

            foreach ($entrylist as &$entry_info) {
                $entryuser = $this->wxtuser_model
                ->where(array("id"=>$entry_info['userid']))
                ->field('name')
                ->find();
                $entry_info["entryuser"]=$entryuser["name"];
            unset($entry_info);
            }
              
            $this->assign("id",$id);
            $this->assign("entrylist",$entrylist);
            $this->display("");          
        }else{
            $this->error('数据传入失败！');
        }       
    }
//------------------报名情况列表end----------------
//------------------删除报名-----------------------
    function delete_entry(){
         $id=intval($_GET['id']);
        //var_dump($id);
        if ($id) {
            $rst = $this->entry_model->where("id=$id")->delete();
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
//------------------删除报名end--------------------
    //排序
    public function listorders() {
        $status = parent::_listorders($this->job_model);
        if ($status) {
            $this->success("排序更新成功！");
        } else {
            $this->error("排序更新失败！");
        }
    }

    private function _getTree(){
		$schoolid=empty($_REQUEST['class'])?0:intval($_REQUEST['class']);
		$result = $this->class_model->field("id ,classname as name")->order(array("id"=>"asc"))->select();
		$tree = new \Tree();
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		foreach ($result as $r) {
			$r['classid']=$r['id'];
			$r['selected']=$id==$r['classid']?"selected":"";
			$array[] = $r;
		}
		
		$tree->init($array);
		$str="<option value='\$id' \$selected>\$spacer\$name</option>";
		$taxonomys = $tree->get_tree(0, $str);
		$this->assign("taxonomys", $taxonomys);
	}
}