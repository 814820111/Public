<?php

/**
 * 后台首页  代理商管理
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class AgentManageController extends AdminbaseController {


    function _initialize() {
        parent::_initialize();
        $this->agent_model = D("Common/Agent");
        $this->wxtuser_model = D("Common/wxtuser");
    }
    //代理商管理首页
    public function index() {
        //查询结果分页
        $count=$this->agent_model
        ->alias('a')
        ->join("".C('DB_PREFIX')."city c ON a.city=c.term_id")
        ->where("a.status =1 or 0 or 2")
        ->count();
        $page = $this->page($count, 20);
        $agent = $this->agent_model
            ->alias('a')
            ->join("".C('DB_PREFIX')."city c ON a.city=c.term_id")
            ->field("a.*,c.name as cityname")
            ->order("a.time DESC")
            ->where("a.status =1 or 0 or 2")
            ->order("a.status DESC ,a.create_time DESC")
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();
//获取负责人的名字
        for ($i=0;$i<count($agent);$i++){
            $parent = $agent[$i]["parent"];
            if ($parent == 0){
                $agent[$i]["parents"] = "管理员";
            }else{
                $paernt_info = M("agent")->where(array("id"=>$parent))->find();
                $agent[$i]["parents"] = $paernt_info["name"];
            }
        }
//        echo "<pre>";
//        var_dump($agent);die();
        $this->assign("page", $page->show('Admin'));
        $this->assign("agent",$agent);
        $this->display("agentmanage");
    }
    function add(){
        $tree  = M("agent")->where(array("parent"=>0))->select();
        $this->assign("tree",$tree);

		$this->display();
	}
    function getCity(){
        $city = M("city")->where(array("parent"=>0))->select();
        $ret = $this->format_ret(1,$city);
        echo json_encode($ret);

    }
    function getPri(){
        $term_id = I("term_id");
        $res = M("city")->where(array("parent"=>$term_id))->select();
        $ret = $this->format_ret(1,$res);
        echo json_encode($ret);
    }
    function format_ret ($status, $data='') {
    if ($status){
        //成功
        return array('status'=>'success', 'data'=>$data);
    }else{
        //验证失败
        return array('status'=>'error', 'data'=>$data);
    }
}
	function add_post(){
        //var_dump($_POST);die();
		if(IS_POST){
			if ($this->agent_model->create()){
				if ($this->agent_model->add()!==false) {
					$this->success("添加成功！", U("index"));
				} else {
					$this->error("添加失败！");
				}
			} else {
				$this->error($this->agent_model->getError());
			}
		
		}
	}
    public function edit(){
        $id=I("get.id");
        if ($id) {
            $rst = $this->agent_model->where(array("id"=>$id))->find();
            if ($rst) {
                $this->assign("agent",$rst);
                $this->display();
            } else {
                $this->error('代理商数据获取失败，请重试！');
            }
        } else {
            $this->error('数据传入失败！');
        }
    }
    function edit_post(){
		if (IS_POST) {
			if ($this->agent_model->create()) {
				if ($this->agent_model->save()!==false) {
					$this->success("保存成功！", U("AgentManage/index"));
				} else {
					$this->error("保存失败！");
				}
			} else {
				$this->error($this->agent_model->getError());
			}
		}
	}
        public function schoolmanage(){
        //代理管理
 		$count=$this->agent_model->where("status =1 or 0 or 2")->count();
        $page = $this->page($count, 20);
        $agent = $this->agent_model
            ->where("status =1 or 0 or 2")
            ->order("status DESC ,create_time DESC")
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();
        $this->assign("page", $page->show('Admin'));
        $this->assign("agent",$agent);
        $this->display("agentmanage");
    }
}

