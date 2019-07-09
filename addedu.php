<?php
session_start();
require("../inc/function.php");
require("../theme1/theme.php");
define("THEME","../theme1/",true);
$db_conn = new core_mysql ();
if (isset($_POST["save"])){
	$id=$_POST["id"];
	$empid=$_POST["empid"];
	$edulevel=$_POST["edulevel"];
	$education=$_POST["education"];
	$seducation=$_POST["seducation"];
	$eduplace=$_POST["eduplace"];
	$educountry=$_POST["educountry"];
	$eduyear=$_POST["eduyear"];
	$eduversion=$_POST["eduversion"];
	$datein=date("Y-m-d H:i:s");
	$userin=$myauth["userin"];
	$sql="SELECT edufile FROM tbempeducation WHERE empid='$empid' AND NOT (edufile IS NULL OR edufile='')";
	$result = $db_conn->query ($sql);
	$numrow=mysql_num_rows($result);
	$run=$numrow<=0?1:$numrow+1;
	if($_POST["chk"]=="a"){
		$fileup="edufile";
		if (validate_file($err,$fileup)){
			$filename = basename($_FILES[$fileup]["name"]);
			list($name,$sname) = explode(".",$filename);
			$edufile = "../empdoc/edu".$empid."_".$run.".".$sname;
			if (!move_uploaded_file($_FILES[$fileup]["tmp_name"], $edufile))
				$edufile = "";
		}else
			$edufile = "";
		$sql="INSERT INTO `tbempeducation` ( `empid` , `edulevel` ,`education` , `seducation` , `eduplace` , `educountry` , `eduyear` , `eduversion` , `edufile` , `datein` , `userin` ) VALUES ('$empid','$edulevel', '$education', '$seducation', '$eduplace', '$educountry', '$eduyear', '$eduversion', '$edufile', '$datein', '$userin')";
	}else{
		$fileup="edufile";
		if (validate_file($err,$fileup)){
			$filename = basename($_FILES[$fileup]["name"]);
			list($name,$sname) = explode(".",$filename);
			$edufile = $_POST["uprun"]==""?"../empdoc/edu".$empid."_".$run.".".$sname:$_POST["uprun"];
			if (!move_uploaded_file($_FILES[$fileup]["tmp_name"], $edufile))
				$edufile = "";
		}else
			$edufile = "";
		if(!empty($edufile)) $upfile="`edufile` = '$edufile',";
		$sql="UPDATE `tbempeducation` SET `empid` = '$empid',`edulevel` = '$edulevel',`education` = '$education',`seducation` = '$seducation',`eduplace` = '$eduplace',`educountry` = '$educountry',`eduyear` = '$eduyear',`eduversion` = '$eduversion',$upfile`datein` = '$datein',`userin` = '$userin' WHERE `id` = '$id' LIMIT 1";
	}
	$result = $db_conn->query ($sql);
	msgBox("บันทึกข้อมูลเรียบร้อย","education.php?empid=$empid");
}
$empid=$_GET["empid"];
if($chk=="e"){
	$sql="SELECT * FROM tbempeducation WHERE `id` = '".$_GET["id"]."'";
	$result = $db_conn->query ($sql);
	$row=mysql_fetch_array($result);
	$empid=$row["empid"];
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<script type="text/javascript" src="../inc/statushide.js"></script>
<title>บันทึกข้อมูลประวัติการศึกษา</title>
<style>
	body {font: 12px Tahoma}
	table {font: 12px Tahoma}
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
<form name="form1" method="post" enctype="multipart/form-data">
<input name="id" type="hidden" value="<?=$row["id"]?>">
<input name="empid" type="hidden" value="<?=$empid?>">
<input name="chk" type="hidden" value="<?=$_GET["chk"]?>">
<input name="uprun" type="hidden" value="<?=$row["edufile"]?>">
<? openframe2("บันทึกข้อมูลประวัติการศึกษา");?>
<table width="100%">
	 <tr>
		<td align="right">ระดับการศึกษา</td>
		<td align="center">:</td>
		<td>
		
		<select name="edulevel" id="eculevel">
			<option value="0"></option>
			<option value="1" <? if($row["edulevel"]=='1') echo "selected";?>>มัธยมต้น</option>
			<option value="2" <? if($row["edulevel"]=='2') echo "selected";?>>มัธยมปลาย</option>
			<option value="3" <? if($row["edulevel"]=='3') echo "selected";?>>ปวช.</option>
			<option value="4" <? if($row["edulevel"]=='4') echo "selected";?>>ปวส.</option>
			<option value="5" <? if($row["edulevel"]=='5') echo "selected";?>>ป.ตรี </option>
			<option value="6" <? if($row["edulevel"]=='6') echo "selected";?>>ป.โท </option>
			<option value="7" <? if($row["edulevel"]=='7') echo "selected";?>>ป.เอก / เทียบเท่า</option>
		</select>
		
		</td>
	  </tr>
  <tr>
    <td align="right">วุฒิการศึกษา</td>
    <td align="center">:</td>
    <td><input name="education" type="text" size="60" value="<?=$row["education"]?>"></td>
  </tr>
  <tr>
    <td align="right">วุฒิการศึกษา(ย่อ)</td>
    <td align="center">:</td>
    <td><input name="seducation" type="text" size="40" value="<?=$row["seducation"]?>"></td>
  </tr>
  <tr>
    <td align="right">สถานศึกษา</td>
    <td align="center">:</td>
    <td><input name="eduplace" type="text" size="60" value="<?=$row["eduplace"]?>"></td>
  </tr>
  <tr>
    <td align="right">ประเทศ</td>
    <td align="center">:</td>
    <td><input name="educountry" type="text" size="60" value="<?=$row["educountry"]?>"></td>
  </tr>
  <tr>
    <td align="right">ปีการศึกษา</td>
    <td align="center">:</td>
    <td><input name="eduyear" type="text" size="5" value="<?=$row["eduyear"]?>" onKeyPress="return  xNum2(this,window.event.keyCode)"></td>
  </tr>
  <tr>
    <td align="right">รุ่นที่</td>
    <td align="center">:</td>
    <td><input name="eduversion" type="text" size="2" value="<?=$row["eduversion"]?>"></td>
  </tr>
  <tr>
    <td align="right">เอกสารแนบ</td>
    <td align="center">:</td>
    <td><input name="edufile" type="file" size="40">
      <?php if(!empty($row["edufile"])) echo " <a href='".$row["edufile"]."' target='_blank'>เอกสารแนบ</a>"?></td>
  </tr>
  
  <tr>
    <td colspan="3" align="center">
		<br>
	  	<button type="submit" name="save"><img src="../image/upload-page-blue.gif">&nbsp;บันทึก</button>
	  	<button onClick="location='education.php?empid=<?=$empid?>'"><img src="../image/left-blue.gif">&nbsp;กลับรายการ</button>	</td>
  </tr>
</table>
<? closeframe2();?>
</form>
</body>
</html>