<?php

namespace Miao\Common\Libs;

/**
 * 钉钉开发平台 PHP开发包
 * @author: zhangkx kunloon@qq.com
 * @since: 2015.9.30
 */
class DingTalk
{
    /**
     * 消息类型：文本
     */
    const MSG_TYPE_TEXT = 'text';

    /**
     * @var array 配置
     */
    private $config;

    /**
     * @var string AccessToken
     */
    private $accessToken;

    /**
     * 构造函数
     * 设置账号 密码
     * 获取 access_token
     */
    public function __construct()
    {
        // 账号密码配置
        $this->config = array(
            'agentid' => 47031225,   // 企业应用id
            'corpid' => 'dinge7109fa74668881835c2f4657eb6378f',                                             // CorpID
            'corpsecret' => 'ms7Ug34VRmEB5NKXtjG8mwav4TWrGPGO_VA1D62nO0b4IbVmmYjYN8gmOOhoPhbj'  // CorpSecret
        );
        $data = $this->httpGet("https://oapi.dingtalk.com/gettoken", $this->config);
        $this->accessToken = $data['access_token'];
    }

    /**
     * 获取部门列表
     */
    public function getDepartmentList()
    {
        $data = $this->httpGet("https://oapi.dingtalk.com/department/list?access_token={$this->accessToken}");
        return ($data['errcode'] == 0) ? $data['department'] : null;
    }

    /**
     * 创建部门
     * @param string $name 部门名
     * @param string $parentid 父部门id
     * @param string $order 在父部门中的次序值
     * @return string 成功的情况下返回id.
     */
    public function createDepartment($name, $parentid, $order = '99')
    {
        $url = "https://oapi.dingtalk.com/department/createk?access_token={$this->accessToken}";
        $params = array(
            'name' => $name,
            'parentid' => $parentid,
            'order' => $order
        );
        $data = $this->httpPost($url, $params);
        return ($data['errcode'] == 0) ? $data['id'] : $data;
    }

    /**
     * 发送企业会话消息: 文本消息
     * @param $users array|string 用户
     * @param $msg 消息内容
     * @return array 返回发送结果
     */
    public function sendText($users = 'manager583', $msg)
    {
        $users = is_array($users) ? implode('|', $users) : $users;
        $url = "https://oapi.dingtalk.com/message/send?access_token={$this->accessToken}";
        $params = array(
            'toparty' => '20852333',
            'agentid' => $this->config['agentid'],
            'msgtype' => self::MSG_TYPE_TEXT,
            'text' => array('content' => $msg)
        );
        return $this->httpPost($url, $params);
    }

    /**
     * get 方法
     * @param $url string 请求网址
     * @param $params Array 参数
     * @param $is_https bool
     * @return null
     */
    private function httpGet($url, $params = array(), $is_https = true)
    {
        $url = empty($params) ? $url : $url . '?' . http_build_query($params);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, !$is_https);  // 是否https 请求
        $output = curl_exec($curl);
        curl_close($curl);
        return json_decode($output, true);
    }

    /**
     * post 方法
     * @param $url string 请求网址
     * @param $params Array 参数
     * @param $is_https bool
     * @return null
     */
    private function httpPost($url, $params = array(), $is_https = true)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, !$is_https); // 是否https 请求
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); // header
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));  // 参数
        $output = curl_exec($curl);
        curl_close($curl);
        return json_decode($output, true);
    }
}