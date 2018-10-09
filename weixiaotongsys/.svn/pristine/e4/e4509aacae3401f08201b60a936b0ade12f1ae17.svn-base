<?php

/**
 * 后台首页
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
class TeacherAttendSelectController extends TeacherbaseController {
    function _initialize() {
        parent::_initialize();

    }

// 老师考勤查询
	function index(){
        // 清除数据缓存
        $cache = new \Think\Cache;
        $cache->getInstance()->clear();
        //用户信息
        $userid=$_SESSION['USER_ID'];

        $schoolid=$_SESSION['schoolid'];

        $level= $_SESSION['level'];
        $attendance=M('attendance');

        $teacher_name=I('teacher_name');

        $work_card=I('work_card');

        $description=I('description');
        $start_time=I('start_time');
        $end_time=I('end_time');
        $attend_status=I('attend_status');

        $start_time_unix=strtotime($start_time);// 将任何英文文本的日期或时间描述解析为 Unix 时间戳
        $end_time_unix=strtotime($end_time);
        if($teacher_name)
        {
            $map['t.name']= $teacher_name;
            $this->assign("teacher_name",$teacher_name);

        }
        if($work_card)
        {
            $where['t_i.work_card']= $work_card;
            $this->assign("work_card",$work_card);
        }

        if($start_time && $end_time){
            $map["a.arrivedate"]=array(array('EGT',date('Y-m-d',$start_time_unix)),array('ELT',date('Y-m-d',$end_time_unix)));
            $this->assign("start_time_unix",date("Y-m-d",$start_time_unix));
            $this->assign("end_time_unix",date("Y-m-d",$end_time_unix));

        }else{
            $map["a.arrivedate"] = date('Y-m-d',time());
        }
        if($description)
        {
            array_push($where, "t_i.description like '%$description%' ");

            // $where['t_i.description']= $description;
        }
        if($attend_status==1)
        {
            $att_type="正常";

        }else if($attend_status==2)
        {
            $att_type="迟到";
        }

        if($level!=1  && $level!=2)
        {

            $map['a.schoolid'] = $schoolid;
//            $map['a.userid'] = $userid;

        }

        //开始改造

        $where['att.schoolid'] =  $schoolid;

        $week_time = date('w',time());
        $map['a.schoolid'] = $schoolid;

        $count=M('teacher_attendances') ->alias('a')->join("wxt_teacher_info t ON a.userid=t.id")->field($field)->where($map)->order("a.id DESC")->count();
        // $list=M('teacher_attendances')->where($map)->order("id DESC")->select();


        $page = $this->page($count, 20);
        $field = "a.id,a.arrivetime,a.attendancetype,a.ss_time,a.status,t.name,a.leavepicture";
        $list=M('teacher_attendances') ->alias('a')->join("wxt_teacher_info t ON a.userid=t.id")->field($field)->where($map)->order("a.id DESC")->select();





//2017 08 03 注释
        //   $where_teacher['t.schoolid'] = $schoolid;
        //    $teacher_info=M('teacher_info')
        // ->alias('t')
        // ->join("wxt_teacher_schedule ts ON t.teacherid=ts.teacherid")
        // ->join("wxt_wxtuser u ON u.id=t.teacherid")
        //       ->where($where_teacher)
        //       ->field("t.teacherid,ts.monday,ts.tuesday,ts.wednesday,ts.thursday,ts.friday,ts.saturday,ts.sunday,u.name")
        //       ->select();
        //   var_dump($teacher_info);
 

 	 
        //  foreach ($teacher_info as &$value) {
    	 
        
        //         $monday=$value['monday'];
          
        //         $userid = $value['teacherid'];
        //         //var_dump($userid);

        //         $sel =  M('attendance')->where("userid = $userid")->select();
          	    

        //     	  $schedule_add = M('teacher_schedule_add')->where("id=$monday")->find();
        //         $schedule_add['ss_time_start'];
        //     	  $schedule_add['ss_time_end'];
        //     	  $schedule_add['ss_time_front'];
        //     	  $schedule_add['ss_time_back'];
       
        //     	 //  foreach ($sel as &$val) {
        //       //      if(empty($val['arrivetime'])){
        //      	//   $schedule_add['ss_time_start'];
        //      	//   $schedule_add['ss_time_end'];
        //      	//   $schedule_add['ss_time_front'];
        //      	//   $schedule_add['ss_time_back'];
        //      	//   $val['arrivertime'] = $value;
        //      	// }
        //     	 //  }
  
          
        //     	  $schedule_add['sx_time_start'];
        //     	  $schedule_add['sx_time_end'];
        //     	  $schedule_add['sx_time_front'];
        //     	  $schedule_add['sx_time_back'];

        //     	  $schedule_add['xs_time_start'];
        //     	  $schedule_add['xs_time_end'];
        //     	  $schedule_add['xs_time_front'];
        //     	  $schedule_add['xs_time_back'];

        //     	  $schedule_add['xx_time_start'];
        //     	  $schedule_add['xx_time_end'];
        //     	  $schedule_add['xx_time_front'];
        //     	  $schedule_add['xx_time_back'];
        //     	  // var_dump(expression)

        //     //exit();

        //   }

        //end
        // exit();




// exit();

        // 添加分页

        /*
		获取考勤设置（暂时只获取第一条）, 因为表里原来的数据都是学生的，这里只是暂时使用，教师对应的字段名称也有所改动
		time_ss3:学生“上午上学 迟到时间” ———— 对应 老师 “上午上班”
		time_sf3:学生“上午放学 迟到时间” ———— 对应 老师 “上午下班”
		time_xs3:学生“下午上学 迟到时间” ———— 对应 老师 “下午上班”
		time_xf3:学生“下午放学 迟到时间” ———— 对应 老师 “下午下班”

		这里只取 time_ss3“上午上班” 一个字段，并且写死
		*/ 





        // $teacher_info = M('teacher_info')->where("schoolid = $schoolid")->select();
        // var_dump($teacher_info);


//先将教师信息和考勤表关联

//2017 08 03 注释
// $attendance_sel=$attendance
// 		->alias('att')
// 		->join("wxt_teacher_info t_i ON t_i.teacherid=att.userid")
// 		->join("wxt_wxtuser u ON u.id=att.userid")
// 		->where($where)
// 		->field("u.id as userid,u.name as name,att.arrivetime,att.sign_date,att.create_time,t_i.education_card,t_i.work_card,t_i.description")
// 		->limit($page->firstRow . ',' . $page->listRows)
// 		->select();
// var_dump($attendance_sel);

// //查出早上的上课时间
// $attendance_set_model=M('attendance_set');
// 		$attendance_set_model_find=$attendance_set_model
// 		->field("time_ss3")
// 		->find();
// 		//var_dump($attendance_set_model_find);
// 		$time_ss3=$attendance_set_model_find['time_ss3'];
// 		$aa=substr($time_ss3,0,2);
// 		//var_dump($aa);
// 		$bb=substr($time_ss3,-2);
// 		//var_dump($bb);


// //TODO以后补充  if create_time > $time_ss3 == 迟到;




// foreach ($attendance_sel as &$value) {
//  //将所有的老师取出   
//   $where_teacher['t.schoolid'] = $schoolid;
//      $teacher_info=M('teacher_info')
// 		        	->alias('t')
// 			        ->join("wxt_wxtuser u ON t.teacherid=u.id")
// 			        ->where($where_teacher)
// 			        ->field("u.name,t.teacherid")
// 			        ->select();
// 		//再将有考勤的过的老师数据拿出来
//    foreach ($teacher_info as $key => &$val) {

//       if($val['teacherid']==$value['userid'])
//       {     
//             $val['arrivetime'] = $value['arrivetime'];
//             $val['create_time'] = $value['create_time'];   
//             $time_self=$val['create_time'];
// 			$cc=strtotime(date('Y-m-d 00:00:00',$time_self));//获取某个时间戳对应的零点
// 			//var_dump($cc); 
// 			$dd=$cc+$aa*60*60+$bb*60;//获取某个时间戳对应的 $time_ss3 即考勤时间
// 		//	var_dump($dd);
// 			$val['attend_point']=$dd;
// 			$val['attend_time']="上午上班";
//       }
//       $arr[] = $val;

//     }
  

// }
//           $time_self=$val['create_time'];
// 			$cc=strtotime(date('Y-m-d 00:00:00',$time_self));//获取某个时间戳对应的零点 
// 			$dd=$cc+$aa*60*60+$bb*60;//获取某个时间戳对应的 $time_ss3 即考勤时间
// 			$val['attend_point']=$dd;
// 			$val['attend_time']="上午上班";

        // var_dump($arr);
// // exit();
        //  $attendance_count=$attendance
        // ->alias('att')
        // ->join("wxt_teacher_info t_i ON t_i.teacherid=att.userid")
        // ->join("wxt_wxtuser u ON u.id=att.userid")
        // ->where($where)
        // ->field("u.id as userid,u.name as name,att.sign_date,att.create_time,t_i.education_card,t_i.work_card,t_i.description")
        // ->count();
        //  $page = $this->page($attendance_count, 10);
        /*
		获取考勤设置（暂时只获取第一条）, 因为表里原来的数据都是学生的，这里只是暂时使用，教师对应的字段名称也有所改动
		time_ss3:学生“上午上学 迟到时间” ———— 对应 老师 “上午上班”
		time_sf3:学生“上午放学 迟到时间” ———— 对应 老师 “上午下班”
		time_xs3:学生“下午上学 迟到时间” ———— 对应 老师 “下午上班”
		time_xf3:学生“下午放学 迟到时间” ———— 对应 老师 “下午下班”

		这里只取 time_ss3“上午上班” 一个字段，并且写死
		*/ 
		// $attendance_set_model=M('attendance_set');
		// $attendance_set_model_find=$attendance_set_model
		// ->field("time_ss3")
		// ->find();
		// var_dump($attendance_set_model_find);
		// $time_ss3=$attendance_set_model_find['time_ss3'];
		// $aa=substr($time_ss3,0,2);
		// var_dump($aa);
		// $bb=substr($time_ss3,-2);
		// var_dump($bb);

// 		/*
// 		考勤表  sign_date 签到当天时间,  education_card 教育证号,  work_card 工号, description 教师介绍
// 		获取信息的主表
// 		*/ 
// 		$attendance_sel=$attendance
// 		->alias('att')
// 		->join("wxt_teacher_info t_i ON t_i.teacherid=att.userid")
// 		->join("wxt_wxtuser u ON u.id=att.userid")
// 		->where($where)
// 		->field("u.id as userid,u.name as name,att.arrivetime,att.sign_date,att.create_time,t_i.education_card,t_i.work_card,t_i.description")
// 		->limit($page->firstRow . ',' . $page->listRows)
// 		->select();
// var_dump($attendance_sel);


// 		foreach ($attendance_sel as &$val) {
// 			$time_self=$val['create_time'];
// 			$cc=strtotime(date('Y-m-d 00:00:00',$time_self));//获取某个时间戳对应的零点 
// 			$dd=$cc+$aa*60*60+$bb*60;//获取某个时间戳对应的 $time_ss3 即考勤时间
// 			$val['attend_point']=$dd;
// 			$val['attend_time']="上午上班";

// // 若果签到时间大于考勤时间
// 			if($time_self>$dd)
// 			{
// 				$val['attend_status']="迟到";
// 			}
// 			else
// 			{
// 				$val['attend_status']="正常";
// 			}
// 		}


        $this->assign("Page", $page->show('Admin'));
		$this->assign('posts',$list);
		$this->display("index");

	}



//导出教师考勤 todo以后再完善

    public function teacher_export()
    {

        $userid=$_SESSION['USER_ID'];

        $schoolid=$_SESSION['schoolid'];

        $level= $_SESSION['level'];
        $attendance=M('attendance');

        $teacher_name=I('teacher_name');

        $work_card=I('work_card');

        $description=I('description');
        $start_time=I('start_time');
        $end_time=I('end_time');
        $attend_status=I('attend_status');

        $start_time_unix=strtotime($start_time);// 将任何英文文本的日期或时间描述解析为 Unix 时间戳
        $end_time_unix=strtotime($end_time);
        if($teacher_name)
        {
            $map['t.name']= $teacher_name;
            $this->assign("teacher_name",$teacher_name);

        }
        if($work_card)
        {
            $where['t_i.work_card']= $work_card;
            $this->assign("work_card",$work_card);
        }

        if($start_time && $end_time){
            $map["a.arrivedate"]=array(array('EGT',date('Y-m-d',$start_time_unix)),array('ELT',date('Y-m-d',$end_time_unix)));
            $this->assign("start_time_unix",date("Y-m-d",$start_time_unix));
            $this->assign("end_time_unix",date("Y-m-d",$end_time_unix));

        }else{
            $map["a.arrivedate"] = date('Y-m-d',time());
        }
        if($description)
        {
            array_push($where, "t_i.description like '%$description%' ");

            // $where['t_i.description']= $description;
        }
        if($attend_status==1)
        {
            $att_type="正常";

        }else if($attend_status==2)
        {
            $att_type="迟到";
        }

        if($level!=1  && $level!=2)
        {

            $map['a.schoolid'] = $schoolid;
//            $map['a.userid'] = $userid;

        }


        $att_type=array("0"=>"未设置","1"=>"上午上班","2"=>"上午下班","3"=>"下午上班","4"=>"下午下班","5"=>"晚上上班","6"=>"晚上下班","7"=>"无考勤打卡","8"=>"特殊活动打卡");

        $status=array("0"=>"异常","1"=>"正常","2"=>"迟到","3"=>"早退","4"=>"病假","5"=>"事假","6"=>"其他","7"=>"其他");
        //开始改造

        $where['att.schoolid'] =  $schoolid;

        $week_time = date('w',time());
        $map['a.schoolid'] = $schoolid;

        $field = "a.id,a.arrivetime,a.attendancetype,a.ss_time,a.status,t.name,a.leavepicture";
        $list=M('teacher_attendances') ->alias('a')->join("wxt_teacher_info t ON a.userid=t.id")->field($field)->where($map)->order("a.id DESC")->select();

        foreach($list as &$value)
        {
            $value['attendancetype'] = $att_type[$value['attendancetype']];
            $value['status'] = $status[$value['status']];
            $value['arrivetime'] = date("Y-m-d H:i:s",$value['arrivetime']);
        }

        $xlsName  = "User";

        $xlsCell  = array(

            array('id','教师id'),

            array('name','老师名字'),

            array('attendancetype','考勤时段'),

            array('status','考勤状态'),

            array('arrivetime','打卡时间'),

        );
        $fileNames =  get_schoolname($schoolid).'-'.'老师考勤数据导出';
        $this->exportExcel($xlsName,$xlsCell,$list,$fileNames);

    }
    public function exportExcel($expTitle,$expCellName,$expTableData,$fileNames){

        $xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
        $fileName = $fileNames;//or $xlsTitle 文件名称可根据自己情况设定
        $cellNum = count($expCellName);
        $dataNum = count($expTableData);


        vendor('PHPExcel.PHPExcel');
        $objPHPExcel = new \PHPExcel();
        //var_dump($objPHPExcel);

        $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');

        //$objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');//合并单元格

        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle.'  Export time:'.date('Y-m-d H:i:s'));
        $objPHPExcel->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);//单元格宽度
        $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setName('Arial');//设置字体
        $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(10);//设置字体大小
        // $objPHPExcel->getActiveSheet(0)->setCellValue('A1',"名字");
        // $objPHPExcel->getActiveSheet(0)->setCellValue('B1',"时间");
        // $objPHPExcel->getActiveSheet(0)->setCellValue('C1',"照片");
        for($i=0;$i<$cellNum;$i++){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'1', $expCellName[$i][1]);
        }
        // Miscellaneous glyphs, UTF-8
        for($i=0;$i<$dataNum;$i++){
            for($j=0;$j<$cellNum;$j++){
                $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+2), $expTableData[$i][$expCellName[$j][0]]);
            }
        }

        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
        header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
        $objWriter = \ PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;

    }



// 老师考勤统计
	function index_statistic()
	{
    

    //留着备用excel导出

   //  $re = R('Teacher/TeacherInfo/exportExcel');
    
   // var_dump($re);
		// echo "index";

		// 清除数据缓存
		// $cache = new \Think\Cache;
		// $cache->getInstance()->clear();
        //用户信息
        $userid=$_SESSION['USER_ID'];

        $schoolid=$_SESSION['schoolid'];

        $level= $_SESSION['level'];

		$attendance=M('teacher_attendances');

		$teacher_name=I('teacher_name');

		$work_card=I('work_card');

		$start_time=I('start_time');
  
		$end_time=I('end_time');
   



		$start_time_unix=date('Y-m-d',strtotime($start_time));// 将任何英文文本的日期或时间描述解析为 Unix 时间戳
      

        $end_time_unix=date('Y-m-d',strtotime($end_time));
  
        if($teacher_name)
        {
        	$where['u.name']= $teacher_name;
        	$this->assign("teacher_name",$teacher_name);
        }
        if($work_card)
        {
        	$where['t_i.work_card']= $work_card;
        	$this->assign("work_card",$work_card);
        }

        if($start_time && $end_time){
            $where_arr["arrivedate"]=array(array('EGT',$start_time_unix),array('ELT',$end_time_unix));
            $this->assign('start_time_unix',$start_time_unix);
            $this->assign('end_time_unix',$end_time_unix);
        }else{
          $where_arr['arrivedate'] = date('Y-m-d',time());
        }

		$flag_0=I('flag_0');//  作为进入界面的标记

		$flag_1=I('flag_1');//  上午上班
	
		$flag_2=I('flag_2');//  上午下班
;
		$flag_3=I('flag_3');//  下午上班

		$flag_4=I('flag_4');//  下午下班

		$flag_5=I('flag_5');

		$flag_6=I('flag_6');

        if(empty($flag_0)&&empty($flag_1)&&empty($flag_2)&&empty($flag_3)&&empty($flag_4)&&empty($flag_5)&&empty($flag_6))
        {
            $flag_1=1;$flag_2=2;$flag_3=3;$flag_4=4;$flag_5=5;$flag_6=6;
        }


        if($level!=1  && $level!=2)
        {
            $where_arr['schoolid'] = $schoolid;
            $where_arr['userid'] = $userid;

        }
      

       $where['d.schoolid']=$schoolid;

        $where_arr['schoolid'] = $schoolid;

        $attend = M('teacher_attendances')->where($where_arr)->field('arrivedate')->group('arrivedate')->select();

        //要改造

// exit();

// var_dump($attend);
//第二种写法可以查出全部
        foreach($attend as $key => &$value)
        {

            // var_dump($key);
            $arrivedate = $value['arrivedate'];
            // var_dump($arrivedate);
//查出该学校的老师
            $teacher_info=M("teacher_info")
                ->alias("d")
                ->join("wxt_wxtuser w ON d.teacherid=w.id")
                ->where($where)
                ->field("w.id,d.name,w.phone,d.schoolid,d.bindingkey,d.state")
                ->select();
            // var_dump($teacher_info);
            //根据$value里的attdate
            foreach($teacher_info as &$val)
            {
                $val['arrivedate'] = $value['arrivedate'];
                $userid = $val['id'];
                // var_dump($userid);
                $attends = M('teacher_attendances')->where("schoolid = $schoolid and userid =$userid and arrivedate='$arrivedate'")->order('attendancetype asc')->select();

                foreach ($attends as $k => &$v) {
                    if($value['arrivedate']==$v['arrivedate'])
                    {
                        if($v['attendancetype']==1)
                        {
                            $val['m_attend'] = $v['attendancetype'];
                        }
                        if($v['attendancetype']==2)
                        {
                            $val['m_lattend'] = $v['attendancetype'];
                        }

                        if($v['attendancetype']==3)
                        {
                            $val['a_attend'] = $v['attendancetype'];
                        }

                        if($v['attendancetype']==4)
                        {
                            $val['a_lattend'] = $v['attendancetype'];
                        }

                        if($v['attendancetype']==5)
                        {
                            $val['n_attend'] = $v['attendancetype'];
                        }
                        if($v['attendancetype']==6)
                        {
                            $val['n_lattend'] = $v['attendancetype'];
                        }


                    }
       
                }
           
            }
            $arr[] = $teacher_info;
 

}

//将获取的数组降维成二维数组
        foreach ($arr as  $value) {
            foreach ($value as  $val) {
                $new_arr[] = $val;
            }
        }
// var_dump($new_arr);
// $teacher_info=M("teacher_info")
//         ->alias("d")
//         ->join("wxt_wxtuser w ON d.teacherid=w.id")
//         ->join($join)
//         ->distinct(true)
//         ->limit($page->firstRow . ',' . $page->listRows)
//         ->where($where)
//         ->field("w.id,w.name,w.phone,d.schoolid,d.bindingkey,d.state")
//         ->select();
        // var_dump($teacher_info);
     


        // foreach ($teacher_info as &$value) {
        // 	  var_dump($value);
        // 	  $userid = $value['id'];
        //     $attend = M('teacher_attendances')->where("userid =$userid")->order('attendancetype asc')->select();
        //     var_dump($attend);
        //     foreach ($attend as  &$val) {
        //     	$value['cardNo'] = $val['cardno'];
        //     	if($val['attendancetype']==1)
        //     	{
        //     		$value['m_attend'] = $val['attendancetype'];
        //     	}
        //     	if($val['attendancetype']==2)
        //     	{
        //        $value['m_lattend'] = $val['attendancetype'];
        //       }

        //       if($val['attendancetype']==3)
        //     	{
        //        $value['a_attend'] = $val['attendancetype'];
        //       }

        //       if($val['attendancetype']==4)
        //     	{
        //        $value['a_lattend'] = $val['attendancetype'];
        //       }

        //       if($val['attendancetype']==5)
        //     	{
        //        $value['n_attend'] = $val['attendancetype'];
        //       }
        //       if($val['attendancetype']==6)
        //     	{
        //        $value['n_lattend'] = $val['attendancetype'];
        //       }
          
        //     }

        // }
        // var_dump($teacher_info);


        $this->assign('flag_1',$flag_1);
        $this->assign('flag_2',$flag_2);
        $this->assign('flag_3',$flag_3);
        $this->assign('flag_4',$flag_4);
        $this->assign('flag_5',$flag_5);
        $this->assign('flag_6',$flag_6);
        $this->assign('teacher_info',$new_arr);
        $this->display("index_statistic");


    }



}