<?php
session_start();
require("../inc/function.php");
$db_conn = new core_mysql ();
if($_GET["chk"]=='d'){
	$sql="DELETE FROM `tbempclass` WHERE `id`='".$_GET["id"]."' LIMIT 1";
	$result = $db_conn->query ($sql);
}
$sql="select * from tbempclass where empid='".$_GET["empid"]."' order by classdate";
$result = $db_conn->query ($sql);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<script type="text/javascript" src="../inc/statushide.js"></script>
<title>ข้อมูลการรับเครื่องราชอิสริยาภรณ์</title>
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
		var agree = confirm("ยืนยันการยกเลิกข้อมูลการรับเครื่องราชอิสริยาภรณ์นี้.   ");
		return agree;
	} 
</script>
</head>

<body>
<table border="0" cellspacing="1" bgcolor="#CCCCCC" width="100%">
  <tr style="background-color:#FFFFCC; color:#006666; font-weight:bold" height="25">
    <td align="center">วันที่</td>
    <td align="center">เครื่องราชอิสริยาภรณ์</td>
    <td align="center">เครื่องราชอิสริยาภรณ์ (ย่อ) </td>
    <td align="center">ตำแหน่ง</td>
    <td align="center">ระดับ</td>
    <td align="center">ขั้นเงินเดือน</td>
    <td align="center">วันที่ได้รับ</td>
    <td align="center">วันที่คืน</td>
    <td width="120" align="center">#</td>
  </tr>
<?
	while($row = mysql_fetch_array($result)){
		$bgcolor=$bgcolor=="#E9E9E9"?"#FFFFFF":"#E9E9E9";
?>
  <tr bgcolor="<?=$bgcolor?>">
    <td align="center"><?=bc2be($row["classdate"],false)?></td>
    <td><?=$row["classname"]?></td>
    <td><?=$row["classsname"]?></td>
    <td><?=$row["classposition"]?></td>
    <td align="center"><?=$row["classlevel"]<=0?"":$row["classlevel"]?></td>
    <td align="center"><?=$row["classstep"]<=0?"":$row["classstep"]?></td>
    <td align="center"><?=bc2be($row["classget"],false)?></td>
    <td align="center"><?=bc2be($row["classreturn"],false)?></td>
    <td align="center">
    <a href="addclass.php?chk=e&id=<?=$row["id"]?>"><img src="../image/edit.gif" border="0">แก้ไข</a>
	<a href="class.php?chk=d&empid=<?=$row["empid"]?>&id=<?=$row["id"]?>" onClick="return confirmbox();"><img src="../image/del.gif"  border="0">ยกเลิก</a>    </td>
  </tr>
<?}?>
  <tr bgcolor="#FFFFFF">
    <td colspan="9"><button onClick="location='addclass.php?chk=a&empid=<?=$empid?>'"><img src="../image/add-page-green.gif">&nbsp;เพิ่มข้อมูล</button></td>
  </tr>
</table>
</body>
</html>