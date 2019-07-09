<?php
session_start();
require("../inc/function.php");
require("../theme1/theme.php");
define("THEME","../theme1/",true);
$db_conn = new core_mysql ();
if (isset($_POST["save"])){
	$id=$_POST["id"];
	$empid=$_POST["empid"];
	$technicid=$_POST["technicid"];
	$technicdate=be2bc($_POST["technicdate"]);
	if($_POST["chk"]=="a"){
		$sql="INSERT INTO `tbemptechnic` ( `empid` , `technicid` , `technicdate` ) VALUES ('$empid', '$technicid', '$technicdate')";
	}else{
		$sql="UPDATE `tbemptechnic` SET `technicid` = '$technicid',`technicdate` = '$technicdate' WHERE `id` = '$id' LIMIT 1";
	}
	$result = $db_conn->query ($sql);
	msgBox("บันทึกข้อมูลเรียบร้อย","technic.php?empid=$empid");
}
$empid=$_GET["empid"];
if($_GET["chk"]=="e"){
	$sql="SELECT * FROM tbemptechnic WHERE `id` = '".$_GET["id"]."' LIMIT 1";
	$result = $db_conn->query ($sql);
	$row=mysql_fetch_array($result);
	$empid=$row["empid"];
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<title>บันทึกข้อมูลตำแหน่งทางวิชาการ</title>
<script type="text/javascript" src="../inc/jquery.js"></script>
<script type="text/javascript" src="../inc/jquery.maskedinput.js"></script>
<script type="text/javascript" src="../calendar/calendar.js"></script>
<script type="text/javascript" src="../calendar/calendar-setup.js"></script>
<script type="text/javascript" src="../calendar/calendar-th.js"></script>
<style type="text/css"> @import url("../calendar/calendar-blue.css"); </style>
<style>
	body {font: 12px Tahoma}
	table {font: 12px Tahoma}
	.SOME5Big {font-family :Tahoma, Verdana, Arial; font-size :16px; color :#FF8000; font-weight :bold; text-decoration: none}
</style>
<script language="javascript">
jQuery(function($){
   $("#technicdate").mask("99/99/9999");
})
</script>
</head>

<body>
<form name="form1" method="post">
<input name="id" type="hidden" value="<?=$row["id"]?>">
<input name="empid" type="hidden" value="<?=$empid?>">
<input name="chk" type="hidden" value="<?=$_GET["chk"]?>">
<? openframe2("บันทึกข้อมูลตำแหน่งทางวิชาการ");?>
<table width="100%">
  <tr bgcolor="#FFFFFF">
    <td align="right">ตำแหน่งทางวิชาการ</td>
    <td align="center">:</td>
    <td><? createlist("technicid,technicname","mttechnic","",$row["technicid"],"technicid","")?></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">ดำรงตำแหน่ง</td>
    <td align="center">:</td>
    <td>
		<input name="technicdate" type="text" id="technicdate" value="<?=bc2be($row["technicdate"],false)?>" size="10">
		<img src="../image/calendar.jpg" alt="เลือกวันที่" id="cmdtechnicdate" style="cursor:hand">	</td>
  </tr>
  
  <tr bgcolor="#FFFFFF">
    <td colspan="3" align="center">
		<br>
	  	<button type="submit" name="save"><img src="../image/upload-page-blue.gif">&nbsp;บันทึก</button>
	  	<button onClick="location='technic.php?empid=<?=$empid?>'"><img src="../image/left-blue.gif">&nbsp;กลับรายการ</button>	</td>
  </tr>
</table>
<? closeframe2();?>
</form>
</body>
</html>
<script type="text/javascript">
		Calendar.setup({ inputField:"technicdate",displayArea:"desktop",button:"cmdtechnicdate"});
</script>
