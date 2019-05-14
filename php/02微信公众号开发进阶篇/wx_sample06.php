<?php
/**
 * wechat php test
 * update time: 20141008
 */
header("Content-Type: text/html;charset=utf-8");

//define your token
define("TOKEN", "weixin");
$wechatObj = new wechatCallbackapiTest();
if ($_GET["echostr"]) {
    $wechatObj->valid();
} else {
    if ($_GET["menu"]) {
        switch ($_GET["menu"]) {
            case 'create':
                $data = ' {
     "button":[
     {    
          "type":"click",
          "name":"今日歌曲",
          "key":"V1001_TODAY_MUSIC"
      },
      {
           "name":"菜单",
           "sub_button":[
           {    
               "type":"view",
               "name":"搜索",
               "url":"http://www.soso.com/"
            },
            {
                 "type":"miniprogram",
                 "name":"wxa",
                 "url":"http://mp.weixin.qq.com",
                 "appid":"wx286b93c14bbf93aa",
                 "pagepath":"pages/lunar/index"
             },
            {
               "type":"click",
               "name":"赞一下我们",
               "key":"V1001_GOOD"
            },
			{
				"type": "scancode_waitmsg", 
				"name": "扫码带提示", 
				"key": "rselfmenu_0_0"
			}, 
			{
				"type": "scancode_push", 
				"name": "扫码推事件", 
				"key": "rselfmenu_0_1"
			}
        ]
       },
       {
           "name":"菜单",
           "sub_button":[
           {
				"type": "pic_sysphoto", 
				"name": "系统拍照发图", 
				"key": "rselfmenu_1_0", 
			   "sub_button": [ ]
			 }, 
			{
				"type": "pic_photo_or_album", 
				"name": "拍照或者相册发图", 
				"key": "rselfmenu_1_1", 
				"sub_button": [ ]
			}, 
			{
				"type": "pic_weixin", 
				"name": "微信相册发图", 
				"key": "rselfmenu_1_2", 
				"sub_button": [ ]
			}, 
			{
				"name": "发送位置", 
				"type": "location_select", 
				"key": "rselfmenu_2_0"
			}]
       }]
 }';

                $arr = $wechatObj->menuCreate($data);
                echo "<pre>";
                print_r($arr);
                break;

            case 'select':
                $arr = $wechatObj->menuSelect();
                echo "<pre>";
                print_r($arr);
                break;

            case 'del':
                $arr = $wechatObj->menuDel();
                echo "<pre>";
                print_r($arr);
                break;
            default:
                echo '没有该操作';
        }

    } else {
        $wechatObj->responseMsg();
    }

}

class wechatCallbackapiTest
{
    //定义服务器访问URL
    private $serverUrl = 'http://152.136.130.234';
    //歌曲信息
    private $music = [
        [
            'title' => '爱情的故事',
            'singer' => '群星',
            'url' => '1.mp3'
        ], [
            'title' => '罗密欧与朱丽叶',
            'singer' => '群星',
            'url' => '2.mp3'
        ], [
            'title' => '幸福梦',
            'singer' => '张碧晨',
            'url' => '3.mp3'
        ], [
            'title' => 'Could You Stay With Me-Could You Stay With Me',
            'singer' => '张靓颖',
            'url' => '4.mp3'
        ]
    ];
    private $postObj = null;
    private $appid = 'wx2870147026ee4123';
    private $appsecret = '49e4fb9fe74e6d5bf9fe94fe19731366';

    //接口验证
    public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if ($this->checkSignature()) {
            echo $echoStr;
            exit;
        }
    }

    // 检验签名
    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }

    //普通消息响应
    public function responseMsg()
    {
        //get post data, May be due to the different environments
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

        //extract post data
        if (!empty($postStr)) {

            $this->postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $postObj = $this->postObj;
            $msgType = trim($postObj->MsgType);

            switch ($msgType) {
                case 'text':
                    //封装一个专门处理文本消息的方法handleText并调用
                    $contentStr = $this->handleText($postObj->Content);
                    if (!$contentStr) {
                        $contentStr = "处理文本消息:\n你给我发送的内容是:\n" . $postObj->Content;
                    }
                    break;
                case 'image':
                    $contentStr = "处理图片消息:\n图片链接:" . $postObj->PicUrl . "\n图片消息媒体id，可以调用获取临时素材接口拉取数据" . $postObj->MediaId;
                    break;
                case 'voice':
                    $contentStr = "处理语音消息:\n语音格式:" . $postObj->Format . "\n语音消息媒体id，可以调用获取临时素材接口拉取数据" . $postObj->MediaId;
                    //如果开通语音识别
                    if ($postObj->Recognition) {
                        $contentStr .= "\n语音识别结果:" . $postObj->Recognition;
                    }
                    break;
                case 'video':
                    $contentStr = "处理视频消息:\n视频消息缩略图的媒体id，可以调用多媒体文件下载接口拉取数据:" . $postObj->ThumbMediaId . "\n视频消息媒体id，可以调用获取临时素材接口拉取数据" . $postObj->MediaId;;
                    break;
                case 'shortvideo':
                    $contentStr = "处理小视频消息:\n视频消息缩略图的媒体id，可以调用多媒体文件下载接口拉取数据:" . $postObj->ThumbMediaId . "\n视频消息媒体id，可以调用获取临时素材接口拉取数据" . $postObj->MediaId;;
                    break;
                case 'location':
                    $contentStr = "处理地理位置消息:\n你所处位置为:" . $postObj->Location_X . "," . $postObj->Location_Y . "\n地图缩放大小为:" . $postObj->Scale . "\n地理位置信息为:" . $postObj->Label;
                    break;
                case 'link':
                    $contentStr = "处理链接消息:\n消息标题为:" . $postObj->Title . "\n消息描述为:" . $postObj->Description . "\n消息Url地址为:" . $postObj->Url;
                    break;
                case 'event':
                    $Event = $postObj->Event;
                    // 处理事件
                    $this->handleEvent($Event);
                    break;

                default:
                    $contentStr = "无法处理的消息类型！！！";
            }
            $this->replyText($contentStr);

        } else {
            echo "";
            exit;
        }
    }

    private function handleText($content)
    {
        $str = '';
        switch ($content) {
            case '点歌':
                $str = "欢迎使用点歌系统\n请输入对应的编号试听歌曲\n";
                for ($i = 0; $i < count($this->music); $i++) {
                    $str .= $i + 1 . ' ' . $this->music[$i]['title'] . '-' . $this->music[$i]['singer'] . "\n";
                }
                break;

            case 'CSDN':
                $data = array(
                    'Title' => '唯一被图灵求婚的女人，与他并肩破译纳粹德国 Enigma 密码，拯救千万人生命！| 人物志',
                    'Description' => '',
                    'PicUrl' => 'http://mmbiz.qpic.cn/mmbiz_jpg/WnYgQCYvFO0Tm5I9Afc3FzicGs5AppV48BFyan8AHhyjXo1goEQsngWnZ2uXatuVrdnu5yQGYbHfD0UicqiaJXLKA/0?wx_fmt=jpeg',
                    'Url' => 'https://mp.weixin.qq.com/s?__biz=MjM5MjAwODM4MA==&mid=2650720058&idx=1&sn=b8fbe8002ca298d4e2f3842dba27b05b',
                );
                //$str = $data[0]['Title'];
                $this->replyNews($data);
                break;

            default:
                //用正则表达式判断输入的是否是纯数字，如果是纯数字，则将其视为歌曲编号处理
                if (preg_match('/^\d{1,2}$/', $content)) {
                    $index = (int)$content - 1;
                    //当编号不在范围内时提示错误
                    if ($index >= count($this->music) || $index < 0) {
                        $str = "歌曲编号出错";
                    } else {
                        $data = array(
                            'Title' => $this->music[$index]['title'],
                            'Description' => $this->music[$index]['title'] . '-' . $this->music[$index]['singer'],
                            'MusicUrl' => $this->serverUrl . "/music/" . $this->music[$index]['url'],
                            'HQMusicUrl' => $this->serverUrl . "/music/" . $this->music[$index]['url']
                        );
                        //$str = $data['MusicUrl'];
                        //回复一个音乐类消息
                        $this->replyMusic($this->postObj, $data);
                    }
                }
        }
        return $str;
    }

    // 回复文本消息
    private function replyText($contentStr)
    {
        $postObj = $this->postObj;
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $textTpl = "<xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[%s]]></MsgType>
            <Content><![CDATA[%s]]></Content>
            <FuncFlag>0</FuncFlag>
        </xml>";
        $time = time();
        $repRsgType = 'text';

        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $repRsgType, $contentStr);
        echo $resultStr;
        exit();
    }

    // 回复音乐消息
    private function replyMusic($postObj, $data)
    {
        $xml = "<xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%d</CreateTime>
            <MsgType><![CDATA[music]]></MsgType>
            <Music>
            <Title><![CDATA[%s]]></Title>
            <Description><![CDATA[%s]]></Description>
            <MusicUrl><![CDATA[%s]]></MusicUrl>
            <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
            </Music>
        </xml>";
        echo sprintf($xml, $postObj->FromUserName, $postObj->ToUserName, time(), $data['Title'], $data['Description'], $data['MusicUrl'], $data['HQMusicUrl']);
        exit();
    }

    //回复图文消息
    public function replyNews($data)
    {
        $postObj = $this->postObj;

        $xml = "	<xml>
				<ToUserName><![CDATA[%s]]></ToUserName>
				<FromUserName><![CDATA[%s]]></FromUserName>
				<CreateTime>%d</CreateTime>
				<MsgType><![CDATA[news]]></MsgType>
				<ArticleCount>1</ArticleCount>
				<Articles>
					<item>
                        <Title><![CDATA[{$data['Title']}]]></Title> 
                        <Description><![CDATA[{$data['Description']}]]></Description>
                        <PicUrl><![CDATA[{$data['PicUrl']}]]></PicUrl>
                        <Url><![CDATA[{$data['Url']}]]></Url>
                    </item>
				</Articles>
			</xml> ";

        echo sprintf($xml, $postObj->FromUserName, $postObj->ToUserName, time());
        exit();
    }

    //回复图片
    private function replyImage($MediaId)
    {
        $postObj = $this->postObj;
        $xml = '	<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%d</CreateTime>
                    <MsgType><![CDATA[image]]></MsgType>
                    <Image>
                    <MediaId><![CDATA[%s]]></MediaId>
                    </Image>
                    </xml>';
        echo sprintf($xml, $postObj->FromUserName, $postObj->ToUserName, time(), $MediaId);
    }


    //处理事件
    private function handleEvent($Event)
    {
        $postObj = $this->postObj;
        $str = '';
        switch ($Event) {
            case 'subscribe':
                //关注回复一张图片
                $this->replyImage("ILxDvsbhRRlpmTOTXUbaedhWB3o15_g2AkiifjL5UNMxhHvcYXlofXB_m-DnrUpD");
                break;
            case 'unsubscribe':
                # code...
                break;
            case 'CLICK':
                # code...
                break;
            default:
                # code...
                break;
        }

        return $str;
    }

    private function getAccessToken()
    {
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->appid}&secret={$this->appsecret}";
        $request = $this->httpRequest($url);
        return $request['access_token'];

    }

    private function httpRequest($url, $data = "")
    {
        // 开启curl
        $ch = curl_init();
        // 设置传输选项
        // 设置传输地址
        curl_setopt($ch, CURLOPT_URL, $url);
        // 以文件流的形式返回
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if ($data) {
            // 以post方式
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        // 发送curl
        $request = curl_exec($ch);
        $tmpArr = json_decode($request, TRUE);

        if (is_array($tmpArr)) {
            return $tmpArr;
        } else {
            return $request;
        }
        // 关闭资源
        curl_close($ch);
    }

    // 创建菜单
    public function menuCreate($data)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token={$this->getAccessToken()}";
        return $request = $this->httpRequest($url, $data);
    }

    // 查询菜单
    public function menuSelect()
    {
        $url = "https://api.weixin.qq.com/cgi-bin/menu/get?access_token={$this->getAccessToken()}";
        return $this->httpRequest($url);
    }

    // 删除菜单
    public function menuDel()
    {
        $url = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token={$this->getAccessToken()}";
        return $this->httpRequest($url);
    }


}
