<?php
include "./weChat.class.php";
// TOKEN
define('TOKEN','y17');
$weChat=new Wechat('wxc9e5776402018fd9','90b0657dd9b0fdabfeb0173d24ad905f');
if ($_GET['echostr']) {
	$weChat->valid();
}else{
	$weChat->responseMsg();
}
