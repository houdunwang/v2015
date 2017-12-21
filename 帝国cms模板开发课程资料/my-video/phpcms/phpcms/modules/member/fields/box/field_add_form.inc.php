<table cellpadding="2" cellspacing="1" width="98%">
	<tr> 
      <td width="100">选项列表</td>
      <td><textarea name="setting[options]" rows="2" cols="20" id="options" style="height:100px;width:400px;">选项名称1|选项值1</textarea></td>
    </tr>
	<tr> 
      <td>选项类型</td>
      <td>
	  <input type="radio" name="setting[boxtype]" value="radio" checked onclick="$('#setcols').show();$('#setsize').hide();"/> 单选按钮 
	  <input type="radio" name="setting[boxtype]" value="checkbox" onclick="$('#setcols').show();$('setsize').hide();"/> 复选框 
	  <input type="radio" name="setting[boxtype]" value="select" onclick="$('#setcols').hide();$('setsize').show();" /> 下拉框 
	  <input type="radio" name="setting[boxtype]" value="multiple" onclick="$('#setcols').hide();$('setsize').show();" /> 多选列表框
	  </td>
    </tr>
	<tr> 
      <td>字段类型</td>
      <td>
	  <select name="setting[fieldtype]" onchange="javascript:fieldtype_setting(this.value);">
	  <option value="varchar">字符 VARCHAR</option>
	  <option value="tinyint">整数 TINYINT(3)</option>
	  <option value="smallint">整数 SMALLINT(5)</option>
	  <option value="mediumint">整数 MEDIUMINT(8)</option>
	  <option value="int">整数 INT(10)</option>
	  </select> <span id="minnumber" style="display:none"><input type="radio" name="setting[minnumber]" value="1" checked/> <font color='red'>正整数</font> <input type="radio" name="setting[minnumber]" value="-1" /> 整数</span>
	  </td>
    </tr>
<tbody id="setcols" style="display:">
	<tr> 
      <td>每列宽度</td>
      <td><input type="text" name="setting[width]" value="100" size="5" class="input-text"> px</td>
    </tr>
</tbody>
<tbody id="setsize" style="display:none">
	<tr> 
      <td>高度</td>
      <td><input type="text" name="setting[size]" value="1" size="5" class="input-text"> 行</td>
    </tr>
</tbody>
	<tr> 
      <td>默认值</td>
      <td><input type="text" name="setting[defaultvalue]" size="40" class="input-text"></td>
    </tr>
	<tr> 
      <td>输出格式</td>
      <td>
	  <input type="radio" name="setting[outputtype]" value="1" checked /> 输出选项值 
	  <input type="radio" name="setting[outputtype]" value="0" /> 输出选项名称
	  </td>
    </tr>
</table>
<SCRIPT LANGUAGE="JavaScript">
<!--
	function fieldtype_setting(obj) {
	if(obj!='varchar') {
		$('#minnumber').css('display','');
	} else {
		$('#minnumber').css('display','none');
	}
}
//-->
</SCRIPT>