<?
session_start();
require("../inc/function.php");
require("../theme1/theme.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>�������Чҹ</title>
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
			alert("���͡��������è�ҧ��͹�ʴ�");
			e.worktype.focus();
			return false;
		}
		if(e.check2.checked && e.positiontype.value==""){
			alert("���͡��¡�͹�ʴ�");
			e.positiontype.focus();
			return false;
		}
		if(e.check3.checked){
			if(e.workvote.value==""){
				alert("���͡�շ��������Ѻ���Ҩ�����Ҥ�Ԫ�ϡ�͹�ʴ�");
				e.workvote.focus();
				return false;
			}
		}
		if(e.check4.checked){
			if(e.workend.value==""){
				alert("���͡�շ������ش������ҡ�è�ҧ��͹�ʴ�");
				e.workend.focus();
				return false;
			}
		}
		if(e.check5.checked && e.select1.value==""){
			alert("���͡�����³�����Ҫ��á�͹�ʴ�");
			e.select1.focus();
			return false;
		}
		if(e.check6.checked && e.select2.value==""){
			alert("���͡�ջ�Ժѵԧҹ�ú 25 �ա�͹�ʴ�");
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
  <? openframe2("���͡����¹�����źؤ�ҡ�")?>
  <table width="100%">
    <tr> 
      <td colspan="3"> <fieldset class="SOMEbig" style="margin: 5px">
        <legend><strong>���͹�</strong></legend>
        <table width="100%">
          <tr class="SOMEbig">
            <td align="center"><input type="checkbox" name="check8" onClick="d1.disabled=!this.checked"></td>
            <td>˹��§ҹ</td>
            <td><? createlist("unitid,unitname","tbjobunit","where status='0' or unitid='99' order by unitid","","d1","onChange='getDataReturnText(\"../inc/getdata.php?id=\"+this.value, displayText)' disabled");?></td>
          </tr>
          <tr class="SOMEbig">
            <td align="center"><input type="checkbox" name="check7" onClick="chkEmp(this.checked)"></td>
            <td>��ѡ�ҹ</td>
            <td><input name="chkuser" type="radio" value="1" onClick="d2.style.display='';d3.style.display='none'" checked disabled>
����Ԫҡ��
  <input name="chkuser" type="radio" value="2" onClick="d2.style.display='none';d3.style.display=''" disabled>
���ʹѺʹع
<?
			createlist("a.empid,b.empname,b.empsname","tbempwork a left join tbemployee b on a.empid=b.empid","where b.empflag='1' and a.workposition in (select positionid from mtposition where positiontype='1') and a.workunit='".$myauth[unitstatus]."' order by b.empname","","d2","disabled");
			createlist("a.empid,b.empname,b.empsname","tbempwork a left join tbemployee b on a.empid=b.empid","where b.empflag='1' and a.workposition in (select positionid from mtposition where positiontype!='1') and a.workunit='".$myauth[unitstatus]."' order by b.empname","","d3","style='display:none' disabled");
?></td>
          </tr>
          <tr class="SOMEbig"> 
            <td width="50" align="center"><input type="checkbox" name="check1" onClick="worktype.disabled=!this.checked"></td>
            <td>��������è�ҧ</td>
            <td> 
              <? createlist("typeid,typename","mttype","order by typeid","","worktype","disabled","----- ���͡��������è�ҧ -----")?></td>
          </tr>
          <tr class="SOMEbig"> 
            <td align="center"><input type="checkbox" name="check2" onClick="positiontype.disabled=!this.checked;workposition.disabled=!this.checked"></td>
            <td>���˹�</td>
            <td> <select name="positiontype" onChange="getDataReturnXml('../report/dataPosition.php?id='+this.value, displayXml)" disabled>
                <option value=""> -- ���͡��� -- </option>
                <option value="1">����Ԫҡ�� (�)</option>
                <option value="2">���ʹѺʹع�Ԫҡ�� (�)</option>
                <option value="3">���ʹѺʹع�Ԫҡ�� (�)</option>
              </select> <select name="workposition" disabled>
              </select> </td>
          </tr>
          <tr class="SOMEbig"> 
            <td align="center"><input type="checkbox" name="check3" onClick="workvote.disabled=!this.checked"></td>
            <td>������Ѻ���Ҩ�����Ҥ�Ԫ��</td>
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
            <td>�������ҡ�è�ҧ</td>
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
            <td>���³�����Ҫ���</td>
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
            <td>��Ժѵԧҹ�ú 25 ��</td>
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
            <td>��Ժѵԧҹ�ú 65 ��</td>
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
        &nbsp;<strong>�����źؤ�ҡ�</strong></legend>
        <input name="employee[]" type="checkbox" value="0">
        &nbsp;���ʾ�ѡ�ҹ<br>
        <input name="employee[]" type="checkbox" value="1">
        &nbsp;�ӹ�˹�Ҫ��� (��)<br>
        <input name="employee[]" type="checkbox" value="2">
        &nbsp;�ӹ�˹�Ҫ��� (�ѧ���)<br>
        <input name="employee[]" type="checkbox" value="3">
        &nbsp;��/���˹� (��)<br>
        <input name="employee[]" type="checkbox" value="4">
        &nbsp;��/���˹� (�ѧ���)<br>
        <input name="employee[]" type="checkbox" value="5">
        &nbsp;����-ʡ�� (��)<br>
        <input name="employee[]" type="checkbox" value="6">
        &nbsp;����-ʡ�� (�ѧ���)
      </fieldset>
		<fieldset class="SOMEbig" style="margin: 5px">
        <legend> 
        <input name="alldetail" type="checkbox" onClick="selectAll('detail[]',this.checked)">
        &nbsp;<strong>��������¡��</strong></legend>
        <table width="100%" border="0" cellspacing="0" cellpadding="1" class="SOMEbig">
          <tr>
            <td><input name="detail[]" type="checkbox" value="0" onClick="chkAll(this.checked,'edu[]')"><span style="cursor:pointer" onClick="expland('education')">&nbsp;�زԡ���֡��</span></td>
          </tr>
          <tr>
            <td style="padding-left:25; display:none" id="education">
			  <input type="checkbox" name="edu[]" value="0">�زԡ���֡��<br>
			  <input type="checkbox" name="edu[]" value="1">�زԡ���֡��(���)<br>
			  <input type="checkbox" name="edu[]" value="2">ʶҹ�֡��<br>
			  <input type="checkbox" name="edu[]" value="3">�����<br>
			  <input type="checkbox" name="edu[]" value="4">�շ�診����֡��<br>
			  <input type="checkbox" name="edu[]" value="5">��蹷��			</td>
          </tr>
          <tr>
            <td><input name="detail[]" type="checkbox" value="1" onClick="chkAll(this.checked,'trn[]')"><span style="cursor:pointer" onClick="expland('train')">&nbsp;����ѵԡ�����֡��/�֡ͺ��</span></td>
          </tr>
          <tr>
            <td style="padding-left:25; display:none" id="train">
			<input type="checkbox" name="trn[]" value="0">�����������<br>
            <input type="checkbox" name="trn[]" value="1">��ѡ�ٵ�<br>
            <input type="checkbox" name="trn[]" value="2">��������<br>
            <input type="checkbox" name="trn[]" value="3">ʶҹ�֡��<br>
            <input type="checkbox" name="trn[]" value="4">�����<br>
            <input type="checkbox" name="trn[]" value="5">�ع<br>
            <input type="checkbox" name="trn[]" value="6">������ҳ			</td>
          </tr>
          <tr>
            <td><input name="detail[]" type="checkbox" value="2" onClick="chkAll(this.checked,'gov[]')"><span style="cursor:pointer" onClick="expland('goverment')">&nbsp;����ѵԡ���Ѻ�Ҫ���</span></td>
          </tr>
          <tr>
            <td style="padding-left:25; display:none" id="goverment">
			<input type="checkbox" name="gov[]" value="0">�ѹ���<br>
            <input type="checkbox" name="gov[]" value="1">���˹�<br>
            <input type="checkbox" name="gov[]" value="2">�дѺ<br>
            <input type="checkbox" name="gov[]" value="3">����Թ��͹<br>
            <input type="checkbox" name="gov[]" value="4">�ӹǹ��鹷�����͹<br>
            <input type="checkbox" name="gov[]" value="5">���/��з�ǧ
			</td>
          </tr>
          <tr>
            <td><input name="detail[]" type="checkbox" value="3" onClick="chkAll(this.checked,'cls[]')"><span style="cursor:pointer" onClick="expland('class')">&nbsp;����ѵԡ���Ѻ����ͧ�Ҫ�</span></td>
          </tr>
          <tr>
            <td style="padding-left:25; display:none" id="class">
			<input type="checkbox" name="cls[]" value="0">�ѹ���<br>
            <input type="checkbox" name="cls[]" value="1">����ͧ�Ҫ��������ó�<br>
            <input type="checkbox" name="cls[]" value="2">���˹�<br>
            <input type="checkbox" name="cls[]" value="3">�дѺ<br>
            <input type="checkbox" name="cls[]" value="4">���<br>
            <input type="checkbox" name="cls[]" value="5">�ѹ������Ѻ<br>
            <input type="checkbox" name="cls[]" value="6">�ѹ���׹
			</td>
          </tr>
          <tr>
            <td><input name="detail[]" type="checkbox" value="4" onClick="chkAll(this.checked,'rwd[]')"><span style="cursor:pointer" onClick="expland('reward')">&nbsp;����ѵ����õ���</span></td>
          </tr>
          <tr>
            <td style="padding-left:25; display:none" id="reward">
			<input type="checkbox" name="rwd[]" value="0">�.�.<br>
            <input type="checkbox" name="rwd[]" value="1">���õ���<br>
            <input type="checkbox" name="rwd[]" value="2">˹��§ҹ����ͺ�ҧ���
			</td>
          </tr>
          <tr>
            <td><input name="detail[]" type="checkbox" value="5" onClick="chkAll(this.checked,'pos[]')"><span style="cursor:pointer" onClick="expland('position')">&nbsp;���˹觺�����</span></td>
          </tr>
          <tr>
            <td style="padding-left:25; display:none" id="position">
			<input type="checkbox" name="pos[]" value="0">���ͤ�С������<br>
            <input type="checkbox" name="pos[]" value="1">���˹觺�����<br>
            <input type="checkbox" name="pos[]" value="2">�������ҵ��˹�
			</td>
          </tr>
          <tr>
            <td><input name="detail[]" type="checkbox" value="6" onClick="chkAll(this.checked,'tec[]')"><span style="cursor:pointer" onClick="expland('technic')">&nbsp;���˹觷ҧ�Ԫҡ��</span></td>
          </tr>
          <tr>
            <td style="padding-left:25; display:none" id="technic">
			<input type="checkbox" name="tec[]" value="0">���˹觷ҧ�Ԫҡ��<br>
            <input type="checkbox" name="tec[]" value="1">��ç���˹�
			</td>
          </tr>
        </table>
	  </fieldset></td>
      <td valign="top"> <fieldset class="SOMEbig" style="margin: 5px">
        <legend> 
        <input name="allprivate" type="checkbox" onClick="selectAll('private[]',this.checked)">
        &nbsp;<strong>����ѵ���ǹ���</strong></legend>
        <input name="private[]" type="checkbox" value="0">
        &nbsp;�ѹ ��͹ �� �Դ<br>
        <input name="private[]" type="checkbox" value="1">
        &nbsp;����<br>
        <input name="private[]" type="checkbox" value="2">
        &nbsp;��<br>
        <input name="private[]" type="checkbox" value="3">
        &nbsp;���ͪҵ�<br>
        <input name="private[]" type="checkbox" value="4">
        &nbsp;�ѭ�ҵ�<br>
        <input name="private[]" type="checkbox" value="5">
        &nbsp;��ʹ�<br>
        <input name="private[]" type="checkbox" value="6">
        &nbsp;ʶҹ�Ҿ����<br>
        <input name="private[]" type="checkbox" value="7">
        &nbsp;�������<br>
        <input name="private[]" type="checkbox" value="8">
        &nbsp;�������������¹��ҹ<br>
        <input name="private[]" type="checkbox" value="9">
        &nbsp;�������Ѩ�غѹ<br>
        <input name="private[]" type="checkbox" value="10">
        &nbsp;���Ѿ��<br>
        <input name="private[]" type="checkbox" value="11">
        &nbsp;��Ͷ��<br>
        <input name="private[]" type="checkbox" value="12">
        &nbsp;�ء�Թ(�Դ���)<br>
        <input name="private[]" type="checkbox" value="13">
        &nbsp;�������<br>
        <input name="private[]" type="checkbox" value="14">
        &nbsp;�����Ţ��Шӵ�ǻ�ЪҪ�<br>
        <input name="private[]" type="checkbox" value="15">
        &nbsp;�Ţ����͹حҵ��Сͺ�ä��Ż�<br>
        <input name="private[]" type="checkbox" value="16">
        &nbsp;�����˵�<br>
        </fieldset></td>
      <td valign="top"> <fieldset class="SOMEbig" style="margin: 5px">
        <legend> 
        <input name="allwork" type="checkbox" onClick="selectAll('work[]',this.checked)">
        &nbsp;<strong>����ѵԡ�÷ӧҹ</strong></legend>
        <input name="work[]" type="checkbox" value="0">
        &nbsp;��������è�ҧ<br>
        <input name="work[]" type="checkbox" value="1">
        &nbsp;�Ţ��Шӵ��˹�<br>
        <input name="work[]" type="checkbox" value="2">
        &nbsp;�ѹ��è�<br>
        <input name="work[]" type="checkbox" value="3">
        &nbsp;���اҹ<br>
        <input name="work[]" type="checkbox" value="4">
        &nbsp;�͹����<br>
        <input name="work[]" type="checkbox" value="5">
        &nbsp;�ѹ��è����Ҩ����<br>
        <input name="work[]" type="checkbox" value="6">
        &nbsp;�ú 25 ��<br>
        <input name="work[]" type="checkbox" value="7">
        &nbsp;���³�����Ҫ���<br>
        <input name="work[]" type="checkbox" value="8">
        &nbsp;�ú 65 ��<br>
        <input name="work[]" type="checkbox" value="9">
        &nbsp;�дѺ<br>
        <input name="work[]" type="checkbox" value="10">
        &nbsp;�Թ��͹<br>
        <input name="work[]" type="checkbox" value="11">
        &nbsp;�Թ��Шӵ��˹�<br>
        <input name="work[]" type="checkbox" value="12">
        &nbsp;���˹�<br>
        <input name="work[]" type="checkbox" value="13">
        &nbsp;������Ѻ���Ҩ�����Ҥ�Ԫ��<br>
        <input name="work[]" type="checkbox" value="14">
        &nbsp;���һ�Ժѵԧҹ<br>
        <input name="work[]" type="checkbox" value="15">
        &nbsp;�Ң��Ԫ�<br>
        <input name="work[]" type="checkbox" value="16">
        &nbsp;ʶҹ���ӧҹ<br>
        <input name="work[]" type="checkbox" value="17">
        &nbsp;���Ѿ��<br>
        <input name="work[]" type="checkbox" value="18">
        &nbsp;�����˵�<br>
        </fieldset></td>
    </tr>
    <tr align="center" valign="bottom"> 
      <td height="40" colspan="3"><button type="submit" name="display"><img src="../image/documents_16.gif">&nbsp;�ʴ���¡��</button></td>
    </tr>
  </table>
  <? closeframe2()?>
</form>
</body>
</html>