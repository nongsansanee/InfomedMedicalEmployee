<?php
session_start();
require("../inc/function.php");
$db_conn = new core_mysql ();
if($_GET["chk"]=='d'){
	$sql="DELETE FROM `tbemptechnic` WHERE `id`='".$_GET["id"]."' LIMIT 1";
	$result = $db_conn->query ($sql);
}
$sql="select a.id,a.empid,b.technicname,a.technicdate from tbemptechnic a left join mttechnic b on a.technicid=b.technicid where a.empid='".$_GET["empid"]."' order by a.technicdate desc";
$result = $db_conn->query ($sql);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<script type="text/javascript" src="../inc/statushide.js"></script>
<title>�����ŵ��˹觷ҧ�Ԫҡ��</title>
<style>
	a:link {font-family: "MS SanSerif"; text-decoration: none; color: #000099}
	a:visited {font-family: "MS SanSerif"; text-decoration: none; color: #000099}
	a:hover {font-family: "MS SanSerif"; text-decoration: none; color: #000099}
	a:active {	font-family: "MS SanSerif"; text-decoration: none; color: #000099}
	body {font: 12px Tahoma}
	table {font: 12px Tahoma}
</style>
<script language="JavaScript">
	function confirmbox(){
		var agree = confirm("�׹�ѹ���¡��ԡ�����ŵ��˹觷ҧ�Ԫҡ�ù��.   ");
		return agree;
	} 
</script>
</head>

<body>
<table border="0" cellspacing="1" bgcolor="#CCCCCC" width="100%">
  <tr style="background-color:#FFFFCC; color:#006666; font-weight:bold" height="25">
    <td align="center">���˹觷ҧ�Ԫҡ��</td>
    <td align="center">��ç���˹������</td>
    <td width="120" align="center">#</td>
  </tr>
<?
	while($row = mysql_fetch_array($result)){
		$bgcolor=$bgcolor=="#E9E9E9"?"#FFFFFF":"#E9E9E9";
?>
  <tr bgcolor="<?=$bgcolor?>">
    <td><?=$row[2]?></td>
    <td align="center"><?=bc2be($row[3],false)?></td>
    <td align="center">
    <a href="addtechnic.php?chk=e&id=<?=$row[0]?>"><img src="../image/edit.gif" border="0">���</a>
	<a href="technic.php?chk=d&empid=<?=$row[1]?>&id=<?=$row[0]?>" onClick="return confirmbox();"><img src="../image/del.gif"  border="0">¡��ԡ</a>    </td>
  </tr>
<?}?>
  <tr bgcolor="#FFFFFF">
    <td colspan="3"><button onClick="location='addtechnic.php?chk=a&empid=<?=$_GET["empid"]?>'"><img src="../image/add-page-green.gif">&nbsp;����������</button></td>
  </tr>
</table>
</body>
</html>