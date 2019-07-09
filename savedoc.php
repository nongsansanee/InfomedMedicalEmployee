<?php
session_start();
require("../inc/function.php");
require("../theme1/theme.php");
define("THEME","../theme1/",true);
if (isset($_POST["save"])){
	$empid=$_POST["empid"];
	$fieldpic=$_POST["upfield"]."pic";
	$fieldpro=$_POST["upfield"]."pro";
	$property=$filedoc_name.":".$filedoc_size.":".$filedoc_type;
	$updoc = addslashes(fread(fopen($filedoc,  "rb"), filesize($filedoc)));
	$sql="UPDATE `tbemployee` SET `$fieldpic` = '$updoc', `$fieldpro` = '$property' WHERE `empid` = '$empid' LIMIT 1";
	$db_conn = new core_mysql ();
	$result = $db_conn->query ($sql);
	$load='onLoad="updateOpener()"';
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<title>เอกสารแนบ</title>
<script type="text/javascript" src="../inc/statushide.js"></script>
<link href="../Skin/style.css" rel="stylesheet" type="text/css">
<script language="javascript">
	function updateOpener() {
		self.close();
		var e=document.form1;
		var chtml='<a href="privatedoc.php?empid='+e.empid.value+'&fieldname='+e.upfield.value+'" target="_blank">แสดงเอกสาร</a>';
		if (e.upfield.value=="empaddr") self.opener.view1.innerHTML=chtml;
		if (e.upfield.value=="emppid") self.opener.view2.innerHTML=chtml;
		if (e.upfield.value=="empsocial") self.opener.view3.innerHTML=chtml;
		if (e.upfield.value=="empcard") self.opener.view4.innerHTML=chtml;
		if (e.upfield.value=="empmary") self.opener.view5.innerHTML=chtml;
	}
	
	function validate(e){
		if(e.filedoc.value==""){
			alert("เลือกไฟล์ที่จะแนบก่อนแนบไฟล์");
			e.filedoc.focus();
			return false;
		}
	}
</script>
</head>

<body <?=$load?>>
<form name="form1" method="post" enctype="multipart/form-data" onSubmit="return validate(this);">
<input name="empid" type="hidden" value="<?=$_GET["empid"]?>">
<input name="upfield" type="hidden" value="<?=$_GET["upfield"]?>">
<? openframe2("เอกสารแนบ");?>
<table width="100%">
  <tr class="SOME"> 
    <td align="right">เอกสาร  :</td>
    <td><input name="filedoc" type="file" size="50"></td>
  </tr>
  <tr> 
    <td colspan="2" align="center">
    <input name="save" type="submit" id="save" value="::   แนบไฟล์   ::">
    <input name="back" type="button" value= "::   ปิดหน้าต่าง  ::"  onClick="window.close()">
    </td>
  </tr>
</table>
<? closeframe2();?>
</form>			
</body>
</html>