<?php

/**
 * 后台首页 
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
class SchoolNoticeController extends TeacherbaseController{
    function _initialize() {
        parent::_initialize();

    }
	public function index(){
        //用户信息
        $userid=$_SESSION['USER_ID'];

        $schoolid=$_SESSION['schoolid'];

        $level= $_SESSION['level'];
		//只查询单独发给老师的公告
		$where["schoolid"]=$schoolid;

		$type = I('type');
		//var_dump($type);
        $begin = strtotime(I("begin"));
        $end = strtotime(I("end"));
		if($type){
			$where['type'] = $type;
		}

		if($begin !=false && $end !=false){
		  $where['create_time']  = array('GT',$begin);
		  $where['create_time'] = array('LT',$end);
		  $this->assign("begin",date('Y-m-d',$begin));
		  $this->assign("end",date('Y-m-d',$end));
		}
        if($level!=1  && $level!=2)
        {


            $where['userid'] = $userid;


        }

//       dump($where);
        $count=M("notice")->where($where)->count();
        $page = $this->page($count, 20);
        $notice=M("notice")->where($where)->limit($page->firstRow . ',' . $page->listRows)->order("create_time desc")->select();
       // var_dump($notice);
		//获取当前系统时间,用以判断公告是否过期
		$time=time();
		$this->assign("notice",$notice);
		$this->assign("time",$time);
        $this->assign("Page", $page->show('School'));
		$this->display();
	}
	public function notice(){
		//获取本校老师
		$schoolid=$_SESSION['schoolid'];
		$teachers=M("teacher_info")->alias("t")->join("wxt_wxtuser w ON w.id=t.teacherid")->where("t.schoolid=$schoolid")->field("w.id,w.name")->select();
		$this->assign("teachers",$teachers);
		$this->display();
	}
	public function notice_post(){
	     $type = I("type");

	    if (empty($type)){
            $this->error("请选择类型");
        }
        $title = I("title");
        if (empty($title)){
            $this->error("请输入标题！");
        }
        $content = I("content");
        if (empty($content)){
            $this->error("请输入内容！");
        }
		$schoolid=$_SESSION['schoolid'];
		$userid=$_SESSION["USER_ID"];
		$data["schoolid"]=$schoolid;
		$data["userid"]=$userid;
		$data["title"]=$title;
		$data["content"]=$content;
		$data["type"]=$type;
		$data["begin_time"]=strtotime(I("begin_time"));
		$data["end_time"]=strtotime(I("end_time"));
		$data["create_time"]=time();
		$notice=M("notice")->add($data);
		if($notice){
			$teacher_arr=I("teacher");
			var_dump($teacher_arr);
			foreach ($teacher_arr as &$teacherid) {
				$data_teacher["noticeid"]=$notice;
				$data_teacher["receiverid"]=$teacherid;
				$data_teacher["create_time"]=time();
				$receive_list=M("notice_receiverid")->add($data_teacher);
			}
			if(!empty($_POST['photos_alt']) && !empty($_POST['photos_url'])){
        		foreach ($_POST['photos_url'] as $key=>$url){
        		    $photourl=sp_asset_relative_url($url);
        		    $_POST['smeta']['photo'][]=array("url"=>$photourl,"alt"=>$_POST['photos_alt'][$key]);
        		}
        	}
        	$picurl = sp_asset_relative_url($_POST['smeta']['thumb']);
        	$pic_add=M("notice_photo")->add(array("noticeid"=>$notice,"photo"=>$picurl,"create_time"=>time()));
        	$this->success("发送成功");
		}
	}

	public function delete(){
    $schoolid=$_SESSION['schoolid'];
     $ids = I('ids');

    // var_dump($ids);

     $id =  implode(",", $ids); 
    // $schoolid=$_SESSION['schoolid'];
   
        $where['id'] = array('in',"$id");
        $del = M('notice')->where($where)->delete();

      if ($del > 0) {
            $info['status'] = true;
            $info['msg'] = $del;
        } else {
            $info['status'] = false;
            $info['msg'] = '404';
         }
          echo json_encode($info); 



        // var_dump("dddddddddddddd");
        //$this->display("notice");
    }

  //TOODO  Excel导入导出函数 还没完善

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

      public function expUser($id){//导出Excel
            $schoolid=$_SESSION['schoolid'];
           // var_dump($schoolid);
            //$ids = I('ids');
            //var_dump($ids);
            //	var_dump($id);
           // exit();
      
             // $id = implode(",", $ids);
             // $where["n.id"] = array('in',"$id");

             // $where["n.schoolid"] = $schoolid;
           //  var_dump($where);     
             
             // $where["k.schoolid"]=$schoolid;
        	 $where["k.id"]=array('in',"$id");
        	// var_dump($where);
        	 
            //1是普通2是表扬
        	 $result=M("notice")
        	->alias("k")
        	->join("wxt_wxtuser d ON k.userid=d.id ")
        	->where($where)
        	->field("d.name,d.id,k.begin_time,k.end_time,k.title,k.content,type")
        	->select();  
   

        
        foreach ($result as $key => &$value) {
                 $type = $value['type'];	
                 if($type ==1){
                 	$type = '普通公告';
                 }
                  if($type ==2){
                 	$type = '表扬公告';
                 }

                $begin_time = date("Y-m-d H:i:s",$value['begin_time']);
                 $end_time  = date("Y-m-d H:i:s",$value['end_time']);

                 //var_dump($type);
                    $value['end_time'] = $end_time;
                    $value['begin_time'] = $begin_time;
                	$value['type'] = $type;

                	
                }       
             
           
                $xlsName  = "User";

                $xlsCell  = array(

                array('title','公告标题'),

                array('type','公告类型'),

                array('content','内容'),

                array('begin_time','发布日期'),

                array('end_time','终止日期'),

                array('name','发布人'),

             

                );
                //接收保存在SESSION的值
                $xlsData = $result;
                // var_dump($xlsData);
           
                 $fileNames =  '校内公告'.date('_YmdHis');
      
               $this->exportExcel($xlsName,$xlsCell,$xlsData,$fileNames);
         
                     
        }




}