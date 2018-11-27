<?php

namespace  app\model;

use core\lib\model;

class  userModel extends model
{

    public  $table = "";



    //获取表集合
    public function  lists()
    {

         $ret = $this->select($this->table,'*');

         return $ret;
    }
    //获取一条数据
    public function getOne($id)
    {

        $res = $this->get($this->table,'*',array('id'=>$id));

        return $res;

    }

    //修改一条数据
    public function setOne($id,$data)
    {
//       var_dump($this->table);

      return $this->update($this->table,$data,array("id"=>$id));
    }
    //删除一条
    public function delOne($id)
    {
        return $this->delete($this->table,array('id'=>$id));
    }
}

