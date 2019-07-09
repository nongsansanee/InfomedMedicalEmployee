<?php
session_start();
require("../inc/function.php");
$sql="select emppicture from tbemployee where empid='".$_GET["empid"]."' LIMIT 1";
$db_conn = new core_mysql ();
$result = $db_conn->query ($sql);
$row = mysql_fetch_array($result);
header("Content-type:image/pjpeg");
echo $row[0];
?>