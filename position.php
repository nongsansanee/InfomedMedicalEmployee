<?
session_start();
require("../inc/function.php");
$db_conn = new core_mysql ();
$empid=$_GET["empid"];
$sql="select a.id,b.groupname,a.position,a.datestart,a.datestop,a.status from tbmanagedetail a left join tbmanageposition b on a.id=b.id where a.empid='$empid' order by a.datestart desc";
$result = $db_conn->query ($sql);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>ตำแหน่งบริหาร</title>
<style>
	body {font: 12px Tahoma}
	table {font: 12px Tahoma}
</style>
</head>

<body>
<table border="0" cellspacing="1" bgcolor="#CCCCCC" width="100%">
  <tr style="background-color:#FFFFCC; color:#006666; font-weight:bold" height="25">
    <td align="center">ชื่อคณะกรรมการ</td>
    <td align="center">ตำแหน่งบริหาร</td>
    <td align="center">ระยะเวลาตำแหน่ง</td>
  </tr>
<?
while($row = mysql_fetch_array($result)){
	$bgcolor=$bgcolor=="#E9E9E9"?"#FFFFFF":"#E9E9E9";
?>
  <tr bgcolor="<?=$bgcolor?>">
    <td><?=$row[1]?></td>
    <td><?=$row[2]?></td>
    <td><?=bc2be($row[3],false)."-".bc2be($row[4],false)?></td>
  </tr>
<?
}
?>
</table>
</body>
</html>
