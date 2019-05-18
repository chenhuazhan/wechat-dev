<?php 
// 开启curl
$ch=curl_init();
// 设置传输选项
// 设置传输地址
curl_setopt($ch, CURLOPT_URL, 'http://www.baidu.com');
// 以文件流的形式返回
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// 发送curl
$arr=curl_exec($ch);

echo $arr;

// echo $arr;
// 关闭资源
curl_close($ch);

 ?>