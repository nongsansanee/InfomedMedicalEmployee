<?
session_start();
require("../inc/function.php");
require("../theme1/theme.php");
$db_conn = new core_mysql ();
if ($_GET["chk"]=='d'){
	$deltable=array("tbempclass","tbempeducation","tbempgoverment","tbemployee","tbempperiod","tbempreward","tbempson","tbemptechnic","tbemptime","tbemptrain","tbempwork");
	foreach($deltable as $table)
		$result = $db_conn->query ("delete from $table where empid = '".$_GET["empid"]."'");
}
$empflag=$_GET["empflag"];
$worktype=$_GET["worktype"];
$positiontype=$_GET["positiontype"];
$workposition=$_GET["workposition"];
$workunit=$_GET["workunit"];
$follow=$_GET["follow"];
$txtsearch=$_GET["txtsearch"];
if(!empty($_POST["btnsearch"])){
	$empflag=$_POST["empflag"];
	$worktype=$_POST["worktype"];
	$positiontype=$_POST["positiontype"];
	$workposition=$_POST["workposition"];
	$workunit=$_POST["workunit"];
	$follow=$_POST["follow"];
	$txtsearch=$_POST["txtsearch"];
}
if(!empty($worktype)) $cond = " and b.worktype='$worktype'";
if(empty($workposition)){
	if(!empty($positiontype)) $cond.= " and b.positiontype='$positiontype'";
}else{
	$cond.= " and b.workposition='$workposition'";
}
if($myauth[ugroup]=="3"){
	if(!empty($workunit)) $cond.= " and b.workunit='$workunit'";
}else{
	$cond.= " and b.workunit='$myauth[pworkunit]'";
}
if(!empty($txtsearch)) $cond.= " and a.$follow like '%$txtsearch%'";
$sql= "SELECT a.empid,CONCAT(if(a.emprankname!='',a.emprankname,a.emprank),' ',a.empname,'  ',a.empsname) as empname,CONCAT(a.empengname,'  ',a.empengsname) as empengname FROM tbemployee a left join tbempwork b on a.empid=b.empid where a.empflag='$empflag'$cond order by a.empname";
$db_conn = new core_mysql ();
$result = $db_conn->query ($sql);
?>

<html>
<head>
	<title>�����źؤ�ҡ�</title>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-874">	
	<script type="text/javascript" src="../inc/statushide.js"></script>
    <link href="../Skin/style.css" rel="stylesheet" type="text/css">
	<script language="JavaScript">
		var itemsGroup = new Array();
		var itemsValue = new Array();
		var itemsText = new Array();
		<?
		$sql="SELECT positiontype,positionid,positionname FROM mtposition order by positiontype,positionname";
		$result3 = $db_conn->query ($sql);
		while($row3=mysql_fetch_array($result3)){
			$x=$x+1;
			echo "x=".$x.";";
			echo "g='".$row3[0]."';";
			echo "v='".$row3[1]."';";
			echo "t='".$row3[2]."';";
			?>
			itemsGroup[x] = g;
			itemsValue[x] = v;
			itemsText[x] = t;
			<?
		} 
		?>

		function selectChange(control, controlToPopulate){
			var myEle ;
			var x ;
			for (var q=controlToPopulate.options.length;q>=0;q--) controlToPopulate.options[q]=null;
			myEle = document.createElement("option") ;
			myEle.value = "";
			myEle.text = "--- ���͡������ ---" ;
			controlToPopulate.add(myEle) ;
			for ( x = 0 ; x < itemsText.length  ; x++ ){
				if ( itemsGroup[x] == control.value ){
					myEle = document.createElement("option") ;
					myEle.value = itemsValue[x];
					myEle.text = itemsText[x] ;
					controlToPopulate.add(myEle) ;
				}
			}
			controlToPopulate.focus();
		}

		function confirmbox(){
			var agree = confirm("�׹�ѹ���¡��ԡ������ʶҹ�Ҿ���.   ");
			return agree;
		} 
	</script>
</head>

<body>
<form method="post" name="form1">
<input name="empflag" type="hidden" value="<?=$empflag?>">
<fieldset class="SOME"><legend>���͹�㹡�ä���</legend>
<table cellpadding="3" class="SOME">
  <tr>
    <td>��������è�ҧ</td>
    <td>:</td>
    <td><? createlist("typeid,typename","mttype","",$worktype,"worktype","","--- ���͡������ ---")?></td>
  </tr>
  <tr>
    <td>���˹�</td>
    <td>:</td>
    <td><select name="positiontype" onChange="selectChange(this, form1.workposition)">
      <option value=""> -- ���͡��� -- </option>
      <option value="1" <? if($positiontype=="1") echo "selected"?>>����Ԫҡ��&nbsp;(�)</option>
      <option value="2" <? if($positiontype=="2") echo "selected"?>>���ʹѺʹع�Ԫҡ��&nbsp;(�)</option>
      <option value="3" <? if($positiontype=="3") echo "selected"?>>���ʹѺʹع�Ԫҡ��&nbsp;(�)</option>
    </select>
      <? createlist("positionid,positionname","mtposition","where positiontype='".$positiontype."' order by positionid",$workposition,"workposition","","--- ���͡������ ---")?></td>
  </tr>
<? if($myauth[ugroup]=="3"){?>
  <tr>
    <td>˹��§ҹ</td>
    <td>:</td>
    <td><? createlist("unitid,unitname","tbjobunit","order by unitid",$workunit,"workunit","","--- ���͡������ ---");?></td>
  </tr>
<? }?>
  <tr>
    <td>���ҵ��</td>
    <td>:</td>
    <td><select name="follow">
      <option value="empid" <? if($follow=="empid") echo "selected"?>>����</option>
      <option value="empname" <? if($follow=="empname" || empty($follow)) echo "selected"?>>����</option>
      <option value="empsname" <? if($follow=="empsname") echo "selected"?>>���ʡ��</option>
    </select>
      <input name="txtsearch" type="text" size="35" value="<?=$txtsearch?>">
      <button type="submit" name="btnsearch"><img src="../image/search-blue.gif">&nbsp;����</button></td>
  </tr>
</table>
</fieldset>
<? openframe1("�����źؤ�ҡ�");?>
<table width="100%" border="0" cellspacing="1" bgcolor="#000000">
  <tr class="tablehead">
    <td>����</td>
    <td>���� - ʡ��(��)</td>
    <td>���� - ʡ��(�ѧ���)</td>
    <td>�Ѵ���</td>
  </tr>
  <? if($empflag=="1"){?>
  <tr>
	  <td colspan="3" class="tabledetail5"></td>
	  <td class="tabledetail5" align="center"><button onClick="location='addemp.php?chk=a&empflag=<?=$empflag?>&worktype=<?=$worktype?>&positiontype=<?=$positiontype?>&workposition=<?=$workposition?>&workunit=<?=$workunit?>&follow=<?=$follow?>&txtsearch=<?=$txtsearch?>'"><img src="../image/add-page-green.gif">&nbsp;����������</button></td>
	</tr>
<?
		$classname="tabledetail5";
	}
	while($row=mysql_fetch_array($result)) {
		$classname=($classname=="tabledetail5")?"tabledetail3":"tabledetail5";
?>
  <tr class="<?=$classname?>">
    <td align="center"><?=$row[0]?></td>
    <td><?=$row[1]?></td>
    <td><?=$row[2]?></td>
	<td align="center">
	  <a href="tranfer.php?empflag=<?=$empflag?>&empid=<?=$row[0]?>&worktype=<?=$worktype?>&positiontype=<?=$positiontype?>&workposition=<?=$workposition?>&workunit=<?=$workunit?>&follow=<?=$follow?>&txtsearch=<?=$txtsearch?>"><img src="../image/right-blue.gif" border="0">�͹����</a>
	  <a href="addemp.php?chk=e&empflag=<?=$empflag?>&empid=<?=$row[0]?>&worktype=<?=$worktype?>&positiontype=<?=$positiontype?>&workposition=<?=$workposition?>&workunit=<?=$workunit?>&follow=<?=$follow?>&txtsearch=<?=$txtsearch?>"><img src="../image/edit.gif" border="0">���</a> 
	  <a href="viewemp.php?chk=d&empflag=<?=$empflag?>&empid=<?=$row[0]?>&worktype=<?=$worktype?>&positiontype=<?=$positiontype?>&workposition=<?=$workposition?>&workunit=<?=$workunit?>&follow=<?=$follow?>&txtsearch=<?=$txtsearch?>" onClick="return confirmbox();"><img src="../image/del.gif"  border="0">¡��ԡ</a> 
	  <a href="history.php?flag=1&empid=<?=$row[0]?>" target="showFrame"><img src="../image/history.gif" border="0">����ѵ�</a> 
	</td>
  </tr>
<? }?>
</table>
<? tablebreak();?>
<table width="100%" cellspacing="0">
  <tr>
    <td class="infobar1">&nbsp;</td>
    <td class="infobar2">&nbsp;</td>
  </tr>
</table>
<? closeframe1();?>
</form>
</body>
</html>