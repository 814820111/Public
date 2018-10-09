<?php

/**
 * 晨检记录
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
class InspectionController extends TeacherbaseController {
    function _initialize() {
        parent::_initialize();

    }
	function index_management()
	{
        $schoolid = $_SESSION['schoolid'];
      
		$grade=M('school_grade')->field("gradeid,name")->order("gradeid asc")->where("schoolid=$schoolid")->select();
          //var_dump($grade);

        $class = M('school_class')->where("schoolid=$schoolid")->select();
        $search=I('name');
        $begintime=I("begintime");
        $endtime=I("endtime");
        $begin=strtotime($begintime);
        $end=strtotime($endtime);
        $classid=I("class");
        if($classid){
            $userid_c=M('class_relationship')->field("userid")->where("classid=$classid")->select();
            $id_arr_c=array();
            foreach ($userid_c as &$itvo) {
                foreach ($itvo as &$co) {
                    array_push($id_arr_c,$co);
                }
            }
            $map["studentid"]=array("in",$id_arr_c);
        }
        if($search){
            $where_name["name"]=array('LIKE',"%".$search."%");
            $userid_n=M('wxtuser')->field("id")->where($where_name)->select();
            //将select查询出的多条id的二维数组通过两次foreach循环配合array_push方法加入到一个一维数组中
            $id_arr_n=array();
            foreach ($userid_n as &$item) {
                foreach ($item as &$vo) {
                    array_push($id_arr_n,$vo);
                }
            }
            $map["studentid"]=array("in",$id_arr_n);
        }
        if($begintime && $endtime){
            $map["create_time"]=array(array('EGT',$begin),array('ELT',$end));
        }

        //先预留着下次启用
      //$map['学籍号'] = $学籍.....
       $count=M('inspection_manage')->where($map)->count();
  		 $page = $this->page($count, 10);

        $list=M('inspection_manage')
        ->where($map)
        ->order("create_time DESC")
        ->limit($page->firstRow . ',' . $page->listRows)
        ->select();

       // var_dump($list);



        foreach ($list as &$item) {
            //拿出晨检表的学生ID
            $studentid=$item["studentid"];
            //将学生ID赋值给用户表里的ID去查询记录
            $where_name["id"]=$studentid;
            $where_name["schoolid"] = $schoolid;
            $student_name=M('wxtuser')->field("name")->where($where_name)->find();
         
        //    var_dump($student_name);
            //用户表的名字赋值给晨检表
            $item["student_name"]=$student_name["name"];
            
            $classname=M('school_class')
            ->alias("s")
            ->join("wxt_class_relationship c ON s.id=c.classid")
            ->where("c.userid=$studentid")
            ->field("s.classname,grade")
            ->find();
        //  var_dump($classname);
              $where['schoolid'] =$schoolid;
              $where['gradeid'] = $classname['grade'];
          //  var_dump($where);

            $grade = M("school_grade")->where($where)->field('name')->find();
            
           //$grade = M('school_grade')->alias("g")->join("wxt_school_class s ON g.gradeid=s.grade")->where()->field("g.name")->find();


       //    var_dump($grade);
            $item["classname"]=$classname["classname"];
            $item['grade'] = $grade['name'];

        }
   

        //里面都要加一个条件就是schoolid = $schoolid 算出来在本校各种卡的记录

        $count_not=M('inspection_manage')->where(array("results"=>0))->count();
        $count_red=M('inspection_manage')->where(array("results"=>1))->count();
        $count_yellow=M('inspection_manage')->where(array("results"=>2))->count();
        $count_green=M('inspection_manage')->where(array("results"=>3))->count();

        $this->assign("count_not",$count_not);
        $this->assign("count_red",$count_red);
        $this->assign("count_yellow",$count_yellow);
        $this->assign("count_green",$count_green);
        $count_all= $count_not+ $count_red+ $count_yellow+ $count_green;
        $this->assign("count_all",$count_all);


        $this->assign("Page", $page->show('Admin'));
		   $this->assign("current_page",$page->GetCurrentPage());
        $this->assign("class",$class);
        $this->assign("grade",$grade);
       // var_dump($class);
        $this->assign("list",$list);
       // var_dump($list);
        $this->assign("teacher",$teacher);
		$this->display("index_management");

	}







	function index_statistics()
	{

        $class=M('school_class')->field("id,classname")->order("id")->select();
        $search=I('name');
        $begintime=I("begintime");
        $endtime=I("endtime");
        $begin=strtotime($begintime);
        $end=strtotime($endtime);
        $classid=I("class");
        if($classid){
            $userid_c=M('class_relationship')->field("userid")->where("classid=$classid")->select();
            $id_arr_c=array();
            foreach ($userid_c as &$itvo) {
                foreach ($itvo as &$co) {
                    array_push($id_arr_c,$co);
                }
            }
            $map["studentid"]=array("in",$id_arr_c);
        }
        if($search){
            $where_name["name"]=array('LIKE',"%".$search."%");
            $userid_n=M('wxtuser')->field("id")->where($where_name)->select();
            //将select查询出的多条id的二维数组通过两次foreach循环配合array_push方法加入到一个一维数组中
            $id_arr_n=array();
            foreach ($userid_n as &$item) {
                foreach ($item as &$vo) {
                    array_push($id_arr_n,$vo);
                }
            }
            $map["studentid"]=array("in",$id_arr_n);
        }
        if($begintime && $endtime){
            $map["create_time"]=array(array('EGT',$begin),array('ELT',$end));
        }


         $count=M('inspection_manage')->where($map)->count();
         $page = $this->page($count, 10);

        $list=M('inspection_statistics')
        ->where($map)
        ->order("create_time DESC")
        ->limit($page->firstRow . ',' . $page->listRows)
        ->select();
     


        foreach ($list as &$item) {
            $studentid=$item["studentid"];
            $where_name["id"]=$studentid;
            $student_name=M('wxtuser')->field("name")->where($where_name)->find();
            $item["student_name"]=$student_name["name"];
            $classname=M('school_class')
            ->alias("s")
            ->field("s.classname")
            ->find();
            $item["classname"]=$classname["classname"];

        }




		$this->assign("Page", $page->show('Admin'));
        $this->assign("class",$class);
        $this->assign("list",$list);
        $this->assign("current_page",$page->GetCurrentPage());

		$this->display("index_statistics");
	}
  



    //晨检管理 先放着!

     public function  managexpUser($id)
     {
        $schoolid=$_SESSION['schoolid'];
      
        $where["m.studentid"]=array('in',"$id");
        //$where['u.schoolid'] = $schoolid;
       $result=M("inspection_manage")
        ->alias("m")
        ->join("wxt_wxtuser d ON m.studentid=d.id ")
        ->where($where)
        ->field("d.name,m.school_num,ic_num,temperature,results,studentid")
        ->select();  
   
//exit();
//TODO有BUG 一个学生可能会拥有多个班级 会使搜索条件不可用  晨检统计也会有误
 var_dump($result);
 // $classname=M('school_class')
 //            ->alias("s")
 //            ->join("wxt_class_relationship c ON s.id=c.classid")
 //            ->where("c.userid=$studentid")
 //            ->field("s.classname,grade")
 //            ->find();
       //  $xlsName  = "User";

       //  $xlsCell  = array(

       //  array('title','公告标题'),

       //  array('type','公告类型'),

       //  array('content','内容'),

       //  array('begin_time','发布日期'),

       //  array('end_time','终止日期'),

       //  array('name','发布人'),

     

       //  );
       //  //接收保存在SESSION的值
       //  $xlsData = $result;
       //  // var_dump($xlsData);

       //   $fileNames =  '校内公告'.date('_YmdHis');

       // $this->exportExcel($xlsName,$xlsCell,$xlsData,$fileNames);


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


}