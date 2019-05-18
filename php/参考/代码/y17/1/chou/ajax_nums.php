<?php 

mysql_connect('w.rdc.sae.sina.com.cn:3307','4342z15jm2','yh4m22ijxy33kzll0z25iykj003410k004mxykm2');

mysql_set_charset('utf8');

mysql_select_db('app_yzm17');


$sql="update chou set nums=$_GET[nums] where openid='$_GET[openid]'";

if (mysql_query($sql)) {
	# code...
	echo "1";
}else{
	echo "0";
}



 ?>