<?php
session_start();
require("../inc/function.php");
require("../theme1/theme.php");
define("THEME","../theme1/",true);
$db_conn = new core_mysql ();
if (isset($_POST["save"])){
	$id=$_POST["id"];
	$empid=$_POST["empid"];
	$fileup = "govfile";
	$msg = "เอกสารแนบ";
	if (validate_file($err,$fileup,$msg)){
		$filename = basename($_FILES[$fileup]["name"]);
		list($name,$sname) = explode(".",$filename);
		$govfile = "../empdoc/gov$empid.$sname";
		if (move_uploaded_file($_FILES[$fileup]["tmp_name"], $govfile))
			echo "สามารถบันทึก".$msg."ได้";
		else{
			$govfile = "";
			echo "ไม่สามารถบันทึก".$msg."ได้";
		}
	}else{
		$govfile = "";
		echo "<font color='red'><b>เกิดข้อผิดพลาด</b><br>";
		echo $err."</font>";
	}
	$govdate=be2bc($_POST["govdate"]);
	$govposition=$_POST["govposition"];
	$govremark=$_POST["govremark"];
	$govlevel=$_POST["govlevel"];
	$govstep=$_POST["govstep"];
	$govamount=$_POST["govamount"];
	$govunit=$_POST["govunit"];
	$govdetail=$_POST["govdetail"];
	$datein=date("Y-m-d H:i:s");
	$userin=$myauth["userin"];
	if($_POST["chk"]=="a"){
		$sql="INSERT INTO `tbempgoverment` ( `empid` , `govdate` , `govposition` , `govremark` , `govlevel` , `govstep` , `govamount` , `govunit` , `govdetail` , `govfile` , `datein` , `userin` ) VALUES ('$empid', '$govdate', '$govposition', '$govremark', '$govlevel', '$govstep', '$govamount', '$govunit', '$govdetail', '$govfile', '$datein', '$userin')";
	}else{
		if(!empty($govfile)) $upfile="`govfile` = '$govfile',";
		$sql="UPDATE `tbempgoverment` SET `empid` = '$empid',`govdate` = '$govdate',`govposition` = '$govposition',`govremark` = '$govremark',`govlevel` = '$govlevel',`govstep` = '$govstep',`govamount` = '$govamount',`govunit` = '$govunit',`govdetail` = '$govdetail',$upfile`datein` = '$datein',`userin` = '$userin' WHERE `id` = '$id' LIMIT 1";
	}
	$result = $db_conn->query ($sql);
	msgBox("บันทึกข้อมูลเรียบร้อย","goverment.php?empid=$empid");
}
$empid=$_GET["empid"];
if($_GET["chk"]=="e"){
	$sql="SELECT * FROM tbempgoverment WHERE `id` = '".$_GET["id"]."' LIMIT 1";
	$result = $db_conn->query ($sql);
	$row=mysql_fetch_array($result);
	$empid=$row["empid"];
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<title>บันทึกข้อมูลรับราชการ</title>
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
   $("#govdate").mask("99/99/9999");
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
<form name="form1" method="post" enctype="multipart/form-data">
<input name="id" type="hidden" value="<?=$row["id"]?>">
<input name="empid" type="hidden" value="<?=$empid?>">
<input name="chk" type="hidden" value="<?=$_GET["chk"]?>">
<? openframe2("บันทึกข้อมูลรับราชการ");?>
<table width="100%">
  <tr bgcolor="#FFFFFF">
    <td align="right">วันที่</td>
    <td align="center">:</td>
    <td>
		<input name="govdate" type="text" id="govdate" value="<?=bc2be($row["govdate"],false)?>" size="10">
      	<img src="../image/calendar.jpg" alt="เลือกวันที่" id="cmdgovdate" style="cursor:hand">	</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">ตำแหน่ง</td>
    <td align="center">:</td>
    <td><input name="govposition" type="text" size="60"  value="<?=$row["govposition"]?>" ></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">หมายเหตุตำแหน่ง</td>
    <td align="center">:</td>
    <td><textarea name="govremark" cols="60" rows="2"><?=$row["govremark"]?></textarea></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">ระดับ</td>
    <td align="center">:</td>
    <td><input name="govlevel" type="text" size="5"  value="<?=$row["govlevel"]?>"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">ขั้นเงินเดือน</td>
    <td align="center">:</td>
    <td><input name="govstep" type="text" size="5"  value="<?=$row["govstep"]?>"  onKeyPress="return  xNum2(this,window.event.keyCode)"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">จำนวนขั้นที่เลื่อน</td>
    <td align="center">:</td>
    <td><input name="govamount" type="text" size="5"  value="<?=$row["govamount"]?>"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">กรม/กระทรวง</td>
    <td align="center">:</td>
    <td><input name="govunit" type="text" size="60"  value="<?=$row["govunit"]?>" ></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">หมายเหตุ</td>
    <td align="center">:</td>
    <td><textarea name="govdetail" cols="60" rows="2"><?=$row["govdetail"]?></textarea></td>
  </tr>
  <tr>
    <td align="right">เอกสารแนบ</td>
    <td align="center">:</td>
    <td><input name="govfile" type="file" size="40">
      <?php if(!empty($row["edufile"])) echo " <a href='".$row["edufile"]."' target='_blank'>เอกสารแนบ</a>"?></td>
  </tr>
  
  <tr bgcolor="#FFFFFF">
    <td colspan="3" align="center">
		<br>
	  	<button type="submit" name="save"><img src="../image/upload-page-blue.gif">&nbsp;บันทึก</button>
	  	<button onClick="location='goverment.php?empid=<?=$empid?>'"><img src="../image/left-blue.gif">&nbsp;กลับรายการ</button>	</td>
  </tr>
</table>
<? closeframe2();?>
</form>
</body>
</html>
<script type="text/javascript">
	Calendar.setup({ inputField:"govdate",displayArea:"desktop",button:"cmdgovdate"});
</script>
