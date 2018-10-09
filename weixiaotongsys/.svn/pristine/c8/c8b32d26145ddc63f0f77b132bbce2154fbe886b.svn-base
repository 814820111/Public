<?php

/**
 * 后台首页
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;

class GroupMessageController extends AdminbaseController {

    function _initialize() {
        parent::_initialize();
    }

    public function index() {
        //获取权限下的学校
        $user_id = $_SESSION['ADMIN_ID'];
        if($user_id)
        {
            $role = M("role_user")->where("user_id = $user_id")->getField("role_id");
        }else{
            $this->error("未获取到用户id，请重新登录");
        }
        if($role==1)
        {
            $schoolarray=M("School")
                ->alias("s")
                ->field("s.schoolid,s.school_name,s.city,s.area")
                ->select();
        }else{
            $where["rs.status"]=1;
            $where["rs.roleid"]=$role;
            $schoolarray=M("School")
                ->alias("s")
                ->join("wxt_role_school rs on rs.schoolid=s.schoolid")
                ->where($where)
                ->field("s.schoolid.s.school_name,s.city,s.area")
                ->select();
        }
        //获取所有省市
        $cityarr = M("City")->field("term_id,name")->select();
        $city=$this->array_column($cityarr,"name","term_id");
        //开始处理数组，12300为为区分学校与区域添加
        $citys=array();
        foreach ($schoolarray as $value){
            if($city[$value['city']]){
                $citys[$value['city']]['cityid']='12300'.$value['city'];
                $citys[$value['city']]['cityname']=$city[$value['city']];
            }
            $citys[$value['city']]['area'][$value['area']]['areaid']='12300'.$value['area'];
            $citys[$value['city']]['area'][$value['area']]['areaname']=$city[$value['area']];

            $citys[$value['city']]['area'][$value['area']]['school'][$value['schoolid']]['schoolid']=$value['schoolid'];
            $citys[$value['city']]['area'][$value['area']]['school'][$value['schoolid']]['schoolname']=$value['school_name'];
        }
        $grade = M("Gradedictionary")->order("schooltype")->select();
        $this->assign("grade",$grade);
        $this->assign("schoolarray",$citys);
        $this->display();
    }
    public function Tqunfa() {
        //获取权限下的学校
        $user_id = $_SESSION['ADMIN_ID'];
        if($user_id)
        {
            $role = M("role_user")->where("user_id = $user_id")->getField("role_id");
        }else{
            $this->error("未获取到用户id，请重新登录");
        }
        if($role==1)
        {
            $schoolarray=M("School")
                ->alias("s")
                ->field("s.schoolid,s.school_name,s.city,s.area")
                ->select();
        }else{
            $where["rs.status"]=1;
            $where["rs.roleid"]=$role;
            $schoolarray=M("School")
                ->alias("s")
                ->join("wxt_role_school rs on rs.schoolid=s.schoolid")
                ->where($where)
                ->field("s.schoolid.s.school_name,s.city,s.area")
                ->select();
        }
        //获取所有省市
        $cityarr = M("City")->field("term_id,name")->select();
        $city=$this->array_column($cityarr,"name","term_id");
        //开始处理数组，12300为为区分学校与区域添加
        $citys=array();
        foreach ($schoolarray as $value){
            if($city[$value['city']]){
                $citys[$value['city']]['cityid']='12300'.$value['city'];
                $citys[$value['city']]['cityname']=$city[$value['city']];
            }
            $citys[$value['city']]['area'][$value['area']]['areaid']='12300'.$value['area'];
            $citys[$value['city']]['area'][$value['area']]['areaname']=$city[$value['area']];

            $citys[$value['city']]['area'][$value['area']]['school'][$value['schoolid']]['schoolid']=$value['schoolid'];
            $citys[$value['city']]['area'][$value['area']]['school'][$value['schoolid']]['schoolname']=$value['school_name'];
        }
        $duty=M("duty")->select();
        $this->assign("duty",$duty);
        $this->assign("schoolarray",$citys);
        $this->display();
    }
    public function Pdanfa() {
        $Province=role_admin();
        $this->assign("Province",$Province);
        $this->display();
    }
    public function Tdanfa() {
        $Province=role_admin();
        $this->assign("Province",$Province);
        $this->display();
    }
    //家长群发信息提交
    function P_add_post()
    {
        $content=I("content");
        $fasongren=I("fasongren");
        if($fasongren){
            $content=$content.'
            ——'.$fasongren;
        }
        $schoolid=rtrim(I("schoolid"),',');
        $schoolarray=explode(",",$schoolid);
        //获取学校id
        foreach ($schoolarray as $k=>$v){
            if(strpos($v, '12300')!== false){
                unset($schoolarray[$k]);
            }
        }
        $schoolids=implode(",",$schoolarray);
        if(empty($schoolids)){
            $this->error("未获取到学校，未发送");
        }

        //获取选择年級
        $suoyouren=I("suoyouren");
        $gardearray=I("gardearray");
        if($suoyouren){
            $garde='suoyouren';
        }else{
            $garde=implode(",",$gardearray);
        }
        if(empty($garde)){
            $this->error("获取发送对象失败，未发送");
        }
        $weixin = I("weixin");
        $duanxing = I("duanxing");
        //信息保存到数据库
        $data['content']=$content;
        $data['tagtype']=1;//家长身份
        $data['garde']=$garde;
        $data['duty']=0;
        if($weixin){
            $data['weixin']=1;
        }else{
            $data['weixin']=0;
        }
        if($duanxing){
            $data['duanxing']=1;
        }else{
            $data['duanxing']=0;
        }
        $data['adminid']=$_SESSION['ADMIN_ID'];
        $data['create_time']=time();
        $data['create_day']=date('Y-m-d H:i:s', time());
        $messageid=M("KefuMessage")->add($data);
        if($messageid) {
            $this->P_zhongzhuan($messageid,$schoolids);
        }else{
            $this->error("信息保存失败，未发送");
        }
        $this->success("发送成功");
    }
    //家长单发信息提交
    function P_danfa_add_post()
    {
        $content=I("content");
        $fasongren=I("fasongren");
        if($fasongren){
            $content=$content.'
            ——'.$fasongren;
        }
        $schoolid=I("schoolid");
        $parentid=I("parentid");
        $weixin = I("weixin");
        $duanxing = I("duanxing");
        if(empty($schoolid) || empty($parentid)){
            $this->error("未获取到数据，未发送");
        }
        if(empty($content)){
            $this->error("未获取发送内容，未发送");
        }
        //信息保存到数据库
        $data['content']=$content;
        $data['tagtype']=1;//家长身份
        $data['garde']=0;
        $data['duty']=0;
        if($weixin){
            $data['weixin']=1;
        }else{
            $data['weixin']=0;
        }
        if($duanxing){
            $data['duanxing']=1;
        }else{
            $data['duanxing']=0;
        }
        $data['adminid']=$_SESSION['ADMIN_ID'];
        $data['create_time']=time();
        $data['create_day']=date('Y-m-d H:i:s', time());
        $messageid=M("KefuMessage")->add($data);

        if($messageid) {
            $this->P_zhongzhuan_dan($messageid,$schoolid,$parentid);
        }else{
            $this->error("信息保存失败，未发送");
        }
        $this->success("发送成功");
    }
    //老师群发信息提交
    function T_add_post()
    {
        $content=I("content");
        $fasongren=I("fasongren");
        if($fasongren){
            $content=$content.'
            ——'.$fasongren;
        }
        $schoolid=rtrim(I("schoolid"),',');
        $schoolarray=explode(",",$schoolid);
        //获取学校id
        foreach ($schoolarray as $k=>$v){
            if(strpos($v, '12300')!== false){
                unset($schoolarray[$k]);
            }
        }
        $schoolids=implode(",",$schoolarray);
        if(empty($schoolids)){
            $this->error("未获取到学校，未发送");
        }

        //获取选择职务
        $suoyouren=I("suoyouren");
        $dutyarray=I("dutyarray");
        if($suoyouren){
            $duty='suoyouren';
        }else{
            $duty=implode(",",$dutyarray);
        }
        if(empty($duty)){
            $this->error("获取发送对象失败，未发送");
        }
        $weixin = I("weixin");
        $duanxing = I("duanxing");
        //信息保存到数据库
        $data['content']=$content;
        $data['tagtype']=2;//老师身份
        $data['garde']=0;
        $data['duty']=$duty;
        if($weixin){
            $data['weixin']=1;
        }else{
            $data['weixin']=0;
        }
        if($duanxing){
            $data['duanxing']=1;
        }else{
            $data['duanxing']=0;
        }
        $data['adminid']=$_SESSION['ADMIN_ID'];
        $data['create_time']=time();
        $data['create_day']=date('Y-m-d H:i:s', time());
        $messageid=M("KefuMessage")->add($data);
        if($messageid) {
                $this->T_zhongzhuan($messageid,$schoolids);
        }else{
            $this->error("信息保存失败，未发送");
        }
        $this->success("发送成功");
    }
    //老师单发信息提交
    function T_danfa_add_post()
    {
        $content=I("content");
        $fasongren=I("fasongren");
        if($fasongren){
            $content=$content.'
            ——'.$fasongren;
        }
        $schoolid=I("schoolid");
        $teacherid=I("teacherid");
        $weixin = I("weixin");
        $duanxing = I("duanxing");
        if(empty($schoolid) || empty($teacherid)){
            $this->error("未获取到数据，未发送");
        }
        if(empty($content)){
            $this->error("未获取发送内容，未发送");
        }
        //信息保存到数据库
        $data['content']=$content;
        $data['tagtype']=2;//老师身份
        $data['garde']=0;
        $data['duty']=0;
        if($weixin){
            $data['weixin']=1;
        }else{
            $data['weixin']=0;
        }
        if($duanxing){
            $data['duanxing']=1;
        }else{
            $data['duanxing']=0;
        }
        $data['adminid']=$_SESSION['ADMIN_ID'];
        $data['create_time']=time();
        $data['create_day']=date('Y-m-d H:i:s', time());
        $messageid=M("KefuMessage")->add($data);

        if($messageid) {
            $this->T_zhongzhuan_dan($messageid,$schoolid,$teacherid);
        }else{
            $this->error("信息保存失败，未发送");
        }
        $this->success("发送成功");
    }


    //获取年级下所有的家长
    public function P_grade(){
        $grade=I("grade");
        $schoolid=I("schoolid");
        if(empty($grade) || empty($schoolid)){
            $res=$this->format_ret(0,'empty gradeid!');
        }else{
            $parent=M("RelationStuUser")
                ->alias("rsu")
                ->join("wxt_student_info si on si.userid=rsu.studentid")
                ->join("wxt_school_class sc on sc.id=si.classid")
                ->join("left outer join wxt_xctuserwechat wx on wx.userid=rsu.userid")
                ->where("sc.schoolid = '$schoolid' and sc.grade = '$grade'")
                ->field("rsu.id as userid,rsu.name,wx.weixin")
                ->group("rsu.id")
                ->select();
            if(empty($parent)){
                $res=$this->format_ret(0,'nodata!');
            }else {
                $res = $this->format_ret(1, $parent);
            }
        }
        echo json_encode($res);
        exit;
    }
    //获取班级下所有的家长
    public function P_class(){
        $class=I("class");
        if(empty($class)){
            $res=$this->format_ret(0,'empty classid!');
        }else{
            $parent=M("RelationStuUser")
                ->alias("rsu")
                ->join("wxt_student_info si on si.userid=rsu.studentid")
                ->join("left outer join wxt_xctuserwechat wx on wx.userid=rsu.userid")
                ->where("si.classid = '$class'")
                ->field("rsu.id as userid,rsu.name,wx.weixin")
                ->group("rsu.id")
                ->select();
            if(empty($parent)){
                $res=$this->format_ret(0,'nodata!');
            }else {
                $res = $this->format_ret(1, $parent);
            }
        }
        echo json_encode($res);
        exit;
    }
    //获取学校下所有的老师
    public function T_school(){
        $schoolid=I("schoolid");
        if(empty($schoolid)){
            $res=$this->format_ret(0,'empty classid!');
        }else{
            $teacher=M("TeacherInfo")
                ->alias("ti")
                ->join("left outer join wxt_xctuserwechat wx on wx.userid=ti.teacherid")
                ->where("ti.schoolid = '$schoolid'")
                ->field("ti.teacherid as userid,ti.name,wx.weixin")
                ->group("ti.teacherid")
                ->select();
            if(empty($teacher)){
                $res=$this->format_ret(0,'nodata!');
            }else {
                $res = $this->format_ret(1, $teacher);
            }
        }
        echo json_encode($res);
        exit;
    }
    //群发送给家长
    private function P_zhongzhuan($message_id,$schoolids)
    {
        $url = "http://up.zhixiaoyuan.net/index.php/Apps/KFsend/kf_parents?message_id=$message_id";
        $data['school']=$schoolids;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置是否返回response header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        //当需要通过curl_getinfo来获取发出请求的header信息时，该选项需要设置为true
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        // 把post的变量加上
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($ch);
        $request_header = curl_getinfo( $ch, CURLINFO_HEADER_OUT);
        curl_close($ch);
        //dump($response);dump($request_header);die;
        return $response;
    }
    //群发送给老师
    private function T_zhongzhuan($message_id,$schoolids)
    {
        $url = "http://up.zhixiaoyuan.net/index.php/Apps/KFsend/kf_teachers?message_id=$message_id";
        $data['school']=$schoolids;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置是否返回response header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        //当需要通过curl_getinfo来获取发出请求的header信息时，该选项需要设置为true
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        // 把post的变量加上
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($ch);
        $request_header = curl_getinfo( $ch, CURLINFO_HEADER_OUT);
        curl_close($ch);
        //dump($response);dump($request_header);die;
        return $response;
    }
    //单发送给老师
    private function T_zhongzhuan_dan($message_id,$schoolids,$teacherid)
    {
        $url = "http://up.zhixiaoyuan.net/index.php/Apps/KFsend/kf_teacher?message_id=$message_id&school=$schoolids";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置是否返回response header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        //当需要通过curl_getinfo来获取发出请求的header信息时，该选项需要设置为true
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        // 把post的变量加上
        curl_setopt($ch, CURLOPT_POSTFIELDS, $teacherid);
        $response = curl_exec($ch);
        $request_header = curl_getinfo( $ch, CURLINFO_HEADER_OUT);
       // dump($response);dump($request_header);die;
        curl_close($ch);
        return $response;
    }
    //单发送给家长
    private function P_zhongzhuan_dan($message_id,$schoolids,$parentid)
    {
        $url = "http://up.zhixiaoyuan.net/index.php/Apps/KFsend/kf_parent?message_id=$message_id&school=$schoolids";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置是否返回response header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        //当需要通过curl_getinfo来获取发出请求的header信息时，该选项需要设置为true
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        // 把post的变量加上
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parentid);
        $response = curl_exec($ch);
        $request_header = curl_getinfo( $ch, CURLINFO_HEADER_OUT);
       // dump($response);dump($request_header);die;
        curl_close($ch);
        return $response;
    }
    /**
     * 低于PHP 5.5版本的array_column()函数
     **/
    private function array_column($input, $columnKey, $indexKey = NULL)
    {
        $columnKeyIsNumber = (is_numeric($columnKey)) ? TRUE : FALSE;
        $indexKeyIsNull = (is_null($indexKey)) ? TRUE : FALSE;
        $indexKeyIsNumber = (is_numeric($indexKey)) ? TRUE : FALSE;
        $result = array();

        foreach ((array)$input AS $key => $row)
        {
            if ($columnKeyIsNumber)
            {
                $tmp = array_slice($row, $columnKey, 1);
                $tmp = (is_array($tmp) && !empty($tmp)) ? current($tmp) : NULL;
            }
            else
            {
                $tmp = isset($row[$columnKey]) ? $row[$columnKey] : NULL;
            }
            if ( ! $indexKeyIsNull)
            {
                if ($indexKeyIsNumber)
                {
                    $key = array_slice($row, $indexKey, 1);
                    $key = (is_array($key) && ! empty($key)) ? current($key) : NULL;
                    $key = is_null($key) ? 0 : $key;
                }
                else
                {
                    $key = isset($row[$indexKey]) ? $row[$indexKey] : 0;
                }
            }

            $result[$key] = $tmp;
        }

        return $result;
    }
    private function format_ret ($status, $data='') {
        if ($status){
            //成功
            return array('state'=>'success', 'info'=>$data);
        }else{
            //验证失败
            return array('state'=>'error', 'info'=>$data);
        }
    }
}

