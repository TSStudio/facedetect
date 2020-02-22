<?php
include 'server-info.php';
header("Content-type: text/html; charset=utf-8");
include "log.php";
$logger=new logger($dbhost, $dbuser, $dbpawd, $dbname);
session_start();
error_reporting(E_ALL || ~ E_NOTICE);
//前期验证（无数据库
$iptru=$_SERVER["HTTP_X_FORWARDED_FOR"];
$url='https://ssl.captcha.qq.com/ticket/verify?aid='.$captappid.'&AppSecretKey='.$captappsecret.'&Ticket='.$_POST['ticket'].'&Randstr='.$_POST['randstr'].'&UserIP='.$iptru;
$html = file_get_contents($url);
$json = json_decode($html,true);
if($json['response']!=1){
    $logger->log("warn","[Captcha Not PASSED]");
    echo '验证失败';
    die();
}
$username = $_POST["username"];
if(strpos($username," ")||strpos($username,"--")||strpos($username,"*")){
    $logger->log("warn","[USERNAME Not PASSED]");
    ?> 
    <script type="text/javascript"> 
    alert("用户名含有非法字符"); 
    window.location.href="register.html";
    </script> 
    <?php
    die();
}
//连数据库验证
$con = mysqli_connect($dbhost, $dbuser, $dbpawd, $dbname);
if (!$con) {
    die('数据库连接失败'.mysqli_error());
}
$dbusername=null;
$dbpassword=null;
$result=$con->query("select username from user where username=\"".$username."\";");
while ($row = mysqli_fetch_array($result)) {
    $dbusername=$row["username"];
}
if (!is_null($dbusername)) {
    ?>
    <script type="text/javascript"> 
    $logger->log("warn","[USER EXISTED]");
    alert("用户已存在"); 
    window.location.href="register.html";
    </script>  
    <?php
}
//计算出密码
$password = hash("sha256", $_POST["password"]);
function random($length) {
    srand(date("s"));
    $possible_charactors="0123456789abcdef";
    $string="";
    while (strlen($string) < $length) {
        $string.=substr($possible_charactors,(rand()%(strlen($possible_charactors))),1);
    }
    return($string);
}
$salt=random(15);
$password=hash("sha256",$password.$salt);
//写入数据库
$con->query('INSERT INTO `user` (username,lastlogin,reg,regip,password,salt) values ("'.$username.'",'.time().','.time().',"'.$iptru.'","'.$password.'","'.$salt.'")');
$logger->log("info","[USER ".$username." REGISTERED]");
$con->close();
$_SESSION["fdun"]=$username;
$_SESSION["isLogged"]=true;