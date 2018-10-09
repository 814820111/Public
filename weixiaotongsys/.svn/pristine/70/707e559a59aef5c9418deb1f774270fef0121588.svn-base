<?php

function sp_get_url_route(){
	$apps=sp_scan_dir(SPAPP."*",GLOB_ONLYDIR);
	$host=(is_ssl() ? 'https' : 'http')."://".$_SERVER['HTTP_HOST'];
	$routes=array();
	foreach ($apps as $a){
	
		if(is_dir(SPAPP.$a)){
			if(!(strpos($a, ".") === 0)){
				$navfile=SPAPP.$a."/nav.php";
				$app=$a;
				if(file_exists($navfile)){
					$navgeturls=include $navfile;
					foreach ($navgeturls as $url){
						//echo U("$app/$url");
						$nav= file_get_contents($host.U("$app/$url"));
						$nav=json_decode($nav,true);
						if(!empty($nav) && isset($nav['urlrule'])){
							if(!is_array($nav['urlrule']['param'])){
								$params=$nav['urlrule']['param'];
								$params=explode(",", $params);
							}
							sort($params);
							$param="";
							foreach($params as $p){
								$param.=":$p/";
							}
							
							$routes[strtolower($nav['urlrule']['action'])."/".$param]=$nav['urlrule']['action'];
						}
					}
				}
					
			}
		}
	}
	
	return $routes;
}
//传入学校id，获取学校名称
function get_schoolname($schoolid){
	return M('school')->where("schoolid = $schoolid")->getField('school_name');
}
//传入职位id，获取职位名称
function get_dutyname($duty_id){
	return M('duty')->where("id = $duty_id")->getField('name');
}

//传入id 获取权限等级
function get_level($schoolid,$id)
{
    $where['teacher.schoolid'] = $schoolid;
    $where['teacher.teacher_id'] = $id;
    $level = M("duty_teacher")
            ->alias('teacher')
            ->join("wxt_school_duty school_duty ON teacher.duty_id = school_duty.id")
            ->where($where)
            ->getField('school_duty.level');

    return $level;

}
//穿入id获取班级
function get_teacher_class($id)
{
    if($id) {

        $schoolid = $_SESSION['schoolid'];

        $teacher_class = M("teacher_class")
            ->alias("t")
            ->join("wxt_school_class c ON t.classid=c.id")
            ->where("t.schoolid = $schoolid and t.teacherid = $id")
            ->field("c.id,c.classname")
            ->select();

        return $teacher_class;
    }
}

//新的卡号是否已经被使用
function get_showcard($card,$schoolid)
{
    $showcard = M("student_card")->where(array("cardNo"=>$card,"schoolid"=>$schoolid,"handletype"=>1))->find();

    if($showcard)
    {
    $istrue = true;
    }else{
        $istrue = false;
    }
    return $istrue;
}
//更新student_card
function update_card($type,$userid,$schoolid)
{
    //判断是什么类型的卡号
    switch ($type) {
        case '0':
            $stu_main = M("student_info")->alias("s")->where("s.userid = $userid and s.schoollid = $schoolid")->join("wxt_school_class class ON s.classid=class.id")->field("s.photo,s.stu_name,class.classname,s.classid")->find();
            $add_card["classId"] = $stu_main["classid"];
            $add_card["name"] = $stu_main["stu_name"];
            $add_card["className"] = $stu_main["classname"];
            $imgurl = $stu_main["photo"];
            $arr = explode("/",$imgurl);

            $photo=$arr[count($arr)-1];
            if(!$photo)
            {
                $photo = "weixiaotong.png";
            }
            $add_card["imgUrl"] = "http://ow3hm6y11.bkt.clouddn.com/".$photo;

            break;
        case '1':
            $teacher_main = M("teacher_info")->where("id = $userid and schoolid = $schoolid")->field("name")->find();
            $add_card["name"] = $teacher_main['name'];
            break;
        case '2':
            break;

    }
    $save_one["handletime"] = date("Y-m-d H:i:s",time());
    $save_one["handletimeint"] = time();
    $save_one["handletype"] = 0;

    $add_card["schoolid"] = $schoolid;
    $add_card["personId"] = $userid;
    $add_card["cardType"] = $type;
    $add_card["handletype"] = 1;


    //查询出该卡号信息
    $show_card = M("student_card")->where(array("personId"=>$userid,"schoolid"=>$schoolid,"cardType"=>$type,"handletype"=>1))->find();


    //将原有的卡号修改为删除
    $save_card = M("student_card")->where(array("personId"=>$userid,"schoolid"=>$schoolid,"cardType"=>$type,"handletype"=>1))->save($save_one);

    $add_card["handletime"] = date("Y-m-d H:i:s",time());
    $add_card["handletimeint"] = time();
    $add_card["handletype"] = 1;
//    $save_card = M("student_card")->where($where)->save($up_card);
    if($save_card && $show_card)
    {
        $add_card['cardNo'] = $show_card['cardno'];
        $add_card['create_time'] = time();
        $add_student_card= M("student_card")->add($add_card);
    }




}


function is_teacher($userid)
{
    if($userid)
    {
        $is_teacher = M("teacher_info")->where(array("teacherid"=>$userid))->find();
        if($is_teacher)
        {
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}

function is_parent($userid)
{
    if($userid)
    {
        $is_parent = M("relation_stu_user")->where(array("userid"=>$userid))->find();
        if($is_parent)
        {
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}
//删除卡号

function deletecard($cardno,$cardtype)
{


    $delete = M('student_card')->where("cardno = $cardno and cardType = $cardtype and handletype = 1")->save(array("handletype"=>0));
    // var_dump($delete);

    if ($delete) {
        $info['status'] = true;
        $info['msg'] = $delete;
    } else {
        $info['status'] = false;
        $info['info'] = '删除失败';
    }
    echo json_encode($info);
}
function add_admin_class($userid,$schoolid)
{
    //查询出这个学校的所有班级
    $school_class = M("school_class")->field("id")->where("schoolid = $schoolid")->select();

    foreach($school_class as $class_item)
    {
        $classid = $class_item['id'];
        $data['teacherid'] = $userid;
        $data['schoolid'] = $schoolid;
        $data['classid'] = $classid;
        $alldata[]=$data;
        unset($data);
    }
    $result = M('teacher_class')->addAll($alldata);

}

//查询学生数据是否有已存在
function get_student($schoolid,$name,$phone)
{

    $where['stu_name'] = $name;
    $where['schoollid'] = $schoolid;

    $student = M("student_info")->where($where)->field("userid")->select();
    if($student)
    {
        foreach ($student as $value) {
            $userid = $value['userid'];
            $parent_phone = M("relation_stu_user")->where("studentid = $userid and type = 1")->getField('phone');

            if ($parent_phone == $phone) {
                return array("status" => false, "error" => "该学生已经存在,请勿重复添加");
            }
        }
        return array("status" => true);

    }else{
        return array("status" => true);

    }


}

function findNum($str=''){
    $str=trim($str);
    if(empty($str)){return '';}
    $result='';
    for($i=0;$i<strlen($str);$i++){
        if(is_numeric($str[$i])){
            $result.=$str[$i];
        }
    }
    return $result;
}


function get_subject($schoolid)
{
    $where['schoolid'] = $schoolid;

    $where['schoolid'] = 0;

    $school = M('school')->where("schoolid=$schoolid")->find();

    $gradetype = $school['schoolgradetypeid'];
    $where['gradetype'] =$gradetype;

    $data['gradetype'] = 0;
    $data['schoolid'] = $schoolid;
    $data['isdefault'] = 1;

    $where_c['gradetype'] = 0;
    $where_c['schoolid'] = 0;
    $where_c['isdefault'] = 0;

    $where_subject=array($where_c,$data,$where,'_logic'=>'or');

    $subject  = M("default_subject")->where($where_subject)->select();

    return $subject;

}

 function is_switch($identifier,$schoolid)
{
    $this->switch_detail = D("Common/switch_detail");

//    $identifier = I("identifier");
//    $schoolid = I("schoolid");

    if(!$identifier || !$schoolid)
    {
        return false;
    }else{

        $switch = $this->switch_detail->where(array("schoolid"=>$schoolid,"identifier"=>$identifier))->find();
        if($switch)
        {
            return true;
        }else{
          return false;
        }

    }

}


//function update_card($type,$userid,$schoolid)
//{
//    //判断是什么类型的卡号
//    switch ($type) {
//        case '0':
//            $stu_main = M("student_info")->alias("s")->where("s.userid = $userid and s.schoollid = $schoolid")->join("wxt_school_class class ON s.classid=class.id")->field("s.photo,s.stu_name,class.classname,s.classid")->find();
//            $save_card["classId"] = $stu_main["classid"];
//            $save_card["name"] = $stu_main["stu_name"];
//            $save_card["className"] = $stu_main["classname"];
//            $save_card["imgUrl"] = "http://up.zhixiaoyuan.net/uploads/microblog/".$stu_main["photo"];
//
//            break;
//        case '1':
//            $teacher_main = M("teacher_info")->where("t.teacherid = $userid and t.schoolid = $schoolid")->alias("t")->join("wxt_wxtuser user ON t.teacherid=user.id")->field("user.name")->find();
//            $save_card["name"] = $teacher_main['name'];
//            break;
//        case '2':
//            break;
//
//    }
//    $where["schoolid"] = $schoolid;
//    $where["personId"] = $userid;
//    $where["cardType"] = $type;
//    $where["handletype"] = 1;
//    $save_card["handletime"] = date("Y-m-d H:i:s",time());
//    $save_card["handletimeint"] = time();
//    $save_card = M("student_card")->where($where)->save($save_card);
//
//}

