<?php
session_start();
require("../inc/function.php");
$db_conn = new core_mysql ();
if (isset($_POST["save"])){
	$empid=$_POST["empid"];
	$worktype=$_POST["worktype"];
	$workid=$_POST["workid"];
	$workindate=be2bc($_POST["workindate"]);
	$worktransfer=be2bc($_POST["worktransfer"]);
	$workappoint=be2bc($_POST["workappoint"]);
	$worksalarypos=str_replace(',','',$_POST["worksalarypos"]);
	$positiontype=$_POST["positiontype"];
	$workposition=$_POST["workposition"];
	$workvote=be2bc($_POST["workvote"]);
	$workoperate1=str_replace('.',':',$_POST["workoperate1"]);
	$workoperate2=str_replace('.',':',$_POST["workoperate2"]);
	$workunit=$_POST["workunit"];
	$workplace=$_POST["workplace"];
	$worktel=$_POST["worktel"];
	$workfax=$_POST["workfax"];
	$workremark=$_POST["workremark"];
	$datein=date("Y-m-d H:i:s");
	$userin=$myauth["userin"];
	$sql="select empid from tbempwork where empid='$empid'";
	$result = $db_conn->query ($sql);
	if(mysql_num_rows($result)>0){
		$sql="UPDATE `tbempwork` SET `worktype` = '$worktype',`workid` = '$workid',`workindate` = '$workindate',`worktransfer` = '$worktransfer',`workappoint` = '$workappoint',`worksalarypos` = '$worksalarypos',`positiontype` = '$positiontype',`workposition` = '$workposition',`workvote` = '$workvote',`workoperate1` = '$workoperate1',`workoperate2` = '$workoperate2',`workunit` = '$workunit',`workplace` = '$workplace',`worktel` = '$worktel',`workfax` = '$workfax',`workremark` = '$workremark',`datein` = '$datein',`userin` = '$userin' WHERE `empid` = '$empid' LIMIT 1";
		$result = $db_conn->query ($sql);
	}else{
		$sql="INSERT INTO `tbempwork` ( `empid` , `worktype` , `workid` , `workindate` , `worktransfer` , `workappoint` , `worksalarypos` , `positiontype` , `workposition` , `workvote` , `workoperate1` , `workoperate2` , `workunit` , `workplace` , `worktel` , `workfax` , `workremark` , `datein` , `userin` ) VALUES ('$empid', '$worktype', '$workid', '$workindate', '$worktransfer', '$workappoint', '$worksalarypos', '$positiontype', '$workposition', '$workvote', '$workoperate1', '$workoperate2', '$workunit', '$workplace', '$worktel', '$workfax', '$workremark', '$datein', '$userin')";
		$result = $db_conn->query ($sql);
	}
	//บันทึกประวัติตำแหน่งทางวิชาการ
	$sql="DELETE FROM `tbemptechnic` WHERE `empid` = '$empid'";
	$result = $db_conn->query ($sql);
	for($i=0;$i<count($col10);$i++){
		$technicdate=be2bc($col10[$i]);
		$sql="INSERT INTO `tbemptechnic` ( `empid` , `technicdate` , `technicid` ) ";
		$sql.="VALUES ('$empid', '$technicdate', '".$col11[$i]."')";
		$result = $db_conn->query ($sql);
	}
	//บันทึกประวัติระยะเวลาการจ้าง
	$sql="DELETE FROM `tbemptime` WHERE `empid` = '$empid'";
	$result = $db_conn->query ($sql);
	for($i=0;$i<count($col12);$i++){
		$sql="INSERT INTO `tbemptime` ( `empid` , `timeno` , `timestart` , `timeend`  ) ";
		$sql.="VALUES ('$empid', '$col12[$i]', '".be2bc($col13[$i])."', '".be2bc($col14[$i])."')";
		$result = $db_conn->query ($sql);
	}
	msgBox("บันทึกข้อมูลเรียบร้อย");
}
$sql="select * from tbempwork where empid='$empid'";
$result = $db_conn->query ($sql);
$row = mysql_fetch_array($result);
$sql="select a.technicid,b.technicname,a.technicdate from tbemptechnic a left join mttechnic b on a.technicid=b.technicid where a.empid='$empid' order by a.technicdate desc";
$result1 = $db_conn->query ($sql);
$sql="select timeno,timestart,timeend from tbemptime where empid='$empid' order by timeno";
$result4 = $db_conn->query ($sql);
if(empty($row["workindate"]) || $row["workindate"]=="0000-00-00"){
	$text1="";
}else{
	$arrdatetime=explode(" ",$row["workindate"]);
	list($yy,$mm,$dd)=explode("-",$arrdatetime[0]);
	$yy=(int)$yy+568;
	$text1="$dd/$mm/$yy";
}
$sql="select govlevel,govstep from tbempgoverment where empid='$empid' order by govdate desc limit  1";
$results = $db_conn->query ($sql);
$rows=mysql_fetch_array($results);
$level=$rows[0];
$salary=$rows[1];
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
<script type="text/javascript" src="../inc/jquery.js"></script>
<script type="text/javascript" src="../inc/jquery.maskedinput.js"></script>
<script type="text/javascript" src="../calendar/calendar.js"></script>
<script type="text/javascript" src="../calendar/calendar-setup.js"></script>
<script type="text/javascript" src="../calendar/calendar-th.js"></script>
<style type="text/css"> @import url("../calendar/calendar-blue.css"); </style>
<script language="javascript">
	var itemsGroup = new Array();
	var itemsValue = new Array();
	var itemsText = new Array();
<?
	$sql="SELECT positiontype,positionid,positionname FROM mtposition order by positiontype,positionname";
	$result3 = $db_conn->query ($sql);
	while($row3=mysql_fetch_array($result3)){
		$x=$x+1;
		echo "x=".$x.";";
		echo "g='".$row3[0]."';";
		echo "v='".$row3[1]."';";
		echo "t='".$row3[2]."';";
?>
		itemsGroup[x] = g;
		itemsValue[x] = v;
		itemsText[x] = t;
<?
	} 
?>
	jQuery(function($){
	   $("#workindate").mask("99/99/9999");
	   $("#worktransfer").mask("99/99/9999");
	   $("#workappoint").mask("99/99/9999");
	   $("#workvote").mask("99/99/9999");
	   $("#technicdate").mask("99/99/9999");
	   $("#workoperate1").mask("99:99");
	   $("#workoperate2").mask("99:99");
	   $("#timestart").mask("99/99/9999");
	   $("#timeend").mask("99/99/9999");
	})

	function selectChange(control, controlToPopulate){
		var myEle ;
		var x ;
		for (var q=controlToPopulate.options.length;q>=0;q--) controlToPopulate.options[q]=null;
		myEle = document.createElement("option") ;
		myEle.value = " ";
		myEle.text = " -- เลือกตำแหน่ง -- " ;
		controlToPopulate.add(myEle) ;
		for ( x = 0 ; x < itemsText.length  ; x++ ){
			if ( itemsGroup[x] == control.value ){
				myEle = document.createElement("option") ;
				myEle.value = itemsValue[x];
				myEle.text = itemsText[x] ;
				controlToPopulate.add(myEle) ;
			}
		}
		controlToPopulate.focus();
	}

	function insRow1(){
		var x=document.getElementById('myTable1').insertRow(document.getElementById('myTable1').rows.length-1)
		var a=x.insertCell(0)
		var b=x.insertCell(1)
		var c=x.insertCell(2)
		var z=document.form1
		a.innerHTML='<input name="col11[]" type="hidden" value="'+z.technicid.value+'">'+z.technicid.options[z.technicid.selectedIndex].text;
		b.innerHTML='<input name="col10[]" type="hidden" value="'+z.technicdate.value+'">'+z.technicdate.value
		c.innerHTML='<input type="button" value="ลบ" onClick="deleteRow(this.parentNode.parentNode.rowIndex,1)">'
		x.style.backgroundColor="#FFFFFF"
		z.technicid.value=""
		z.technicdate.value=""
	}
	
	function insRow2(){
		var x=document.getElementById('myTable2').insertRow(document.getElementById('myTable2').rows.length-1);
		var a=x.insertCell(0);
		var b=x.insertCell(1);
		var c=x.insertCell(2);
		var z=document.form1;
		a.innerHTML='<input name="col12[]" type="hidden" value="'+z.timeno.value+'">'+z.timeno.value;
		b.innerHTML='<input name="col13[]" type="hidden" value="'+z.timestart.value+'">'+z.timestart.value+' ถึง <input name="col14[]" type="hidden" value="'+z.timeend.value+'">'+z.timeend.value;
		c.innerHTML='<input type="button" value="ลบ" onClick="deleteRow(this.parentNode.parentNode.rowIndex,2)">';
		x.style.backgroundColor="#FFFFFF";
		z.timeno.value="";
		z.timestart.value="";
		z.timeend.value="";
	}

	function deleteRow(i,tname){
		document.getElementById('myTable'+tname).deleteRow(i)
	}

	function xNum2(obj,key){
		ret=false;
		if( (key>=48 && key<=57) || key==46 ){
			ret=true;
		}
		return ret;
	}

	function windowOpen() {
		var width=650;
		var height=500;
		var left=parseInt((screen.availWidth/2)-(width/2));
		var top=parseInt((screen.availHeight/2)-(height/2));
		var windowFeatures="width="+width+",height="+height+",scrollbars,resizable,left="+left+",top="+top+",screenX="+left+",screenY="+top;
		var linkfile="viewperiod.php";
		myWindow=window.open(linkfile+'?empid='+document.getElementById('empid').value,'win1',windowFeatures);
		if (!myWindow.opener) myWindow.opener = self;
	}
</script>
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
            <td> 
              <? createlist("typeid,typename","mttype","",$row['worktype'],"worktype","")?>            </td>
            <td align="right">เลขประจำตำแหน่ง</td>
            <td align="center">:</td>
            <td><input name="workid" type="text" size="10"  value="<?=$row["workid"]?>"></td>
          </tr>
          <tr> 
            <td align="right">วันบรรจุ</td>
            <td align="center">:</td>
            <td> <input name="workindate" type="text" id="workindate" value="<?=bc2be($row["workindate"],false)?>" size="8"> 
              <img src="../image/calendar.jpg" alt="เลือกวันที่" id="cmdworkindate" style="cursor:hand">            </td>
            <td align="right">อายุงาน</td>
            <td align="center">:</td>
            <td><input type="text" name="workage" size="5" value="<?=$workage?>"></td>
          </tr>
          <tr>
            <td align="right">โอนย้าย</td>
            <td align="center">:</td>
            <td><input name="worktransfer" type="text" id="worktransfer" value="<?=bc2be($row["worktransfer"],false)?>" size="8">
              <img src="../image/calendar.jpg" alt="เลือกวันที่" id="cmdworktransfer" style="cursor:hand"></td>
            <td align="right">ครบ 25 ปี</td>
            <td align="center">:</td>
            <td><input type="text" name="text1" size="10" value="<?=$text1?>" readonly></td>
          </tr>
          <tr> 
            <td align="right">เกษียณอายุราชการ</td>
            <td align="center">:</td>
            <td><input type="text" name="text2" size="10" value="<?=$text2?>" readonly></td>
            <td align="right">ครบ 65 ปี</td>
            <td align="center">:</td>
            <td><input type="text" name="text3" size="10" value="<?=$text3?>" readonly>
(ต่ออายุราชการ)</td>
          </tr>
          <tr>
            <td align="right">วันบรรจุเป็นอาจารย์</td>
            <td align="center">:</td>
            <td><input name="workappoint" type="text" id="workappoint" value="<?=bc2be($row["workappoint"],false)?>" size="8">
              <img src="../image/calendar.jpg" alt="เลือกวันที่" id="cmdworkappoint" style="cursor:hand"></td>
            <td align="right">มีมติรับเป็น<br>
            อาจารย์ภาควิชาฯ</td>
            <td align="center">:</td>
            <td><input name="workvote" type="text" id="workvote" value="<?=bc2be($row["workvote"],false)?>" size="8">
              <img src="../image/calendar.jpg" alt="เลือกวันที่" id="cmdworkvote" style="cursor:hand"></td>
          </tr>
          <tr> 
            <td align="right" valign="top">ระยะเวลาการจ้าง</td>
            <td align="center" valign="top">:</td>
            <td colspan="4"><table id="myTable2" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
              <tr style="background-color:#FFFFCC; color:#006666; font-weight:bold">
                <td align="center">ครั้งที่</td>
                <td align="center">ระยะเวลาการจ้าง</td>
                <td align="center">#</td>
              </tr>
              <?
			while($row4 = mysql_fetch_array($result4)){
			?>
              <tr bgcolor="#FFFFFF">
                <td><input name="col12[]" type="hidden" value="<?=$row4["timeno"]?>">
                    <?=$row4["timeno"]?></td>
                <td><input name="col13[]" type="hidden" value="<?=bc2be($row4["timestart"],false)?>">
                    <input name="col14[]" type="hidden" value="<?=bc2be($row4["timeend"],false)?>">
                  <?=bc2be($row4["timestart"],false).' ถึง '.bc2be($row4["timeend"],false)?>
                </td>
                <td align="center"><input name="button2" type="button" onClick="deleteRow(this.parentNode.parentNode.rowIndex,2)" value="ลบ"></td>
              </tr>
              <?
			}
			?>
              <tr bgcolor="#E0E0FF">
                <td><input type="text" name="timeno" size="2"></td>
                <td><input name="timestart" type="text" id="timestart" size="8">
                    <img src="../image/calendar.jpg" alt="เลือกวันที่" id="cmdtimestart" style="cursor:hand">&nbsp;ถึง&nbsp;
                    <input name="timeend" type="text" id="timeend" size="8">
                    <img src="../image/calendar.jpg" alt="เลือกวันที่" id="cmdtimeend" style="cursor:hand"></td>
                <td><input name="button2" type="button" onClick="insRow2()" value="เพิ่ม"></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="right">ระดับ</td>
            <td align="center">:</td>
            <td><input name="worksalarylevel" type="text" size="5"  value="<?=$level<=0?"":$level?>"></td>
            <td align="right">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td align="right">เงินเดือน</td>
            <td align="center">:</td>
            <td><input name="worksalary" type="text" size="10"  value="<?=$salary<=0?"":number_format($salary)?>" onKeyPress="return  xNum2(this,window.event.keyCode)"></td>
            <td align="right">เงินประจำตำแหน่ง</td>
            <td align="center">:</td>
            <td><input name="worksalarypos" type="text" size="10"  value="<?=$row["worksalarypos"]<=0?"":number_format($row["worksalarypos"])?>" onKeyPress="return  xNum2(this,window.event.keyCode)"></td>
          </tr>
          <tr> 
            <td align="right">ตำแหน่ง</td>
            <td align="center">:</td>
            <td colspan="4"> <select name="positiontype" onChange="selectChange(this, form1.workposition)">
                <option value=""> -- เลือกสาย -- </option>
                <option value="1" <? if($row["positiontype"]=="1") echo "selected"?>>สายวิชาการ 
                (ก)</option>
                <option value="2" <? if($row["positiontype"]=="2") echo "selected"?>>สายสนับสนุนวิชาการ 
                (ข)</option>
                <option value="3" <? if($row["positiontype"]=="3") echo "selected"?>>สายสนับสนุนวิชาการ 
                (ค)</option>
              </select> 
              <? createlist("positionid,positionname","mtposition","where positiontype='".$row["positiontype"]."' order by positionname",$row['workposition'],"workposition","")?>            </td>
          </tr>
          <tr>
            <td align="right" valign="top">ตำแหน่งทางวิชาการ</td>
            <td align="center" valign="top">:</td>
            <td colspan="4"><table id="myTable1" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
              <tr style="background-color:#FFFFCC; color:#006666; font-weight:bold">
                <td align="center">ตำแหน่งทางวิชาการ</td>
                <td align="center">ดำรงตำแหน่ง</td>
                <td align="center">#</td>
              </tr>
              <?
			while($row1 = mysql_fetch_array($result1)){
			?>
              <tr bgcolor="#FFFFFF">
                <td><input name="col11[]" type="hidden" value="<?=$row1["technicid"]?>">
                    <?=$row1["technicname"]?>                </td>
                <td><input name="col10[]" type="hidden" value="<?=bc2be($row1["technicdate"],false)?>">
                    <?=bc2be($row1["technicdate"],false)?>                </td>
                <td align="center"><input name="button" type="button" onClick="deleteRow(this.parentNode.parentNode.rowIndex,1)" value="ลบ"></td>
              </tr>
              <?
			}
			?>
              <tr bgcolor="#E0E0FF">
                <td><? createlist("technicid,technicname","mttechnic","","","technicid","")?>                </td>
                <td><input name="technicdate" type="text" id="technicdate" size="8">
                    <img src="../image/calendar.jpg" alt="เลือกวันที่" id="cmdtechnicdate" style="cursor:hand"></td>
                <td><input name="button" type="button" onClick="insRow1()" value="เพิ่ม"></td>
              </tr>
            </table></td>
          </tr>          
          <tr> 
            <td align="right">สาขาวิชา</td>
            <td align="center">:</td>
            <td colspan="4"> 
              <? createlist("unitid,unitname","tbjobunit","order by unitid",$row["workunit"],"workunit","")?>            </td>
          </tr>
          <tr> 
            <td align="right">สถานที่ทำงาน</td>
            <td align="center">:</td>
            <td colspan="4"> 
              <? createlist("placeid,placename","mtplace","",$row["workplace"],"workplace","")?>            </td>
          </tr>
          <tr> 
            <td align="right">โทรศัพท์</td>
            <td align="center">:</td>
            <td><input name="worktel" type="text" size="20"  value="<?= $row["worktel"]?>"></td>
            <td align="right">โทรสาร</td>
            <td align="center">:</td>
            <td><input name="workfax" type="text" size="20"  value="<?= $row["workfax"]?>"></td>
          </tr>          
          <tr> 
            <td align="right" valign="top">เวลาปฏิบัติงาน</td>
            <td align="center" valign="top">:</td>
            <td colspan="4" valign="top"><input name="workoperate1" id="workoperate1" type="text" value="<?=substr($row["workoperate1"],0,5)?>" size="5">
              -
            <input name="workoperate2" id="workoperate2" type="text" value="<?=substr($row["workoperate2"],0,5)?>" size="5"></td>
          </tr>
          <tr> 
            <td align="right" valign="top">หมายเหตุ</td>
            <td align="center" valign="top">:</td>
            <td colspan="4" valign="top"><textarea name="workremark" cols="60" rows="3" id="workremark"><?=$row["workremark"]?>
	    </textarea></td>
          </tr>
          <tr align="center"> 
            <td colspan="6"> <br> <button type="submit" name="save"><img src="../image/upload-page-blue.gif" width="14" height="14">&nbsp;บันทึก</button>
              <button type="reset"><img src="../image/checkout-blue.gif">&nbsp;ยกเลิก</button>
              <button onClick="location='printwork.php?empid=<?=$_GET["empid"]?>'"><img src="../image/printer-blue.gif">&nbsp;พิมพ์              </button></td>
          </tr>
        </table>
	</form>
	</td>
  </tr>
</table>
</body>
</html>
<script type="text/javascript">
	Calendar.setup({ inputField:"workindate",displayArea:"desktop",button:"cmdworkindate"});
	Calendar.setup({ inputField:"worktransfer",displayArea:"desktop",button:"cmdworktransfer"});
	Calendar.setup({ inputField:"workappoint",displayArea:"desktop",button:"cmdworkappoint"});
	Calendar.setup({ inputField:"technicdate",displayArea:"desktop",button:"cmdtechnicdate"});
	Calendar.setup({ inputField:"workvote",displayArea:"desktop",button:"cmdworkvote"});
	Calendar.setup({ inputField:"timestart",displayArea:"desktop",button:"cmdtimestart"});
	Calendar.setup({ inputField:"timeend",displayArea:"desktop",button:"cmdtimeend"});
</script>