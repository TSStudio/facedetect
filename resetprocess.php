<?php
include './include/server-info.php';
session_start();
error_reporting(E_ALL || ~ E_NOTICE);
?>
<html>
<body>
  <?php
if (isset($_REQUEST['authcode'])) {
    if (strtolower($_REQUEST['authcode']) != $_SESSION['authcode']) {
        //提示以及跳转页面
        echo "<script language=\"javascript\">";
        echo "alert(\"验证码错误\");";
        echo "document.location=\"./reset.php\"";
        echo "</script>";
        exit();
    }
}
function random($length) {
    srand(date("s"));
    $possible_charactors = "0123456789abcdef";
    $string = "";
    while (strlen($string) < $length) {
        $string.= substr($possible_charactors, (rand() % (strlen($possible_charactors))) , 1);
    }
    return ($string);
}
$username = $_SESSION['username'];
$oldpassword = hash("sha256", $_POST["oldpw"]);
$newpassword = hash("sha256", $_POST["password"]);
$con = new \mysqli($dbhost,$dbuser,$dbpawd,$dbname);;
$dbusername = null;
$dbpassword = null;
$result = $con->query("select * from user where realname ='{$username}';");
while ($row = mysqli_fetch_array($result)) {
    $dbusername = $row["realname"];
    $dbpassword = $row["password"];
}
//
$pw = explode('$', $dbpassword);
$salt = $pw['2'];
$pass = $pw['3'];
$password = hash("sha256", $oldpassword . $salt);
if (is_null($dbusername)) {
?> 
  <script type="text/javascript"> 
    alert("用户名处理错误"); 
    window.location.href="index.php"; 
  </script>  
  <?php
}
if ($password != $pass) {
?> 
  <script type="text/javascript"> 
    alert("密码错误"); 
    window.location.href="reset.php"; 
  </script> 
  <?php
}
$randomstr = random(15);
$newpassword = hash("sha256", $newpassword . $randomstr);
$newpassword = '$SHA$' . $randomstr . '$' . $newpassword;
$con->query("update user set password='{$newpassword}' where realname='{$username}'") or die("存入数据库失败" . mysqli_error()); //如果上述用户名密码判定不错，则update进数据库中
mysqli_close($con);
?> 
 
 
  <script type="text/javascript"> 
    alert("密码修改成功"); 
    window.location.href="index.php"; 
  </script> 
?>
</body>
</html>
