<?php session_start();
if ($_SESSION['username']==""){
    echo "You are not logging in,jumping to the log-in page.";
    header('Refresh:0;url=loginform.php?URL=settings.php&code=105');
    die();
}
include './include/load.php';
include './include/server-info.php';
$lang=$_SESSION['language'];
include './include/'.$lang.'.php';
if ($lang=="zh_CN"){
    $zhcn='selected';
    $enus='';
}else if ($lang=="en_US"){
    $enus='selected';
    $zhcn='';
}
$ipv6=strpos($_SERVER["HTTP_X_FORWARDED_FOR"],":")?"IPV6":"IPV4";
 ?>
<html>
    <head>
        <link href="css/style.css" rel="stylesheet">
        <link href="css/all.css" rel="stylesheet">
        
        <title><?=$htit?></title>
    </head>
    <body id="body" class="lazy">
        <div id="load">
            <i class="fa fa-spinner fa-pulse fa-5x" style="position:absolute;left:50%;top:50%;transform:translate(-50%,-50%);"></i>
        </div>
        <div id="Main" style="display:none;">
                <h2><?=$setn?></h2>
                <i class="iconfont icon-username"></i><?php echo $_SESSION['username']; ?><br>
                <a href="index.php" class="button button-primary"><i class="iconfont icon-i-back"></i><?=$back?></a><br>
                <h3>安全/Security</h3>
                    Your Email:<?=$_SESSION['email']?>
                    <?php
                        if($_SESSION['isEmailConfirmed']){
                            echo '<font style="background-color:#33EE33;color:#222222;">已验证/Confirmed</font>';
                        }else{
                            echo '<font style="background-color:#EE3333;color:#222222;">未验证/Not Confirmed</font>';
                        }
                    ?>
                    <a href="reemail.php" class="button button-royal">更改/Update</a><br>
                <h3>服务器负载/Server Load</h3>
                    <!--构造框架-->
                    负载指数：
                    <div class="loadp <?=$clr?>" title="<?=$loaddetail?>">
                    <center><?=$load?></center>
                    </div>
                <h4>网络/Network</h4>
                    <div><?=$ipv6?>(<?=$_SERVER["HTTP_X_FORWARDED_FOR"]?>)</div>
                <h5>TSS Website - ACCOUNT SYSTEM VERSION 19A1</h5>
        </div>
        <div style="color:white;" class="copyright"><p>&nbsp;&nbsp;&nbsp;<?=$copyright?>&copy; 2014-<?php
echo date('Y'); ?>.TS Studio <?=$alrr?> 吉ICP备17003700号</p></div>
    </body>
    <script src="./css/bgi.js"></script>
</html>