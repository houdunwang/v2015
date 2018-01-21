<table cellpadding="2" cellspacing="1" bgcolor="#ffffff">
	<tr> 
      <td><strong>时间格式：</strong></td>
      <td>
	  <input type="radio" name="setting[fieldtype]" value="date" checked>日期（<?php echo date('Y-m-d')?>）<br />
	  <input type="radio" name="setting[fieldtype]" value="datetime">日期+时间（<?php echo date('Y-m-d H:i:s')?>）<br />
	  <input type="radio" name="setting[fieldtype]" value="int">整数 显示格式：
	  <select name="setting[format]">
	  <option value="Y-m-d H:i:s"><?php echo date('Y-m-d H:i:s')?></option>
	  <option value="Y-m-d H:i"><?php echo date('Y-m-d H:i')?></option>
	  <option value="Y-m-d"><?php echo date('Y-m-d')?></option>
	  <option value="m-d"><?php echo date('m-d')?></option>
	  </select>
	  </td>
    </tr>
	<tr> 
      <td><strong>默认值：</strong></td>
      <td>
	  <input type="radio" name="setting[defaulttype]" value="0" checked/>无<br />
	 </td>
    </tr>
</table>