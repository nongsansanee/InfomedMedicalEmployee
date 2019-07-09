<?php
session_start();
require("../inc/function.php");
$sql="select * from tbemployee where empid='".$_GET["empid"]."'";
$db_conn = new core_mysql ();
$result = $db_conn->query ($sql);
$row = mysql_fetch_array($result);
if($row["empsex"]=="1") $sex="ชาย"; else if($row["empsex"]=="2") $sex="หญิง";
$sql="select * from tbempson where empid='".$_GET["empid"]."' order by sonno";
$resultd = $db_conn->query ($sql);
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
<script type="text/javascript" src="../inc/statushide.js"></script>
<title>ประวัติส่วนตัว</title>
<style>
	a:link {font-family: "MS SanSerif"; text-decoration: none; color: #000099}
	a:visited {font-family: "MS SanSerif"; text-decoration: none; color: #000099}
	a:hover {font-family: "MS SanSerif"; text-decoration: none; color: #000099}
	a:active {	font-family: "MS SanSerif"; text-decoration: none; color: #000099}
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
            <td align="right">วัน เดือน ปี เกิด</td>
            <td align="center" width="10">:</td>
            <td><input name="empbirthday" type="text" value="<?=bc2be($row["empbirthday"],false)?>" size="10" readonly>
              &nbsp;&nbsp;&nbsp;:&nbsp;</td>
          </tr>
          <tr>
            <td align="right">อายุ</td>
            <td align="center">:</td>
            <td><input type="text" name="age" size="5" value="<?=$age?>">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เพศ&nbsp;:&nbsp;
            <input name="empsex" type="text" value="<?=$sex?>" size="15" readonly></td>
          </tr>
          <tr>
            <td align="right">เชื้อชาติ</td>
            <td align="center">:</td>
            <td><input name="emprace" type="text" value="<?=$row["emprace"]?>" size="15" readonly>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; สัญชาติ&nbsp;:
            <input name="empnation" type="text" value="<?=$row["empnation"]?>" size="15" readonly></td>
          </tr>
          <tr> 
            <td align="right">ศาสนา</td>
            <td align="center">:</td>
            <td><input name="empreligion" type="text" value="<?=$row["empreligion"]?>" size="15" readonly></td>
          </tr>
          <tr> 
            <td align="right">สถานภาพสมรส</td>
            <td align="center">:</td>
            <td><input name="empmary" type="text" value="<?=$row["empmary"]?>" size="15" readonly> 
              &nbsp;&nbsp;คู่สมรส&nbsp;:&nbsp; <input type="text" name="empspouse" size="35" value="<?=$row["empspouse"]?>" readonly>
              <?php if(!empty($row["maryfile"])) echo " <a href='".$row["maryfile"]."' target='_blank'>เอกสารแนบ</a>"?></td>
          </tr>
<tr>
            <td align="right">บุตร/ธิดา</td>
            <td align="center">:</td>
            <td><input name="empson" type="text" size="2" value="<?=$row["empson"]?>" readonly>&nbsp;คน</td>
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
				switch ($rowd["sonsex"]) {
				case "1":
					$sex="ชาย";
					break;
				case "2":
					$sex="หญิง";
					break;
				default:
					$sex="";
				}
				if($rowd["sonbirth"]=="0000-00-00")
					$sonage=0;
				else{
					list($yy,$mm,$dd)=explode("-",$rowd["sonbirth"]);
					$age=calage("$dd/$mm/$yy");
					$sonage=$age[2];
				}
              echo '<tr style="background-color:#FFFFFF;">
                <td align="center">'.$rowd["sonno"].'</td>
                <td>'.$rowd["sonname"].'-'.$rowd["sonsname"].'</td>
                <td align="center">'.bc2be($rowd["sonbirth"],false).'</td>					
               <td align="center">'.$sex.'</td>
                <td align="center">'.$sonage.'</td>
                </tr>';
			}
?>
            </table></td>
          </tr>
          <tr> 
            <td align="right" valign="top">ที่อยู่ ตามทะเบียนบ้าน</td>
            <td align="center" valign="top">:</td>
            <td> <textarea name="empaddress" cols="60" rows="3" readonly><?=$row["empaddress"]?></textarea>
            <?php if(!empty($row["addressfile"])) echo " <a href='".$row["addressfile"]."' target='_blank'>เอกสารแนบ</a>"?></td>
          </tr>
          <tr> 
            <td align="right" valign="top">ที่อยู่ ปัจจุบัน</td>
            <td align="center" valign="top">:</td>
            <td><textarea name="empcurrent" cols="60" rows="3" id="empcurrent" readonly><?=$row["empcurrent"]?></textarea></td>
          </tr>
          <tr> 
            <td align="right">โทรศัพท์</td>
            <td align="center">:</td>
            <td><input name="emptel" type="text" value="<?=$row["emptel"]?>" size="15" readonly> 
              &nbsp;&nbsp;มือถือ&nbsp;:&nbsp; <input name="empmobile" type="text" value="<?=$row["empmobile"]?>" size="15" readonly></td>
          </tr>
          <tr> 
            <td align="right">ฉุกเฉิน(ติดต่อ)</td>
            <td align="center">:</td>
            <td><input name="empemergency" type="text" value="<?=$row["empemergency"]?>" size="30" readonly>
              &nbsp;&nbsp;โทรศัพท์&nbsp;:&nbsp;
              <input type="text" name="empemrtel" value="<?=$row["empemrtel"]?>" size="20" readonly></td>
          </tr>
          <tr> 
            <td align="right">อีเมลล์</td>
            <td align="center">:</td>
            <td><input name="empemail" type="text" value="<?=$row["empemail"]?>" size="60" readonly></td>
          </tr>
          <tr> 
            <td align="right">หมายเลขประจำตัวประชาชน</td>
            <td align="center">:</td>
            <td> <input name="emppid" type="text" size="30"  value="<?= $row["emppid"]?>" readonly>
            <?php if(!empty($row["pidfile"])) echo " <a href='".$row["pidfile"]."' target='_blank'>เอกสารแนบ</a>"?></td>
          </tr>
          <tr> 
            <td align="right">เลขที่ใบอนุญาตประกอบโรคศิลป์</td>
            <td align="center">:</td>
            <td> <input name="empcardid" type="text" size="30"  value="<?= $row["empcardid"]?>" readonly>
            <?php if(!empty($row["cardidfile"])) echo " <a href='".$row["cardidfile"]."' target='_blank'>เอกสารแนบ</a>"?></td>
          </tr>
          <tr> 
            <td align="right">หมายเหตุ</td>
            <td align="center">:</td>
            <td><textarea name="empremark" cols="60" rows="3" readonly><?=$row["empremark"]?></textarea></td>
          </tr>
          <tr align="center"> 
            <td colspan="3"><button onClick="location='printprivate.php?empid=<?=$_GET["empid"]?>'"><img src="../image/printer-blue.gif">&nbsp;พิมพ์ 
              </button></td>
          </tr>
        </table>
	</form>
	</td>
  </tr>
</table>
</body>
</html>
