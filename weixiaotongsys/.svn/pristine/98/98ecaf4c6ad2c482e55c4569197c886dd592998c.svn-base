<?php

/**
 * 后台首页  日常管理
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class DeliveryVerifyController extends AdminbaseController {


    function _initialize() {
        parent::_initialize();
        $this->school_model = D("Common/School");
        $this->wxtuser_model = D("Common/wxtuser");
        $this->class_model = D("Common/school_class");
        $this->wxt_agent_model=D("Common/agent");
        $this->delivery_model=D("Common/student_delivery");
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
            
        $count=$this->delivery_model
        ->where($where)
        ->count();
            
        $page = $this->page($count, 20);
            
        $posts=$this->delivery_model
        ->field('delivery_id,schoolid,teacherid,photo,delivery_time,delivery_status,parentid,parenttime')
        ->where($where)
        ->limit($page->firstRow . ',' . $page->listRows)
        ->order("delivery_id DESC")->select();

        // foreach ($posts as &$name) {
        //      $schoolname=$this->school_model
        //     ->alias("school")
        //     ->join("wxt_microblog_main pic")
        //     ->where(array("school.schoolid"=>$name['schoolid']))
        //     ->field('school_name')
        //     ->find();
        //     $name["schoolname"]=$schoolname["school_name"];
        //     unset($name);
        // }
         foreach ($posts as &$school) {
             $schoolname=$this->school_model
            ->where(array("schoolid"=>$school['schoolid']))
            ->field('school_name')
            ->find();

            $school["schoolname"]=$schoolname["school_name"];
            unset($school);
        }
        foreach ($posts as &$user) {
             $username=$this->wxtuser_model
            ->where(array("id"=>$user['userid']))
            ->field('name')
            ->find();

            $user["username"]=$username["name"];
            unset($user);
        }
         foreach ($posts as &$teacher) {
             $teacherinfo=$this->wxtuser_model
            ->where(array("id"=>$teacher['teacherid']))
            ->field('name,phone')
            ->find();

            $teacher["teacher_name"]=$teacherinfo["name"];
            $teacher["teacher_phone"]=$teacherinfo["phone"];
            unset($teacher);
        }
         foreach ($posts as &$parent) {
             $parentinfo=$this->wxtuser_model
            ->where(array("id"=>$parent['parentid']))
            ->field('name,phone')
            ->find();
            $parent["parent_name"]=$parentinfo["name"];
            $parent["parent_phone"]=$parentinfo["phone"];
            unset($parent);
        }
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
            $rst = $this->delivery_model->where("delivery_id=$id")->delete();
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