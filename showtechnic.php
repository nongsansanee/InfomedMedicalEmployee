<?php
session_start();
require("../inc/function.php");
$sql="select a.technicid,b.technicname,a.technicdate from tbemptechnic a left join mttechnic b on a.technicid=b.technicid where a.empid='".$_GET["empid"]."' order by a.technicdate desc";
$db_conn = new core_mysql ();
$result = $db_conn->query ($sql);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<title>ข้อมูลตำแหน่งทางวิชาการ</title>
<style>
	a:link {font-family: "MS SanSerif"; text-decoration: none; color: #000099}
	a:visited {font-family: "MS SanSerif"; text-decoration: none; color: #000099}
	a:hover {font-family: "MS SanSerif"; text-decoration: none; color: #000099}
	a:active {	font-family: "MS SanSerif"; text-decoration: none; color: #000099}
	body {font: 12px Tahoma}
	table {font: 12px Tahoma}
</style>
</head>

<body>
<table border="0" cellspacing="1" bgcolor="#CCCCCC" width="100%">
  <tr style="background-color:#FFFFCC; color:#006666; font-weight:bold" height="25">
    <td align="center">ตำแหน่งทางวิชาการ</td>
    <td align="center">ดำรงตำแหน่งเมื่อ</td>
  </tr>
<?
	while($row = mysql_fetch_array($result)){
		$bgcolor=$bgcolor=="#E9E9E9"?"#FFFFFF":"#E9E9E9";
?>
  <tr bgcolor="<?=$bgcolor?>">
    <td><?=$row[1]?></td>
    <td align="center"><?=bc2be($row[2],false)?></td>
  </tr>
<?}?>
</table>
</body>
</html>