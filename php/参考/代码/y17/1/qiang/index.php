<?php

mysql_connect('w.rdc.sae.sina.com.cn:3307','4342z15jm2','yh4m22ijxy33kzll0z25iykj003410k004mxykm2');

mysql_set_charset('utf8');

mysql_select_db('app_yzm17');

$sql="select user.*,text.time,text.text from user,text where user.openid=text.openid order by time desc limit 5";
$res=mysql_query($sql);


?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<style>
		*{
			margin: 0 auto;
			padding: 0px;
		}
		body{
			background: url('bg.jpg');
		}
		h2{
			text-align: center;
			color: #fff;
			line-height: 100px;
		}
		.main{
			width:600px;
			height:530px;
			margin-top: 10px;
			border: 5px solid #00f;
			border-radius: 5px;
		}
		ul li{
			list-style: none;
		}
		ul li .main_li{
			height:100px;
			background-color: #aaf;
			border-radius: 10px;
			margin:5px;
		}
		.left{
			width:20%;
			float:left;
		}
		.right{
			width:80%;
			float:left;
		}
	</style>
	<script src="jquery.js"></script>
</head>
<body>
	<h2>云知梦微信上墙系统</h2>
	<div class="main">
		<ul id="ul">
			<?php


				while ($row=mysql_fetch_assoc($res)) {
					# code...
					echo '<li>
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

			?>
			
			
		</ul>
	</div>
</body>
<script>
	setInterval(function(){
		$.get('http://yzm17.applinzi.com/qiang/ajax.php',{},function(data){
			$("#ul").html(data);
		});
	},3000);
</script>
</html>