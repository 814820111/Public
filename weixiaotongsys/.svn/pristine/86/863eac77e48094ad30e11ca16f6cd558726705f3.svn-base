<?php
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class FunctionalModuleController extends AdminbaseController{
	protected $ad_model;
	
	function _initialize() {
		parent::_initialize();
		$this->growth_module = D("Common/growth_module");
	}
	
    //功能模块
    public function index()
    {
        $infos = $this->growth_module->select();

        $this->assign('info', $infos);
        $this->display();
    }
    public function add()
    {
        if (IS_POST){
            $arr = array(
                'name'=>I('name'),
                'sort'=>I('sort'),
                'is_lock'=>I('lock')
            );
            $insert = $this->growth_module->add($arr);
            if ($insert){
                $this->success('添加成功', U('index'));
            }
            exit();
        }
        $this->display();
    }
}