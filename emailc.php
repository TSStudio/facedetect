<?php
$secret=$_GET["secret"];
include './include/server-info.php';
header("Content-type: text/html; charset=utf-8");
$con = mysqli_connect($dbhost, $dbuser, $dbpawd, $dbname);
$result=$con->query("select confirmCode from user where confirmCode='{$secret}';");
if(empty($secret)){
    echo "链接不合法";
    die();
}
while ($row = mysqli_fetch_array($result)) {
    $confirmCode = $row["confirmCode"];
}
if(is_null($confirmCode)){
    echo "此验证链接已失效或不存在";
    die();
}
$con->query("update user set confirmCode=0,isEmailConfirmed=1,EmailLastSend=0 where confirmCode='{$confirmCode}';");
$_SESSION['isEmailConfirmed']=true;
echo "您的邮箱已验证";
$con->close();
?>