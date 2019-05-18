<?php 


mysql_connect('w.rdc.sae.sina.com.cn:3307','4342z15jm2','yh4m22ijxy33kzll0z25iykj003410k004mxykm2');

mysql_set_charset('utf8');

mysql_select_db('app_yzm17');

$sql="select * from yzm";
$res=mysql_query($sql);

while ($row=mysql_fetch_assoc($res)) {
	# code...
	var_dump($row);
	echo "<hr>";
}
 ?>