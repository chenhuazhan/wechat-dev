<?php
mysql_connect('w.rdc.sae.sina.com.cn:3307','4342z15jm2','yh4m22ijxy33kzll0z25iykj003410k004mxykm2');

mysql_set_charset('utf8');

mysql_select_db('app_yzm17');

$sql="select * from chou where openid='$_GET[openid]'";

$res=mysql_query($sql);

$row=mysql_fetch_assoc($res);


?>
<!doctype html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>jQuery老虎机转动抽奖程序</title>
</head>
<style type="text/css">
body, div, dl, dt, dd, ul, ol, li, h1, h2, h3, h4, h5, h6, pre, code, form, fieldset, legend, input, button, textarea, blockquote, th, td, p { margin:0; padding:0 }
input, button, select, textarea, a:fouse {outline:none}
li {list-style:none;}
img {border:none;}
textarea {resize:none;}
body {margin:0;font:12px "微软雅黑"; background:#feecd4;}
/* === End CSS Reset ========== */
body{min-width:1000px;_width:expression((document.documentElement.clientWidth||document.body.clientWidth)<950?"950px":"");}
a{text-decoration:none;}
.clearfix:after {visibility:hidden;display:block;font-size:0;content:" ";clear:both;height:0;}
.clearfix{*zoom:1;}
.container{width:1000px;margin:0 auto;position:relative;/*height:198px;*/}
/* main2 */
.main2{background:url("images/main2.png") no-repeat center;
height:689px;_width:expression((document.documentElement.clientWidth||document.body.clientWidth)<1000?"1000px":"");/*最小宽度*/}
.main3{_width:expression((document.documentElement.clientWidth||document.body.clientWidth)<1000?"1000px":"");}
.main3-text{color:#744b00;font-size:23px;font-weight:bold;position:absolute;left:74px;top:210px;}
.main3-text2{color:#744b00;font-size:14px;position:absolute;left:74px;top:254px;line-height:22px;width:867px;}
.main-text{position:absolute;left:360px;top:325px;color:#b03b01;font-size:16px;}
.main2-text1{position:absolute;left:79px;top:45px;color:#ffffff;font-size:16px;}
.main2-text2{position:absolute;left:69px;top:67px;color:#ffffff;font-size:23px;font-weight:bold;}
.main2-text2 span{color:#ffff00;}
.main2-text3{position:absolute;left:69px;top:97px;color:#ffffff;font-size:18px;}
.main2-text4{position:absolute;left:382px;top:34px;color:#ffffff;font-size:18px;}
.main2-text4 span{color:#ffe700;font-weight:bold;}
.main2-text5{position:absolute;left:665px;top:34px;color:#ffffff;font-size:18px;}
.main2-text5 span{color:#ffe700;font-weight:bold;}
.num{position:absolute;left:248px;top:171px;width:124px;height:198px;overflow:hidden;}
.num-con{position:relative;top:-430px;}
.num-img{background:url("images/num.png") no-repeat;width:124px;height:1298px;margin-bottom:4px;}
.num2{left:399px;}
.num3{left:551px;}
.main3-btn{width:307px;height:95px;position:absolute;left:313px;top:-290px;cursor:pointer;}
h2,p{
	text-align: center;
}
</style>

<body>
	<div class="header">
		<h2>云知梦抽奖系统</h2>
		<p>剩余抽奖<span id="nums" style="color:red"> <?php echo $row[nums]?> </span>次</p>
		<p>中奖纪录 <?php echo $row[zhong]?></p>
	</div>
<div class="main2">
	
	<div class="container">
		<div class="num num1">
			<div class="num-con num-con1">
				<div class="num-img"></div>
				<div class="num-img"></div>
			</div>
		</div>
		<div class="num num2">
			<div class="num-con num-con2">
				<div class="num-img"></div>
				<div class="num-img"></div>
			</div>
		</div>
		<div class="num num3">
			<div class="num-con num-con3">
				<div class="num-img"></div>
				<div class="num-img"></div>
			</div>
		</div>
	</div>
</div>

<div class="main3">
	<div class="container">
		<div class="main3-btn"></div>
	</div>
</div>

</body>
</html>
<script type="text/javascript"  src="js/jquery.js"></script>
<script type="text/javascript">
$(".main3-btn").click(function () {
		var nums=$("#nums").html();
		nums=parseInt(nums);
		nums--;
		

		if (nums<0) {
			alert('抽奖次数有限');
			return false;

		}else{
			$.get('http://yzm17.applinzi.com/chou/ajax_nums.php',{'openid':'<?php echo $row[openid]?>','nums':nums},function(data){
				
			});
			$("#nums").html(nums);
			reset();
			letGo();
			

		}
		
});

var flag=false;
var index=0;
var TextNum1
var TextNum2
var TextNum3

function letGo(){

	TextNum1=parseInt(Math.random()*4)//随机数
	TextNum2=parseInt(Math.random()*4)
	TextNum3=parseInt(Math.random()*4)

	// var num1=[-549,-668,-786,-904][TextNum1];//在这里随机
	var num1=[-1377,-1495,-1614,-430,-549,-668,-786,-904][TextNum1];
	var num2=[-1377,-1495,-1614,-430,-549,-668,-786,-904][TextNum2];
	var num3=[-1377,-1495,-1614,-430,-549,-668,-786,-904][TextNum3];
	$(".num-con1").stop().animate({"top":-1140},1000,"linear", function () {
		$(this).css("top",0).animate({"top":num1},1000,"linear");
	});
	$(".num-con2").stop().animate({"top":-1140},1000,"linear", function () {
		$(this).css("top",0).animate({"top":num2},1800,"linear");
	});
	$(".num-con3").stop().animate({"top":-1140},1000,"linear", function () {
		$(this).css("top",0).animate({"top":num3},1300,"linear");
	});
	if ( TextNum3==TextNum2 && TextNum2==TextNum1) {
		setTimeout(function(){
			
			$.get('http://yzm17.applinzi.com/chou/ajax_zhong.php',{'openid':'<?php echo $row[openid]?>'},function(data){
				
			});
			alert('恭喜XXX 中奖');
		},3000);
	};
}

function reset(){
	$(".num-con1,.num-con2,.num-con3").css({"top":-430});
}
</script>
</body>
</html>