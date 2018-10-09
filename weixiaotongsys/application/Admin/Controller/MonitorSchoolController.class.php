<?php

/**
 * 视频监控管理
 */

namespace Admin\Controller;

use Common\Controller\AdminbaseController;

class MonitorSchoolController extends AdminbaseController
{
    function _initialize()
    {
        parent::_initialize();
    }

    //设备列表
    public function index()
    {
        $info=M('MonitorVideo')
            ->alias('mv')
            ->join('wxt_school as s on mv.school_id = s.schoolid')
            ->field('s.school_name')
            ->group('mv.school_id')
            ->select();
        foreach($info as $value){
            $school["$value[school_name]"]['school']=$value['school_name'];
            $school["$value[school_name]"]['video']=1;
            $school["$value[school_name]"]['live']=0;
        }
        $infos=M('MonitorLive')
            ->alias('ml')
            ->join('wxt_school as s on ml.school_id = s.schoolid')
            ->field('s.school_name')
            ->group('ml.school_id')
            ->select();
        foreach($infos as $val){
            if(empty($school["$val[school_name]"]['video'])){
                $video=0;
            }else{
                $video=1;
            }
            $school["$val[school_name]"]['school']=$val['school_name'];
            $school["$val[school_name]"]['live']=1;
            $school["$val[school_name]"]['video']=$video;
        }
        $this->assign('info', $school);
        $this->display();
    }

    //通过区域来找对应的学校
    public function lookup(){
        $user_id = $_SESSION['ADMIN_ID'];
        $this->school_model = D("Common/School");
        $this->role_school = D("Common/role_school");
        $type=I("type");
        if($user_id)
        {
            $role = M("role_user")->where("user_id = $user_id")->getField("role_id");
        }
        //取最新记录的几个设备
        $idarrays = M('monitor_video')->field('school_id')->group('school_id')->select();
        $idarray = $this->array_column($idarrays,'school_id');
        $map['schoolid']  = array('in',$idarray);
        if($type!=""){
            if($role==1)
            {
                $School=$this->school_model->where("area=$type")->where($map)->field("school_name,schoolid,schoolgradetypeid")->select();

            }else{
                $School = $this->role_school->alias("rs")->join("wxt_school s ON s.schoolid = rs.schoolid")->where("rs.area = $type and rs.status = 1 and rs.roleid = $role")->where($map)->field("s.school_name,s.schoolid,s.schoolgradetypeid")->select();

            }
        }else{
            $ret = $this->format_ret(0,'参数缺失！');
        }
        echo json_encode(array('data'=>$School,'message'=>'10000'));
    }

    //返回当前账号下的设备列表
    public function devicelist()
    {
        $userid=I("userid");
        if($userid=="") {
            $ret = $this->format_ret(0,'参数缺失！');
            echo json_encode($ret);
            exit;
        }
        //取最新记录的几个设备
        $idarrays = M('monitor_device')->field('max(id)')->group('deviceserial')->select();
        $idarray = $this->array_column($idarrays,'max(id)');
        $map['id']  = array('in',$idarray);
        $device = M('monitor_device')
            ->where($map)
            ->where("userid = '$userid'")
            ->field('deviceSerial,alias')
            ->select();
        if($device){
            echo json_encode(array('data'=>$device,'message'=>'10000'));
        }else{
            $ret = $this->format_ret(0,'没有设备信息！');
            echo json_encode($ret);
            exit;
        }

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
    /**
     * 低于PHP 5.5版本的array_column()函数
     **/
    function array_column($input, $columnKey, $indexKey = NULL)
    {
        $columnKeyIsNumber = (is_numeric($columnKey)) ? TRUE : FALSE;
        $indexKeyIsNull = (is_null($indexKey)) ? TRUE : FALSE;
        $indexKeyIsNumber = (is_numeric($indexKey)) ? TRUE : FALSE;
        $result = array();

        foreach ((array)$input AS $key => $row)
        {
            if ($columnKeyIsNumber)
            {
                $tmp = array_slice($row, $columnKey, 1);
                $tmp = (is_array($tmp) && !empty($tmp)) ? current($tmp) : NULL;
            }
            else
            {
                $tmp = isset($row[$columnKey]) ? $row[$columnKey] : NULL;
            }
            if ( ! $indexKeyIsNull)
            {
                if ($indexKeyIsNumber)
                {
                    $key = array_slice($row, $indexKey, 1);
                    $key = (is_array($key) && ! empty($key)) ? current($key) : NULL;
                    $key = is_null($key) ? 0 : $key;
                }
                else
                {
                    $key = isset($row[$indexKey]) ? $row[$indexKey] : 0;
                }
            }

            $result[$key] = $tmp;
        }

        return $result;
    }

}