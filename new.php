<?php
session_start();
if(!isset($_SESSION["fdun"])){
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
if(empty($_POST["name"])){
    die("ERR:Invalid name");
}
//上面是上传部分
//文件转base64
$ph=base64_encode(file_get_contents($_FILES["file"]["tmp_name"]));
//生成一个faceid
$faceid=time().mt_rand(1000,9999);


//调用SDK
include 'apikey.php';
require_once 'aip-php-sdk-2.2.16/AipFace.php';

$client = new AipFace(18542829, $apiKey, $secretKey);

$imageType = "BASE64";

// 调用人脸检测
$client->detect($ph, $imageType);

// 如果有可选参数
$options = array();
$options["face_field"] = "age";
$options["max_face_num"] = 2;
$options["face_type"] = "LIVE";
$options["liveness_control"] = "LOW";

$response=$client->addUser($ph, $imageType, "c", $faceid, $options);
//echo "<pre>";
//var_dump($response);
//echo "</pre>";
include "server-info.php";
include "log.php";
$logger=new logger($dbhost, $dbuser, $dbpawd, $dbname);
if($response["error_code"]!=0){
    echo "ERR:".$response["error_msg"];
    $logger->log("err",$response["error_msg"]);
    die();
}
$facetoken=$response["result"]["face_token"];
//连接数据库
//新建用户

$db=new mysqli($dbhost, $dbuser, $dbpawd, $dbname);
$sql = 'INSERT INTO `face` (cname,faceid,face_token) values ("'.$_POST["name"].'","'.$faceid.'","'.$facetoken.'");';
if(!$db->query($sql)){die(mysqli_error($db));}
echo "人脸id:".$faceid;
echo "<br>已成功录入<br>";
echo '<img src="data:image/png;base64,'.$ph.'"/>';
$logger->log("info","[".$_SESSION["fdun"]."]".$_POST["cname"]."reged");
$db->close();
//会输出上面那两个信息和一个图片，在下面写html，把元素填进去就ok
?>