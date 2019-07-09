<?php
session_start();
require("../inc/function.php");
$db_conn = new core_mysql ();
if($_GET["chk"]=="d"){
	$sql="DELETE FROM `tbemptrain` WHERE `id`='".$_GET["id"]."' LIMIT 1";
	$result = $db_conn->query ($sql);
}
$sql="select * from tbemptrain where empid='".$_GET["empid"]."' order by id";
$result = $db_conn->query ($sql);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<script type="text/javascript" src="../inc/statushide.js"></script>
<title>ข้อมูลการลาศึกษา/ฝึกอบรม</title>
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
		var agree = confirm("ยืนยันการยกเลิกข้อมูลการลาศึกษา/ฝึกอบรมนี้.   ");
		return agree;
	} 
</script>
</head>

<body>
<table border="0" cellspacing="1" bgcolor="#CCCCCC" width="100%">
  <tr style="background-color:#FFFFCC; color:#006666; font-weight:bold" height="25">
    <td align="center">ประเภทการลา</td>
    <td align="center">หลักสูตร</td>
    <td align="center">ระยะเวลา</td>
    <td align="center">สถานศึกษา</td>
    <td align="center">ประเทศ</td>
    <td align="center">ทุน</td>
    <td width="120" align="center">เอกสารแนบ</td>
    <td width="120" align="center">#</td>
  </tr>
<?
	while($row = mysql_fetch_array($result)){
		$doc=explode(":",$row["traindocpro"]);
		$ntype=array("ลาศึกษาต่อต่างประเทศ","ลาศึกษาต่อในประเทศ","ลาฝึกอบรมต่างประเทศ","ลาฝึกอบรมในประเทศ");
		$bgcolor=$bgcolor=="#E9E9E9"?"#FFFFFF":"#E9E9E9";
?>
  <tr bgcolor="<?=$bgcolor?>">
    <td><?=$ntype[$row["traintype"]-1]?></td>
    <td><?=$row["traincourse"]?></td>
    <td align="center"><?=bc2be($row["trainstart"],false)."  ถึง  ".bc2be($row["trainend"],false)?></td>
    <td><?=$row["trainplace"]?></td>
    <td><?=$row["traincountry"]?></td>
    <td><?=$row["traincapital"]?></td>
    <td align="center"><?php if(!empty($row["trainfile"])) echo " <a href='".$row["trainfile"]."' target='_blank'>เอกสารแนบ</a>"?></td>
    <td align="center">
	<a href="addtrain.php?chk=e&id=<?=$row["id"]?>"><img src="../image/edit.gif" border="0">แก้ไข</a>
	<a href="train.php?chk=d&empid=<?=$row["empid"]?>&id=<?=$row["id"]?>" onClick="return confirmbox();"><img src="../image/del.gif"  border="0">ยกเลิก</a>	</td>
  </tr>
<?}?>
  <tr bgcolor="#FFFFFF">
    <td colspan="8"><button onClick="location='addtrain.php?chk=a&empid=<?=$empid?>'"><img src="../image/add-page-green.gif">&nbsp;เพิ่มข้อมูล</button></td>
  </tr>
</table>
</body>
</html>