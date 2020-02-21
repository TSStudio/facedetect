<?php
session_start();
error_reporting(E_ALL || ~E_NOTICE);
include '../include/server-info.php';
$lang=$_SESSION['language'];
if ($_SESSION['username']==""){
    die("请使用已登录账号验证");
}
if(time()-$_SESSION["lastsend"]<=60){
    die("请勿重复发送");
}
$pattern='/^[A-Za-zd]+([-_.][A-Za-zd]+)*@([A-Za-zd]+[-.])+[A-Za-zd]{2,5}$/';
  if(!preg_match($pattern,$_session['email'])){
    echo "邮件地址不合法";
    die();
  }
$type=$_GET["type"];
function randoms($length) {
    srand(date("s"));
    $possible_charactors = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $string = "";
    while (strlen($string) < $length) {
        $string.= substr($possible_charactors, (rand() % (strlen($possible_charactors))) , 1);
    }
    return ($string);
}
$econfirm=randoms(30);
if($type=="old"){
    $t="之前";
    $mailaddr=$_SESSION["email"];
    $_SESSION["Econfirm"]=$econfirm;
}else if($type=="new"){
    $t="之后";
    $mailaddr=$_GET["EmailAddr"];
    $_SESSION["Econfirm2"]=$econfirm;
    $_SESSION["mailpending"]=$mailaddr;
}else{
    die("禁止从此处访问");
}
include_once '../include/aliyun-php-sdk-core/Config.php';
use Dm\Request\V20151123 as Dm;            
$iClientProfile = DefaultProfile::getProfile("cn-hangzhou", $aliaccesskey, $aliaccesssecret);        
$client = new DefaultAcsClient($iClientProfile);    
$request = new Dm\SingleSendMailRequest();     
$request->setAccountName("no-reply@mailsend.tmysam.top");
$request->setFromAlias("TSStudio");
$request->setAddressType(1);
$request->setTagName("TSStudio");
$request->setReplyToAddress("true");
$request->setToAddress($mailaddr);
$request->setSubject("TS Studio邮箱验证");
$address='https://security.tmysam.top/facedetect/apis/mailconf.php?type='.$type.'&secret='.$econfirm;
$htmlbody='<div style="height=100%;"><div style="width:100%;background-color:#0000ff;padding:20px;"><img src="https://resource.tmysam.top/i/logo_fff.png" style="display:inline;"><font style="font-size:3em;color:#ffffff;font-weight:bold;position:absolute;right:100px;">邮件确认</font></div><div style="font-size:1.5em;padding:20px 200px 200px 200px;background-color:#aaaaaa;">请点击<a href="'.$address.'">此链接</a>验证你'.$t.'用的邮箱，如果这不是你的操作，请忽略</div><div style="color:white;width:100%;height:50px;background-color:#333;"><p>&nbsp;&nbsp;&nbsp;© 2014-'.date("Y").' TS Studio All rights reserved.</p></div></div>';
$request->setHtmlBody($htmlbody);        
try {
    $response = $client->getAcsResponse($request);
}
catch (ClientException  $e) {
    print_r($e->getErrorCode());   
    print_r($e->getErrorMessage());   
}
catch (ServerException  $e) {        
    print_r($e->getErrorCode());   
    print_r($e->getErrorMessage());
}
echo "成功发送";
$_SESSION["lastsend"]=time();