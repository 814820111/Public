<?php

/**
 * 后台首页  日常管理
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;

class SmsSchoolController extends AdminbaseController {


    public function index() {
        $this->_lists();
        $Province=role_admin();
        $this->assign("Province",$Province);
        $this->display();
    }
    public function showProduct()
    {
        $schoolid = I('schoolid');
        $productid = M('school_product')->where("schoolid = '$schoolid' and producttype = 1")->order("id desc")->field("productid")->find();

        $product = M('product')->where("product like '%短信%' and isconsume = 0")->field("id,product,num")->select();


        foreach ($product as &$value){
            if($value[id] == $productid['productid']){
                $value['check'] = 1;
            }else{
                $value['check'] = 0;
            }
        }
        if ($product) {
            $info['status'] = true;
            $info['data'] = $product;
        }else{
            $info['status'] = false;
            $info['msg'] = 'field';
        }
        echo json_encode($info);
    }
    public function showlinshi()
    {
        $product = M('product')->where("product like '%短信%' and isconsume = 1")->field("id,product,num")->select();

        if ($product) {
            $info['status'] = true;
            $info['data'] = $product;
        }else{
            $info['status'] = false;
            $info['msg'] = 'field';
        }
        echo json_encode($info);
    }
    public function editProduct()
    {
        $data['schoolid'] = I('schoolid');
        $data['productid'] = I('productid');
        $data['producttype'] = 1;
        $data['add_month'] = date('Y-m',time());
        $data['add_day'] = date('Y-m-d H:i:s', time());
        $data['add_time'] = time();
        $save = M('school_product')->add($data);
        echo json_encode($save);
    }
    public function editlinshi()
    {
        $month = date('Y-m',time());
        $schoolid=I('schoolid');
        $linshiid = I('linshiid');
        $data['schoolid'] = $schoolid;
        $data['linshiid'] = $linshiid;
        $data['producttype'] = 2;
        $data['add_month'] = $month;
        $data['add_day'] = date('Y-m-d H:i:s', time());
        $data['add_time'] = time();
        $save = M('school_product')->add($data);

        $messages = M("SmsSchool")->where("schoolid = $schoolid and month = '$month'")->find();
        $product = M("Product")->where("id = '$linshiid'")->find();
        if(empty($product[num])){
            $product[num] = 0;
        }
        if(empty($messages)){  //重置短信发送次数
            $messagea = M("SmsSchool")->where("schoolid = $schoolid")->order("id desc")->find();
            $num = M("SchoolProduct")
                ->alias('sp')
                ->join("wxt_product p ON p.id=sp.productid")
                ->where("sp.schoolid = $schoolid and sp.producttype = 1")->order("sp.id desc")->field("p.num")->find();
            if(empty($num[num])){
                $num[num]=0;
            }
            if($messagea) {
                if ($messagea[lognum] > $messagea[taocannum]) {
                    $numss = $messagea[num] - $messagea[lognum] + $num[num]+ $product[num];
                } else {
                    $numss = $messagea[num] - $messagea[taocannum] + $num[num]+ $product[num];
                }
            }else{
                $numss = $num[num]+ $product[num];
            }
            $data['schoolid'] = $schoolid;
            $data['num'] = $numss;
            $data['lognum'] = 0;
            $data['taocannum'] = $num[num];
            $data['month'] = $month;
            M("SmsSchool")->add($data);

            $value['num']=$numss;
            $value['lognum']=0;
        }else{
            $data['num'] = $messages[num]+$product[num];
            M("SmsSchool")->where("schoolid = $schoolid and month = '$month'")->save($data );
        }
        echo json_encode($save);
    }

    private function _lists()
    {
        $schoolid = I("schoolid");
        $province = I("province");
        $citys = I('citys');
        $message_type = I('message_type');
        $keyword = I('keyword');
        if($keyword)
        {
            $this->assign("keyword",$keyword);
            $where['s.school_name']= array("like","%".$keyword."%");
        }
        if($schoolid)
        {
            $this->assign("schoolid",$schoolid);
            $where['s.schoolid']=$schoolid;
        }
        if($province)
        {
            $this->assign("province",$province);
            $where['s.province']=$province;
        }
        if($citys){
            $this->assign("new_citys",$citys);
            $where['s.city']=$city;
        }
        if($message_type)
        {
            $this->assign("new_message_type",$message_type);
            $where['s.area']=$message_type;
        }
        $count=M("school")
            ->alias("s")
           // ->join("wxt_school_product sp ON sp.schoolid=s.schoolid")
            ->where($where)
            ->field('s.schoolid,s.school_name')
            ->count();
        $page = $this->page($count, 20);
        $school=M("school")
            ->alias("s")
          //  ->join("wxt_school_product s ON sp.schoolid=s.schoolid")
            ->where($where)
            ->field('s.schoolid,s.school_name')
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();
        foreach ($school as &$value){
            $schoolids = $value['schoolid'];
            $product = M('school_product')
                ->alias('sp')
                ->join("wxt_product p ON p.id=sp.productid")
                ->where("sp.schoolid = '$schoolids' and sp.producttype = 1")->order("sp.id desc")->field("p.product,p.num")->find();
            $value['product']=$product['product'];
            if($product['product']){

                $month = date('Y-m',time());
                $messages = M("SmsSchool")->where("schoolid = $schoolids and month = '$month'")->find();
                $value['num']=$messages['num'];
                $value['lognum']=$messages['lognum'];

                if(empty($messages)){  //重置短信发送次数
                    $messagea = M("SmsSchool")->where("schoolid = $schoolids")->order("id desc")->find();
                    $num = M("SchoolProduct")
                        ->alias('sp')
                        ->join("wxt_product p ON p.id=sp.productid")
                        ->where("sp.schoolid = $schoolids and sp.producttype = 1")->order("sp.id desc")->field("p.num")->find();
                    if(empty($num[num])){
                        $num[num]=0;
                    }
                    if($messagea) {
                        if ($messagea[lognum] > $messagea[taocannum]) {
                            $numss = $messagea[num] - $messagea[lognum] + $num[num];
                        } else {
                            $numss = $messagea[num] - $messagea[taocannum] + $num[num];
                        }
                    }else{
                        $numss = $num[num];
                    }
                    $data['schoolid'] = $schoolids;
                    $data['num'] = $numss;
                    $data['lognum'] = 0;
                    $data['taocannum'] = $num[num];
                    $data['month'] = $month;
                    M("SmsSchool")->add($data);

                    $value['num']=$numss;
                    $value['lognum']=0;
                }
                $value['xxnum']=$value['num']-$value['lognum'];
            }
        }
        $this->assign("Page", $page->show('Admin'));
        $this->assign("school",$school);
    }
}