<? 
session_start();
require("../inc/function.php");
require("../report/mc_table.php");

$sql="select * from tbempeducation where empid='".$_GET["empid"]."' order by eduyear";
$db_conn = new core_mysql ();
$result = $db_conn->query ($sql);

$pdf=new PDF_MC_Table('l','mm','A4');
//$pdf=new PDF();
$pdf->SetThaiFont();
$pdf->AddPage();
$pdf->SetFont('CordiaNew','B',16);
$pdf->Cell(0,10,'����ѵԡ���֡��',0,1,'C');
$pdf->SetFont('CordiaNew','',16); 
$pdf->Cell(0,10,'����-ʡ�� : '.getdata("emprank,empname,empsname","tbemployee","where empid='".$_GET['empid']."'"),0,1);
$pdf->SetWidths(array(95,55,95,25,10));
$pdf->SetAligns(array('C','C','C','C','C'));
$pdf->SetFont('CordiaNew','B',16);
$pdf->Row(array("�زԡ���֡��","�زԡ���֡��(���)","ʶҹ��診","�ա���֡��","��蹷��"));
$pdf->SetAligns(array('L','L','L','C','C'));
$pdf->SetFont('CordiaNew','',16);
while($row=mysql_fetch_array($result)) $pdf->Row(array($row["education"],$row["seducation"],$row["eduplace"],$row["eduyear"],$row["eduversion"]));
$pdf->Ln(7);
$pdf->SetFont('CordiaNew','B',16);
$pdf->Cell(20,7,"�����˵� : ");
$pdf->SetFont('CordiaNew','',16);
$pdf->MultiCell(0,7,"��سҵ�Ǩ�ͺ �����С�͡���������ú ��������Ṻ�͡��÷ء�زԡ���֡�� ���ͨ��᡹���Ṻ���㹰ҹ������");

$pdf->Output();
?>  