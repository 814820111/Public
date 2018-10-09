<?php

/**
 * 后台首页  代理商管理
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class ParadiseManageController extends AdminbaseController {

    protected $paradise_model;
    function _initialize() {
        parent::_initialize();
        $this->paradise_model =M("Paradise");
    }
    function index(){
        $this->assign("parase",$this->paradise_model->select());
        $this->display("ParadiseManage/index");
    }


    function change(){
        $id = intval(I("id"));
        $paradise =  $this->paradise_model->where("id = $id")->find();
        $this->assign("paradise",$paradise);
        $this->display("change");
    }

    function change_post(){
        $data["sortid"] = intval(I("sortid"));
        $data["id"] = intval(I("id"));
        $data["name"] = I("name");
        $data["url"] = I("url");
        if ($this->paradise_model->save($data)){
            $this->success("更新成功！", U("index"));
        } else{
            $this->error($this->paradise_model->getError());
        }
    }
    function add(){
        $this->display("add");
    }
    function add_post(){
        $data["name"] = I("name");
        $data["url"] = I("url");
        $data["sortid"] = intval(I("sortid"));
        if ($this->paradise_model->add($data)){
            $this->success("新增成功！", U("index"));
        } else{
            $this->error($this->paradise_model->getError());
        }
    }
    function delete(){
        $id = intval(I("id"));
        if ($id){
            $data["id"] = $id;
           if ($this->paradise_model->where("id = $id")->delete()){
               $this->success("删除成功！", U("index"));
           } else{
               $this->error($this->paradise_model->getError());
           }
        }else{
            $this->error("删除失败!");
        }
    }
}

