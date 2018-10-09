<?php

/**
 * 后台首页
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
class AttendanceSetController extends TeacherbaseController {

    function _initialize() {
        parent::_initialize();

    }

//    考勤设置

    function boarders_index()
    {
        $schoolid = $_SESSION['schoolid'];
        $class=M('school_grade')->field("id,name,schoolid,gradeid")->order("id")->where("schoolid = $schoolid")->select();
        $this->assign("class",$class);
        $this->display("boarders_index");
    }
    function not_boarders()
    {
        $userid = $_SESSION['USER_ID'];
        $schoolid = $_SESSION['schoolid'];
        $class=M('school_grade')->field("id,name,schoolid,gradeid")->order("id")->where("schoolid = '$schoolid'")->select();
       // var_dump($class);die();
        foreach( $class as $k=>$v){
            if( !$v['name'] )
                unset( $class[$k] );
        }
        $class = array_filter($class);
        //var_dump($class);
        $this->assign("class",$class);
        $this->display("not_boarders");
    }

    //TODO非住校生 还没完善 还没加判断是否是住校生 
    function not_boarders_post(){
         $schoolid = $_SESSION['schoolid'];
        
        $grade = I('school');
      //  var_dump($grade);
        //exit();
        $stay = 2;
       $week = I('week');
       //早上上学
       $kaoqin_ss = I('kaoqin_ss');
        //var_dump($kaoqin_ss);
       $time_ss1 = I('time_ss1');
       //var_dump($time_ss1);
       $time_ss2 = I('time_ss2');
      // var_dump($time_ss2);
       $time_ss3 = I('time_ss3');
      // var_dump($time_ss3);
       // exit();
       //早上放学
        $kaoqin_sf = I('kaoqin_sf');
        
        //var_dump($kaoqin_sf);
       
        $time_sf1 = I('time_sf1');
        $time_sf2 = I('time_sf2');
        $time_sf3 = I('time_sf3');
       // exit();
        //下午上学
        $kaoqin_xs = I('kaoqin_xs');
        
        $time_xs1 = I('time_xs1');
        $time_xs2 = I('time_xs2');
        $time_xs3 = I('time_xs3');
       // var_dump($kaoqin_xs);
        //下午放学
        $kaoqin_xf = I('kaoqin_xf');
         // var_dump($kaoqin_xf);
         // exit();    
         $time_xf1 = I('time_xf1');
         $time_xf2 = I('time_xf2');
         $time_xf3 = I('time_xf3');


        //var_dump($kaoqin_xf);
        //晚上上学
        $kaoqin_ws = I('kaoqin_ws');

        $time_ws1 = I('time_ws1');
        $time_ws2 = I('time_ws2');
        $time_ws3 = I('time_ws3');
        
       // var_dump($kaoqin_ws);
        //晚上放学
        $kaoqin_wf = I('kaoqin_wf');

        $time_wf1 = I('time_wf1');
        $time_wf2 = I('time_wf2');
        $time_wf3 = I('time_wf3');
          //var_dump($kaoqin_wf); 
        
           //var_dump(date('w'));
           // var_dump($week);
 // exit();
        // if ($week == 0) {
        //     echo "Dasdsa";
        // }
        $school_grade = M('school_grade')->where("schoolid = $schoolid")->order("id ASC")->select();
           //如果为全校
        if ($grade == 0) {

            //echo "DSadsa";
            //var_dump($school);
          //  $school_grade = M('school_grade')->where("schoolid = $schoolid")->order("id ASC")->select();
            //并且又为全周 循环全年段和全周
           if ($week == 0) {
             
              //$weeks = count($school_grade)*7;
             //删除该学校的所有年级考勤再添加
             $del = M('attendancesetting')->where("schoolid = $schoolid and stay = $stay")->delete();

             //exit();    
              //从礼拜一到礼拜日
              for ($i=1; $i <= 7; $i++) { 
                  //$list = array();
                     $list = array();
                   //如果其中选中了上午放学     一下以此类推
                   if ($kaoqin_ss == 1) {
                       foreach ($school_grade as $key => $value) {
                      $list = $value['gradeid'];

                      $data['week'] =$i;

                      $data['gradeid'] = $list;
                      
                      $data['schoolid'] = $schoolid;

                      $data['type'] = $kaoqin_ss;

                      $data['begintime'] = $time_ss1;

                      $data['endtime'] = $time_ss2;

                      $data['latetime'] = $time_ss3;

                      $data['opt'] = 1;

                      $data['stay'] = 2;

                      $attend = M('attendancesetting')->add($data);
                     
                     }   
                   }


                   if($kaoqin_sf == 2){

                   foreach ($school_grade as $key => $value) {
                      $list = $value['gradeid'];

                      $data['week'] =$i;

                      $data['gradeid'] = $list;
                      
                      $data['schoolid'] = $schoolid;

                      $data['type'] = $kaoqin_sf;

                      $data['begintime'] = $time_sf1;
                      
                      $data['endtime'] = $time_sf2;

                      $data['latetime'] = $time_sf3;

                      $data['opt'] = 1;

                      $data['stay'] = 2;

                      $attend = M('attendancesetting')->add($data);
                     
                     }
                  }
                
                     
                   if($kaoqin_xs == 3){

                        foreach ($school_grade as $key => $value) {
                      $list = $value['gradeid'];

                      $data['week'] =$i;

                      $data['gradeid'] = $list;
                      
                      $data['schoolid'] = $schoolid;

                      $data['type'] = $kaoqin_xs;

                      $data['begintime'] = $time_xs1;
                      
                      $data['endtime'] = $time_xs2;

                      $data['latetime'] = $time_xs3;

                      $data['opt'] = 1;

                      $data['stay'] = 2;

                      $attend = M('attendancesetting')->add($data);
                     
                     }


                   }

                   if($kaoqin_xf == 4){

                 foreach ($school_grade as $key => $value) {
                      $list = $value['gradeid'];

                      $data['week'] =$i;

                      $data['gradeid'] = $list;
                      
                      $data['schoolid'] = $schoolid;

                      $data['type'] = $kaoqin_xf;

                      $data['begintime'] = $time_xf1;
                      
                      $data['endtime'] = $time_xf2;

                      $data['latetime'] = $time_xf3;

                      $data['opt'] = 1;

                      $data['stay'] = 2;

                      $attend = M('attendancesetting')->add($data);
                     
                     }


                   }

                   if($kaoqin_ws == 5){

                  foreach ($school_grade as $key => $value) {
                      $list = $value['gradeid'];

                      $data['week'] =$i;

                      $data['gradeid'] = $list;
                      
                      $data['schoolid'] = $schoolid;

                      $data['type'] = $kaoqin_ws;

                      $data['begintime'] = $time_ws1;
                      
                      $data['endtime'] = $time_ws2;

                      $data['latetime'] = $time_ws3;

                      $data['opt'] = 1;

                      $data['stay'] = 2;

                      $attend = M('attendancesetting')->add($data);
                     
                     }


                   }



                   if($kaoqin_wf == 6){

                foreach ($school_grade as $key => $value) {
                      $list = $value['gradeid'];

                      $data['week'] =$i;

                      $data['gradeid'] = $list;
                      
                      $data['schoolid'] = $schoolid;

                      $data['type'] = $kaoqin_wf;

                      $data['begintime'] = $time_wf1;
                      
                      $data['endtime'] = $time_wf2;

                      $data['latetime'] = $time_wf3;

                      $data['opt'] = 1;

                      $data['stay'] = 2;

                      $attend = M('attendancesetting')->add($data);
                     
                      }


                    }

              
              }
           
    
           }
                switch ($week) {                                            
                    case '1':
                   if($kaoqin_ss == 1){
                     $this->days($kaoqin_ss,$week,$stay); 
                   }

                   if($kaoqin_sf == 2){
                    $this->days($kaoqin_sf,$week,$stay); 
                   }
                   if($kaoqin_xs==3){
                    $this->days($kaoqin_xs,$week,$stay); 
                   }
                   if($kaoqin_xf == 4){
                   $this->days($kaoqin_xf,$week,$stay);
                   }
                   if ($kaoqin_ws == 5) {
                       $this->days($kaoqin_ws,$week,$stay);
                   }
                   if($kaoqin_wf == 6){
                    $this->days($kaoqin_wf,$week,$stay);
                   }
                        break;
                    case '2':
                   if($kaoqin_ss == 1){
                     $this->days($kaoqin_ss,$week,$stay); 
                   }

                   if($kaoqin_sf == 2){                   
                    $this->days($kaoqin_sf,$week,$stay); 
                   }
                   if($kaoqin_xs==3){
                    $this->days($kaoqin_xs,$week,$stay); 
                   }
                   if($kaoqin_xf == 4){
                   $this->days($kaoqin_xf,$week,$stay);
                   }
                   if ($kaoqin_ws == 5) {
                       $this->days($kaoqin_ws,$week,$stay);
                   }
                   if($kaoqin_wf == 6){
                    $this->days($kaoqin_wf,$week,$stay);
                   }
                        break;
                     case '3':
                   if($kaoqin_ss == 1){
                     $this->days($kaoqin_ss,$week,$stay); 
                   }

                   if($kaoqin_sf == 2){

                    $this->days($kaoqin_sf,$week,$stay); 
                   }
                   if($kaoqin_xs==3){
                    $this->days($kaoqin_xs,$week,$stay); 
                   }
                   if($kaoqin_xf == 4){
                   $this->days($kaoqin_xf,$week,$stay);
                   }
                   if ($kaoqin_ws == 5) {
                       $this->days($kaoqin_ws,$week,$stay);
                   }
                   if($kaoqin_wf == 6){
                    $this->days($kaoqin_wf,$week,$stay);
                   }
                        break;
                     case '4':
                   if($kaoqin_ss == 1){
                     $this->days($kaoqin_ss,$week,$stay); 
                   }

                   if($kaoqin_sf == 2){

                    $this->days($kaoqin_sf,$week,$stay); 
                   }
                   if($kaoqin_xs==3){
                    $this->days($kaoqin_xs,$week,$stay); 
                   }
                   if($kaoqin_xf == 4){
                   $this->days($kaoqin_xf,$week,$stay);
                   }
                   if ($kaoqin_ws == 5) {
                       $this->days($kaoqin_ws,$week,$stay);
                   }
                   if($kaoqin_wf == 6){
                    $this->days($kaoqin_wf,$week,$stay);
                   }
                        break;
                 case '5':
                   if($kaoqin_ss == 1){
                     $this->days($kaoqin_ss,$week,$stay); 
                   }

                   if($kaoqin_sf == 2){

                    $this->days($kaoqin_sf,$week,$stay); 
                   // echo "我成功了2";
                   }
                   if($kaoqin_xs==3){
                    $this->days($kaoqin_xs,$week,$stay); 
                   }
                   if($kaoqin_xf == 4){
                   $this->days($kaoqin_xf,$week,$stay);
                   }
                   if ($kaoqin_ws == 5) {
                       $this->days($kaoqin_ws,$week,$stay);
                   }
                   if($kaoqin_wf == 6){
                    $this->days($kaoqin_wf,$week,$stay);
                   }
                        break;
                  case '6':
                   if($kaoqin_ss == 1){
                     $this->days($kaoqin_ss,$week,$stay); 
                   }

                   if($kaoqin_sf == 2){

                    $this->days($kaoqin_sf,$week,$stay); 
                   }
                   if($kaoqin_xs==3){
                    $this->days($kaoqin_xs,$week,$stay); 
                   }
                   if($kaoqin_xf == 4){
                   $this->days($kaoqin_xf,$week,$stay);
                   }
                   if ($kaoqin_ws == 5) {
                       $this->days($kaoqin_ws,$week,$stay);
                   }
                   if($kaoqin_wf == 6){
                    $this->days($kaoqin_wf,$week,$stay);
                   }
                        break;

                case '7':
                   if($kaoqin_ss == 1){
                     $this->days($kaoqin_ss,$week,$stay); 
                   }

                   if($kaoqin_sf == 2){

                    $this->days($kaoqin_sf,$week,$stay); 
                   }
                   if($kaoqin_xs==3){
                    $this->days($kaoqin_xs,$week,$stay); 
                   }
                   if($kaoqin_xf == 4){
                   $this->days($kaoqin_xf,$week,$stay);
                   }
                   if ($kaoqin_ws == 5) {
                       $this->days($kaoqin_ws,$week,$stay);
                   }
                   if($kaoqin_wf == 6){
                    $this->days($kaoqin_wf,$week,$stay);
                   }
                        break;
                    
                    default:
                        # code...
                        break;
                }
              
         
            
           
        
        }else{
              //否则选中单日和单个年级
            if($kaoqin_ss == 1){
                 $where['week'] = $week;
                 $where['gradeid'] = $grade;
                 $where['schoolid'] = $schoolid;
                 $where['type'] = $kaoqin_ss;
                 $ss_del = M('attendancesetting')->where($where)->delete();

                 if($week == 0){

                    $where_week['type'] = $kaoqin_ss;
                    $where_week['schoolid'] = $schoolid;
                    $where_week['gradeid'] = $grade;
                    $delweek = M('attendancesetting')->where($where_week)->delete();
             
                    $this->week($grade,$kaoqin_ss,$time_ss1,$time_ss2,$time_ss3,$stay);
                  // return;
                 }else{


               
                 //echo "Dsadas";

                  $data['gradeid'] = $grade;
                  $data['type'] = $kaoqin_ss;
                  $data['week'] = $week;
                  $data['schoolid'] = $schoolid;
                  $data['begintime'] = $time_ss1;
                  $data['endtime'] = $time_ss2;
                  $data['latetime'] = $time_ss3;
                  $data['opt'] = 1;
                  $data['stay'] = $stay;
                  $attend = M('attendancesetting')->add($data);
                 }    // var_dump($attend);
             
            }
         
         if($kaoqin_sf == 2){
                 $where['week'] = $week;
                 $where['gradeid'] = $grade;
                 $where['schoolid'] = $schoolid;
                 $where['type'] = $kaoqin_sf;
               $sf_del = M('attendancesetting')->where($where)->delete();

                 if($week== 0){
                    $where_week['type'] = $kaoqin_sf;
                    $where_week['schoolid'] = $schoolid;
                    $where_week['gradeid'] = $grade;
                    // $where_week['week'] = $week
                    $delweek = M('attendancesetting')->where($where_week)->delete();
                
                    $this->week($grade,$kaoqin_sf,$time_sf1,$time_sf2,$time_sf3,$stay);
                    
                 }else{

                 //echo "Dsadas";

                  $data['gradeid'] = $grade;
                  $data['type'] = $kaoqin_sf;
                  $data['week'] = $week;
                  $data['schoolid'] = $schoolid;
                  $data['begintime'] = $time_sf1;
                  $data['endtime'] = $time_sf2;
                  $data['latetime'] = $time_sf3;
                  $data['opt'] = 1;
                  $data['stay'] = $stay;
                  $attend = M('attendancesetting')->add($data);
               }   // var_dump($attend);
             
            }

          if($kaoqin_xs == 3){
                $where['week'] = $week;
                $where['gradeid'] = $grade;
                $where['schoolid'] = $schoolid;
                $where['type'] = $kaoqin_xs;
                $xs_del = M('attendancesetting')->where($where)->delete();

                 if($week== 0){
                    $where_week['type'] = $kaoqin_xs;
                    $where_week['schoolid'] = $schoolid;
                    $where_week['gradeid'] = $grade;
                    // $where_week['week'] = $week
                    $delweek = M('attendancesetting')->where($where_week)->delete();
                    $this->week($grade,$kaoqin_xs,$time_xs1,$time_xs2,$time_xs3,$stay);
                   // die();
                 }else{
                   $data['gradeid'] = $grade;
                  $data['type'] = $kaoqin_xs;
                  $data['week'] = $week;
                  $data['schoolid'] = $schoolid;
                  $data['begintime'] = $time_xs1;
                  $data['endtime'] = $time_xs2;
                  $data['latetime'] = $time_xs3;
                  $data['opt'] = 1;
                  $data['stay'] = $stay;
                  $attend = M('attendancesetting')->add($data); 
                 }

                 //echo "Dsadas";

                  
                 // var_dump($attend);
             
            }

            if($kaoqin_xf == 4){
                $where['week'] = $week;
                $where['gradeid'] = $grade;
                $where['schoolid'] = $schoolid;
                $where['type'] = $kaoqin_xf;
                $xf_del = M('attendancesetting')->where($where)->delete();


                 if($week== 0){
                  $where_week['type'] = $kaoqin_xf;
                  $where_week['schoolid'] = $schoolid;
                    $where_week['gradeid'] = $grade;
                    // $where_week['week'] = $week
                    $delweek = M('attendancesetting')->where($where_week)->delete();
                    $this->week($grade,$kaoqin_xf,$time_xf1,$time_xf2,$time_xf3,$stay);
                   // die();
                 }else{
                  $data['gradeid'] = $grade;
                  $data['type'] = $kaoqin_xf;
                  $data['week'] = $week;
                  $data['schoolid'] = $schoolid;
                  $data['begintime'] = $time_xf1;
                  $data['endtime'] = $time_xf2;
                  $data['latetime'] = $time_xf3;
                  $data['opt'] = 1;
                  $data['stay'] = $stay;
                  $attend = M('attendancesetting')->add($data);
                 }

             
            } 

            if($kaoqin_ws == 5){
                $where['week'] = $week;
                $where['gradeid'] = $grade;
                $where['schoolid'] = $schoolid;
                $where['type'] = $kaoqin_ws;
                $ws_del = M('attendancesetting')->where($where)->delete();



                 if($week== 0){
                  $where_week['type'] = $kaoqin_ws;
                  $where_week['schoolid'] = $schoolid;
                    $where_week['gradeid'] = $grade;
                    // $where_week['week'] = $week
                    $delweek = M('attendancesetting')->where($where_week)->delete();
                   

                    $this->week($grade,$kaoqin_ws,$time_ws1,$time_ws2,$time_ws3,$stay);
                 }else{
                   $data['gradeid'] = $grade;
                  $data['type'] = $kaoqin_ws;
                  $data['week'] = $week;
                  $data['schoolid'] = $schoolid;
                  $data['begintime'] = $time_ws1;
                  $data['endtime'] = $time_ws3;
                  $data['latetime'] = $time_ws3;
                  $data['opt'] = 1;
                  $data['stay'] = $stay;
                  $attend = M('attendancesetting')->add($data);
                 }


             
            }

            if($kaoqin_wf == 6){
                $where['week'] = $week;
                $where['gradeid'] = $grade;
                $where['schoolid'] = $schoolid;
                $where['type'] = $kaoqin_wf;
                $wf_del = M('attendancesetting')->where($where)->delete();
                 if($week== 0){
                  $where_week['type'] = $kaoqin_wf;
                    $where_week['schoolid'] = $schoolid;
                    $where_week['gradeid'] = $grade;
                    // $where_week['week'] = $week
                    $delweek = M('attendancesetting')->where($where_week)->delete();

                    $this->week($grade,$kaoqin_wf,$time_wf1,$time_wf2,$time_wf3,$stay);

                 }else{
                    $data['gradeid'] = $grade;
                  $data['type'] = $kaoqin_wf;
                  $data['week'] = $week;
                  $data['schoolid'] = $schoolid;
                  $data['begintime'] = $time_wf1;
                  $data['endtime'] = $time_wf3;
                  $data['latetime'] = $time_wf3;
                  $data['opt'] = 1;
                  $data['stay'] = $stay;
                  $attend = M('attendancesetting')->add($data);
                 }

             
            }        




        }
        $this->success("保存成功!");
      
    }
//TODO住校生 还没完善 还没加判断是否是住校生 
	function boarders_index_post(){
//        var_dump(I());die();
        //这里不用再做七条数据  其实读取的时候如果没找到的话就读取全周就好了
        // 类型  1非住校生, 2住校
        $schoolid = $_SESSION['schoolid'];
        
        $grade = I('school');
        //var_dump($grade);
        //exit();
         $stay = 1;
          $week = I('week');
       //早上上学
       $kaoqin_ss = I('kaoqin_ss');
       // var_dump($kaoqin_ss);
       $time_ss1 = I('time_ss1');
       //var_dump($time_ss1);
       $time_ss2 = I('time_ss2');
       //var_dump($time_ss2);
       $time_ss3 = I('time_ss3');
       //var_dump($time_ss3);
       // exit();
       //早上放学
        $kaoqin_sf = I('kaoqin_sf');
        
        //var_dump($kaoqin_sf);
       
        $time_sf1 = I('time_sf1');
        $time_sf2 = I('time_sf2');
        $time_sf3 = I('time_sf3');
       // exit();
        //下午上学
        $kaoqin_xs = I('kaoqin_xs');
        
        $time_xs1 = I('time_xs1');
        $time_xs2 = I('time_xs2');
        $time_xs3 = I('time_xs3');
        //var_dump($kaoqin_xs);
        //下午放学
        $kaoqin_xf = I('kaoqin_xf');
         // var_dump($kaoqin_xf);
         // exit();
         $time_xf1 = I('time_xf1');
         $time_xf2 = I('time_xf2');
         $time_xf3 = I('time_xf3');


        //var_dump($kaoqin_xf);
        //晚上上学
        $kaoqin_ws = I('kaoqin_ws');

        $time_ws1 = I('time_ws1');
        $time_ws2 = I('time_ws2');
        $time_ws3 = I('time_ws3');
        
        //var_dump($kaoqin_ws);
        //晚上放学
        $kaoqin_wf = I('kaoqin_wf');

        $time_wf1 = I('time_wf1');
        $time_wf2 = I('time_wf2');
        $time_wf3 = I('time_wf3');
          //var_dump($kaoqin_wf); 
        
           //var_dump(date('w'));
           // var_dump($week);
 // exit();
        // if ($week == 0) {
        //     echo "Dasdsa";
        // }
        $school_grade = M('school_grade')->where("schoolid = $schoolid")->order("id ASC")->select();
           //如果为全校
        if ($grade == 0) {

          //  $school_grade = M('school_grade')->where("schoolid = $schoolid")->order("id ASC")->select();
            //并且又为全周 循环全年段和全周
           if ($week == 0) {
             
              //$weeks = count($school_grade)*7;
             //删除该学校的所有年级考勤再添加
             $del = M('attendancesetting')->where("schoolid = $schoolid and stay = $stay")->delete();
             //exit();    
              //从礼拜一到礼拜日
              for ($i=1; $i <= 7; $i++) { 
                  //$list = array();
                     $list = array();
                   //如果其中选中了上午放学     一下以此类推
                   if ($kaoqin_ss == 1) {
                       foreach ($school_grade as $key => $value) {
                      $list = $value['gradeid'];

                      $data['week'] =$i;

                      $data['gradeid'] = $list;
                      
                      $data['schoolid'] = $schoolid;

                      $data['type'] = $kaoqin_ss;

                      $data['begintime'] = $time_ss1;

                      $data['endtime'] = $time_ss2;

                      $data['latetime'] = $time_ss3;

                      $data['opt'] = 1;

                      $data['stay'] = $stay;

                      $attend = M('attendancesetting')->add($data);
                     
                     }   
                   }


                   if($kaoqin_sf == 2){

                        foreach ($school_grade as $key => $value) {
                      $list = $value['gradeid'];

                      $data['week'] =$i;

                      $data['gradeid'] = $list;
                      
                      $data['schoolid'] = $schoolid;

                      $data['type'] = $kaoqin_sf;

                      $data['begintime'] = $time_sf1;
                      
                      $data['endtime'] = $time_sf2;

                      $data['latetime'] = $time_sf3;

                      $data['opt'] = 1;

                      $data['stay'] = $stay;

                      $attend = M('attendancesetting')->add($data);
                     
                     }
                  }
                
                     
                   if($kaoqin_xs == 3){

                    foreach ($school_grade as $key => $value) {
                      $list = $value['gradeid'];

                      $data['week'] =$i;

                      $data['gradeid'] = $list;
                      
                      $data['schoolid'] = $schoolid;

                      $data['type'] = $kaoqin_xs;

                      $data['begintime'] = $time_xs1;
                      
                      $data['endtime'] = $time_xs2;

                      $data['latetime'] = $time_xs3;

                      $data['opt'] = 1;

                      $data['stay'] = $stay;

                      $attend = M('attendancesetting')->add($data);
                     
                     }


                   }

                   if($kaoqin_xf == 4){

                 foreach ($school_grade as $key => $value) {
                      $list = $value['gradeid'];

                      $data['week'] =$i;

                      $data['gradeid'] = $list;
                      
                      $data['schoolid'] = $schoolid;

                      $data['type'] = $kaoqin_xf;

                      $data['begintime'] = $time_xf1;
                      
                      $data['endtime'] = $time_xf2;

                      $data['latetime'] = $time_xf3;

                      $data['opt'] = 1;

                      $data['stay'] = $stay;

                      $attend = M('attendancesetting')->add($data);
                     
                     }


                   }

                   if($kaoqin_ws == 5){

                  foreach ($school_grade as $key => $value) {
                      $list = $value['gradeid'];

                      $data['week'] =$i;

                      $data['gradeid'] = $list;
                      
                      $data['schoolid'] = $schoolid;

                      $data['type'] = $kaoqin_ws;

                      $data['begintime'] = $time_ws1;
                      
                      $data['endtime'] = $time_ws2;

                      $data['latetime'] = $time_ws3;

                      $data['opt'] = 1;

                      $data['stay'] = $stay;

                      $attend = M('attendancesetting')->add($data);
                     
                     }


                   }



                   if($kaoqin_wf == 6){

                foreach ($school_grade as $key => $value) {
                      $list = $value['gradeid'];

                      $data['week'] =$i;

                      $data['gradeid'] = $list;
                      
                      $data['schoolid'] = $schoolid;

                      $data['type'] = $kaoqin_wf;

                      $data['begintime'] = $time_wf1;
                      
                      $data['endtime'] = $time_wf2;

                      $data['latetime'] = $time_wf3;

                      $data['opt'] = 1;

                      $data['stay'] = $stay;

                      $attend = M('attendancesetting')->add($data);
                     
                      }


                    }

              
              }
           
    

           }
            
                //如果选中了全年级和单日开始判定 
                switch ($week) {                                            
                    case '1':
                   if($kaoqin_ss == 1){
                    //去调用下公共方法
                     $this->days($kaoqin_ss,$week,$stay); 
                   }

                   if($kaoqin_sf == 2){

                    $this->days($kaoqin_sf,$week,$stay); 
                   }
                   if($kaoqin_xs==3){
                    $this->days($kaoqin_xs,$week,$stay); 
                   }
                   if($kaoqin_xf == 4){
                   $this->days($kaoqin_xf,$week,$stay);
                   }
                   if ($kaoqin_ws == 5) {
                       $this->days($kaoqin_ws,$week,$stay);
                   }
                   if($kaoqin_wf == 6){
                    $this->days($kaoqin_wf,$week,$stay);
                   }
                        break;
                    case '2':
                   if($kaoqin_ss == 1){
                    //echo "我成功了1";
                     $this->days($kaoqin_ss,$week,$stay); 

                    // echo "我成功了1";
                     //exit();
                   }

                   if($kaoqin_sf == 2){
                    
                    $this->days($kaoqin_sf,$week,$stay); 
                   // echo "我成功了2";
                   }
                   if($kaoqin_xs==3){
                    $this->days($kaoqin_xs,$week,$stay); 
                   }
                   if($kaoqin_xf == 4){
                   $this->days($kaoqin_xf,$week);
                   }
                   if ($kaoqin_ws == 5) {
                       $this->days($kaoqin_ws,$week,$stay);
                   }
                   if($kaoqin_wf == 6){
                    $this->days($kaoqin_wf,$week,$stay);
                   }
                        break;
                     case '3':
                      // echo"最前面成功的";
                   if($kaoqin_ss == 1){
                    //echo "我成功了1";
                     $this->days($kaoqin_ss,$week,$stay); 

                    // echo "我成功了1";
                     //exit();
                   }

                   if($kaoqin_sf == 2){

                    $this->days($kaoqin_sf,$week,$stay); 
                    //echo "我成功了2";
                   }
                   if($kaoqin_xs==3){
                    $this->days($kaoqin_xs,$week,$stay); 
                   }
                   if($kaoqin_xf == 4){
                   $this->days($kaoqin_xf,$week);
                   }
                   if ($kaoqin_ws == 5) {
                       $this->days($kaoqin_ws,$week,$stay);
                   }
                   if($kaoqin_wf == 6){
                    $this->days($kaoqin_wf,$week,$stay);
                   }
                        break;
                     case '4':
                   if($kaoqin_ss == 1){
                     $this->days($kaoqin_ss,$week,$stay); 
                   }

                   if($kaoqin_sf == 2){
                    $this->days($kaoqin_sf,$week,$stay); 
                   }
                   if($kaoqin_xs==3){
                    $this->days($kaoqin_xs,$week,$stay); 
                   }
                   if($kaoqin_xf == 4){
                   $this->days($kaoqin_xf,$week,$stay);
                   }
                   if ($kaoqin_ws == 5) {
                       $this->days($kaoqin_ws,$week,$stay);
                   }
                   if($kaoqin_wf == 6){
                    $this->days($kaoqin_wf,$week,$stay);
                   }
                        break;
                 case '5':
                   if($kaoqin_ss == 1){
                     $this->days($kaoqin_ss,$week,$stay); 

                   }

                   if($kaoqin_sf == 2){

                    $this->days($kaoqin_sf,$week,$stay); 
                  
                   }
                   if($kaoqin_xs==3){
                    $this->days($kaoqin_xs,$week,$stay); 
                   }
                   if($kaoqin_xf == 4){
                   $this->days($kaoqin_xf,$week,$stay);
                   }
                   if ($kaoqin_ws == 5) {
                       $this->days($kaoqin_ws,$week,$stay);
                   }
                   if($kaoqin_wf == 6){
                    $this->days($kaoqin_wf,$week,$stay);
                   }
                        break;
                  case '6':
                     
                   if($kaoqin_ss == 1){
                    //echo "我成功了1";
                     $this->days($kaoqin_ss,$week,$stay); 

                   }

                   if($kaoqin_sf == 2){

                    $this->days($kaoqin_sf,$week,$stay); 
                    //echo "我成功了2";
                   }
                   if($kaoqin_xs==3){
                    $this->days($kaoqin_xs,$week,$stay); 
                   }
                   if($kaoqin_xf == 4){
                   $this->days($kaoqin_xf,$week,$stay);
                   }
                   if ($kaoqin_ws == 5) {
                       $this->days($kaoqin_ws,$week,$stay);
                   }
                   if($kaoqin_wf == 6){
                    $this->days($kaoqin_wf,$week,$stay);
                   }
                        break;

                case '7':
                      // echo"最前面成功的";
                   if($kaoqin_ss == 1){
                    //echo "我成功了1";
                     $this->days($kaoqin_ss,$week,$stay); 

                   }

                   if($kaoqin_sf == 2){

                    $this->days($kaoqin_sf,$week,$stay); 
                   // echo "我成功了2";
                   }
                   if($kaoqin_xs==3){
                    $this->days($kaoqin_xs,$week,$stay); 
                   }
                   if($kaoqin_xf == 4){
                   $this->days($kaoqin_xf,$week,$stay);
                   }
                   if ($kaoqin_ws == 5) {
                       $this->days($kaoqin_ws,$week,$stay);
                   }
                   if($kaoqin_wf == 6){
                    $this->days($kaoqin_wf,$week,$stay);
                   }
                        break;
                    
                    default:
                        # code...
                        break;
                }
              
         
            
           
        
        }else{
              //否则选中单日和单个年级
            if($kaoqin_ss == 1){
                 $where['week'] = $week;
                 $where['gradeid'] = $grade;
                 $where['schoolid'] = $schoolid;
                 $where['type'] = $kaoqin_ss;
                 $ss_del = M('attendancesetting')->where($where)->delete();

                 if($week == 0){

                    $where_week['type'] = $kaoqin_ss;
                    $where_week['schoolid'] = $schoolid;
                    $where_week['gradeid'] = $grade;
                    $delweek = M('attendancesetting')->where($where_week)->delete();
                
                    $this->week($grade,$kaoqin_ss,$time_ss1,$time_ss2,$time_ss3,$stay);
                  // return;
                 }else{


               
                 //echo "Dsadas";

                  $data['gradeid'] = $grade;
                  $data['type'] = $kaoqin_ss;
                  $data['week'] = $week;
                  $data['schoolid'] = $schoolid;
                  $data['begintime'] = $time_ss1;
                  $data['endtime'] = $time_ss2;
                  $data['latetime'] = $time_ss3;
                  $data['opt'] = 1;
                  $data['stay'] = $stay;
                  $attend = M('attendancesetting')->add($data);
                 }    // var_dump($attend);
             
            }
         
         if($kaoqin_sf == 2){
                 $where['week'] = $week;
                 $where['gradeid'] = $grade;
                 $where['schoolid'] = $schoolid;
                 $where['type'] = $kaoqin_sf;
               $sf_del = M('attendancesetting')->where($where)->delete();

                 if($week== 0){
                    $where_week['type'] = $kaoqin_sf;
                    $where_week['schoolid'] = $schoolid;
                    $where_week['gradeid'] = $grade;
                    // $where_week['week'] = $week
                    $delweek = M('attendancesetting')->where($where_week)->delete();
                    //var_dump($delweek);
                    $this->week($grade,$kaoqin_sf,$time_sf1,$time_sf2,$time_sf3,$stay);
                    
                 }else{

                 //echo "Dsadas";

                  $data['gradeid'] = $grade;
                  $data['type'] = $kaoqin_sf;
                  $data['week'] = $week;
                  $data['schoolid'] = $schoolid;
                  $data['begintime'] = $time_sf1;
                  $data['endtime'] = $time_sf2;
                  $data['latetime'] = $time_sf3;
                  $data['opt'] = 1;
                  $data['stay'] = $stay;
                  $attend = M('attendancesetting')->add($data);
               }   // var_dump($attend);
             
            }

          if($kaoqin_xs == 3){
                $where['week'] = $week;
                $where['gradeid'] = $grade;
                $where['schoolid'] = $schoolid;
                $where['type'] = $kaoqin_xs;
                $data['opt'] = 1;
                $xs_del = M('attendancesetting')->where($where)->delete();

                 if($week== 0){
                   $where_week['type'] = $kaoqin_xs;
                    $where_week['schoolid'] = $schoolid;
                    $where_week['gradeid'] = $grade;
                    // $where_week['week'] = $week
                    $delweek = M('attendancesetting')->where($where_week)->delete();
                    $this->week($grade,$kaoqin_xs,$time_xs1,$time_xs2,$time_xs3,$stay);
                   // die();
                 }else{
                   $data['gradeid'] = $grade;
                  $data['type'] = $kaoqin_xs;
                  $data['week'] = $week;
                  $data['schoolid'] = $schoolid;
                  $data['begintime'] = $time_xs1;
                  $data['endtime'] = $time_xs2;
                  $data['latetime'] = $time_xs3;
                  $data['opt'] = 1;
                  $data['stay'] = $stay;
                  $attend = M('attendancesetting')->add($data); 
                 }

                 //echo "Dsadas";

                  
                 // var_dump($attend);
             
            }

            if($kaoqin_xf == 4){
                $where['week'] = $week;
                $where['gradeid'] = $grade;
                $where['schoolid'] = $schoolid;
                $where['type'] = $kaoqin_xf;
                $xf_del = M('attendancesetting')->where($where)->delete();


                 if($week== 0){
                    $where_week['type'] = $kaoqin_xf;
                    $where_week['schoolid'] = $schoolid;
                    $where_week['gradeid'] = $grade;
                    // $where_week['week'] = $week
                    $delweek = M('attendancesetting')->where($where_week)->delete();
                    $this->week($grade,$kaoqin_xf,$time_xf1,$time_xf2,$time_xf3);
                   // die();
                 }else{
                  $data['gradeid'] = $grade;
                  $data['type'] = $kaoqin_xf;
                  $data['week'] = $week;
                  $data['schoolid'] = $schoolid;
                  $data['begintime'] = $time_xf1;
                  $data['endtime'] = $time_xf2;
                  $data['latetime'] = $time_xf3;
                  $data['opt'] = 1;
                  $data['stay'] = $stay;
                  $attend = M('attendancesetting')->add($data);
                 }

                 //echo "Dsadas";

                 
                 // var_dump($attend);
             
            } 

            if($kaoqin_ws == 5){
                $where['week'] = $week;
                $where['gradeid'] = $grade;
                $where['schoolid'] = $schoolid;
                $where['type'] = $kaoqin_ws;
                $ws_del = M('attendancesetting')->where($where)->delete();



                 if($week== 0){
                    $where_week['type'] = $kaoqin_ws;
                    $where_week['schoolid'] = $schoolid;
                    $where_week['gradeid'] = $grade;
                    // $where_week['week'] = $week
                    $delweek = M('attendancesetting')->where($where_week)->delete();
                    $this->week($grade,$kaoqin_ws,$time_ws1,$time_ws2,$time_ws3,$stay);
                    //die();
                 }else{
                   $data['gradeid'] = $grade;
                  $data['type'] = $kaoqin_ws;
                  $data['week'] = $week;
                  $data['schoolid'] = $schoolid;
                  $data['begintime'] = $time_ws1;
                  $data['endtime'] = $time_ws3;
                  $data['latetime'] = $time_ws3;
                  $data['opt'] = 1;
                  $data['stay'] = $stay;
                  $attend = M('attendancesetting')->add($data);
                 }

                 //echo "Dsadas";

                  
                 // var_dump($attend);
             
            }

            if($kaoqin_wf == 6){
                $where['week'] = $week;
                $where['gradeid'] = $grade;
                $where['schoolid'] = $schoolid;
                $where['type'] = $kaoqin_wf;
                $wf_del = M('attendancesetting')->where($where)->delete();
                 if($week== 0){
                  $where_week['type'] = $kaoqin_wf;
                   $where_week['schoolid'] = $schoolid;
                    $where_week['gradeid'] = $grade;
                    // $where_week['week'] = $week
                    $delweek = M('attendancesetting')->where($where_week)->delete();
                    $this->week($grade,$kaoqin_wf,$time_wf1,$time_wf2,$time_wf3);
                    //die();
                 }else{
                    $data['gradeid'] = $grade;
                  $data['type'] = $kaoqin_wf;
                  $data['week'] = $week;
                  $data['schoolid'] = $schoolid;
                  $data['begintime'] = $time_wf1;
                  $data['endtime'] = $time_wf3;
                  $data['latetime'] = $time_wf3;
                  $data['opt'] = 1;
                  $data['stay'] = $stay;
                  $attend = M('attendancesetting')->add($data);
                 }

                 //echo "Dsadas";

                  
                 // var_dump($attend);
             
            }        




        }
        $this->success("保存成功!");
        
    }
 

 

     //如果为全校年级但时间为单日

    public function days($kaoqin,$week,$stay)

    {     
        $schoolid = $_SESSION['schoolid'];

           $where['type'] = $kaoqin;

           $where['week'] = $week;

           $where['schoolid'] = $schoolid;

           $day_del = M('attendancesetting')->where($where)->delete();


            $school_grade = M('school_grade')->where("schoolid = $schoolid")->select();


         if ($kaoqin == 1) {
                    foreach ($school_grade as $key => $value) {
                     // $list = $value['gradeid'];

                      $data['week'] =$week;

                      $data['gradeid'] = $value['gradeid'];
                      
                      $data['schoolid'] = $schoolid;

                      $data['type'] = $kaoqin;

                      $data['opt'] = 1;

                      $data['stay'] = $stay;

                      $attend = M('attendancesetting')->add($data);
                     
                     }   
                   }


          if($kaoqin == 2){

                 foreach ($school_grade as $key => $value) {
                      
                      //$list = $value['gradeid'];

                      $data['week'] =$week;

                      $data['gradeid'] = $value['gradeid'];
                      
                      $data['schoolid'] = $schoolid;

                      $data['type'] = $kaoqin;

                      $data['opt'] = 1;

                      $data['stay'] = $stay;

                      $attend = M('attendancesetting')->add($data);
                     
                     }

                
                     
            if($kaoqin == 3){

                foreach ($school_grade as $key => $value) {
                     // $list = $value['gradeid'];

                      $data['week'] =$week;

                      $data['gradeid'] = $value['gradeid'];
                      
                      $data['schoolid'] = $schoolid;

                      $data['type'] = $kaoqin;

                      $data['opt'] = 1;

                      $data['stay'] = $stay;

                      $attend = M('attendancesetting')->add($data);
                     
                     }


                   }

                   if($kaoqin == 4){

                 foreach ($school_grade as $key => $value) {
                      //$list = $value['gradeid'];

                      $data['week'] =$week;

                      $data['gradeid'] = $value['gradeid'];
                      
                      $data['schoolid'] = $schoolid;

                      $data['type'] = $kaoqin;

                      $data['opt'] = 1;

                      $data['stay'] = $stay;

                      $attend = M('attendancesetting')->add($data);
                     
                     }


                   }

                   if($kaoqin == 5){

                        foreach ($school_grade as $key => $value) {
                    //  $list = $value['gradeid'];

                      $data['week'] =$week;

                      $data['gradeid'] = $value['gradeid'];
                      
                      $data['schoolid'] = $schoolid;

                      $data['type'] = $kaoqin;

                      $data['opt'] = 1;

                      $data['stay'] = $stay;

                      $attend = M('attendancesetting')->add($data);
                     
                     }


                   }



                   if($kaoqin == 6){

                foreach ($school_grade as $key => $value) {
                     // $list = $value['gradeid'];

                      $data['week'] =$week;

                      $data['gradeid'] = $value['gradeid'];
                      
                      $data['schoolid'] = $schoolid;

                      $data['type'] = $kaoqin;

                      $data['opt'] = 1;

                      $data['stay'] = $stay;

                      $attend = M('attendancesetting')->add($data);
                     
                      }


              }

         }
         $this->success("保存成功!");

   }



  //如果为全周的话调用下面的

   public function week($gradeid,$type,$begintime,$endtime,$latetime,$stay)
   {
       
       $schoolid = $_SESSION['schoolid'];
        
       //  $where['gradeid'] = $gradeid;
       //  $where['type'] = $type;
       //  $where['schoolid'] =$schoolid; 
       // $delweek = M('attendancesetting')->where($where)->delete();  
       
       for ($i=1; $i <= 7; $i++)  
       {  
          //var_dump($i);
          $data['gradeid'] = $gradeid;
          $data['type'] = $type;
          $data['week'] = $i;
         // var_dump($data['week']);
          $data['schoolid'] = $schoolid;
          $data['begintime'] = $begintime;
          $data['endtime'] = $endtime;
          $data['latetime'] = $latetime;
          $data['opt'] = 1;
          $data['stay'] = $stay;
          $attend = M('attendancesetting')->add($data);
          
       }
       //die();


   
   }

   public function  getAttendance()
   {

     $schoolid = $_SESSION['schoolid'];

     $gradeid = I('classid');
     
     $week = I('week');

    if(!$week)
    {
       $week = 1;
    } 

     
     $stay = I('stay'); 
     //var_dump($stay);
     //var_dump($classid);
    $where['gradeid'] = $gradeid;

      $where['week'] = $week;
     //var_dump($week);     
     
     $where['schoolid'] = $schoolid;   

     $where['stay'] = $stay;

     $attend =  M('attendancesetting')->where($where)->select();
     //var_dump($attend);      
    if ($attend) {
                    $info['status'] = true;
                    $info['msg'] = $attend;
                } else {
                    $info['status'] = false;
                    $info['msg'] = '404';
                }
            echo json_encode($info);


   


     //exit();



   }

    function format_ret($status, $data = '')
    {
        if ($status) {
            //成功
            return array('status' => 'success', 'data' => $data);
        } else {
            //验证失败
            return array('status' => 'error', 'data' => $data);
        }
    }

}