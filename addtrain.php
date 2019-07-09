<?php
session_start();
require("../inc/function.php");
require("../theme1/theme.php");
define("THEME","../theme1/",true);
$db_conn = new core_mysql ();
if (isset($_POST["save"])){
	$id=$_POST["id"];
	$empid=$_POST["empid"];
	$traincourse=$_POST["traincourse"];
	$traintype=$_POST["traintype"];
	$trainstart=be2bc($_POST["trainstart"]);
	$trainend=be2bc($_POST["trainend"]);
	$trainplace=$_POST["trainplace"];
	$traincountry=$_POST["traincountry"];
	$traincapital=$_POST["traincapital"];
	$trainbudget=$_POST["trainbudget"];
	$trainremark=$_POST["trainremark"];
	$datein=date("Y-m-d H:i:s");
	$userin=$myauth["userin"];
	$sql="SELECT trainfile FROM tbemptrain WHERE empid='$empid' AND NOT (trainfile IS NULL OR trainfile='')";
	$result = $db_conn->query ($sql);
	$numrow=mysql_num_rows($result);
	$run=$numrow<=0?1:$numrow+1;
	if($_POST["chk"]=="a"){
		$fileup="trainfile";
		if (validate_file($err,$fileup)){
			$filename = basename($_FILES[$fileup]["name"]);
			list($name,$sname) = explode(".",$filename);
			$trainfile = "../empdoc/edu".$empid."_".$run.".".$sname;
			if (!move_uploaded_file($_FILES[$fileup]["tmp_name"], $trainfile))
				$trainfile = "";
		}else
			$trainfile = "";
		$sql="INSERT INTO `tbemptrain` ( `empid` , `traincourse` , `traintype` , `trainstart` , `trainend` , `trainplace` , `traincountry` , `traincapital` , `trainbudget` , `trainremark` , `trainfile` , `datein` , `userin` ) VALUES ('$empid', '$traincourse', '$traintype', '$trainstart', '$trainend', '$trainplace', '$traincountry', '$traincapital', '$trainbudget', '$trainremark', '$trainfile', '$datein', '$userin')";
	}else{
		$fileup="trainfile";
		if (validate_file($err,$fileup)){
			$filename = basename($_FILES[$fileup]["name"]);
			list($name,$sname) = explode(".",$filename);
			$trainfile = $_POST["uprun"]==""?"../empdoc/edu".$empid."_".$run.".".$sname:$_POST["uprun"];
			if (!move_uploaded_file($_FILES[$fileup]["tmp_name"], $trainfile))
				$trainfile = "";
		}else
			$trainfile = "";
		if(!empty($trainfile)) $upfile="`trainfile` = '$trainfile',";
		$sql="UPDATE `tbemptrain` SET `empid` = '$empid',`traincourse` = '$traincourse',`traintype` = '$traintype',`trainstart` = '$trainstart',`trainend` = '$trainend',`trainplace` = '$trainplace',`traincountry` = '$traincountry',`traincapital` = '$traincapital',`trainbudget` = '$trainbudget',`trainremark` = '$trainremark',$upfile`datein` = '$datein',`userin` = '$userin' WHERE `id` = '$id' LIMIT 1";
	}
	$result = $db_conn->query ($sql);
	msgBox("บันทึกข้อมูลเรียบร้อย","train.php?empid=$empid");
}
$empid=$_GET["empid"];
if($_GET["chk"]=="e"){
	$sql="SELECT * FROM tbemptrain WHERE `id` = '".$_GET["id"]."' LIMIT 1";
	$result = $db_conn->query ($sql);
	$row=mysql_fetch_array($result);
	$empid=$row["empid"];
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<title>บันทึกข้อมูลประวัติการศึกษา</title>
<style>
	body {font: 12px Tahoma}
	table {font: 12px Tahoma}
	.SOME5Big {font-family :Tahoma, Verdana, Arial; font-size :16px; color :#FF8000; font-weight :bold; text-decoration: none}
</style>
<script type="text/javascript" src="../inc/jquery.js"></script>
<script type="text/javascript" src="../inc/jquery.maskedinput.js"></script>
<script type="text/javascript" src="../calendar/calendar.js"></script>
<script type="text/javascript" src="../calendar/calendar-setup.js"></script>
<script type="text/javascript" src="../calendar/calendar-th.js"></script>
<style type="text/css"> @import url("../calendar/calendar-blue.css"); </style>
<script language="javascript">
jQuery(function($){
   $("#trainstart").mask("99/99/9999");
   $("#trainend").mask("99/99/9999");
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
<input name="uprun" type="hidden" value="<?=$row["trainfile"]?>">
<? openframe2("บันทึกข้อมูลการลาไปศึกษา/อบรม");?>
<table width="100%">
  <tr bgcolor="#FFFFFF">
    <td align="right">ประเภทการลา</td>
    <td align="center">:</td>
    <td><select name="traintype">
      <option></option>
      <option value="1" <? if($row["traintype"]=="1") echo "selected"?>>ลาศึกษาต่อต่างประเทศ</option>
      <option value="2" <? if($row["traintype"]=="2") echo "selected"?>>ลาศึกษาต่อในประเทศ</option>
      <option value="3" <? if($row["traintype"]=="3") echo "selected"?>>ลาฝึกอบรมต่างประเทศ</option>
      <option value="4" <? if($row["traintype"]=="4") echo "selected"?>>ลาฝึกอบรมในประเทศ</option>
    </select></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">หลักสูตร</td>
    <td align="center">:</td>
    <td><input name="traincourse" type="text" value="<?=$row["traincourse"]?>" size="60"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">ระยะเวลาตั้งแต่</td>
    <td align="center">:</td>
    <td>
	<input name="trainstart" type="text" id="trainstart" value="<?=bc2be($row["trainstart"],false)?>" size="10">
	<img src="../image/calendar.jpg" alt="เลือกวันที่" id="cmdtrainstart" style="cursor:hand">
	ถึง&nbsp;
	<input name="trainend" type="text" id="trainend" value="<?=bc2be($row["trainend"],false)?>" size="10">
	<img src="../image/calendar.jpg" alt="เลือกวันที่" id="cmdtrainend" style="cursor:hand">	</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">สถานศึกษา</td>
    <td align="center">:</td>
    <td><input name="trainplace" type="text" value="<?=$row["trainplace"]?>" size="60"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">ประเทศ</td>
    <td align="center">:</td>
    <td><input name="traincountry" type="text" value="<?=$row["traincountry"]?>" size="60"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">ทุน</td>
    <td align="center">:</td>
    <td><input name="traincapital" type="text" value="<?=$row["traincapital"]?>" size="60"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">งบประมาณ</td>
    <td align="center">:</td>
    <td><input name="trainbudget" type="text" onKeyPress="return  xNum2(this,window.event.keyCode)" value="<?=$row["trainbudget"]?>" size="10"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">หมายเหตุ</td>
    <td align="center">:</td>
    <td><textarea name="trainremark" cols="60" rows="2"><?=$row["trainremark"]?></textarea></td>
  </tr>
  <tr>
    <td align="right">เอกสารแนบ</td>
    <td align="center">:</td>
    <td><input name="trainfile" type="file" size="40">
      <?php if(!empty($row["trainfile"])) echo " <a href='".$row["trainfile"]."' target='_blank'>เอกสารแนบ</a>"?></td>
  </tr>
  
  <tr bgcolor="#FFFFFF">
    <td colspan="3" align="center">
		<br>
	  	<button type="submit" name="save"><img src="../image/upload-page-blue.gif">&nbsp;บันทึก</button>
	  	<button onClick="location='train.php?empid=<?=$empid?>'"><img src="../image/left-blue.gif">&nbsp;กลับรายการ</button>	</td>
  </tr>
</table>
<? closeframe2();?>
</form>
</body>
</html>
<script type="text/javascript">
	Calendar.setup({ inputField:"trainstart",displayArea:"desktop",button:"cmdtrainstart"});
	Calendar.setup({ inputField:"trainend",displayArea:"desktop",button:"cmdtrainend"});
</script> 