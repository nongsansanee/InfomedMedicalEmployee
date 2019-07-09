<?php
session_start();
require("../inc/function.php");
$db_conn = new core_mysql ();

$arredulevel=array("","มัธยมต้น","มัธยมปลาย","ปวช","ปวส","ป.ตรี","ป.โท ","ป.เอก / เทียบเท่า");


if($_GET["chk"]=="d"){
	$sql="DELETE FROM `tbempeducation` WHERE `id`='".$_GET["id"]."' LIMIT 1";
	$result = $db_conn->query ($sql);
}
$sql="select * from tbempeducation where empid='".$_GET["empid"]."' order by eduyear desc";
$result = $db_conn->query ($sql);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<script type="text/javascript" src="../inc/statushide.js"></script>
<title>ข้อมูลประวัติการศึกษา</title>
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
		var agree = confirm("ยืนยันการยกเลิกข้อมูลประวัติการศึกษานี้.   ");
		return agree;
	} 
</script>
</head>

<body>
 <table border="0" cellspacing="1" bgcolor="#CCCCCC" width="100%">
  <tr style="background-color:#FFFFCC; color:#006666; font-weight:bold" height="25">
  <td align="center">ระดับการศึกษา</td>
    <td align="center">วุฒิการศึกษา</td>
	 
    <td align="center">วุฒิการศึกษา(ย่อ)</td>
    <td align="center">สถานศึกษา</td>
    <td align="center">ประเทศ</td>
    <td align="center">ปีที่จบการศึกษา</td>
    <td align="center">รุ่นที่</td>
    <td align="center">เอกสารแนบ</td>
    <td width="120" align="center">#</td>
  </tr>
<?
	while($row = mysql_fetch_array($result)){
		$doc=explode(":",$row["edudocpro"]);
		$bgcolor=$bgcolor=="#E9E9E9"?"#FFFFFF":"#E9E9E9";
?>

  <tr bgcolor="<?=$bgcolor?>">
     <td><?=$arredulevel[$row["edulevel"]]?></td>
    <td><?=$row["education"]?></td>
	<td><?=$row["seducation"]?></td>
	<td><?=$row["eduplace"]?></td>
	<td align="center"><?=$row["educountry"]?></td>
	<td align="center"><?=$row["eduyear"]?></td>
	<td align="center"><?=$row["eduversion"]?></td>
	<td align="center"><?php if(!empty($row["edufile"])) echo " <a href='".$row["edufile"]."' target='_blank'>เอกสารแนบ</a>"?></td>
	<td align="center">
	<a href="addedu.php?chk=e&id=<?=$row["id"]?>"><img src="../image/edit.gif" border="0">แก้ไข</a>
	<a href="education.php?chk=d&empid=<?=$row["empid"]?>&id=<?=$row["id"]?>" onClick="return confirmbox();"><img src="../image/del.gif"  border="0">ยกเลิก</a>    </td>
  </tr>
<?	}?>
  <tr bgcolor="#FFFFFF">
    <td colspan="8"><button onClick="location='addedu.php?chk=a&empid=<?=$empid?>'"><img src="../image/add-page-green.gif">&nbsp;เพิ่มข้อมูล</button><button onClick="location='printeducation.php?empid=<?=$_GET["empid"]?>'"><img src="../image/printer-blue.gif">&nbsp;พิมพ์ </button></td>
  </tr>
</table>
</body>
</html>