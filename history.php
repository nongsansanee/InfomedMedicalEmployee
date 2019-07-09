<?php
	session_start();
	require("../inc/function.php");
	$sql="select empid,empname,empsname,empengname,empengsname,emppic from tbemployee where empid='".$_GET["empid"]."'";
	$db_conn = new core_mysql ();
	$result = $db_conn->query ($sql);
	$row = mysql_fetch_array($result);
	if($_GET["flag"]=="1") $fname=""; else $fname="show";
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<title>เมนูประวัติ</title>
<script src="../object/aw.js"></script>
<link href="../object/xp/aw.css" rel="stylesheet"></link>
<link href="../object/mini.css" rel="stylesheet"></link>
<link href="../Skin/style.css" rel="stylesheet" type="text/css">
<style>
	body {font: 12px Tahoma}
	table {font: 12px Tahoma}
	#myTabs {width: 100%}
</style>

</head>

<body>
	<form method="post" name="form1">
	<table align="center">
  <tr class="BIG">
    <td colspan="2" align="center">ประวัติบุคลากร      </td>
    </tr>
  <tr>
    <td valign="bottom"><img id="img" src="<?=$row["emppic"]?>" width="119" height="156" border="1" style="border-color:#0066CC"></td>
    <td valign="bottom">
	<table>
      <tr>
        <td>รหัสพนักงาน</td>
        <td>:</td>
        <td><input name="empid" type="text" value="<?=$row["empid"]?>" size="20" readonly></td>
      </tr>
      <tr>
        <td>ชื่อ - สกุล </td>
        <td>:</td>
        <td><input name="empname" type="text" value="<?=$row["empname"]."  ".$row["empsname"]?>"  size="50" readonly></td>
      </tr>
      <tr>
        <td>ชื่อ - สกุล(อังกฤษ)</td>
        <td>:</td>
        <td><input name="empengname" type="text" value="<?=$row["empengname"]."  ".$row["empengsname"]?>"  size="50" readonly></td>
      </tr>
    </table>	</td>
    </tr>
</table>

	</form>
	<span id="myTabs"></span>
	<iframe id="myContent" style="border: 1px solid #aaa; width:100%; height:500px" frameborder=no></iframe>
<script>
	var fpage="<?=isset($_GET["fpage"])?$_GET["fpage"]:0?>";
	var f="<?=$fname?>";
	var e=document.form1.empid.value;
	var names = ["ประวัติส่วนตัว", "ประวัติการทำงาน", "วุฒิการศึกษา", "ประวัติการลาศึกษา/ฝึกอบรม", "ประวัติการรับราชการ", "ประวัติการรับเครื่องราชฯ", "ประวัติเกียรติยศ", "ตำแหน่งบริหาร"];
	var values = [f+"private.php?empid="+e, f+"work.php?empid="+e, f+"education.php?empid="+e, f+"train.php?empid="+e, f+"goverment.php?empid="+e, f+"class.php?empid="+e, f+"reward.php?empid="+e, "position.php?empid="+e];
	var tabs = new AW.UI.Tabs;
	tabs.setId("myTabs");
	tabs.setItemText(names);
	tabs.setItemValue(values); // store page URLs in the 'value' property.
	tabs.setItemCount(8);
	tabs.refresh();
	tabs.onSelectedItemsChanged = function(selected){
		var index = selected[0];
		var value = this.getItemValue(index);
		window.status = index + ": " + value;
		document.getElementById("myContent").src = value; // iframe URL
	}
	tabs.setSelectedItems([fpage]); // load the first page.
</script>

</body>
</html>