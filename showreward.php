<?php
session_start();
require("../inc/function.php");
$db_conn = new core_mysql ();
$sql="select * from tbempreward where empid='".$_GET["empid"]."' order by rewardyear";
$result = $db_conn->query ($sql);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<title>�����Ż���ѵ����õ���</title>
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
    <td align="center">�.�.</td>
    <td align="center">���õ���</td>
    <td align="center">˹��§ҹ����ͺ�ҧ���</td>
    <td align="center">�дѺ</td>
  </tr>
<?
	$alevel=array("1"=>"�дѺ�ҵ�","2"=>"�дѺ�ҹҪҵ�");
	while($row = mysql_fetch_array($result)){
		$bgcolor=$bgcolor=="#E9E9E9"?"#FFFFFF":"#E9E9E9";
?>
  <tr bgcolor="<?=$bgcolor?>">
    <td align="center"><?=$row["rewardyear"]?></td>
    <td><?=$row["reward"]?></td>
    <td><?=$row["rewardunit"]?></td>
    <td><?=$alevel[$row["rewardlevel"]]?></td>
  </tr>
<?}?>
</table>
</body>
</html>