<?php

/**
 * 附件上传
 */
namespace Asset\Controller;
use Common\Controller\AdminbaseController;
class AssetController extends AdminbaseController {


    function _initialize() {
    	$adminid=sp_get_current_admin_id();
    	$userid=sp_get_current_userid();
    	if(empty($adminid) && empty($userid)){
    		// exit("非法上传！");
    	}
    }

    /**
     * swfupload 上传 
     */
    public function swfupload() {
        // exit();
        if (IS_POST) {
			
            //上传处理类
            $config=array(
                // 'rootPath' => './'.C("UPLOADPATH"),
            		'rootPath' => './'.C("UPLOADPATH_SELF"),
            		'savePath' => '',
            		'maxSize' => 11048576,
            		'saveName'   =>    array('uniqid',''),
            		'exts'       =>    array('jpg', 'gif', 'png', 'jpeg',"txt",'zip'),
            		'autoSub'    =>    false,
            );
			$upload = new \Think\Upload($config);// 
			$info=$upload->upload();
            //开始上传
            if ($info) {
                //上传成功
                //写入附件数据库信息
                $first=array_shift($info);
                if(!empty($first['url'])){
                	$url=$first['url'];
                }else{
                	$url=C("TMPL_PARSE_STRING_SELF.__UPLOAD__").$first['savename'];
                }
                
				echo "1," . $url.",".'1,'.$first['name'];
				exit;
            } else {
                //上传失败，返回错误
                exit("0," . $upload->getError());
            }
        } else {
            $this->display(':swfupload');
        }
    }

	
    /**
     * swfupload 上传  新路径uploads/microblog
     */
    public function swfupload_self() {
     // exit();

        if (IS_POST) {

            //先注释
            // $savepath=date('Ymd').'/';

            // 原来的： 'rootPath' => './'.C("UPLOADPATH"),
            //上传处理类
            // var_dump(C("UPLOADPATH"));

            $config=array(
                    'rootPath' => './'.C("UPLOADPATH_SELF"),
                    'savePath' => $savepath,
                    'maxSize' => 11048576,
                    'saveName'   =>    array('uniqid',''),
                    'exts'       =>    array('jpg', 'gif', 'png', 'jpeg',"txt",'zip'),
                    'autoSub'    =>    false,
            );
            // var_dump($config);
            $upload = new \Think\Upload($config);// 
            $info=$upload->upload();
            //开始上传
            if ($info) {
                //上传成功
                //写入附件数据库信息
                $first=array_shift($info);
                if(!empty($first['url'])){
                    $url=$first['url'];
                }else{
                    $url=C("TMPL_PARSE_STRING_SELF.__UPLOAD__").$savepath.$first['savename'];
                }
                
                echo "1," . $url.",".'1,'.$first['name'];
                exit;
            } else {
                //上传失败，返回错误
                exit("0," . $upload->getError());
            }
        } else {
            $this->display(':swfupload_self');
        }
    }





}
