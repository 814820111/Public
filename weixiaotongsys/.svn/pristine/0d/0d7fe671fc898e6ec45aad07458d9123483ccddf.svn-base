<?php

/**
 * 后台首页  代理商管理
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class SchoolTermController extends AdminbaseController {

    protected $term_model;
    function _initialize() {
        parent::_initialize();
        $this->term_model = M("School_term");
    }
    //代理商管理首页
    public function index() {
       $this->assign("term",$this->term_model->select());
       $this->display();
    }

    function add(){
		$this->display();
	}
	
	function add_post(){
		if(IS_POST){
		    $data = $this->term_model->create();
			if ($data){
                $data['start_date'] = strtotime($_POST["start_date"]);
                $data['end_date'] = strtotime($_POST["end_date"]);
				if ($this->term_model->add($data)!==false) {
					$this->success("添加成功！", U("index"));
				} else {
					$this->error("添加失败！".$this->term_model->getError());
				}
			} else {
				$this->error($this->term_model->getError());
			}
		
		}
	}

	public function change(){
        $id=intval($_GET['id']);
        $term= $this->term_model->where("id=$id")->find();
        $this->assign("term",$term);
	    $this->display("change");
    }

    public function change_post(){
        if(IS_POST){
            $data = $this->term_model->create();
            if ($data){
                $data['start_date'] = strtotime($_POST["start_date"]);
                $data['end_date'] = strtotime($_POST["end_date"]);
                if ($this->term_model->save($data)!==false) {
                    $this->success("更新成功！", U("index"));
                } else {
                    $this->error("更新失败！");
                }
            } else {
                $this->error($this->term_model->getError());
            }

        }

    }

    public function delete(){
        $id=intval($_GET['id']);
        if ($this->term_model->where("id=$id")->delete()){
            $this->success("删除成功！", U("index"));
        }else{
            $this->error($this->grade_model->getError());
        }

    }

}

