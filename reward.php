<?php
session_start();
require("../inc/function.php");
$db_conn = new core_mysql ();
if($_GET["chk"]=='d'){
	$sql="DELETE FROM `tbempreward` WHERE `id`='".$_GET["id"]."' LIMIT 1";
	$result = $db_conn->query ($sql);
}
$sql="select * from tbempreward where empid='".$_GET["empid"]."' order by rewardyear";
$result = $db_conn->query ($sql);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<script type="text/javascript" src="../inc/statushide.js"></script>
<title>ข้อมูลประวัติเกียรติยศ</title>
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
		var agree = confirm("ยืนยันการยกเลิกข้อมูลประวัติเกียรติยศนี้.   ");
		return agree;
	} 
</script>
</head>

<body>
<table border="0" cellspacing="1" bgcolor="#CCCCCC" width="100%">
  <tr style="background-color:#FFFFCC; color:#006666; font-weight:bold" height="25">
    <td align="center">พ.ศ.</td>
    <td align="center">เกียรติยศ</td>
    <td align="center">หน่วยงานที่มอบรางวัล</td>
    <td align="center">ระดับ</td>
    <td width="120" align="center">#</td>
  </tr>
<?
	$alevel=array("1"=>"ระดับชาติ","2"=>"ระดับนานาชาติ");
	while($row = mysql_fetch_array($result)){
		$bgcolor=$bgcolor=="#E9E9E9"?"#FFFFFF":"#E9E9E9";
?>
  <tr bgcolor="<?=$bgcolor?>">
    <td align="center"><?=$row["rewardyear"]?></td>
    <td><?=$row["reward"]?></td>
    <td><?=$row["rewardunit"]?></td>
    <td><?=$alevel[$row["rewardlevel"]]?></td>
    <td align="center">
	<a href="addreward.php?chk=e&id=<?=$row["id"]?>"><img src="../image/edit.gif" border="0">แก้ไข</a>
	<a href="reward.php?chk=d&empid=<?=$row["empid"]?>&id=<?=$row["id"]?>" onClick="return confirmbox();"><img src="../image/del.gif"  border="0">ยกเลิก</a>
	</td>
  </tr>
<?}?>
  <tr bgcolor="#FFFFFF">
    <td colspan="8"><button onClick="location='addreward.php?chk=a&empid=<?=$empid?>'"><img src="../image/add-page-green.gif">&nbsp;เพิ่มข้อมูล</button></td>
  </tr>
</table>
</body>
</html>