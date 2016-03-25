<?php

use Wechat\Wechat;
require_once 'Wechat.class.php';
$wechatObj = new Wechat();

if(isset($_GET['echostr'])){
    $wechatObj->valid();
}else{
    $wechatObj->responseMsg();
}
