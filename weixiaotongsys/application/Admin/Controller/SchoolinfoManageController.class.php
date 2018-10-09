<?php

/**
 * 后台首页  学校信息管理
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class SchoolinfoManageController extends AdminbaseController {


    function _initialize() {
        parent::_initialize();
        $this->school_model = D("Common/School");
        $this->class_model = D("Common/school_class");
        $this->wxtuser_model = D("Common/wxtuser");
    }
    //学校信息管理首页
    public function index(){
        //查询结果分页
        $count=$this->school_model->where("school_status =1 or 0 or 2")->count();
        $page = $this->page($count, 20);
        $schoollist = $this->school_model
            ->alias("s")
            ->join("wxt_agent a ON s.agent_id=a.id")
            ->field("s.*,a.name as agent_name")
            ->where("s.school_status =1 or 0 or 2")
            ->order("s.school_status DESC ,s.create_time DESC")
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();

        $this->assign("page", $page->show('Admin'));
        $this->assign("school",$schoollist);        
        $this->display("index");
    }
    public function edit(){
        $id=I("get.id");
        if ($id) {
            $rst = $this->school_model->where(array("id"=>$id))->find();
            if ($rst) {
                $this->assign("school",$rst);
                $this->display();
            } else {
                $this->error('学校数据获取失败，请重试！');
            }
        } else {
            $this->error('数据传入失败！');
        }
    }
    function edit_post(){
        if (IS_POST) {
            if ($this->school_model->create()) {
                if ($this->school_model->save()!==false) {
                    $this->success("保存成功！", U("index"));
                } else {
                    $this->error("保存失败！");
                }
            } else {
                $this->error($this->school_model->getError());
            }
        }
    }
    //信息登记
    public function add(){
        $this->display("add");
    }
    public function pic_update(){

    }
    public function infoRegister_post(){
        $this->error('信息登记功能暂未开放！');
    }
    //班级信息管理首页
    public function classlist(){
        //查询结果分页
        $schoolid= I("schoolid");
        $count=$this->class_model->where(array("schoolid"=>$schoolid))->count();
        $page = $this->page($count, 20);
        $list = $this->class_model
            ->alias("c")
            ->where("c.schoolid =$schoolid")
            ->order("c.id DESC")
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();

            // ->join("wxt_agent a ON s.agent_id=a.id")
            // ->field("s.*,a.name as agent_name")
        $this->assign("page", $page->show('Admin'));
        $this->assign("class",$list);        
        $this->display("classlist");
    }
    //学校划拨
    public function schooltransfer(){
        echo "学校划拨给代理商（涉及到费用问题）";
    }
}

