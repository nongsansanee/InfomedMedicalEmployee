<? 
session_start();
require('../ThaiPDF/thaipdfclass.php');
require("../inc/function.php");

$sql= "SELECT * FROM tbemployee where empid='".$_GET["empid"]."'";
$db_conn = new core_mysql ();
$result = $db_conn->query ($sql);
$row=mysql_fetch_array($result);

$pdf=new ThaiPDF();
$pdf->SetThaiFont();
$pdf->AddPage();
$pdf->SetFont('CordiaNew','B',16);
$pdf->Cell(0,10,'����ѵ���ǹ���',0,1,'C');
$pdf->SetFont('CordiaNew','',16); 
$pdf->Cell(0,10,'����-ʡ�� : '.$row["emprank"].'  '.$row["empname"].'  '.$row["empsname"],0,1);
$pdf->Cell(0,10,'����-ʡ��(�ѧ���) : '.$row["empengrank"].'  '.$row["empengname"].'  '.$row["empengsname"],0,1);
$pdf->Cell(0,10,'�ѹ ��͹ �� �Դ : '.bc2be($row["empbirthday"],false),0,1);
if($row["empsex"]=="1") $sex="���"; else if($row["empsex"]=="2") $sex="˭ԧ";
$pdf->Cell(0,10,'�� : '.$sex,0,1);
$pdf->Cell(0,10,'���ͪҵ� : '.$row["emprace"],0,1);
$pdf->Cell(0,10,'�ѭ�ҵ� : '.$row["empnation"],0,1);
$pdf->Cell(0,10,'��ʹ� : '.$row["empreligion"],0,1);
$pdf->Cell(0,10,'ʶҹ�Ҿ���� : '.$row["empmary"],0,1);
$pdf->Cell(0,10,'������� : '.$row["empspouse"],0,1);
$pdf->MultiCell(0,10,'������� �������¹��ҹ : '.$row["empaddress"],0);
$pdf->MultiCell(0,10,'������� �Ѩ�غѹ : '.$row["empcurrent"],0);
$pdf->Cell(0,10,'���Ѿ�� : '.$row["emptel"],0,1);
$pdf->Cell(0,10,'��Ͷ�� : '.$row["empmobile"],0,1);
$pdf->Cell(0,10,'�ء�Թ(�Դ���) : '.$row["empemergency"],0,1);
$pdf->Cell(0,10,'������� : '.$row["empemail"],0,1);
$pdf->Cell(0,10,'�����Ţ��Шӵ�ǻ�ЪҪ� : '.$row["emppid"],0,1);
$pdf->Cell(0,10,'�Ţ����͹حҵ��Сͺ�ä��Ż� : '.$row["empcardid"],0,1);
$pdf->Ln(7);
$pdf->SetFont('CordiaNew','B',16);
$pdf->Cell(20,7,"�����˵� : ");
$pdf->SetFont('CordiaNew','',16);
$pdf->MultiCell(0,7,"��سҵ�Ǩ�ͺ �����С�͡���������ú ��������Ṻ�͡��õ��仹�� ���ͨ��᡹���Ṻ���㹰ҹ������",0,1);
$pdf->Cell(20,7,"");
$pdf->Cell(0,7,"1. ���ҷ���¹��ҹ",0,1);
$pdf->Cell(20,7,"");
$pdf->Cell(0,7,"2. ���Һѵû�Шӵ�ǻ�ЪҪ�",0,1);
$pdf->Cell(20,7,"");
$pdf->Cell(0,7,"3. �����͹حҵ��Сͺ�ԪҪվ�Ǫ���� (㺻�Сͺ�ä��Ż�)");

$pdf->Output();
exit;
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>Untitled Document</title>
</head>

<body>
</body>
</html>
