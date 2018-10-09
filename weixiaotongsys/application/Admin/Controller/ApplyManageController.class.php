<?php

/**
 * 后台首页  日常管理
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class ApplyManageController extends AdminbaseController {


    function _initialize() {
        parent::_initialize();
        $this->school_model = D("Common/School");
        $this->class_model = D("Common/school_class");
        $this->wxtuser_model = D("Common/wxtuser");
        $this->wxt_agent_model=D("Common/agent");
        $this->apply_model=D("Common/apply");
    }

    public function index() {
        
        $this->_getTree();
        $this->_lists();
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
            
            
        $count=$this->apply_model
        ->where($where)
        ->count();
            
        $page = $this->page($count, 20);
            
        $apply=$this->apply_model
        ->field('id,schoolid,classid,name,sex,address,phone,qq,weixin,create_time,post_content,post_status')
        ->where($where)
        ->limit($page->firstRow . ',' . $page->listRows)
        ->order("create_time DESC")->select();



        foreach ($apply as &$apply_class) {
             $classname=$this->class_model
            ->alias("class")
            ->join("wxt_apply apply")
            ->where(array("class.id"=>$apply_class['classid']))
            ->field('classname')
            ->find();

            $apply_class["classname"]=$classname["classname"];
            unset($apply_class);
        }
        // foreach ($mailbox as &$mail_name) {
        //      $username=$this->wxtuser_model
        //     ->alias("user")
        //     ->join("wxt_mailbox mail")
        //     ->where(array("user.id"=>$mail_name['userid']))
        //     ->field('name')
        //     ->find();

        //     $mail_name["user_name"]=$username["name"];
        //     unset($mail_name);
        // }

        $this->assign("Page", $page->show('Admin'));
        $this->assign("current_page",$page->GetCurrentPage());
        unset($_GET[C('VAR_URL_PARAMS')]);
        $this->assign("formget",$_GET);
        $this->assign("apply",$apply);
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