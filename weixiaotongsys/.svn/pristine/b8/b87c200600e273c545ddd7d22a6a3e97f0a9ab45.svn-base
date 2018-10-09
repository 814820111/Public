<?php
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class AlbumManageController extends AdminbaseController{
	protected $ad_model;
	
	function _initialize() {
		parent::_initialize();
		$this->growth_album = D("Common/growth_album");
	}

	//学校信息
	function index(){
        $info = $this->growth_album->alias('ga')
            ->join('wxt_school as s on ga.school_id = s.schoolid')
            ->join("wxt_school_class as c on c.schoolid = ga.school_id")
            ->where("ga.class_id = c.id")
            ->field('ga.*, s.school_name, c.classname')->select();
        $this->assign('info', $info);
        $this->display();
	}
	
	function add_info(){
	    if (IS_POST){
            $arr = array(
                'name'=>I('name'),
                'school_id'=>I('school_id'),
                'class_id'=>I('class_id')
            );
            $insert = M("growth_album")->add($arr);
            if ($insert){
                $this->success('添加成功', U('index'));
            }
            exit;
        }
        $school = M('school')->select();
        $this->assign('school', $school);
		$this->display();
	}

	public function getClass()
    {
        $id = I('id');
        $class = M('school_class')->where("schoolid = $id")->field("id, classname as name")->select();
        //var_dump($class);
        echo json_encode($class);
    }

    public function look_photo()
    {
        $id = I('id');
        $photo = M('growth_photo')->where('album_id = '. $id)->select();
        $this->assign('id', $id);
        $this->assign('photo', $photo);
        $this->display();
    }

    public function add_photo()
    {
        $id = I('id');
        $info = M('growth_album')->where('id = '. $id)->field('name')->find();

        $this->assign('name', $info['name']);
        $this->assign('id', $id);
        $this->display();
    }
    public function add_photo_post()
    {
        if (IS_POST){
            $arr = array(
                'album_id'=>I('album_id'),
                'img'=>addslashes($_POST['smeta']['thumb']),
                'desc'=>addslashes($_POST['post']['post_content'])
            );
            $insert = M("growth_photo")->add($arr);
            if ($insert){
                $this->success('添加成功', U('add_photo', array('id'=>I('album_id'))));
            }
            exit;
        }
    }
}