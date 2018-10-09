<?php

namespace Admin\Controller;
use Common\Controller\AdminbaseController;

 header("Content-type: text/html; charset=utf-8");  
class DeviceManageController extends AdminbaseController{
	protected $ad_model;
	
	function _initialize() {
		parent::_initialize();
		$this->ad_model = M("Device");
		$this->school_model = D("Common/School");
		$this->agreement_model = D("Common/deviceagreement");
		$this->log_model=D("Common/device_online");
		$this->attendance_model=D("Common/device_log");
	}
	function index(){
        $schoolid = I("school_id");

        $tiaojian = I("keywordtype");
        $shuzhi = I("keyword");
        $province = I("province");
        $citys = I('city');
        $message_type = I('message_type');


        if($schoolid)
        {
            $where['s.schoolid'] = $schoolid;
            $this->assign("schoolid",$schoolid);
        }

        if($province)
        {
            $this->assign("province",$province);
        }

        if($citys){
            $this->assign("new_citys",$citys);
        }
        if($message_type)
        {
            $where['s.area'] = $message_type;
            $this->assign("new_message_type",$message_type);
        }
        if($tiaojian){
            if($tiaojian == 'phone'){
                $where['d.phone'] = array('like',"%$shuzhi%");

            }
            if($tiaojian =='number'){
                $where['d.deviceid'] = array('like',"%$shuzhi%");
            }
            $this->assign("tiaojian",$tiaojian);
            $this->assign("shuzhi",$shuzhi);
        }


		$ads=$this->ad_model
		->alias('d')
		->join("".C('DB_PREFIX')."school s on s.schoolid=d.schoolid")
		->join("".C('DB_PREFIX')."agent ag on s.agent_id=ag.id")
		->join("".C('DB_PREFIX')."city c on ag.city=c.term_id")
		->join("".C('DB_PREFIX')."deviceagreement a on a.id=d.agreements")
        ->where($where)
		->field('d.*,s.school_name as schoolname,a.name as agreements,ag.name as agentname,c.name as cityname')->order('d.id desc')->select();
//		dump($ads);
        $Province=role_admin();
        //var_dump($agreementlist);
        //获取协议列表
        $this->assign("Province",$Province);
		$this->assign("ads",$ads);
		$this->display();
	}
	
	function add(){
		//获取学校列表
		$schoollist = $this->school_model->order(array("schoolid"=>"asc"))->select();
		// var_dump($schoollist);
		$agreementlist=$this->agreement_model->order(array("id"=>"asc"))->select();
         //获取省份
        $Province=role_admin();
		//var_dump($agreementlist);
		//获取协议列表
		 $this->assign("Province",$Province);
		$this->assign("schools",$schoollist);
		$this->assign("agreements",$agreementlist);
		$this->display();
	}
	
	function add_post(){
        

		if (IS_POST) {
            if(empty($_POST['school_id'])){
                $this->error("请选择学校！");
            }
            if(empty($_POST['agreement'])){
                $this->error("请选择协议！");
            }
            if(empty($_POST['type'])){
                $this->error("请选择类型！");
            }
            $deviceId =  $_POST['deviceId'];

            if($deviceId)
            {
                $show_deviceId = M("device")->where("deviceId = $deviceId")->find();

                if($show_deviceId)
                {
                    $this->error("设备编号已经存在!");
                }
            }


              $arr=explode(':',$_POST['xxt_agreement'],2);
             $xxthttp = 'http://'.strtr($arr[1],array("端口"=>'',")"=>''));
 
             $xxtname = strtr($arr[0],array("(IP"=>''));
            
    
            $data['schoolid']=$_POST['school_id'];
            $data['type']=$_POST['type'];
            $data['agreements']=$_POST['agreement']; 
            $data['SN']=$_POST['sn'];
            $data['IMEI']=$_POST['IMEI'];
            $data['create_time']=time();

            $data['deviceId'] = $deviceId;
            $data['phone'] = $_POST['phone'];
            // $data['xxt_dievivedid'] =
           
        //     $agreement = $_POST['agreement'];
		      // $arr=explode('.',$agreement,2);

            $result=$this->ad_model->add($data);


            if ($result) {

                if(!$deviceId)
                {
                    $data['deviceId'] = $result;
                    $deviceId = $this->ad_model->where("id = $result")->save($data);
                }



                $this->success("添加成功！",U('index'));
            } else {
                $this->error("添加失败！");
            }
             
        }
	}
	function edit(){
		$id=I("get.id");
		$ad=$this->ad_model->where("id=$id")->find();
		$school = $this->school_model->where(array("schoolid"=>$ad['schoolid']))->field("schoolid,school_name")->find();

        $agreementlist=$this->agreement_model->order(array("id"=>"asc"))->select();

        $agre = $ad['xxtname'].$this->get_agreement($ad['xxthttp']);

//        exit();

        $Province=role_admin();
        //获取协议列表

        $this->assign("ad_school",$school);
        $this->assign("Province",$Province);
        $this->assign("agre",$agre);
		$this->assign('ad',$ad);
		$this->assign("id",$id);
        $this->assign("agreements",$agreementlist);
		$this->display();
	}

    private function get_agreement($http)
    {

        $arr=explode(':',$http);

        $cc = '(IP:'.strtr($arr[1],array("//"=>'',")"=>'')).'端口:'.$arr[2].')';
        return $cc;

    }
	
	function edit_post(){
		if (IS_POST) {
            if(empty($_POST['school_id'])){
                $this->error("请选择学校！");
            }
            if(empty($_POST['agreement'])){
                $this->error("请选择协议！");
            }
            if(empty($_POST['type'])){
                $this->error("请选择类型！");
            }



            $id = I("id");

            $arr=explode(':',$_POST['xxt_agreement'],2);
            $xxthttp = 'http://'.strtr($arr[1],array("端口"=>'',")"=>''));

            $xxtname = strtr($arr[0],array("(IP"=>''));


            $data['schoolid']=$_POST['school_id'];
            $data['type']=$_POST['type'];
            $data['agreements']=$_POST['agreement'];
            $data['SN']=$_POST['sn'];
            $data['IMEI']=$_POST['IMEI'];
            $data['create_time']=time();
            $data['xxtname'] = $xxtname;
            $data['xxthttp'] = $xxthttp;
            $data['xxtstatus'] = $_POST['xxt_status'];
            $data['xxtsn'] = $_POST['xxt_sn'];
            $data['xxtimei'] = $_POST['xxt_IMEI'];
            $data['deviceId'] = $_POST['deviceId'];
            $data['phone'] = $_POST['phone'];
            // $data['xxt_dievivedid'] =

            //     $agreement = $_POST['agreement'];
            // $arr=explode('.',$agreement,2);
            $deviceId = $this->ad_model->where("id = $id")->save($data);


            if ($deviceId) {
                $this->success("修改成功！",U('index'));
            } else {
                $this->error("修改失败！");
            }

//			if ($this->ad_model->create()) {
//				if ($this->ad_model->save()!==false) {
//					$this->success("保存成功！", U("devicemanage/index"));
//				} else {
//					$this->error("保存失败！");
//				}
//			} else {
//				$this->error($this->ad_model->getError());
//			}
		}
	}
	
	/**
	*更新数据
	**/
	function update(){
		$id = I("get.id",0,"intval");
		$data['update_state']=-1;
		$where['id']=$id;
		if ($this->ad_model->where($where)->save($data)!==false) {
			$this->success("开始下发！");
		} else {
			$this->error("下发失败！");
		}
	}

	//设备状态监控
    public function device_online()
    {

        $schoolid = I("school_id");

        $tiaojian = I("keywordtype");
        $shuzhi = I("keyword");
        $province = I("province");
        $citys = I('city');
        $message_type = I('message_type');


        if($schoolid)
        {
            $where['s.schoolid'] = $schoolid;
            $this->assign("schoolid",$schoolid);
        }

        if($province)
        {
            $this->assign("province",$province);
        }

        if($citys){
            $this->assign("new_citys",$citys);
        }
        if($message_type)
        {
            $where['s.area'] = $message_type;
            $this->assign("new_message_type",$message_type);
        }
        if($tiaojian){
            if($tiaojian == 'phone'){
                $where['d.phone'] = array('like',"%$shuzhi%");

            }
            if($tiaojian =='number'){
                $where['d.deviceid'] = array('like',"%$shuzhi%");
            }
            $this->assign("tiaojian",$tiaojian);
            $this->assign("shuzhi",$shuzhi);
        }


        $ads=$this->ad_model
            ->alias('d')
            ->join("".C('DB_PREFIX')."school s on s.schoolid=d.schoolid")
            ->join("".C('DB_PREFIX')."agent ag on s.agent_id=ag.id")
            ->join("".C('DB_PREFIX')."city c on ag.city=c.term_id")
            ->join("".C('DB_PREFIX')."deviceagreement a on a.id=d.agreements")
            ->where($where)
            ->field('d.*,s.school_name as schoolname,a.name as agreements,ag.name as agentname,c.name as cityname')->order('d.id desc')->select();



       //获取当前时间戳

        $time = date('YmdHis');

        foreach($ads as &$value)
        {
           $deviceid = $value['deviceid'];
            $lasttime = M("device_online")->where("deviceId = $deviceid")->order("lasttime desc")->limit(0, 1)->getField('lasttime');
            $value['lasttime'] =$lasttime?date("Y-m-d H:i:s",strtotime($lasttime)):"";

             //如果时间小于三分钟则设备正常
            if ($time - $lasttime <= 300) {
                $value['connected_status'] = "已连接";
            }else{
                $value['connected_status'] = "未连接";

            }



        }

        $Province=role_admin();
        //var_dump($agreementlist);
        //获取协议列表
        $this->assign("Province",$Province);
        $this->assign("ads",$ads);
        $this->display();

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
	function log(){
		$count=$this->log_model
		->alias('l')
		->join("".C('DB_PREFIX')."device d on l.deviceId=d.deviceId")
		->join("".C('DB_PREFIX')."school s on s.schoolid=d.schoolid")
		->join("".C('DB_PREFIX')."agent ag on s.agent_id=ag.id")
		->join("".C('DB_PREFIX')."city c on ag.city=c.term_id")
		->join("".C('DB_PREFIX')."deviceagreement a on a.id=d.agreements")
        ->count();
            
        $page = $this->page($count, 20);
		$lists=$this->log_model
		->alias('l')
		->join("".C('DB_PREFIX')."device d on l.deviceId=d.deviceId")
		->join("".C('DB_PREFIX')."school s on s.schoolid=d.schoolid")
		->join("".C('DB_PREFIX')."agent ag on s.agent_id=ag.id")
		->join("".C('DB_PREFIX')."city c on ag.city=c.term_id")
		->join("".C('DB_PREFIX')."deviceagreement a on a.id=d.agreements")
		->field('l.*,d.type,d.sn,s.school_name as schoolname,a.name as agreements,ag.name as agentname,c.name as cityname')
		->limit($page->firstRow . ',' . $page->listRows)
		->order("id DESC")
		->select();
		
		// var_dump($lists);
		$this->assign("logs",$lists);
		$this->assign("page", $page->show('Admin'));
		$this->display();
	}
	//考勤日志
	function attendance(){
		$count=$this->attendance_model
		->alias('at')
		->join("".C('DB_PREFIX')."device d on at.deviceId=d.deviceId")
		->join("".C('DB_PREFIX')."school s on s.schoolid=d.schoolid")
		->join("".C('DB_PREFIX')."agent ag on s.agent_id=ag.id")
		->join("".C('DB_PREFIX')."city c on ag.city=c.term_id")
		->join("".C('DB_PREFIX')."deviceagreement a on a.id=d.agreements")
        ->count();
            
        $page = $this->page($count, 20);
		$lists=$this->attendance_model
		->alias('at')
		->join("".C('DB_PREFIX')."device d on at.deviceId=d.deviceId")
		->join("".C('DB_PREFIX')."school s on s.schoolid=d.schoolid")
		->join("".C('DB_PREFIX')."agent ag on s.agent_id=ag.id")
		->join("".C('DB_PREFIX')."city c on ag.city=c.term_id")
		->join("".C('DB_PREFIX')."deviceagreement a on a.id=d.agreements")
		->field('at.*,d.type,d.sn,s.school_name as schoolname,a.name as agreements,ag.name as agentname,c.name as cityname')
		->limit($page->firstRow . ',' . $page->listRows)
		->order("id DESC")
		->select();
		$this->assign("logs",$lists);
		$this->assign("page", $page->show('Admin'));
		$this->display();
	}	
	
}