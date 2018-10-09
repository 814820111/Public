<?php
class Hxcall
{

    private $app_key = '1150180627177152#linchatdemo';
    private $client_id = 'YXA6aD-UAH7OEeiyCQGgKZrE4g';
    private $client_secret = 'YXA6lAcrDa6VDmZAP7sJwgPvZ2rD2PM';
    private $url = "https://a1.easemob.com/1150180627177152/linchatdemo";
    /*
     * 获取APP管理员Token
     */
    function __construct()
    {
        $url = $this->url . "/token";
        $data = array(
            'grant_type' => 'client_credentials',
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret
        );
        $rs = json_decode($this->curl($url, $data), true);

        $this->token = $rs['access_token'];

//        $this->token = "YWMtpcRM7IvDEei0T7UIn1Ia_gAAAAAAAAAAAAAAAAAAAAFoP5QAfs4R6LIJAaApmsTiAgMAAAFktX429gBPGgAiLV4G062-veRQHv6B6_OdZuYsyaYF9mhPax-9JhXFvQ";
    }
    /*
     * 注册IM用户(授权注册)
     */
    public function hx_register($username, $password, $nickname)
    {
        $url = $this->url . "/users";
        $data = array(
            'username' => $username,
            'password' => $password,
            'nickname' => $nickname
        );
        $header = array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->token
        );
        return $this->curl($url, $data, $header, "POST");
    }
    /*
     * 给IM用户的添加好友
     */
    public function hx_contacts($owner_username, $friend_username)
    {
        $url = $this->url . "/users/${owner_username}/contacts/users/${friend_username}";
        $header = array(
            'Authorization: Bearer ' . $this->token
        );
        return $this->curl($url, "", $header, "POST");
    }
    /*
     * 解除IM用户的好友关系
     */
    public function hx_contacts_delete($owner_username, $friend_username)
    {
        $url = $this->url . "/users/${owner_username}/contacts/users/${friend_username}";
        $header = array(
            'Authorization: Bearer ' . $this->token
        );
        return $this->curl($url, "", $header, "DELETE");
    }
    /*
     * 查看好友
     */
    public function hx_contacts_user($owner_username)
    {
        $url = $this->url . "/users/${owner_username}/contacts/users";
        $header = array(
            'Authorization: Bearer ' . $this->token
        );
        return $this->curl($url, "", $header, "GET");
    }

    /* 发送文本消息 target_type 单人users 群聊chatgroups 聊天室chatrooms*/
    public function hx_send($sender, $receiver, $msg,$target_type = "users")
    {
        $url = $this->url . "/messages";
        $header = array(
            'Authorization: Bearer ' . $this->token
        );
        $data = array(
            'target_type' => $target_type,
            'target' => array(
                '0' => $receiver
            ),
            'msg' => array(
                'type' => "txt",
                'msg' => $msg
            ),
            'from' => $sender,
            'ext' => array(
                'attr1' => 'v1',
                'attr2' => "v2"
            )
        );

        return $this->curl($url, $data, $header, "POST");
    }
    /**
     * 创建群组
     *
     * @param $option['groupname'] //群组名称,
     *          此属性为必须的
     * @param $option['desc'] //群组描述,
     *          此属性为必须的
     * @param $option['public'] //是否是公开群,
     *          此属性为必须的 true or false
     * @param $option['approval'] //加入公开群是否需要批准,
     *          没有这个属性的话默认是true, 此属性为可选的
     * @param $option['owner'] //群组的管理员,
     *          此属性为必须的
     * @param $option['members'] //群组成员,此属性为可选的
     */

    public function createGroups($option) {

        $url = $this->url . "/chatgroups";
        $header = array(
            'Authorization: Bearer ' . $this->token
        );
        $result = $this->curl ( $url, $option, $header ,"POST");
        return $result;
    }
    /**
     * 获取群组详情
     *
     * @param
     *          $group_id
     */
    public function chatGroupsDetails($group_id) {
        $url = $this->url . "/chatgroups/" . $group_id;
        $header = array(
            'Authorization: Bearer ' . $this->token
        );
        $result = $this->curl ($url, '', $header ,"GET");
        return $result;
    }
    /**
     * 群组添加成员
     *
     * @param
     *          $group_id
     * @param
     *          $username
     */
    public function addGroupsUser($group_id, $username) {

        $url = $this->url . "/chatgroups/" . $group_id . "/users";

        $data = array(
            'usernames' => $username,
        );

        $header = array(
            'Authorization: Bearer ' . $this->token
        );
        $result = $this->curl( $url, $data, $header,"POST");
        return $result;
    }
    /**
     * 群组删除成员
     *
     * @param
     *          $group_id
     * @param
     *          $username
     */
    public function delGroupsUser($group_id,$username) {

        $url = $this->url . "/chatgroups/" . $group_id . "/users/". $username;

        $header = array(
            'Authorization: Bearer ' . $this->token
        );
        $result = $this->curl( $url, '', $header,"DELETE");
        return $result;
    }


    /* 查询离线消息数 获取一个IM用户的离线消息数 */
    public function hx_msg_count($owner_username)
    {
        $url = $this->url . "/users/${owner_username}/offline_msg_count";
        $header = array(
            'Authorization: Bearer ' . $this->token
        );
        return $this->curl($url, "", $header, "GET");
    }

    /* 查询离线消息数 获取一个IM用户的指定消息离线消息数 */
    public function hx_msg_assign_count($owner_username,$meg_id)
    {
        $url = $this->url . "/users/${owner_username}/offline_msg_status/${meg_id}";
        $header = array(
            'Authorization: Bearer ' . $this->token
        );
        return $this->curl($url, "", $header, "GET");
    }

    /*
     * 获取IM用户[单个]
     */
    public function hx_user_info($username)
    {
        $url = $this->url . "/users/${username}";
        $header = array(
            'Authorization: Bearer ' . $this->token
        );
        return $this->curl($url, "", $header, "GET");
    }
    /*
     * 获取IM用户[批量]
     */
    public function hx_user_infos($limit)
    {
        $url = $this->url . "/users?${limit}";
        $header = array(
            'Authorization: Bearer ' . $this->token
        );
        return $this->curl($url, "", $header, "GET");
    }
    /*
     * 重置IM用户密码
     */
    public function hx_user_update_password($username, $newpassword)
    {
        $url = $this->url . "/users/${username}/password";
        $header = array(
            'Authorization: Bearer ' . $this->token
        );
        $data['newpassword'] = $newpassword;
        return $this->curl($url, $data, $header, "PUT");
    }

    /*
     * 删除IM用户[单个]
     */
    public function hx_user_delete($username)
    {
        $url = $this->url . "/users/${username}";
        $header = array(
            'Authorization: Bearer ' . $this->token
        );
        return $this->curl($url, "", $header, "DELETE");
    }
    /*
     * 修改用户昵称
     */
    public function hx_user_update_nickname($username, $nickname)
    {
        $url = $this->url . "/users/${username}";
        $header = array(
            'Authorization: Bearer ' . $this->token
        );
        $data['nickname'] = $nickname;
        return $this->curl($url, $data, $header, "PUT");
    }
    /*
     *
     * curl
     */
    private function curl($url, $data, $header = false, $method = "POST")
    {
        $ch = curl_init($url);


        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if ($header) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $ret = curl_exec($ch);

        return $ret;
    }
}