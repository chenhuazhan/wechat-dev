<?php

include "./weChat.class.php";
define('TOKEN','y17');
$noncestr="Wm3WZYTPz0wzccnW";
$time=time();
$weChat=new weChat('wxc9e5776402018fd9','90b0657dd9b0fdabfeb0173d24ad905f');

// 获取ticket

$url="https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$weChat->get_access_token()."&type=jsapi";

$arr=$weChat->https_request($url);

echo "<pre>";
var_dump($arr);

echo "<hr>";
$ticket=$arr['ticket'];


$str="jsapi_ticket={$ticket}&noncestr={$noncestr}&timestamp={$time}&url=http://yzm17.applinzi.com/jssdk.php";
$str=sha1($str);
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
</head>
<body>
	<button onclick="a()">IMG</button>
  <button onclick="b()">FENXIAN</button>
  <button onclick="c()">SAO</button>
  <button onclick="d()">SAO</button>
</body>
<script>
	
  wx.config({
    debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
    appId: 'wxc9e5776402018fd9', // 必填，公众号的唯一标识
    timestamp: '<?php echo $time?>', // 必填，生成签名的时间戳
    nonceStr: '<?php echo $noncestr?>', // 必填，生成签名的随机串
    signature: '<?php echo $str?>',// 必填，签名，见附录1
    jsApiList: ['onMenuShareTimeline','chooseImage','onMenuShareAppMessage','scanQRCode'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
  });
  wx.ready(function () {
  	wx.checkJsApi({
  	    jsApiList: ['chooseImage','onMenuShareAppMessage'], // 需要检测的JS接口列表，所有JS接口列表见附录2,
  	    success: function(res) {
  	        // 以键值对的形式返回，可用的api值true，不可用为false
  	        // 如：{"checkResult":{"chooseImage":true},"errMsg":"checkJsApi:ok"}
  	    }
  	});

  });

  function a(){
    var images = {
      localId: [],
      serverId: []
    };
    
    wx.chooseImage({
      success: function (res) {
        images.localId = res.localIds;
        alert('已选择 ' + res.localIds.length + ' 张图片');
      }
    });
  }

  function b(){
    wx.onMenuShareAppMessage({
      title: '互联网之子',
      desc: '在长大的过程中，我才慢慢发现，我身边的所有事，别人跟我说的所有事，那些所谓本来如此，注定如此的事，它们其实没有非得如此，事情是可以改变的。更重要的是，有些事既然错了，那就该做出改变。',
      link: 'http://movie.douban.com/subject/25785114/',
      imgUrl: 'http://demo.open.weixin.qq.com/jssdk/images/p2166127561.jpg',
      trigger: function (res) {
       // 不要尝试在trigger中使用aja x异步请求修改本次分享的内容，因为客户端分享操作是一个同步操作，这时候使用ajax的回包会还没有返回
        alert('用户点击发送给朋友');
      },
      success: function (res) {
        alert('已分享');
      },
      cancel: function (res) {
        alert('已取消');
      },
      fail: function (res) {
        alert(JSON.stringify(res));
      }
    });
  }

  function c(){
    wx.scanQRCode({
         needResult: 1,
         desc: 'scanQRCode desc',
         success: function (res) {
           alert(JSON.stringify(res));
         }
       });
  }

  function d(){
    wx.onMenuShareTimeline({
      title: '互联网之子',
      link: 'http://movie.douban.com/subject/25785114/',
      imgUrl: 'http://demo.open.weixin.qq.com/jssdk/images/p2166127561.jpg',
      trigger: function (res) {
        // 不要尝试在trigger中使用ajax异步请求修改本次分享的内容，因为客户端分享操作是一个同步操作，这时候使用ajax的回包会还没有返回
        alert('用户点击分享到朋友圈');
      },
      success: function (res) {
        alert('已分享');
      },
      cancel: function (res) {
        alert('已取消');
      },
      fail: function (res) {
        alert(JSON.stringify(res));
      }
    });
  }
</script>
</html>