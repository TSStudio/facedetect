<?php
include 'server-info.php';
header("Content-type: text/html; charset=utf-8");
include "log.php";
$logger=new logger($dbhost, $dbuser, $dbpawd, $dbname);
session_start();
//error_reporting(E_ALL || ~ E_NOTICE);
//前期验证（无数据库
error_reporting(E_ALL);

ini_set("display_errors","On");
$iptru=$_SERVER["HTTP_X_FORWARDED_FOR"];
$url='https://ssl.captcha.qq.com/ticket/verify?aid='.$captappid.'&AppSecretKey='.$captappsecret.'&Ticket='.$_POST['ticket'].'&Randstr='.$_POST['randstr'].'&UserIP='.$iptru;
$html = file_get_contents($url);
$json = json_decode($html,true);
if($json['response']!=1){
    echo '验证失败';
    header('Location:login.html');
    die();
}
$username = $_POST["username"];
if(strpos($username," ")||strpos($username,"--")||strpos($username,"*")){
    $logger->log("warn","[USERNAME Not PASSED]");
    ?> 
    <script type="text/javascript"> 
    alert("用户名含有非法字符"); 
    window.location.href="login.html";
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
$dbsalt=null;
$result=$con->query("select username,password,salt from user where username=\"".$username."\";");
while ($row = mysqli_fetch_array($result)) {
    $dbusername=$row["username"];
    $dbpassword=$row["password"];
    $dbsalt=$row["salt"];
}
if (is_null($dbusername)) {
    ?>
    <script type="text/javascript"> 
    alert("用户不存在"); 
    window.location.href="login.html";
    </script>  
    <?php
    $logger->log("info","[USER NOT EXISTED]"); 
    die();
}
//计算出密码
$password=hash("sha256", $_POST["password"]);
$password=hash("sha256",$password.$dbsalt);
if($password!=$dbpassword){
    //密码错误
    ?>
    <script type="text/javascript">
    
    alert("密码错误"); 
    window.location.href="login.html";
    </script>
    <?php
    $logger->log("info","[WRONG PASSWORD EXCEPTION]"); 
    die();
}
//写入数据库
$con->query('UPDATE `user` SET lastlogin='.time().' where username="'.$username.'";');
echo mysqli_error($con);
$logger->log("info","[USER ".$username." LOGGED]");
$con->close();
$_SESSION["fdun"]=$username;
$_SESSION["isLogged"]=true;
header('Location:index.html');