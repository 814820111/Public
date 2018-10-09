<?php

/**
 * 后台Controller
 */
//定义是后台
namespace Common\Controller;
use Common\Controller\AppframeController;

class WeixinbaseController extends AppframeController {
    private $appId;
    private $appSecret;

	public function __construct() {
		$admintpl_path=C("SP_WEIXIN_TMPL_PATH").C("SP_WEIXIN_DEFAULT_THEME")."/";
		C("TMPL_ACTION_SUCCESS",$admintpl_path.C("SP_WEIXIN_TMPL_ACTION_SUCCESS"));
		C("TMPL_ACTION_ERROR",$admintpl_path.C("SP_WEIXIN_TMPL_ACTION_ERROR"));
        // C("TMPL_ACTION_OVERTIME",$admintpl_path.C("SP_TEACHER_TMPL_ACTION_OVERTIME"));
		parent::__construct();
	   if($_SESSION["APPID"]){
           $this->appId=$_SESSION["APPID"];
       } else{
           $this->appId = "wx7325155f62456567";
           $_SESSION["APPID"] = $this->appId;
       }

       if($_SESSION["APPSECRET"]){
           $this->appSecret = $_SESSION["APPSECRET"];
        }else{
           $this->appSecret = "c379e9768f9faa8865a1db767fc81155";
           $_SESSION["APPSECRET"] = $this->appSecret;
        }

		$time=time();
		$this->assign("js_debug",APP_DEBUG?"?v=$time":"");
	}

    public function getSignPackage() {
        $jsapiTicket = $this->getJsApiTicket();
        // 注意 URL 一定要动态获取，不能 hardcode.
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $timestamp = time();
        $nonceStr = $this->createNonceStr();

        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

        $signature = sha1($string);

        $signPackage = array(
            "appId"     => $this->appId,
            "nonceStr"  => $nonceStr,
            "timestamp" => $timestamp,
            "url"       => $url,
            "signature" => $signature,
            "rawString" => $string
        );
        return $signPackage;
    }

    private function createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

//    private function getJsApiTicket() {
//        // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
//        $data = json_decode($this->get_php_file("./jsapi_ticket.php"));
//        if ($data->expire_time < time()) {
//            $accessToken = $this->getAccessToken();
//            // 如果是企业号用以下 URL 获取 ticket
//            // $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
//            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
//            $res = json_decode($this->httpGet($url));
//            $ticket = $res->ticket;
//            if ($ticket) {
//                $data->expire_time = time() + 7000;
//                $data->jsapi_ticket = $ticket;
//                $this->set_php_file("./jsapi_ticket.php", json_encode($data));
//            }
//        } else {
//            $ticket = $data->jsapi_ticket;
//        }
//
//        return $ticket;
//    }

    private function getJsApiTicket() {
        // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
         $appid = $this->appId;
         $result = M("wxmanage")->where("wx_appid = '$appid'")->find();
         $time = $result["jsapi_ticket_expire_time"]; //JsApiTicket过期时间

        if (time()>$time  || empty($time)) {
            $accessToken = $this->getAccessToken();
            // 如果是企业号用以下 URL 获取 ticket
            // $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
            $res = json_decode($this->httpGet($url));
            $ticket = $res->ticket;
            if ($ticket) {
                $data["jsapi_ticket_time"] = time();
                $data["jsapi_ticket"]       = $ticket;
                $data["jsapi_ticket_expire_time"]       = time()+6500;
                $res   = M("wxmanage")->where("wx_appid = '$appid'")->save($data);

            }
        } else {
            $arr = M("wxmanage")->where("wx_appid = '$appid'")->find();
            $ticket = $arr["jsapi_ticket"];
        }

        return $ticket;
    }

//    function getAccessToken() {
//        // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
//        $data = json_decode($this->get_php_file("./access_token.php"));
//        if ($data->expire_time < time()) {
//            // 如果是企业号用以下URL获取access_token
//            // $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
//            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
//            $res = json_decode($this->httpGet($url));
//            $access_token = $res->access_token;
//            if ($access_token) {
//                $data->expire_time = time() + 7000;
//                $data->access_token = $access_token;
//                $this->set_php_file("./access_token.php", json_encode($data));
//            }
//        } else {
//            $access_token = $data->access_token;
//        }
//        return $access_token;
//    }
    function getAccessToken()
    {
        $appid = $this->appId;
        $appsecret = $this->appSecret;

        $result = M("wxmanage")->where("wx_appid = '$appid'")->find(); //令牌刷新时间

        $time = $result["token_expire_int"]; //令牌过期时间
        //第一次是access_token不存在 就重新获取一个
        if (time()>$time  || empty($time)) {
            //获取token
//            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . APPID . "&secret=" . APPSECRET;
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appid . "&secret=" . $appsecret;
            //获取token
            $ch  = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($ch);
            curl_close($ch);
            $jsoninfo                   = json_decode($output, true);
            $access_token               = $jsoninfo["access_token"];
            //重新写进 数据库
            $data["token_expire_timeint"] = time();
            $data["authorizer_access_token"]       = $access_token;
            $data["token_expire_int"]       = time()+6500;
            $data["token_refresh_timeint"]       = time();
            $res   = M("wxmanage")->where("wx_appid = '$appid'")->save($data);
        } else {
            $arr = M("wxmanage")->where("wx_appid = '$appid'")->find();
            $access_token = $arr["authorizer_access_token"];
        }
        return $access_token;
    }

    private function httpGet($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        // 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
        // 如果在部署过程中代码在此处验证失败，请到 http://curl.haxx.se/ca/cacert.pem 下载新的证书判别文件。
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);
        curl_setopt($curl, CURLOPT_URL, $url);

        $res = curl_exec($curl);
        curl_close($curl);

        return $res;
    }

    private function get_php_file($filename) {
        return trim(substr(file_get_contents($filename), 15));
    }
    private function set_php_file($filename, $content) {
        $fp = fopen($filename, "w+");
        fwrite($fp, "<?php exit();?>" . $content);
        fclose($fp);
    }

    /**
     * 消息提示
     * @param type $message
     * @param type $jumpUrl
     * @param type $ajax 
     */
    public function success($message = '', $jumpUrl = '', $ajax = false) {
        parent::success($message, $jumpUrl, $ajax);
    }

    /**
     * 模板显示
     * @param type $templateFile 指定要调用的模板文件
     * @param type $charset 输出编码
     * @param type $contentType 输出类型
     * @param string $content 输出内容
     * 此方法作用在于实现后台模板直接存放在各自项目目录下。例如Admin项目的后台模板，直接存放在Admin/Tpl/目录下
     */
    public function display($templateFile = '', $charset = '', $contentType = '', $content = '', $prefix = '') {
        parent::display($this->parseTemplate($templateFile), $charset, $contentType);
    }
    
    
    /**
     * 自动定位模板文件
     * @access protected
     * @param string $template 模板文件规则
     * @return string
     */
    public function parseTemplate($template='') {
    	$tmpl_path=C("SP_WEIXIN_TMPL_PATH");
		// 获取当前主题名称
		$theme      =    C('SP_WEIXIN_DEFAULT_THEME');
		
		if(is_file($template)) {
			// 获取当前主题的模版路径
			define('THEME_PATH',   $tmpl_path.$theme."/");
			return $template;
		}
		$depr       =   C('TMPL_FILE_DEPR');
		$template   =   str_replace(':', $depr, $template);
		
		// 获取当前模块
		$module   =  MODULE_NAME."/";
		if(strpos($template,'@')){ // 跨模块调用模版文件
			list($module,$template)  =   explode('@',$template);
		}
		// 获取当前主题的模版路径
		define('THEME_PATH',   $tmpl_path.$theme."/");
		
		// 分析模板文件规则
		if('' == $template) {
			// 如果模板文件名为空 按照默认规则定位
			$template = CONTROLLER_NAME . $depr . ACTION_NAME;
		}elseif(false === strpos($template, '/')){
			$template = CONTROLLER_NAME . $depr . $template;
		}
		
		C("TMPL_PARSE_STRING.__TMPL__",__ROOT__."/".THEME_PATH);
		
		C('SP_VIEW_PATH',$tmpl_path);
		C('DEFAULT_THEME',$theme);
		
		$file=THEME_PATH.$module.$template.C('TMPL_TEMPLATE_SUFFIX');
		if(!is_file($file)) E(L('_TEMPLATE_NOT_EXIST_').':'.$file);
		return $file;
    }


    /**
     * 初始化后台菜单
     */
    public function initMenu() {
        $Menu = F("Menu");
        if (!$Menu) {
            $Menu=D("Common/Nav")->menu_cache();
        }
        return $Menu;
    }

    /**
     *  排序 排序字段为listorders数组 POST 排序字段为：listorder
     */
    protected function _listorders($model) {
        if (!is_object($model)) {
            return false;
        }
        $pk = $model->getPk(); //获取主键名称
        $ids = $_POST['listorders'];
        foreach ($ids as $key => $r) {
            $data['listorder'] = $r;
            $model->where(array($pk => $key))->save($data);
        }
        return true;
    }

    protected function page($Total_Size = 1, $Page_Size = 0, $Current_Page = 1, $listRows = 6, $PageParam = '', $PageLink = '', $Static = FALSE) {
        import('Page');
        if ($Page_Size == 0) {
            $Page_Size = C("PAGE_LISTROWS");
        }
        if (empty($PageParam)) {
            $PageParam = C("VAR_PAGE");
        }
        $Page = new \Page($Total_Size, $Page_Size, $Current_Page, $listRows, $PageParam, $PageLink, $Static);
        $Page->SetPager('Teacher', '{first}{prev}&nbsp;{liststart}{list}{listend}&nbsp;{next}{last}', array("listlong" => "9", "first" => "首页", "last" => "尾页", "prev" => "上一页", "next" => "下一页", "list" => "*", "disabledclass" => ""));
        return $Page;
    }

    private function check_access($uid){
    	
    	//如果用户角色是1，则无需判断
    	if($uid == 1){
    		return true;
    	}
    	if(MODULE_NAME.CONTROLLER_NAME.ACTION_NAME!="TeacherIndexindex"){
    		return sp_auth_check($uid);
    	}else{
    		return true;
    	}
    }

    function check_session(){
        if(!$_SESSION["userid"]){
            $this->error('session会话过期,重新登录','Accredit/accept',3);
        }

    }

    public function check_menu($id,$stu_id,$school_id){
        $_SESSION["userid"] = $id;
        $_SESSION["studentid"] = $stu_id;
        //顺带查出来学校id 学校名字 学生班级
        $sch_info = M("school")->where(array('schoolid' => $school_id))->find();
        if ($sch_info){
            $_SESSION["school_name"] = $sch_info["school_name"];
            $_SESSION["schoolid"] = $sch_info["schoolid"];
        }

        $weixin = $_SESSION["user"]["weixin"];//微信ID
        $appid = $_SESSION["APPID"];
        $schoolid = $school_id;
        //改变粉丝关注表
        M("wechat_school_openid")->where(array("openid"=>$weixin,"appid"=>$appid))->save(array("schoolid"=>$schoolid));

    }

    //查看是否有权限
    public function  check_role($action,$userid,$schoolid){
        $newarray=array();
        $result = M("duty_teacher")->where(array("teacher_id"=>$userid,"schoolid"=>$schoolid))->find();
        if(count($result)){
            $duty_id = $result["duty_id"];
            $query = M("school_authaccess_app")->where(array("role_id"=>$duty_id,"schoolid"=>$schoolid))->select();
            foreach ($query as $value){
                $newarray[] = $value["rule_name"];
            }
            if(in_array($action,$newarray)){
                return 1;
            }else{
                return 2;
            }
        }
    }
    // 过滤掉emoji表情
    public function filter_Emoji($str)
    {
        $str = preg_replace_callback(    //执行一个正则表达式搜索并且使用一个回调进行替换
            '/./u',
            function (array $match) {
                return strlen($match[0]) >= 4 ? '' : $match[0];
            },
            $str);

        return $str;
    }

    function format_ret ($status, $data='') {
        if ($status){
            //成功
            return array('status'=>'success', 'data'=>$data);
        }else{
            //验证失败
            return array('status'=>'error', 'data'=>$data);
        }
    }
}