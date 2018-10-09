<?php
/* *
 * 系统权限配置，用户角色管理
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class SwitchController extends AdminbaseController {

    function _initialize() {
        parent::_initialize();
        $this->switch_model = D("Common/switch");
        $this->school_model = D("Common/school");
        $this->switch_detail = D("Common/switch_detail");
    }
    public function index()
    {

       $switch = $this->switch_model->select();

       $this->assign("switch",$switch);
        $this->display();
    }

    public function add()
    {

        $this->display();
    }

    public function add_post()
    {
        $name = I("name");
        $identifier = I("identifier");
        $status = I("status");

        $is_all = I("is_all");
        if(!$name)
        {
            $this->error("开关名称不能为空!");
        }
        if(!$identifier)
        {
            $this->error("开关标识不能为空!");
        }
        if(!$status)
        {
            $this->error("状态不能为空!");
        }
        if(!$is_all)
        {
            $this->error("请选择是否要同步所有学校!");
        }

        $is_identifier = $this->switch_model->where(array("identifier"=>$identifier))->find();
        if($is_identifier)
        {
            $this->error("请勿重复添加标识!");
        }



        $data = $this->switch_model->create();
        $add = $this->switch_model->add($data);
        if ($add!==false) {

             //插入所有学校

            if($is_all==1)
            {
              $school = $this->school_model->field("schoolid")->select();

              foreach ($school as $value)
              {
                  $data_detail['schoolid'] =$value['schoolid'];
                  $data_detail['identifier'] = $identifier;
                  $data_detail['name'] = $name;
                  $data_detail['status'] = $status;
                  $data_detail['switchid'] =$add;
                  $alldata[]=$data_detail;
                  unset($data_detail);
              }

                $this->switch_detail->addAll($alldata);

            }
            $this->success("添加成功！", U('Switch/index'));
        } else {
            $this->error("添加失败！");
        }

    }

    public function edit()
    {
        $id = I("id");
        if(!$id)
        {
            $this->error("参数有误");
        }

        $switch =  $this->switch_model->where("id = $id")->find();

        $this->assign("id",$id);
        $this->assign("switch",$switch);
        $this->display();

    }

    public function edit_post()
    {
        $name = I("name");
        $identifier = I("identifier");
        $status = I("status");
        $is_all = I("is_all");
        if(!$name)
        {
            $this->error("开关名称不能为空!");
        }
        if(!$identifier)
        {
            $this->error("开关标识不能为空!");
        }
        if(!$status)
        {
            $this->error("状态不能为空!");
        }
        if(!$is_all)
        {
            $this->error("请选择是否要同步学校");
        }



        $data = $this->switch_model->create();

        $save = $this->switch_model->save($data);

        if ($save!==false) {

            if($is_all==1)
            {
                //查询出所有学校
                $school = $this->school_model->field("schoolid")->select();
                $sql = '';
                foreach($school as $value)
                {
                       $schoolid = $value['schoolid'];


                        $sql .= "update wxt_switch_detail set name = '$name',status = '$status' where schoolid = $schoolid and identifier = '$identifier';";

                }



                $Model = D();
                $Model->execute($sql);
            }


            $this->success("添加成功！", U('Switch/index'));
        } else {
            $this->error("添加失败！");
        }

    }

    public function save_switch()
    {
        $id = I("id");

        $status = I("status");

       $save = $this->switch_model->where(array("id"=>$id))->save(array("status"=>$status));

       if($save)
       {
           $info['status'] = true;
           $info['msg'] = "更新成功";
       }else{
           $info['status'] = false;
           $info['msg'] = "更新成功";
       }

     echo json_encode($info);



    }

    public function delete()
    {
      $id = I("id");

      if($id)
      {
          //删除主表
          $switch_del =  $this->switch_model->where(array("id"=>$id))->delete();
          //删除详细表
          if($switch_del)
          {
             $this->switch_detail->where(array("switchid"=>$id))->delete();
          }
          if($switch_del)
          {
            $this->success("删除成功");
          }else{
              $this->error("删除失败");
          }
      }else{
          $this->error("参数有误");
      }
    }

    //同步学校开关
    public function school_synchronization()
    {

        //查询出所有学校
        $school = $this->school_model->field("schoolid")->select();

        $switch = $this->switch_model->select();

        //删除所有
        $del_switch = $this->switch_detail->where("1=1")->delete();

        //查询出通用开关
        foreach($school as $value)
        {
            $schoolid = $value['schoolid'];
            foreach ($switch as $val)
            {
              $data['schoolid'] = $schoolid;
              $data['identifier'] = $val['identifier'];
              $data['name'] = $val['name'];
              $data['status'] = $val['status'];
              $data['switchid'] = $val['id'];
              $alldata[]=$data;
              unset($data);

            }
            $this->switch_detail->addAll($alldata);
            unset($alldata);

        }


            $info['status'] = true;
            $info['msg'] = "同步成功";

        echo json_encode($info);

    }
}
