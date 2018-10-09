<?php

/**
 * app广告设置
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class AppPosterManageController extends AdminbaseController {

    protected $advertisement_model;
    function _initialize() {
        parent::_initialize();
        $this->advertisement_model =M("Advertisement");
    }
    function index(){

        $this->assign("advertisement",$this->advertisement_model->order("type asc")->select());
        $this->display("AppPosterManage/index");
    }


    function change(){
        $id = intval(I("id"));
        $advertisement =  $this->advertisement_model->where("id = $id")->find();
        $this->assign("advertisement",$advertisement);
        $this->display("change");
    }

    function change_post(){
        $data["id"] = intval(I("id"));
        $data["sortid"] = intval(I("sortid"));
        $data["message_title"] = I("title");
        $data["message_url"] = I("url");
        $data["type"] = I("type");
        $data["message_pic"] =  sp_asset_relative_url($_POST['smeta']['thumb']);
        if ($this->advertisement_model->save($data)){
            $this->success("更新成功！", U("index"));
        } else{
            $this->error($this->advertisement_model->getError());
        }
    }
    function add(){
        $this->display("add");
    }
    function add_post(){
        $data["sortid"] = intval(I("sortid"));
        $data["message_title"] = I("title");
        $data["message_url"] = I("url");
        $data["type"] = I("type");
        $data["message_pic"] =  sp_asset_relative_url($_POST['smeta']['thumb']);
        if ($this->advertisement_model->add($data)){
            $this->success("新增成功！", U("index"));
        } else{
            $this->error($this->advertisement_model->getError());
        }
    }
    function delete(){
        $id = intval(I("id"));
        if ($id){
            $data["id"] = $id;
           if ($this->advertisement_model->where("id = $id")->delete()){
               $this->success("删除成功！", U("index"));
           } else{
               $this->error($this->advertisement_model->getError());
           }
        }else{
            $this->error("删除失败!");
        }
    }
}

