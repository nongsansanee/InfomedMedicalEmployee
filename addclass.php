<?php
session_start();
require("../inc/function.php");
require("../theme1/theme.php");
define("THEME","../theme1/",true);
$db_conn = new core_mysql ();
if (isset($_POST["save"])){
	$id=$_POST["id"];
	$empid=$_POST["empid"];
	$classdate=be2bc($_POST["classdate"]);
	$classposition=$_POST["classposition"];
	$classlevel=$_POST["classlevel"];
	$classstep=$_POST["classstep"];
	$classname=$_POST["classname"];
	$classsname=$_POST["classsname"];
	$classget=be2bc($_POST["classget"]);
	$classreturn=be2bc($_POST["classreturn"]);
	$classremark=$_POST["classremark"];
	$datein=date("Y-m-d H:i:s");
	$userin=$myauth["userin"];
	if($_POST["chk"]=="a"){
		$sql="INSERT INTO `tbempclass` ( `empid` , `classdate` , `classposition` , `classlevel` , `classstep` , `classname` , `classsname` , `classget` , `classreturn` , `classremark` , `datein` , `userin` ) VALUES ('$empid', '$classdate', '$classposition', '$classlevel', '$classstep', '$classname', '$classsname', '$classget', '$classreturn', '$classremark', '$datein', '$userin')";
	}else{
		$sql="UPDATE `tbempclass` SET `empid` = '$empid',`classdate` = '$classdate',`classposition` = '$classposition',`classlevel` = '$classlevel',`classstep` = '$classstep',`classname` = '$classname',`classsname` = '$classsname',`classget` = '$classget',`classreturn` = '$classreturn',`classremark` = '$classremark',`datein` = '$datein',`userin` = '$userin' WHERE `id` = '$id' LIMIT 1";
	}
	$result = $db_conn->query ($sql);
	msgBox("บันทึกข้อมูลเรียบร้อย","class.php?empid=$empid");
}
$empid=$_GET["empid"];
if($_GET["chk"]=="e"){
	$sql="SELECT * FROM tbempclass WHERE `id` = '".$_GET["id"]."' LIMIT 1";
	$result = $db_conn->query ($sql);
	$row=mysql_fetch_array($result);
	$empid=$row["empid"];
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<title>บันทึกข้อมูลการรับเครื่องราชอิสริยาภรณ์</title>
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
   $("#classdate").mask("99/99/9999");
   $("#classget").mask("99/99/9999");
   $("#classreturn").mask("99/99/9999");
})

function xNum2(obj,key){
	ret=false;
	if( (key>=48 && key<=57) || key==46 ){
		ret=true;
	}
	return ret;
}
</script>
</head>

<body>
<form name="form1" method="post">
<input name="id" type="hidden" value="<?=$row["id"]?>">
<input name="empid" type="hidden" value="<?=$empid?>">
<input name="chk" type="hidden" value="<?=$_GET["chk"]?>">
<? openframe2("บันทึกข้อมูลการรับเครื่องราชอิสริยาภรณ์");?>
<table width="100%">
  <tr bgcolor="#FFFFFF">
    <td align="right">วันที่</td>
    <td align="center">:</td>
    <td>
		<input name="classdate" type="text" id="classdate" value="<?=bc2be($row["classdate"],false)?>" size="10">
		<img src="../image/calendar.jpg" alt="เลือกวันที่" id="cmdclassdate" style="cursor:hand">	</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">เครื่องราชอิสริยาภรณ์</td>
    <td align="center">:</td>
    <td><input name="classname" type="text" value="<?=$row["classname"]?>" size="60" ></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">เครื่องราชอิสริยาภรณ์ (ย่อ) </td>
    <td align="center">:</td>
    <td><input name="classsname" type="text" value="<?=$row["classsname"]?>" size="30" ></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">ตำแหน่ง</td>
    <td align="center">:</td>
    <td><input name="classposition" type="text" value="<?=$row["classposition"]?>" size="60" ></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">ระดับ</td>
    <td align="center">:</td>
    <td><input name="classlevel" type="text"  onKeyPress="return  xNum2(this,window.event.keyCode)" value="<?=$row["classlevel"]?>" size="5"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">ขั้นเงินเดือน</td>
    <td align="center">:</td>
    <td><input name="classstep" type="text"  onKeyPress="return  xNum2(this,window.event.keyCode)" value="<?=$row["classstep"]?>" size="5"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">วันที่ได้รับ</td>
    <td align="center">:</td>
    <td>
		<input name="classget" type="text" id="classget" value="<?=bc2be($row["classget"],false)?>" size="10">
      	<img src="../image/calendar.jpg" alt="เลือกวันที่" id="cmdclassget" style="cursor:hand">	</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">วันที่คืน</td>
    <td align="center">:</td>
    <td>
		<input name="classreturn" type="text" id="classreturn" value="<?=bc2be($row["classreturn"],false)?>" size="10">
      	<img src="../image/calendar.jpg" alt="เลือกวันที่" id="cmdclassreturn" style="cursor:hand">	</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">หมายเหตุ</td>
    <td align="center">:</td>
    <td><textarea name="classremark" cols="60" rows="2"><?=$row["classremark"]?></textarea></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td colspan="3" align="center">
		<br>
	  	<button type="submit" name="save"><img src="../image/upload-page-blue.gif">&nbsp;บันทึก</button>
	  	<button onClick="location='class.php?empid=<?=$empid?>'"><img src="../image/left-blue.gif">&nbsp;กลับรายการ</button>	</td>
  </tr>
</table>
<? closeframe2();?>
</form>
</body>
</html>
<script type="text/javascript">
		Calendar.setup({ inputField:"classdate",displayArea:"desktop",button:"cmdclassdate"});
		Calendar.setup({ inputField:"classget",displayArea:"desktop",button:"cmdclassget"});
		Calendar.setup({ inputField:"classreturn",displayArea:"desktop",button:"cmdclassreturn"});
</script>
