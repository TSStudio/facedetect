<?php session_start();
error_reporting(E_ALL || ~E_NOTICE);
include './include/server-info.php';
$lang=$_SESSION['language'];
include './include/'.$lang.'.php';
if ($_SESSION['username']==""){
    echo "You are not logging in,jumping to the log-in page.";
    header('Refresh:0;url=loginform.php?URL=login.php&code=105');
    die();
}if($_SESSION["2Step"]){
    $_SESSION["2Step"]=null;
    header('Refresh:0;url=settings.php');
    die();
}
$sendbutton='<a href="#" onclick="chkandsend();">发送邮件</a>';
?>
<html>
    <head>
        <link href="css/style.css" rel="stylesheet">
        <link href="css/all.css" rel="stylesheet">
        <title>更改邮箱</title>
        <script>
        timeleft=0;
        ajax=new XMLHttpRequest();
        function timepass(){
            if(timeleft==0){
                secs.innerText="";
            }else{
                timeleft--;
                secs.innerText="倒计时:"+timeleft+"秒";
            }
        }
        setInterval("timepass();",1000);
        var szReg=/^[A-Za-zd]+([-_.][A-Za-zd]+)*@([A-Za-zd]+[-.])+[A-Za-zd]{2,5}$/;
        function timer(){
            timeleft=60;
        }
        function sendmail(){
            ajax.open("GET","apis/mailsend.php?type=old",false);
            ajax.send();
            res=ajax.responseText;
            alert(res);
        }
        function sendm(){
            if(szReg.test(email)||email.length==0){
                alert("邮箱非法");
                return false;
            }
            ajax.open("GET","apis/mailsend.php?type=new&EmailAddr="+inputb.value,false);
            ajax.send();
            res=ajax.responseText;
            alert(res);
        }
        function chkandsend(){
            if(timeleft>0){
                alert('请勿重复操作！');
            }else{
                sendmail();
                timer();
            }
        }
        function confirmnew(){
            if(timeleft>0){
                alert('请勿重复操作！');
            }else{
                sendm();
                timer();
            }
        }
        </script>
    </head>
    <body id="body" class="lazy">
        <div class="paybox"><!--Main-->
            <h1>更改邮箱/Update Email</h1>
            <h2>你需要进行的操作(当你中途退出登录，所有内容消失)</h2>
            1.验证现有邮箱 <?=$_SESSION["email"]?>
            <?php
            if(empty($_SESSION["email"])){
                echo "由于没有原邮箱，则无需验证!";
                $_SESSION["FirstStep"]=true;
            }else if(!$_SESSION["isEmailConfirmed"]){
                echo "由于原邮箱未验证，则无需验证!";
                $_SESSION["FirstStep"]=true;
            }else if(!$_SESSION["FirstStep"]){
                echo $sendbutton.'<font id="secleft"></font>';
                echo '<br>&nbsp;&nbsp;-未完成(如果你已经验证，请刷新后进行下一步)<br>';
                $_SESSION["FirstStep"]=false;
            }else{
                echo '<br>&nbsp;&nbsp;-已完成<br>';
            }
            ?>
            2.输入并验证新邮箱
            <?php
            if(!$_session["FirstStep"]){
                echo '<form><input type="email" name="name" id="ne" /><br><a href="#" onclick="confirmnew()">确定</a>';
                echo '<font id="secleft"></font>';
                echo '</form>';
            }
            ?>
        </div>
        <div style="color:white;" class="copyright"><p>&nbsp;&nbsp;&nbsp;<?=$copyright?>&copy; 2014-<?php echo date('Y'); ?>.TS Studio <?=$alrr?> 吉ICP备17003700号</p></div>
    </body>
    <script>
    secs=document.getElementById("secleft");
    inputb=document.getElementById("ne");
    </script>
    <script src="./css/bgi.js"></script>
</html>