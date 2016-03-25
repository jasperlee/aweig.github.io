<?php
/**
 * 微信公众账号开发基础接口
 */
namespace Wechat;

define('TOKEN', 'weixin');

//用于获取access_token
define('APPID', 'wxceff3470c5a6468f');
define('APPSECRET', 'd4624c36b6795d1d99dcf0547af5443d');

class Wechat{
    public function valid(){
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }

    /**
     * 获取access_token
     * @return mixed
     */
    public function getAccessToken(){
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.APPID.'&secret='.APPSECRET;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);

        $jsoninfo = json_decode($output, true);
        $access_token = $jsoninfo['access_token'];

        return $access_token;
    }

    /**创建自定义菜单
     * @return mixed
     */
    public function createMenu(){
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$this->getAccessToken();
        $jsonmenu = '{
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
                                   "type":"view",
                                   "name":"视频",
                                   "url":"http://v.qq.com/"
                                },
                                {
                                   "type":"click",
                                   "name":"赞一下我们",
                                   "key":"V1001_GOOD"
                                }]
                           }]
                     }';

        $result = $this->https_request($url, $jsonmenu);
        return $result;
    }


    public function https_request($url, $data=null){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        if(!empty($data)){
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);

        return $output;
    }



    public function responseMsg(){
        //get post data, May be due to the different environments
        //$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        $postStr = file_get_contents('php://input');

        //extract post data
        if (!empty($postStr)){

            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->MsgType);

            switch($RX_TYPE){
                case 'event':
                    $result = $this->receiveEvent($postObj);
                    break;
                case 'text':
                    $result = $this->receiveText($postObj);
                    break;
                case 'image':
                    $result = $this->receiveImage($postObj);
                    break;
                case 'voice':
                    $result = $this->receiveVoice($postObj);
                    break;
                case 'video':
                    $result = $this->receiveVideo($postObj);
                    break;
                default:
                    $result = 'unknow msg type: '.$RX_TYPE;
                    break;
            }

            echo $result;
        }else {
            echo "";
            exit;
        }
    }

    private function checkSignature(){
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

    private function receiveEvent($object){
        $content = "";
        switch($object->Event){
            case 'subscribe': //关注事件
                $content = '欢迎关注阿伟工作室';
                break;
            case 'unsubscribe'://取消关注事件
                $content = '';
                break;
        }

        $result = $this->transmitText($object, $content);
        return $result;
    }

    private function receiveText($object){
        $keyword = trim($object->Content);

        if($keyword == '文本'){
            //回复文本消息
            $content = '这是个文本消息';
            $result = $this->transmitText($object, $content);

        }elseif($keyword == '图文' || $keyword == '单图文'){
            //回复图文消息
            $content = array();
            $content[] = array(
                'Title' => '单图文标题',
                'Description' => '单图文内容',
                'PicUrl' => 'http://aweig.com/pic300.jpg',
                'Url' => 'http://aweig.com'
            );

            $result = $this->transmitNews($object, $content);

        }elseif($keyword == '多图文'){
            //回复多图文消息
            $content = array();
            $content[] = array(
                'Title' => '多图文标题1',
                'Description' => '多图文内容1',
                'PicUrl' => 'http://aweig.com/pic300.jpg',
                'Url' => 'http://aweig.com'
            );
            $content[] = array(
                'Title' => '多图文标题2',
                'Description' => '多图文内容2',
                'PicUrl' => 'http://aweig.com/pic300.jpg',
                'Url' => 'http://aweig.com'
            );
            $content[] = array(
                'Title' => '多图文标题3',
                'Description' => '多图文内容3',
                'PicUrl' => 'http://aweig.com/pic300.jpg',
                'Url' => 'http://aweig.com'
            );
            $result = $this->transmitNews($object, $content);

        }elseif($keyword == '音乐'){
            //回复音乐消息
            $content = array(
                'Title' => '欢乐新春',
                'Description' => '歌手：未知',
                'MusicUrl' => 'http://aweig.github.io/demo/h5_springFestival/audio/happynewyear.mp3',
                'HQMusicUrl' => 'http://aweig.github.io/demo/h5_springFestival/audio/happynewyear.mp3',
                'ThumbMediaId' =>''
            );
            $result = $this->transmitMusic($object, $content);

        }

        return $result;
    }

    private function receiveImage($object){
        //回复图片消息
        $content = array('MediaId' => $object->MediaId);
        $result = $this->transmitImage($object, $content);

        return $result;
    }

    private function receiveVoice($object){
        //回复语音消息
        $content = array('MediaId' => $object->MediaId);
        $result = $this->transmitVoice($object, $content);

        return $result;
    }

    private function receiveVideo($object){
        //回复视频消息
        $content = array(
            'MediaId' => $object->MediaId,
            'ThumbMediaId' => $object->ThumbMediaId,
            'title' => '',
            'Description' => ''
        );
        $result = $this->transmitVideo($object, $content);

        return $result;
    }

    /**
     * 回复文本消息
     * @param $object
     * @param $content
     * @return string
     */
    private function transmitText($object, $content){
        $textTpl = '<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[text]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    </xml>';
        $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content);
        return $result;
    }

    /**
     * 回复图片消息
     * @param $object
     * @param $imageArray
     * @return string
     */
    private function transmitImage($object, $imageArray){
        $itemTpl = '<Image>
                    <MediaId><![CDATA[%s]]></MediaId>
                    </Image>';
        $item_str = sprintf($itemTpl, $imageArray['MediaId']);

        $textTpl = '<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[image]]></MsgType>'.$item_str.'</xml>';
        $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    /**
     * 回复语音消息
     * @param $object
     * @param $voiceArray
     * @return string
     */
    private function transmitVoice($object, $voiceArray){
        $itemTpl = '<Voice>
                    <MediaId><![CDATA[%s]]></MediaId>
                    </Voice>';
        $item_str = sprintf($itemTpl, $voiceArray['MediaId']);

        $textTpl = '<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[voice]]></MsgType>'.$item_str.'</xml>';
        $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    /**
     * 回复视频消息
     * @param $object
     * @param $videoArray
     * @return string
     */
    private function transmitVideo($object, $videoArray){
        $itemTpl = '<Video>
                    <MediaId><![CDATA[%s]]></MediaId>
                    <ThumbMediaId><![CDATA[%s]]></ThumbMediaId>
                    <Title><![CDATA[%s]]></Title>
                    <Description><![CDATA[%s]]></Description>
                    </Video>';
        $item_str = sprintf($itemTpl, $videoArray['MediaId'], $videoArray['ThumbMediaId'], $videoArray['Title'], $videoArray['Description']);

        $textTpl = '<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[video]]></MsgType>'.$item_str.'</xml>';
        $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    /**
     * 回复图文消息
     * @param $object
     * @param $arr_item
     * @return string|void
     */
    private function transmitNews($object, $arr_item){
        if(!is_array($arr_item)){
            return;
        }

        $itemTpl = '<item>
                    <Title><![CDATA[%s]]></Title>
                    <Description><![CDATA[%s]]></Description>
                    <PicUrl><![CDATA[%s]]></PicUrl>
                    <Url><![CDATA[%s]]></Url>
                    </item>';
        $item_str = '';
        foreach($arr_item as $item){
            $item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);
        }

        $newsTpl = '<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[news]]></MsgType>
                    <ArticleCount>%s</ArticleCount>
                    <Articles>'.$item_str.'</Articles>
                    </xml> ';
        $result = sprintf($newsTpl, $object->FromUserName, $object->ToUserName, time(),count($arr_item));
        return $result;
    }

    /**
     * 回复音乐消息
     * @param $object
     * @param $musicArray
     * @return string
     */
    private function transmitMusic($object, $musicArray){
        $itemTpl = '<Music>
                    <Title><![CDATA[%s]]></Title>
                    <Description><![CDATA[%s]]></Description>
                    <MusicUrl><![CDATA[%s]]></MusicUrl>
                    <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
                    </Music>';
        $item_str = sprintf($itemTpl, $musicArray['Title'], $musicArray['Description'], $musicArray['MusicUrl'], $musicArray['HQMusicUrl']);

        $textTpl = '<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[music]]></MsgType>'.$item_str.'</xml>';
        $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }
}
