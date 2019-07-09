<?
session_start();
require("../inc/function.php");
require("../theme1/theme.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>ค้นหาภาระงาน</title>
<script type="text/javascript" src="../inc/dropdown.js"></script>
<script type="text/javascript" src="../inc/myAjaxFramework.js"></script>
<link href="../Skin/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
	function chkAll(flag,oname){
		var objCheckBoxes = document.forms["form1"].elements[oname];
		if(!objCheckBoxes) return;
		var countCheckBoxes = objCheckBoxes.length;
		for(i=0;i<countCheckBoxes;i++){
			objCheckBoxes[i].checked = flag;
		}
	}

	function expland(oname){
		var obj = document.getElementById(oname);
		if(obj.style.display=="none") obj.style.display="block"; else obj.style.display="none";
	}
	function validate(e){
		if(e.check1.checked && e.worktype.value==""){
			alert("เลือกประเภทการจ้างก่อนแสดง");
			e.worktype.focus();
			return false;
		}
		if(e.check2.checked && e.positiontype.value==""){
			alert("เลือกสายก่อนแสดง");
			e.positiontype.focus();
			return false;
		}
		if(e.check3.checked){
			if(e.workvote.value==""){
				alert("เลือกปีที่มีมติรับเป็นอาจารย์ภาควิชาฯก่อนแสดง");
				e.workvote.focus();
				return false;
			}
		}
		if(e.check4.checked){
			if(e.workend.value==""){
				alert("เลือกปีที่สิ้นสุดระยเวลาการจ้างก่อนแสดง");
				e.workend.focus();
				return false;
			}
		}
		if(e.check5.checked && e.select1.value==""){
			alert("เลือกปีเกษียณอายุราชการก่อนแสดง");
			e.select1.focus();
			return false;
		}
		if(e.check6.checked && e.select2.value==""){
			alert("เลือกปีปฏิบัติงานครบ 25 ปีก่อนแสดง");
			e.select2.focus();
			return false;
		}
	}

	function displayXml(root){
		var obj=document.getElementById('workposition');
		clearDropDownList(obj);
		var items = root.getElementsByTagName("position");
		obj.options[0] = new Option("", "");
		for (var i = 0 ; i < items.length ; i++) {
			var item = items[i];
			var id = item.getElementsByTagName("id")[0].firstChild.nodeValue;
			var name = item.getElementsByTagName("name")[0].firstChild.nodeValue;
			obj.options[obj.options.length] = new Option(name, id);
		}
	}

	function clearDropDownList(obj){
		for(i=obj.options.length-1; i>=0; i--){
			obj.options[i]=null;
		}
	}

	function selectAll(oName,flag){
		var obj = document.form1.elements(oName);
		for(i=0;i<obj.length;i++) obj[i].checked=flag;
	}

	function chkEmp(flag){
		with(document.form1){
			chkuser[0].disabled=!flag;
			chkuser[1].disabled=!flag;
			d2.disabled=!flag;
			d3.disabled=!flag;
		}
	}

	function displayText(data){
		if(data != ""){
			var arrTotal=data.split("><");
			//DropDownList2
			var arrData = arrTotal[0].split(",");
			if(arrData.length > 0){
				//Clear DropDownList
				var dd2 = document.getElementById("d2");
				clearDropDownList(dd2);
				//Start add item.
				dd2.options[dd2.options.length] = new Option("", "");
				for(i=0; i<arrData.length; i++){				
					if(arrData[i]!=""){
						var arrValue = arrData[i].split(":");
						dd2.options[dd2.options.length] = new Option(arrValue[1], arrValue[0]);
					}
				}
			}
			//DropDownList3
			var arrData = arrTotal[1].split(",");
			if(arrData.length > 0){
				//Clear DropDownList
				var dd3 = document.getElementById("d3");
				clearDropDownList(dd3);
				//Start add item.
				dd3.options[dd3.options.length] = new Option("", "");
				for(i=0; i<arrData.length; i++){				
					if(arrData[i]!=""){
						var arrValue = arrData[i].split(":");
						dd3.options[dd3.options.length] = new Option(arrValue[1], arrValue[0]);
					}
				}
			}
		}
	}	
</script>
</head>

<body>
<form method="post" name="form1" action="dispfield.php">
  <? openframe2("เลือกระเบียนข้อมูลบุคลากร")?>
  <table width="100%">
    <tr> 
      <td colspan="3"> <fieldset class="SOMEbig" style="margin: 5px">
        <legend><strong>เงื่อนไข</strong></legend>
        <table width="100%">
          <tr class="SOMEbig">
            <td align="center"><input type="checkbox" name="check8" onClick="d1.disabled=!this.checked"></td>
            <td>หน่วยงาน</td>
            <td><? createlist("unitid,unitname","tbjobunit","where status='0' or unitid='99' order by unitid","","d1","onChange='getDataReturnText(\"../inc/getdata.php?id=\"+this.value, displayText)' disabled");?></td>
          </tr>
          <tr class="SOMEbig">
            <td align="center"><input type="checkbox" name="check7" onClick="chkEmp(this.checked)"></td>
            <td>พนักงาน</td>
            <td><input name="chkuser" type="radio" value="1" onClick="d2.style.display='';d3.style.display='none'" checked disabled>
สายวิชาการ
  <input name="chkuser" type="radio" value="2" onClick="d2.style.display='none';d3.style.display=''" disabled>
สายสนับสนุน
<?
			createlist("a.empid,b.empname,b.empsname","tbempwork a left join tbemployee b on a.empid=b.empid","where b.empflag='1' and a.workposition in (select positionid from mtposition where positiontype='1') and a.workunit='".$myauth[unitstatus]."' order by b.empname","","d2","disabled");
			createlist("a.empid,b.empname,b.empsname","tbempwork a left join tbemployee b on a.empid=b.empid","where b.empflag='1' and a.workposition in (select positionid from mtposition where positiontype!='1') and a.workunit='".$myauth[unitstatus]."' order by b.empname","","d3","style='display:none' disabled");
?></td>
          </tr>
          <tr class="SOMEbig"> 
            <td width="50" align="center"><input type="checkbox" name="check1" onClick="worktype.disabled=!this.checked"></td>
            <td>ประเภทการจ้าง</td>
            <td> 
              <? createlist("typeid,typename","mttype","order by typeid","","worktype","disabled","----- เลือกประเภทการจ้าง -----")?></td>
          </tr>
          <tr class="SOMEbig"> 
            <td align="center"><input type="checkbox" name="check2" onClick="positiontype.disabled=!this.checked;workposition.disabled=!this.checked"></td>
            <td>ตำแหน่ง</td>
            <td> <select name="positiontype" onChange="getDataReturnXml('../report/dataPosition.php?id='+this.value, displayXml)" disabled>
                <option value=""> -- เลือกสาย -- </option>
                <option value="1">สายวิชาการ (ก)</option>
                <option value="2">สายสนับสนุนวิชาการ (ข)</option>
                <option value="3">สายสนับสนุนวิชาการ (ค)</option>
              </select> <select name="workposition" disabled>
              </select> </td>
          </tr>
          <tr class="SOMEbig"> 
            <td align="center"><input type="checkbox" name="check3" onClick="workvote.disabled=!this.checked"></td>
            <td>มีมติรับเป็นอาจารย์ภาควิชาฯ</td>
            <td> <select name='workvote' disabled>
                <?
			$yy=date("Y");
			for($i=$yy-5;$i<$yy+10;$i++)
				if($i==$yy) echo "<option value='$i' selected>".($i+543)."</option>"; else echo "<option value=$i>".($i+543)."</option>";
			?>
              </select> </td>
          </tr>
          <tr class="SOMEbig"> 
            <td align="center"><input type="checkbox" name="check4" onClick="workend.disabled=!this.checked"></td>
            <td>ระยะเวลาการจ้าง</td>
            <td><select name='workend' disabled>
                <?
			$yy=date("Y");
			for($i=$yy-5;$i<$yy+10;$i++)
				if($i==$yy) echo "<option value='$i' selected>".($i+543)."</option>"; else echo "<option value=$i>".($i+543)."</option>";
			?>
              </select></td>
          </tr>
          <tr class="SOMEbig"> 
            <td align="center"><input type="checkbox" name="check5" onClick="select1.disabled=!this.checked"></td>
            <td>เกษียณอายุราชการ</td>
            <td><select name='select1' disabled>
                <?
			$yy=date("Y");
			for($i=$yy-5;$i<$yy+10;$i++)
				if($i==$yy) echo "<option value='$i' selected>".($i+543)."</option>"; else echo "<option value=$i>".($i+543)."</option>";
			?>
              </select></td>
          </tr>
          <tr class="SOMEbig"> 
            <td align="center"><input type="checkbox" name="check6" onClick="select2.disabled=!this.checked"></td>
            <td>ปฏิบัติงานครบ 25 ปี</td>
            <td><select name='select2' disabled>
                <?
			$yy=date("Y");
			for($i=$yy-5;$i<$yy+10;$i++)
				if($i==$yy) echo "<option value='$i' selected>".($i+543)."</option>"; else echo "<option value=$i>".($i+543)."</option>";
			?>
              </select> </td>
          </tr>
          <tr class="SOMEbig"> 
            <td align="center"><input type="checkbox" name="check9" onClick="select3.disabled=!this.checked"></td>
            <td>ปฏิบัติงานครบ 65 ปี</td>
            <td><select name='select3' disabled>
                <?
			$yy=date("Y");
			for($i=$yy-5;$i<$yy+10;$i++)
				if($i==$yy) echo "<option value='$i' selected>".($i+543)."</option>"; else echo "<option value=$i>".($i+543)."</option>";
			?>
              </select> </td>
          </tr>
        </table>
        </fieldset></td>
    </tr>
    <tr>
      <td valign="top"> <fieldset class="SOMEbig" style="margin: 5px">
        <legend> 
        <input name="allemp" type="checkbox" onClick="selectAll('employee[]',this.checked)">
        &nbsp;<strong>ข้อมูลบุคลากร</strong></legend>
        <input name="employee[]" type="checkbox" value="0">
        &nbsp;รหัสพนักงาน<br>
        <input name="employee[]" type="checkbox" value="1">
        &nbsp;คำนำหน้าชื่อ (ไทย)<br>
        <input name="employee[]" type="checkbox" value="2">
        &nbsp;คำนำหน้าชื่อ (อังกฤษ)<br>
        <input name="employee[]" type="checkbox" value="3">
        &nbsp;ยศ/ตำแหน่ง (ไทย)<br>
        <input name="employee[]" type="checkbox" value="4">
        &nbsp;ยศ/ตำแหน่ง (อังกฤษ)<br>
        <input name="employee[]" type="checkbox" value="5">
        &nbsp;ชื่อ-สกุล (ไทย)<br>
        <input name="employee[]" type="checkbox" value="6">
        &nbsp;ชื่อ-สกุล (อังกฤษ)
      </fieldset>
		<fieldset class="SOMEbig" style="margin: 5px">
        <legend> 
        <input name="alldetail" type="checkbox" onClick="selectAll('detail[]',this.checked)">
        &nbsp;<strong>ข้อมูลรายการ</strong></legend>
        <table width="100%" border="0" cellspacing="0" cellpadding="1" class="SOMEbig">
          <tr>
            <td><input name="detail[]" type="checkbox" value="0" onClick="chkAll(this.checked,'edu[]')"><span style="cursor:pointer" onClick="expland('education')">&nbsp;วุฒิการศึกษา</span></td>
          </tr>
          <tr>
            <td style="padding-left:25; display:none" id="education">
			  <input type="checkbox" name="edu[]" value="0">วุฒิการศึกษา<br>
			  <input type="checkbox" name="edu[]" value="1">วุฒิการศึกษา(ย่อ)<br>
			  <input type="checkbox" name="edu[]" value="2">สถานศึกษา<br>
			  <input type="checkbox" name="edu[]" value="3">ประเทศ<br>
			  <input type="checkbox" name="edu[]" value="4">ปีที่จบการศึกษา<br>
			  <input type="checkbox" name="edu[]" value="5">รุ่นที่			</td>
          </tr>
          <tr>
            <td><input name="detail[]" type="checkbox" value="1" onClick="chkAll(this.checked,'trn[]')"><span style="cursor:pointer" onClick="expland('train')">&nbsp;ประวัติการลาศึกษา/ฝึกอบรม</span></td>
          </tr>
          <tr>
            <td style="padding-left:25; display:none" id="train">
			<input type="checkbox" name="trn[]" value="0">ประเภทการลา<br>
            <input type="checkbox" name="trn[]" value="1">หลักสูตร<br>
            <input type="checkbox" name="trn[]" value="2">ระยะเวลา<br>
            <input type="checkbox" name="trn[]" value="3">สถานศึกษา<br>
            <input type="checkbox" name="trn[]" value="4">ประเทศ<br>
            <input type="checkbox" name="trn[]" value="5">ทุน<br>
            <input type="checkbox" name="trn[]" value="6">งบประมาณ			</td>
          </tr>
          <tr>
            <td><input name="detail[]" type="checkbox" value="2" onClick="chkAll(this.checked,'gov[]')"><span style="cursor:pointer" onClick="expland('goverment')">&nbsp;ประวัติการรับราชการ</span></td>
          </tr>
          <tr>
            <td style="padding-left:25; display:none" id="goverment">
			<input type="checkbox" name="gov[]" value="0">วันที่<br>
            <input type="checkbox" name="gov[]" value="1">ตำแหน่ง<br>
            <input type="checkbox" name="gov[]" value="2">ระดับ<br>
            <input type="checkbox" name="gov[]" value="3">ขั้นเงินเดือน<br>
            <input type="checkbox" name="gov[]" value="4">จำนวนขั้นที่เลือน<br>
            <input type="checkbox" name="gov[]" value="5">กรม/กระทรวง
			</td>
          </tr>
          <tr>
            <td><input name="detail[]" type="checkbox" value="3" onClick="chkAll(this.checked,'cls[]')"><span style="cursor:pointer" onClick="expland('class')">&nbsp;ประวัติการรับเครื่องราชฯ</span></td>
          </tr>
          <tr>
            <td style="padding-left:25; display:none" id="class">
			<input type="checkbox" name="cls[]" value="0">วันที่<br>
            <input type="checkbox" name="cls[]" value="1">เครื่องราชอิสริยาภรณ์<br>
            <input type="checkbox" name="cls[]" value="2">ตำแหน่ง<br>
            <input type="checkbox" name="cls[]" value="3">ระดับ<br>
            <input type="checkbox" name="cls[]" value="4">ขั้น<br>
            <input type="checkbox" name="cls[]" value="5">วันที่ได้รับ<br>
            <input type="checkbox" name="cls[]" value="6">วันที่คืน
			</td>
          </tr>
          <tr>
            <td><input name="detail[]" type="checkbox" value="4" onClick="chkAll(this.checked,'rwd[]')"><span style="cursor:pointer" onClick="expland('reward')">&nbsp;ประวัติเกียรติยศ</span></td>
          </tr>
          <tr>
            <td style="padding-left:25; display:none" id="reward">
			<input type="checkbox" name="rwd[]" value="0">พ.ศ.<br>
            <input type="checkbox" name="rwd[]" value="1">เกียรติยศ<br>
            <input type="checkbox" name="rwd[]" value="2">หน่วยงานที่มอบรางวัล
			</td>
          </tr>
          <tr>
            <td><input name="detail[]" type="checkbox" value="5" onClick="chkAll(this.checked,'pos[]')"><span style="cursor:pointer" onClick="expland('position')">&nbsp;ตำแหน่งบริหาร</span></td>
          </tr>
          <tr>
            <td style="padding-left:25; display:none" id="position">
			<input type="checkbox" name="pos[]" value="0">ชื่อคณะกรรมการ<br>
            <input type="checkbox" name="pos[]" value="1">ตำแหน่งบริหาร<br>
            <input type="checkbox" name="pos[]" value="2">ระยะเวลาตำแหน่ง
			</td>
          </tr>
          <tr>
            <td><input name="detail[]" type="checkbox" value="6" onClick="chkAll(this.checked,'tec[]')"><span style="cursor:pointer" onClick="expland('technic')">&nbsp;ตำแหน่งทางวิชาการ</span></td>
          </tr>
          <tr>
            <td style="padding-left:25; display:none" id="technic">
			<input type="checkbox" name="tec[]" value="0">ตำแหน่งทางวิชาการ<br>
            <input type="checkbox" name="tec[]" value="1">ดำรงตำแหน่ง
			</td>
          </tr>
        </table>
	  </fieldset></td>
      <td valign="top"> <fieldset class="SOMEbig" style="margin: 5px">
        <legend> 
        <input name="allprivate" type="checkbox" onClick="selectAll('private[]',this.checked)">
        &nbsp;<strong>ประวัติส่วนตัว</strong></legend>
        <input name="private[]" type="checkbox" value="0">
        &nbsp;วัน เดือน ปี เกิด<br>
        <input name="private[]" type="checkbox" value="1">
        &nbsp;อายุ<br>
        <input name="private[]" type="checkbox" value="2">
        &nbsp;เพศ<br>
        <input name="private[]" type="checkbox" value="3">
        &nbsp;เชื้อชาติ<br>
        <input name="private[]" type="checkbox" value="4">
        &nbsp;สัญชาติ<br>
        <input name="private[]" type="checkbox" value="5">
        &nbsp;ศาสนา<br>
        <input name="private[]" type="checkbox" value="6">
        &nbsp;สถานภาพสมรส<br>
        <input name="private[]" type="checkbox" value="7">
        &nbsp;คู่สมรส<br>
        <input name="private[]" type="checkbox" value="8">
        &nbsp;ที่อยู่ตามทะเบียนบ้าน<br>
        <input name="private[]" type="checkbox" value="9">
        &nbsp;ที่อยู่ปัจจุบัน<br>
        <input name="private[]" type="checkbox" value="10">
        &nbsp;โทรศัพท์<br>
        <input name="private[]" type="checkbox" value="11">
        &nbsp;มือถือ<br>
        <input name="private[]" type="checkbox" value="12">
        &nbsp;ฉุกเฉิน(ติดต่อ)<br>
        <input name="private[]" type="checkbox" value="13">
        &nbsp;อีเมลล์<br>
        <input name="private[]" type="checkbox" value="14">
        &nbsp;หมายเลขประจำตัวประชาชน<br>
        <input name="private[]" type="checkbox" value="15">
        &nbsp;เลขที่ใบอนุญาตประกอบโรคศิลป์<br>
        <input name="private[]" type="checkbox" value="16">
        &nbsp;หมายเหตุ<br>
        </fieldset></td>
      <td valign="top"> <fieldset class="SOMEbig" style="margin: 5px">
        <legend> 
        <input name="allwork" type="checkbox" onClick="selectAll('work[]',this.checked)">
        &nbsp;<strong>ประวัติการทำงาน</strong></legend>
        <input name="work[]" type="checkbox" value="0">
        &nbsp;ประเภทการจ้าง<br>
        <input name="work[]" type="checkbox" value="1">
        &nbsp;เลขประจำตำแหน่ง<br>
        <input name="work[]" type="checkbox" value="2">
        &nbsp;วันบรรจุ<br>
        <input name="work[]" type="checkbox" value="3">
        &nbsp;อายุงาน<br>
        <input name="work[]" type="checkbox" value="4">
        &nbsp;โอนย้าย<br>
        <input name="work[]" type="checkbox" value="5">
        &nbsp;วันบรรจุเป็นอาจารย์<br>
        <input name="work[]" type="checkbox" value="6">
        &nbsp;ครบ 25 ปี<br>
        <input name="work[]" type="checkbox" value="7">
        &nbsp;เกษียณอายุราชการ<br>
        <input name="work[]" type="checkbox" value="8">
        &nbsp;ครบ 65 ปี<br>
        <input name="work[]" type="checkbox" value="9">
        &nbsp;ระดับ<br>
        <input name="work[]" type="checkbox" value="10">
        &nbsp;เงินเดือน<br>
        <input name="work[]" type="checkbox" value="11">
        &nbsp;เงินประจำตำแหน่ง<br>
        <input name="work[]" type="checkbox" value="12">
        &nbsp;ตำแหน่ง<br>
        <input name="work[]" type="checkbox" value="13">
        &nbsp;มีมติรับเป็นอาจารย์ภาควิชาฯ<br>
        <input name="work[]" type="checkbox" value="14">
        &nbsp;เวลาปฏิบัติงาน<br>
        <input name="work[]" type="checkbox" value="15">
        &nbsp;สาขาวิชา<br>
        <input name="work[]" type="checkbox" value="16">
        &nbsp;สถานที่ทำงาน<br>
        <input name="work[]" type="checkbox" value="17">
        &nbsp;โทรศัพท์<br>
        <input name="work[]" type="checkbox" value="18">
        &nbsp;หมายเหตุ<br>
        </fieldset></td>
    </tr>
    <tr align="center" valign="bottom"> 
      <td height="40" colspan="3"><button type="submit" name="display"><img src="../image/documents_16.gif">&nbsp;แสดงรายการ</button></td>
    </tr>
  </table>
  <? closeframe2()?>
</form>
</body>
</html>