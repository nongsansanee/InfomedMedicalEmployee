<?php
session_start();
require("../inc/function.php");
require("../theme1/theme.php");
$db_conn = new core_mysql ();
if (isset($_POST["save"])){
	$empid=$_POST["empid"];
	if (validate_image($err,"emppic")){
		$filename = basename($_FILES["emppic"]["name"]);
		list($name,$sname) = explode(".",$filename);
		$uploadfile = "../emppic/u$empid.$sname";
		//echo "uploadfile=".$uploadfile;
		$upFileName = "u$empid.$sname";
		if (move_uploaded_file($_FILES["emppic"]["tmp_name"], $uploadfile)){
			echo "����ö�ѹ�֡�ٻ�Ҿ��";
				//fopen($image, 'r')
				/********************Send Data To WEB MED  by call API addEmp (sansanee 010762)***********************************/
			//	$url = 'https://www.si.mahidol.ac.th/department/Medicine/home/api/apiUpImg3.asp';
			//	$data_img = "sapid=".$empid."&file1=".$emppic;
				//$data_img = "action=1&sapid=".$empid;
				//$data_img = fopen($uploadfile, "rb");
				
			//	echo "DATA=".$data_img."<br>";
				//msgBox($data);
			//	$options = array(
			//		'http' => array(
			//	 	'header'  => "Content-type: multipart/form-data\r\n",
			//	 	'method'  => 'POST',
			//	 	'content' => $data_img,
			//	 	),
			//	 );
			//	$context  = stream_context_create($options);
			//	$result = file_get_contents($url, false, $context);
			//	 echo "11111111111";
				// $fp = fopen($url, 'rb', false, $context);
				// echo "2222222222";

				// $response = stream_get_contents($fp);

				// echo "ssssssss";
				//$uploadfile = "../emppic/u98765411.jpg";

				//echo "<br>uploadfile".$uploadfile."<br>";
			//	$fileHandle = fopen($uploadfile, "rb");
				//echo "fileHandle".$fileHandle."<br>";
				?>
				 <!-- <img  src="<?php echo $uploadfile ?>" width="80" height="100" border="1" style="border-color:#0066CC" -->
				<?php

			//	$fileContents = stream_get_contents($fileHandle);
				//fclose($fileHandle);
				// $data_img = "sapid=".$empid."&file1=".$fileContents;

				// echo "DATA=".$data_img."<br>";
			

				 //application/x-www-form-urlencoded
				 //multipart/form-data
				//$params = array(
				 //  'http' => array
				 //  (
				//	   'method' => 'POST',
				//	   'header'=>"Content-Type: multipart/form-data\r\n",
				//	   'content' => $data_img
				//   )
				//);
				//$url = "https://www.si.mahidol.ac.th/department/Medicine/home/api/apiUpImg4.asp";
				//$ctx = stream_context_create($params);
			
				//--$fp = fopen($url, 'rb', false, $ctx);
				//$result = file_get_contents($url, false, $ctx);
				//$response = stream_get_contents($fp);

				//--START FTP   SUCCESS 
				//$ftp_server = "10.7.101.43";
				//$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
				//$login = ftp_login($ftp_conn, "simed", "mhcne5");

				//-- then do something...
				//echo "uploadfile=".$uploadfile;
			
				//$remode_file = "emppic/".$upFileName;

				//-- upload file
				//if (ftp_put($ftp_conn, $remode_file, $uploadfile, FTP_BINARY))
				//{
				//	echo " and Successfully uploaded $file.";
				//}
				//else
				//{
				//	echo " and Error uploading $file.";
				//}

				//-- close connection
				//ftp_close($ftp_conn); 

				//--END FTP SUCCESS


				//-------------------CURL  not success
				
				//$cfile = curl_file_create('../emppic/u98765412.jpg','image/jpeg','testpic');
				//--error  Call to undefined function curl_file_create() 
				//$cfile = new CURLFile('../emppic/u98765412.jpg','image/jpeg','testpic');
				//$imgdata = array('myimage' => $cfile);

				//$target ="https://www.si.mahidol.ac.th/department/Medicine/home/api/apiUpImg4.asp";

				//$ch = curl_init();
				//curl_setopt($curl, CURLOPT_URL, $target);
				//curl_setopt($curl, CURLOPT_USERAGENT,'Opera/9.80 (Windows NT 6.2; Win64; x64) Presto/2.12.388 Version/12.15');
				//curl_setopt($curl, CURLOPT_HTTPHEADER,array('User-Agent: Opera/9.80 (Windows NT 6.2; Win64; x64) Presto/2.12.388 Version/12.15','Referer: http://someaddress.tld','Content-Type: multipart/form-data'));
				//curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // stop verifying certificate
				//curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
				//curl_setopt($curl, CURLOPT_POST, true); // enable posting
				//curl_setopt($curl, CURLOPT_POSTFIELDS, $imgdata); // post images 
				//curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); // if any redirection after upload
				//$ch = curl_exec($curl); 
				//curl_close($curl);
			   
				//--CURL ex2   SUCCESS
				//$ch = curl_init('https://www.si.mahidol.ac.th/department/Medicine/home/api/apiUpImg4.asp');

				//$file_name = $uploadfile;
				//echo "uploadfile=".$uploadfile;
				//echo "empid=".$empid;
				$cFile = '@'. realpath($uploadfile);
				$data = array('sapid' => $empid , 'file1' => $cFile);
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL,"https://www.si.mahidol.ac.th/department/Medicine/home/api/apiUpImg.asp");
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); //add veriry ssl
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$server_output = curl_exec($ch);
				echo curl_exec($ch);
				curl_close ($ch);

			//	echo "upload success=".$result;
		}else{
			$uploadfile = "";
			echo "�������ö�ѹ�֡�ٻ�Ҿ��";
		}
	}else{
		$uploadfile = "";
		echo "<font color='red'><b>�Դ��ͼԴ��Ҵ</b><br>";
		echo $err."</font>";
	}
	$emprank=$_POST["emprank"];
	$emprankname=$_POST["emprankname"];
	$empengrankname=$_POST["empengrankname"];
	$empengrank=$_POST["empengrank"];
	$empname=$_POST["empname"];
	$empsname=$_POST["empsname"];
	$empengname=$_POST["empengname"];
	$empengsname=$_POST["empengsname"];
	$empflag=$_POST["empflag"];
	$empleave=be2bc($_POST["empleave"]);
	$datein=date("Y-m-d H:i:s");
	$userin=$myauth["userin"];
	$emptype=$_POST["emptype"];
	$worktype=$_POST["worktype"];
	$positiontype=$_POST["positiontype"];
	$workposition=$_POST["workposition"];
	$workunit=$_POST["workunit"];
	$follow=$_POST["follow"];
	$txtsearch=$_POST["txtsearch"];
	
	if ($_POST["chk"]=="a"){
		$sql = "SELECT count(*) FROM tbemployee WHERE empid='$empid'";
		$result = $db_conn->query ($sql);
		$row = mysql_fetch_array($result);
		if($row[0]>0){
        	msgBox("��ѡ�ҹ�����ӡ�úѹ�֡�������,�������ö�ѹ�֡�����Ź����","addemp.php?chk=a&empflag=$emptype&worktype=$worktype&positiontype=$positiontype&workposition=$workposition&workunit=$workunit&follow=$follow&txtsearch=$txtsearch");
		}else{
			$sql="INSERT INTO `tbemployee` ( `empid` , `emprankname` , `empengrankname` , `emprank` , `empname` , `empsname` , `empengrank` , `empengname` , ";
			$sql.="`empengsname` , `emppic` , `empflag` , `empleave` , `datein` , `userin` ) VALUES ('$empid', '$emprankname', '$empengrankname', '$emprank', '$empname', '$empsname', ";
			$sql.="'$empengrank', '$empengname', '$empengsname', '$uploadfile', '$empflag', '$empleave', '$datein', '$userin' )";
			$result = $db_conn->query ($sql);
			//msgBox("�ѹ�֡���������º����","history.php?flag=1&empid=$empid&fpage=1");
		}
	
	
		
		/********************Send Data To WEB MED  by call API addEmp (sansanee 010762)***********************************/
		$url = 'https://www.si.mahidol.ac.th/department/Medicine/home/api/addEmp.asp';
		$data = "action=1&sapid=".$empid."&title=".$emprank."&positiondesc=".$emprankname."&fname=".$empname."&mname=&lname=".$empsname."&title_eng=".$empengrank."&fname_eng=".$empengname."&mname_eng=&lname_eng=".$empengsname."&userin=".$userin."&empflag=".$empflag;
		//echo "DATA=".$data."<br>";
		//msgBox($data);
		$options = array(
			'http' => array(
			'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			'method'  => 'POST',
			'content' => $data,
			),
		);
		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
		
		 msgBox("�ѹ�֡���������º����","history.php?flag=1&empid=$empid&fpage=1");
	}
	else{
		if(!empty($uploadfile)) $upfile="`emppic` = '$uploadfile' ,";
		$sql="UPDATE `tbemployee` SET `emprankname` = '$emprankname',`empengrankname` = '$empengrankname',`emprank` = '$emprank',`empname` = '$empname',`empsname` = '$empsname',`empengrank` = '$empengrank',`empengname` = '$empengname',";
		$sql.="`empengsname` = '$empengsname',`empflag` = '$empflag' ,`empleave` = '$empleave' ,$upfile`datein` = '$datein' ,`userin` = '$userin' WHERE `empid` = '$empid' LIMIT 1 ";
		$result = $db_conn->query ($sql);
		
		/********************Send Data To WEB MED  by call API updEmp (sansanee 020762)***********************************/
		
		$url = 'https://www.si.mahidol.ac.th/department/Medicine/home/api/updEmp.asp';
		$data = "action=1&sapid=".$empid."&title=".$emprank."&positiondesc=".$emprankname."&fname=".$empname."&mname=&lname=".$empsname."&title_eng=".$empengrank."&fname_eng=".$empengname."&mname_eng=&lname_eng=".$empengsname."&userin=".$userin."&empflag=".$empflag;
		//echo "DATA=".$data."<br>";
		//msgBox($data);
		$options = array(
			'http' => array(
			'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			'method'  => 'POST',
			'content' => $data,
			),
		);
		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
		
		msgBox("�ѹ�֡���������º����","viewemp.php?empflag=$emptype&worktype=$worktype&positiontype=$positiontype&workposition=$workposition&workunit=$workunit&follow=$follow&txtsearch=$txtsearch");
		
		
	
	}
}
$leave="none";
$empleave=date("d/m/").(date("Y")+543);
if ($_GET["chk"]=="a"){
	$title="�����ؤ�ҡ�";
	$focus="document.form1.empid.focus();";
	$idreadonly="";
}else{
	$title="��䢺ؤ�ҡ�";
	$focus="document.form1.empname.focus();";
	$idreadonly="style='background-color:#CCCCCC' readonly";
	$sql="select empid,emprankname,empengrankname,emprank,empname,empsname,empengrank,empengname,empengsname,emppic,empflag,empleave from tbemployee where empid='".$_GET["empid"]."' order by empid";
	$result = $db_conn->query ($sql);
	$row = mysql_fetch_array($result);
	if($row["empflag"]=="2") $leave="inline";
	if(empty($row["empleave"]) || $row["empleave"]=="0000-00-00")
		$empleave=date("d/m/").(date("Y")+543);
	else
		$empleave=bc2be($row["empleave"],false);
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<link rel="stylesheet" type="text/css" href="../Skin/style.css">
<title><?=$title?></title>
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

<body text="#000000" link="#9999CC" vlink="#FF66CC" alink="#FF0000" onLoad="<?=$focus?>">
<form method="post" enctype="multipart/form-data" name="form1" onSubmit="return validate(this);" <? if($_GET["chk"]=="a") echo 'target="showFrame"'?>>
<input type="hidden" name="chk" value="<?=$_GET["chk"]?>">
<input name="emptype" type="hidden" value="<?=$_GET["empflag"]?>">
<input name="worktype" type="hidden" value="<?=$_GET["worktype"]?>">
<input name="positiontype" type="hidden" value="<?=$_GET["positiontype"]?>">
<input name="workposition" type="hidden" value="<?=$_GET["workposition"]?>">
<input name="workunit" type="hidden" value="<?=$_GET["workunit"]?>">
<input name="follow" type="hidden" value="<?=$_GET["follow"]?>">
<input name="txtsearch" type="hidden" value="<?=$_GET["txtsearch"]?>">
<?
openframe2($title);
?>
  <fieldset class="SOME" style="padding:0; margin:10"><legend>�����ž�ѡ�ҹ</legend>
  <table width="100%" background="../image/bg.jpg">
    <tr  class="SOME"> 
      <td align="right">���ʾ�ѡ�ҹ :</td>
      <td><input name="empid" type="text" maxlength="20" size="20" value="<?=$row["empid"]?>" <?=$idreadonly?>></td>
    </tr>
    <tr class="SOME">
      <td align="right">��/���˹� (��):</td>
      <td>
        <? createlist("titlename as titleid,titlename","mttitle","",$row["emprankname"],"emprankname","")?>      </td>
    </tr>
    <tr class="SOME"> 
      <td align="right">��/���˹� (�ѧ���): </td>
      <td>
        <? createlist("titleengname as titleid,titleengname","mttitle","where titleengname!=''",$row["empengrankname"],"empengrankname","")?>      </td>
    </tr>
    <tr class="SOME"> 
      <td align="right">���� - ʡ�� (��) :</td>
      <td> 
        <? createlist("rankname as rankid,rankname","mtrank","",$row["emprank"],"emprank","")?>
        <input name="empname" type="text" size="30" value="<?=$row["empname"]?>"> 
        <input name="empsname" type="text" size="30" value="<?=$row["empsname"]?>">      </td>
    </tr>
    <tr class="SOME"> 
      <td align="right">���� - ʡ��(�ѧ���) :</td>
      <td> 
        <? createlist("rankengname as rankid,rankengname","mtrank","",$row["empengrank"],"empengrank","")?>
        <input name="empengname" type="text" size="30"  value="<?=$row["empengname"];?>"> 
        <input name="empengsname" type="text" size="30"  value="<?=$row["empengsname"];?>">      </td>
    </tr>
    <tr class="SOME"> 
      <td align="right">ʶҹ�Ҿ :</td>
      <td><select name="empflag" onChange="if(this.value=='2') empleave.style.display='inline'; else empleave.style.display='none';">
          <option value="1" <? if($row["empflag"]=="1") echo "selected";?>>��Ժѵԧҹ</option>
          <option value="2" <? if($row["empflag"]=="2") echo "selected";?>>���͡</option>
          <option value="3" <? if($row["empflag"]=="3") echo "selected";?>>���³����</option>
          <option value="4" <? if($row["empflag"]=="4") echo "selected";?>>˹��§ҹ</option>
          <option value="5" <? if($row["empflag"]=="5") echo "selected";?>>������</option>
          <option value="6" <? if($row["empflag"]=="6") echo "selected";?>>����֡��</option>
        </select><input name="empleave" type="text" value="<?=$empleave?>" size="8" maxlength="10" style="display:<?=$leave?>"> </td>
    </tr>
  </table>
  </fieldset>
  <fieldset class="SOME" style="padding:0; margin:10"><legend>�ٻ�Ҿ</legend>
  <table width="100%" background="../image/bg.jpg">
    <tr class="SOME">
      <td align="center"><img id="img" src="<?=$row["emppic"]?>" width="80" height="100" border="1" style="border-color:#0066CC"></td>
    </tr>
    <tr class="SOME"> 
      <td align="center"><input name="emppic" type="file" size="40" onChange="img.src=this.value"></td>
    </tr>
  </table>
  </fieldset>  
  <div style="padding-top:10" align="center">
	  <button type="submit" name="save"><img src="../image/upload-page-blue.gif">&nbsp;�ѹ�֡</button>
	  <button onClick="location='viewemp.php?empflag='+emptype.value+'&worktype='+worktype.value+'&positiontype='+positiontype.value+'&workposition='+workposition.value+'&workunit='+workunit.value+'&follow='+follow.value+'&txtsearch='+txtsearch.value"><img src="../image/left-blue.gif">&nbsp;��Ѻ��¡��</button>
  </div>
<?
closeframe2();
?>
</form>
</body>
</html>
<?php
function validate_image(&$err,$oname){
	$err = "";
	if(!is_uploaded_file($_FILES[$oname]["tmp_name"])){
		$err .= "������������� �˵ؼŤ�� ";
		if (($_FILES[$oname]["error"] == UPLOAD_ERR_INI_SIZE) or 
		    ($_FILES[$oname]["error"] == UPLOAD_ERR_FORM_SIZE))
			$err .= "����բ�Ҵ�˭���ҷ���˹�<br>";
		elseif ($_FILES[$oname]["error"] == UPLOAD_ERR_PARTIAL)
			$err .= "�����Ţͧ���١�������ú<br>";
		elseif ($_FILES[$oname]["error"] == UPLOAD_ERR_NO_FILE)
			$err .= "�س��������͡��������<br>";
	}
	else{
		if (($_FILES[$oname]["type"] != "image/gif") and 
		    ($_FILES[$oname]["type"] != "image/jpeg") and
		    ($_FILES[$oname]["type"] != "image/pjpeg"))
			$err .= "���������� �����������������ٻẺ GIF ���� JPEG<br>";
	}
	if ($err)
		return false;
	else
		return true;
}
?>
