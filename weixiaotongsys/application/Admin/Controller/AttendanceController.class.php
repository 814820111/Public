<?php

/**
 * 后台首页  考勤
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
header("Content-type: text/html; charset=utf-8");
class AttendanceController extends AdminbaseController {


    function _initialize() {
        parent::_initialize();
    }
    //考勤首页
    public function index() {
        echo "考勤";
    }
    public function attendanceStatistics(){
        $Province=role_admin();

        $this->assign("Province",$Province);
//        echo "考勤统计：能看班级学生人数，打卡学生记录，未打卡学生记录，迟到打卡记录";
        $this->display("attendanceStatistics");
    }

    function getClass(){
        $schoolid = I("id");
        $class = M("school_class")->where(array("schoolid"=>$schoolid))->field("id,classname")->select();
        if ($class){
            $ret = format_ret(1,$class);
            echo json_encode($ret);
        }else{
            $ret = format_ret(0,"parms lost");
            echo json_encode($ret);
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
    //获取学生的到校时间和离校时间
//    function getTime(){
//      //todo星期一想
//
//        //查询时间
//        $begin_time  = I("begin_time");
//
//        dump($begin_time);
//
//        $end_time  = I("end_time");
//        dump($end_time);
//        $schoolid= I("schoolid");
//        $classid = I("classid");
//
//        $where_stu['schoolid'] = $schoolid;
//
//        if($classid)
//        {
//            $where_stu['classid'] = $classid;
//        }
//
//
//
//
//        //获取学生列表
//        $stu_list = M("class_relationship")->where($where_stu)->select();
//
//
//
//        $stu_count = M("class_relationship")->where($where_stu)->count();
//
//// dump($stu_list);
//
//        $stu_userid = '';
//        //循环出来用户的信息
//        for ($i=0;$i<count($stu_list);$i++){
//            $stu_userid .= $stu_list[$i]["userid"].",";
//        }
//        $stu_userid = substr($stu_userid,0,-1);
////        echo $stu_userid;
//
//        if ($stu_list) {
//            //查询学生的信息
//            $stu_info = M("wxtuser as user")
//                ->where("user.id in($stu_userid)")->field("id,name")->select();
//        }
//          // var_dump($stu_info);
//        //执行循环判断然后入栈
//            //考勤记录为主表 考勤设置为辅表
//        for ($i=0;$i<count($stu_info);$i++){
//            //获取学生id 然后班级id是已知的 学校id也是已知的
//            //读取考勤记录 配合考勤时间
//            $attendance["userid"] = $stu_info[$i]['id'];
//            $attendance["arrivedate"] =  array(array('EGT',$begin_time),array('ELT',$end_time));
//            // $attendance['arrivetime']= array("elt",$tendtime);
//            $list = M("attendances")->where($attendance)->distinct("arrivetime")->order("arrivetime DESC")->select();
//
//            dump($list);
//
//
//            foreach ($list as  $value) {
//
//                if($value['attendancetype']==1)
//                {
//                  $stu_info[$i]['m_attend'] = $value['arrivetime'];
//                }
//                 if($value['attendancetype']==2)
//                {
//                  $stu_info[$i]['m_lattend'] = $value['arrivetime'];
//                }
//                 if($value['attendancetype']==3)
//                {
//                  $stu_info[$i]['a_attend'] = $value['arrivetime'];
//                }
//                 if($value['attendancetype']==4)
//                {
//                  $stu_info[$i]['a_lattend'] = $value['arrivetime'];
//                }
//                 if($value['attendancetype']==5)
//                {
//                  $stu_info[$i]['n_attend'] = $value['arrivetime'];
//                }
//                 if($value['attendancetype']==6)
//                {
//                  $stu_info[$i]['n_lattend'] = $value['arrivetime'];
//                }
//
//
//            }
//            //查到学生的最新两条然后查询都是否符合条件
//                // $leatime = $list[1]['arrivetime'];
//                // // var_dump(expression)
//                // $arrtime = $list[0]['arrivetime'];
//
//            //开始查看是否在这个时间段之内 如果只有一条的话就显示一条 如果多条的话就显示多条
//            //判断学生的打卡是不是都是今天的打卡
//            // $sertime = array($arrtime,$leatime);
//            //var_dump($sertime);
//            // sort($sertime);//序列化数组
//            // //开始查询时间 查询这时间是否都在时间段之内
//            // if ($sertime[1] >=$tbtim && $sertime[1]<=$tendtime){
//            //     $stu_info[$i]["last"] = $sertime[1];
//            // }else{
//            //     $stu_info[$i]["last"] = "";
//            // }
//            // if ($sertime[0] >=$tbtim && $sertime[0]<=$tendtime){
//            //     $stu_info[$i]['first'] = $sertime[0];
//            // }else{
//            //     $stu_info[$i]['first'] = "";
//            // }
//            //还是判断是否有时间传过来
////            echo M("attendances")->getLastSql();
//            //查出来考勤记录
//        }
//
//         dump($stu_info);
////        echo M("wxtuser as user")->getLastSql();
//        if (!empty($stu_info)){
//           $ret = $this->format_ret(1,$stu_info);
//           echo json_encode($stu_info);
//        }else{
//            $ret = $this->format_ret(0,"parms lost");
//            echo json_encode($ret);
//        }
//
//
//    }
    function getTime(){


        //查询时间
        $begin_time  = I("begin_time");

//        dump($begin_time);

        $end_time  = I("end_time");
//        dump($end_time);
        $schoolid= I("schoolid");
        $classid = I("classid");

        $where_stu['schoolid'] = $schoolid;

        if($classid)
        {
            $where_stu['classid'] = $classid;
            $attendance["classid"] = $classid;
        }

        if($begin_time && $end_time)
        {
            $attendance["arrivedate"] =  array(array('EGT',$begin_time),array('ELT',$end_time));
        }else{
            $attendance["arrivedate"] = date('Y-m-d',time());
        }

        $attendance['schoolid'] = $schoolid;








        //获取学生列表
        $stu_list = M("class_relationship")->where($where_stu)->select();




        $stu_count = M("class_relationship")->where($where_stu)->count();

        $list = M("attendances")->where($attendance)->distinct("arrivetime")->order("arrivetime DESC")->select();

//        dump($list);



        $stu_userid = '';
        //循环出来用户的信息
        for ($i=0;$i<count($stu_list);$i++){
            $stu_userid .= $stu_list[$i]["userid"].",";
        }
        $stu_userid = substr($stu_userid,0,-1);

        if ($stu_list) {
            //查询学生的信息
            $stu_info = M("wxtuser as user")
                ->where("user.id in($stu_userid)")->field("id,name")->select();
        }




//        $array = array();
        //处理数组+
        foreach ($stu_info as $key=>$value)
        {
            foreach ($list as $val)
            {

                if($value['id']==$val['userid'])
                {

//                     array_push($array,$val);
                    $array[] = $val;
                     $this->get_attend($value,$array);

                }


            }
//            dump($array);

            $res = $this->get_attend($value,$array);


            if($res)
            {
                unset($array);
                unset($stu_info[$key]);

                foreach ($res as $val)
                {

                    array_push($stu_info,$val);
                }
            }




        }



        // var_dump($stu_info);
        //执行循环判断然后入栈
        //考勤记录为主表 考勤设置为辅表
//        for ($i=0;$i<count($stu_info);$i++){
//            //获取学生id 然后班级id是已知的 学校id也是已知的
//            //读取考勤记录 配合考勤时间
//            $attendance["userid"] = $stu_info[$i]['id'];
//            $attendance["arrivedate"] =  array(array('EGT',$begin_time),array('ELT',$end_time));
//            // $attendance['arrivetime']= array("elt",$tendtime);
//            $list = M("attendances")->where($attendance)->distinct("arrivetime")->order("arrivetime DESC")->select();
//
//
//
//
//            foreach ($list as  $value) {
//
//                if($value['attendancetype']==1)
//                {
//                    $stu_info[$i]['m_attend'] = $value['arrivetime'];
//                }
//                if($value['attendancetype']==2)
//                {
//                    $stu_info[$i]['m_lattend'] = $value['arrivetime'];
//                }
//                if($value['attendancetype']==3)
//                {
//                    $stu_info[$i]['a_attend'] = $value['arrivetime'];
//                }
//                if($value['attendancetype']==4)
//                {
//                    $stu_info[$i]['a_lattend'] = $value['arrivetime'];
//                }
//                if($value['attendancetype']==5)
//                {
//                    $stu_info[$i]['n_attend'] = $value['arrivetime'];
//                }
//                if($value['attendancetype']==6)
//                {
//                    $stu_info[$i]['n_lattend'] = $value['arrivetime'];
//                }
//
//
//            }
            //查到学生的最新两条然后查询都是否符合条件
            // $leatime = $list[1]['arrivetime'];
            // // var_dump(expression)
            // $arrtime = $list[0]['arrivetime'];

            //开始查看是否在这个时间段之内 如果只有一条的话就显示一条 如果多条的话就显示多条
            //判断学生的打卡是不是都是今天的打卡
            // $sertime = array($arrtime,$leatime);
            //var_dump($sertime);
            // sort($sertime);//序列化数组
            // //开始查询时间 查询这时间是否都在时间段之内
            // if ($sertime[1] >=$tbtim && $sertime[1]<=$tendtime){
            //     $stu_info[$i]["last"] = $sertime[1];
            // }else{
            //     $stu_info[$i]["last"] = "";
            // }
            // if ($sertime[0] >=$tbtim && $sertime[0]<=$tendtime){
            //     $stu_info[$i]['first'] = $sertime[0];
            // }else{
            //     $stu_info[$i]['first'] = "";
            // }
            //还是判断是否有时间传过来
//            echo M("attendances")->getLastSql();
            //查出来考勤记录
//        }



           $stu_info = array_values($stu_info);



        if (!empty($stu_info)){
            $ret = $this->format_ret(1,$stu_info);
            echo json_encode($stu_info);
        }else{
            $ret = $this->format_ret(0,"parms lost");
            echo json_encode($ret);
        }


    }

    //获取该学生的考勤
    public function get_attend($student,$attd)
    {
        $arr = array();

        if($attd)
        {

          $result =  $this->array_group_by($attd);
           foreach ($result as $key=>&$attr)
           {

                foreach ($attr as $k=>$val)
                {

                    array_push($arr,$val);

                    unset($attr[$k]);

                }
               array_push($result[$key],$student);

               foreach ($arr as $v)
               {

                   if($v['arrivedate']==$key) {

                       if ($v['attendancetype'] == 1) {
                           foreach ($attr as $ke=>$vas)
                           {
//                               array_push($attr[$ke],111);
                              $attr[$ke]['m_attend'] = $v['arrivetime'];
                           }

                       }
                       if ($v['attendancetype'] == 2) {
                           foreach ($attr as $ke=>$vas)
                           {
                               $attr[$ke]['m_lattend'] = $v['arrivetime'];
                           }
                       }
                       if ($v['attendancetype'] == 3) {
                           foreach ($attr as $ke=>$vas)
                           {
                               $attr[$ke]['a_attend'] = $v['arrivetime'];
                           }
                       }
                       if ($v['attendancetype'] == 4) {
                           foreach ($attr as $ke=>$vas)
                           {
                               $attr[$ke]['a_lattend'] = $v['arrivetime'];
                           }
                       }
                       if ($v['attendancetype'] == 5) {
                           foreach ($attr as $ke=>$vas)
                           {
                               $attr[$ke]['n_attend'] = $v['arrivetime'];
                           }
                       }
                       if ($v['attendancetype'] == 6) {
                           foreach ($attr as $ke=>$vas)
                           {
                               $attr[$ke]['n_lattend'] = $v['arrivetime'];
                           }
                       }
                   }
               }


           }
        }
//        dump($result);

        return $this->down_arr($result);
         exit();
    }

    //降维数组
    public function down_arr($arr)
    {


        foreach ($arr as $key=>$val)
        {
            foreach ($val as &$v)
            {
                $v['arrivedate'] = $key;
                $new_arr[] = $v;
            }
        }

        return $new_arr;

    }

    //同类分组
    public function array_group_by($array)
    {

        $result =   array();
        foreach($array as $k=>$v){
            $result[$v['arrivedate']][]    =   $v;
        }

        return $result;
    }


    public function Lexcel()
    {
        //查询时间
//        $settime = I("time");
//
//        $schoolid= I("schoolid");
//        $classid = I("classid");
//        $where_stu['schoolid'] = $schoolid;
//
//        if ($classid)
//        {
//            $where_stu['classid'] = $classid;
//        }

        //查询时间
        $begin_time  = I("begin_time");

//        dump($begin_time);

        $end_time  = I("end_time");
//        dump($end_time);
        $schoolid= I("schoolid");
        $classid = I("classid");

        $where_stu['schoolid'] = $schoolid;

        if($classid)
        {
            $where_stu['classid'] = $classid;
            $attendance["classid"] = $classid;
        }

        if($begin_time && $end_time)
        {
            $attendance["arrivedate"] =  array(array('EGT',$begin_time),array('ELT',$end_time));
        }else{
            $attendance["arrivedate"] = date('Y-m-d',time());
        }






        //获取学生列表
        $stu_list = M("class_relationship")->where($where_stu)->select();




        $stu_count = M("class_relationship")->where($where_stu)->count();

        $list = M("attendances")->where($attendance)->distinct("arrivetime")->order("arrivetime DESC")->select();



// dump($stu_list);

        $stu_userid = '';
        //循环出来用户的信息
        for ($i=0;$i<count($stu_list);$i++){
            $stu_userid .= $stu_list[$i]["userid"].",";
        }
        $stu_userid = substr($stu_userid,0,-1);
//        echo $stu_userid;

        if ($stu_list) {
            //查询学生的信息
            $stu_info = M("student_info as info")
                ->where("info.userid in($stu_userid)")->join("wxt_school_class class ON info.classid=class.id")->field("info.userid as id,info.stu_name as name,class.classname")->select();
        }


        // var_dump($stu_info);
        //执行循环判断然后入栈
        //考勤记录为主表 考勤设置为辅表
//        for ($i=0;$i<count($stu_info);$i++){
//            //获取学生id 然后班级id是已知的 学校id也是已知的
//            //读取考勤记录 配合考勤时间
//            $attendance["userid"] = $stu_info[$i]['id'];
//            $attendance["arrivedate"] = $settime;
//            // $attendance['arrivetime']= array("elt",$tendtime);
//            $list = M("attendances")->where($attendance)->order("arrivetime DESC")->select();
//
//
//
//
//            foreach ($list as  $value) {
//
//                if($value['attendancetype']==1)
//                {
//                    $stu_info[$i]['m_attend'] = date('Y-m-d H:i:s',$value['arrivetime']);
//                }
//                if($value['attendancetype']==2)
//                {
//                    $stu_info[$i]['m_lattend'] = date('Y-m-d H:i:s',$value['arrivetime']);
//                }
//                if($value['attendancetype']==3)
//                {
//                    $stu_info[$i]['a_attend'] = date('Y-m-d H:i:s',$value['arrivetime']);
//                }
//                if($value['attendancetype']==4)
//                {
//                    $stu_info[$i]['a_lattend'] = date('Y-m-d H:i:s',$value['arrivetime']);
//                }
//                if($value['attendancetype']==5)
//                {
//                    $stu_info[$i]['n_attend'] = date('Y-m-d H:i:s',$value['arrivetime']);
//                }
//                if($value['attendancetype']==6)
//                {
//                    $stu_info[$i]['n_lattend'] = date('Y-m-d H:i:s',$value['arrivetime']);
//                }
//
//
//            }
//
//
//
//
//
//        }
        $array = array();
        //TODO 这里以后需要改进 卡号可以直接join一张表就可以不需要再循环查去查出学生的卡号
        foreach ($stu_info as $key=>&$value)
        {
            $userid = $value['id'];


            $card = M('student_card')->where("personId = $userid and cardType = 0 and handletype = 1")->getField("cardNo");

            $value['cardno'] = $card;

            foreach ($list as $val)
            {
                if($value['id']==$val['userid'])
                {

                    array_push($array,$val);
//                     $this->get_attend($value,$array);

                }


            }
            $res = $this->get_attend($value,$array);


            if($res)
            {
                unset($array);
                unset($stu_info[$key]);

                unset($array);
                foreach ($res as $val)
                {

                    array_push($stu_info,$val);
                }
            }


        }


        $ExceData =  $stu_info;




        vendor('PHPExcel.PHPExcel');
        $objPHPExcel = new \PHPExcel();
        //include './statics/PHPExcel/Classes/PHPExcel.php';
        //$objPHPExcel = new \PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Da")
            ->setLastModifiedBy("Da")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX,generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet(0)->setTitle("250");//标题
        $objPHPExcel->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);//单元格宽度
        $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setName('Arial');//设置字体
        $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(10);//设置字体大小
        $objPHPExcel->getActiveSheet(0)->setCellValue('A1',"班级");
        $objPHPExcel->getActiveSheet(0)->setCellValue('B1',"姓名");
        $objPHPExcel->getActiveSheet(0)->setCellValue('C1',"日期");
        $objPHPExcel->getActiveSheet(0)->setCellValue('D1',"IC卡号");
        $objPHPExcel->getActiveSheet(0)->setCellValue('E1',"上午到校时间");
        $objPHPExcel->getActiveSheet(0)->setCellValue('F1',"上午离校时间");
        $objPHPExcel->getActiveSheet(0)->setCellValue('G1',"下午到校时间");
        $objPHPExcel->getActiveSheet(0)->setCellValue('H1',"下午离校时间");
        $objPHPExcel->getActiveSheet(0)->setCellValue('I1',"晚上到校时间");
        $objPHPExcel->getActiveSheet(0)->setCellValue('J1',"晚上离校时间");
        $objPHPExcel->getActiveSheet(0)->setCellValue('K1',"IC卡发放详情");

        $Val = 2;
//        for($i=0 ;$i<count($ExceData) ;$i++){
        foreach ($ExceData as $cc){


            $objPHPExcel->getActiveSheet(0)->setCellValue('A' . $Val, $cc['classname']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('B' . $Val, $cc['name']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('C' . $Val,' '.$cc['arrivedate']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('D' . $Val,' '.$cc['cardno']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('E' . $Val, $cc['m_attend']==""?"未刷卡":date('Y-m-d H:i:s',$cc['m_attend']));
            $objPHPExcel->getActiveSheet(0)->setCellValue('F' . $Val, $cc['m_lattend']==""?"未刷卡":date('Y-m-d H:i:s',$cc['m_lattend']));
            $objPHPExcel->getActiveSheet(0)->setCellValue('G' . $Val, $cc['a_attend']==""?"未刷卡":date('Y-m-d H:i:s',$cc['a_attend']));
            $objPHPExcel->getActiveSheet(0)->setCellValue('H' . $Val, $cc['a_lattend']==""?"未刷卡":date('Y-m-d H:i:s',$cc['a_lattend']));
            $objPHPExcel->getActiveSheet(0)->setCellValue('I' . $Val, $cc['n_attend']==""?"未刷卡":date('Y-m-d H:i:s',$cc['n_attend']));
            $objPHPExcel->getActiveSheet(0)->setCellValue('J' . $Val, $cc['n_lattend']==""?"未刷卡":date('Y-m-d H:i:s',$cc['n_lattend']));
            $objPHPExcel->getActiveSheet(0)->setCellValue('K' . $Val, $cc['cardno']==""?"卡未发":'已下发');
//            $objPHPExcel->getActiveSheet(0)->setCellValue('K' . $Val, $ExceData[$i]['parent_phone']);


            $Val++;
        }

        $school_name = M('school')->where("schoolid=$schoolid")->getField("school_name");
        $filename =$school_name.'-'.'学生刷卡导出';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename.'.xls');
        header('Cache-Control: max-age=0');

        $objWriter =\ PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_clean();//关键
        flush();//关键
        $objWriter->save('php://output');
        exit;
    }




    //获取学生的到校时间和离校时间 TODO以前的
//     function getTime(){

//         //查询时间
//         $settime = I("time");
//        // var_dump($settime);

//         if ($settime){
//             $tbtim = strtotime($settime)-28800;
//             $tendtime = $tbtim+86400;
//         }else{
//             //获取当天开始的时间和结束的时间
//             //开始判断这两个时间是不是都在这里面
//             $tbtim = mktime(0,0,0,date("m"),date("d"),date("Y"));
//             //获取最后一天
//             $tendtime = $tbtim+86400;
//         }

//          // var_dump($tbtim);
//          // var_dump($tendtime);

//         //拿到学校id和班级id
//         $schoolid= I("schoolid");
//         $classid = I("classid");
//         //获取学生列表
//         $stu_list = M("class_relationship")->where(array("schoolid"=>$schoolid,"classid"=>$classid))->select();
//         if (empty($stu_list)){
//             $ret = format_ret(0,"parms lost");
//             echo json_encode($ret);
//         }
//         //循环出来用户的信息
//         for ($i=0;$i<count($stu_list);$i++){
//             $stu_userid .= $stu_list[$i]["userid"].",";
//         }
//         $stu_userid = substr($stu_userid,0,-1);
// //        echo $stu_userid;
//         //查询学生的信息
//         $stu_info= M("wxtuser as user")
//             ->where("user.id in($stu_userid)")->select();
//            // var_dump($stu_info);
//         //执行循环判断然后入栈
//             //考勤记录为主表 考勤设置为辅表
//         for ($i=0;$i<count($stu_info);$i++){
//             //获取学生id 然后班级id是已知的 学校id也是已知的
//             //读取考勤记录 配合考勤时间
//             $attendance["userid"] = $stu_info[$i]['id'];
//             $attendance["arrivetime"] = array("egt",$tbtim);
//             $attendance['arrivetime']= array("elt",$tendtime);
//             $list = M("attendances")->where($attendance)->order("arrivetime DESC")->select();
//             //var_dump($list);
//             //查到学生的最新两条然后查询都是否符合条件
//                 $leatime = $list[1]['arrivetime'];
//                 // var_dump(expression)
//                 $arrtime = $list[0]['arrivetime'];

//             //开始查看是否在这个时间段之内 如果只有一条的话就显示一条 如果多条的话就显示多条
//             //判断学生的打卡是不是都是今天的打卡
//             $sertime = array($arrtime,$leatime);
//             //var_dump($sertime);
//             sort($sertime);//序列化数组
//             //开始查询时间 查询这时间是否都在时间段之内
//             if ($sertime[1] >=$tbtim && $sertime[1]<=$tendtime){
//                 $stu_info[$i]["last"] = $sertime[1];
//             }else{
//                 $stu_info[$i]["last"] = "";
//             }
//             if ($sertime[0] >=$tbtim && $sertime[0]<=$tendtime){
//                 $stu_info[$i]['first'] = $sertime[0];
//             }else{
//                 $stu_info[$i]['first'] = "";
//             }
//             //还是判断是否有时间传过来
// //            echo M("attendances")->getLastSql();
//             //查出来考勤记录
//         }
// //        echo M("wxtuser as user")->getLastSql();
//         if (!empty($stu_info)){
//            $ret = $this->format_ret(1,$stu_info);
//            echo json_encode($stu_info);
//         }else{
//             $ret = format_ret(0,"parms lost");
//             echo json_encode($ret);
//         }
//     }
    public function attendanceMessage(){
        $Province=role_admin();



        $this->assign("Province",$Province);


        $this->display("attendancemassage");
    }

    public function get_message()
    {

        //查询时间
        $begin_time  = strtotime(I("begin_time"));

        $end_time  = strtotime(I("end_time"))+86400;

        $schoolid= I("schoolid");

         $phone = I("phone");

        $classid = I("classid");

        $att_type = I("att_type");

        $cardNo = I("cardNo");


        if($schoolid)
        {
            $where['message.schoolid'] = $schoolid;
            $school_name = M("school")->where("schoolid  = $schoolid")->getField("school_name");
        }



        if($classid)
        {
            $where['message.classid'] = $classid;

        }

        if($phone)
        {
            $where['relation.phone'] = array('like', "%$phone%");
        }

        if($begin_time && $end_time)
        {
            $where["message.time"] =  array(array('EGT',$begin_time),array('ELT',$end_time));
        }

        if($att_type)
        {
            $where['message.attendancetype'] = $att_type;
        }

        if($cardNo)
        {
            $where['message.cardNo'] = $cardNo;
        }

        //查出学校
//        $school_name = M("school")->where("schoolid  = $schoolid")->getField("school_name");



        $count = M("attendances_message")
                  ->alias("message")
                  ->join("wxt_school_class class ON message.classid = class.id")
                  ->join("wxt_relation_stu_user relation ON message.parentid = relation.userid and message.studentid = relation.studentid ")
                  ->join("wxt_student_info info ON message.studentid = info.userid")
                  ->where($where)
                  ->count();

        $page = $this -> page($count, 20);

        $att_message = M("attendances_message")
                      ->alias("message")
                      ->join("wxt_school_class class ON message.classid = class.id")
                      ->join("wxt_relation_stu_user relation ON message.parentid = relation.userid and message.studentid = relation.studentid ")
                      ->join("wxt_student_info info ON message.studentid = info.userid")
                      ->where($where)
                      ->field("relation.name as parent_name,relation.appellation,class.classname,message.content,relation.phone,info.stu_name,message.status,message.errcode,message.time,message.attendancetype,message.schoolid,message.cardNo,message.leavepicture")
                      -> limit($page -> firstRow . ',' . $page -> listRows)
                      ->select();

        foreach ($att_message as &$value)
         {
             if(empty($value['parent_name']))
             {
                 $value['parent_name'] = $value['stu_name'].'的'.$value['appellation'];
             }


             if($schoolid)
             {
                 $value['school_name'] = $school_name;
             }else{

                $value['school_name'] = M("school")->where(array("schoolid"=>$value['schoolid']))->getField("school_name");
             }

            $value['time'] = date('Y-m-d H:i:s',$value['time']);
            if($value['attendancetype']==1){
                $value['attendancetype'] = '上午上学';
            }
            if($value['attendancetype']==2){
                $value['attendancetype'] = '上午放学';
            }
            if($value['attendancetype']==3){
                $value['attendancetype'] = '下午上学';
            }
            if($value['attendancetype']==4){
                $value['attendancetype'] = '下午放学';
            }
            if($value['attendancetype']==5){
                $value['attendancetype'] = '晚上上学';
            }
            if($value['attendancetype']==6){
                $value['attendancetype'] = '晚上放学';
            }
            if($value['attendancetype']=='0'){
                $value['attendancetype'] = '考勤异常';
            }

            if($value['status']=='1'){
                $value['status'] = '发送成功';
            }
             if($value['status']=='2'){
                 $value['status'] = '发送失败';
             }
             if($value['status']=='3'){
                 $value['status'] = '已存入考勤表';
             }
             if($value['status']=='4'){
                 $value['status'] = '日期不同';
             }

        }





        $Page[] =  $page -> show('Admin');
        $result = array_merge($Page,$att_message);



        if (!empty($result)){
            $ret = $this->format_ret(1,$result);

            echo json_encode($result);
            //echo $Page;


            // $this -> assign("Page", $page -> show('Admin'));

        }else{
            $ret = $this->format_ret(0,"parms lost");
            $this -> assign("Page", $page -> show('Admin'));
            echo json_encode($ret);

        }
        exit();


    }

    public function messageReceiveSet(){
        echo "信息接受设置：老师卡在考勤机上刷卡时能把考勤短信发送到园长（可配置、可关闭）手机上，考勤短信内容能显示老师名字";
    }
    public function schoolbus(){
        echo "校车管理：校车维护，校车刷卡";
    }
    public function studentLeave(){

        $Province=role_admin();



        $this->assign("Province",$Province);
//        echo "学生请假";
        $this->display();
    }

    public function school_class()
    {
      $schoolid = I('schoolid');
      // var_dump($schoolid);

      $school_class = M("school_class")->where("schoolid = $schoolid")->select();

      if (!empty($school_class)){
           $ret = $this->format_ret(1,$school_class);
           echo json_encode($ret);
        }else{
            $ret = format_ret(0,"parms lost");
            echo json_encode($ret);
        }


    }

    public function student()
    {

        $schoolid=I('schoolid');
        // var_dump($schoolid);

        $class = I('class');

        // var_dump($class);
       

        $class_relationship = M('class_relationship')
                            ->alias("c")
                            ->where("c.schoolid = $schoolid and c.classid = $class")
                            ->join("wxt_student_info s ON c.userid = s.userid")
                            ->field("s.userid,s.stu_name")
                            ->order("s.userid")
                            ->select();

        
   // var_dump($class_relationship);
        

            if($class_relationship){
                $ret = $this->format_ret(1,$class_relationship);
            }else{
                $ret = $this->format_ret(0,"lost params");
            }
            echo json_encode($ret);

    }

    public function addbinding_post()
    {
      $studentid = I('student');
      $begin =strtotime(I('begin'));
      $end =strtotime(I('end'));
      $leavetype = I('leavetype');
      $reason = I('content');

     if($studentid)
     {
        $data = array(
            'studentid'=>$studentid,
            'leavetype' => $leavetype,
            'reason'=>$reason,
            'create_time'=>time(),
            'begintime'=>$begin,
            'endtime'=>$end,


            );

        $add = M('leave')->add($data);

        if($add)
        {
            $this->success("请假发送成功");
        }else{
            $this->error("发送失败");
        }
     }

    }
    

    public function temperature(){
//        echo "体温";
        $this->display();
    }
    public function monitoring(){
        echo "在校监控";
    }
    public function location(){
        echo "安全定位";
    }
}

