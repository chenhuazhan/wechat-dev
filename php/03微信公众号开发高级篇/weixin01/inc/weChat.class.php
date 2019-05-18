<?php
/**
 * Created by PhpStorm.
 * User: chenhuazhan
 * Date: 2019/5/18
 * Time: 9:50
 * Desc: 微信主类
 */

class weChat
{
    //定义服务器访问URL
    private $serverUrl = 'http://152.136.130.234';
    private $postObj = null;
    private $appid;
    private $appsecret;
    private $mysql;
    private $mem;
    private $curl;
    private $reply;

    public $affected_rows;

    //构造函数
    public function __construct($appid,$appsecret){
        $this->appid = $appid;
        $this->appsecret = $appsecret;
        $mysq_conf = $GLOBALS['config']['mysql'];
        $this->mysql = new mysql($mysq_conf);
        $this->mem = new myMemCache("127.0.0.1", 11111);
        $this->curl = new curl();
    }

    //消息响应
    public function responseMsg()
    {
        //get post data, May be due to the different environments
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

        //extract post data
        if (!empty($postStr)) {
            $this->postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $postObj = $this->postObj;
            $this->reply = new weChatReply($postObj);
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
                    $Latitude = $postObj->Location_X;   //纬度
                    $Longitude = $postObj->Location_Y;  //经度


                    $contentStr = "处理地理位置消息:\n你所处位置为:\n经度:" . $Longitude . "\n纬度:" . $Latitude . "\n地图缩放大小为:" . $postObj->Scale . "\n地理位置信息为:" . $postObj->Label;
                    break;
                case 'mysql':
                    $contentStr = "处理链接消息:\n消息标题为:" . $postObj->Title . "\n消息描述为:" . $postObj->Description . "\n消息Url地址为:" . $postObj->Url;
                    break;
                case 'event':
                    // 处理事件
                    $this->handleEvent();
                    break;

                default:
                    $contentStr = "无法处理的消息类型！！！";
            }
            $this->reply->text($contentStr);

        } else {
            echo "";
            exit;
        }
    }

    private function handleText($content)
    {
        $postObj = $this->postObj;
        $musicInfo = $GLOBALS['config']['music'];
        $str = '';
        switch ($content) {

            case '点歌':
                $str = "欢迎使用点歌系统\n请输入对应的编号试听歌曲\n";
                for ($i = 0; $i < count($musicInfo); $i++) {
                    $str .= $i + 1 . ' ' . $musicInfo[$i]['title'] . '-' . $musicInfo[$i]['singer'] . "\n";
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
                $this->reply->news($data);
                break;

            default:
                preg_match('/^ly([a-z|A-Z|0-9|\x{4e00}-\x{9fa5}]+)/ui', $content,$arr);
                if ($arr[0]) {
                    $sql = "insert into leave_msgs values(null,'$postObj->FromUserName','$arr[1]',null)";
                    // $this->reply->text($postObj,$sql);
                    $this->mysql->sqlExec($sql);
                    $this->reply->text("恭喜上墙成功");
                }

                preg_match('/^zb([a-z|A-Z|0-9|\x{4e00}-\x{9fa5}]+)/ui', $content, $arr1);
                if ($arr1[0]) {
                    $sql = "select * from positions where openid='{$postObj->FromUserName}'";
                    $position = $this->mysql->sqlQuery($sql);
                    $search = urlencode($arr1[1]);
                    //$this->reply->text($search);
                    if ($position) {
                        $url = "{$this->serverUrl}/app/periphery_search/index.php?search={$search}&j={$position[Longitude]}&w={$position[Latitude]}";
                        $this->reply->text($url);
                    }else{
                        $this->reply->text('请您提交您的地理位置信息');
                    }
                }
                //用正则表达式判断输入的是否是纯数字，如果是纯数字，则将其视为歌曲编号处理
                if (preg_match('/^\d{1,2}$/', $content)) {
                    $index = (int)$content - 1;
                    //当编号不在范围内时提示错误
                    if ($index >= count($musicInfo) || $index < 0) {
                        $str = "歌曲编号出错";
                    } else {
                        $data = array(
                            'Title' => $musicInfo[$index]['title'],
                            'Description' => $musicInfo[$index]['title'] . '-' . $musicInfo[$index]['singer'],
                            'MusicUrl' => $this->serverUrl . "/music/" . $musicInfo[$index]['url'],
                            'HQMusicUrl' => $this->serverUrl . "/music/" . $musicInfo[$index]['url']
                        );
                        //$str = $data['MusicUrl'];
                        //$this->reply->text($str);
                        //回复一个音乐类消息
                        $this->reply->music($this->postObj, $data);
                    }
                }else{
                    $this->tuLingReply($content);
                }
        }
        return $str;
    }


    //处理事件
    private function handleEvent()
    {
        $postObj = $this->postObj;
        $Event = $postObj->Event;
        $str = '';
        //$this->reply->text($Event);
        switch ($Event) {
            case 'subscribe':

                $url="https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$this->getAccessToken()."&openid=".$postObj->FromUserName."&lang=zh_CN";
                $userInfo=$this->curl->httpRequest($url);

                // 查看用户是否在用户表中
                $sql = "select id from users where openid = '$userInfo[openid]'";
                //$this->reply->text($sql);
                $res = $this->mysql->sqlQuery($sql,true);
                if(count($res)>0){
                    $status = 2;
                    $sql="update users set status = {$status} where openid='$userInfo[openid]'";
                }else{
                    $sql="insert into luckydraws values(null,'$userInfo[openid]',3,'')";
                    $this->mysql->sqlExec($sql);
                    $status = 1;
                    $sql="insert into users values(null,'{$userInfo[openid]}','$userInfo[nickname]','$userInfo[sex]','$userInfo[country]','$userInfo[province]','$userInfo[city]','$userInfo[headimgurl]',$userInfo[subscribe_time],'$userInfo[subscribe_scene]',$status)";
                }
                $this->mysql->sqlExec($sql);
                $welcome = "终于等到你\n我们的商城发起了一个优惠券抽奖活动，快来参与吧\n点击下面蓝色文字\n<a href='{$this->serverUrl}/app/luckdraw/?openid={$userInfo[openid]}'>进入抽奖页面</a>";
                $this->reply->text($welcome);
                break;
            case 'unsubscribe':
                $status = 0;
                $sql="update users set status = {$status} where openid='$postObj->FromUserName'";
                $this->mysql->sqlExec($sql);
                break;
            case 'CLICK':
                $this->handleClickEvent();
                break;
            case 'LOCATION':
                $openid = $postObj->FromUserName;   //纬度
                $Latitude = $postObj->Latitude;   //纬度
                $Longitude = $postObj->Longitude;  //经度
                $this->saveLocation($openid,$Latitude,$Longitude);
                exit();
            default:
                # code...
                $this->reply->text("未处理的事件类型");
                break;
        }

        return $str;
    }

    //处理click事件
    private function handleClickEvent()
    {
        $postObj = $this->postObj;
        $EventKey = $postObj->EventKey;
        $str = '';
        //$this->reply->text($EventKey);
        switch ($EventKey) {
            case 'JOKE':

                $showapi_appid = '94899';
                $showapi_secret = 'd8d04dceb5544ca5afec876b035d71cd';
                $paramArr = array(
                    'showapi_appid'=> $showapi_appid,
                    'page'=> rand(0,10000),
                    'maxResult'=> "1"
                );


                $paraStr = "";
                $signStr = "";
                ksort($paramArr);
                foreach ($paramArr as $key => $val) {
                    if ($key != '' && $val != '') {
                        $signStr .= $key . $val;
                        $paraStr .= $key . '=' . urlencode($val) . '&';
                    }
                }
                $signStr .= $showapi_secret;//排好序的参数加上secret,进行md5
                $sign = strtolower(md5($signStr));
                $paraStr .= 'showapi_sign=' . $sign;//将md5后的值作为参数,便于服务器的效验

                $param = $paraStr;
                $url = 'http://route.showapi.com/341-1?' . $param;

                $result = $this->curl->httpRequest($url);
                $this->reply->text($result['showapi_res_body']['contentlist'][0]['text']);
                break;

            case 'SEARCH':
                $this->reply->text("要使用公众号搜索周边功能，请在公众对话框输入\"zb+搜索关键词\",如\"zbKTV\",\"zb酒店\"");
                break;
            default:
                # code...
                break;
        }

        return $str;
    }

    //存储地理位置
    private function saveLocation($openid,$Latitude,$Longitude)
    {
        $sql = "select * from positions where openid='{$openid}'";
        $position = $this->mysql->sqlQuery($sql);

        if ($position) {
            $sql = "update positions set Latitude='{$Latitude}',Longitude='{$Longitude}' where  openid='{$openid}'";
        } else {
            $sql = "insert into positions values(null,'{$openid}','{$Latitude}','{$Longitude}')";
        }
        //$this->reply->text($sql);
        $this->mysql->sqlExec($sql);
    }


    //机器人回复消息
    private function tuLingReply($content){
        $url="http://www.tuling123.com/openapi/api?key=c11311dda971ef36a39d2d2f57b86a98&info=".$content;
        // $arr=array(
        // 	"key"=>'c11311dda971ef36a39d2d2f57b86a98',
        // 	"info"=>$Recognition,
        // 	);
        // $json=json_encode($arr);
        $tuArr=$this->curl->httpRequest($url);
        switch ($tuArr['code']) {
            case '100000':
                $this->reply->text($tuArr['text']);
                break;
            case '200000':
                $this->reply->text("<a href='".$tuArr[url]."'>".$tuArr['text'].'</a>');
                break;

            default:
                # code...
                break;
        }
        exit();
    }

    //获取公众号access_token
    private function getAccessToken()
    {
        $access_token = $this->mem->getMemcache('access_token');
        if(!$access_token){
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->appid}&secret={$this->appsecret}";
            $request = $this->curl->httpRequest($url);
            var_dump($request);
            $access_token = $request['access_token'];
            $this->mem->setMemcache('access_token',$access_token,7000);
        }
        return $access_token;
    }

    // 创建菜单
    public function menuCreate($data)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token={$this->getAccessToken()}";
        return $request = $this->curl->httpRequest($url, $data);
    }

    // 查询菜单
    public function menuSelect()
    {
        $url = "https://api.weixin.qq.com/cgi-bin/menu/get?access_token={$this->getAccessToken()}";
        return $this->curl->httpRequest($url);
    }

    // 删除菜单
    public function menuDel()
    {
        $url = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token={$this->getAccessToken()}";
        return $this->curl->httpRequest($url);
    }

}
