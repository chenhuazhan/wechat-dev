<?php
/**
 * wechat php test
 * update time: 20141008
 */

//define your token
define("TOKEN", "weixin");
$wechatObj = new wechatCallbackapiTest();
if($_GET["echostr"]){
    $wechatObj->valid();
}else{
    $wechatObj->responseMsg();
}

class wechatCallbackapiTest
{
    public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }

    public function responseMsg()
    {
        //get post data, May be due to the different environments
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

        //extract post data
        if (!empty($postStr)){

            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            $msgType = trim($postObj->MsgType);

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


            switch ($msgType) {
                case 'text':
                    $contentStr = "处理文本消息:\n你给我发送的内容是:\n".$postObj->Content;
                    break;
                case 'image':
                    $contentStr = "处理图片消息:\n图片链接:".$postObj->PicUrl."\n图片消息媒体id，可以调用获取临时素材接口拉取数据".$postObj->MediaId;
                    break;
                case 'voice':
                    $contentStr = "处理语音消息:\n语音格式:".$postObj->Format."\n语音消息媒体id，可以调用获取临时素材接口拉取数据".$postObj->MediaId;
                    //如果开通语音识别
                    if($postObj->Recognition){
                        $contentStr .= "\n语音识别结果:".$postObj->Recognition;
                    }
                    break;
                case 'video':
                    $contentStr = "处理视频消息:\n视频消息缩略图的媒体id，可以调用多媒体文件下载接口拉取数据:".$postObj->ThumbMediaId."\n视频消息媒体id，可以调用获取临时素材接口拉取数据".$postObj->MediaId;;
                    break;
                case 'shortvideo':
                    $contentStr = "处理小视频消息:\n视频消息缩略图的媒体id，可以调用多媒体文件下载接口拉取数据:".$postObj->ThumbMediaId."\n视频消息媒体id，可以调用获取临时素材接口拉取数据".$postObj->MediaId;;
                    break;
                case 'location':
                    $contentStr = "处理地理位置消息:\n你所处位置为:".$postObj->Location_X.",".$postObj->Location_Y."\n地图缩放大小为:".$postObj->Scale."\n地理位置信息为:".$postObj->Label;
                    break;
                case 'link':
                    $contentStr = "处理链接消息:\n消息标题为:".$postObj->Title."\n消息描述为:".$postObj->Description."\n消息Url地址为:".$postObj->Url;
                    break;

                default:
                    $contentStr = "无法处理的消息类型！！！";
            }
            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $repRsgType, $contentStr);
            echo $resultStr;

        }else {
            echo "";
            exit;
        }
    }

    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }
}
