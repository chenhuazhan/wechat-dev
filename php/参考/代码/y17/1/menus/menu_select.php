<?php 
include '../weChat.class.php';
define('TOKEN','y17');
$weChat=new Wechat('wxc9e5776402018fd9','90b0657dd9b0fdabfeb0173d24ad905f');


 $arr=$weChat->menu_select();
var_dump($arr);
 ?>