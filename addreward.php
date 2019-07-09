<?php
session_start();
require("../inc/function.php");
require("../theme1/theme.php");
define("THEME","../theme1/",true);
$db_conn = new core_mysql ();
if (isset($_POST["save"])){
	$id=$_POST["id"];
	$empid=$_POST["empid"];
	$rewardyear=$_POST["rewardyear"];
	$reward=$_POST["reward"];
	$rewardunit=$_POST["rewardunit"];
	$rewardlevel=$_POST["rewardlevel"];
	$datein=date("Y-m-d H:i:s");
	$userin=$myauth["userin"];
	if($_POST["chk"]=="a"){
		$sql="INSERT INTO `tbempreward` ( `empid` , `rewardyear` , `reward` , `rewardunit` , `rewardlevel` , `datein` , `userin` ) VALUES ('$empid', '$rewardyear', '$reward', '$rewardunit', '$rewardlevel', '$datein', '$userin')";
	}else{
		$sql="UPDATE `tbempreward` SET `empid` = '$empid',`rewardyear` = '$rewardyear',`reward` = '$reward',`rewardunit` = '$rewardunit',`rewardlevel` = '$rewardlevel',`datein` = '$datein',`userin` = '$userin' WHERE `id` = '$id' LIMIT 1";
	}
	$result = $db_conn->query ($sql);
	msgBox("บันทึกข้อมูลเรียบร้อย","reward.php?empid=$empid");
}
$empid=$_GET["empid"];
if($_GET["chk"]=="e"){
	$sql="SELECT * FROM tbempreward WHERE `id` = '".$_GET["id"]."' LIMIT 1";
	$result = $db_conn->query ($sql);
	$row=mysql_fetch_array($result);
	$empid=$row["empid"];
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<title>บันทึกข้อมูลประวัติเกียรติยศ</title>
<style>
	body {font: 12px Tahoma}
	table {font: 12px Tahoma}
	.SOME5 {font-family:Tahoma, Verdana, Arial; font-size:13px; color:#FF8000; font-weight:bold; text-decoration:none}
	.SOME5Big {font-family :Tahoma, Verdana, Arial; font-size :16px; color :#FF8000; font-weight :bold; text-decoration: none}
</style>
<script language="javascript">
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
<? openframe2("บันทึกข้อมูลประวัติเกียรติยศ");?>
<table width="100%">
  <tr bgcolor="#FFFFFF">
    <td align="right">พ.ศ.</td>
    <td align="center">:</td>
    <td><input name="rewardyear" type="text" onKeyPress="return  xNum2(this,window.event.keyCode)" value="<?=$row["rewardyear"]?>" size="5"<?=$enabled?>></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">เกียรติยศ</td>
    <td align="center">:</td>
    <td><input name="reward" type="text" value="<?=$row["reward"]?>" size="60" ></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">หน่วยงานที่มอบรางวัล</td>
    <td align="center">:</td>
    <td><input name="rewardunit" type="text" value="<?=$row["rewardunit"]?>" size="60" ></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">ระดับ</td>
    <td align="center">:</td>
    <td><select name="rewardlevel">
      <option value=""></option>
      <option value="1"<? if($row["rewardlevel"]=="1") echo " selected"?>>ระดับชาติ</option>
      <option value="2"<? if($row["rewardlevel"]=="2") echo " selected"?>>ระดับนานาชาติ</option>
    </select></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td colspan="3" align="center">
		<br>
	  	<button type="submit" name="save"><img src="../image/upload-page-blue.gif">&nbsp;บันทึก</button>
	  	<button onClick="location='reward.php?empid=<?=$empid?>'"><img src="../image/left-blue.gif">&nbsp;กลับรายการ</button>
	</td>
  </tr>
</table>
<? closeframe2();?>
</form>
</body>
</html>