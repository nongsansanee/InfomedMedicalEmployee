<?
session_start();
require("../inc/function.php");
$db_conn = new core_mysql ();
$sql="select a.id,b.groupname,a.position,a.datestart,a.datestop,a.status from tbmanagedetail a left join tbmanageposition b on a.id=b.id where a.empid='$empid' order by a.datestart desc";
$result2 = $db_conn->query ($sql);
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
<form name="form1" method="post">
<div>
  <div align="center" style="height:30px"><strong>ตำแหน่งบริหาร</strong></div>
</div>
<table border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC" align="center">
  <tr style="background-color:#FFFFCC; color:#006666; font-weight:bold">
    <td align="center">ชื่อคณะกรรมการ</td>
    <td align="center">ตำแหน่งบริหาร</td>
    <td align="center">ระยะเวลาตำแหน่ง</td>
  </tr>
<?
while($row2 = mysql_fetch_array($result2)){
	$backtr=$backtr=="#DFDFDF"?"#FFFFFF":"#DFDFDF";
?>
  <tr bgcolor="<?=$backtr?>">
    <td><?=$row2[1]?></td>
    <td><?=$row2[2]?></td>
    <td><?=bc2be($row2[3],false)."-".bc2be($row2[4],false)?></td>
  </tr>
<?
}
?>
</table>
</form>
</body>
</html>
