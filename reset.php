<?php
session_start();
header("Content-type: text/html; charset=utf-8");
include './include/server-info.php';
$lang=$_SESSION['language'];
include './include/'.$lang.'.php';
 ?>
<html>
<head>
<link href="css/style.css" rel="stylesheet">
<link href="css/all.css" rel="stylesheet">
<title><?=$resp?></title>
</head>
<body id="body">
<?php
error_reporting(E_ALL || ~ E_NOTICE);
if ($_SESSION['username'] == "") {
    echo "You are not logging in,jumping to the log-in page.";
    header('Refresh:0;url=loginform.php?URL=index.php&code=105');
}
?>
<br>
    <div style="vertical-align: middle;" id="input-box">
        <form action="resetprocess.php?URL=<?php
echo $_GET['URL']; ?>" method="post" name="form_register" onsubmit="return check()" style="margin:auto;" class="reset info-input">
            <center><font style="font-size:3em;"><?=$resp?></font></center><br>
            <table style="margin:auto;">
            <tr><td><i class="iconfont icon-key"></i><?=$oldp?></td><td><input type="password" name="oldpw" id="username" class="input-box"></td></tr>
            <tr><td><i class="iconfont icon-key"></i><?=$newp?></td><td><input type="password" name="password" id="password" class="input-box"></td></tr>
            <tr><td><i class="iconfont icon-key"></i><?=$cnpw?></td><td><input type="password" name="assertpassword" id="assertpassword" class="input-box"></td></tr>
            <tr><td><?=$capt?></td><td><input type="text" name='authcode' value='' class="input-box" style="width:30%;"/><a href="javascript:void(0)" onclick="document.getElementById('captcha_img').src='./captcha.php?r='+Math.random()"><img id="captcha_img" border='1' src='./captcha.php?r=echo rand(); ?>' style="width:100px; height:30px" /></a></td></tr>
            </table>
            <center>
            <table><tr><td><input type="submit" value="<?=$resp?>" class="button button-primary" style="font-style:normal;text-decoration:none;width:100%;"></td></tr><tr><td><a href="index.php" class="button button-action" style="font-style:normal;text-decoration:none;width:100%;"><?=$back?></a></td></tr></table>
            </center>
        </form> 
    </div>
  <script type="text/javascript"> 
    function check() { 
      var username=document.getElementById("username").value; 
      var password=document.getElementById("password").value; 
      var assertpassword=document.getElementById("assertpassword").value; 
      var regex=/^[/s]+$/; 
       
      if(regex.test(username)||username.length==0){ 
        alert("<?=$oldp.$misw?>"); 
        return false; 
      } 
      if(regex.test(password)||password.length==0){ 
        alert("<?=$lapw.$misw?>"); 
        return false;     
      } 
      if(password!=assertpassword){ 
        alert("<?=$ttpd?>"); 
        return false; 
      } 
    } 
  </script>
</p>
</form>
<div style="color:white;" class="copyright"><p>&nbsp;&nbsp;&nbsp;<?=$copyright?>&copy; 2014-<?php
echo date('Y'); ?>.TS Studio <?=$alrr?> 吉ICP备17003700号</p></div>
</body>
<script defer src="./css/bgi.js"></script>
</html>
