<?php
header("content-type: application/json;charset: utf-8");
session_start();
$output=array();
if(isset($_SESSION["isLogged"])){
    $output["isLogged"]=true;
    $output["userName"]=$_SESSION["fdun"];
}else{
    $output["isLogged"]=false;
    $output["userName"]="";
}
print(json_encode($output));
?>