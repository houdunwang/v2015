<table cellpadding="2" cellspacing="1" width="98%">
	<tr> 
      <td width="100">取值范围</td>
      <td><input type="text" name="setting[minnumber]" value="1" size="5" class="input-text"> - <input type="text" name="setting[maxnumber]" value="" size="5" class="input-text"></td>
    </tr>
	<tr> 
      <td>小数位数：</td>
      <td>
	  <select name="setting[decimaldigits]">
	  <option value="-1">自动</option>
	  <option value="0" selected>0</option>
	  <option value="1">1</option>
	  <option value="2">2</option>
	  <option value="3">3</option>
	  <option value="4">4</option>
	  <option value="5">5</option>
	  </select>
    </td>
    </tr>
	<tr> 
      <td>默认值</td>
      <td><input type="text" name="setting[defaultvalue]" value="<?php echo $defaultvalue?>" size="40" class="input-text"></td>
    </tr>

	<tr> 
	  <td>是否作为区间字段</td>
	  <td>
	  <input type="radio" name="setting[rangetype]" value="1"/> 是 
	  <input type="radio" name="setting[rangetype]" value="0" checked />否 　　注：区间字段可以通过filters('字段名称','模型id','自定义数组')调用
	  </td>
	</tr>	
</table>