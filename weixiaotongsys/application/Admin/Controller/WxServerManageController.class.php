<?php
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class WxServerManageController extends AdminbaseController{
	

	function index(){

	    $wx = M('wxserver')
            ->alias('w')
            ->order('w.id desc')
            ->select();
	    //dump($wx);
	    $this->assign('wx', $wx);
		$this->display();
	}
	
	function add(){
		$this->display();
	}
	
	function add_post(){
		if(IS_POST){
			if (M('wxserver')->create()){
				if (M('wxserver')->add()!==false) {
					$this->success("添加成功！", U("index"));
				} else {
					$this->error("添加失败！");
				}
			} else {
				$this->error(M('wxmanage')->getError());
			}
		
		}
	}
	
	function edit(){
		$id=I("get.id");
        $wx = M('wxserver')
            ->where("id = $id")
            ->find();
        //dump($wx);
		$this->assign('wx',$wx);
		$this->display();
	}
	
	function edit_post(){
		if (IS_POST) {
			if (M('wxserver')->create()) {
				if (M('wxserver')->save()!==false) {
					$this->success("保存成功！", U("index"));
				} else {
					$this->error("保存失败！");
				}
			} else {
				$this->error(M('wxserver')->getError());
			}
		}
	}
	
	/**
	 *  删除
	 */
	function delete(){
		$id = I("get.id",0,"intval");
		if (M('wxserver')->delete($id)!==false) {
			$this->success("删除成功！");
		} else {
			$this->error("删除失败！");
		}
	}
}