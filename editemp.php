<?php
session_start();
require("../inc/function.php");
require("../theme1/theme.php");
$db_conn = new core_mysql ();
if (isset($_POST["save"])){
	$empid=$_POST["empid"];
	$emprank=$_POST["emprank"];
	$emprankname=$_POST["emprankname"];
	$empengrankname=$_POST["empengrankname"];
	$empengrank=$_POST["empengrank"];
	$empname=$_POST["empname"];
	$empsname=$_POST["empsname"];
	$empengname=$_POST["empengname"];
	$empengsname=$_POST["empengsname"];
	$empflag=$_POST["empflag"];
	$datein=date("Y-m-d H:i:s");
	$userin=$myauth["userin"];
	$emptype=$_POST["emptype"];
	$d1=$_POST["d1"];
	if ($_POST["chk"]=="a"){
		$picture = addslashes(fread(fopen($emppicture,  "rb"), filesize($emppicture)));
		$sql="INSERT INTO `tbemployee` ( `empid` , `emprankname` , `empengrankname` , `emprank` , `empname` , `empsname` , `empengrank` , `empengname` , `empengsname` , `emppicture` , `empflag` , `datein` , `userin` ) ";
		$sql.="VALUES ('$empid', '$emprankname', '$empengrankname', '$emprank', '$empname', '$empsname', '$empengrank', '$empengname', '$empengsname', '$picture', '$empflag', '$datein', '$userin' )";
		$result = $db_conn->query ($sql);
		msgBox("�ѹ�֡���������º����","history.php?flag=1&empid=$empid");
	}
	else{
		$sql="UPDATE `tbemployee` SET `emprankname` = '$emprankname',`empengrankname` = '$empengrankname',`emprank` = '$emprank',`empname` = '$empname',`empsname` = '$empsname',`empengrank` = '$empengrank',`empengname` = '$empengname',";
		if($emppicture!=""){
			$picture = addslashes(fread(fopen($emppicture,  "rb"), filesize($emppicture)));
			$sql.="`empengsname` = '$empengsname',`emppicture` = '$picture' ,`empflag` = '$empflag' ,`datein` = '$datein' ,`userin` = '$userin' WHERE `empid` = '$empid' LIMIT 1 ";
		}else{
			$sql.="`empengsname` = '$empengsname',`empflag` = '$empflag' ,`datein` = '$datein' ,`userin` = '$userin' WHERE `empid` = '$empid' LIMIT 1 ";
		}
		$result = $db_conn->query ($sql);
		msgBox("�ѹ�֡���������º����","viewemp.php?empflag=$emptype&d1=$d1");
	}
}
$sql="select empid,emprank,empname,empsname from tbemployee where empid='".$_GET["empid"]."'";
$result = $db_conn->query ($sql);
$row = mysql_fetch_array($result);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<link rel="stylesheet" type="text/css" href="../Skin/style.css">
<title>������ʾ�ѡ�ҹ</title>
<script language="javascript">
function validate(e){
	if (e.empid.value==""){
		alert("��͡���ʾ�ѡ�ҹ��͹�ѹ�֡");
		e.empid.focus();
		return false;
	}
	if (e.empname.value==""){
		alert("��͡���;�ѡ�ҹ��͹�ѹ�֡");
		e.empname.focus();
		return false;
	}
	if (e.empsname.value==""){
		alert("��͡���ʡ�ž�ѡ�ҹ��͹�ѹ�֡");
		e.empsname.focus();
		return false;
	}
	if (e.empflag.value==""){
		alert("���͡ʶҹ�Ҿ��͹�ѹ�֡");
		e.empflag.focus();
		return false;
	}
	return true;
}
</script>
</head>

<body text="#000000" link="#9999CC" vlink="#FF66CC" alink="#FF0000" onLoad="document.form1.empid.focus();">
<form method="post" name="form1" onSubmit="return validate(this);">
<?
openframe2("������ʾ�ѡ�ҹ");
?>
  <table width="100%">
    
    <tr  class="SOME"> 
      <td><input name="empid" type="text" maxlength="20" size="20" value="<?=$row["empid"]?>" <?=$idreadonly?>></td>
    </tr>
    <tr class="SOME">
      <td>
        <? createlist("titlename as titleid,titlename","mttitle","",$row["emprankname"],"emprankname","")?>      </td>
    </tr>
    <tr class="SOME"> 
      <td>
        <? createlist("titleengname as titleid,titleengname","mttitle","where titleengname!=''",$row["empengrankname"],"empengrankname","")?>      </td>
    </tr>
    <tr class="SOME"> 
      <td> 
        <? createlist("rankname as rankid,rankname","mtrank","",$row["emprank"],"emprank","")?>
        <input name="empname" type="text" size="30" value="<?=$row["empname"]?>"> 
        <input name="empsname" type="text" size="30" value="<?=$row["empsname"]?>">      </td>
    </tr>
    <tr class="SOME"> 
      <td> 
        <? createlist("rankengname as rankid,rankengname","mtrank","",$row["empengrank"],"empengrank","")?>
        <input name="empengname" type="text" size="30"  value="<?=$row["empengname"];?>"> 
        <input name="empengsname" type="text" size="30"  value="<?=$row["empengsname"];?>">      </td>
    </tr>
    <tr class="SOME"> 
      <td><select name="empflag">
          <option value=""></option>
          <option value="1" <? if($row["empflag"]=="1") echo "selected";?>>��Ժѵԧҹ</option>
          <option value="2" <? if($row["empflag"]=="2") echo "selected";?>>���͡</option>
          <option value="3" <? if($row["empflag"]=="3") echo "selected";?>>���³����</option>
          <option value="4" <? if($row["empflag"]=="4") echo "selected";?>>˹��§ҹ</option>
          <option value="5" <? if($row["empflag"]=="5") echo "selected";?>>������</option>
          <option value="6" <? if($row["empflag"]=="6") echo "selected";?>>����֡��</option>
        </select> </td>
    </tr>
    <tr class="SOME"> 
      <td><input name="emppicture" type="file" size="40"></td>
    </tr>
    <tr class="SOME"> 
      <td>
        <? if(isset($row["emppicture"])) echo "* ����������¹�ٻ�Ҿ����ͧ���͡�ٻ�Ҿ���� (��ͧ�ٻ�Ҿ�����ҧ���) * ";?>      </td>
    </tr>
    <tr class="SOME2"> 
      <td align="center"> <br> <button type="submit" name="save"><img src="../image/upload-page-blue.gif">&nbsp;�ѹ�֡</button>
        <button onClick="location='viewemp.php?empflag='+emptype.value+'&d1='+d1.value"><img src="../image/left-blue.gif">&nbsp;��Ѻ��¡��</button></td>
    </tr>
  </table>
<?
closeframe2();
?>
</form>
</body>
</html>
<?php
function validate_form(&$err){
	$err = "";
	if(!is_uploaded_file($_FILES["emppicture"]["tmp_name"])){
		$err .= "������������� �˵ؼŤ�� ";
		if (($_FILES["emppicture"]["error"] == UPLOAD_ERR_INI_SIZE) or 
		    ($_FILES["emppicture"]["error"] == UPLOAD_ERR_FORM_SIZE))
			$err .= "����բ�Ҵ�˭���ҷ���˹�<br>";
		elseif ($_FILES["emppicture"]["error"] == UPLOAD_ERR_PARTIAL)
			$err .= "�����Ţͧ���١�������ú<br>";
		elseif ($_FILES["emppicture"]["error"] == UPLOAD_ERR_NO_FILE)
			$err .= "�س��������͡��������<br>";
	}
	else{
		define("MAX_SIZE", 500000);
		if ($_FILES["emppicture"]["size"] > MAX_SIZE)
			$err .= "���������� ������բ�Ҵ�˭���ҷ���˹�<br>";
		if (($_FILES["emppicture"]["type"] != "image/gif") and 
		    ($_FILES["emppicture"]["type"] != "image/jpeg") and
		    ($_FILES["emppicture"]["type"] != "image/pjpeg"))
			$err .= "���������� �����������������ٻẺ GIF ���� JPEG<br>";
	}
	if ($err)
		return false;
	else
		return true;
}
function process_form(){
	echo "���Ѻ��� {$_FILES['emppicture']['name']} ����<br>";
	echo "��Ҵ��� {$_FILES['emppicture']['size']} 亵�<br>";
	echo "MIME Type {$_FILES['emppicture']['type']} 亵�<br><br>";
	echo "";
}
?>
