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
$pdf->Cell(0,10,'ประวัติส่วนตัว',0,1,'C');
$pdf->SetFont('CordiaNew','',16); 
$pdf->Cell(0,10,'ชื่อ-สกุล : '.$row["emprank"].'  '.$row["empname"].'  '.$row["empsname"],0,1);
$pdf->Cell(0,10,'ชื่อ-สกุล(อังกฤษ) : '.$row["empengrank"].'  '.$row["empengname"].'  '.$row["empengsname"],0,1);
$pdf->Cell(0,10,'วัน เดือน ปี เกิด : '.bc2be($row["empbirthday"],false),0,1);
if($row["empsex"]=="1") $sex="ชาย"; else if($row["empsex"]=="2") $sex="หญิง";
$pdf->Cell(0,10,'เพศ : '.$sex,0,1);
$pdf->Cell(0,10,'เชื้อชาติ : '.$row["emprace"],0,1);
$pdf->Cell(0,10,'สัญชาติ : '.$row["empnation"],0,1);
$pdf->Cell(0,10,'ศาสนา : '.$row["empreligion"],0,1);
$pdf->Cell(0,10,'สถานภาพสมรส : '.$row["empmary"],0,1);
$pdf->Cell(0,10,'คู่สมรส : '.$row["empspouse"],0,1);
$pdf->MultiCell(0,10,'ที่อยู่ ตามทะเบียนบ้าน : '.$row["empaddress"],0);
$pdf->MultiCell(0,10,'ที่อยู่ ปัจจุบัน : '.$row["empcurrent"],0);
$pdf->Cell(0,10,'โทรศัพท์ : '.$row["emptel"],0,1);
$pdf->Cell(0,10,'มือถือ : '.$row["empmobile"],0,1);
$pdf->Cell(0,10,'ฉุกเฉิน(ติดต่อ) : '.$row["empemergency"],0,1);
$pdf->Cell(0,10,'อีเมลล์ : '.$row["empemail"],0,1);
$pdf->Cell(0,10,'หมายเลขประจำตัวประชาชน : '.$row["emppid"],0,1);
$pdf->Cell(0,10,'เลขที่ใบอนุญาตประกอบโรคศิลป์ : '.$row["empcardid"],0,1);
$pdf->Ln(7);
$pdf->SetFont('CordiaNew','B',16);
$pdf->Cell(20,7,"หมายเหตุ : ");
$pdf->SetFont('CordiaNew','',16);
$pdf->MultiCell(0,7,"กรุณาตรวจสอบ แก้ไขและกรอกข้อมูลให้ครบ พร้อมทั้งแนบเอกสารต่อไปนี้ เพื่อจะสแกนและแนบไว้ในฐานข้อมูล",0,1);
$pdf->Cell(20,7,"");
$pdf->Cell(0,7,"1. สำเนาทะเบียนบ้าน",0,1);
$pdf->Cell(20,7,"");
$pdf->Cell(0,7,"2. สำเนาบัตรประจำตัวประชาชน",0,1);
$pdf->Cell(20,7,"");
$pdf->Cell(0,7,"3. สำเนาใบอนุญาตประกอบวิชาชีพเวชกรรม (ใบประกอบโรคศิลป์)");

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
