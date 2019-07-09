<?php
session_start();
require("../inc/function.php");
$db_conn = new core_mysql ();
if($_GET["chk"]=='d'){
	$sql="DELETE FROM `tbempgoverment` WHERE `id`='".$_GET["id"]."' LIMIT 1";
	$result = $db_conn->query ($sql);
}
$sql="select * from tbempgoverment where empid='".$_GET["empid"]."' order by govdate";
$result = $db_conn->query ($sql);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<script type="text/javascript" src="../inc/statushide.js"></script>
<title>ข้อมูลการรับราชการ</title>
<style>
	a:link {font-family: "MS SanSerif"; text-decoration: none; color: #000099}
	a:visited {font-family: "MS SanSerif"; text-decoration: none; color: #000099}
	a:hover {font-family: "MS SanSerif"; text-decoration: none; color: #000099}
	a:active {	font-family: "MS SanSerif"; text-decoration: none; color: #000099}
	body {font: 12px Tahoma}
	table {font: 12px Tahoma}
</style>
<script language="JavaScript">
	function confirmbox(){
		var agree = confirm("ยืนยันการยกเลิกข้อมูลการรับราชการนี้.   ");
		return agree;
	} 
</script>
</head>

<body>
<table border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC" width="100%">
  <tr style="background-color:#FFFFCC; color:#006666; font-weight:bold" height="25">
    <td align="center">วันที่</td>
    <td align="center">ตำแหน่ง</td>
	 <td align="center">หมายเหตุตำแหน่ง</td>
    <!--<td align="center">ระดับ</td>
    <td align="center">ขั้นเงินเดือน</td>
    <td align="center">จำนวนขั้นที่เลือน</td>-->
    <td align="center">กรม/กระทรวง</td>
    <td width="120" align="center">หมายเหตุ</td>
    <td width="120" align="center">#</td>
  </tr>
<?
	while($row = mysql_fetch_array($result)){
		$doc=explode(":",$row["govdocpro"]);
		$bgcolor=$bgcolor=="#E9E9E9"?"#FFFFFF":"#E9E9E9";
?>
  <tr bgcolor="<?=$bgcolor?>">
    <td align="center"><?=bc2be($row["govdate"],false)?></td>
    <td><?=$row["govposition"]?></td>
	 <td><?=$row["govremark"]?></td>
  <!--  <td align="center"><?=$row["govlevel"]<=0?"":$row["govlevel"]?></td>
    <td align="center"><?=$row["govstep"]<=0?"":number_format($row["govstep"])?></td>
    <td align="center"><?=$row["govamount"]<=0?"":$row["govamount"]?></td>-->
    <td><?=$row["govunit"]?></td>
    <td><?=$row["govdetail"]?></td>
    <td align="center">
	<a href="addgov.php?chk=e&id=<?=$row["id"]?>"><img src="../image/edit.gif" border="0">แก้ไข</a>
	<a href="goverment.php?chk=d&empid=<?=$row["empid"]?>&id=<?=$row["id"]?>" onClick="return confirmbox();"><img src="../image/del.gif"  border="0">ยกเลิก</a>	</td>
  </tr>
<?}?>
  <tr bgcolor="#FFFFFF">
    <td colspan="8"><button onClick="location='addgov.php?chk=a&empid=<?=$empid?>'"><img src="../image/add-page-green.gif">&nbsp;เพิ่มข้อมูล</button></td>
  </tr>
</table>
</body>
</html>