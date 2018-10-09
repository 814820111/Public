<?php
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class AgreementController extends AdminbaseController{
	protected $ad_model;
	
	function _initialize() {
		parent::_initialize();
		$this->ad_model = M("Deviceagreement");
	}
	
	function index(){
		$ads=$this->ad_model->select();
		$this->assign("ads",$ads);
		$this->display();
	}
	
	function add(){
		$this->display();
	}
	
	function add_post(){
		if(IS_POST){
			if ($this->ad_model->create()){
				if ($this->ad_model->add()!==false) {
					$this->success('添加成功', U("agreement/index"));
				} else {
					$this->error('添加失败');
				}
			} else {
				$this->error($this->ad_model->getError());
			}
		
		}
	}
	
	function edit(){
		$id=I("get.id");
		$ad=$this->ad_model->where("id=$id")->find();
		$this->assign($ad);
		$this->display();
	}
	
	function edit_post(){
		if (IS_POST) {
			if ($this->ad_model->create()) {
				if ($this->ad_model->save()!==false) {
					$this->success("保存成功！", U("agreement/index"));
				} else {
					$this->error("保存失败！");
				}
			} else {
				$this->error($this->ad_model->getError());
			}
		}
	}
	
	/**
	 *  删除
	 */
	function delete(){
		$id = I("get.id",0,"intval");
		if ($this->ad_model->delete($id)!==false) {
			$this->success("删除成功！");
		} else {
			$this->error("删除失败！");
		}
	}
	
}