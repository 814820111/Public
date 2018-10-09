<?php

/**
 * 班级相册
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
class ClassAlbumController extends TeacherbaseController {
    function _initialize() {
        parent::_initialize();
        $this -> userid =$_SESSION['USER_ID'];
        $this -> schoolid =$_SESSION['schoolid'];
        $this -> level =$_SESSION['level'];


    }


	function add()
	{
//		$wxtuser =  M('wxtuser');
//        $school_class=M('school_class');
//        $school_class_id=$school_class->field('classname,grade,id')->select();
//        $this->assign("categorys",$school_class_id);

        $userid=$_SESSION['USER_ID'];
        $schoolid=$_SESSION['schoolid'];
        $grade=M("school_grade")->where("schoolid = $schoolid")->select();
//        $class=M("teacher_class")
//            ->alias('t')
//            ->join("wxt_school_class s ON t.classid=s.id")
//            ->where("t.teacherid=$userid")
//            ->field("s.classname,s.id,s.grade")
//            ->order("id")->select();
//        foreach ($class as &$item){
//            $item_gid= $item['grade'];
//            //var_dump($item_gid);
//            //$item_schoolid = $item['schoolid'];
//           // var_dump($item_schoolid);
//            $grade_item = M("school_grade")->where("gradeid=$item_gid and schoolid = $schoolid")->select();
//
//            array_push($grade,$grade_item);
//            unset($grade_item);
//        }
        $this->assign("categorys",$grade);
        $this->assign("class",$class);
		$this->display("add");

		// session_start();
		// $schoolid=$_SESSION["schoolid"];
		// echo $schoolid;

	}

	function add_post()
	{

		$grade=I('grade');
		$class=I('class');
		$content=I('content');
		$microblog_main=M('microblog_main');
		$microblog_picture_url=M('microblog_picture_url');
		$wxtuser=M('wxtuser');

		if(empty($class))
        {
             $this->error("请选择班级");
        }

// 图片路径在 data/upload
		// $_POST['smeta']['thumb'] = sp_asset_relative_url($_POST['smeta']['thumb']);
		// $photo=$_POST['smeta']['thumb'];
/*
在 本地  微校通 photo的路径是  /weixiaotong2016uploads/microblog/20170107/5870b86

		只保留	20170107/5870b86  所以截取/weixiaotong2016uploads/microblog/    34

而在  乾哥服务器
uploads/microblog/20170107/5870bc561ebf1.jpg

是18

*/ 
		$photo=substr($photo, 18);
		
		session_start();
        $userid=$_SESSION["USER_ID"];
        $schoolid=$_SESSION["schoolid"];

		$data['userid']=$userid;
		$data['schoolid']=$schoolid;
		$data['content']=$content;
		$data['type']=2;
		$data['classid']=$class;
		$data['write_time']=time();
		$data['status']=1;

		$add_id=$microblog_main->add($data);

		if($add_id&&$_POST['smeta']['thumb'])
		{   
              $pic  = explode('|',$_POST['smeta']['thumb']);
           
            foreach ($pic as  &$value) {
        
              $arr=explode("/", $value);
         
              $value = $arr[count($arr)-1];

			$data_ap['microblogid']=$add_id;
			$data_ap['pictureurl']=$value;
			$microblog_picture_url->add($data_ap);
		 }

		}
		if($add_id)
		{
			$this->error("添加成功");
		}
		// echo $add_a;


		$this->add();

	}


	function index()
	{    

		  $userid=$_SESSION['USER_ID'];
        $schoolid=$_SESSION['schoolid'];

		$wxtuser=M('teacher_info');
		$microblog_main=M('microblog_main');
		$microblog_picture_url=M('microblog_picture_url');
		$school_class=M('school_class');
		$class_id=$school_class->field('classname,grade,id')->select();


		$grade=I('grade');
		$class=I('class');

		$start_time=I('start_time');
        $end_time=I('end_time');
        $start_time_unix=strtotime($start_time);//将任何英文文本的日期或时间描述解析为 Unix 时间戳
        $end_time_unix=strtotime($end_time);

		$map=array();
		$map['mm.type']=2;
        if($start_time_unix && $end_time_unix){
            $map["mm.write_time"]=array(array('EGT',$start_time_unix),array('ELT',$end_time_unix));
            $this->assign('start_time_unix',date('Y-m-d H:i:s',$start_time_unix));
            $this->assign('end_time_unix',date('Y-m-d H:i:s',$end_time_unix));
        }
        if($class)
        {
        	$map["mm.classid"]=$class;
        	$this->assign("classinfo",$class);
        }
        if($grade)
        {
        //	$map["mm.classid"]=$grade;
        	$this->assign('gradeinfo',$grade);
        }


        if($this->level!=1  && $this->level!=2)
        {
            $map['mm.userid'] = $this->userid;


        }
        $map['mm.schoolid'] = $schoolid;
        $count  = $microblog_main->alias("mm")->where($map)->count();
        $page = $this->page($count, 20);
        //改造后

        $lists  = $microblog_main->alias("mm")->where($map)->select();

        foreach ($lists as &$item) {
            $mid=$item["mid"];
            $userid_val=$item['userid'];

            //获取图片
            $pic_count=$microblog_picture_url->field("pictureurl")->where("microblogid=$mid")->count();
            $item["picture_count"]=$pic_count;
//            $pic=$microblog_picture_url->field("pictureurl")->where("microblogid=$mid")->find();
            $pic=$microblog_picture_url->field("pictureurl")->where(array("microblogid"=>$mid,"set_bag"=>1))->find();
            $item["picture"]=$pic['pictureurl'];

            $wxtuser_find=$wxtuser->where(array("teacherid"=>$userid_val))->field("name")->find();
            $item['user_name']=$wxtuser_find['name'];

            //获取接收人

        }


        //需改造

//      $field="mm.mid,mm.type,mm.schoolid,mm.content,mm.write_time,mm.classid,mm.userid,mp.pictureurl,mp.id as mp_id";
//
//      $map['mm.schoolid'] = $schoolid;
//
//		$count=$microblog_picture_url
//		->alias('mp')
//		->join("wxt_microblog_main mm on mp.microblogid = mm.mid ")
//		->field($field)
//		->order("mm.mid desc, mp.id desc")
//		->where($map)
//		->count();
//		$page = $this->page($count, 20);
//
//
//		$lists=$microblog_picture_url
//		->alias('mp')
//		->join("wxt_microblog_main mm on mp.microblogid = mm.mid ")
//		->field($field)
//		->order("mm.mid desc, mp.id desc")
//		->where($map)
//		->limit($page->firstRow . ',' . $page->listRows)   // 添加分页
//		->select();
//
//
//		foreach ($lists as &$val) {
//			$userid_val=$val['userid'];
//			$wxtuser_find=$wxtuser->where(array("id"=>$userid_val))->field("name")->find();
//			$val['user_name']=$wxtuser_find['name'];
//		}

        //zsq_获取班级年级信息
        $grade_q=M("school_grade")->where(" schoolid = $schoolid")->select();
//        $class_q=M("teacher_class")
//            ->alias('t')
//            ->join("wxt_school_class s ON t.classid=s.id")
//            ->where("t.teacherid=$userid")
//            ->field("s.classname,s.id,s.grade")
//            ->order("id")->select();
            // var_dump($class_q);
//        foreach ($class_q as &$item){
//            $item_gid= $item['grade'];
//            $grade_item = M("school_grade")->where("gradeid=$item_gid and schoolid = $schoolid")->select();
//            array_push($grade_q,$grade_item);
//            unset($grade_item);
//        }


		$this->assign("categorys",$grade_q);
		$this->assign("current_page",$page->GetCurrentPage());
		$this->assign("Page", $page->show('Admin'));   // 添加分页
		$this->assign("lists",$lists);



		$this->display("index");

	}

	function shanchu()
	{
		$mid=I('mid');//相册表的mid
		$mp_id=I('mp_id');//图片表的id
		
		$microblog_main=M('microblog_main');
		$microblog_picture_url=M('microblog_picture_url');

		/*
		 删除图片时先判断 图片表中相册的mid的个数，
		 1. 如果图片表中mid只有一个,则表示该相册只有一张图片，所以连相册一起删除
		 2. 如果图片表中mid大于1，则表示相册中还有其他的图片，所以不能删除相册
		*/

		$mp_del = $microblog_main->where(array("mid"=>$mid))->delete();

		if($mp_del)
        {
            $pic_del = $microblog_picture_url->where(array("microblogid"=>$mid))->delete();
        }

//		 $count_mp=$microblog_picture_url
//		 ->where(array("microblogid"=>$mid))
//		 ->count();
//		 if($count_mp>1)
//		 {
//		 	$mp_del=$microblog_picture_url->where(array("id"=>$mp_id))->delete();
//		 }
//		 else
//		 {
//		 	$mp_del=$microblog_picture_url->where(array("id"=>$mp_id))->delete();
//		 	$microblog_main->where(array("mid"=>$mid))->delete();
//		 }
		 $this->index();


	}

	public function Album_details()
    {
        $mid = I("mid");

        $bag = M("microblog_picture_url")->where(array("microblogid"=>$mid,"set_bag"=>1))->getField("pictureurl");

        $count = M("microblog_picture_url")->where(array("microblogid"=>$mid))->count();

        $picture = M("microblog_picture_url")->where(array("microblogid"=>$mid))->select();
        $this->assign("lists",$picture);
        $this->assign("mid",$mid);
        $this->assign("bag",$bag);
        $this->assign("count",$count);
        $this->display();
    }

    public function album()
    {
        $mid = I("mid");
        $aid = I("aid");

        $seleced_pic = M("microblog_picture_url")->where(array("id"=>$aid))->find();

        $pic = M("microblog_picture_url")->where(array("microblogid"=>$mid))->select();

        foreach($pic as &$value)
        {
            if($value['id']==$aid)
            {
                $value['selected'] = true;
            }
        }

        $this->assign("seleced_pic",$seleced_pic);
        $this->assign("lists",$pic);
        $this->display();
    }

    public function add_album()
    {
        $grade = I("grade");
        $class = I("class");
        $album_name = I("album_name");

        $data['type'] = 2;
        $data['schoolid'] = $_SESSION['schoolid'];
        $data['classid'] = $class;
        $data['userid'] = $_SESSION['userid'];
        $data['content'] = $album_name;
        $data['status'] = 1;
        $data['write_time'] = time();

        $add = M("microblog_main")->add($data);
        if($add)
        {
            $info['status'] = true;
            $info['msg'] = "添加成功!";
        }else{
            $info['status'] = false;
            $info['msg'] = "添加失败!";
        }

        echo json_encode($info);

    }

    public function add_picture()
    {
      $img = explode('|',I("img"));
      $mid = I("mid");
      foreach($img as $pic)
      {
          $arr=explode("/", $pic);

          $img_name = $arr[count($arr)-1];
          $data['microblogid'] = $mid;
          $data['pictureurl'] = $img_name;
          $alldata[] = $data;
          unset($data);
      }

      $result = M("microblog_picture_url")->addAll($alldata);

      if($result)
      {
          $info['status'] = true;
          $info['msg'] = "上传图片成功";
      }else{
          $info['status'] = false;
          $info['msg'] = "上传图片失败";

      }

      echo json_encode($info);

    }

    public function del_picture()
    {
        $mid = I("microblogid");

        $ids = I("ids");

        $where['id'] = array("in",$ids);
        $where['microblogid'] = $mid;
        $del = M("microblog_picture_url")->where($where)->delete();

        if($del)
        {
            $info['status'] = true;
            $info['msg'] = "删除成功";
        }else{
            $info['status'] = false;
            $info['msg'] = "删除失败";
        }

        echo json_encode($info);

    }

    public function set_background()
    {
       $id = I('id');
       $mid = I("mid");

       //先将该活动的背景图取消
        $ago_edit = M("microblog_picture_url")->where(array("microblogid"=>$mid,"set_bag"=>1))->save(array("set_bag"=>0));

        $bag = M("microblog_picture_url")->where(array("id"=>$id))->save(array("set_bag"=>1));

        if($bag)
        {
            $info['status'] = true;
            $info['msg'] = "设置成功!";
        }else{
            $info['status'] = false;
            $info['msg'] = "设置失败!";
        }
        echo json_encode($info);

    }




}