<? 
session_start();
require("../inc/function.php");
require("../report/mc_table.php");

$empid=$_GET["empid"];
$sql= "SELECT * FROM tbempwork where empid='$empid'";
$db_conn = new core_mysql ();
$result = $db_conn->query ($sql);
$row=mysql_fetch_array($result);
$sql="select a.technicid,b.technicname,a.technicdate from tbemptechnic a left join mttechnic b on a.technicid=b.technicid where a.empid='$empid' order by a.technicdate desc";
$result1 = $db_conn->query ($sql);
$sql="select a.id,b.groupname,a.position,a.datestart,a.datestop,a.status from tbmanagedetail a left join tbmanageposition b on a.id=b.id where a.empid='$empid' order by a.datestart desc";
$result2 = $db_conn->query ($sql);

$pdf=new PDF_MC_Table();
$pdf->SetThaiFont();
$pdf->AddPage();
$pdf->SetFont('CordiaNew','B',16);
$pdf->Cell(0,10,'����ѵԡ�÷ӧҹ',0,1,'C');
$pdf->SetFont('CordiaNew','',16); 
$pdf->Cell(0,10,'����-ʡ�� : '.getdata("emprank,empname,empsname","tbemployee","where empid='".$row['empid']."'"),0,1);
$pdf->Cell(0,10,'��������è�ҧ : '.getdata("typename","mttype","where typeid='".$row['worktype']."'"),0,1);
$pdf->Cell(0,10,'�Ţ��Шӵ��˹� : '.$row["workid"],0,1);
$pdf->Cell(0,10,'�ѹ��è� : '.bc2be($row["workindate"],false),0,1);
$pdf->Cell(0,10,'�͹���� : '.bc2be($row["worktransfer"],false),0,1);
if(!empty($row["workindate"])){
	$arrdatetime=explode(" ",$row["workindate"]);
	$arrdate=explode("-",$arrdatetime[0]);
	$arrdate[0]=$arrdate[0]+568;
	$text1=$arrdate[2]."/".$arrdate[1]."/".$arrdate[0];
}
$birthday=getdata("empbirthday","tbemployee","where empid='$empid'");
if(!empty($birthday)) $text2="01/10/".(substr($birthday,0,4)+603);
$pdf->Cell(0,10,'�ú 25 ������� : '.$text1,0,1);
$pdf->Cell(0,10,'���³�����Ҫ�������� : '.$text2,0,1);
$pdf->Cell(0,10,'�������ҡ�è�ҧ : '.bc2be($row["workstart"],false).' �֧ '.bc2be($row["workend"],false),0,1);
$pdf->Cell(0,10,'�дѺ : '.$row["worksalarylevel"],0,1);
$pdf->Cell(0,10,'�Թ��͹ : '.number_format($row["worksalary"]),0,1);
$pdf->Cell(0,10,'�Թ��Шӵ��˹� : '.number_format($row["worksalarypos"]),0,1);
$pdf->Cell(0,10,'���˹� : '.getdata("positionname","mtposition","where positionid='".$row['workposition']."'"),0,1);
$pdf->Cell(0,10,'�Ҩ�����Ҥ�Ԫ��������ʵ��(Vote) : '.bc2be($row["workvote"],false),0,1);
$pdf->Cell(0,10,'���һ�Ժѵԧҹ : '.bc2be($row["workoperate"],false),0,1);
$pdf->Cell(0,10,'���˹觺����� : ',0,1);
$pdf->SetWidths(array(75,75,45));
$pdf->SetAligns(array('C','C','C'));
$pdf->SetFont('CordiaNew','B',16);
$pdf->Row(array("���ͤ�С������","���˹觺�����","�������ҵ��˹�"));
$pdf->SetAligns(array('L','L','C'));
$pdf->SetFont('CordiaNew','',16);
while($row2 = mysql_fetch_array($result2)) $pdf->Row(array($row2[1],$row2[2],bc2be($row2[3],false)."-".bc2be($row2[4],false)));
$pdf->Cell(0,10,'���˹觷ҧ�Ԫҡ�� :',0,1);
$pdf->SetWidths(array(90,45));
$pdf->SetAligns(array('C','C'));
$pdf->SetFont('CordiaNew','B',16);
$pdf->Row(array("���˹觷ҧ�Ԫҡ��","��ç���˹������"));
$pdf->SetAligns(array('L','C'));
$pdf->SetFont('CordiaNew','',16);
while($row1 = mysql_fetch_array($result1)) $pdf->Row(array($row1["technicname"],bc2be($row1["technicdate"],false)));
$pdf->Cell(0,10,'�Ң��Ԫ� : '.getdata("unitname","tbjobunit","where unitid='".$row['workunit']."'"),0,1);
$pdf->Cell(0,10,'ʶҹ���ӧҹ : '.getdata("placename","mtplace","where placeid='".$row['workplace']."'"),0,1);
$pdf->Cell(0,10,'���Ѿ�� : '.$row["worktel"],0,1);

$pdf->Output();
?>  