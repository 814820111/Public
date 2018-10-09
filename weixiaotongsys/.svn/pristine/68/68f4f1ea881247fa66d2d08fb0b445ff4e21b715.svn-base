<?php

/**
 * 后台首页
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
class OtherManageController extends TeacherbaseController {
	  function _initialize() {
        parent::_initialize();

    }
	
    //校园招聘
	public function JobManage()
    {

        $schoolid = $_SESSION["schoolid"];
        if($schoolid)
        {
            $where["schoolid"]=$schoolid;
        }
        $name = I("name"); //职位名称
        if($name)
        {
            $where["name"]=array("like","%".$name."%");;
            $this->assign("name",$name);
        }

        $status = I("status"); //状态
        if($status)
        {
            $where["status"]=$status;
            $this->assign("status",$status);
        }



        $count = M("jobmanage")->where($where)->order("id desc")->count();
        $page = $this->page($count,20);
        $jobmanage = M("jobmanage")->where($where)->limit($page->firstRow . ',' . $page->listRows)->order("id desc")->select();
        foreach ($jobmanage as &$value)
        {
            $id= $value["id"];
            $result = M("jobmanage_enroll")->where(array("job_id"=>$id))->count();
            $value["count"] = $result;

        }
       // dump($jobmanage);
        $this->assign("Page", $page->show('Admin'));
        $this->assign("jobmanage",$jobmanage);
        $this->display("JobManage");
    }

    //校园招聘修改
    public function JobManage_edit()
    {
        $schoolid = $_SESSION["schoolid"];
        $id=intval($_GET['id']);
        $this->assign("id",$id);
        $jobmanage = M("jobmanage")->where(array("Id"=>$id))->order("id desc")->find();
//        dump($jobmanage);
        $this->assign("jobmanage",$jobmanage);
        $this->display("JobManage_edit");

    }

    //修改提交
    public function  edit_post()
    {
        $data = M("jobmanage")->create();
//        dump($data);
//        die();
        $id = I("id");
        if($data){
//            $desc = trim($data["desc"]);
//            $data["desc"] = $desc;
            $data['desc'] =  htmlspecialchars_decode($data['desc']);

            $contact_way = trim($data["contact_way"]);
            $data["contact_way"] = $contact_way;
            $result = M("jobmanage")->where(array("Id"=>$id))->save($data); // 写入数据到数据库
            if($result){
                $this->success("修改成功",U("JobManage"));
            }else{
                $this->error("修改失败!");
            }
        }else{
            $this->error("表单验证失败!");
        }

    }


    //校园招聘_添加
    public function JobManage_add()
    {
        $this->display("JobManage_add");
    }

    public function add_post()
    {
        $data = M("jobmanage")->create();
        //dump($data);
        //die();
        if($data){
            $data['schoolid'] = $_SESSION['schoolid'];
            $data['create_time'] = time();
            $data['create_date'] = date('Y-m-d h:i:s', time());
            $data['desc'] =  htmlspecialchars_decode($data['desc']);
            $result = M("jobmanage")->add($data); // 写入数据到数据库
            if($result){
                $this->success("新增成功！",U("JobManage"));
            }else{
                $this->error("新增失败！");
            }
        }else{
            $this->error("表单验证失败！");
        }
    }

    function Job_delete(){
        $id=intval($_GET['id']);
        if ($id) {
            $rst = M("jobmanage")->where("id=$id")->delete();
            if ($rst) {
                M("jobmanage_enroll")->where("job_id=$id")->delete();
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            }
        } else {
            $this->error('数据传入失败！');
        }
        //$this->error('该功能暂时未开通！');
    }

    //查看招聘情况
    public function jobmanage_enroll_list()
    {
        $schoolid = $_SESSION["schoolid"];
        $list = M("jobmanage")->where(array("schoolid"=>$schoolid))->select();
//        dump($online);
        $this->assign("list",$list);

        if($schoolid){
            $where["b.schoolid"] =$schoolid;
        }
        $id =I("job_id"); //招聘的职位ID
        if($id){
            $where["a.job_id"] = $id;
            $this->assign("job_id",$id);
        }

        $state =I("state"); //状态
        if($state){
            $where["a.state"] = $state;
            $this->assign("state",$state);
        }


//        $result = M("jobmanage_enroll")->where(array("job_id"=>$id))->select();
        $count = M("jobmanage_enroll as a")->
        join("wxt_jobmanage as b on a.job_id=b.id")->where($where)->field("a.*,b.name as jobname")->count();
        $page = $this->page($count,20);
        $result = M("jobmanage_enroll as a")->

        join("wxt_jobmanage as b on a.job_id=b.id")->where($where)->field("a.*,b.name as jobname")->limit($page->firstRow . ',' . $page->listRows)->select();
        $this->assign("Page", $page->show('Admin'));
        $this->assign("jobmanage",$result);
        $this->display("enroll_list");
    }

    //修改应聘人的状态
    public function edit_enroll_state()
    {
        $id = I("id");
        $state = I("state");

        if($id and $state){
            if($state==1)
            {
                $result = M("jobmanage_enroll")->where(array("id"=>$id))->save(array("state"=>2)); // 写入数据到数据库
            }
            if($state==2)
            {
                $result = M("jobmanage_enroll")->where(array("id"=>$id))->save(array("state"=>1)); // 写入数据到数据库
            }

            if($result){
                $this->success("修改成功",U("jobmanage_enroll_list"));
            }else{
                $this->error("修改失败!");
            }
        }else{
            $this->error("缺少参数!");
        }


    }

    public function enroll_list_delete(){
        $id=intval($_GET['id']);
        if ($id) {
            $rst = M("jobmanage_enroll")->where("id=$id")->delete();
            if ($rst) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            }
        } else {
            $this->error('数据传入失败！');
        }
    }
    //在线报名
    public function Online_enroll()
    {

        $schoolid = $_SESSION["schoolid"];
        if($schoolid)
        {
            $where["schoolid"]=$schoolid;
        }
        $title = I("title"); //标题
        if($title)
        {
            $where["title"]=array("like","%".$title."%");;
            $this->assign("title",$title);
        }

        $status = I("status"); //状态
        if($status)
        {
            $where["status"]=$status;
            $this->assign("status",$status);
        }
//        dump($where);

        $count = M("online_enroll")->where($where)->order("id desc")->count();
        $page = $this->page($count,20);
        $enroll = M("online_enroll")->where($where)->limit($page->firstRow . ',' . $page->listRows)->order("id desc")->select();
        $this->assign("Page", $page->show('Admin'));
        $this->assign("enroll",$enroll);
        $this->display("Online_enroll");
    }
    //在线报名详情
    public function Online_enroll_list()
    {
        $schoolid = $_SESSION["schoolid"];
        $online = M("online_enroll")->where(array("schoolid"=>$schoolid))->select();
//        dump($online);
        $this->assign("online",$online);
        if($schoolid)
        {
            $where["a.schoolid"]=$schoolid;
        }

        $online_id = I("online_id");
        if($online_id){
            $where["a.online_id"] = $online_id;
            $this->assign("online_id",$online_id);
        }
       // dump($where);
        $count = M("online_enroll_list as a")->join("left join wxt_online_enroll as b on a.online_id=b.Id")->where($where)->field("a.*,b.title")->order("b.id desc")->count();
        $page = $this->page($count,20);
        $enroll = M("online_enroll_list as a")->join("left join 
        wxt_online_enroll as b on a.online_id=b.Id")->where($where)->limit($page->firstRow . ',' . $page->listRows)->field("a.*,b.title")->order("b.id desc")->select();

        $this->assign("Page", $page->show('Admin'));
        $this->assign("enroll",$enroll);
        $this->display("Online_enroll_list");
    }

    //添加报名
    public function add_enroll()
    {
        $this->display("add_enroll");
    }

    //添加报名提交
    public function add_enroll_post()
    {
        $data = M("online_enroll")->create();
//        dump($data);
//        die();
        if($data){
            $data['schoolid'] = $_SESSION['schoolid'];
            $data['create_time'] = date('Y-m-d h:i:s', time());
            $data['create_time_int'] =  time();
            $data['content'] =  htmlspecialchars_decode($data['content']);
            $result = M("online_enroll")->add($data); // 写入数据到数据库
            if($result){
                $this->success("新增成功！",U("Online_enroll"));
            }else{
                $this->error("新增失败！");
            }
        }else{
            $this->error("表单验证失败！");
        }
    }

    //报名修改
    public function edit_enroll()
    {
        $id=I("id");
        if ($id){
            $enroll = M("online_enroll")->where(array("Id"=>$id))->find();
            $this->assign("enroll",$enroll);
        }

        $this->display();
    }
    //修改提交
    public function  edit_enroll_post()
    {
        $schoolid = $_SESSION["schoolid"];
        $data = M("online_enroll")->create();
//        dump($data);
//        die();

        if($data){
//            if($data["status"]==1)
//            {
//                $count = M("online_enroll")->where(array("schoolid"=>$schoolid,"status"=>1))->count();
//                if($count>=1){
//                    $this->error("只允许一个在线报名,请先把其他报名下线,在进行修改!");
//                    return;
//                }
//
//            }
            $data['content'] =  htmlspecialchars_decode($data['content']);
            $result = M("online_enroll")->save($data); // 写入数据到数据库
            if($result){
                $this->success("修改成功",U("Online_enroll"));
            }else{
                $this->success("修改失败!");
            }
        }else{
            $this->error("表单验证失败!");
        }

    }

    //报名删除
    function delete(){
        $id=intval($_GET['id']);
        if ($id) {
            $rst = M("online_enroll")->where("id=$id")->delete();
            if ($rst) {
                M("online_enroll_list")->where("online_id=$id")->delete();
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            }
        } else {
            $this->error('数据传入失败！');
        }
        //$this->error('该功能暂时未开通！');
    }
    //报名详情删除
    function list_delete(){
        $id=intval($_GET['id']);
        if ($id) {
            $rst = M("online_enroll_list")->where("id=$id")->delete();
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
    //信箱
    public function mailbox()
    {


        $schoolid = $_SESSION["schoolid"];

        $count = M("mailboxs as a")->join("left join wxt_wxtuser  b on a.userid=b.id")->where(array("a.schoolid"=>$schoolid))->field("a.*,b.name")->order("a.id desc")->count();
        $page = $this->page($count,20);
        $mailbox = M("mailboxs as a")->join("left join wxt_wxtuser  b on a.userid=b.id")->where(array("a.schoolid"=>$schoolid))->limit($page->firstRow . ',' . $page->listRows)->field("a.*,b.name")->order("a.id desc")->select();
//        dump($mailbox);
        $this->assign("Page", $page->show('Admin'));
        $this->assign("mailbox",$mailbox);
        $this->display("mailbox");
    }

    //信箱删除
    function m_delete(){
        $id=intval($_GET['id']);
        //var_dump($id);
        if ($id) {
            $rst = M("mailboxs")->where("id=$id")->delete();
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

    //参数获取(状态，原因)
    function format_ret ($status, $data='') {
        if ($status){   
        //成功
            return array('status'=>'success', 'data'=>$data);
        }else{  
            //验证失败
            return array('status'=>'error', 'data'=>$data);
        }
    }
}