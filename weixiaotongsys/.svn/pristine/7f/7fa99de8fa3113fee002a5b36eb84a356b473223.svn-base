<?php

/**
 * 后台首页  代理商管理
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class GradeManageController extends AdminbaseController {


    function _initialize() {
        parent::_initialize();
        $this->grade_model = D("Common/gradedictionary");
        $this->school_grade_model = D("Common/schoolgradetype");
    }
    //代理商管理首页
    public function index() {
        //查询结果分页
        $count=$this->grade_model
        ->count();
        $page = $this->page($count, 20);
        $agent = $this->grade_model
            ->alias("a")
            ->join("".C('DB_PREFIX').'schoolgradetype c ON a.schooltype=c.id')
            ->field("c.name as schooltype_name,a.id,a.name")
            ->order("a.schooltype DESC")
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();
        $this->assign("page", $page->show('Admin'));
        $this->assign("agent",$agent);
        $this->display("");
    }

    function add(){
        $schooltype = $this->school_grade_model->select();
        $this->assign("schooltype",$schooltype);
		$this->display();
	}
	
	function add_post(){
		if(IS_POST){
			if ($this->grade_model->create()){
                $this->grade_model->create_time = time();
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

	public function change(){
        $id=intval($_GET['id']);
        $schooltype = $this->school_grade_model->select();
        $gradle = $this->grade_model->where("id=$id")->find();
        $this->assign("gradle",$gradle);
        $this->assign("schooltype",$schooltype);
	    $this->display("change");
    }

    public function change_post(){
        if(IS_POST){
            if ($this->grade_model->create()){
                $this->grade_model->create_time = time();
                if ($this->grade_model->save()) {
                    $this->success("修改成功！", U("index"));
                } else {
                    $this->error("修改失败！");
                }
            } else {
                $this->error($this->grade_model->getError());
            }

        }

    }

    public function delete(){
        $id=intval($_GET['id']);
        if ($this->grade_model->where("id=$id")->delete()){
            $this->success("删除成功！", U("index"));
        }else{
            $this->error($this->grade_model->getError());
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
}

