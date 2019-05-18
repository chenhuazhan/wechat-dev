<?php 
include "../weChat.class.php";
define('TOKEN','y17');
$weChat=new Wechat('wxc9e5776402018fd9','90b0657dd9b0fdabfeb0173d24ad905f');

$arr=$weChat->getSignature();


var_dump($arr);
 ?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
</head>
<body>
	<button onclick="a()">选择图片</button>
	<div id="main"></div>
	<button onclick="b()">扫一扫</button>
	<button onclick="c()">预览</button>

</body>
<script>
	
	wx.config({
	    debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
	    appId: '<?php echo $arr[appId]?>', // 必填，公众号的唯一标识
	    timestamp: <?php echo $arr['timestamp']?>, // 必填，生成签名的时间戳
	    nonceStr: '<?php echo $arr[nonceStr]?>', // 必填，生成签名的随机串
	    signature: '<?php echo $arr[signature]?>',// 必填，签名，见附录1
	    jsApiList: ['chooseImage','scanQRCode','previewImage'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
	});

	wx.ready(function(){

	  
	});
	var aa=[];
	function a(){
			var main=document.getElementById('main');
			var images = {
			    localId: [],
			    serverId: []
			  };
			  var str='';
			 wx.chooseImage({
			      success: function (res) {
			        images.localId = res.localIds;
			        var imgs=images.localId;
			        aa=imgs;
			        for (var i = imgs.length - 1; i >= 0; i--) {
			        	str+='<img src="'+imgs[i]+'"><br/>'
			        };


			        main.innerHTML=str;
			      }
		    });
	}


	function b(){
		wx.scanQRCode({
	      needResult: 1,
	      desc: 'scanQRCode desc',
	      success: function (res) {
	        alert(JSON.stringify(res));
	      }
	    });
	}

	function c(){

		wx.previewImage({
		      current: aa[0],
		      urls: aa
		    });
	}

</script>
</html>