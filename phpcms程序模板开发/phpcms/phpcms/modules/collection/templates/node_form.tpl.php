<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<script type="text/javascript">
$(document).ready(function() {
	$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'})}});
	$("#name").formValidator({onshow:"<?php echo L('input').L('nodename')?>",onfocus:"<?php echo L('input').L('nodename')?>"}).inputValidator({min:1,onerror:"<?php echo L('input').L('nodename')?>"}).ajaxValidator({type : "get",url : "",data :"m=collection&c=node&a=public_name<?php if(ROUTE_A=='edit')echo "&nodeid=$data[nodeid]"?>",datatype : "html",async:'false',success : function(data){	if( data == "1" ){return true;}else{return false;}},buttons: $("#dosubmit"),onerror : "<?php echo L('nodename').L('exists')?>",onwait : "<?php echo L('connecting')?>"})<?php if(ROUTE_A=='edit')echo ".defaultPassed()"?>;

});
</script>
<div class="pad-10">
<div class="col-tab">
<ul class="tabBut cu-li">
<li class="on" id="tab_1"><a href="javascript:show_div('1')"><?php echo L('url_rewrites')?></a></li>
<li  id="tab_2"><a href="javascript:show_div('2')"><?php echo L('content_rules')?></a></li>
<li  id="tab_3"><a href="javascript:show_div('3')"><?php echo L('custom_rule')?></a></li>
<li  id="tab_4"><a href="javascript:show_div('4')"><?php echo L('eigrp')?></a></li>
</ul>
<form name="myform" action="?m=collection&c=node&a=<?php echo ROUTE_A?>&nodeid=<?php if(isset($nodeid)) echo $nodeid?>" method="post" id="myform">
<div class="content pad-10" id="show_div_1" style="height:auto">
<div class="common-form">
<fieldset>
	<legend><?php echo L('basic_configuration')?></legend>
	<table width="100%" class="table_form">
		<tr>
			<td width="120"><?php echo L('collection_items_of')?>：</td> 
			<td>
			<input type="text" name="data[name]" id="name"  class="input-text" value="<?php if(isset($data['name'])) echo $data['name']?>"></input>
			</td>
		</tr>
		<tr>
			<td width="120"><?php echo L('encode_varchar')?>：</td> 
			<td>
			<?php echo form::radio(array('gbk'=>'GBK', 'utf-8'=>'UTF-8', 'big5'=>'BIG5'), (isset($data['sourcecharset']) ? $data['sourcecharset'] : 'gbk'), 'name="data[sourcecharset]"')?>
			</td>
		</tr>
	</table>
</fieldset>
<fieldset>
	<legend><?php echo L('web_sites_to_collect')?></legend>
	<table width="100%" class="table_form">
		<tr>
			<td width="120"><?php echo L('url_type')?>：</td> 
			<td>
			<?php echo form::radio($this->url_list_type, (isset($data['sourcetype']) ? $data['sourcetype'] : '1'), 'name="data[sourcetype]" onclick="show_url_type(this.value)"')?>
			</td>
		</tr>
		<tbody id="url_type_1" <?php if (isset($data['sourcetype'])  && $data['sourcetype'] != 1){echo ' style="display:none"';}?>>
		<tr>
			<td width="120"><?php echo L('url_configuration')?>：</td> 
			<td>
			 <input type="text" name="urlpage1" id="urlpage_1" size="100" value="<?php if(isset($data['sourcetype']) && $data['sourcetype'] == 1 && isset($data['urlpage'])) echo $data['urlpage'];?>"> <input type="button" class="button" onclick="show_url()" value="<?php echo L('test')?>"><br /> 
			<?php echo L('url_msg')?><br />
			 <?php echo L('page_from')?>: <input type="text" name="data[pagesize_start]" value="<?php if(isset($data['sourcetype']) && $data['sourcetype'] == 1 && isset($data['pagesize_start'])) { echo $data['pagesize_start'];} else { echo '1';}?>" size="4"> <?php echo L('to')?> <input type="text" name="data[pagesize_end]" value="<?php if(isset($data['sourcetype']) && $data['sourcetype'] == 1 && isset($data['pagesize_end'])) { echo $data['pagesize_end'];} else { echo '10';}?>" size="4"> <?php echo L('increment_by')?><input type="text" name="data[par_num]" size="4" value="<?php if(isset($data['sourcetype']) && $data['sourcetype'] == 1 && isset($data['par_num'])) { echo $data['par_num'];} else { echo '1';}?>">
			</td>
		</tr>
		</tbody>
		<tbody id="url_type_2"  <?php if (!isset($data['sourcetype']) || $data['sourcetype'] != 2){echo ' style="display:none"';}?>>
		<tr>
			<td width="120"><?php echo L('url_configuration')?>：</td> 
			<td>
			<textarea rows="10" cols="80" name="urlpage2" id="urlpage_2" ><?php if(isset($data['sourcetype']) && $data['sourcetype'] == 2 && isset($data['urlpage'])) { echo $data['urlpage'];}?></textarea> <br><?php echo L('one_per_line')?>
			</td>
		</tr>
		</tbody>
		<tbody id="url_type_3"  <?php if (!isset($data['sourcetype']) || $data['sourcetype'] != 3){echo ' style="display:none"';}?>>
		<tr>
			<td width="120"><?php echo L('url_configuration')?>：</td> 
			<td>
			 <input type="text" name="urlpage3" id="urlpage_3" size="100" value="<?php if(isset($data['sourcetype']) && $data['sourcetype'] == 3 && isset($data['urlpage'])) { echo $data['urlpage'];}?>">
			</td>
		</tr>
		</tbody>
		<tbody id="url_type_4"  <?php if (!isset($data['sourcetype']) || $data['sourcetype'] != 4){echo ' style="display:none"';}?>>
		<tr>
			<td width="120"><?php echo L('url_configuration')?>：</td> 
			<td>
			 <input type="text" name="urlpage4" id="urlpage_4" size="100" value="<?php if(isset($data['sourcetype']) && $data['sourcetype'] == 4 && isset($data['urlpage'])) { echo $data['urlpage'];}?>">
			</td>
		</tr>
		</tbody>
		<tr>
			<td width="120"><?php echo L('url_configuration')?>：</td> 
			<td>
			<?php echo L('site_must_contain')?><input type="text" name="data[url_contain]"  value="<?php if(isset($data['url_contain'])) echo $data['url_contain']?>"> <?php echo L('the_web_site_does_not_contain')?><input type="text" name="data[url_except]"  value="<?php if(isset($data['url_except'])) echo $data['url_except']?>">
			</td>
		</tr>
			<tr>
			<td width="120"><?php echo L('base_configuration')?>：</td> 
			<td>
			<input type="text" name="data[page_base]"  value="<?php if(isset($data['page_base'])) echo $data['page_base']?>" size="100" ><br>
			<?php echo L('base_msg')?>
			</td>
		</tr>
		<tr>
			<td width="120"><?php echo L('get_url')?>：</td> 
			<td>
			<?php echo L('from')?> <textarea rows="10" cols="40" name="data[url_start]"><?php if(isset($data['url_start'])) echo $data['url_start']?></textarea> <?php echo L('to')?> <textarea rows="10" name="data[url_end]" cols="40"><?php if(isset($data['url_end'])) echo $data['url_end']?></textarea> <?php echo L('finish')?>
			</td>
		</tr>
	</table>
</fieldset>

</div>
</div>
<div class="content pad-10" id="show_div_2" style="height:auto;display:none">
<div class="explain-col">
<?php echo L('rule_msg')?>
</div>
<div class="bk15"></div>
<input type="button" class="button" value="<?php echo L('expand_all')?>" onclick="$('#show_div_2').children('fieldset').children('.table_form').show()"> <input type="button" class="button" value="<?php echo L('all_the')?>" onclick="$('#show_div_2').children('fieldset').children('.table_form').hide()">
<fieldset>
	<legend><a href="javascript:void(0)" onclick="$(this).parent().parent().children('table').toggle()"><?php echo L('title').L('rule')?></a></legend>
	<table width="100%" class="table_form">
		<tr>
			<td width="120"><?php echo L('matching_rule')?>：</td> 
			<td>
			<textarea rows="5" cols="40" name="data[title_rule]" id="title_rule"><?php if(isset($data['title_rule'])) {echo $data['title_rule'];}else{echo '<title>'.L('[content]').'</title>';}?></textarea> <br><?php echo L('use')?>"<a href="javascript:insertText('title_rule', '<?php echo L('[content]')?>')"><?php echo L('[content]')?></a>"<?php echo L('w_wildmenu')?>
			</td>
			<td width="120"><?php echo L('filtering')?>：</td> 
			<td>
			<textarea rows="5" cols="50" name="data[title_html_rule]" id="title_html_rule"><?php if(isset($data['title_html_rule'])) echo $data['title_html_rule']?></textarea>
			<input type="button" value="<?php echo L('select')?>" class="button"  onclick="html_role('data[title_html_rule]')">
			</td>
		</tr>
	</table>
</fieldset>
<fieldset>
	<legend><a href="javascript:void(0)" onclick="$(this).parent().parent().children('table').toggle()"><?php echo L('author').L('rule')?></a></legend>
	<table width="100%" class="table_form" style="display:none">
		<tr>
			<td width="120"><?php echo L('matching_rule')?>：</td> 
			<td>
			<textarea rows="5" cols="40" name="data[author_rule]" id="author_rule"><?php if(isset($data['author_rule'])) echo $data['author_rule']?></textarea>  <br><?php echo L('use')?>"<a href="javascript:insertText('author_rule', '<?php echo L('[content]')?>')"><?php echo L('[content]')?></a>"<?php echo L('w_wildmenu')?>
			</td>
			<td width="120"><?php echo L('filtering')?>：</td> 
			<td>
			<textarea rows="5" cols="50" name="data[author_html_rule]" id="author_html_rule"><?php if(isset($data['author_html_rule'])) echo $data['author_html_rule']?></textarea>
			<input type="button" value="<?php echo L('select')?>" class="button"  onclick="html_role('data[author_html_rule]')">
			</td>
		</tr>
	</table>
</fieldset>
<fieldset>
	<legend><a href="javascript:void(0)" onclick="$(this).parent().parent().children('table').toggle()"><?php echo L('comeform').L('rule')?></a></legend>
	<table width="100%" class="table_form" style="display:none">
		<tr>
			<td width="120"><?php echo L('matching_rule')?>：</td> 
			<td>
			<textarea rows="5" cols="40" name="data[comeform_rule]" id="comeform_rule"><?php if(isset($data['comeform_rule'])) echo $data['comeform_rule']?></textarea> <br><?php echo L('use')?>"<a href="javascript:insertText('comeform_rule', '<?php echo L('[content]')?>')"><?php echo L('[content]')?></a>"<?php echo L('w_wildmenu')?>
			</td>
			<td width="120"><?php echo L('filtering')?>：</td> 
			<td>
			<textarea rows="5" cols="50" name="data[comeform_html_rule]" id="comeform_html_rule"><?php if(isset($data['comeform_html_rule'])) echo $data['comeform_html_rule']?></textarea>
			<input type="button" value="<?php echo L('select')?>" class="button"  onclick="html_role('data[comeform_html_rule]')">
			</td>
		</tr>
	</table>
</fieldset>
<fieldset>
	<legend><a href="javascript:void(0)" onclick="$(this).parent().parent().children('table').toggle()"><?php echo L('time').L('rule')?></a></legend>
	<table width="100%" class="table_form"  style="display:none">
		<tr>
			<td width="120"><?php echo L('matching_rule')?>：</td> 
			<td>
			<textarea rows="5" cols="40" name="data[time_rule]" id="time_rule"><?php if(isset($data['time_rule'])) echo $data['time_rule']?></textarea> <br><?php echo L('use')?>"<a href="javascript:insertText('time_rule', '<?php echo L('[content]')?>')"><?php echo L('[content]')?></a>"<?php echo L('w_wildmenu')?>
			</td>
			<td width="120"><?php echo L('filtering')?>：</td> 
			<td>
			<textarea rows="5" cols="50" name="data[time_html_rule]" id="time_html_rule"><?php if(isset($data['time_html_rule'])) echo $data['time_html_rule']?></textarea>
			<input type="button" value="<?php echo L('select')?>" class="button"  onclick="html_role('data[time_html_rule]')">
			</td>
		</tr>
	</table>
</fieldset>
<fieldset>
	<legend><a href="javascript:void(0)" onclick="$(this).parent().parent().children('table').toggle()"><?php echo L('content').L('rule')?></a></legend>
	<table width="100%" class="table_form" style="display:none">
		<tr>
			<td width="120"><?php echo L('matching_rule')?>：</td> 
			<td>
			<textarea rows="5" cols="40" name="data[content_rule]" id="content_rule"><?php if(isset($data['content_rule'])) echo $data['content_rule']?></textarea> <br><?php echo L('use')?>"<a href="javascript:insertText('content_rule', '<?php echo L('[content]')?>')"><?php echo L('[content]')?></a>"<?php echo L('w_wildmenu')?>
			</td>
			<td width="120"><?php echo L('filtering')?>：</td> 
			<td>
			<textarea rows="5" cols="50" name="data[content_html_rule]" id="content_html_rule"><?php if(isset($data['content_html_rule'])) echo $data['content_html_rule']?></textarea>
			<input type="button" value="<?php echo L('select')?>" class="button"  onclick="html_role('data[content_html_rule]')">
			</td>
		</tr>
	</table>
</fieldset>
<fieldset>
	<legend><a href="javascript:void(0)" onclick="$(this).parent().parent().children('table').toggle()"><?php echo L('content_page').L('rule')?></a></legend>
	<table width="100%" class="table_form" style="display:none">
		<tr>
			<td width="120"><?php echo L('page_mode')?>：</td> 
			<td>
			<?php echo form::radio(array('1'=>L('all_are_models'), '2'=>L('down_the_pages_mode')), (isset($data['content_page_rule']) ? $data['content_page_rule'] : 1), 'name="data[content_page_rule]" onclick="show_nextpage(this.value)"')?>
			</td>
			</tr>
		<tbody id="nextpage" <?php if(!isset($data['content_page_rule']) || $data['content_page_rule']!=2) echo 'style="display:none"'?>>
			<tr>
			<td width="120"><?php echo L('nextpage_rule')?>：</td> 
			<td>
			<input type="text" name="data[content_nextpage]" size="100" value="<?php if(isset($data['content_nextpage'])) echo $data['content_nextpage']?>"><br>
			<?php echo L('nextpage_rule_msg')?>
			</td>
			</tr>
		</tbody>
		<tr>
			<td width="120"><?php echo L('matching_rule')?>：</td> 
			<td>
			<?php echo L('from')?> <textarea rows="5" cols="40" name="data[content_page_start]" id="content_page_start"><?php if(isset($data['content_page_start'])) echo $data['content_page_start']?></textarea> <?php echo L('to')?> <textarea rows="5" cols="40" name="data[content_page_end]" id="content_page_end"><?php if(isset($data['content_page_end'])) echo $data['content_page_end']?></textarea>
			</td>
			</tr>
	</table>
</fieldset>
</div>

<div class="content pad-10" id="show_div_3" style="height:auto;display:none">
<input type="button" class="button" value="<?php echo L('add_item')?>" onclick="add_caiji()">
<div class="bk10"></div>
<table width="100%" class="table_form" id="customize_config">
<?php if(isset($data['customize_config']) && is_array($data['customize_config'])) foreach ($data['customize_config'] as $k=>$v):?>
<tbody id="customize_config_<?php echo $k?>"><tr style="background-color:#FBFFE4"><td><?php echo L('rulename')?>：</td><td><input type="text" name="customize_config[name][<?php echo $k?>]" value="<?php echo $v['name']?>" class="input-text" /></td><td><?php echo L('rules_in_english')?>：</td><td><input type="text" name="customize_config[en_name][<?php echo $k?>]" value="<?php echo $v['en_name']?>" class="input-text" /></td></tr><tr><td width="120"><?php echo L('matching_rule')?>：</td><td><textarea rows="5" cols="40" name="customize_config[rule][<?php echo $k?>]" id="rule_<?php echo $k?>"><?php echo $v['rule']?></textarea> <br><?php echo L('use')?>"<a href="javascript:insertText('rule_<?php echo $k?>', '<?php echo L('[content]')?>')"><?php echo L('[content]')?></a>"<?php echo L('w_wildmenu')?></td><td width="120"><?php echo L('filtering')?>：</td><td><textarea rows="5" cols="50" name="customize_config[html_rule][<?php echo $k?>]"><?php echo $v['html_rule']?></textarea><input type="button" value="<?php echo L('select')?>" class="button"  onclick="html_role('customize_config[html_rule][<?php echo $k?>]')"></td></tr></tbody>
<?php endforeach;?>
	</table>
</div>

<div class="content pad-10" id="show_div_4" style="height:auto;display:none">
<table width="100%" class="table_form" >
		<tr>
			<td width="120"><?php echo L('download_pic')?>：</td> 
			<td>
			<?php echo form::radio(array('1'=>L('download_pic'), '0'=>L('no_download')), (isset($data['down_attachment']) ? $data['down_attachment'] : '0'), 'name="data[down_attachment]"')?>
			</td>
		</tr>
		<tr>
			<td width="120"><?php echo L('watermark')?>：</td> 
			<td>
			<?php echo form::radio(array('1'=>L('gfl_sdk'), '0'=>L('no_gfl_sdk')), (isset($data['watermark']) ? $data['watermark'] : '0'), 'name="data[watermark]"')?>
			</td>
		</tr>
		<tr>
			<td width="120"><?php echo L('content_page_models')?>：</td> 
			<td>
			<?php echo form::radio(array('0'=>L('no_page'), '1'=>L('by_the_paging')), (isset($data['content_page']) ? $data['content_page'] : '1'), 'name="data[content_page]"')?>
			</td>
		</tr>
		<tr>
			<td width="120"><?php echo L('sort_order')?>：</td> 
			<td>
			<?php echo form::radio(array('1'=>L('with_goals_from_the_same'), '2'=>L('and_objectives_of_the_standing_opposite')), (isset($data['coll_order']) ? $data['coll_order'] : '1'), 'name="data[coll_order]"')?>
			</td>
		</tr>
	</table>
</div>
</div>


    <div class="bk15"></div>
    <input name="dosubmit" type="submit" id="dosubmit" value="<?php echo L('submit')?>" class="button">
</div>

</form>
<script type="text/javascript">
<!--
function insertText(id, text)
{
	$('#'+id).focus();
    var str = document.selection.createRange();
	str.text = text;
}

function show_url_type(obj) {
	var num = <?php echo count($this->url_list_type);?>;
	for (var i=1; i<=num; i++){
		if (obj==i){ 
			$('#url_type_'+i).show();
		} else {
			$('#url_type_'+i).hide();
		}
	}
}

function show_div(id) {
	for (var i=1;i<=4;i++) {
		if (id==i) {
			$('#tab_'+i).addClass('on');
			$('#show_div_'+i).show();
		} else {
			$('#tab_'+i).removeClass('on');
			$('#show_div_'+i).hide();
		}
	}
}


function show_url() {
	var type = $("input[type='radio'][name='data[sourcetype]']:checked").val();
	window.top.art.dialog({id:'test_url',iframe:'?m=collection&c=node&a=public_url&sourcetype='+type+'&urlpage='+$('#urlpage_'+type).val()+'&pagesize_start='+$("input[name='data[pagesize_start]']").val()+'&pagesize_end='+$("input[name='data[pagesize_end]']").val()+'&par_num='+$("input[name='data[par_num]']").val(), title:'<?php echo L('testpageurl')?>', width:'700', height:'450'}, '', function(){window.top.art.dialog({id:'test_url'}).close()});
			
}

function anti_selectall(obj) {
	$("input[name='"+obj+"']").each(function(i,n){
		if (this.checked) {
			this.checked = false;
		} else {
			this.checked = true;
		}});
}

function show_nextpage(value) {
	if (value == 2) {
		$('#nextpage').show();
	} else {
		$('#nextpage').hide();
	}
}

var i =<?php echo  isset($data['customize_config']) ? count($data['customize_config']) : 0?>;
function add_caiji() {
	var html = '<tbody id="customize_config_'+i+'"><tr style="background-color:#FBFFE4"><td><?php echo L('rulename')?>：</td><td><input type="text" name="customize_config[name][]" class="input-text" /></td><td><?php echo L('rules_in_english')?>：</td><td><input type="text" name="customize_config[en_name][]" class="input-text" /></td></tr><tr><td width="120"><?php echo L('matching_rule')?>：</td><td><textarea rows="5" cols="40" name="customize_config[rule][]" id="rule_'+i+'"></textarea> <br><?php echo L('use')?>"<a href="javascript:insertText(\'rule_'+i+'\', \'<?php echo L('[content]')?>\')"><?php echo L('[content]')?></a>"<?php echo L('w_wildmenu')?></td><td width="120"><?php echo L('filtering')?>：</td><td><textarea rows="5" cols="50" name="customize_config[html_rule][]" id="content_html_rule_'+i+'"></textarea><input type="button" value="<?php echo L('select')?>" class="button"  onclick="html_role(\'content_html_rule_'+i+'\', 1)"></td></tr></tbody>';
	$('#customize_config').append(html);
	i++;
}

function html_role(id, type) {
	art.dialog({id:'test_url',content:'<?php echo form::checkbox(self::$html_tag, '', 'name="html_rule"', '', '120')?><br><div class="bk15"></div><center><input type="button" value="<?php echo L('select_all')?>" class="button"  onclick="selectall(\'html_rule\')"> <input type="button" class="button"  value="<?php echo L('invert')?>" onclick="anti_selectall(\'html_rule\')"></center>', width:'500', height:'150', lock: false}, function(){var old = $("textarea[name='"+id+"']").val();var str = '';$("input[name='html_rule']:checked").each(function(){str+=$(this).val()+"\n";});$((type == 1 ? "#"+id :"textarea[name='"+id+"']")).val((old ? old+"\n" : '')+str);}, function(){art.dialog({id:'test_url'}).close()});
}
<?php if (ROUTE_A == 'edit') echo '$(\'#show_div_2\').children(\'fieldset\').children(\'.table_form\').show();';?>
//-->
</script>
</body>
</html>