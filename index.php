<?php session_start();
error_reporting(E_ALL || ~E_NOTICE);
if ($_SESSION['username']==""){
    echo "You are not logging in,jumping to the log-in page.";
    header('Refresh:0;url=loginform.php?URL=index.php&code=105');
    die();
}
include './include/server-info.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <link href="css/all.css" rel="stylesheet">
        <meta charset="utf-8">
        <title>TS Studio PANEL</title>
    </head>
    <body id="body">
        <div id="usrbar"on><a onclick="logout()"><i class="iconfont icon-username" style="font-size:1em;"></i><?php echo $_SESSION['username'];?></a></div>
        <div id="timebar"><h1 style="font-size:3em;" id="time">00:00</h1></div>
        <div id="apps">
            <a href="settings.php" class="round_button"><i class="iconfont icon-mzicon-setting" style="font-size:1em;"></i>设置</a>
            <a href="quest.php" class="round_button"><i class="iconfont icon-keys" style="font-size:1em;"></i>授权申请</a>
            <a href="reset.php" class="round_button"><i class="iconfont icon-zhongzhi" style="font-size:1em;"></i>重置密码</a>
        </div>
        <div style="color:white;" class="copyright"><p>&nbsp;版权所有&copy; 2014-2020.TS Studio 保留所有权利 吉ICP备17003700号</p></div>
    </body>
    <script src="js/time.js"></script>
</html>