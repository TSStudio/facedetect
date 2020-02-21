<?php
include './include/server-info.php';
header("Content-type: text/html; charset=utf-8");
session_start();
error_reporting(E_ALL || ~ E_NOTICE);
?>
<html>
<body>
  <?php
$iptru=$_SERVER["HTTP_X_FORWARDED_FOR"];
$url='https://ssl.captcha.qq.com/ticket/verify?aid='.$captappid.'&AppSecretKey='.$captappsecret.'&Ticket='.$_POST['ticket'].'&Randstr='.$_POST['randstr'].'&UserIP='.$iptru;
$html = file_get_contents($url);
$json = json_decode($html,true);
if($json['response']!=1){
    echo '验证失败';
}
$username = $_POST["username"];
$email=$_POST["email"];
if(strpos($username," or ")||strpos($username,"--")||strpos($username,"/*")||strpos($username,"*/")){
    ?> 
  <script type="text/javascript"> 
    alert("用户名含有非法字符"); 
    window.location.href="loginform.php?code=103&URL=<?php echo $_GET["URL"];?>"; 
  </script> 
  <?php
    die();
    }
    $pattern='/^[A-Za-z0-9d]+([-_.][A-Za-z0-9d]+)*@([A-Za-z0-9d]+[-.])+[A-Za-zd]{2,5}$/';
  if(!preg_match($pattern,$email)){
    echo '<script>alert("邮件地址不合法");</script>';
    echo '<script>window.location.href="loginform.php?code=103&URL='.$_GET["URL"].'</script>'; 
    die();
  }
$password = hash("sha256", $_POST["password"]);
function random($length) {
    srand(date("s"));
    $possible_charactors = "0123456789abcdef";
    $string = "";
    while (strlen($string) < $length) {
        $string.= substr($possible_charactors, (rand() % (strlen($possible_charactors))) , 1);
    }
    return ($string);
}
function randoms($length) {
  srand(date("s"));
  $possible_charactors = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
  $string = "";
  while (strlen($string) < $length) {
      $string.= substr($possible_charactors, (rand() % (strlen($possible_charactors))) , 1);
  }
  return ($string);
}
$randomstr = random(15);
$password = hash("sha256", $password . $randomstr);
$password = '$SHA$' . $randomstr . '$' . $password;
$con = mysqli_connect($dbhost, $dbuser, $dbpawd, $dbname);
if (!$con) {
    die('数据库连接失败' . mysqli_error());
}
$dbusername = null;
$dbpassword = null;
$result = $con->query("select realname from user where realname ='{$username}';");
while ($row = mysqli_fetch_array($result)) {
    $dbusername = $row["realname"];
}
if (!is_null($dbusername)) {
?>
  <script type="text/javascript"> 
    alert("用户已存在"); 
    window.location.href="regform.php?URL=<?php
    echo $_GET['URL']; ?>&code=107"; 
  </script>  
  <?php
}
list($msec, $sec) = explode(' ', microtime());
$msectime = (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
$realname = strtolower($username);
$realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
$times=time();
//生成邮件验证号
$econfirm=randoms(30);
$con->query("insert into user (username,regip,ip,regdate,lastlogin,name,realname,password,confirmCode,email,isEmailConfirmed,EmailLastSend) values('0','{$realip}','{$realip}','{$msectime}','{$msectime}','{$realname}','{$username}','{$password}','{$econfirm}','{$email}',0,'{$times}')") or die("存入数据库失败" . mysqli_error());
$con->close();
$_SESSION["username"] = $username;
$_SESSION["id"] = $time;
$_SESSION["language"] = "zh_CN";
$_SESSION["email"]=$email;
$_SESSION["isEmailConfirmed"]=false;
//-------------------------------------------
//发送验证邮件
include_once 'include/aliyun-php-sdk-core/Config.php';
use Dm\Request\V20151123 as Dm;            
$iClientProfile = DefaultProfile::getProfile("cn-hangzhou", $aliaccesskey, $aliaccesssecret);        
$client = new DefaultAcsClient($iClientProfile);    
$request = new Dm\SingleSendMailRequest();     
$request->setAccountName("no-reply@mailsend.tmysam.top");
$request->setFromAlias("TSStudio");
$request->setAddressType(1);
$request->setTagName("TSStudio");
$request->setReplyToAddress("true");
$request->setToAddress($email);
$request->setSubject("TS Studio邮箱验证");
$address='https://security.tmysam.top/facedetect/emailc.php?secret='.$econfirm;
$htmlbody='<div style="height=100%;"><div style="width:100%;background-color:#0000ff;padding:20px;"><img src="https://resource.tmysam.top/i/logo_fff.png" style="display:inline;"><font style="font-size:3em;color:#ffffff;font-weight:bold;position:absolute;right:100px;">邮件确认</font></div><div style="font-size:1.5em;padding:20px 200px 200px 200px;background-color:#aaaaaa;">请点击<a href="'.$address.'">此链接</a>验证你注册时用的邮箱,或者扫描下方二维码:<br><img src="https://security.tmysam.top/qrcode.php?code='.rawurlencode($address).'" />如果这不是你的操作，请忽略</div><div style="color:white;width:100%;height:50px;background-color:#333;"><p>&nbsp;&nbsp;&nbsp;© 2014-'.date("Y").' TS Studio All rights reserved.</p></div></div>';
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
//-------------------------------------------
?> 
  <script type="text/javascript"> 
    alert("注册成功，验证邮件已发送"); 
    window.location.href="index.php"; 
  </script> 
</body>
</html>
