<?php 
include '../weChat.class.php';
define('TOKEN','y17');
$weChat=new Wechat('wxee274aac6d013ab0','c017752c68d16e4fcceeba6d601e4270');


 $arr=$weChat->menu_del();
var_dump($arr);
 ?>