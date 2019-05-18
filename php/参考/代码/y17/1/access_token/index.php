<?php 
$appid='wxee274aac6d013ab0';
$appsecret="c017752c68d16e4fcceeba6d601e4270";
$url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$appsecret}";

// 开启curl
$ch=curl_init();
// 设置传输选项
// 设置传输地址
curl_setopt($ch, CURLOPT_URL, $url);
// 以文件流的形式返回
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// 发送curl
$arr=curl_exec($ch);

$arrs=json_decode($arr,TRUE);
var_dump($arrs);

// echo $arr;
// 关闭资源
curl_close($ch);


 ?>