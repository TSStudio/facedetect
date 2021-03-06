<?php
session_start();
if(!isset($_SESSION["fdun"])){
    header('Location:login.html');
    die("未登录");
}

header("Content-type: text/html; charset=utf-8");
if($_FILES["file"]["error"]>0){
    echo "ERR:".$_FILES["file"]["error"];
    die();
}
$ft=$_FILES["file"]["type"];
if($ft!="image/jpeg"&&$ft!="image/png"){
    echo "ERR:Wrong type!";
    die();
}
if(strpos(".php",$_FILES["file"]["name"])){
    echo "ERR:Invalid filename";
    die();
}
//上面是上传部分
//文件转base64
$ph=base64_encode(file_get_contents($_FILES["file"]["tmp_name"]));

//调用SDK
include 'apikey.php';
require_once 'aip-php-sdk-2.2.16/AipFace.php';

$client = new AipFace(18542829, $apiKey, $secretKey);

$imageType = "BASE64";


// 如果有可选参数
$options = array();
$options["max_face_num"] = 1;
$options["match_threshold"] = 70;
$options["quality_control"] = "NORMAL";
$options["liveness_control"] = "LOW";
$options["max_user_num"] = 3;

// 带参数调用人脸搜索
$response=$client->search($ph, $imageType, "c", $options);
//echo "<pre>";
//var_dump($response);
//echo "</pre>";
//连接数据库
//新建用户
include "server-info.php";
include "log.php";
$logger=new logger($dbhost, $dbuser, $dbpawd, $dbname);
if($response["error_code"]!=0){
    echo "ERR:".$response["error_msg"];
    $logger->log("err",$response["error_msg"]);
    die();
}
$uid=$response["result"]["user_list"][0]["user_id"];
$sco=$response["result"]["user_list"][0]["score"];
$db=new mysqli($dbhost, $dbuser, $dbpawd, $dbname);
$sql = 'SELECT cname from `face` where faceid="'.$uid.'";';
$res=$db->query($sql);
if(!$res){die(mysqli_error());}
$r=$res->fetch_array();
$logger->log("info","[".$_SESSION["fdun"]."]".$r["cname"]."searched");
$db->close();
?>
<!DOCTYPE HTML>
<html>
    <head>
    </head>
    <body>
        <h1>人脸搜索识别结果</h1>
            <div>
                当前登录用户：<a id="UN"></a>
                <a href="logout.php" class="link">登出</a>
            </div>
            <div>
                上传的图片：<?='<img src="data:image/png;base64,'.$ph.'" width="30%"/>'?><br>
                识别结果：录入时名称:<?=$r["cname"]?><br>
                相似度：<?=$sco?>%<br>
                人脸id：<?=$uid?>
            </div>
        <a href="uploadf.php">再识别一个</a><br>
        <a href="index.html">首页</a>
    </body>
    <script>var type="mainp";</script>
    <script src="js/check.js"></script>
</html>