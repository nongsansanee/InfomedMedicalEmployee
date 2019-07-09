<?php
session_start();
require("../inc/function.php");
$db_conn = new core_mysql ();
$sql="select * from tbempwork where empid='$empid'";
$result = $db_conn->query ($sql);
$row = mysql_fetch_array($result);
$sql="select b.technicname,a.technicdate from tbemptechnic a left join mttechnic b on a.technicid=b.technicid where a.empid='$empid' order by a.technicdate desc";
$result1 = $db_conn->query ($sql);
$sql="select timeno,timestart,timeend from tbemptime where empid='$empid' order by timeno";
$result4 = $db_conn->query ($sql);
if(empty($row["workindate"]) || $row["workindate"]=="0000-00-00"){
	$workage=0;
	$text1="";
}else{
	$arrdatetime=explode(" ",$row["workindate"]);
	list($yy,$mm,$dd)=explode("-",$arrdatetime[0]);
	$arrage=calage("$dd/$mm/$yy");
	$workage=$arrage[2];
	$yy=(int)$yy+568;
	$text1="$dd/$mm/$yy";
}
$worktype=getdata("typename","mttype","where typeid='".$row['worktype']."'");
$workposition=getdata("positionname","mtposition","where positionid='".$row['workposition']."'");
$workunit=getdata("unitname","tbjobunit","where unitid='".$row['workunit']."'");
$workplace=getdata("placename","mtplace","where placeid='".$row['workplace']."'");
$birthday=getdata("empbirthday","tbemployee","where empid='$empid'");
if(empty($birthday) || $birthday=="0000-00-00"){
	$text2="";
	$text3="";
}else{
	list($yy,$mm,$dd)=explode("-",$birthday);
	if((int)$mm>9) $yy=$yy+1;
	$yy60=$yy+603;
	$yy65=$yy+608;
	$text2="01/10/$yy60";
	$text3="01/10/$yy65";
}
$sql="select govlevel,govstep from tbempgoverment where empid='$empid' order by govdate desc limit  1";
$results = $db_conn->query ($sql);
$rows=mysql_fetch_array($results);
$level=$rows[0];
$salary=$rows[1];
$wdate=getdata("govdate","tbempgoverment","where empid='$empid' order by govdate limit  1");
if(empty($wdate) || $wdate=="0000-00-00"){
	$workage=0;
}else{
	$arrdatetime=explode(" ",$wdate);
	list($yy,$mm,$dd)=explode("-",$arrdatetime[0]);
	$arrage=calage("$dd/$mm/$yy");
	$workage=$arrage[2];
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<title>ประวัติส่วนตัว</title>
<style>
	body {font: 12px Tahoma}
	table {font: 12px Tahoma}
</style>
</head>

<body>
<table width="100%" style="border-collapse:collapse" bordercolor="#3399FF" cellpadding="0" cellspacing="0" border="1" align="center" background="../image/bg.jpg">
  <tr>
    <td>
	<form method="post" name="form1" style="margin-bottom:0">
	<input name="empid" type="hidden" value="<?=$empid?>">
	    <table width="100%" >
          <tr> 
            <td align="right">ประเภทการจ้าง</td>
            <td align="center" width="10">:</td>
            <td><input name="worktype" type="text" size="30" value="<?=$worktype?>" readonly></td>
            <td align="right">เลขประจำตำแหน่ง</td>
            <td align="center">:</td>
            <td><input name="workid" type="text" size="20"  value="<?=$row["workid"]?>" readonly></td>
          </tr>
          <tr> 
            <td align="right">วันบรรจุ</td>
            <td align="center">:</td>
            <td><input name="workindate" type="text" value="<?=bc2be($row["workindate"],false)?>" size="10" readonly></td>
            <td align="right">อายุงาน</td>
            <td align="center">:</td>
            <td><input type="text" name="workage" size="5" value="<?=$workage?>"></td>
          </tr>
          <tr>
            <td align="right">โอนย้าย</td>
            <td align="center">:</td>
            <td><input name="worktransfer" type="text" value="<?=bc2be($row["worktransfer"],false)?>" size="10" readonly></td>
            <td align="right">ครบ 25 ปี</td>
            <td align="center">:</td>
            <td><input type="text" name="text2" size="10" value="<?=$text1?>" readonly></td>
          </tr>
          <tr> 
            <td align="right">เกษียณอายุราชการ</td>
            <td align="center">:</td>
            <td><input type="text" name="text1" size="10" value="<?=$text2?>" readonly></td>
            <td align="right">ครบ 65 ปี</td>
            <td align="center">:</td>
            <td><input type="text" name="text3" size="10" value="<?=$text3?>" readonly>
&nbsp;(ต่ออายุราชการ)</td>
          </tr>
          <tr>
            <td align="right">วันบรรจุเป็นอาจารย์</td>
            <td align="center">:</td>
            <td><input name="workappoint" type="text" value="<?=bc2be($row["workappoint"],false)?>" size="10" readonly></td>
            <td align="right">มีมติรับเป็น<br>
อาจารย์ภาควิชาฯ</td>
            <td align="center">:</td>
            <td><input name="workvote" type="text" value="<?=bc2be($row["workvote"],false)?>" size="10" readonly></td>
          </tr>
          <tr> 
            <td align="right" valign="top">ระยะเวลาการจ้าง</td>
            <td align="center" valign="top">:</td>
            <td colspan="4"><table id="myTable2" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
              <tr style="background-color:#FFFFCC; color:#006666; font-weight:bold">
                <td align="center">ครั้งที่</td>
                <td align="center">ระยะเวลาการจ้าง</td>
                </tr>
              <?
			while($row4 = mysql_fetch_array($result4)){
			?>
              <tr bgcolor="#FFFFFF">
                <td><?=$row4["timeno"]?></td>
                <td><?=bc2be($row4["timestart"],false).' ถึง '.bc2be($row4["timeend"],false)?></td>
                </tr>
              <?
			}
			?>
            </table></td>
          </tr>
          <tr>
            <td align="right">ระดับ</td>
            <td align="center">:</td>
            <td><input name="worksalarylevel" type="text" size="5"  value="<?=$level<=0?"":$level?>" readonly></td>
            <td align="right">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td align="right">เงินเดือน</td>
            <td align="center">:</td>
            <td><input name="worksalary" type="text" size="10"  value="<?=$salary<=0?"":number_format($salary)?>" readonly></td>
            <td align="right">เงินประจำตำแหน่ง</td>
            <td align="center">:</td>
            <td><input name="worksalarypos" type="text" size="10"  value="<?=$row["worksalarypos"]<=0?"":number_format($row["worksalarypos"])?>" readonly></td>
          </tr>
          <tr> 
            <td align="right">ตำแหน่ง</td>
            <td align="center">:</td>
            <td colspan="4"><input name="workposition" type="text" size="60"  value="<?=$workposition?>" readonly></td>
          </tr>
          <tr>
            <td align="right" valign="top">ตำแหน่งทางวิชาการ</td>
            <td align="center" valign="top">:</td>
            <td colspan="4"><table id="myTable1" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
              <tr style="background-color:#FFFFCC; color:#006666; font-weight:bold">
                <td align="center">ตำแหน่งทางวิชาการ</td>
                <td align="center">ดำรงตำแหน่งเมื่อ</td>
              </tr>
              <?
			while($row1 = mysql_fetch_array($result1)){
			?>
              <tr bgcolor="#FFFFFF">
                <td><?=$row1[0]?></td>
                <td><?=bc2be($row1[1],false)?></td>
              </tr>
              <?
			}
			?>
            </table></td>
          </tr>
          <tr> 
            <td align="right">สาขาวิชา</td>
            <td align="center">:</td>
            <td colspan="4"><input name="workunit" type="text" size="30" value="<?=$workunit?>" readonly></td>
          </tr>
          <tr> 
            <td align="right">สถานที่ทำงาน</td>
            <td align="center">:</td>
            <td colspan="4"><input name="workplace" type="text" size="80" value="<?=$workplace?>" readonly></td>
          </tr>
          <tr> 
            <td align="right">โทรศัพท์</td>
            <td align="center">:</td>
            <td><input name="worktel" type="text" size="20"  value="<?= $row["worktel"]?>" readonly></td>
            <td align="right">โทรสาร</td>
            <td align="center">:</td>
            <td><input name="workfax" type="text" size="20"  value="<?= $row["workfax"]?>" readonly></td>
          </tr>
          <tr> 
            <td align="right" valign="top">เวลาปฏิบัติงาน</td>
            <td align="center" valign="top">:</td>
            <td colspan="4" valign="top"><input name="workoperate1" type="text" value="<?=substr($row["workoperate1"],0,5)?>" size="5" readonly>
-
  <input name="workoperate2" type="text" value="<?=substr($row["workoperate2"],0,5)?>" size="5" readonly></td>
          </tr>
          <tr> 
            <td align="right" valign="top">หมายเหตุ</td>
            <td align="center" valign="top">:</td>
            <td colspan="4" valign="top"><textarea name="workremark" cols="60" rows="3" id="workremark" readonly><?=$row["workremark"]?></textarea></td>
          </tr>
          <tr align="center"> 
            <td colspan="6"> <button onClick="location='printwork.php?empid=<?=$_GET["empid"]?>'"><img src="../image/printer-blue.gif">&nbsp;พิมพ์ 
              </button></td>
          </tr>
        </table>
	</form>
	</td>
  </tr>
</table>
</body>
</html>