<?
session_start();
require("../inc/function.php");
require("../theme1/theme.php");
$db_conn = new core_mysql ();
$empid=$_GET["empid"];
if($_GET["chk"]=='d'){
	$sql="delete from tbempperiod where id = ".$_GET["id"];
	$result = $db_conn->query ($sql);
}
if(!empty($_POST["save"])){
	$empid=$_POST["empid"];
	$periodstart=be2bc($_POST["periodstart"]);
	$periodstop=be2bc($_POST["periodstop"]);
	if($filedoc!=""){
		$periodpic = addslashes(fread(fopen($filedoc,  "rb"), filesize($filedoc)));
		$periodpro=$filedoc_name.":".$filedoc_size.":".$filedoc_type;
		$upfield=", `periodpic` , `periodpro` ";
		$upvalue=",'$periodpic', '$periodpro'";
	}
	$sql="INSERT INTO `tbempperiod` ( `id` , `empid` , `periodstart` , `periodstop` $upfield) VALUES ('', '$empid', '$periodstart', '$periodstop'$upvalue)";
	$result = $db_conn->query ($sql);
}
$sql="SELECT id,periodstart,periodstop,periodpic,periodpro FROM tbempperiod WHERE empid='$empid' order by periodstart desc";
$result = $db_conn->query ($sql);
?>
<html>
<head>
	<title>ข้อมูลระยะเวลาการจ้าง</title>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-874">	
	<script type="text/javascript" src="../inc/statushide.js"></script>
    <link href="../Skin/style.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="../inc/jquery.js"></script>
	<script type="text/javascript" src="../inc/jquery.maskedinput.js"></script>
	<script type="text/javascript" src="../calendar/calendar.js"></script>
	<script type="text/javascript" src="../calendar/calendar-setup.js"></script>
	<script type="text/javascript" src="../calendar/calendar-th.js"></script>
	<style type="text/css"> @import url(../calendar/calendar-blue.css); </style>
	<script language="JavaScript">
		jQuery(function($){
		   $("#periodstart").mask("99/99/9999");
		   $("#periodstop").mask("99/99/9999");
		})

		function confirmbox(){
			var agree = confirm("ยืนยันการยกเลิกข้อมูลระยะเวลาการจ้างนี้.   ");
			return agree;
		} 

		function validate(e){
			if(e.periodstart.value==""){
				alert("เลือกวันที่เริ่มก่อนบันทึก");
				e.periodstart.focus();
				return false;
			}
			if(e.periodstop.value==""){
				alert("เลือกวันที่สิ้นสุดก่อนบันทึก");
				e.periodstop.focus();
				return false;
			}
		}
	</script>
</head>

<body>
<form method="post" enctype="multipart/form-data" name="form1" onSubmit="return validate(this)">
<input name="empid" type="hidden" value="<?=$empid?>">
<? openframe1("ข้อมูลระยะเวลาการจ้าง");?>
<table width="100%" border="0" cellspacing="1" bgcolor="#000000">
  <tr class="tablehead">
    <td colspan="3">ระยะเวลาการจ้าง</td>
    <td rowspan="2">จัดการ</td>
  </tr>
  <tr class="tablehead">
    <td>วันที่เริ่ม</td>
    <td>วันที่สิ้นสุด</td>
    <td>ไฟล์แนบ</td>
    </tr>
  <tr class="tabledetail5">
	  <td align="center"><input name="periodstart" id="periodstart" type="text" size="8"><img src="../image/calendar.jpg" alt="เลือกวันที่" id="cmdperiodstart" style="cursor:hand"></td>
	  <td align="center"><input name="periodstop" id="periodstop" type="text" size="8"><img src="../image/calendar.jpg" alt="เลือกวันที่" id="cmdperiodstop" style="cursor:hand"></td>
	  <td align="center"><input type="file" name="filedoc"></td>
	  <td align="center"><button type="submit" name="save"><img src="../image/add-page-green.gif">&nbsp;เพิ่มข้อมูล</button></td>
	</tr>	
<?
	$classname="tabledetail5";
	while($row=mysql_fetch_array($result)){
		$doc=explode(":",$row[4]);
		$classname=($classname=="tabledetail5")?"tabledetail3":"tabledetail5";
?>
  <tr class="<?=$classname?>">
    <td align="center"><?=bc2be($row[1],false)?></td>
    <td><?=bc2be($row[2],false)?></td>
    <td><? if($row[3]!="") echo '<a href="showdoc.php?fieldname=period&tablename=tbempperiod&id='.$row[0].'" target="_blank">'.$doc[0].'</a>';?></td>
    <td align="center"><a href="viewperiod.php?empid=<?=$empid?>&chk=d&id=<?=$row[0]?>" onClick="return confirmbox();"><img src="../image/del.gif"  border="0">ยกเลิก</a></td>
  </tr>
<? }?>
</table>
<? tablebreak();?>
<table width="100%" cellspacing="0">
  <tr>
    <td class="infobar1">&nbsp;</td>
  </tr>
</table>
<? closeframe1();?>
</form>
</body>
</html>
<script type="text/javascript">
	Calendar.setup({ inputField:"periodstart",displayArea:"desktop",button:"cmdperiodstart"});
	Calendar.setup({ inputField:"periodstop",displayArea:"desktop",button:"cmdperiodstop"});
</script>