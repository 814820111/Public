<?php

/**
 * 后台首页  日常管理
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class TeacherCommentController extends AdminbaseController {


    function _initialize() {
        parent::_initialize();
        $this->school_model = D("Common/School");
        $this->class_model = D("Common/school_class");
        $this->wxtuser_model = D("Common/wxtuser");
        $this->wxt_agent_model=D("Common/agent");
        $this->comment_model=D("Common/teacher_comment");
    }

    public function index() {
        $this->_lists();
        $this->_getTree();
        $this->display("");
    }
private  function _lists($status=1){
        $school_id=0;
        if(!empty($_REQUEST["school"])){
            $school_id=intval($_REQUEST["school"]);
            //$this->assign("school_id",$school_id);
            //$_GET['school_id']=$school_id;
        }
        
        $where_ands=empty($school_id)?array(""):array("schoolid = $school_id");
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
        
        $where= join(" ", $where_ands);
            
        $count=$this->comment_model
        ->where($where)
        ->count();
            
        $page = $this->page($count, 20);
            
        $posts=$this->comment_model
        ->field('comment_id,teacher_id,studentid,comment_time,comment_status,learn,work,sing,labour,strain,comment_content')
        ->where($where)
        ->limit($page->firstRow . ',' . $page->listRows)
        ->order("comment_time DESC")->select();



        foreach ($posts as &$teacherinfo) {
             $teacherlist=$this->wxtuser_model
            ->where(array("id"=>$teacherinfo['teacherid']))
            ->field('name')
            ->find();

            $teacherinfo["teacher_name"]=$teacherlist["name"];
            unset($teacherinfo);
        }
        foreach ($posts as &$studentinfo) {
             $studentlist=$this->wxtuser_model
            ->where(array("id"=>$studentinfo['studentid']))
            ->field('name')
            ->find();

            $studentinfo["student_name"]=$studentlist["name"];
            unset($studentinfo);
        }

        $this->assign("Page", $page->show('Admin'));
        $this->assign("current_page",$page->GetCurrentPage());
        unset($_GET[C('VAR_URL_PARAMS')]);
        $this->assign("formget",$_GET);
//        $this->assign("school_name",$school_name);
        $this->assign("posts",$posts);
    }
//------------------增加周计划----------------
  function add(){
        $school_name = $this->school_model->order(array("schoolid"=>"asc"))->select();
        $class_name = $this->class_model->order(array("id"=>"asc"))->select();
        $schoolid = intval(I("get.school"));
        $this->_getTree();
        $plan=$this->plan_model->where("schoolid=$schoolid")->find();
        $this->assign("author","1");
        $this->assign("plan",$plan);
        $this->assign("school_name",$school_name);
        $this->assign("class_name",$class_name);
        $this->display();
    }
    
    function add_post(){
        if (IS_POST) {
            if(empty($_POST['school'])){
                $this->error("请至少选择一个学校！");
            }
            $job=I("post.post");
            $data['schoolid']=$_POST['school'];
            $data['title']=$_POST['title'];
            $data['content']=htmlspecialchars_decode($job['post_content']);
            $data['school_phone']=$this->school_model->where(array("schoolid"=>$_POST['school']))->field('school_phone')->find();
            $data['create_time']=time();
            //die($_POST['school']);
            $result=$this->plan_model->add($data);
            if ($result) {
                $this->success("添加成功");
            } else {
                $this->error("添加失败！");
            }
             
        }
    }
//------------------增加周计划结束----------------

//------------------更新周计划开始----------------
    public function edit(){
        $id=  intval(I("id"));
        $schoolid = intval(I("get.school"));
        $this->_getTree();
        $school_name = $this->school_model->order(array("schoolid"=>"asc"))->select();
        $class_name = $this->class_model->order(array("id"=>"asc"))->select();
        $plan = $this->plan_model->where(array("id"=>$id))->find();
        $this->assign("plan",$plan);
        $this->assign("smeta",json_decode($_POST['smeta'],true));
        $this->assign("school_name",$school_name);
        $this->assign("class_name",$class_name);
        $this->display();
    }
    
    public function edit_post(){
        if (IS_POST) {
            $where['id']=intval(I("plan_id"));
            if(empty($_POST['school'])){
                $this->error("请至少选择一个分类栏目！");
            }
            $remeber=I("post.post");
            $data['schoolid']=$_POST['school'];
            $data['title']=$_POST['title'];
            $data['content']=htmlspecialchars_decode($remeber['post_content']);
            $data['school_phone']=$this->school_model->where(array("schoolid"=>$_POST['school']))->field('school_phone')->find();
            $data['create_time']=time();
            $result=$this->plan_model->where($where)->save($data);
            if ($result!==false) {
                $this->success("保存成功！");
            } else {
                $this->error("保存失败！");
            }
        }
    }
   
//------------------更新周计划结束----------------

//------------------删除信息------------------------
    function delete(){
        $id=intval($_GET['id']);
        if ($id) {
            $rst = $this->comment_model->where("comment_id=$id")->delete();
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