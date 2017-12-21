<table cellpadding="2" cellspacing="1" width="98%">
	<tr> 
      <td width="100">表单</td>
      <td><textarea name="setting[formtext]" rows="2" cols="20" id="options" style="height:100px;width:400px;"></textarea><BR>
	  例如：&lt;input type='text' name='info[voteid]' id='voteid' value='{FIELD_VALUE}' style='50' &gt;</td>
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
</table>