<?php
session_start();
require("../inc/function.php");
$db_conn = new core_mysql ();
if (isset($_POST["save"])){
	$fileup="maryfile";
	if (validate_file($err,$fileup)){
		$filename = basename($_FILES[$fileup]["name"]);
		list($name,$sname) = explode(".",$filename);
		$maryfile = "../empdoc/mar$empid.$sname";
		if (!move_uploaded_file($_FILES[$fileup]["tmp_name"], $maryfile))
			$maryfile = "";
	}else
		$maryfile = "";

	$fileup="addressfile";
	if (validate_file($err,$fileup)){
		$addressfile = basename($_FILES[$fileup]["name"]);
		list($name,$sname) = explode(".",$addressfile);
		$addressfile = "../empdoc/adr$empid.$sname";
		if (!move_uploaded_file($_FILES[$fileup]["tmp_name"], $addressfile))
			$addressfile = "";
	}else
		$addressfile = "";

	$fileup="pidfile";
	if (validate_file($err,$fileup)){
		$pidfile = basename($_FILES[$fileup]["name"]);
		list($name,$sname) = explode(".",$pidfile);
		$pidfile = "../empdoc/pid$empid.$sname";
		if (!move_uploaded_file($_FILES[$fileup]["tmp_name"], $pidfile))
			$pidfile = "";
	}else
		$pidfile = "";

	$fileup="cardidfile";
	if (validate_file($err,$fileup)){
		$cardidfile = basename($_FILES[$fileup]["name"]);
		list($name,$sname) = explode(".",$cardidfile);
		$cardidfile = "../empdoc/cid$empid.$sname";
		if (!move_uploaded_file($_FILES[$fileup]["tmp_name"], $cardidfile))
			$cardidfile = "";
	}else
		$cardidfile = "";

	$empid=$_POST["empid"];
	$empbirthday=be2bc($_POST["empbirthday"]);
	$empsex=$_POST["empsex"];
	$emprace=$_POST["emprace"];
	$empnation=$_POST["empnation"];
	$empreligion=$_POST["empreligion"];
	$empmary=$_POST["empmary"];
	$empson=$_POST["empson"];
	$empspouse=$_POST["empspouse"];
	$empaddress=$_POST["empaddress"];
	$empcurrent=$_POST["empcurrent"];
	$emptel=$_POST["emptel"];
	$empmobile=$_POST["empmobile"];
	$empemergency=$_POST["empemergency"];
	$empemrtel=$_POST["empemrtel"];
	$emppid=$_POST["emppid"];
	$empcardid=$_POST["empcardid"];
	$empemail=$_POST["empemail"];
	$empremark=$_POST["empremark"];
	$fcancel=$_POST["fcancel"];
	$datein=date("Y-m-d H:i:s");
	$userin=$myauth["userin"];
	if(!empty($maryfile)) $upfile="`maryfile` = '$maryfile',";
	if(!empty($addressfile)) $upfile.="`addressfile` = '$addressfile',";
	if(!empty($pidfile)) $upfile.="`pidfile` = '$pidfile',";
	if(!empty($cardidfile)) $upfile.="`cardidfile` = '$cardidfile',";
	$sql="UPDATE `tbemployee` SET `empbirthday` = '$empbirthday',`empsex` = '$empsex',`emprace` = '$emprace',`empnation` = '$empnation',`empreligion` = '$empreligion',";
	$sql.="`empmary` = '$empmary',`empson` = '$empson',`empspouse` = '$empspouse',`empaddress` = '$empaddress',`empcurrent` = '$empcurrent',`emptel` = '$emptel',";
	$sql.="`empmobile` = '$empmobile',`empemergency` = '$empemergency',`empemrtel` = '$empemrtel',`emppid` = '$emppid',`empcardid` = '$empcardid',`empemail` = '$empemail',";
	$sql.="`empremark` = '$empremark',$upfile`datein` = '$datein',`userin` = '$userin' WHERE `empid` = '$empid' LIMIT 1";
	$result = $db_conn->query ($sql);
	$sql="DELETE FROM `tbempson` WHERE empid='$empid'";
	$result = $db_conn->query ($sql);
	for($i=1;$i<=$empson;$i++){
		$sonbirth=be2bc($_POST["sonbirth".$i]);
		$sql="INSERT INTO `tbempson` ( `empid` , `sonno` , `sonname` , `sonsname` , `sonbirth` , `sonsex` ) VALUES ('$empid', '$i', '".$_POST["sonname".$i]."', '".$_POST["sonsname".$i]."', '$sonbirth', '".$_POST["sonsex".$i]."')";
		$result = $db_conn->query ($sql);
	}
	$fsize=count($fcancel);
	for($i=0;$i<$fsize;$i++){
		$delfield.=(empty($delfield)?"":",").$fcancel[$i]."=NULL";
		$selfield.=(empty($selfield)?"":",").$fcancel[$i];
		
	}
	if($fsize>0){
		$sql="UPDATE `tbemployee` SET $delfield WHERE `empid` = '$empid' LIMIT 1";
		$result = $db_conn->query ($sql);
		$sql="SELECT $selfield FROM tbemployee WHERE `empid` = '$empid' LIMIT 1";
		$result = $db_conn->query ($sql);
		if(mysql_num_rows($result)>0){
			$row=mysql_fetch_assoc($result);
			foreach($row as $value)
				unlink($value);
		}
	}	
	msgBox("บันทึกข้อมูลเรียบร้อย");
}
$sql="select * from tbemployee where empid='".$_GET["empid"]."'";
$result = $db_conn->query ($sql);
$row = mysql_fetch_array($result);
$sql="select * from tbempson where empid='".$_GET["empid"]."' order by sonno";
$resultd = $db_conn->query ($sql);
$pos = strpos($row["empnation"], "อื่น");
if ($pos === false) $dispnation="none"; else $dispnation="inline";
if($row["empbirthday"]=="0000-00-00")
	$sonage=0;
else{
	list($yy,$mm,$dd)=explode("-",$row["empbirthday"]);
	$arrage=calage("$dd/$mm/$yy");
	$age=$arrage[2];
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<title>ประวัติส่วนตัว</title>
<style>
	a:link {font-family: "MS SanSerif"; text-decoration: none; color: #000099}
	a:visited {font-family: "MS SanSerif"; text-decoration: none; color: #000099}
	a:hover {font-family: "MS SanSerif"; text-decoration: none; color: #000099}
	a:active {	font-family: "MS SanSerif"; text-decoration: none; color: #000099}
	body {font: 12px Tahoma}
	table {font: 12px Tahoma}
</style>
<script type="text/javascript" src="../inc/jquery.js"></script>
<script type="text/javascript" src="../inc/jquery.maskedinput.js"></script>
<script type="text/javascript" src="../calendar/calendar.js"></script>
<script type="text/javascript" src="../calendar/calendar-setup.js"></script>
<script type="text/javascript" src="../calendar/calendar-th.js"></script>
<script type="text/javascript" src="../inc/statushide.js"></script>
<style type="text/css"> @import url("../calendar/calendar-blue.css"); </style>
<script language="javascript">
	jQuery(function($){
	   $("#empbirthday").mask("99/99/9999");
	})

	function insRow(newRow){
		if(newRow=="") return;
		var obj=document.getElementById('myTable');
		var oldRow=obj.rows.length-1;
		if(oldRow!=newRow){
			if(oldRow>newRow){
				var delRow=oldRow-newRow;
				for(i=0; i<delRow; i++) obj.deleteRow(obj.rows.length-1);				
			}else{
				var insertRow=newRow-oldRow;
				for(i=0; i<insertRow; i++){
					var x=obj.insertRow(obj.rows.length);
					var a=x.insertCell(0);
					var b=x.insertCell(1);
					var c=x.insertCell(2);
					var d=x.insertCell(3);
					var e=x.insertCell(4);
					var no=obj.rows.length-1;
					a.innerHTML=no;
					b.innerHTML='<input name="sonname'+no+'" type="text" size="20">-<input name="sonsname'+no+'" type="text" size="20" value="<?=$row[empsname]?>">';
					c.innerHTML='<input name="sonbirth'+no+'" type="text" size="8" onChange="caltime(this.value,sonage'+no+')"><img src="../image/calendar.jpg" alt="เลือกวันที่" id="cmdsonbirth'+no+'" style="cursor:hand">';
					Calendar.setup({ inputField:"sonbirth"+no,displayArea:"desktop",button:"cmdsonbirth"+no});
					d.innerHTML='<select name="sonsex'+no+'"><option></option><option value="1">ชาย</option><option value="2">หญิง</option></select>';
					e.innerHTML='<input name="sonage'+no+'" type="text" size="2">';
					a.align="center";
					c.align="center";
					d.align="center";
					e.align="center";
					x.bgColor ="white";
				}
			}
		}
	}

	function xNum2(obj,key){
		ret=false;
		if( (key>=48 && key<=57) || key==46 ){
			ret=true;
		}
		return ret;
	}

	function caltime(vdate,oname){
		var minutes = 1000*60;
		var hours = minutes*60;
		var days = hours*24;
		var years = days*365;
		var arrDate=vdate.split("/");
		var d = new Date()
		if(arrDate.length>0){
			var bDate=new Date(arrDate[2]-543, arrDate[1]-1 , arrDate[0]);
			var cDate=new Date(d.getFullYear(),  d.getMonth(), d.getDate());
			var t = cDate.getTime()-bDate.getTime();
			var y = t/years;
			oname.value=Math.floor(y);
		}
	}
</script>
</head>

<body background="../image/bg.jpg">
<form method="post" enctype="multipart/form-data" name="form1" style="margin-bottom:0">
<input name="empid" type="hidden" value="<?=$empid?>">
<fieldset><legend><strong>ประวัติส่วนตัว</strong></legend>
<table width="100%" cellpadding="3" >
  <tr>
    <td align="right">วัน เดือน ปี เกิด</td>
    <td align="center" width="10">:</td>
    <td><input name="empbirthday" id="empbirthday" type="text" value="<?=bc2be($row["empbirthday"],false)?>" size="10" maxlength="10">
        <img src="../image/calendar.jpg" alt="เลือกวันที่" id="cmdempbirthday" style="cursor:hand"></td>
  </tr>
  <tr>
    <td align="right">อายุ</td>
    <td align="center">:</td>
    <td><input type="text" name="age" size="5" value="<?=$age?>">
      &nbsp;ปี&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เพศ&nbsp;:&nbsp;
      <select name="empsex">
        <option value=""></option>
        <option value="1" <? if($row["empsex"]=="1") echo "selected"?>>ชาย</option>
        <option value="2" <? if($row["empsex"]=="2") echo "selected"?>>หญิง</option>
      </select></td>
  </tr>
  <tr>
    <td align="right">เชื้อชาติ</td>
    <td align="center">:</td>
    <td><? createlist("racename as raceid,racename","mtrace","",$row["emprace"],"emprace","")?>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;สัญชาติ&nbsp;:&nbsp;
      <? createlist("nationname as nationid,nationname","mtnation","",$row["empnation"],"empnation","")?></td>
  </tr>
  <tr>
    <td align="right">ศาสนา</td>
    <td align="center">:</td>
    <td><? createlist("reliname as reliid,reliname","mtreligion","",$row["empreligion"],"empreligion","")?></td>
  </tr>
  <tr>
    <td align="right">สถานภาพสมรส</td>
    <td align="center">:</td>
    <td><? createlist("maryname as maryid,maryname","mtmary","",$row["empmary"],"empmary","")?>
      &nbsp;&nbsp;คู่สมรส&nbsp;:&nbsp;
      <input type="text" name="empspouse" size="35" value="<?=$row["empspouse"]?>">
      <?php if(!empty($row["maryfile"])) echo " <a href='".$row["maryfile"]."' target='_blank'>เอกสารแนบ</a> <input name='fcancel[]' type='checkbox' value='maryfile'>ยกเลิก"?></td>
  </tr>
  
  <tr>
    <td align="right">บุตร/ธิดา</td>
    <td align="center">:</td>
    <td><input name="empson" type="text" size="2" value="<?=$row["empson"]?>" onKeyUp="insRow(this.value)">
      &nbsp;คน</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><table border="0" cellspacing="1" bgcolor="#CCCCCC" width="100%" id="myTable">
      <tr style="background-color:#FFFFCC; color:#006666; font-weight:bold" height="25">
        <td align="center">คนที่</td>
        <td align="center">ชื่อ-นามสกุล</td>
        <td align="center">วันเกิด</td>
        <td align="center">เพศ</td>
        <td align="center">อายุ</td>
      </tr>
      <?
			while($rowd = mysql_fetch_array($resultd)){
				if($rowd["sonbirth"]=="0000-00-00")
					$sonage=0;
				else{
					list($yy,$mm,$dd)=explode("-",$rowd["sonbirth"]);
					$arrage=calage("$dd/$mm/$yy");
					$sonage=$arrage[2];
				}
              echo '<tr style="background-color:#FFFFFF;">
                <td align="center">'.$rowd["sonno"].'</td>
                <td><input name="sonname'.$rowd["sonno"].'" type="text" size="20" value="'.$rowd["sonname"].'">-<input name="sonsname'.$rowd["sonno"].'" type="text" size="20" value="'.$rowd["sonsname"].'"></td>
                <td align="center"><input name="sonbirth'.$rowd["sonno"].'" type="text" size="8" value="'.bc2be($rowd["sonbirth"],false).'" onChange="caltime(this.value,sonage'.$rowd["sonno"].')"><img src="../image/calendar.jpg" alt="เลือกวันที่" id="cmdsonbirth'.$rowd["sonno"].'" style="cursor:hand"><script type="text/javascript">Calendar.setup({ inputField:"sonbirth'.$rowd["sonno"].'",displayArea:"desktop",button:"cmdsonbirth'.$rowd["sonno"].'"});</script></td>					
               <td align="center"><select name="sonsex'.$rowd["sonno"].'"><option></option><option value="1" '.($rowd["sonsex"]=="1"?"selected":"").'>ชาย</option><option value="2" '.($rowd["sonsex"]=="2"?"selected":"").'>หญิง</option></select></td>
                <td align="center"><input name="sonage'.$rowd["sonno"].'" type="text" size="2" value="'.$sonage.'"></td>
                </tr>';
			}
?>
    </table></td>
  </tr>
  <tr>
    <td align="right" valign="top">ที่อยู่ ตามทะเบียนบ้าน</td>
    <td align="center" valign="top">:</td>
    <td><textarea name="empaddress" cols="60" rows="3"><?=$row["empaddress"]?>
</textarea>
        <?php if(!empty($row["addressfile"])) echo " <a href='".$row["addressfile"]."' target='_blank'>เอกสารแนบ</a> <input name='fcancel[]' type='checkbox' value='addressfile'>ยกเลิก"?></td>
  </tr>
  
  <tr>
    <td align="right" valign="top">ที่อยู่ ปัจจุบัน</td>
    <td align="center" valign="top">:</td>
    <td><textarea name="empcurrent" cols="60" rows="3" id="empcurrent"><?=$row["empcurrent"]?>
</textarea></td>
  </tr>
  <tr>
    <td align="right">โทรศัพท์</td>
    <td align="center">:</td>
    <td><input name="emptel" type="text" value="<?=$row["emptel"]?>" size="15">
      &nbsp;&nbsp;มือถือ&nbsp;:&nbsp;
      <input name="empmobile" type="text" value="<?=$row["empmobile"]?>" size="15"></td>
  </tr>
  <tr>
    <td align="right">ฉุกเฉิน(ติดต่อ)</td>
    <td align="center">:</td>
    <td><input name="empemergency" type="text" value="<?=$row["empemergency"]?>" size="30">
      &nbsp;&nbsp;โทรศัพท์&nbsp;:&nbsp;
      <input type="text" name="empemrtel" value="<?=$row["empemrtel"]?>" size="20"></td>
  </tr>
  <tr>
    <td align="right">อีเมลล์</td>
    <td align="center">:</td>
    <td><input name="empemail" type="text" value="<?=$row["empemail"]?>" size="60"></td>
  </tr>
  <tr>
    <td align="right">หมายเลขประจำตัวประชาชน</td>
    <td align="center">:</td>
    <td><input name="emppid" type="text" size="30"  value="<?= $row["emppid"]?>">
        <?php if(!empty($row["pidfile"])) echo " <a href='".$row["pidfile"]."' target='_blank'>เอกสารแนบ</a> <input name='fcancel[]' type='checkbox' value='pidfile'>ยกเลิก"?></td>
  </tr>
  
  <tr>
    <td align="right">เลขที่ใบอนุญาตประกอบโรคศิลป์</td>
    <td align="center">:</td>
    <td><input name="empcardid" type="text" size="30"  value="<?= $row["empcardid"]?>">
        <?php if(!empty($row["cardidfile"])) echo " <a href='".$row["cardidfile"]."' target='_blank'>เอกสารแนบ</a> <input name='fcancel[]' type='checkbox' value='cardidfile'>ยกเลิก"?></td>
  </tr>
  
  <tr>
    <td align="right" valign="top">หมายเหตุ</td>
    <td align="center" valign="top">:</td>
    <td><textarea name="empremark" cols="60" rows="3"><?=$row["empremark"]?>
</textarea></td>
  </tr>
</table>
</fieldset><fieldset style="margin-top:10">
<legend><strong>เอกสารแนบ</strong></legend>
<table width="100%" cellpadding="3">
  <tr>
    <td align="right">สมรส</td>
    <td align="center">:</td>
    <td><input name="maryfile" type="file" size="40"></td>
  </tr>
  <tr>
    <td align="right">ที่อยู่ ตามทะเบียนบ้าน</td>
    <td align="center">:</td>
    <td><input name="addressfile" type="file" id="addressfile" size="40"></td>
  </tr>
  <tr>
    <td align="right">หมายเลขประจำตัวประชาชน</td>
    <td align="center">:</td>
    <td><input name="pidfile" type="file" id="pidfile" size="40"></td>
  </tr>
  <tr>
    <td align="right">เลขที่ใบอนุญาตประกอบโรคศิลป์</td>
    <td align="center">:</td>
    <td><input name="cardidfile" type="file" size="40"></td>
  </tr>
  <tr>
    <td colspan="3" align="center"><br>
	<button type="submit" name="save"><img src="../image/upload-page-blue.gif">&nbsp;บันทึก</button>
	<button type="reset"><img src="../image/checkout-blue.gif">&nbsp;ยกเลิก</button>
	<button onClick="location='printprivate.php?empid=<?=$_GET["empid"]?>'"><img src="../image/printer-blue.gif">&nbsp;พิมพ์ </button></td>
	</td>
    </tr>
</table>
</fieldset></form>
</body>
</html>
<script type="text/javascript">
	Calendar.setup({ inputField:"empbirthday",displayArea:"desktop",button:"cmdempbirthday"});
</script>