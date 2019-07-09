<?php
session_start();
require("../inc/function.php");
require("../theme1/theme.php");
$db_conn = new core_mysql ();
$empid_old=$_GET["empid"];
$empflag=$_GET["empflag"];
$worktype=$_GET["worktype"];
$positiontype=$_GET["positiontype"];
$workposition=$_GET["workposition"];
$workunit=$_GET["workunit"];
$follow=$_GET["follow"];
$txtsearch=$_GET["txtsearch"];
if (isset($_POST["save"])){
	$empid_old=$_POST["empid_old"];
	$empid_new=$_POST["empid_new1"];
	$datein=date("Y-m-d H:i:s");
	$userin=$myauth["userin"];
	$empflag=$_POST["empflag"];
	$worktype=$_POST["worktype"];
	$positiontype=$_POST["positiontype"];
	$workposition=$_POST["workposition"];
	$workunit=$_POST["workunit"];
	$follow=$_POST["follow"];
	$txtsearch=$_POST["txtsearch"];
	$sql="SELECT empid FROM tbemployee WHERE empid='$empid_new'";
	$result = $db_conn->query ($sql);
	if(mysql_num_rows($result)>0){
		msgBox("ไม่สามารถโอนรหัสพนักงานได้,เนื่องจากรหัสพนักงานดังกล่าวมีอยู่แล้ว");
	}else{
		$sql="UPDATE `mtcountry` SET `userin` = '$empid_new' WHERE `userin` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `mtcourse` SET `userin` = '$empid_new' WHERE `userin` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `mtfund` SET `userin` = '$empid_new' WHERE `userin` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `mtfundtype` SET `userin` = '$empid_new' WHERE `userin` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `mtmary` SET `userin` = '$empid_new' WHERE `userin` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `mtnation` SET `userin` = '$empid_new' WHERE `userin` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `mtoperator` SET `userin` = '$empid_new' WHERE `userin` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `mtoperatordetail` SET `empid` = '$empid_new' WHERE `empid` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `mtplace` SET `userin` = '$empid_new' WHERE `userin` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `mtposition` SET `userin` = '$empid_new' WHERE `userin` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `mtprovince` SET `userin` = '$empid_new' WHERE `userin` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `mtrace` SET `userin` = '$empid_new' WHERE `userin` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `mtrank` SET `userin` = '$empid_new' WHERE `userin` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `mtreligion` SET `userin` = '$empid_new' WHERE `userin` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `mttechnic` SET `userin` = '$empid_new' WHERE `userin` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `mttitle` SET `userin` = '$empid_new' WHERE `userin` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `mttype` SET `userin` = '$empid_new' WHERE `userin` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `setsys` SET `userin` = '$empid_new' WHERE `userin` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `tbempclass` SET `empid` = '$empid_new' WHERE `empid` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `tbempclass` SET `userin` = '$empid_new' WHERE `userin` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `tbempeducation` SET `empid` = '$empid_new' WHERE `empid` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `tbempeducation` SET `userin` = '$empid_new' WHERE `userin` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `tbempgoverment` SET `empid` = '$empid_new' WHERE `empid` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `tbempgoverment` SET `userin` = '$empid_new' WHERE `userin` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `tbemployee` SET `empid` = '$empid_new' WHERE `empid` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `tbemployee` SET `userin` = '$empid_new' WHERE `userin` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `tbempperiod` SET `empid` = '$empid_new' WHERE `empid` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `tbempreward` SET `empid` = '$empid_new' WHERE `empid` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `tbempreward` SET `userin` = '$empid_new' WHERE `userin` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `tbempson` SET `empid` = '$empid_new' WHERE `empid` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `tbemptechnic` SET `empid` = '$empid_new' WHERE `empid` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `tbemptrain` SET `empid` = '$empid_new' WHERE `empid` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `tbemptrain` SET `userin` = '$empid_new' WHERE `userin` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `tbempwork` SET `empid` = '$empid_new' WHERE `empid` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `tbempwork` SET `userin` = '$empid_new' WHERE `userin` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `tbjob` SET `userin` = '$empid_new' WHERE `userin` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `tbjobaction` SET `empid` = '$empid_new' WHERE `empid` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `tbjobaction` SET `userin` = '$empid_new' WHERE `userin` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `tbjobunit` SET `userin` = '$empid_new' WHERE `userin` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `tbmanagedetail` SET `empid` = '$empid_new' WHERE `empid` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `tbmanageposition` SET `userin` = '$empid_new' WHERE `userin` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `tbresearchaction` SET `empid` = '$empid_new' WHERE `empid` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `tbresearchaction` SET `userin` = '$empid_new' WHERE `userin` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `tbsuccess` SET `userin` = '$empid_new' WHERE `userin` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `tbsuccessdetail` SET `empid` = '$empid_new' WHERE `empid` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `tbuauthor` SET `empid` = '$empid_new' WHERE `empid` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `tbuser` SET `empid` = '$empid_new' WHERE `empid` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `tbuser` SET `userin` = '$empid_new' WHERE `userin` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `tbletteraction` SET `empid` = '$empid_new' WHERE `empid` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `tbletteraction` SET `userin` = '$empid_new' WHERE `userin` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `tbletterprivate` SET `sendempid` = '$empid_new' WHERE `sendempid` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `tbletterregprivate` SET `regempid` = '$empid_new' WHERE `regempid` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `tblettersend` SET `sendempid` = '$empid_new' WHERE `sendempid` = '$empid_old'";
		$result = $db_conn->query ($sql);

		$sql="UPDATE `tblettersend` SET `sendname` = '$empid_new' WHERE `sendname` = '$empid_old'";
		$result = $db_conn->query ($sql);

		$sql="UPDATE `tbletterunit` SET `userin` = '$empid_new' WHERE `userin` = '$empid_old'";
		$result = $db_conn->query ($sql);
		$sql="UPDATE `tbletterreg` SET `regempid` = '$empid_new' WHERE `regempid` = '$empid_old'";
		$result = $db_conn->query ($sql);
		
		###### update in leave system #############
		require("../../mvmis/UpdateHR/update_sapid_for_leav.php");
		##################################
		msgBox("โอนรหัสพนักงานเรียบร้อย","viewemp.php?empflag=$empflag&worktype=$worktype&positiontype=$positiontype&workposition=$workposition&workunit=$workunit&follow=$follow&txtsearch=$txtsearch");
	}
}
$sql="select empid,empname,empsname from tbemployee where empid='$empid_old'";
$result = $db_conn->query ($sql);
$row = mysql_fetch_array($result);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<link rel="stylesheet" type="text/css" href="../Skin/style.css">
<title>โอนย้ายพนักงาน</title>
<script language="javascript">
function validate(e){
	if (e.empid_new1.value==""){
		alert("กรอกรหัสพนักงานใหม่ก่อนบันทึก");
		e.empid_new1.focus();
		return false;
	}
	if (e.empid_new2.value==""){
		alert("กรอกยืนยันรหัสพนักงานใหม่ก่อนบันทึก");
		e.empid_new2.focus();
		return false;
	}
	if (e.empid_new1.value!=e.empid_new2.value){
		alert("รหัสพนักงานใหม่ไม่ตรงกับยืนยันรหัสพนักงานใหม่");
		e.empid_new1.focus();
		return false;
	}	
	if (e.empid_old.value==e.empid_new2.value){
		alert("รหัสพนักงานใหม่จะต้องไม่เท่ากับรหัสพนักงานเดิม");
		e.empid_new1.focus();
		return false;
	}	
	if(!confirm("ยืนยันการโอนย้ายพนักงาน")) return false;
	return true;
}
</script>
</head>

<body text="#000000" link="#9999CC" vlink="#FF66CC" alink="#FF0000" onLoad="document.form1.empid_new1.focus();">
<form method="post" name="form1" onSubmit="return validate(this);">
<input name="empflag" type="hidden" value="<?=$empflag?>">
<input name="worktype" type="hidden" value="<?=$_GET["worktype"]?>">
<input name="positiontype" type="hidden" value="<?=$_GET["positiontype"]?>">
<input name="workposition" type="hidden" value="<?=$_GET["workposition"]?>">
<input name="workunit" type="hidden" value="<?=$_GET["workunit"]?>">
<input name="follow" type="hidden" value="<?=$_GET["follow"]?>">
<input name="txtsearch" type="hidden" value="<?=$_GET["txtsearch"]?>">
<?
openframe2("โอนย้ายพนักงาน");
?>
  <table width="100%">
    <tr  class="SOME"> 
      <td align="right">รหัสพนักงานเดิม</td>
      <td align="center">:</td>
      <td><input name="empid_old" type="text" maxlength="20" size="20" value="<?=$row[0]?>" style='background-color:#CCCCCC' readonly></td>
    </tr>
    <tr class="SOME"> 
      <td align="right">ชื่อ-สกุล</td>
      <td align="center">:</td>
      <td><input name="empname" type="text" size="50" value="<?=$row[1]."  ".$row[2]?>" style='background-color:#CCCCCC' readonly> 
      </td>
    </tr>
    <tr class="SOME"> 
      <td align="right">รหัสพนักงานใหม่</td>
      <td align="center">:</td>
      <td><input name="empid_new1" type="text" size="20" maxlength="20"> </td>
    </tr>
    <tr class="SOME"> 
      <td align="right">ยืนยันรหัสพนักงานใหม่</td>
      <td align="center">:</td>
      <td><input name="empid_new2" type="text" size="20" maxlength="20"> </td>
    </tr>
    <tr> 
      <td colspan="3" align="center">
	  	<button type="submit" name="save"><img src="../image/upload-page-blue.gif">&nbsp;บันทึก</button>
		<button onClick="location='viewemp.php?empflag='+empflag.value+'&worktype='+worktype.value+'&positiontype='+positiontype.value+'&workposition='+workposition.value+'&workunit='+workunit.value+'&follow='+follow.value+'&txtsearch='+txtsearch.value"><img src="../image/left-blue.gif">&nbsp;กลับรายการ</button>
	  </td>
    </tr>
  </table>
<?
closeframe2();
?>
</form>
</body>
</html>
