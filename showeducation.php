<?php
session_start();
require("../inc/function.php");
$sql="select * from tbempeducation where empid='".$_GET["empid"]."' order by eduyear desc";
$db_conn = new core_mysql ();
$result = $db_conn->query ($sql);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<script type="text/javascript" src="../inc/statushide.js"></script>
<title>�����Ż���ѵԡ���֡��</title>
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
 <table border="0" cellspacing="1" bgcolor="#CCCCCC" width="100%">
  <tr style="background-color:#FFFFCC; color:#006666; font-weight:bold" height="25">
    <td align="center">�زԡ���֡��</td>
    <td align="center">�زԡ���֡��(���)</td>
    <td align="center">ʶҹ�֡��</td>
    <td align="center">�����</td>
    <td align="center">�շ�診����֡��</td>
    <td align="center">��蹷��</td>
    <td align="center">�͡���Ṻ</td>
  </tr>
<?
	while($row = mysql_fetch_array($result)){
		$doc=explode(":",$row["edudocpro"]);
		$bgcolor=$bgcolor=="#E9E9E9"?"#FFFFFF":"#E9E9E9";
?>
  <tr bgcolor="<?=$bgcolor?>">
    <td><?=$row["education"]?></td>
	<td><?=$row["seducation"]?></td>
	<td><?=$row["eduplace"]?></td>
	<td><?=$row["educountry"]?></td>
	<td align="center"><?=$row["eduyear"]?></td>
	<td align="center"><?=$row["eduversion"]?></td>
	<td align="center"><?php if(!empty($row["edufile"])) echo " <a href='".$row["edufile"]."' target='_blank'>�͡���Ṻ</a>"?></td>
  </tr>
<?	}?>
  <tr bgcolor="#FFFFFF">
    <td colspan="8"><button onClick="location='printeducation.php?empid=<?=$_GET["empid"]?>'"><img src="../image/printer-blue.gif">&nbsp;����� </button></td>
  </tr>
</table>
</body>
</html>