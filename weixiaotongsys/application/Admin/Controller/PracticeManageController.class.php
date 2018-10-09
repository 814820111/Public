<?php

/**
 * 后台首页  业务管理
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
header("Content-type: text/html; charset=utf-8");
class PracticeManageController extends AdminbaseController {
    function _initialize() {
        parent::_initialize();
        $this->agent_model = D("Common/Agent");
        $this->wxtuser_model = D("Common/wxtuser");
        $this->school_model = D("Common/School");
        $this->pay_model = D("Common/Pay_record");
    }
    //业务管理首页
    public function index() {
        echo "业务管理";
    }
    //产品管理
    public function goods(){
//        $searchname=$_POST['searchname'];
//        if(!empty($searchname)){
//                $where["name"]=array('LIKE',"%".$searchname."%");
//        }
//        $goods_model=M("shopping_goods");
//        $where["status"]=1;
//        $count=$goods_model->where($where)->count();
//        $page = $this->page($count, 20);
//        $lists=$goods_model
//         ->where($where)
//         ->limit($page->firstRow . ',' . $page->listRows)
//         ->order("id DESC")
//         ->select();
//        //取图片路径
//        foreach ($lists as $key => $val) {
//            $itemid=$val["id"];
//            if($val['picture']){
//                if(stripos($val['picture'],",")){
//                    $temp = explode(",", $val['picture']);
//                    $lists[$key]['picture'] = $temp[0];
//                }else{
//                    $lists[$key]['picture'] = $val['picture'];
//                }
//            }
//        }
//        $this->assign("Page", $page->show('Admin'));
//        $this->assign("current_page",$page->GetCurrentPage());
//        $this->assign("post",$_GET);
//        $this->assign('lists', $lists);
//        $arr=$goods_model->where('status=1')->count();
//        $this->assign('arr',$arr);
//    	$this->display();
        $searchname=$_POST['searchname'];
        if(!empty($searchname)){
            $where["product"]=array('LIKE',"%".$searchname."%");
        }
        //表示上家产品
        $result = M("product")->where($where)->select();


        $this->assign("list",$result);
        $this->display();
    }
    //产品管理
    public function goodsadd(){
        //获取所有的链接然后拼接成一个权限管控
        $url  = M("nav")->where(array("app"=>"Teacher"))->select();
        $this->assign("nav",$url);
        $this->display();
    }
    public function goodsadd_post(){
//        var_dump(I());
//        die();
        $data['price'] = $_POST['price'];//单价
        $data['product']=$_POST['product'];//名称
        $data['description'] = $_POST['description'];//单价
        $data['num'] = $_POST['num'];//数量
        $data['isconsume'] = $_POST['isconsume'];//是否为消耗品
        $data['productcode'] = rand(100000,999999);//产品标识

        $nid  = M("product")->add($data);
//       $gid = $goods->add($data);
        if($nid){
            $this->success("添加成功",U('goods'));
        } else {
            $this->success("添加失败");
        }
    }

    /*批量删除*/
    public function goodsdel(){
        $id=$_POST['id'];
        if(!is_numeric($id)){
            $goods_id = $id;
            $where = array("id" => array("in" , $goods_id));
            //print_r($where);die;//
        }else{
            $goods_id = $_POST['id'];
            $where = array("id" => $goods_id);
        }
        $goods = M("product");
        $re = $goods->where($where)->delete();
        if($re !== false){
            echo json_encode(array("error" => 0 , 'errMsg' => '删除成功'));exit();
        }else{
            echo json_encode(array("error" => 1 , 'errMsg' => '删除失败'));exit();
        }
    }
    /*批量下架*/
    public function goodsxiajia(){
        $id=$_POST['id'];
        //print_r($id);die;
        $goods = M("product");
        if(!is_numeric($id)){
            $goods_id = $id;
            $where = array("id" => array("in" , $goods_id));
        }else{
            $goods_id = $_POST['id'];
            $where = array("id" => $goods_id);
        }
        $re = $goods->where($where)->save(array("racking" => 0));
        if($re !== false){
            $this->error("下架失败");die;
            // $this->success("下架成功");die;
        }else{
            $this->error("下架失败");die;
        }
    }
    /*产品删除*/
    public function goodsdelete(){
        $goods=M("product");
        $id=$_GET['id'];

        // $goods->where(array('id' => $id))->delete();
        $count=$goods->delete($id);
        if($count>0){
            $this->success("删除成功");
        }else{
            $this->error("删除失败");
        }
    }
    /*产品编辑*/
    public function goodsedit(){
        $id=$_GET['id'];

        // $GR=M("goods_relation");

        $product = M("product")->where("id = $id")->find();

        $this->assign("product",$product['product']);
        $this->assign("price",$product['price']);
        $this->assign("description",$product['description']);
        $this->assign("num",$product['num']);
         $this->assign("isconsume",$product['isconsume']);
        $this->assign("id",$id);
        $this->display("edit");
    }



    /**
     * 编辑产品
     */
    public function edit_post() {
        $m=M("product");

        //$data['name']=$_POST['name'];
        $data['product'] = $_POST['product'];
        $data['price'] = $_POST['price'];
        $data['description'] = $_POST['description'];
        $data['num'] = $_POST['num'];
        $data['isconsume'] = $_POST['isconsume'];
        //$data['description']=$_POST['description'];
        //$data['unit'] = $_POST['unit'];
        // $data['showid'] = $_POST['showid'];

        $condition['id'] = $_POST['id'];
        $result = $m->where($condition)->save($data);

        if($result){
            $this->success('数据更新成功',U('goods'));die();
        }else{
            $this->success("数据更新失败！");die();
        }


    }
    /*上架*/
    public function goodssj(){
        $id=$_POST['id'];
        if(!empty($_POST['id'])){
            $goods = M("product");
            $re = $goods->where(array("id" => $id))->save(array("racking" => 0));
            if($re){
                echo json_encode(array("error" => 0 , "Msg" => '下架'));
            }else{
                echo json_encode(array("error" => 1));
            }
        }
    }

    /*下架*/
    public function goodsxj(){
        $id=$_POST['id'];
        if(!empty($_POST['id'])){
            $goods = M("product");
            $re = $goods->where(array("id" => $id))->save(array("racking" => 1));
            if($re){
                echo json_encode(array("error" => 1 , "Msg" => '上架'));
            }else{
                echo json_encode(array("error" => 0));
            }
        }
    }
    /*下架*/
    public function mealxj(){
        $id=$_POST['id'];
        if(!empty($_POST['id'])){
            $goods = M("package");
            $re = $goods->where(array("id" => $id))->save(array("type" => 2));
            if($re){
                echo json_encode(array("error" => 1 , "Msg" => '下架'));
            }else{
                echo json_encode(array("error" => 0));
            }
        }
    }
    /*上架*/
    public function mealsj(){
        $id=$_POST['id'];
        if(!empty($_POST['id'])){
            $goods = M("package");
            $re = $goods->where(array("id" => $id))->save(array("type" => 1));
            if($re){
                echo json_encode(array("error" => 0 , "Msg" => '上架'));
            }else{
                echo json_encode(array("error" => 1));
            }
        }
    }
    // 查看套餐列表
    public function meal(){
        $searchname=$_POST['searchname'];
        if(!empty($searchname)){
            $where["combo"]=array('LIKE',"%".$searchname."%");
        }
        $goods_model=M("package");

        $lists=$goods_model
            ->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)
            ->order("id DESC")
            ->select();





        $this->assign('lists', $lists);
        $this->display();
    }
    public function mealedit()
    {
        $goods_model=M("product");
        $id = I("id");


        $package = M("package")->where("id = $id")->find();




        $sales = M("sales")->order("id DESC")->field("name,id")->select();


        $this->assign("sales",$sales);
        $this->assign("sales_info",$package['salesid']);
        $this->assign("id",$id);
        $this->assign('goodslist', $lists);
        $this->assign("combo",$package);
        $this->display();
    }

    public function mealedit_post()
    {
        $id = I("id");
        $datas['name'] = $_POST['name'];
        $datas['price'] = $_POST['price'];
        $datas['description'] = $_POST['description'];
        $datas['time_type'] = $_POST['time_type'];
        $datas['type'] = $_POST['type'];
        $datas['tryoutmonth'] = $_POST['tryoutmonth'];
        $datas['salesid'] = $_POST['sales'];

        $meal=M("package");









        $result= $meal->where("id = $id")->save($datas);



        if($result || $res){
            $this->success('数据更新成功',U('meal'));die();
        }else{
            $this->success("数据更新失败！");die();
        }

        $this->assign('goodslist', $lists);
        $this->assign("combo",$combo);
        $this->display();
    }


    public function addmeal(){
        $goods_model=M("product");

        $agent_model = M("agent");

        $lists=$goods_model
            ->where($where)
            ->order("id DESC")
            ->select();
        $agent = $agent_model->order("id DESC")->field("id,name")->select();

        $sales = M("sales")->order("id DESC")->field("name,id")->select();

        $this->assign("sales",$sales);
        $this->assign("agent",$agent);
        $this->assign('goodslist', $lists);
        $this->display();
    }


    public function addmeal_post(){
        $meal=M("package");


        $data['name']=$_POST['name'];
        $data['price'] = $_POST['price'];
        $data['description']=$_POST['description'];
        $data['time_type'] = $_POST['time_type'];
        $data['type'] = $_POST['type'];
        $data['salesid'] = $_POST['sales'];
        $data['agent'] = $_POST['agentid'];
        $data['tryoutmonth'] = $_POST['tryoutmonth'];



        $mealid = $meal->add($data);

        $agent_data['agentid'] = $_POST['agent'];
        $agent_data['packageid'] = $mealid;
        $agent_data['status'] =1;

        $agent_package = M("agent_package")->add($agent_data);



        if($mealid){
            $this->success("添加成功");
        } else {
            $this->success("添加失败");
        }
    }

    public function mealdelete(){
        $meal=M("package");
        $id=$_GET['id'];

            // $goods->where(array('id' => $id))->delete();
        $count=$meal->delete($id);

        $agent = M('agent_package')->where("packageid = $id")->delete();
        if($count>0){
            $this->success("删除成功");
        }else{
            $this->error("删除失败");
        }
    }
    public function orders(){
        $count=$this->pay_model
            ->alias('a')
            ->join("".C('DB_PREFIX')."city c ON a.city=c.term_id")
            ->where("a.status =1 or 0 or 2")
            ->count();
        $page = $this->page($count, 20);
        $lists = $this->pay_model
            ->alias('a')
            ->join("".C('DB_PREFIX')."wxtuser c ON a.studentid=c.id")
            ->field("a.*,c.name as studentname")
            ->order("a.time DESC")
            ->where("a.status =1 or 0 or 2")
            ->order("a.status DESC ,a.create_time DESC")
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();
        $this->assign("page", $page->show('Admin'));
        $this->assign("agent",$agent);
        $this->display();
    }

    //查看销售品列表
    public function sales()
    {
        $sales = M("sales")->select();

        $this->assign("sales",$sales);
        $this->display();
    }
    public function addsales()
    {
        $goods_model=M("product");
        $lists=$goods_model
            ->where($where)
            ->order("id DESC")
            ->select();
        $this->assign('goodslist', $lists);
        $this->display();
    }
    public function addsales_post(){
        $meal=M("sales");

        $relation = M("sales_product");
        $goods = I("goods");
        $data['name']=$_POST['name'];

        $data['description']=$_POST['description'];




        $mealid = $meal->add($data);



        foreach ($goods as  $value) {
            $data['salesid'] = $mealid;
            $data['productid'] = $value;
            $alldata[] = $data;
            unset($data);
        }

        $result = $relation->addAll($alldata);

        if($mealid){
            $this->success("添加成功");
        } else {
            $this->success("添加失败");
        }
    }

    public function salesedit()
    {
        $goods_model=M("product");
        $id = I("id");


        $package = M("sales")->where("id = $id")->find();

        $packageid = M("sales_product")->where("salesid = $id")->select();

        $lists=$goods_model
            ->where($where)
            ->order("id DESC")
            ->select();
        foreach($lists as &$value)
        {
            foreach($packageid as $val)
            {
                if($value['id']==$val['productid'])
                {
                    $value['checked'] = 'checked';
                }
            }
        }


        $this->assign("id",$id);
        $this->assign('goodslist', $lists);
        $this->assign("combo",$package);
        $this->display();
    }

    public function salesedit_post()
    {
        $id = I("id");
        $datas['name'] = $_POST['name'];

        $datas['description'] = $_POST['description'];


        $meal=M("sales");


        $goods = I("goods");
        $relation = M("sales_product")->where("salesid = $id")->delete();

        if($goods)
        {
            foreach ($goods as  $value) {
                $data['salesid'] = $id;
                $data['productid'] = $value;
                $alldata[] = $data;
                unset($data);
            }
            $res = M("sales_product")->addAll($alldata);
        }



        $result= $meal->where("id = $id")->save($datas);



        if($result || $res){
            $this->success('数据更新成功',U('sales'));die();
        }else{
            $this->success("数据更新失败！");die();
        }

        $this->assign('goodslist', $lists);
        $this->assign("combo",$combo);
        $this->display();
    }


    public function salesdelete(){
        $goods=M("sales");
        $id=$_GET['id'];

        // $goods->where(array('id' => $id))->delete();
        $count=$goods->delete($id);

        if($count)
        {
            M('sales_product')->where(array('salesid'=>$id))->delete();
        }
        if($count>0){
            $this->success("删除成功");
        }else{
            $this->error("删除失败");
        }
    }
    public function authorization(){
        $this->display();
    }

    public function school(){
        //查询结果分页
        $count=$this->school_model->where("school_status =1 or 0 or 2")->count();
        $page = $this->page($count, 20);
        $school = $this->school_model
            ->alias('s')
            ->join("".C('DB_PREFIX').'agent a ON s.agent_id=a.id')
            ->where("school_status =1 or 0 or 2")
            ->field("s.*,a.name as agent_name")
            ->order("school_status DESC,s.create_time DESC")
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();
        $meal_model=M("shopping_meal");
        foreach ($school as $key => $val) {
            $meal_array = explode(",", $school[$key]["meallist"]);
            $mealname = "";
            foreach ($meal_array as $key => $vo) {
                $meal_where['id']=$vo;
                $meal=$meal_model->where($meal_where)->find();
                if($mealname){
                    $mealname=$mealname.",".$meal["name"];
                }else{
                    $mealname=$meal["name"]."";
                }
            }
            $school[$key]['mealname'] = $mealname;

        }
        $this->assign("page", $page->show('Admin'));
        $this->assign("school",$school);
        $this->display();
    }

    //体验期设置
    public function experience()
    {

        $Province=role_admin();




        $this->assign("Province",$Province);

        $this->display("experience");
    }

    //体验期设置
    public function experience_show()
    {
        $student_package = M("student_package");
        $schoolid = I("schoolid");

//        $gradeid = I('gradeid');

        $classid = I('classid');

        if($schoolid)
        {

            if($classid)
            {
                $where['sp.classid'] =$classid;
            }
            $where['sp.schoolid'] = $schoolid;
            $where['relation.type'] = 1;
            $count = $student_package
                ->alias("sp")
                ->join("wxt_school school ON sp.schoolid = school.schoolid")
                ->join("wxt_agent agent ON sp.agentid= agent.id")
                ->join("wxt_school_class class ON sp.classid = class.id")
                ->join("wxt_student_info info ON sp.studentid = info.userid")
                ->join("wxt_relation_stu_user relation ON sp.studentid = relation.studentid")
                ->join("wxt_package package ON sp.packageid = package.id")
                ->count();
            $page = $this -> page($count, 10);
            $stu_package = $student_package
                ->alias("sp")
                ->join("wxt_school school ON sp.schoolid = school.schoolid")
                ->join("wxt_agent agent ON sp.agentid= agent.id")
                ->join("wxt_school_class class ON sp.classid = class.id")
                ->join("wxt_student_info info ON sp.studentid = info.userid")
                ->join("wxt_relation_stu_user relation ON sp.studentid = relation.studentid")
                ->join("wxt_package package ON sp.packageid = package.id")
                ->where($where)
                ->field("sp.id,sp.phone,sp.add_time,sp.begin_time,sp.edit_time,school.school_name,agent.name as agent_name,class.classname,info.stu_name,relation.phone as parent_phone,package.name as package_name,sp.tryoutmonth")
                -> limit($page -> firstRow . ',' . $page -> listRows)
                ->select();
            foreach($stu_package as &$value)
            {
                switch($value['tryoutmonth']){
                    case '1':
                        $value['tryoutmonth'] = '1个月';
                        break;
                    case '2':
                        $value['tryoutmonth'] = '2个月';
                        break;
                    case '3':
                        $value['tryoutmonth'] = '3个月';
                        break;
                    case '4':
                        $value['tryoutmonth'] = '4个月';
                        break;
                    default:

                        break;
                }

            }

            $Page[] =  $page -> show('Admin');
            ;
            $result = array_merge($Page,$stu_package);


            if (!empty($result)){
                $ret = $this->format_ret_else(1,$result);

                echo json_encode($result);
                //echo $Page;


                // $this -> assign("Page", $page -> show('Admin'));

            }else{
                $ret = $this->format_ret_else(0,"parms lost");
                $this -> assign("Page", $page -> show('Admin'));
                echo json_encode($ret);

            }

            exit();
        }






        $this->display("experience");
    }

    public function experience_time()
    {
        $student_package = M("student_package");
        $packageid = I('id');
        $tryoutmonth = I("tryoutmonth");

        foreach ($packageid as $value)
        {
            $stu_time = $student_package->where("id = $value")->getField("begin_timeint");

            $time = date("Y-m-d", strtotime("+$tryoutmonth months", $stu_time));

            $time_int = strtotime($time);

            $result = $student_package->where("id = $value")->save(array('end_time'=>$time,'end_timeint'=>$time_int,"tryoutmonth"=>$tryoutmonth,"edit_time"=>date("Y-m-d H:i:s",time())));



        }
        if($result){
            $ret = $this->format_ret_else(1,$result);
        }else{
            $ret = $this->format_ret_else(0,"lost params");
        }
        echo json_encode($ret);
        exit;




    }
    public function customization(){

        $package = M("package");

        $Province=role_admin();

        $meal = $package->select();

        $this->assign("meal",$meal);
        $this->assign("Province",$Province);
        $this->display();
    }

    public function customization_show()
    {

        $student_package = M("student_package");
        $student_info = M("student_info");

        $schoolid = I("schoolid");

        $classid = I('classid');

        $package = I('package');

        $tiaojian = I("tiaojian");

        $shuzhi = I("shuzhi");
        //订单状态
        $order = I("order");
        //时间
        $begin = I('begin');
        $end = I('end');



        if ($tiaojian != "0" && $shuzhi != "") {
            if($tiaojian=='stu_name')
            {
                $where["info.$tiaojian"] = array('like', "%$shuzhi%");
            }else{
                $where["relation.$tiaojian"] = array('like', "%$shuzhi%");
            }

//            $where["s.$tiaojian"] = array('like', "%$shuzhi%");
        }

        if($package){
            $where['package.packageid'] = $package;
            $where_package['sp.packageid'] = $package;
            $join = 'wxt_student_package package ON info.userid = package.studentid';
        }

        if($classid)
        {
            $where['class.id'] = $classid;
            $where_package['sp.classid'] = $classid;
        }

        if($order)
        {
            $where['package.oder_status'] = $order;
            $where_package['sp.oder_status'] = $order;
            $join = 'wxt_student_package package ON info.userid = package.studentid';
        }

        if($begin && $end)
        {
            $where['package.edit_time'] = array(array('EGT',$begin),array('ELT',$end));
            $where_package['sp.edit_time'] =  array(array('EGT',$begin),array('ELT',$end));

            $join = 'wxt_student_package package ON info.userid = package.studentid';
        }

        if($schoolid)
        {
            $where['info.schoollid'] = $schoolid;
            $where['relation.type'] = 1;
            //先查出学生
            $count = $student_info
                ->alias('info')
                ->join("wxt_school_class class ON info.classid = class.id")
                ->join("wxt_school school ON info.schoollid = school.schoolid" )
                ->join("wxt_relation_stu_user relation ON info.userid = relation.studentid")
                ->join("wxt_agent agent ON school.agent_id= agent.id")
                ->join($join)
                ->field("info.stu_name,info.userid,class.classname,school.school_name,relation.phone")
                ->where($where)
                ->count();

            $page = $this -> page($count, 15);
            $customization = $student_info
                ->alias('info')
                ->join("wxt_school_class class ON info.classid = class.id")
                ->join("wxt_school school ON info.schoollid = school.schoolid" )
                ->join("wxt_agent agent ON school.agent_id= agent.id")
                ->join("wxt_relation_stu_user relation ON info.userid = relation.studentid")
//                          ->join('wxt_student_package package ON info.userid = package.studentid')
                ->join($join)
                ->field("info.stu_name,info.userid,class.classname,school.school_name,relation.phone as parent_phone,relation.charging_phone,agent.name as agent_name")
                ->where($where)
                -> limit($page -> firstRow . ',' . $page -> listRows)
                ->select();


            //todo根据学生id去重 因为学生id是唯一的所有按学生id去重
            $customization = $this->array_unset_tt($customization,'userid');



            foreach ($customization as &$value) {

                $studentid = $value['userid'];

                $where_package['sp.studentid'] = $studentid;
                $package = $student_package
                    ->alias("sp")
                    ->join("wxt_package package ON sp.packageid=package.id")
//                       ->join("wxt_agent agent ON sp.agentid= agent.id")
                    ->where($where_package)
                    ->field("sp.id,sp.use_status,sp.phone,sp.oder_status,sp.edit_time,sp.add_time,package.name as package_name,package.id as packageid")
                    ->select();
                foreach ($package as &$val) {
                    if ($val['use_status'] == 1) {
                        $val['use_status'] = '开通';
                    }
                    if ($val['use_status'] == 2) {
                        $val['use_status'] = '转收费';
                    }
                    if ($val['use_status'] == 3) {
                        $val['use_status'] = '取消';
                    }
                    if ($val['oder_status'] == 1) {
                        $val['oder_status'] = '免费';
                    }
                    if ($val['oder_status'] == 2) {
                        $val['oder_status'] = '收费';
                    }
                    if ($val['oder_status'] == 3) {
                        $val['oder_status'] = '欠费';
                    }
                    if ($val['oder_status'] == 4) {
                        $val['oder_status'] = '退订';
                    }

                }

                $value['package'] = $package;
            }



            $Page[] =  $page -> show('Admin');

            $result = array_merge($Page,$customization);



            if (!empty($result)){
                $ret = $this->format_ret_else(1,$result);

                echo json_encode($result);
                //echo $Page;


                // $this -> assign("Page", $page -> show('Admin'));

            }else{
                $ret = $this->format_ret_else(0,"parms lost");
                $this -> assign("Page", $page -> show('Admin'));
                echo json_encode($ret);

            }

            exit();

        }
    }


    //excel 导出
    public function Lexcel_customization()
    {

        $student_package = M("student_package");
        $student_info = M("student_info");

        $schoolid = I("schoolid");

        $classid = I('classid');

        $package = I('package');

        $tiaojian = I("tiaojian");

        $shuzhi = I("shuzhi");
        //订单状态
        $order = I("order");
        //时间
        $begin = I('begin');
        $end = I('end');



        if ($tiaojian != "0" && $shuzhi != "") {
            if($tiaojian=='stu_name')
            {
                $where["info.$tiaojian"] = array('like', "%$shuzhi%");
            }else{
                $where["relation.$tiaojian"] = array('like', "%$shuzhi%");
            }

//            $where["s.$tiaojian"] = array('like', "%$shuzhi%");
        }

        if($package){
            $where['package.packageid'] = $package;
            $where_package['sp.packageid'] = $package;
            $join = 'wxt_student_package package ON info.userid = package.studentid';
        }

        if($classid)
        {
            $where['class.id'] = $classid;
            $where_package['sp.classid'] = $classid;
        }

        if($order)
        {
            $where['package.oder_status'] = $order;
            $where_package['sp.oder_status'] = $order;
            $join = 'wxt_student_package package ON info.userid = package.studentid';
        }

        if($begin && $end)
        {
            $where['package.edit_time'] = array(array('EGT',$begin),array('ELT',$end));
            $where_package['sp.edit_time'] =  array(array('EGT',$begin),array('ELT',$end));

            $join = 'wxt_student_package package ON info.userid = package.studentid';
        }

        if($schoolid)
        {
            $where['info.schoollid'] = $schoolid;
            $where['relation.type'] = 1;

            $customization = $student_info
                ->alias('info')
                ->join("wxt_school_class class ON info.classid = class.id")
                ->join("wxt_school school ON info.schoollid = school.schoolid" )
                ->join("wxt_agent agent ON school.agent_id= agent.id")
                ->join("wxt_relation_stu_user relation ON info.userid = relation.studentid")
                ->join($join)
                ->field("info.stu_name,info.userid,class.classname,school.school_name,relation.phone as parent_phone,relation.charging_phone,agent.name as agent_name")
                ->where($where)
                ->select();




            foreach ($customization as $key=>$value) {

                $studentid = $value['userid'];

                $where_package['sp.studentid'] = $studentid;
                $package = $student_package
                    ->alias("sp")
                    ->join("wxt_package package ON sp.packageid=package.id")
//                     ->join("wxt_agent agent ON sp.agentid= agent.id")
                    ->where($where_package)
                    ->field("sp.id,sp.use_status,sp.phone,sp.oder_status,sp.edit_time,sp.add_time,package.name as package_name,package.id as packageid")
                    ->select();
                if($package)
                {
                    unset($customization[$key]);

                    foreach ($package as &$val) {
                        $val['stu_name'] = $value['stu_name'];
                        $val['userid'] = $value['userid'];
                        $val['classname'] = $value['classname'];
                        $val['school_name'] = $value['school_name'];
                        $val['parent_phone'] = $value['parent_phone'];
                        $val['charging_phone'] = $value['charging_phone'];
                        $val['agent_name'] = $value['agent_name'];
                        if ($val['use_status'] == 1) {
                            $val['use_status'] = '开通';
                        }
                        if ($val['use_status'] == 2) {
                            $val['use_status'] = '转收费';
                        }
                        if ($val['use_status'] == 3) {
                            $val['use_status'] = '取消';
                        }
                        if ($val['oder_status'] == 1) {
                            $val['oder_status'] = '免费';
                        }
                        if ($val['oder_status'] == 2) {
                            $val['oder_status'] = '收费';
                        }
                        if ($val['oder_status'] == 3) {
                            $val['oder_status'] = '欠费';
                        }
                        if ($val['oder_status'] == 4) {
                            $val['oder_status'] = '退订';
                        }
                        array_push($customization,$val);

                    }

                }

            }


            $ExceData = array_merge($customization);
            // var_dump($ExceData);


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
            $objPHPExcel->getActiveSheet(0)->setCellValue('A1',"学校名称");
            $objPHPExcel->getActiveSheet(0)->setCellValue('B1',"所属SA");
            $objPHPExcel->getActiveSheet(0)->setCellValue('C1',"班级名称");
            $objPHPExcel->getActiveSheet(0)->setCellValue('D1',"学生姓名");
            $objPHPExcel->getActiveSheet(0)->setCellValue('E1',"手机号码");
            $objPHPExcel->getActiveSheet(0)->setCellValue('F1',"扣费号码");
            $objPHPExcel->getActiveSheet(0)->setCellValue('G1',"服务");
            $objPHPExcel->getActiveSheet(0)->setCellValue('H1',"最近更新");
            $objPHPExcel->getActiveSheet(0)->setCellValue('I1',"开通状态");
            $objPHPExcel->getActiveSheet(0)->setCellValue('J1',"订购状态");
            $Val = 2;
            for($i=0 ;$i<count($ExceData) ;$i++){


                $objPHPExcel->getActiveSheet(0)->setCellValue('A' . $Val, $ExceData[$i]['school_name']);
                $objPHPExcel->getActiveSheet(0)->setCellValue('B' . $Val, $ExceData[$i]['agent_name']);
                $objPHPExcel->getActiveSheet(0)->setCellValue('C' . $Val,' '.$ExceData[$i]['classname']);
                $objPHPExcel->getActiveSheet(0)->setCellValue('D' . $Val,' '.$ExceData[$i]['stu_name']);
                $objPHPExcel->getActiveSheet(0)->setCellValue('E' . $Val, $ExceData[$i]['parent_phone']);
                $objPHPExcel->getActiveSheet(0)->setCellValue('F' . $Val, $ExceData[$i]['charging_phone']);
                $objPHPExcel->getActiveSheet(0)->setCellValue('G' . $Val, $ExceData[$i]['package_name']);
                $objPHPExcel->getActiveSheet(0)->setCellValue('H' . $Val, $ExceData[$i]['edit_time']);
                $objPHPExcel->getActiveSheet(0)->setCellValue('I' . $Val, $ExceData[$i]['use_status']);
                $objPHPExcel->getActiveSheet(0)->setCellValue('J' . $Val, $ExceData[$i]['oder_status']);


                $Val++;
            }
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename=""');
            header('Cache-Control: max-age=0');

            $objWriter =\ PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            ob_clean();//关键
            flush();//关键
            $objWriter->save('php://output');
            exit;





//            if (!empty($result)){
//                $ret = $this->format_ret_else(1,$result);
//
//                echo json_encode($result);
//                //echo $Page;
//
//
//                // $this -> assign("Page", $page -> show('Admin'));
//
//            }else{
//                $ret = $this->format_ret_else(0,"parms lost");
//                $this -> assign("Page", $page -> show('Admin'));
//                echo json_encode($ret);
//
//            }
//
//            exit();

        }
    }
    function array_unset_tt($arr,$key){
        //建立一个目标数组
        $res = array();
        foreach ($arr as $k=>$value) {
            //查看有没有重复项

            if(isset($res[$value[$key]])){
                //有：销毁

                unset($value[$key]);

            }
            else{

                $res[$value[$key]] = $value;
            }
        }
        return $res;
    }

    public function customization_operation()
    {
        $student_package = M("student_package");

        $student_product = M("student_product");

        //操作标识
        $status = I("status");

        $schoolid = I("schoolid");
        //学生id
        $id = I("id");
        $package = I("pacid");
        $use_status = I("use_status");

        //修改原因
        $desc = I('desc');

        //获取代理商id
        $agentid = $this->get_agent($package);

        $error_info = array();

        //获取学生列表
        $result = $this->get_student($id,$status,$schoolid);

        $selesid = M("package")->where("id = $package")->getField('salesid');



        $product = M('sales_product')->where("salesid = $selesid")->select();



        foreach ($result as $value)
        {

            $studentid = $value['userid'];
            if($use_status==1)
            {
                $time = time();
                $show_package = $student_package->where("studentid  = $studentid and packageid = $package")->find();

                if($show_package)
                {
                    $change_package = $student_package->where("studentid  = $studentid and packageid = $package")->save(array("use_status"=>$use_status,"oder_status"=>1,"desc"=>$desc,"edit_time"=>date('Y-m-d H:i:s',time())));

                    //修改产品表
                    if($change_package) {
                        $change_product = $student_product->where("studentid  = $studentid and packageid = $package")->save(array("use_status" => $use_status, "desc"=>$desc,"oder_status" => 1, "edit_time" => date('Y-m-d H:i:s', time())));
                    }
                    $this->customization_pub_log(1,$package,$studentid,$value['charging_phone'],$show_package['agentid'],$schoolid,$value['classid'],$value['phone'],$use_status,time(),$desc,1);

                }else{
                    //获取代理商id
                    $agentid = $this->get_agent($package);
                    $data['agentid'] = $agentid;
                    $data['schoolid'] = $schoolid;
                    $data['classid'] = $value['classid'];
                    $data['studentid'] = $studentid;
                    $data['phone'] = $value['phone'];
                    $data['packageid'] = $package;
                    $data['status'] = 1;
                    $data['begin_time'] = date("Y-m-d H:i:s",$time);
                    $data['begin_timeint'] = $time;
                    $data['end_time'] =date("Y-m-d H:i:s", strtotime("+1 months",$time));
                    $data['end_timeint'] =strtotime("+1 months",$time);
                    $data['oder_status'] = 1;
                    $data['use_status'] = $use_status;
                    $data['add_time'] = date("Y-m-d H:i:s",$time);
                    $data['add_timeint'] = $time;
                    $data['edit_time'] = date("Y-m-d H:i:s",$time);
                    $data['desc'] = $desc;
                    $change_package = $student_package->add($data);


                    $this->customization_pub_log(1,$package,$studentid,$value['charging_phone'],$agentid,$schoolid,$value['classid'],$value['phone'],$use_status,time(),$desc,1);
                    if($change_package) {
                        foreach ($product as $v) {


                            $data['selesid'] = $selesid;
                            $data['productid'] = $v['productid'];
                            M('student_product')->add($data);
                        }
                    }



                }



            }

            if($use_status==2)
            {
                $show_package = $student_package->where("studentid  = $studentid and packageid = $package")->find();
                $time_type = I("time_type");
                $month = I('month');

                if ($time_type==3)
                {
                    $month = 4;
                }
                if($time_type==4)
                {
                    $month = 12;
                }
                //todo 转收费时时间暂定

                $save_data['use_status'] = $use_status;
                $save_data['oder_status'] = 2;
                $save_data['begin_time'] = date("Y-m-d H:i:s",time());
                $save_data['begin_timeint'] = time();
                $save_data['end_time'] = date("Y-m-d H:i:s", strtotime("+$month months",time()));
                $save_data['end_timeint'] = $use_status;
                $save_data['edit_time'] = date('Y-m-d H:i:s',time());
                $save_data['desc'] = $desc;

                $change_package = $student_package->where(array('studentid'=>$studentid,'packageid'=>$package))->save($save_data);
                if($change_package)
                {
                    $change_package = $student_product->where(array('studentid'=>$studentid,'packageid'=>$package))->save($save_data);
                }
                $this->customization_pub_log(2,$package,$studentid,$value['charging_phone']);
            }
            if($use_status==3)
            {
                $change_package = $student_package->where(array('studentid'=>$studentid,'packageid'=>$package))->save(array("use_status"=>$use_status,"oder_status"=>4,"desc"=>$desc,"edit_time"=>date('Y-m-d H:i:s',time())));
                if($change_package)
                {
                    $change_package = $student_product->where(array('studentid'=>$studentid,'packageid'=>$package))->save(array("use_status"=>$use_status,"oder_status"=>4,"desc"=>$desc,"edit_time"=>date('Y-m-d H:i:s',time())));
                }
                $this->customization_pub_log(2,$package,$studentid,$value['charging_phone']);
            }

        }


//        $result = $student_package->where($where)->save(array("use_status"=>$use_status,"packageid"=>$package));


        if (!empty($change_package)){
            $ret = $this->format_ret_else(1,$result);

            echo json_encode($ret);


        }else{
            $ret = $this->format_ret_else(0,"parms lost");

            echo json_encode($ret);

        }




    }
    //查询定制
    public function quire_customization()
    {
        $package = M("package");

        $Province=role_admin();

        $meal = $package->select();

        $this->assign("meal",$meal);
        $this->assign("Province",$Province);
        $this->display();

    }

    public function  ope_customization()
    {
        $student_package  =M('student_package');
        $student_product =M('student_product');
        //状态标识1为退订2为删除
        $type = I('type');
        //套餐id
        $id = I('id');

        $studentid =I("stuid");

        $package = I("package");

        if($type==1)
        {

            $package_cancel = $student_package->where("id = $id")->save(array("oder_status"=>4,"use_status"=>3,status=>3));
            if($package)
            {
                $product_cancel = $student_product->where(array("studentid"=>$studentid,"packageid"=>$package))->save(array("oder_status"=>4,"use_status"=>3,status=>3));
            }
        }else{
            $package_del = $student_package->where("id = $id")->delete();


            if($package_del)
            {
                $product_del = $student_product->where(array("studentid"=>$studentid,"packageid"=>$package))->delete();
            }
        }

        if($package_cancel || $package_del)
        {
            $info['status'] = true;
            $info['msg'] = $id;
        }else{
            $info['status'] = true;
            $info['info'] = '数据有误!';
        }
        echo json_encode($info);



    }
    //todo 数据库查询次数过多需要修改
    public function ope_selected()
    {
        $student_package  =M('student_package');
        $student_product =M('student_product');
        $id = I('id');

        $student = I('student');


        $package = I('package');






        //状态标识1为退订2为删除
        $type = I("type");





           $newArr = array();
           foreach ($student as $key => $val) {


               $newArr[] = array('studentid' => $student[$key], 'package' => $package[$key]);
           }


           if ($type == 1) {
               $where['id'] = array('in', $id);

               $package_save = $student_package->where($where)->save(array("oder_status" => 4, "use_status" => 3, status => 3));


               if ($package_save) {
                   $sql = '';
                   foreach ($newArr as $key => $value) {
                       $studentid = $value['studentid'];
                       $package = $value['package'];

                       $sql .= "update wxt_student_product set oder_status = 4,status = 3,use_status = 3 where studentid = $studentid and packageid = $package;";
                   }

                   $Model = D();
                   $Model->execute($sql);


               }


           } else {
               $where['id'] = array('in', $id);

               $package_del = $student_package->where($where)->delete();


               if ($package_del) {

                   foreach ($newArr as $key => $value) {
                       $studentid = $value['studentid'];
                       $package = $value['package'];
                       $student_product->where(array("studentid" => $studentid, "packageid" => $package))->delete();
                   }

               }
           }
           if ($package_del || $package_save) {
               $info['status'] = true;
               $info['msg'] = $id;
           } else {
               $info['status'] = true;
               $info['info'] = '数据有误!';
           }
           echo json_encode($info);


    }


    /*
     * $package 套餐id
     * $studentid学生id
     * $use_status 套餐状态
     * $use_status 订购状态
     *
     * */
    public function student_product($package,$studentid,$use_status,$use_status)
    {
        //$package
    }

    /*
     * $id为学生id
     * $status为获取是否是全部学生
     * */
    protected function get_student($id,$status,$schoolid=null)
    {
        $student_info = M("student_info");
        $where['rela.type'] = 1;
        if($status==1)
        {
            $where['info.userid'] = array("in",$id);

        }else{
            $where['info.schoollid'] = $schoolid;
        }
        $student = $student_info->alias("info")
            ->join("wxt_relation_stu_user rela ON info.userid=rela.studentid")
            ->field("info.userid,info.classid,rela.phone,rela.charging_phone")
            ->where($where)
            ->select();
        return $student;
    }


    //获取代理商id
    protected function get_agent($packageid)
    {
        $package = M("agent_package");
        $agentid = $package->where("packageid = $packageid")->getField("agentid");

        return $agentid;
    }


    //获取手机信息
    public function showqinshu()
    {
        $studentid = I('studentid');
        // var_dump($studentid);

        if ($studentid) {

            //先注释不启用
            $relation = M('relation_stu_user')->where("studentid = $studentid and type = 0")->field("name,phone,appellation")->select();

            $load= M('relation_stu_user')->where("studentid = $studentid and type = 1")->field("name,phone as parent_phone,charging_phone,appellation")->find();
            // var_dump($relation);

            $info["status"] = true;
            $info["msg"] = $relation;
            $info["load"] = $load;
            echo json_encode($info);


        }




    }
    /* 定制日志
     * $package 套餐id
     * $agentid 代理商id
     * $schoolid 学校id
     * $classid 班级id
     * $studentid 学生id
     * $phone 手机号码
     * $telephone 扣费号码
     * $use_status 套餐使用状态
     * $time 修改时间
     * $userid 修改人id
     * $desc 修改原因
     * $oder_status 订购状态
     * */

    public function customization_pub_log($type,$packageid,$studentid = null,$telephone,$agentid=null,$schoolid = null,$classid = null,$phone = null,$use_status = null,$time = null,$desc = null,$oder_status = null)
    {
        $userid = $_SESSION['ADMIN_ID'];
        if($type==1)
        {
            $data_log['agentid'] = $agentid;
            $data_log['schoolid'] = $schoolid;
            $data_log['classid'] = $classid;
            $data_log['studentid'] = $studentid;
            $data_log['phone'] = $phone;
            $data_log['telephone'] =$telephone;
            $data_log['packageid'] = $packageid;
            $data_log['type'] = 1;
            $data_log['use_status'] = $use_status;
            $data_log['time'] = $time;
            $data_log['userid'] = $userid;
            $data_log['desc'] = $desc;
            $data_log['oder_status'] = $oder_status;

            //$add_log = M("customization_log")->add($data_log);

        }else{
            $student_package = M("student_package")->where("packageid = $packageid and studentid = $studentid")->find();
            $data_log['agentid'] = $student_package['agentid'];
            $data_log['schoolid'] = $student_package['schoolid'];
            $data_log['classid'] = $student_package['classid'];
            $data_log['studentid'] = $student_package['studentid'];
            $data_log['phone'] = $student_package['phone'];
            $data_log['telephone'] =$telephone;
            $data_log['packageid'] = $packageid;
            $data_log['type'] = 1;
            $data_log['use_status'] = $student_package['use_status'];
            $data_log['time'] = time();
            $data_log['userid'] = $userid;
            $data_log['desc'] = $desc;
            $data_log['oder_status'] = $student_package['oder_status'];

        }
        $add_log = M("customization_log")->add($data_log);

    }

    //修改手机信息
    public function qinshu(){
        $data1 = I('qinshu1');

        $load = I("load");

        $student = I('studentid');


        $schoolid = I('schoolid');

        $sole_num = I("sole_num");

        if($sole_num)
        {
            M("relation_stu_user")->where(array("type"=>1,"studentid"=>$student,'schoollid'=>$schoolid))->save(array("phone"=>$sole_num));
        }

        if($load)
        {
            M("relation_stu_user")->where(array("type"=>1,"studentid"=>$student,'schoollid'=>$schoolid))->save(array("charging_phone"=>$load));
        }



        if(!empty($data1))
        {

            if ($data1[0]&&$data1[1]&&$data1[2]) {

                $old_phone = $data1[3];



                if(!$old_phone){

                    $datalist1['name'] = $data1[0];
                    $datalist1['password'] = md5('school');
                    $datalist1['phone'] = $data1[1];
                    $datalist1['schoolid'] = $schoolid;
                    $datalist1['create_time'] = time();
                    $insert1 = M('wxtuser')->add($datalist1);
                    $data_relate1['appellation'] = $data1[2];
                    $data_relate1['studentid'] = I('studentid');
                    $data_relate1['name'] = $data1[0];
                    $data_relate1['phone'] = $data1[1];
                    $data_relate1['userid'] = $insert1;
                    $data_relate1['time'] = time();
                    $relate1 = M('relation_stu_user')->add($data_relate1);
                    $info_siz = '添加成功';
                }else{


                    $showold = M('relation_stu_user')->where("phone = $old_phone")->field("phone,id")->find();
                    $id = $showold['id'];

                    $data1 = array(
                        'name'=>$data1[0],
                        'phone'=>$data1[1],
                        'appellation'=>$data1[2],

                    );

                    $save = M('relation_stu_user')->where("id = $id")->save($data1);
                    $info_siz = '添加成功';

                }
            }else{
                $this->error('数据不完整！');
            }
        }
        $data2 = I('qinshu2');

        if(!empty($data2)){

            if($data2[0]&&$data2[1]&&$data2[2]) {


                $old_phone2 = $data2[3];




                if(!$old_phone2){
                    $datalist2['name'] = $data2[0];
                    $datalist2['password'] = md5('school');
                    $datalist2['phone'] = $data2[1];
                    $datalist2['schoolid'] = $schoolid;
                    $datalist2['create_time'] = time();
                    $insert2 = M('wxtuser')->add($datalist2);
                    $data_relate2['appellation'] = $data2[2];
                    $data_relate2['name'] = $data2[0];
                    $data_relate2['phone'] = $data2[1];
                    $data_relate2['studentid'] = I('studentid');
                    $data_relate2['userid'] = $insert2;
                    $data_relate2['time'] = time();
                    $relate2 = M('relation_stu_user')->add($data_relate2);
                    $info_siz = '添加成功';
                }else{

                    $showold = M('relation_stu_user')->where("phone = $old_phone2")->field("phone,id")->find();
                    $id = $showold['id'];

                    $data2 = array(
                        'name'=>$data2[0],
                        'phone'=>$data2[1],
                        'appellation'=>$data2[2],

                    );

                    $save = M('relation_stu_user')->where("id = $id")->save($data2);
                    $info_siz = '添加成功';

                }


            }else{
                $this->error('数据不完整22!');
            }
        }


        $data3 = I('qinshu3');

        if(!empty($data3)){
            if($data3[0]&&$data3[1]&&$data3[2]){

                $old_phone3 = $data3[3];



                if(!$old_phone3){

                    $datalist3['name'] = $data3[0];
                    $datalist3['password'] = md5('school');
                    $datalist3['phone'] = $data3[1];
                    $datalist3['schoolid'] = $schoolid;
                    $datalist3['create_time'] = time();
                    $insert3 = M('wxtuser')->add($datalist3);
                    $data_relate3['appellation'] = $data3[2];
                    $data_relate3['name'] = $data3[0];
                    $data_relate3['phone'] = $data3[1];
                    $data_relate3['studentid'] = I('studentid');
                    $data_relate3['userid'] = $insert3;
                    $data_relate3['time'] = time();
                    $relate3 = M('relation_stu_user')->add($data_relate3);
                    $info_siz = '添加成功';
                }else{

                    $showold = M('relation_stu_user')->where("phone = $old_phone3")->field("phone,id")->find();
                    //var_dump($showold);

                    $id = $showold['id'];

                    $data3 = array(
                        'name'=>$data3[0],
                        'phone'=>$data3[1],
                        'appellation'=>$data3[2],

                    );

                    $save = M('relation_stu_user')->where("id = $id")->save($data3);
                    $info_siz = '添加成功';

                }
            }else{
                $this->error('数据不完整!');
            }

        }
        $info["status"] = true;
        $info["msg"] = $info_siz;




        echo json_encode($info);


    }


    public function editschoolmeal(){
        $this->display();
    }

    function format_ret_else ($status, $data='') {
        if ($status){
            //成功
            return array('status'=>'success', 'data'=>$data);
        }else{
            //验证失败
            return array('status'=>'error', 'data'=>$data);
        }
    }
    public function agentauthorization(){
        //查询结果分页
        $count=$this->agent_model
            //代理商标
            ->alias('a')
            //城市表
            //代理商的城市id = 城市的id
            ->join("".C('DB_PREFIX')."city c ON a.city=c.term_id")
            //->join("wxt_agent_combo as d on d.agentid=a.id")
            // ->join("wxt_combo as e on d.comboid=e.id")
            //在代理商的状态是1 || 2
            ->where("a.status =1 or 0 or 2")
            //这里是获取城市的代理商分别有多少个
            ->count();
        //分页操作
        $page = $this->page($count, 20);
        //这里是查找所有的代理商
        $agent = $this->agent_model
            ->alias('a')
            ->join("".C('DB_PREFIX')."city c ON a.city=c.term_id")
            //->join("wxt_agent_combo as d on d.agentid=a.id")
            // ->join("wxt_combo as e on d.comboid=e.id")
//            ->field("a.*,c.name as cityname,e.combo,d.status as state")
            ->field("a.*,c.name as cityname")
            ->order("a.time DESC")
            ->where("a.status =1 or 0 or 2")
            ->order("a.status DESC ,a.create_time DESC")
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();
        //拿到所有的信息就ok了 开始映射到前台
        //var_dump($agent);
        $this->assign("page", $page->show('Admin'));
        $this->assign("agent",$agent);
        $this->display();
    }


    //分配代理商套餐
    public function editagentmeal(){
        $agentid= I("agentid");
        $result = M("agent_package")->where("agentid=$agentid")->select();
        $package = M("package")->select();
        //dump($result);
        $this->assign("package",$package);
        $this->assign("agentid",$agentid);
        $this->assign("result",$result);
        $this->display();
    }
    //分配套餐提交
    public function agentmeal_post(){

        //dump($_POST);
        //die();
        $id = I("id");
        $package = I("packageid");//套餐ID
        $agentid = I("agentid");//代理商ID

        //dump($package);
        if(empty($package)){
            $this->error("请勾选套餐");
        }else{
            M("agent_package")->where("agentid=$agentid")->delete();
            foreach ($package as $k=>$value){
                $packageid = $value;
                //echo $packageid;
                $data['agentid'] = $agentid;
                $data['packageid'] = $packageid;
                $data['status'] = 1;
                $res  = M("agent_package")->add($data);
            }
        }
        //die();
//        if($id){
//            $data['packageid'] = $comboid;
//            $res = M("agent_package")->where("id=$id")->save($data);
//        }else{
//            $data['agentid'] = $agentid;
//            $data['packageid'] = $comboid;
//            $data['status'] = 1;
//            $res  = M("agent_package")->add($data);
//        }
        if($res){
            $this->success("修改成功");
        } else {
            $this->success("修改失败");
        }
        //dump($_POST);
    }
    //状态修改
    public function edit_status(){
        $state = I("state");
        $agentid = I("agentid");

        if($state==1){
            $data['status'] = 2;
        }else{
            $data['status'] = 1;
        }
        $res = M("agent_package")->where("agentid=$agentid")->save($data);

        if($res){
            $this->success("修改成功");
        } else {
            $this->success("修改失败");
        }
        //dump($_POST);
    }


//customization_log

    //导入定制
    //导入套餐页面
    public function ImportPackage(){
        //dump($_SESSION);
        $allcount=I('allcount');
        $successcount=I('successcount');
        $updatecount=I('updatecount');
        $info=I('info');
        $this->assign("allcount",$allcount);
        $this->assign("successcount",$successcount);
        $this->assign("updatecount",$updatecount);
        $this->assign("info",$info);

        $Province=role_admin();
        $this->assign("Province",$Province);
        $this->display();
    }

    //通过城市 找到代理商 通过代理商 找到套餐
    public function lookup(){
        $city=I("city");

        if($city!=""){

            $package = M("agent_package as a")
                ->join("wxt_package as b on a.packageid = b.id")
                ->join("wxt_agent as c on a.agentid = c.id")
                ->field("b.*")
                ->where("c.city=$city")
                ->select();
        }else{
            $ret = $this->format_ret(0,'参数缺失！');
        }

        echo json_encode(array('data'=> $package,'message'=>'10000'));
    }

    //导入提交
    public function import_post(){
//        dump($_POST);
//        die();
        $schoolid = intval(I('schoolid'));//学校ID
        $use_status = intval(I('use_status'));//1表示开通 2表示转收费
        $package = I("package");
        $packagearr = explode(",",$package);
        $packageid = $packagearr[0];//套餐ID
        $types = $packagearr[1];//套餐类型

        $desc = I("desc");//修改原因
        $m = I("month");
        if($m){
            $month = $m;
        }else{
            $month =1;
        }

        $allcount=0;
        $successcount=0;
        $updatecount=0;

        if(!$schoolid){
            $this->error("请选择学校");
        }
        if(!$package){
            $this->error("请选择套餐");

        }
//        if(!$schoolid){
//            $this->error("请选择学校");
//        }
        $upload = new \Think\Upload();// 实例化上传类

        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('xls', 'xlsx');// 设置附件上传类型
        $upload->rootPath  =      './'; // 设置附件上传根目录
        $upload->savePath  =      'uploads/SchoolData/'; // 设置附件上传（子）目录
        $upload->autoSub   = 	 false;//不自动生成子文件夹
        // 上传单个文件
        // 上传单个文件
        $info   =   $upload->uploadOne($_FILES['excel_file']);


        $type = $info['ext'];

        $file_name = $info['name'];
        // var_dump($_FILES);
        // exit();
        if(!$info){
            $this->error($upload->getError());
        }else{
            $file_puth = './'.$info['savepath'].$info['savename'];
            //文件上传成功，对文件进行解析
            // vendor('phpexcel_1.phpexcel');//导入类库
            require_once VENDOR_PATH.'PHPExcel/PHPExcel/IOFactory.php';
            require_once VENDOR_PATH.'PHPExcel/PHPExcel.php';
            if($info['ext']=='xlsx'){
                require_once VENDOR_PATH.'PHPExcel/PHPExcel/Reader/Excel2007.php';
                $objReader = \PHPExcel_IOFactory::createReader('Excel2007');//xlsx格式必须2007之后才能打开
            }else{
                require_once VENDOR_PATH.'PHPExcel/PHPExcel/Reader/Excel5.php';
                $objReader = \PHPExcel_IOFactory::createReader('Excel5');
            }
            //use excel2007 for 2007 format
            $objPHPExcel = $objReader->load($file_puth);

            // $objPHPExcel->setActiveSheetIndex(1);
            $sheet = $objPHPExcel->getSheet(0);// 读取第一个工作表(编号从 0 开始)

            $highestRow = $sheet->getHighestRow(); // 取得总行数

            $highestColumn = $sheet->getHighestColumn(); // 取得总列数
            //循环读取excel文件,读取一条,插入一条
            // $info='begin::';
            for($j=2;$j<=$highestRow;$j++)
            {
                for($k='A';$k<=$highestColumn;$k++)
                {
                    //读取单元格
                    $ExamPaper_arr[$j][$k]= $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
                    $allcount++;
                }
            }
            $info=$j.'-'.$k.':'.$info.$objPHPExcel->getActiveSheet()->getCell('A10')->getValue();
            //var_dump($info);
            // $info=$info.'end';
            $successcount=0;
            $error_info = array();
            $rowNo = 1;



            foreach ($ExamPaper_arr as $key => $value)
            {
                //循环数据检测A=>学生姓名，B=>班级，C=>监护人姓名，D=>家长联系方式，H=>关系, L=>性别，M=>学号，N=>IC卡号，O=>是否住校
                //如果题号或者题干不为空
                if(!empty($value['A'])||!empty($value['B'])){
                    $name=$value['A'];  //学生姓名
                    $phone=$value['B']; //手机号码
                    //$schoolid=$value['C']; //学校ID


                    $result=$this->importstudent(trim($name),trim($phone),trim($schoolid),$use_status,$packageid,$types,$desc,$month);

                    /**
                     * 导入教师以及关系数据到数据库
                     * return 1 导入成功
                     * return 2 没有这个学生
                     * return 3 你已经开通这个套餐,无需在开通
                     * return 4 找不到这个手机号码
                     * return 5 导入失败
                     */
                    if($result ==1){
                        $successcount++;
                    }else if($result ==2){
                        $error_item = array(
                            "row"=>$rowNo,
                            "msg"=>"该学校,没有这个学生"
                        );
                        array_push($error_info,$error_item);
                    }else if($result==3){
                        $error_item = array(
                            "row"=>$rowNo,
                            "msg"=>"你已经开通这个套餐,无需在开通"
                        );
                        array_push($error_info,$error_item);
                    }else if($result==4){
                        $error_item = array(
                            "row"=>$rowNo,
                            "msg"=>"找不到这个手机号码"
                        );
                        array_push($error_info,$error_item);
                    }else if($result==5){
                        $error_item = array(
                            "row"=>$rowNo,
                            "msg"=>"导入失败"
                        );
                        array_push($error_info,$error_item);
                    }
                }else {
                    $error_item = array(
                        "row"=>$rowNo,
                        "msg"=>"必填数据未填写"
                    );
                    array_push($error_info,$error_item);
                }

                $rowNo++;
            }
        }


        $emptyData = "";
        foreach ($error_info as &$error_item){
            $emptyData = $emptyData."第".($error_item["row"]+1)."行".$error_item["msg"].",";
        }

        $allcount=$highestRow-1;
        //$updatecount=$allcount-$ius;
//
        if(!empty($emptyData))
        {
            $data_excel =  array(
                'schoolid'=>$schoolid,
                'filename'=>$file_name,
                'type'=>$type,
                'time'=>time(),
                'pro'=>rtrim($emptyData, ","),
                'status'=>1,
                'state'=>4

            );

            $teacher_excel = M('student_package_excel')->add($data_excel);


        }else{
            $data_excel =  array(
                'schoolid'=>$schoolid,
                'filename'=>$file_name,
                'type'=>$type,
                'time'=>time(),
                'pro'=>'完美!',
                'status'=>0,
                'state'=>4,

            );
            $teacher_excel = M('student_package_excel')->add($data_excel);


        }
//
//
        $info='::其中成功'.$successcount.'人,'.$emptyData;


        $this->success('导入完成','ImportPackage/successcount/'.$successcount.'/allcount/'.$allcount.'/info/ok::'.$info);
    }

    //导入数据添加
    public function importstudent($name,$phone,$schoolid,$use_status,$packageid,$types,$desc,$month){

        $userid = $_SESSION["ADMIN_ID"]; //操作人ID
        if($schoolid){
            $school = M("school")->where("schoolid = $schoolid")->field("agent_id")->find(); //找到学校的代理商
            $agentid = $school["agent_id"];//代理商ID
        }
        //通过学生 姓名 和 家长手机号码 找到下面所需要的数据
        $result = M("relation_stu_user")->where("phone = $phone and type=1")->find(); //找到关系表里面学生ID
        if($result){
            $studentid = $result["studentid"]; //学生ID

            $student = M("student_info")->where("stu_name='$name' and userid = $studentid and schoollid=$schoolid")->field("userid,classid")->find();
            //dump($student);
            if($student){ //如果存在 说明找到了这个学生
                $classid = $student["classid"];//班级ID
            }else{
                //echo "没有这个学生";
                return 2;
            }

            $stupackage  = M("student_package")->where("studentid = $studentid and packageid=$packageid")->find(); //学生套餐查找好有没有订过这个套餐
            if($stupackage){
                if($stupackage["use_status"]==1 and $use_status==1){
                    //echo  "你已经开通这个套餐1,无需在开通";
                    return 3;
                }
                if($stupackage["use_status"]==2 and $use_status==1){
                    //echo  "你已经开通这个套餐2,无需在开通";
                    return 3;
                }
                if($stupackage["use_status"]==2 and $use_status==2){
                    // echo  "你已经开通这个套餐3,无需在开通";
                    return 3;
                }
                if($stupackage["use_status"]==1 and $use_status==2){ //表现投原来的开通转为收费
                    $oder_status = 2;
                    if($types==1){ //表示月份
                        $begin_timeint = $stupackage["begin_timeint"];  //套餐开始时间
                        $months = '+'.$month.'month';
                        $end_timeint = strtotime($months,$begin_timeint);  //套餐结束时间
                    }
                    if($types==2){ //表示学期
                        $begin_timeint = $stupackage["begin_timeint"];  //套餐开始时间
                        $end_timeint = strtotime('+4month',$begin_timeint);  //套餐结束时间 加4个月
                    }
                    if($types==4){ //表示年
                        $begin_timeint = $stupackage["begin_timeint"];  //套餐开始时间
                        $end_timeint = strtotime('+1year',$begin_timeint);  //套餐结束时间 ,加一年
                    }
                    $data=array(
                        'use_status'=>$use_status,
                        'oder_status'=>$oder_status,
                        'end_timeint'=>$end_timeint

                    );
                    $arr=M("student_package")->where("studentid = $studentid and packageid=$packageid")->save($data);
                    if($arr){
                        //表示导入成功
                        return 1;
                    }else{
                        //表示导入失败
                        return 5;
                    }
                }

            }else{ //表示第一次订制这个套餐
                if($use_status==1){  //表示开通
                    $oder_status = 1;
                    $begin_timeint = time();  //套餐开始时间
                    $end_timeint = strtotime('+1month');  //套餐结束时间 ,默认体验期一个月
                }
                if($use_status==2){ //表示转收费
                    $oder_status = 2;
                    if($types==1){ //表示月份
                        $begin_timeint = time();  //套餐开始时间
                        $months = '+'.$month.'month';
                        $end_timeint = strtotime($months);  //套餐结束时间
                    }
                    if($types==2){ //表示学期
                        $begin_timeint = time();  //套餐开始时间
                        $end_timeint = strtotime('+4month');  //套餐结束时间 ,加4个月
                    }
                    if($types==4){ //表示年
                        $begin_timeint = time();  //套餐开始时间
                        $end_timeint = strtotime('+1year');  //套餐结束时间 ,加一年
                    }
                }
                $data=array(
                    'schoolid'=>$schoolid,
                    'studentid'=>$studentid,
                    'agentid'=>$agentid,
                    'classid'=>$classid,
                    'phone'=>$phone,
                    'use_status'=>$use_status,
                    'packageid'=>$packageid,
                    'oder_status'=>$oder_status,
                    'status'=>1,
                    'begin_timeint'=>$begin_timeint,
                    'end_timeint'=>$end_timeint,
                    'add_timeint'=>time(),
                    'desc'=>$desc
                );
                //dump($data);
                $arr=M("student_package")->add($data); //学生套餐表里面加数据
                if($arr){
                    $newdata = array();
                    $query = M("package as a")->
                    join("wxt_sales as b  on a.salesid=b.id")->
                    join("wxt_sales_product as c on c.salesid = b.id")->
                    where("a.id=$packageid")->
                    field("c.*")->
                    select();
                    foreach ($query as $value){
                        $data["productid"] =$value["productid"];
                        $data["selesid"] =$value["salesid"];
                        $newdata[] =$data;
                    }
//                        dump($newdata);
//                        die();
                    M('student_product')->addAll($newdata);//学生产品表里面加数据
                    //往日志表里面加入记录
                    $log_data=array(
                        'schoolid'=>$schoolid,
                        'studentid'=>$studentid,
                        'agentid'=>$agentid,
                        'classid'=>$classid,
                        'phone'=>$phone,
                        'telephone'=>$phone,
                        'use_status'=>$use_status,
                        'packageid'=>$packageid,
                        'oder_status'=>$oder_status,
                        'time'=>time(),
                        'userid'=>$userid,
                        'desc'=>$desc
                    );
                    // dump($log_data);
                    // die();
                    M("customization_log")->add($log_data); //学生套餐表里面加数据
                    //表示导入成功
                    return 1;
                }else{
                    //表示导入失败
                    return 5;
                }
            }

        }else{
            //echo "找不到这个手机号码";
            //die();
            return 4;
        }

        //需要schoolid  studentid  agentid classid phone  packageid
    }


    //查看导入结果
    public function excel_list()
    {

        $begin = strtotime(I('begin'));
        $end = strtotime(I('end'));

        $roleid = admin_role();

        if($roleid!=1)
        {
            $join= "wxt_role_school rs ON rs.schoolid = t.schoolid";
            $where['rs.roleid'] = $roleid;
        }




        if($end && $begin)
        {
            $where['t.time']  = array('GT',$begin);
            $where['t.time'] = array('LT',$end);
        }

        $where['t.state'] = 4;

        $excel = M('student_package_excel as t')
            ->join($join)
            ->where($where)->order("t.time asc")
            ->select();

        $this->assign('excel',$excel);
        $this->display();

    }

    //导入结果删除
    function student_package_delete() {
        $userid = intval($_GET['id']);
        if ($userid) {
            $rest = $this -> relation_stu_user_model -> where("studentid=$userid") -> delete();
            $rst = $this -> relation_stu_class_model -> where("userid=$userid") -> delete();
            $user = $this -> wxtuser_model -> where("id=$userid") -> delete();
            if ($rst && $user) {
                $this -> success("删除成功！");
            } else {
                $this -> error("删除失败！");
            }
        } else {
            $this -> error('数据传入失败！');
        }
    }

    //定制日志
    public function customization_log(){
        $package = M("package")->select(); //拉取套餐
        $this->assign("package",$package);

        $Province=role_admin();//拉取地区
        $this->assign("Province",$Province);
        $pro = I("province"); //地区

        if($pro){
            $this->assign("province",$pro);
        }

        $citys = I("citys");
        if($citys){
            $this->assign("new_citys",$citys);
        }

        $message_type = I("message_type");
        if($message_type){
            $this->assign("new_message_type",$message_type);
        }

        $schoolid = I("schoolid"); //学校
        if($schoolid){
            $where["a.schoolid"]=$schoolid;
            $this->assign("schoolid",$schoolid);
        }

        $packageid = I("packageid"); //套餐ID
        if($packageid){
            $where["a.packageid"]=$packageid;
            $this->assign("packageid",$packageid);

        }

        $oder_status = I("oder_status"); //订阅状态
        if($oder_status){
            $where["a.oder_status"]=$oder_status;
            $this->assign("oder_status",$oder_status);

        }
        $type = I("type"); //定制方式
        if($type){
            $where["a.type"]=$type;
            $this->assign("type",$type);

        }

        $use_status= I("use_status"); //操作方式
        if($use_status){
            $where["a.use_status"]=$use_status;
            $this->assign("use_status",$use_status);

        }

        $tiaojian= I("tiaojian"); //类型
        if($tiaojian){
            $this->assign("tiaojian",$tiaojian);

            $shuzhi= I("shuzhi"); //模糊查找
            if($shuzhi){
                if($tiaojian=="name"){
                    $where["g.stu_name"]=array("like","%".trim(I('shuzhi'))."%");
                }

                if($tiaojian=="phone"){
                    $where["a.phone"]=array("like","%".trim(I('shuzhi'))."%");
                }

                $this->assign("shuzhi",$shuzhi);
            }

        }

        $start_time= I("start_time"); //开始时间
        if($start_time){
            $this->assign("start_time",$start_time);

        }
        $end_time= I("end_time"); //开始时间
        if($end_time){
            $this->assign("end_time",$end_time);

        }
        if($end_time && $start_time)
        {

            $where['a.time']  = array('GT',strtotime($start_time));
            $where['a.time'] = array('LT',strtotime($end_time));
        }

        //  dump($_GET);
        // dump($where);
        $count = M("customization_log as a")->
        join("wxt_agent as b  on a.agentid=b.id")->
        join("wxt_school as c  on a.schoolid=c.schoolid")->
        join("wxt_school_class as d  on d.id=a.classid")->
        join("wxt_package as e  on a.packageid=e.id")->
        join("wxt_users as f  on a.userid=f.id")->
        join("wxt_student_info as g  on g.userid=a.studentid")->
        where($where)->
        field("g.stu_name as studentname,b.name as agentname,c.school_name,d.classname,e.name as packagename,f.user_nicename,a.*")->
        count();
        $page = $this->page($count,20);

        $result = M("customization_log as a")->
        join("wxt_agent as b  on a.agentid=b.id")->
        join("wxt_school as c  on a.schoolid=c.schoolid")->
        join("wxt_school_class as d  on d.id=a.classid")->
        join("wxt_package as e  on a.packageid=e.id")->
        join("wxt_users as f  on a.userid=f.id")->
        join("wxt_student_info as g  on g.userid=a.studentid")->
        limit($page->firstRow . ',' . $page->listRows)->
        where($where)->
        order('a.studentid asc')->
        field("g.stu_name as studentname,b.name as agentname,c.school_name,d.classname,e.name as packagename,f.user_nicename,a.*")->
        select();
        $this->assign("result",$result);
        $this->assign("Page", $page->show('Admin'));
        $this->display();
    }

    //导出日志
    public function Lexcel()
    {
        $schoolid = I("schoolid");//学校ID
        if($schoolid){
            $where["a.schoolid"] = $schoolid;
        }
        $result = M("customization_log as a")->
        join("wxt_agent as b  on a.agentid=b.id")->
        join("wxt_school as c  on a.schoolid=c.schoolid")->
        join("wxt_school_class as d  on d.id=a.classid")->
        join("wxt_package as e  on a.packageid=e.id")->
        join("wxt_users as f  on a.userid=f.id")->
        join("wxt_student_info as g  on g.userid=a.studentid")->
        where($where)->
        order('a.studentid asc')->
        field("g.stu_name as studentname,b.name as agentname,c.school_name,d.classname,e.name as packagename,f.user_nicename,a.*")->
        select();
//        $newresult = array();
        foreach ($result as &$value){
            if($value["type"]==1){  //定制方式
                $value["type"]="网页";
            }
            if($value["use_status"]==1){  //操作
                $value["use_status"]="开通";
            }elseif ($value["use_status"]==2){
                $value["use_status"]="转收费";
            }

            $value["time"] = date("Y-m-d H:i:s",$value["time"]);

        }
//        dump($result);
//        die();
        $ExceData = array_merge($result);


        vendor('PHPExcel.PHPExcel');
        $objPHPExcel = new \PHPExcel();
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
        $objPHPExcel->getActiveSheet(0)->setCellValue('A1',"SA");
        $objPHPExcel->getActiveSheet(0)->setCellValue('B1',"学校");
        $objPHPExcel->getActiveSheet(0)->setCellValue('C1',"班级");
        $objPHPExcel->getActiveSheet(0)->setCellValue('D1',"学生姓名");
        $objPHPExcel->getActiveSheet(0)->setCellValue('E1',"手机号码");
        $objPHPExcel->getActiveSheet(0)->setCellValue('F1',"扣费号码");
        $objPHPExcel->getActiveSheet(0)->setCellValue('G1',"服务名称");
        $objPHPExcel->getActiveSheet(0)->setCellValue('H1',"定制方式");
        $objPHPExcel->getActiveSheet(0)->setCellValue('I1',"操作");
        $objPHPExcel->getActiveSheet(0)->setCellValue('J1',"修改日期");
        $objPHPExcel->getActiveSheet(0)->setCellValue('K1',"修改原因");
        $objPHPExcel->getActiveSheet(0)->setCellValue('L1',"修改人");
        $Val = 2;
        if(!count($ExceData)){
            $objPHPExcel->getActiveSheet(0)->setCellValue('A' . $Val, "该学校没记录");
        }else{
            for($i=0 ;$i<count($ExceData) ;$i++){
                $objPHPExcel->getActiveSheet(0)->setCellValue('A' . $Val, $ExceData[$i]['agentname']);
                $objPHPExcel->getActiveSheet(0)->setCellValue('B' . $Val, $ExceData[$i]['school_name']);
                $objPHPExcel->getActiveSheet(0)->setCellValue('C' . $Val, $ExceData[$i]['classname']);
                $objPHPExcel->getActiveSheet(0)->setCellValue('D' . $Val, $ExceData[$i]['studentname']);
                $objPHPExcel->getActiveSheet(0)->setCellValue('E' . $Val, $ExceData[$i]['phone']);
                $objPHPExcel->getActiveSheet(0)->setCellValue('F' . $Val, $ExceData[$i]['telephone']);
                $objPHPExcel->getActiveSheet(0)->setCellValue('G' . $Val, $ExceData[$i]['packagename']);
                $objPHPExcel->getActiveSheet(0)->setCellValue('H' . $Val, $ExceData[$i]['type']);
                $objPHPExcel->getActiveSheet(0)->setCellValue('I' . $Val, $ExceData[$i]['use_status']);
                $objPHPExcel->getActiveSheet(0)->setCellValue('J' . $Val, $ExceData[$i]['time']);
                $objPHPExcel->getActiveSheet(0)->setCellValue('K' . $Val, $ExceData[$i]['desc']);
                $objPHPExcel->getActiveSheet(0)->setCellValue('L' . $Val, $ExceData[$i]['user_nicename']);
                $Val++;
            }
        }

        $school = M("school")->where("schoolid=$schoolid")->field("school_name")->find();
        $school_name = $school["school_name"];
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$school_name.'.xls"');
        header("Content-Disposition:attachment;filename=$school_name.xls");//attachment新窗口打印inline本窗口打印
        header('Cache-Control: max-age=0');
        $objWriter =\ PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_clean();//关键
        flush();//关键
        $objWriter->save('php://output');
        exit;
    }

    //费用导入
    public function service_charge_import(){

        $allcount=I('allcount');
        $successcount=I('successcount');
        $updatecount=I('updatecount');
        $info=I('info');
        $this->assign("allcount",$allcount);
        $this->assign("successcount",$successcount);
        $this->assign("updatecount",$updatecount);
        $this->assign("info",$info);

        $Province=role_admin();
        $this->assign("Province",$Province);
        $this->display("charge");
    }

    //费用导入提交
    public function service_charge_import_post()
    {

        $schoolid = intval(I('schoolid'));//学校ID
        //$use_status = intval(I('use_status'));//1表示开通 2表示转收费
        $package = I("package");
        $packagearr = explode(",",$package);
        $packageid = $packagearr[0];//套餐ID
        $types = $packagearr[1];//套餐类型

        $desc = I("desc");//修改原因
//        $m = I("month");
//        if($m){
//            $month = $m;
//        }else{
//            $month =1;
//        }

        $allcount=0;
        $successcount=0;
        $updatecount=0;

        if(!$schoolid){
            $this->error("请选择学校");
        }
        if(!$package){
            $this->error("请选择套餐");
        }

        $school = M("school")->where("schoolid = $schoolid")->field("agent_id")->find(); //找到学校的代理商
        $agentid = $school["agent_id"];//代理商ID

        if($types==1){ //月份
            $month =I("month");
        }

        if($types==2){ //学期
            $month =4;
        }
        if($types==4){ //学年
            $month =12;
        }
        $rs = M("service_charge")->where("schoolid=$schoolid and packageid=$packageid")->find();
        if($rs){
            if($types==1){
                $a = $rs["month"]+$month;
                $id = $rs['id'];
                M("service_charge")->where("id = $id")->save(array("month"=>$a));
                $service_charge_id = $id;

            }else{
                $this->error("这个学校该套餐已经录入过");
            }

        }else{
            $data=array(
                'schoolid'=>$schoolid,
                'agentid'=>$agentid,
                'packageid'=>$packageid,
                'Auditing_status'=>1,
                'decription'=> $desc,
                'type'=> $types,
                'month'=> $month,
                'add_timeint'=>time()
            );
            //dump($data);
            $service_charge_id=M("service_charge")->add($data); //总记录表里面加记录
        }


        $upload = new \Think\Upload();// 实例化上传类

        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('xls', 'xlsx');// 设置附件上传类型
        $upload->rootPath  =      './'; // 设置附件上传根目录
        $upload->savePath  =      'uploads/SchoolData/'; // 设置附件上传（子）目录
        $upload->autoSub   = 	 false;//不自动生成子文件夹
        // 上传单个文件
        // 上传单个文件
        $info   =   $upload->uploadOne($_FILES['excel_file']);


        $type = $info['ext'];

        $file_name = $info['name'];
        // var_dump($_FILES);
        // exit();
        if(!$info){
            $this->error($upload->getError());
        }else{
            $file_puth = './'.$info['savepath'].$info['savename'];
            //文件上传成功，对文件进行解析
            // vendor('phpexcel_1.phpexcel');//导入类库
            require_once VENDOR_PATH.'PHPExcel/PHPExcel/IOFactory.php';
            require_once VENDOR_PATH.'PHPExcel/PHPExcel.php';
            if($info['ext']=='xlsx'){
                require_once VENDOR_PATH.'PHPExcel/PHPExcel/Reader/Excel2007.php';
                $objReader = \PHPExcel_IOFactory::createReader('Excel2007');//xlsx格式必须2007之后才能打开
            }else{
                require_once VENDOR_PATH.'PHPExcel/PHPExcel/Reader/Excel5.php';
                $objReader = \PHPExcel_IOFactory::createReader('Excel5');
            }
            //use excel2007 for 2007 format
            $objPHPExcel = $objReader->load($file_puth);

            // $objPHPExcel->setActiveSheetIndex(1);
            $sheet = $objPHPExcel->getSheet(0);// 读取第一个工作表(编号从 0 开始)

            $highestRow = $sheet->getHighestRow(); // 取得总行数

            $highestColumn = $sheet->getHighestColumn(); // 取得总列数
            //循环读取excel文件,读取一条,插入一条
            // $info='begin::';
            for($j=2;$j<=$highestRow;$j++)
            {
                for($k='A';$k<=$highestColumn;$k++)
                {
                    //读取单元格
                    $ExamPaper_arr[$j][$k]= $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
                    $allcount++;
                }
            }
            $info=$j.'-'.$k.':'.$info.$objPHPExcel->getActiveSheet()->getCell('A10')->getValue();

            $successcount=0;
            $error_info = array();
            $rowNo = 1;



            foreach ($ExamPaper_arr as $key => $value)
            {
                //循环数据检测A=>班级名称，B=>学生姓名，C=>手机号码，D=>费用
                //如果题号或者题干不为空
                if(!empty($value['A'])||!empty($value['B'])||!empty($value['C'])||!empty($value['D'])){
                    $classname=$value['A'];  //班级名称
                    $studentname=$value['B']; //学生姓名
                    $phone=$value['C'];  //手机号码
                    $charge=$value['D']; //费用

                    $result=$this->import_student_charge($service_charge_id,$agentid,trim($schoolid),trim($classname),trim($studentname),trim($phone),trim($charge),$packageid,$types,$desc,$month);

                    /**
                     * 导入教师以及关系数据到数据库
                     * return 1 导入成功
                     * return 2 该学校,没有这个班级
                     * return 3 数据有误,找不到这个学生
                     * return 4  费用格式错误
                     * return 5 导入失败
                     */
                    if($result ==1){
                        $successcount++;
                    }else if($result ==2){
                        $error_item = array(
                            "row"=>$rowNo,
                            "msg"=>"该学校,没有这个班级"
                        );
                        array_push($error_info,$error_item);
                    }else if($result==3){
                        $error_item = array(
                            "row"=>$rowNo,
                            "msg"=>"找不到这个学生"
                        );
                        array_push($error_info,$error_item);

                    } else if($result==4){
                        $error_item = array(
                            "row"=>$rowNo,
                            "msg"=>"费用格式错误,必须为数字"
                        );
                        array_push($error_info,$error_item);

                    }
                    else if($result==7){
                        $error_item = array(
                            "row"=>$rowNo,
                            "msg"=>"找不到这个手机号码"
                        );
                        array_push($error_info,$error_item);

                    }else if($result==5){
                        $error_item = array(
                            "row"=>$rowNo,
                            "msg"=>"导入失败"
                        );
                        array_push($error_info,$error_item);
                    }
                }else {
                    $error_item = array(
                        "row"=>$rowNo,
                        "msg"=>"必填数据未填写"
                    );
                    array_push($error_info,$error_item);
                }

                $rowNo++;
            }
        }


        $emptyData = "";
        foreach ($error_info as &$error_item){
            $emptyData = $emptyData."第".($error_item["row"]+1)."行".$error_item["msg"].",";
        }

        $allcount=$highestRow-1;


//        if(!empty($emptyData))
//        {
//            $data_excel =  array(
//                'schoolid'=>$schoolid,
//                'filename'=>$file_name,
//                'type'=>$type,
//                'time'=>time(),
//                'pro'=>rtrim($emptyData, ","),
//                'status'=>1,
//                'state'=>4
//
//            );
//
//            $teacher_excel = M('student_package_excel')->add($data_excel);
//
//
//        }else{
//            $data_excel =  array(
//                'schoolid'=>$schoolid,
//                'filename'=>$file_name,
//                'type'=>$type,
//                'time'=>time(),
//                'pro'=>'完美!',
//                'status'=>0,
//                'state'=>4,
//
//            );
//            $teacher_excel = M('student_package_excel')->add($data_excel);
//
//
//        }
//
//
        $total_charge=0;
        $service = M("service_charge_detail")->where("schoolid=$schoolid and packageid =$packageid")->select();
        if(count($service)){
            foreach ($service as $value){
                $total_charge+=$value["charge"];
            }
        }

        if($total_charge>0){
            $dte['total_charge'] = $total_charge;
            M("service_charge")->where("id = $service_charge_id")->save($dte);
        }
        $info='::其中成功'.$successcount.'人,'.$emptyData;

        $this->success('导入完成','service_charge_import/successcount/'.$successcount.'/allcount/'.$allcount.'/info/ok::'.$info);
    }

    public function import_student_charge($service_charge_id,$agentid,$schoolid,$classname,$studentname,$phone,$charge,$packageid,$types,$desc,$month)
    {
        if(!is_numeric($charge)){
            return 4;
        }
        $class_where['schoolid']=$schoolid;
        $class_where['classname']=$classname;
        $class=M('school_class')->where($class_where)->field('id,classname')->find();
        if(empty($class)){
            return 2;
            //找不到这个班级
        }
        $result = M("relation_stu_user")->where("phone = $phone and type=1")->find(); //找到关系表里面学生ID
        if(empty($result)){
            return 7;
            //没有这个手机号码
        }

        $classid = $class["id"];
        $studentid = $result["studentid"]; //学生ID

        $student = M("student_info")->
        where("stu_name='$studentname' and userid = $studentid and schoollid=$schoolid and classid = $classid")
            ->field("userid,classid")->find();
        //dump($student);
        if(empty($student)) { //如果存在 说明找到了这个学生
            return 3;  //找不到学生
        }

        $rs = M("service_charge_detail")->where("studentid = $studentid and schoolid=$schoolid and packageid=$packageid")->find();
        if($rs){
            if($types==1){ //表示月份
                $a = $rs["month"]+$month;
                $id = $rs['id'];
                $arr=M("service_charge_detail")->where("id = $id")->save(array("month"=>$a,"charge"=>$charge));
                if($arr){
                    //导入成功
                    return 1;
                }else{
                    //导入失败
                    return 5;
                }
            }
        }else{
            $data=array(
                'schoolid'=>$schoolid,
                'studentid'=>$studentid,
                'agentid'=>$agentid,
                'classid'=>$classid,
                'phone'=>$phone,
                'packageid'=>$packageid,
                'charge'=>$charge,
                'service_charge_id'=>$service_charge_id,
                'type'=> $types,
                'month'=> $month,
                'add_timeint'=>time()
            );
            //dump($data);
            $arr=M("service_charge_detail")->add($data); //学生套餐表里面加数据
            if($arr){
                //导入成功
                return 1;
            }else{
                //导入失败
                return 5;
            }
        }



    }

    //费用管理首页
    public function student_charge_index()
    {

        $package = M("package")->select(); //拉取套餐
        $this->assign("package",$package);

        $Province=role_admin();//拉取地区
        $this->assign("Province",$Province);

        $pro = I("province"); //地区

        if($pro){
            $this->assign("province",$pro);
        }

        $citys = I("citys");
        if($citys){
            $this->assign("new_citys",$citys);
        }

        $message_type = I("message_type");
        if($message_type){
            $this->assign("new_message_type",$message_type);
        }

        $schoolid = I("schoolid"); //学校
        if($schoolid){
            $where["a.schoolid"]=$schoolid;
            $this->assign("schoolid",$schoolid);
        }

        $packageid = I("packageid"); //套餐ID
        if($packageid){
            $where["a.packageid"]=$packageid;
            $this->assign("packageid",$packageid);

        }

        $Auditing_status = I("Auditing_status"); //订阅状态
        if($Auditing_status){
            $where["a.Auditing_status"]=$Auditing_status;
            $this->assign("Auditing_status",$Auditing_status);

        }


        $start_time= I("start_time"); //开始时间
        if($start_time){
            $this->assign("start_time",$start_time);

        }
        $end_time= I("end_time"); //开始时间
        if($end_time){
            $this->assign("end_time",$end_time);

        }
        if($end_time && $start_time)
        {

            $where['a.add_timeint']  = array('GT',strtotime($start_time));
            $where['a.add_timeint'] = array('LT',strtotime($end_time));
        }

        $count= M("service_charge as a")->
        join("wxt_agent as b  on a.agentid=b.id")->
        join("wxt_school as c  on a.schoolid=c.schoolid")->
        join("wxt_package as e  on a.packageid=e.id")->
        where($where)->
        order('a.schoolid asc')->
        field("b.name as agentname,c.school_name,e.name as packagename,a.*")->
        count();

        $page = $this->page($count,20);

        $result = M("service_charge as a")->
        join("wxt_agent as b  on a.agentid=b.id")->
        join("wxt_school as c  on a.schoolid=c.schoolid")->
        join("wxt_package as e  on a.packageid=e.id")->
        limit($page->firstRow . ',' . $page->listRows)->
        where($where)->
        order('a.schoolid asc')->
        field("b.name as agentname,c.school_name,e.name as packagename,a.*")->
        select();
        //dump($result);
        $this->assign("Page", $page->show('Admin'));
        $this->assign("result",$result);
        $this->display("charge_index");
    }

    //修改审核状态
    public function eidt_charge()
    {
        $ids = I("ids");
        $state = I("state");
        $id = array_filter(explode(",",$ids));
        //dump($id);
        $data["Auditing_status"] = $state;
        foreach ($id  as $value){
            $result = M("service_charge")->where("id=$value")->save($data);
            if($result){
                $res[]=array("state"=>1,"id"=>$value);
            }else{
                $res[]=array("state"=>2,"id"=>$value);
            }
        }
        echo json_encode($res);
    }

    //查看费用明细
    public function charge_detail()
    {


        $schoolid = I("schoolid"); //学校ID
        if($schoolid){
            $where["a.schoolid"] = $schoolid;
            $class = M("school_class")->where("schoolid = $schoolid")->field("id,classname")->select();
            $this->assign("class",$class);
            $this->assign("schoolid",$schoolid);
        }
        $packageid = I("packageid"); //套餐ID
        if($packageid){
            $where["a.packageid"] = $packageid;
            $this->assign("packageid",$packageid);
        }
        $service_charge_id = I("service_charge_id"); //关联的主表ID
        if($service_charge_id){
            $where["a.service_charge_id"] = $service_charge_id;
            $this->assign("service_charge_id",$service_charge_id);
        }

        $classid = I("classid"); //套餐ID
        if($classid){
            $where["a.classid"] = $classid;
            $this->assign("classid",$classid);
        }

        $tiaojian= I("tiaojian"); //类型
        if($tiaojian){
            $this->assign("tiaojian",$tiaojian);

            $shuzhi= I("shuzhi"); //模糊查找
            if($shuzhi){
                if($tiaojian=="name"){
                    $where["g.stu_name"]=array("like","%".trim(I('shuzhi'))."%");
                }

                if($tiaojian=="phone"){
                    $where["a.phone"]=array("like","%".trim(I('shuzhi'))."%");
                }

                $this->assign("shuzhi",$shuzhi);
            }

        }

        $start_time= I("start_time"); //开始时间
        if($start_time){
            $this->assign("start_time",$start_time);

        }
        $end_time= I("end_time"); //开始时间
        if($end_time){
            $this->assign("end_time",$end_time);

        }
        if($end_time && $start_time)
        {

            $where['a.add_timeint']  = array('GT',strtotime($start_time));
            $where['a.add_timeint'] = array('LT',strtotime($end_time));
        }
        $count = M("service_charge_detail as a")->
        join("wxt_agent as b  on a.agentid=b.id")->
        join("wxt_school as c  on a.schoolid=c.schoolid")->
        join("wxt_school_class as d  on d.id=a.classid")->
        join("wxt_package as e  on a.packageid=e.id")->
        join("wxt_student_info as g  on g.userid=a.studentid")->
        where($where)->
        order('a.studentid asc')->
        field("g.stu_name as studentname,b.name as agentname,c.school_name,d.classname,e.name as packagename,a.*")->
        count();

        $page = $this->page($count,20);

        $result = M("service_charge_detail as a")->
        join("wxt_agent as b  on a.agentid=b.id")->
        join("wxt_school as c  on a.schoolid=c.schoolid")->
        join("wxt_school_class as d  on d.id=a.classid")->
        join("wxt_package as e  on a.packageid=e.id")->
        join("wxt_student_info as g  on g.userid=a.studentid")->
        limit($page->firstRow . ',' . $page->listRows)->
        where($where)->
        order('a.studentid asc')->
        field("g.stu_name as studentname,b.name as agentname,c.school_name,d.classname,e.name as packagename,a.*")->
        select();
        //dump($result);
        $this->assign("Page", $page->show('Admin'));
        $this->assign("result",$result);
        $this->display();
    }

    //修改审核状态
    public function edit_charge_detail()
    {
        $charge_id = I("charge_id"); //ID
        $charge = I("charge");//费用
        $schoolid = I("schoolid");//学校ID
        $packageid = I("packageid");//套餐ID
        $service_charge_id = I("service_charge_id");//套餐ID

        if(!$charge_id and !$charge and !$schoolid and !$packageid and !$service_charge_id){
            echo json_encode(array("state"=>0,"success"=>"缺少参数"));
            return;
        }
        $result = M("service_charge_detail")->where("id=$charge_id")->save(array("charge"=>$charge));
        if($result){
            $total_charge=0;
            $service = M("service_charge_detail")->where("schoolid=$schoolid and packageid =$packageid")->select();
            if(count($service)){
                foreach ($service as $value){
                    $total_charge+=$value["charge"];
                }
            }

            if($total_charge>0){
                $dte['total_charge'] = $total_charge;
                M("service_charge")->where("id = $service_charge_id")->save($dte);
            }
            echo json_encode(array("state"=>1,"success"=>"添加成功"));
        }

    }

    //拉取学生信息
    public function student_info()
    {
        $schoolid = I("schoolid");//学校ID
        $classid = I("classid");//班级ID

        if(!$schoolid and !$classid){
            echo json_encode(array("state"=>0,"success"=>"缺少参数"));
        }else{
            $result = M("student_info")->where("schoollid =$schoolid and classid=$classid")->select();
            if(count($result)){
                echo json_encode(array("state"=>1,"success"=>$result));
            }else{
                echo json_encode(array("state"=>0,"success"=>"没有找到到信息"));
            }
        }
    }

    //添加明细
    public  function add_charge_detail(){
        $studentid = I("studentid");//学生ID
        $classid = I("classid");//班级ID
        $service_charge_id = I("service_charge_id");//收费表关联ID
        $charge = I("charge");//费用
        $phone = I("phone");//手机号码

        if(empty($studentid) || empty($classid) || empty($service_charge_id) || empty($charge) || empty($phone)){
            echo json_encode(array("state"=>0,"success"=>"缺少参数"));
        }else{
            $rest = M("relation_stu_user")->where("phone = $phone and type=1")->find(); //找到关系表里面学生ID
//            if(empty($rest)){
//                echo json_encode(array("state"=>0,"success"=>"该号码不存在"));
//                return;
//            }
            $arr = M("service_charge_detail")->where("service_charge_id = $service_charge_id and studentid = $studentid")->find();
            if($arr){
                echo json_encode(array("state"=>0,"success"=>"该学生已经存在记录"));
            }else{
                $array = M("service_charge")->where("id=$service_charge_id")->find();
                $data=array(
                    'schoolid'=>$array["schoolid"],
                    'studentid'=>$studentid,
                    'agentid'=>$array["agentid"],
                    'classid'=>$classid,
                    'phone'=>$phone,
                    'packageid'=>$array["packageid"],
                    'charge'=>$charge,
                    'service_charge_id'=>$service_charge_id,
                    'type'=> $array["type"],
                    'month'=>$array["month"],
                    'add_timeint'=>time()
                );
                $schoolid = $array["schoolid"];
                $packageid = $array["packageid"];
                $result = M("service_charge_detail")->add($data);
                if(count($result)){
                    $total_charge=0;
                    $service = M("service_charge_detail")->where("schoolid=$schoolid and packageid =$packageid")->select();
                    if(count($service)){
                        foreach ($service as $value){
                            $total_charge+=$value["charge"];
                        }
                    }

                    if($total_charge>0){
                        $dte['total_charge'] = $total_charge;
                        M("service_charge")->where("id = $service_charge_id")->save($dte);
                    }
                    echo json_encode(array("state"=>1,"success"=>"添加成功"));
                }else{
                    echo json_encode(array("state"=>0,"success"=>"添加失败"));
                }

            }


        }
    }
}

