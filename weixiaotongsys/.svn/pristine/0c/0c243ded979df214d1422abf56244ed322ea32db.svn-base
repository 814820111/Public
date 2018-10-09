<?php
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class StyleManageController extends AdminbaseController{
	protected $ad_model;
	
	function _initialize() {
		parent::_initialize();
		$this->growth_schoolinfo = D("Common/growth_schoolinfo");
	}

	function index(){
        $this->display();
	}
	
	public function add_info(){

		$this->display();
	}

	public function add_info_next()
    {
        $info = M('temple_page')->order("sort asc")->select();
        //dump($info);
        $arr = array();
        foreach ($info as $k=>$v){
            $it = M('temple_imgs_texts')->where("temple_id = {$v['id']}")->select();


            $ia = array();
            $ta = array();
            foreach ($it as $ks=>$vs){
                if ($vs['type'] == 0){
                    $ta[$ks]['id'] = $vs['id'];
                    $ta[$ks]['width'] = $vs['width'];
                    $ta[$ks]['height'] = $vs['height'];
                    $ta[$ks]['left'] = $vs['left'];
                    $ta[$ks]['top'] = $vs['top'];
                } elseif ($vs['type'] == 1){
                    $ia[$ks]['id'] = $vs['id'];
                    $ia[$ks]['width'] = $vs['width'];
                    $ia[$ks]['height'] = $vs['height'];
                    $ia[$ks]['left'] = $vs['left'];
                    $ia[$ks]['top'] = $vs['top'];
                }
            }
            if (empty($ia)){
                $ijs = '';
            }else {
                $ijs = json_encode($ia);
            }
            if(empty($ta)){
                $tjs = '';
            }else{
                $tjs = json_encode($ta);
            }
            $arr[$k]['title'] = $v['title'];
            $arr[$k]['small_img'] = $v['small_img'];
            $arr[$k]['big_img'] = $v['big_img'];
            $arr[$k]['img_count'] = $v['img_count'];
            $arr[$k]['text_count'] = $v['text_count'];
            $arr[$k]['sort'] = $v['sort'];
            $arr[$k]['id'] = $v['id'];
            $arr[$k]['imgPosition'] = $ijs;
            $arr[$k]['textPosition'] = $tjs;
        }
        //dump($arr);

        //获取学校
        $school = M('school')->field('schoolid, school_name')->select();
        $this->assign('school', $school);
        $this->assign('info', $arr);
        $this->display();
    }

    public function add_info_post()
    {

        $this->assign('name', I('name'));
        $this->assign('name', I('year'));
        $this->assign('name', I('xueqi'));
        $this->assign('name', I('yue'));
        $this->display();
    }

    //获取模板的数据
    public function tempAjax()
    {
        $id = I('id');
        $select = M('temple_imgs_texts')->where("temple_id = $id")->select();
        if ($select){
            echo json_encode($select);
            exit();
        }
    }
    public function classAjax(){

    }
}