<?php

/**
 * 后台首页  代理商管理
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class SchoolYearManageController extends AdminbaseController {


    function _initialize() {
        parent::_initialize();
        $this->grade_model = D("Common/schoolgradetype");
    }
    //代理商管理首页
    public function index() {
        //查询结果分页
        $count=$this->grade_model
        ->count();
        $page = $this->page($count, 20);
        $agent = $this->grade_model
            ->alias("a")
            ->field("a.id,a.name")
            ->order("a.id DESC")
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();
        $this->assign("page", $page->show('Admin'));
        $this->assign("agent",$agent);
        $this->display("");
    }
    function add(){
		$this->display();
	}
	
	function add_post(){
		if(IS_POST){
			if ($this->grade_model->create()){
				if ($this->grade_model->add()!==false) {
					$this->success("添加成功！", U("index"));
				} else {
					$this->error("添加失败！");
				}
			} else {
				$this->error($this->grade_model->getError());
			}
		
		}
	}
    public function edit(){
        $id=I("get.id");
        if ($id) {
            $rst = $this->grade_model->where(array("id"=>$id))->find();
            if ($rst) {
                $this->assign("agent",$rst);
                $this->display();
            } else {
                $this->error('数据获取失败，请重试！');
            }
        } else {
            $this->error('数据传入失败！');
        }
    }
    function edit_post(){
		if (IS_POST) {
			if ($this->grade_model->create()) {
				if ($this->grade_model->save()!==false) {
					$this->success("保存成功！", U("AgentManage/index"));
				} else {
					$this->error("保存失败！");
				}
			} else {
				$this->error($this->agent_model->getError());
			}
		}
	}



    //--------------------学校年段管理----------------------
    public  function  gradleManage(){
        $class=M("schoolgradetype")->select();
        $this->assign("class",$class);
        $this->display("schoolgradlemanage");

    }

    //修改时获取当前年级段信息
    public function change_gradle(){
        $class=D("Common/schoolgradetype");
        $gradleid = intval($_GET['id']);
        if ($gradleid) {
            $rst = $class->where(array("id"=>$gradleid))->find();
            if ($rst) {
                $this->assign("gradle",$rst);
                $this->display("changeGradle");
            } else {
                $this->error('数据获取失败，请重试！');
            }
        } else {
            $this->error('数据传入失败！');
        }
    }

    //修改年级段
    public function save_gradle_msg()
    {
        if (IS_POST) {
            $class=D("Common/schoolgradetype");
            $get_gradle_id = $_POST['gradle_id'];
            $get_gradle_name = $_POST['gradle_name'];
            if (!empty($get_gradle_id)&&!empty($get_gradle_name)){
                $data['id']=$_POST['gradle_id'];
                $data['name']=$_POST['gradle_name'];
                $data['create_time'] = time();
                if($class->save($data)){
                    $this->success("保存成功！",U('gradleManage'));
                } else{
                    $this->error("保存失败！");
                }
            }else{
                $this->error("数据传输字段错误！");
            }
        }else {
            $this->error("数据传输错误！");
        }

    }

    public function addGradle(){
        $this->display("addGradle");

    }

    //新增年级段
    public function add_gradle(){
        if (IS_POST){
            if (!empty($_POST['gradle_name'])){
                $class=D("Common/schoolgradetype");
                $data['name'] =  $_POST['gradle_name'];
                $data['create_time'] = time();
                if ($class->add($data)){
                    $this->success("新增成功！",U('gradleManage'));
                } else{
                    $this->error("新增失败！");
                }

            }

        }

    }

    //删除年级段
    public function delete_gradle(){
        $class=D("Common/schoolgradetype");
        $gradleid = intval($_GET['id']);
        if ($gradleid) {
            $rst = $class->where(array("id"=>$gradleid))->delete();
            if ($rst) {
                $this->success("删除成功！",U('gradleManage'));
            } else {
                $this->error('删除失败，请重试！');
            }
        } else {
            $this->error('数据传入失败！');
        }
    }
}

