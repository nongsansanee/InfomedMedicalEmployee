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
$pdf->Cell(0,10,'ประวัติการทำงาน',0,1,'C');
$pdf->SetFont('CordiaNew','',16); 
$pdf->Cell(0,10,'ชื่อ-สกุล : '.getdata("emprank,empname,empsname","tbemployee","where empid='".$row['empid']."'"),0,1);
$pdf->Cell(0,10,'ประเภทการจ้าง : '.getdata("typename","mttype","where typeid='".$row['worktype']."'"),0,1);
$pdf->Cell(0,10,'เลขประจำตำแหน่ง : '.$row["workid"],0,1);
$pdf->Cell(0,10,'วันบรรจุ : '.bc2be($row["workindate"],false),0,1);
$pdf->Cell(0,10,'โอนย้าย : '.bc2be($row["worktransfer"],false),0,1);
if(!empty($row["workindate"])){
	$arrdatetime=explode(" ",$row["workindate"]);
	$arrdate=explode("-",$arrdatetime[0]);
	$arrdate[0]=$arrdate[0]+568;
	$text1=$arrdate[2]."/".$arrdate[1]."/".$arrdate[0];
}
$birthday=getdata("empbirthday","tbemployee","where empid='$empid'");
if(!empty($birthday)) $text2="01/10/".(substr($birthday,0,4)+603);
$pdf->Cell(0,10,'ครบ 25 ปีเมื่อ : '.$text1,0,1);
$pdf->Cell(0,10,'เกษียณอายุราชการเมื่อ : '.$text2,0,1);
$pdf->Cell(0,10,'ระยะเวลาการจ้าง : '.bc2be($row["workstart"],false).' ถึง '.bc2be($row["workend"],false),0,1);
$pdf->Cell(0,10,'ระดับ : '.$row["worksalarylevel"],0,1);
$pdf->Cell(0,10,'เงินเดือน : '.number_format($row["worksalary"]),0,1);
$pdf->Cell(0,10,'เงินประจำตำแหน่ง : '.number_format($row["worksalarypos"]),0,1);
$pdf->Cell(0,10,'ตำแหน่ง : '.getdata("positionname","mtposition","where positionid='".$row['workposition']."'"),0,1);
$pdf->Cell(0,10,'อาจารย์ภาควิชาอายุรศาสตร์(Vote) : '.bc2be($row["workvote"],false),0,1);
$pdf->Cell(0,10,'เวลาปฏิบัติงาน : '.bc2be($row["workoperate"],false),0,1);
$pdf->Cell(0,10,'ตำแหน่งบริหาร : ',0,1);
$pdf->SetWidths(array(75,75,45));
$pdf->SetAligns(array('C','C','C'));
$pdf->SetFont('CordiaNew','B',16);
$pdf->Row(array("ชื่อคณะกรรมการ","ตำแหน่งบริหาร","ระยะเวลาตำแหน่ง"));
$pdf->SetAligns(array('L','L','C'));
$pdf->SetFont('CordiaNew','',16);
while($row2 = mysql_fetch_array($result2)) $pdf->Row(array($row2[1],$row2[2],bc2be($row2[3],false)."-".bc2be($row2[4],false)));
$pdf->Cell(0,10,'ตำแหน่งทางวิชาการ :',0,1);
$pdf->SetWidths(array(90,45));
$pdf->SetAligns(array('C','C'));
$pdf->SetFont('CordiaNew','B',16);
$pdf->Row(array("ตำแหน่งทางวิชาการ","ดำรงตำแหน่งเมื่อ"));
$pdf->SetAligns(array('L','C'));
$pdf->SetFont('CordiaNew','',16);
while($row1 = mysql_fetch_array($result1)) $pdf->Row(array($row1["technicname"],bc2be($row1["technicdate"],false)));
$pdf->Cell(0,10,'สาขาวิชา : '.getdata("unitname","tbjobunit","where unitid='".$row['workunit']."'"),0,1);
$pdf->Cell(0,10,'สถานที่ทำงาน : '.getdata("placename","mtplace","where placeid='".$row['workplace']."'"),0,1);
$pdf->Cell(0,10,'โทรศัพท์ : '.$row["worktel"],0,1);

$pdf->Output();
?>  