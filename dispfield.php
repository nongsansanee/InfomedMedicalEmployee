<?
session_start();
require("../inc/function.php");
require("../theme1/theme.php");
define("THEME","../theme1/",true);

if($_POST["check1"]) $cond=" and b.worktype='".$_POST["worktype"]."'";
if($_POST["check2"]){
	if(!empty($_POST["positiontype"])) $cond.=" and b.positiontype='".$_POST["positiontype"]."'";
	if(!empty($_POST["workposition"])) $cond.=" and b.workposition='".$_POST["workposition"]."'";
}
if($_POST["check3"]){
	$date1=$_POST["workvote"];
	$cond.=" and YEAR(b.workvote)='$date1'";
}
if($_POST["check3"]){
	$date1=$_POST["workvote"];
	$cond.=" and YEAR(b.workvote)='$date1'";
}
if($_POST["check4"]){
	$date1=$_POST["workend"];
	$cond.=" and a.empid in (SELECT DISTINCT empid FROM tbemptime WHERE $date1 BETWEEN YEAR(timestart) AND YEAR(timeend) ORDER BY timeno DESC)";
}
if($_POST["check5"]) $cond.=" and if(day(a.empbirthday)>1 and month(a.empbirthday)>9,year(a.empbirthday)+61,year(a.empbirthday)+60)='".$_POST["select1"]."'";
if($_POST["check6"]) $cond.=" and (YEAR(b.workindate)+25)='".$_POST["select2"]."'";
if($_POST["check7"]){
	if($_POST["chkuser"]=='1') $cond.=empty($_POST["d2"])?" and b.positiontype='1'":" and a.empid='".$_POST["d2"]."'";
	else $cond.=empty($_POST["d3"])?" and b.positiontype!='1'":" and a.empid='".$_POST["d3"]."'"; 
}			
if($_POST["check8"]) $cond.=" and b.workunit='".$_POST["d1"]."'";
if($_POST["check9"]) $cond.=" and if(day(a.empbirthday)>1 and month(a.empbirthday)>9,year(a.empbirthday)+66,year(a.empbirthday)+65)='".$_POST["select3"]."'";
$arrfield1 = array("a.empid","a.emprank","a.empengrank","a.emprankname","a.empengrankname","CONCAT(a.empname,'  ',a.empsname)","CONCAT(a.empengname,'  ',a.empengsname)");
$arrtitle1 = array("���ʾ�ѡ�ҹ","�ӹ�˹�Ҫ��� (��)","�ӹ�˹�Ҫ��� (�ѧ���)","��/���˹� (��)","��/���˹� (�ѧ���)","����-ʡ�� (��)","����-ʡ�� (�ѧ���)");
$arrfield2 = array("CONCAT(day(a.empbirthday),'/',month(a.empbirthday),'/',year(a.empbirthday)+543)","DATE_FORMAT( NOW( ) , '%Y' ) - DATE_FORMAT( `empbirthday` , '%Y' ) - ( DATE_FORMAT( NOW( ) , '00-%m-%d' ) < DATE_FORMAT( `empbirthday` , '00-%m-%d' ) ) AS Age","case a.empsex when '1' then '���' when '2' then '˭ԧ' else '' end","a.emprace","a.empnation","a.empreligion","a.empmary","a.empspouse","a.empaddress","a.empcurrent","a.emptel","a.empmobile","a.empemergency","a.empemail","a.emppid","a.empcardid","a.empremark");
$arrtitle2 = array("�ѹ ��͹ �� �Դ","����","��","���ͪҵ�","�ѭ�ҵ�","	��ʹ�","ʶҹ�Ҿ����","�������","�������������¹��ҹ","�������Ѩ�غѹ","���Ѿ��","��Ͷ��","�ء�Թ(�Դ���)","�������","�����Ţ��Шӵ�ǻ�ЪҪ�","�Ţ����͹حҵ��Сͺ�ä��Ż�","�����˵�");
$arrfield3 = array("(select typename from mttype where typeid=b.worktype)","b.workid","CONCAT(day(b.workindate),'/',month(b.workindate),'/',year(b.workindate)+543)","DATE_FORMAT( NOW( ) , '%Y' ) - DATE_FORMAT( `workindate` , '%Y' ) - ( DATE_FORMAT( NOW( ) , '00-%m-%d' ) < DATE_FORMAT( `workindate` , '00-%m-%d' ) ) AS workage","CONCAT(day(b.worktransfer),'/',month(b.worktransfer),'/',year(b.worktransfer)+543)","CONCAT(day(b.workappoint),'/',month(b.workappoint),'/',year(b.workappoint)+543)","CONCAT(day(b.workindate),'/',month(b.workindate),'/',year(b.workindate)+568)","CONCAT('01/10/',if(day(a.empbirthday)>1 and month(a.empbirthday)>9,year(a.empbirthday)+604,year(a.empbirthday)+603))","CONCAT('01/10/',if(day(a.empbirthday)>1 and month(a.empbirthday)>9,year(a.empbirthday)+609,year(a.empbirthday)+608))","(select govlevel from tbempgoverment where empid=b.empid order by govdate desc limit  1)","(select govstep from tbempgoverment where empid=b.empid order by govdate desc limit  1)","b.worksalarypos","(select positionname from mtposition where positionid=b.workposition)","CONCAT(day(b.workvote),'/',month(b.workvote),'/',year(b.workvote)+543)","CONCAT(substring(b.workoperate1,1,5),'-',substring(b.workoperate2,1,5))","(select unitname from tbjobunit where unitid=b.workunit)","(select placename from mtplace where placeid=b.workplace)","b.worktel","b.workremark");
$arrtitle3 = array("��������è�ҧ","�Ţ��Шӵ��˹�","�ѹ��è�","���اҹ","�͹����","�ѹ��è����Ҩ����","�ú 25 ��","���³�����Ҫ���","�ú 65 ��","�дѺ","�Թ��͹","�Թ��Шӵ��˹�","���˹�","������Ѻ���Ҩ�����Ҥ�Ԫ��","���һ�Ժѵԧҹ","�Ң��Ԫ�","ʶҹ���ӧҹ","���Ѿ��","�����˵�");
$employee = $_POST["employee"];
$private = $_POST["private"];
$work = $_POST["work"];
$count1 = count($employee);
$count2 = count($private);
$count3 = count($work);
if($count1>0){
	foreach($employee as $value){
		$col .= "<td align='center'>$arrtitle1[$value]</td>";
		$field .= ",".$arrfield1[$value];
	}
}
if($count2>0){
	foreach($private as $value){
		$col .= "<td align='center'>$arrtitle2[$value]</td>";
		$field .= ",".$arrfield2[$value];
	}
}
if($count3>0){
	foreach($work as $value){
		$col .= "<td align='center'>$arrtitle3[$value]</td>";
		$field .= ",".$arrfield3[$value];
		echo $field;
	}
}
$width="100%";
$total=$count1+$count2+$count3;
if($total>10) $width=$total*100;
$sql= "SELECT a.empid as id$field FROM tbemployee a left join tbempwork b on a.empid=b.empid where a.empflag='1'$cond";
echo $sql;
$db_conn = new core_mysql ();
$result = $db_conn->query ($sql);
?>

<html>
<head>
	<title>�����źؤ�ҡ�</title>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-874">	
	<script type="text/javascript" src="../inc/statushide.js"></script>
    <link href="../Skin/style.css" rel="stylesheet" type="text/css">
</head>

<body>
<form method="post" name="form1">
<input name="empflag" type="hidden" value="<?=$empflag?>">

<?
	$detail=$_POST["detail"];
	echo "<table width='$width' border='0' cellspacing='1' bgcolor='#000000'>";
	echo "<tr class='tablehead'>$col</tr>";
	while($row=mysql_fetch_assoc($result)) {
		echo "<tr class='tabledetail5'>";
		$n=0;
		foreach($row as $col){
			if($n>0) echo "<td>$col</td>";
			$n++;
		}
		echo "</tr>";
		if(isset($detail)){
			$n--;
			echo "<tr class='tabledetail5'>";
			echo "<td>&nbsp;</td>";
			echo "<td colspan='$n'>";
			foreach($detail as $value){
				if($value=="0"){
					$sql="select * from tbempeducation where empid='".$row["id"]."' order by eduyear";
					$resultd = $db_conn->query ($sql);
					$ahead = array("�زԡ���֡��","�زԡ���֡��(���)","ʶҹ�֡��","�����","�շ�診����֡��","��蹷��");
					$edu=$_POST["edu"];
					$vhead="";
					foreach($edu as $key) $vhead.="<td align='center'>".$ahead[$key]."</td>";
					echo "<table border='1' style='border-collapse:collapse; border-color:#CCCCCC'>";
					echo "<tr class='tabledetail2'><td align='center' colspan='6'>�زԡ���֡��</td></tr>";
					echo "<tr class='tabledetail3'>$vhead</tr>";
					while($rowd = mysql_fetch_assoc($resultd)){
						$afield = array("<td>".$rowd["education"]."</td>","<td>".$rowd["seducation"]."</td>","<td>".$rowd["eduplace"]."</td>","<td align='center'>".$rowd["educountry"]."</td>","<td align='center'>".$rowd["eduyear"]."</td>","<td align='center'>".$rowd["eduversion"]."</td>");
						$vfield="";
						foreach($edu as $key) $vfield.=$afield[$key];
						echo "<tr class='tabledetail5'>$vfield</tr>";
					}
					echo "</table>";
				}
				if($value=="1"){
					$sql="select * from tbemptrain where empid='".$row["id"]."' order by id";
					$resultd = $db_conn->query ($sql);
					$ahead = array("�����������","��ѡ�ٵ�","��������","ʶҹ�֡��","�����","�ع","������ҳ");
					$trn=$_POST["trn"];
					$vhead="";
					foreach($trn as $key) $vhead.="<td align='center'>".$ahead[$key]."</td>";
					echo "<table border='1' style='border-collapse:collapse; border-color:#CCCCCC'>";
					echo "<tr class='tabledetail2'><td align='center' colspan='7'>����ѵԡ�����֡��/�֡ͺ��</td></tr>";
					echo "<tr class='tabledetail3'>$vhead</tr>";
					$ntype=array("���֡�ҵ�͵�ҧ�����","���֡�ҵ��㹻����","�ҽ֡ͺ����ҧ�����","�ҽ֡ͺ��㹻����");
					while($rowd = mysql_fetch_assoc($resultd)){
						$afield = array("<td>".$ntype[$rowd["traintype"]-1]."</td>","<td>".$rowd["traincourse"]."</td>","<td align='center'>".bc2be($rowd["trainstart"],false)."  �֧  ".bc2be($rowd["trainend"],false)."</td>","<td>".$rowd["trainplace"]."</td>","<td>".$rowd["traincountry"]."</td>","<td>".$rowd["traincapital"]."</td>","<td align='right'>".number_format($rowd["trainbudget"],2)."</td>");
						$vfield="";
						foreach($trn as $key) $vfield.=$afield[$key];
						echo "<tr class='tabledetail5'>$vfield</tr>";
					}
					echo "</table>";
				}
				if($value=="2"){
					$sql="select * from tbempgoverment where empid='".$row["id"]."' order by govdate";
					$resultd = $db_conn->query ($sql);
					$ahead = array("�ѹ���","���˹�","�дѺ","����Թ��͹","�ӹǹ��鹷�����͹","���/��з�ǧ");
					$gov=$_POST["gov"];
					$vhead="";
					foreach($gov as $key) $vhead.="<td align='center'>".$ahead[$key]."</td>";
					echo "<table border='1' style='border-collapse:collapse; border-color:#CCCCCC'>";
					echo "<tr class='tabledetail2'><td align='center' colspan='7'>����ѵԡ���Ѻ�Ҫ���</td></tr>";
					echo "<tr class='tabledetail3'>$vhead</tr>";
					while($rowd = mysql_fetch_assoc($resultd)){
						$afield = array("<td align='center'>".bc2be($rowd["govdate"],false)."</td>","<td>".$rowd["govposition"]."</td>","<td align='center'>".$rowd["govlevel"]."</td>","<td align='right'>".number_format($rowd["govstep"])."</td>","<td align='center'>".$rowd["govamount"]."</td>","<td>".$rowd["govunit"]."</td>");
						$vfield="";
						foreach($gov as $key) $vfield.=$afield[$key];
						echo "<tr class='tabledetail5'>$vfield</tr>";
					}
					echo "</table>";
				}
				if($value=="3"){
					$sql="select * from tbempclass where empid='".$row["id"]."' order by classdate";
					$resultd = $db_conn->query ($sql);
					$ahead = array("�ѹ���","����ͧ�Ҫ��������ó�","���˹�","�дѺ","���","�ѹ������Ѻ","�ѹ���׹");
					$cls=$_POST["cls"];
					$vhead="";
					foreach($cls as $key) $vhead.="<td align='center'>".$ahead[$key]."</td>";
					echo "<table border='1' style='border-collapse:collapse; border-color:#CCCCCC'>";
					echo "<tr class='tabledetail2'><td align='center' colspan='7'>����ѵԡ���Ѻ����ͧ�Ҫ�</td></tr>";
					echo "<tr class='tabledetail3'>$vhead</tr>";
					while($rowd = mysql_fetch_assoc($resultd)){
						$afield = array("<td align='center'>".bc2be($rowd["classdate"],false)."</td>","<td>".$rowd["classname"]."</td>","<td>".$rowd["classposition"]."</td>","<td align='center'>".$rowd["classlevel"]."</td>","<td align='center'>".$rowd["classstep"]."</td>","<td align='center'>".bc2be($rowd["classget"],false)."</td>","<td align='center'>".bc2be($rowd["classreturn"],false)."</td>");
						$vfield="";
						foreach($cls as $key) $vfield.=$afield[$key];
						echo "<tr class='tabledetail5'>$vfield</tr>";
					}
					echo "</table>";
				}
				if($value=="4"){
					$sql="select * from tbempreward where empid='".$row["id"]."' order by rewardyear";
					$resultd = $db_conn->query ($sql);
					$ahead = array("�.�.","���õ���","˹��§ҹ����ͺ�ҧ���");
					$rwd=$_POST["rwd"];
					$vhead="";
					foreach($rwd as $key) $vhead.="<td align='center'>".$ahead[$key]."</td>";
					echo "<table border='1' style='border-collapse:collapse; border-color:#CCCCCC'>";
					echo "<tr class='tabledetail2'><td align='center' colspan='7'>����ѵ����õ���</td></tr>";
					echo "<tr class='tabledetail3'>$vhead</tr>";
					while($rowd = mysql_fetch_assoc($resultd)){
						$afield = array("<td align='center'>".$rowd["rewardyear"]."</td>","<td>".$rowd["reward"]."</td>","<td>".$rowd["rewardunit"]."</td>");
						$vfield="";
						foreach($rwd as $key) $vfield.=$afield[$key];
						echo "<tr class='tabledetail5'>$vfield</tr>";
					}
					echo "</table>";
				}
				if($value=="5"){
					$sql="select a.id,b.groupname,a.position,a.datestart,a.datestop,a.status from tbmanagedetail a left join tbmanageposition b on a.id=b.id where a.empid='".$row["id"]."' order by a.datestart desc";
					$resultd = $db_conn->query ($sql);
					$ahead = array("���ͤ�С������","���˹觺�����","�������ҵ��˹�");
					$pos=$_POST["pos"];
					$vhead="";
					foreach($pos as $key) $vhead.="<td align='center'>".$ahead[$key]."</td>";
					echo "<table border='1' style='border-collapse:collapse; border-color:#CCCCCC'>";
					echo "<tr class='tabledetail2'><td align='center' colspan='7'>���˹觺�����</td></tr>";
					echo "<tr class='tabledetail3'>$vhead</tr>";
					while($rowd = mysql_fetch_assoc($resultd)){
						$afield = array("<td>".$rowd["groupname"]."</td>","<td>".$rowd["position"]."</td>","<td>".bc2be($rowd["datestart"],false)."-".bc2be($rowd["datestop"],false)."</td>");
						$vfield="";
						foreach($pos as $key) $vfield.=$afield[$key];
						echo "<tr class='tabledetail5'>$vfield</tr>";
					}
					echo "</table>";
				}
				if($value=="6"){
					$sql="select a.technicid,b.technicname,a.technicdate from tbemptechnic a left join mttechnic b on a.technicid=b.technicid where a.empid='".$row["id"]."' order by a.technicdate desc";
					$resultd = $db_conn->query ($sql);
					$ahead = array("���˹觷ҧ�Ԫҡ��","��ç���˹�","");
					$tec=$_POST["tec"];
					$vhead="";
					foreach($tec as $key) $vhead.="<td align='center'>".$ahead[$key]."</td>";
					echo "<table border='1' style='border-collapse:collapse; border-color:#CCCCCC'>";
					echo "<tr class='tabledetail2'><td align='center' colspan='7'>���˹觷ҧ�Ԫҡ��</td></tr>";
					echo "<tr class='tabledetail3'>$vhead</tr>";
					while($rowd = mysql_fetch_assoc($resultd)){
						$afield = array("<td>".$rowd["technicname"]."</td>","<td>".bc2be($rowd["technicdate"],false)."</td>");
						$vfield="";
						foreach($tec as $key) $vfield.=$afield[$key];
						echo "<tr class='tabledetail5'>$vfield</tr>";
					}
					echo "</table>";
				}
			}
			echo "</td>";
			echo "</tr>";
		}
	}
	echo "</table>";
?>
</form>
</body>
</html>