<?php
session_start();
require("../inc/function.php");
$empid=$_GET["empid"];
$fieldpic=$_GET["fieldname"]."pic";
$fieldpro=$_GET["fieldname"]."pro";
$sql="select $fieldpic,$fieldpro from tbemployee where empid='$empid' LIMIT 1";
$db_conn = new core_mysql ();
$result = $db_conn->query ($sql);
$row = mysql_fetch_array($result);
$property=explode(":",$row[1]);
header("Content-Disposition: attachment; filename=".$property[0]);
header("Content-length: ".$property[1]);
header("Content-type: ".$property[2]);
header("Content-Description: PHP Generated Data");
echo $row[0];
?>