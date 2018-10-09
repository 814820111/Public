<?php

/**
 * 后台首页  日常管理
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class TeacherManageController extends AdminbaseController {


    function _initialize() {
        parent::_initialize();
        $this->school_model = D("Common/School");
        $this->wxtuser_model = D("Common/wxtuser");
        $this->wxt_agent_model=D("Common/agent");
        $this->teacher_model=D("Common/teacherinfo");
    }

    public function index() {
        $this->_lists();
        $this->_getTree();
        $this->display("");
    }
private  function _lists($status=1){
        $school_id=0;
        if(!empty($_REQUEST["school_id"])){
            $school_id=intval($_REQUEST["school_id"]);
            $this->assign("school_id",$school_id);
            $_GET['school_id']=$school_id;
        }
        
        $where_ands=empty($school_id)?array(""):array("school_id = $school_id");
        
        $fields=array(
                'start_time'=> array("field"=>"post_date","operator"=>">"),
                'end_time'  => array("field"=>"post_date","operator"=>"<"),
                'keyword'  => array("field"=>"post_title","operator"=>"like"),
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
        
        $where= join(" and ", $where_ands);
            
            
        $count=$this->teacher_model
        ->where($where)
        ->count();
            
        $page = $this->page($count, 20);
            
        $posts=$this->teacher_model
        ->field('id,schoolid,post_title,smeta,post_excerpt,post_content,post_date,post_status')
        ->where($where)
        ->limit($page->firstRow . ',' . $page->listRows)
        ->order("post_date DESC")->select();



        foreach ($posts as &$teacher) {
             $schoolname=$this->school_model
            ->alias("school")
            ->join("wxt_teacherinfo teacher")
            ->where(array("school.schoolid"=>$teacher['schoolid']))
            ->field('school_name')
            ->find();

            $teacher["schoolname"]=$schoolname["school_name"];
            unset($teacher);
        }

        $this->assign("Page", $page->show('Admin'));
        $this->assign("current_page",$page->GetCurrentPage());
        unset($_GET[C('VAR_URL_PARAMS')]);
        $this->assign("formget",$_GET);
//        $this->assign("school_name",$school_name);
        $this->assign("posts",$posts);
    }
//------------------增加校园招聘----------------
  function add(){
        $school_name = $this->school_model->order(array("schoolid"=>"asc"))->select();
        $schoolid = intval(I("get.school"));
        $this->_getTree();
        $teacher=$this->teacher_model->where("schoolid=$schoolid")->find();
        $this->assign("author","1");
        $this->assign("teacher",$teacher);
        $this->assign("school_name",$school_name);
        $this->display();
    }
    
    function add_post(){
        if (IS_POST) {
            if(empty($_POST['school'])){
                $this->error("请至少选择一个学校！");
            }
            if(!empty($_POST['photos_alt']) && !empty($_POST['photos_url'])){
                foreach ($_POST['photos_url'] as $key=>$url){
                    $photourl=sp_asset_relative_url($url);
                    $_POST['smeta']['photo'][]=array("url"=>$photourl,"alt"=>$_POST['photos_alt'][$key]);
                }
            }
            $_POST['smeta']['thumb'] = sp_asset_relative_url($_POST['smeta']['thumb']);
             
            $_POST['post']['post_date']=date("Y-m-d H:i:s",time());
           //$_POST['post']['post_author']=get_current_admin_id();
            $teacher=I("post.post");
            $teacher['schoolid']=$_POST['school'];
            // $schoolname=$this->school_model->where("$school_id=schoolid")->getField('school_name');

            $teacher['smeta']=json_encode($_POST['smeta']);
            $teacher['post_content']=htmlspecialchars_decode($teacher['post_content']);
            $result=$this->teacher_model->add($teacher);
            if ($result) {
                
                // foreach ($_POST['school'] as $mschool_id){
                //     $this->job_model->add(array("schoolid"=>intval($mschool_id)));
                // }
                
                $this->success("添加成功！");
            } else {
                $this->error("添加失败！");
            }
             
        }
    }
//------------------增加校园招聘结束----------------

//------------------更新校园招聘开始----------------
    public function edit(){
        $id=  intval(I("id"));
        //var_dump($id);
        $schoolid = intval(I("get.school"));
        $this->_getTree();
         $school_name = $this->school_model->order(array("schoolid"=>"asc"))->select();
        $teacher = $this->teacher_model->where(array("id"=>$id))->find();
        //$this->_getTermTree($term_relationship);
        //$terms=$this->terms_model->select();
        //$post=$this->posts_model->where("id=$id")->find();
        $this->assign("teacher",$teacher);
        $this->assign("smeta",json_decode($_POST['smeta'],true));
        $this->assign("school_name",$school_name);
        // $this->assign("term",$term_relationship);
        $this->display();
    }
    
    public function edit_post(){
        if (IS_POST) {
            $where['id']=intval(I("teacher_id"));
            if(empty($_POST['school'])){
                $this->error("请至少选择一个分类栏目！");
            }
            //$post_id=intval($_POST['post']['id']);
            
            //$this->term_relationships_model->where(array("object_id"=>$post_id,"term_id"=>array("not in",implode(",", $_POST['term']))))->delete();
            // foreach ($_POST['term'] as $mterm_id){
            //     $find_term_relationship=$this->term_relationships_model->where(array("object_id"=>$post_id,"term_id"=>$mterm_id))->count();
            //     if(empty($find_term_relationship)){
            //         $this->term_relationships_model->add(array("term_id"=>intval($mterm_id),"object_id"=>$post_id));
            //     }else{
            //         $this->term_relationships_model->where(array("object_id"=>$post_id,"term_id"=>$mterm_id))->save(array("status"=>1));
            //     }
            // }
            
            if(!empty($_POST['photos_alt']) && !empty($_POST['photos_url'])){
                foreach ($_POST['photos_url'] as $key=>$url){
                    $photourl=sp_asset_relative_url($url);
                    $_POST['smeta']['photo'][]=array("url"=>$photourl,"alt"=>$_POST['photos_alt'][$key]);
                }
            }
            $_POST['smeta']['thumb'] = sp_asset_relative_url($_POST['smeta']['thumb']);
            $_POST['post']['post_date']=date("Y-m-d H:i:s",time());
            //unset($_POST['post']['post_author']);
            $teacher=I("post.post");
            //$job['schoolid']=$_POST['school'];
            $teacher['smeta']=json_encode($_POST['smeta']);
            $teacher['post_content']=htmlspecialchars_decode($teacher['post_content']);
            $result=$this->teacher_model->where($where)->save($teacher);
            if ($result!==false) {
                $this->success("保存成功！");
            } else {
                $this->error("保存失败！");
            }
        }
    }
   
//------------------更新校园招聘结束----------------

//------------------删除信息------------------------
    function delete(){
         $id=intval($_GET['id']);
        //var_dump($id);
        if ($id) {
            $rst = $this->teacher_model->where("id=$id")->delete();
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