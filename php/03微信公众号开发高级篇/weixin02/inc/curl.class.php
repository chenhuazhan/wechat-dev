<?php
/**
 * Created by PhpStorm.
 * User: chenhuazhan
 * Date: 2019/5/18
 * Time: 13:24
 * Desc: curl发送网络请求
 */

class curl
{
    private $resource;
    public function __construct()
    {
        // 开启curl
        $this->resource = curl_init();
    }
    public function httpRequest($url, $data = "")
    {
        // 设置传输选项
        // 设置传输地址
        curl_setopt($this->resource, CURLOPT_URL, $url);
        // 以文件流的形式返回
        curl_setopt($this->resource, CURLOPT_RETURNTRANSFER, 1);
        if ($data) {
            // 以post方式
            curl_setopt($this->resource, CURLOPT_POST, 1);
            curl_setopt($this->resource, CURLOPT_POSTFIELDS, $data);
        }
        // 发送curl
        $result = curl_exec($this->resource);
        return $this->formatResult($result);
    }
    private function formatResult($str){
        $tmpArr = json_decode($str, TRUE);
        if (is_array($tmpArr)) {
            return $tmpArr;
        } else {
            return $str;
        }
    }
}