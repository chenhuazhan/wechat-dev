<?php

mysql_connect('w.rdc.sae.sina.com.cn:3307','4342z15jm2','yh4m22ijxy33kzll0z25iykj003410k004mxykm2');

mysql_set_charset('utf8');

mysql_select_db('app_yzm17');

$sql="select user.*,text.time,text.text from user,text where user.openid=text.openid order by time desc limit 5";
$res=mysql_query($sql);


	while ($row=mysql_fetch_assoc($res)) {
		# code...
		$str.='<li>
				<div class="main_li">
					<div class="left">
						<img src="'.$row[headimgurl].'" width="100%" height="100px" alt="">
					</div>
					<div class="right">
						<h2>'.$row[nickname].':'.$row[text].'</h2>
					</div>
				</div>
			</li>';
	}

	echo $str;

?>
