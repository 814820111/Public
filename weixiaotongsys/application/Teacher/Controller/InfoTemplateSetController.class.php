<?php

/**
 * 信息模板设置
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
class InfoTemplateSetController extends TeacherbaseController {

    function _initialize() {
        parent::_initialize();

    }

//  整体考勤短信设置
	function indexWhole()
	{
		// 清除数据缓存
		$cache = new \Think\Cache;
		$cache->getInstance()->clear();
		$schoolid=$_SESSION['schoolid'];

		$message = M('infotemplateset_wb')->where("schoolid=$schoolid and type = 1")->find();

		if(!$message)
		{
			$message = M('infotemplateset_wb')->where("type = 1")->find();
		}
        // var_dump($message);
  
        $this->assign('morn_school',$message['morn_school']);
        $this->assign('morn_leave',$message['morn_leave']);
        $this->assign('after_school',$message['after_school']);
        $this->assign('after_leave',$message['after_leave']);
        $this->assign('night_school',$message['night_school']);
        $this->assign('night_leave',$message['night_leave']);
		$this->display("indexWhole");
	}

//  提交 整体考勤短信设置
	function indexWhole_post()
	{   
       $infotemplateset_wb=M('infotemplateset_wb');
		$schoolid=$_SESSION['schoolid'];

		$text_1=I('text_1');
		
		$text_2=I('text_2');
		
		$text_3=I('text_3');
		$text_4=I('text_4');
		$text_5=I('text_5');
		// var_dump($text_5);
		$text_6=I('text_6');
		// var_dump($text_6);

		$data['type']=1;
		$data['morn_school']=$text_1;
		$data['morn_leave']=$text_2;
		$data['after_school']=$text_3;
		$data['after_leave']=$text_4;
		$data['night_school']=$text_5;
		$data['night_leave']=$text_6;
		$data['schoolid'] = $schoolid;
		$data['create_time']=time();

       $message = M('infotemplateset_wb')->where("schoolid = $schoolid and type = 1")->find();

       if(!$message)
       {
       	$infotemplateset_wb_add=$infotemplateset_wb->where("schoolid=$schoolid")->add($data);
       }else{
       	$infotemplateset_wb_add=$infotemplateset_wb->where("schoolid=$schoolid")->save($data);
       }


		
		if($infotemplateset_wb_add)
		{
			$this->error("保存成功！");
		}
		else
		{
			$this->error("保存失败");
		}

	}

// 住校生考勤短信
	function index_Boarder()
	{
       	$schoolid=$_SESSION['schoolid'];


       	

	  $message = M('infotemplateset_wb')->where("schoolid=$schoolid and type = 1")->find();

		if(!$message)
		{
			$message = M('infotemplateset_wb')->where("type = 1")->find();
		}

        // var_dump($message);

  
        $this->assign('morn_school',$message['morn_school']);
        $this->assign('morn_leave',$message['morn_leave']);
        $this->assign('after_school',$message['after_school']);
        $this->assign('after_leave',$message['after_leave']);
        $this->assign('night_school',$message['night_school']);
        $this->assign('night_leave',$message['night_leave']);
      
  



		$this->display("index_Boarder");
	}
// 提交  住校生考勤短信
	function index_Boarder_post()
	{
        $infotemplateset_wb=M('infotemplateset_wb');
		$schoolid=$_SESSION['schoolid'];

		$text_1=I('text_1');
		$text_2=I('text_2');
		$text_3=I('text_3');
		$text_4=I('text_4');
		$text_5=I('text_5');
		// var_dump($text_5);
		$text_6=I('text_6');
		// var_dump($text_6);

		$data['type']=2;
		$data['morn_school']=$text_1;
		$data['morn_leave']=$text_2;
		$data['after_school']=$text_3;
		$data['after_leave']=$text_4;
		$data['night_school']=$text_5;
		$data['night_leave']=$text_6;
		$data['schoolid'] = $schoolid;
		$data['create_time']=time();


		  $message = M('infotemplateset_wb')->where("schoolid = $schoolid and type = 2")->find();

       if(!$message)
       {
       	$infotemplateset_wb_add=$infotemplateset_wb->where("schoolid=$schoolid")->add($data);
       }else{
       	$infotemplateset_wb_add=$infotemplateset_wb->where("schoolid=$schoolid")->save($data);
       }


	
		if($infotemplateset_wb_add)
		{
			$this->error("保存成功！");
		}
		else
		{
			$this->error("保存失败");
		}
	}





//  特殊活动考勤短信
	function index_special()
	{
		$infotemplateset_special=M('infotemplateset_special');
		$infotemplateset_special_sel=$infotemplateset_special->field("id,event_name,start_time,end_time,status,content,create_time,type")->select();

		$this->assign("list",$infotemplateset_special_sel);
		$this->display("index_special");
	}

// 添加  特殊活动考勤短信

	function index_special_add()
	{

		$this->display("add");

	}



	function index_special_add_post()
	{
		$event_name=I('event_name');
		$start_time=I('start_time');
		$end_time=I('end_time');
		$content=I('content');
		$type=I('type');
		$data['event_name']=$event_name;
		$data['start_time']=$start_time;
		$data['end_time']=$end_time;
		$data['content']=$content;
		$data['type']=$type;
		$infotemplateset_special=M('infotemplateset_special');
		$infotemplateset_special_add=$infotemplateset_special->add($data);

		if($infotemplateset_special_add)
		{
			$this->index_special();
		}
		else
		{
			$this->error("添加失败");
		}


		// echo $event_name;
		
	}


	function kaiqi_guanbi()
	{
		$id=I('id');
		$type=I('type');
		$infotemplateset_special=M('infotemplateset_special');

		$infotemplateset_special_save=$infotemplateset_special
		->where(array("id"=>$id))
		->save(array("type"=>$type));

		$this->index_special();



		// print_r($type);


	}





}