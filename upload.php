<?php
//请到60行查看相关信息
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
if($response["error_code"]!=0){
    echo "ERR:".$response["error_msg"];
    die();
}
$uid=$response["result"]["user_list"][0]["user_id"];
$sco=$response["result"]["user_list"][0]["score"];
//连接数据库
//新建用户
include "server-info.php";
$db=new mysqli($dbhost, $dbuser, $dbpawd, $dbname);
$sql = 'SELECT cname from `face` where faceid="'.$uid.'";';
$res=$db->query($sql);
if(!$res){die(mysqli_error());}
$r=$res->fetch_array();
echo "人脸id:".$uid."<br>";
echo "录入时名称:".$r["cname"]."<br>";
echo "相似度:".$sco."%";
$db->close();
//会输出上面那三个信息，在下面写html，把三个信息填进去就ok
?>