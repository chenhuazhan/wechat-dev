<?php 

mysql_connect('w.rdc.sae.sina.com.cn:3307','4342z15jm2','yh4m22ijxy33kzll0z25iykj003410k004mxykm2');

mysql_set_charset('utf8');

mysql_select_db('app_yzm17');


include "../weChat.class.php";

$weChat=new weChat('wxc9e5776402018fd9','90b0657dd9b0fdabfeb0173d24ad905f');

$sql="select * from user where openid='$_GET[openid]'";
$res=mysql_query($sql);
$data=mysql_fetch_assoc($res);
$arr['name']=$data['nickname'];
$arr['goods']='3000万大奖';
$weChat->sendTmp($_GET[openid],'gkHFm0_15SUs1PJ4z2iMw32bvH7bFG2u_s7kyojT0fE',$arr);


$sql="update chou set zhong='获得3000万' where openid='$_GET[openid]'";

if (mysql_query($sql)) {
	# code...
	echo "1";
}else{
	echo "0";
}



 ?>