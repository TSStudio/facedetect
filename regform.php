<?php
error_reporting(E_ALL || ~E_NOTICE);
include './include/zh_CN.php';
include './include/server-info.php';
?>
<html>
<head>
<title><?=$regi?></title>
<link href="css/style.css" rel="stylesheet">
<link href="css/all.css" rel="stylesheet">
<script src="https://ssl.captcha.qq.com/TCaptcha.js"></script>
</head>
<body id="body">
    <div style="vertical-align: middle;" id="input-box">
        <form action="register.php?URL=<?php echo $_GET['URL'];?>" method="post" onsubmit="return check()" style="margin:auto;" class="reg info-input" id="input-form">
            <center><font style="font-size:3em;"><?=$regi?></font></center><br>
            <table style="margin:auto;">
            <center style="background-color:rgba(255,50,50,0.5);"><i class="iconfont icon-warning"></i><?php if ($_GET['code']=="100"){echo $erro.$e100;}else if($_GET['code']=="101"){echo $erro.$e101;}else if($_GET['code']=="102"){echo $erro.$e102;}else if($_GET['code']=="103"){echo $erro.$e103;}else if($_GET['code']=="104"){echo $erro.$e104;}else if($_GET['code']=="105"){echo $erro.$e105;}else if($_GET['code']=="106"){echo $erro.$e106;}else if($_GET['code']=="107"){echo $erro.$e107;}?></center><br>
            <tr><td><i class="iconfont icon-username"></i><?=$usnm?></td><td><input type="text" name="username" id="username" class="input-box"></td></tr>
            <tr><td><i class="iconfont icon-mailenvelopeletteremailnewsletter"></i><?=$emai?></td><td><input type="email" name="email" id="email" class="input-box"></td></tr>
            <tr><td><i class="iconfont icon-key"></i><?=$lapw?></td><td><input type="password" name="password" id="password" class="input-box"></td></tr>
            <tr><td><i class="iconfont icon-key"></i><?=$cnpw?></td><td><input type="password" name="assertpassword" id="assertpassword" class="input-box"></td></tr>
            <input type="text" style="display:none;" id="capti" name="ticket">
            <input type="text" style="display:none;" id="captr" name="randstr">
            <tr><td><?=$capt?></td>
            <td><button id="TencentCaptcha" type="button" class="button button-action" data-appid="<?=$captappid?>" data-cbfn="subm">验证</button>
            <div style="display:none;" id="CaptchaPass"><i style="font-size:2em;" class="iconfont icon-checkmarktickse"></i></div></td></tr>
            </table>
            <center>
            <?=$wycr?><a href="Policy.html" target="view_window"><?=$lise?></a><br>
            <input type="button" value="<?=$regi?>" class="button button-primary" id="subbutt"><br>
            <p><?=$haac?><a href="loginform.php?URL=<?php echo $_GET['URL']?>&code=<?php echo $_GET['code']?>"><?=$logi?></a></p>
            </center>
        </form> 
    </div>
    <script>
window.subm = function(res){
    console.log(res)
    if(res.ret === 0){
        yz=true;
        ticke=res.ticket;
        rands=res.randstr;
        captbutton=document.getElementById('TencentCaptcha');
        captdone=document.getElementById('CaptchaPass');
        captbutton.style.display="none";
        captdone.style.display="block";
    }
}

</script>
<script type="text/javascript">
    var form = document.getElementById('input-form');
    var go = document.getElementById('subbutt');
    go.onclick = function(){
        if(!yz){
            alert('请完成验证');
        }
        var cap = document.getElementById('capti');
        var car = document.getElementById('captr');
        cap.value=window.ticke;
        car.value=window.rands;
        form.submit();
    }
    document.onkeydown=function(event){ 
    var e = event || window.event || arguments.callee.caller.arguments[0]; 
        if(e && e.keyCode==13){ // 按 Enter 
            if(!yz){
                alert('请完成验证');
            }
            var cap = document.getElementById('capti');
            var car = document.getElementById('captr');
            cap.value=window.ticke;
            car.value=window.rands;
            form.submit();
        }
    };
function check() { 
    var username=document.getElementById("username").value; 
    var password=document.getElementById("password").value; 
    var assertpassword=document.getElementById("assertpassword").value;
    var email=document.getElementById("email").value;
    var regex=/^[/s]+$/; 
    var szReg=/^[A-Za-z0-9d]+([-_.][A-Za-z0-9d]+)*@([A-Za-z0-9d]+[-.])+[A-Za-zd]{2,5}$/;
    if(szReg.test(email)||email.length==0){
        alert("<?=$emnr?>");
        return false;
    }
    if(regex.test(username)||username.length==0){ 
        alert("<?=$lapw.$misw?>"); 
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
<div style="color:white;" class="copyright"><p>&nbsp;&nbsp;&nbsp;<?=$copyright?>&copy; 2014-<?php
echo date('Y'); ?>.TS Studio <?=$alrr?> 吉ICP备17003700号</p></div>
</body>
<script defer src="./css/bgi.js"></script>
</html>