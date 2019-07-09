<?php
session_start();
require("../inc/function.php");
$sql="select * from tbempgoverment where empid='".$_GET["empid"]."' order by govdate";
$db_conn = new core_mysql ();
$result = $db_conn->query ($sql);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<title>ข้อมูลการรับราชการ</title>
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
<table border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC" width="100%">
  <tr style="background-color:#FFFFCC; color:#006666; font-weight:bold" height="25">
    <td align="center">วันที่</td>
    <td align="center">ตำแหน่ง</td>
    <td align="center">ระดับ</td>
    <td align="center">ขั้นเงินเดือน</td>
    <td align="center">จำนวนขั้นที่เลือน</td>
    <td align="center">กรม/กระทรวง</td>
    <td align="center">หมายเหตุ</td>
  </tr>
<?
	while($row = mysql_fetch_array($result)){
		$doc=explode(":",$row["govdocpro"]);
		$bgcolor=$bgcolor=="#E9E9E9"?"#FFFFFF":"#E9E9E9";
?>
  <tr bgcolor="<?=$bgcolor?>">
    <td align="center"><?=bc2be($row["govdate"],false)?></td>
    <td><?=$row["govposition"]?></td>
    <td align="center"><?=$row["govlevel"]<=0?"":$row["govlevel"]?></td>
    <td align="center"><?=$row["govstep"]<=0?"":number_format($row["govstep"])?></td>
    <td align="center"><?=$row["govamount"]<=0?"":$row["govamount"]?></td>
    <td><?=$row["govunit"]?></td>
    <td><?=$row["govdetail"]?></td>
  </tr>
<?}?>
</table>
</body>
</html>