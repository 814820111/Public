<?php

/**
 * 后台首页  日常管理
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class SendMessageController extends AdminbaseController {


    function _initialize() {
        parent::_initialize();
        $this->school_model = D("Common/school");
        $this->wxtuser_model = D("Common/wxtuser");
        $this->class_model = D("Common/school_class");
        $this->wxt_agent_model=D("Common/agent");
        $this->user_message_model=D("Common/user_message");
        $this->user_message_reception_model=D("Common/user_message_reception");
        $this->user_message_pic_model=D("Common/user_message_pic");
    }

    public function index() {
        $this->_lists();
        $this->_getTree();
        $this->display("");
    }
private  function _lists($message_type=1,$send_user_id=0){
       if(!empty($_REQUEST["send_user_id"])){
            $send_user_id=$_REQUEST["send_user_id"];
        }
        //获取到的type值和发送人id
        $where_ands=empty($send_user_id)?array("message_type=$message_type"):array("send_user_id = $send_user_id AND message_type=$message_type");
        $fields=array(
                'start_time'=> array("field"=>"a.message_time","operator"=>">"),
                'end_time'  => array("field"=>"a.message_time","operator"=>"<"),
                // 'reception_user_name'  => array("field"=>"r.reception_user_name","operator"=>"like"),
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
            
        $count=$this->user_message_model
        ->where($where)
        ->count();
            
        $page = $this->page($count, 20);
            
         if(empty($_REQUEST['reception_user_name'])){
            //不限制接收人,获取到的reception_user_name为空
            $where= join(" and ", $where_ands);

            $messages=$this->user_message_model
            ->alias("a")
            ->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)
            ->order("a.message_time ASC")
            ->select();
        }else{
            //如果限制接收人,获取到接收人姓名
            $reception_user_name = $_REQUEST['reception_user_name'];
            //将与获取到的名字相似的接收人姓名存到$where_ands数组中
            array_push($where_ands, "r.receiver_user_name like '%$reception_user_name%'");
            $where= join(" and ", $where_ands);
            $messages=M('user_message')
            ->alias("a")
            ->join("wxt_user_message_reception r ON a.id=r.message_id")//信息表id=接收信息人表message_id
            ->where($where)
            ->field('a.id,a.schoolid,a.send_user_id,a.send_user_name,a.message_content,a.message_time')
            ->limit($page->firstRow . ',' . $page->listRows)
            ->order("a.message_time ASC")
            ->select();
        }
        //获取接收人列表
        foreach ($messages as &$messageinfo) {
             $receiver=M('user_message')
            ->alias("m")
            ->join("wxt_user_message_reception r ON m.id=r.message_id")
            ->where(array("r.message_id"=>$messageinfo['id']))
            ->field('receiver_user_id,receiver_user_name,read_time')
            ->select();
            $messageinfo["receiver"]=$receiver;
            //赋值接收人数量
            $messageinfo["receiver_num"] = count($receiver);
            unset($messageinfo);
        }
        
        //获取图片列表
        foreach ($messages as &$messageinfo) {
             $picture=M('user_message')
            ->alias("m")
            ->join("wxt_user_message_pic p ON m.id=p.message_id")
            ->where(array("p.message_id"=>$messageinfo['id']))
            ->field('picture_url')
            ->select();
            $messageinfo["picture"]=$picture;
            unset($messageinfo);
        }
        //获取学校列表
        foreach ($messages as &$school) {
            $schoolname=$this->school_model
            ->where(array("schoolid"=>$school['schoolid']))
            ->field('school_name')
            ->find();
            $school["schoolname"]=$schoolname["school_name"];
            unset($school);
        }
        $this->assign("Page", $page->show('Admin'));
        $this->assign("current_page",$page->GetCurrentPage());
        unset($_GET[C('VAR_URL_PARAMS')]);
        $this->assign("formget",$_GET);
        $this->assign("messages",$messages);
    }

//------------------删除信息------------------------
    function delete(){
         $id=intval($_GET['id']);
        //var_dump($id);
        if ($id) {
            $rst = $this->user_message_model->where("id=$id")->delete();
            $ret = $this->user_message_pic_model->where("message_id=$id")->delete();
            $rut = $this->user_message_reception_model->where("message_id=$id")->delete();
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
//-------------------接收人列表展示--------------
    public function receive(){
        $id = intval($_GET['id']);   
        if ($id) {
            $receiver=M('user_message')
            ->alias("m")
            ->join("wxt_user_message_reception r ON m.id=r.message_id")
            ->where(array("r.message_id"=>$id))
            ->field('receiver_user_id,receiver_user_name,read_time')
            ->select();
            $this->assign("id",$id);
            $this->assign("receive",$receiver);
            $this->display("");
            
        } else {
            $this->error('数据传入失败！');
        }
    }
//-------------------接收人列表展示结束--------------
    function receive_delete(){
         $id=$_GET['id'];
        //var_dump($id);
        if ($id) {
            $rst = $this->user_message_reception_model->where("id=$id")->delete();
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