<?php
session_start();
error_reporting(E_ALL || ~E_NOTICE);
include '../include/server-info.php';
$lang=$_SESSION['language'];
if ($_SESSION['username']==""){
    die("请使用已登录账号验证");
}
$username=$_SESSION["username"];
if($_SESSION["Econfirm"]==$_GET["secret"]&&$_GET["type"]=="old"){
    $_SESSION["FirstStep"]=true;
    $_SESSION["Econfirm"]=null;
    die("验证成功");
}
if($_SESSION["Econfirm2"]==$_GET["secret"]&&$_GET["type"]=="new"){
    $_SESSION["email"]=$_SESSION["mailpending"];
    $email=$_SESSION["mailpending"];
    $_SESSION["2Step"]=true;
    $_SESSION["FirstStep"]=false;
    $_SESSION["Econfirm"]=null;
    $_SESSION["isEmailConfirmed"]=true;
    $db=mysqli_connect($dbhost, $dbuser, $dbpawd, $dbname);
    $db->query("update user set email='{$email}',isEmailConfirmed=1 where realname='{$username}';");
    $db->close();
    die("验证成功");
}
echo "验证失败";