<?php
session_start();
error_reporting(E_ALL || ~E_NOTICE);
$url='Refresh:0;url='.$_GET['URL'];
unset($_SESSION['username']);
header($url);
?>