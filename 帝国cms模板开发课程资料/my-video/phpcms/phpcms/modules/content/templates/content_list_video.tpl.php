<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH;?>content_addtop.js"></script>
<style type="text/css">
	.img175{width:100px; height:75px; overflow: hidden; position:relative;}
	.hids{display:none;}
	.bghd{background-color:#000; position:absolute; width:100px; height:75px;}
	.img175 a{position:absolute; padding-left:20px; z-index:1000; left:12px;}
	.img175 a:link,.img175 a:visited{color:#fff;}
	.img175 a.aa1{background:url(<?php echo IMG_PATH?>admin_img/imgicon0.png) no-repeat 0px 4px; top:16px;}
	.img175 a.aa2{background:url(<?php echo IMG_PATH?>admin_img/imgicon1.png) no-repeat 0px 2px; top:40px;}
	.sjt{background-color:#666; position:absolute; padding:1px 2px; right:0px; z-index:90;}
	.sjt{color:#fff; background-color:rgba(0,0,0,0.4);}
	.tit_ipt,.cps_ipt{display:block; border:none; background:none; width:99%;}
	.tit_ipt{ margin-right:10px;font-weight: bold; color:#3A6EA5; margin-bottom:6px;}
	.cps_ipt{color:#999; height:4em; line-height: 18px; padding:0px;  overflow-y:hidden;}
	.iptfc{background:#fff; border: 1px solid #A7A6AA; word-wrap: break-word; word-break: normal; padding:0px; color:#666;}
</style>
<div id="closeParentTime" style="display:none"></div>
<SCRIPT LANGUAGE="JavaScript">
<!--
	if(window.top.$("#current_pos").data('clicknum')==1 || window.top.$("#current_pos").data('clicknum')==null) {
	parent.document.getElementById('display_center_id').style.display='';
	parent.document.getElementById('center_frame').src = '?m=content&c=content&a=public_categorys&type=add&menuid=<?php echo $_GET['menuid'];?>&pc_hash=<?php echo $_SESSION['pc_hash'];?>';
	window.top.$("#current_pos").data('clicknum',0);
}

$.fn.inputlimiter = function () {
    var _this = this;
    _this.mb_substr = function(str, startp, endp) {
        var i=0; c = 0; unicode=0; rstr = '';
        var len = str.length;
        var sblen = str.replace(/[^\x00-\xff]/g,"**").length;
        if (startp < 0) {
            startp = sblen + startp;
        }

        if (endp < 1) {
            endp = sblen + endp;
        }

        for(i = 0; i < len; i++) {
            if (c >= startp) {
                break;
            }
            var unicode = str.charCodeAt(i);
            if (unicode < 127) {
                c += 1;
            } else {
                c += 2;
            }
        }

        for(i = i; i < len; i++) {
            var unicode = str.charCodeAt(i);
            if (unicode < 127) {
                c += 1;
            } else {
                c += 2;
            }
            rstr += str.charAt(i);

            if (c >= endp) {
                break;
            }
        }

        return rstr;
    }

    $(this).each(function (i) {
        /*
		if ($(this).nextAll('div.textlimit').size() == 0) {
            $(this).after('<div class="textlimit">还可输入 n 字符</div>');
        }
		*/
        $(this).bind('propertychange focus keyup input paste', function () {
            var _max = $(this).attr('max');
            var _length = $(this).val().replace(/[^\x00-\xff]/g,"**").length;
            if (_length > _max) {
                $(this).val(_this.mb_substr($(this).val(), 0, _max));
            }
            _left = $(this).offset().left;
            _top = $(this).offset().top;
            _width = $(this).width();
            _height = $(this).height();

            $(this).nextAll('div.textlimit').html('还可输入 ' + (_max-_length) + ' 字符');
            $(this).nextAll('div.textlimit').css({
                'left': _left + _width + 15,
                'top': _top + _height - 12
            });
        });

        $(this).focus(function () {
            $(this).nextAll('div.textlimit').fadeIn('slow');
        });

        $(this).blur(function () {
            $(this).nextAll('div.textlimit').fadeOut('slow');
        });
    });
};
$(document).ready(function(){
	
	$('.bghd').css("opacity","0.6");
	$('.img175').hover(function(){
		$(this).find(".hids").toggle();$(this).find('.sjt').toggle();
	},function(){
		$(this).find(".hids").toggle();$(this).find('.sjt').toggle();
	});
	$(".tit_ipt,.cps_ipt").removeClass("input-text");
	$(".tit_ipt,.cps_ipt").hover(function(){
		$(this).toggleClass("iptfc").focus();
		$(this).data("vl",$(this).val());
	},function(){
		$(this).toggleClass("iptfc").blur();
		if($(this).val() == $(this).data("vl")){
		}else{
			update_param($(this).attr('id'), this);
		}
		$(this).removeData("vl");
	});
	$('textarea[max],input[max]').inputlimiter();
});
//-->
</SCRIPT>
<div class="pad-10">
<div class="content-menu ib-a blue line-x">
<a class="add fb" href="javascript:;" onclick=javascript:openwinx('?m=content&c=content&a=add&menuid=&catid=<?php echo $catid;?>&pc_hash=<?php echo $_SESSION['pc_hash'];?>','')><em><?php echo L('add_content');?></em></a>　
<a href="?m=content&c=content&a=init&catid=<?php echo $catid;?>&pc_hash=<?php echo $pc_hash;?>" <?php if($steps==0 && !isset($_GET['reject'])) echo 'class=on';?>><em><?php echo L('check_passed');?></em></a><span>|</span>
<?php echo $workflow_menu;?> <a href="javascript:;" onclick="javascript:$('#searchid').css('display','');"><em><?php echo L('search');?></em></a> 
<?php if($category['ishtml']) {?>
<span>|</span><a href="?m=content&c=create_html&a=category&pagesize=30&dosubmit=1&modelid=0&catids[0]=<?php echo $catid;?>&pc_hash=<?php echo $pc_hash;?>&referer=<?php echo urlencode($_SERVER['QUERY_STRING']);?>"><em><?php echo L('update_htmls',array('catname'=>$category['catname']));?></em></a>
<?php }?>
</div>
<div id="searchid" style="display:<?php if(!isset($_GET['search'])) echo 'none';?>">
<form name="searchform" action="" method="get" >
<input type="hidden" value="content" name="m">
<input type="hidden" value="content" name="c">
<input type="hidden" value="init" name="a">
<input type="hidden" value="<?php echo $catid;?>" name="catid">
<input type="hidden" value="<?php echo $steps;?>" name="steps">
<input type="hidden" value="1" name="search">
<input type="hidden" value="<?php echo $pc_hash;?>" name="pc_hash">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td>
		<div class="explain-col">
 
				<?php echo L('addtime');?>：
				<?php echo form::date('start_time',$_GET['start_time'],0,0,'false');?>- &nbsp;<?php echo form::date('end_time',$_GET['end_time'],0,0,'false');?>
				
				<select name="posids"><option value='' <?php if($_GET['posids']=='') echo 'selected';?>><?php echo L('all');?></option>
				<option value="1" <?php if($_GET['posids']==1) echo 'selected';?>><?php echo L('elite');?></option>
				<option value="2" <?php if($_GET['posids']==2) echo 'selected';?>><?php echo L('no_elite');?></option>
				</select>				
				<select name="searchtype">
					<option value='0' <?php if($_GET['searchtype']==0) echo 'selected';?>><?php echo L('title');?></option>
					<option value='1' <?php if($_GET['searchtype']==1) echo 'selected';?>><?php echo L('intro');?></option>
					<option value='2' <?php if($_GET['searchtype']==2) echo 'selected';?>><?php echo L('username');?></option>
					<option value='3' <?php if($_GET['searchtype']==3) echo 'selected';?>>ID</option>
				</select>
				
				<input name="keyword" type="text" value="<?php if(isset($keyword)) echo $keyword;?>" class="input-text" />
				<input type="submit" name="search" class="button" value="<?php echo L('search');?>" />
	</div>
		</td>
		</tr>
    </tbody>
</table>
</form>
</div>
<form name="myform" id="myform" action="" method="post" >
<div class="table-list">
    <table width="100%">
        <thead>
            <tr>
			 <th width="16"><input type="checkbox" value="" id="check_box" onclick="selectall('ids[]');"></th>
            <th width="37"><?php echo L('listorder');?></th>
            <th width="40">ID</th>
			<th width="60"><?php echo L('thumb');?></th>
			<th><?php echo L('title');?></th>
            <th width="40"><?php echo L('hits');?></th>
            <th width="70"><?php echo L('publish_user');?></th>
            <th width="118"><?php echo L('updatetime');?></th>
			<th width="72"><?php echo L('operations_manage');?></th>
            </tr>
        </thead>
<tbody>
    <?php
	if(is_array($datas)) {
		$sitelist = getcache('sitelist','commons');
		$release_siteurl = $sitelist[$category['siteid']]['url'];
		$path_len = -strlen(WEB_PATH);
		$release_siteurl = substr($release_siteurl,0,$path_len);
		$this->hits_db = pc_base::load_model('hits_model');
		
		foreach ($datas as $r) {
			$hits_r = $this->hits_db->get_one(array('hitsid'=>'c-'.$modelid.'-'.$r['id']));
	?>
        <tr>
		<td align="center"><input class="inputcheckbox " name="ids[]" value="<?php echo $r['id'];?>" type="checkbox"></td>
        <td align='center'><input name='listorders[<?php echo $r['id'];?>]' type='text' size='3' value='<?php echo $r['listorder'];?>' class='input-text-c'></td>
		<td align='center' ><?php echo $r['id'];?></td>
		<td>
		<div class="img175">
			<div class="hids">
			<a href="<?php echo $r['url'];?>" target="_blank" class="aa1"><?php echo L('view_video');?></a>
			<a href="javascript:void(0);" onclick="upthumb('<?php echo $r['id']?>')" class="aa2"><?php echo L('change_thumb');?></a>
			<div class="bghd"></div>
			</div>
			<div class="sjt">03:13</div>
			<img src="<?php echo $r['thumb'] ? $r['thumb'] : IMG_PATH.'admin_img/bfqicon1.jpg';?>" id="thumb_images_<?php echo $r['id']?>" width="100px" />
		</div>
		</td>
		<td valign="top">
		<div class="iptd"><input class="tit_ipt" value="<?php echo $r['title'];?>" type="text" id="title_<?php echo $r['id'];?>"></input>
		<textarea name="description" cols="96%" rows="3" id="description_<?php echo $r['id'];?>" max="255" class="cps_ipt"><?php echo $r['description']?></textarea>
		</div>
		</td>
		<td align='center' title="<?php echo L('today_hits');?>：<?php echo $hits_r['dayviews'];?>&#10;<?php echo L('yestoday_hits');?>：<?php echo $hits_r['yestodayviews'];?>&#10;<?php echo L('week_hits');?>：<?php echo $hits_r['weekviews'];?>&#10;<?php echo L('month_hits');?>：<?php echo $hits_r['monthviews'];?>"><?php echo $hits_r['views'];?></td>
		<td align='center'>
		<?php
		if($r['sysadd']==0) {
			echo "<a href='?m=member&c=member&a=memberinfo&username=".urlencode($r['username'])."&pc_hash=".$_SESSION['pc_hash']."' >".$r['username']."</a>"; 
			echo '<img src="'.IMG_PATH.'icon/contribute.png" title="'.L('member_contribute').'">';
		} else {
			echo $r['username'];
		}
		?></td>
		<td align='center'><?php echo format::date($r['updatetime'],1);?></td>
		<td align='center'><a href="javascript:;" onclick="javascript:openwinx('?m=content&c=content&a=edit&catid=<?php echo $catid;?>&id=<?php echo $r['id']?>','')"><?php echo L('edit');?></a> | <a href="javascript:view_comment('<?php echo id_encode('content_'.$catid,$r['id'],$this->siteid);?>','<?php echo safe_replace($r['title']);?>')"><?php echo L('comment');?></a></td>
	</tr>
     <?php }
	}
	?>
</tbody>
     </table>
    <div class="btn"><label for="check_box"><?php echo L('selected_all');?>/<?php echo L('cancel');?></label>
		<input type="hidden" value="<?php echo $pc_hash;?>" name="pc_hash">
    	<input type="button" class="button" value="<?php echo L('listorder');?>" onclick="myform.action='?m=content&c=content&a=listorder&dosubmit=1&catid=<?php echo $catid;?>&steps=<?php echo $steps;?>';myform.submit();"/>
		<?php if($category['content_ishtml']) {?>
		<input type="button" class="button" value="<?php echo L('createhtml');?>" onclick="myform.action='?m=content&c=create_html&a=batch_show&dosubmit=1&catid=<?php echo $catid;?>&steps=<?php echo $steps;?>';myform.submit();"/>
		<?php }
		if($status!=99) {?>
		<input type="button" class="button" value="<?php echo L('passed_checked');?>" onclick="myform.action='?m=content&c=content&a=pass&catid=<?php echo $catid;?>&steps=<?php echo $steps;?>';myform.submit();"/>
		<?php }?>
		<input type="button" class="button" value="<?php echo L('delete');?>" onclick="myform.action='?m=content&c=content&a=delete&dosubmit=1&catid=<?php echo $catid;?>&steps=<?php echo $steps;?>';return confirm_delete()"/>
		<?php if(!isset($_GET['reject'])) { ?>
		<input type="button" class="button" value="<?php echo L('push');?>" onclick="push();"/>
		<?php if($workflow_menu) { ?><input type="button" class="button" value="<?php echo L('reject');?>" onclick="reject_check()"/>
		<div id='reject_content' style='background-color: #fff;border:#006699 solid 1px;position:absolute;z-index:10;padding:1px;display:none;'>
		<table cellpadding='0' cellspacing='1' border='0'><tr><tr><td colspan='2'><textarea name='reject_c' id='reject_c' style='width:300px;height:46px;'  onfocus="if(this.value == this.defaultValue) this.value = ''" onblur="if(this.value.replace(' ','') == '') this.value = this.defaultValue;"><?php echo L('reject_msg');?></textarea></td><td><input type='button' value=' <?php echo L('submit');?> ' class="button" onclick="reject_check(1)"></td></tr>
		</table>
		</div>
		<?php }}?>
		<input type="button" class="button" value="<?php echo L('remove');?>" onclick="myform.action='?m=content&c=content&a=remove&catid=<?php echo $catid;?>';myform.submit();"/>
		<?php echo runhook('admin_content_init')?>
	</div>
    <div id="pages"><?php echo $pages;?></div>
</div>
</form>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH;?>swfupload/swf2ckeditor.js"></script>
</div>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>cookie.js"></script>
<script type="text/javascript"> 
<!--
function push() {
	var str = 0;
	var id = tag = '';
	$("input[name='ids[]']").each(function() {
		if($(this).attr('checked')=='checked') {
			str = 1;
			id += tag+$(this).val();
			tag = '|';
		}
	});
	if(str==0) {
		alert('<?php echo L('you_do_not_check');?>');
		return false;
	}
	window.top.art.dialog({id:'push'}).close();
	window.top.art.dialog({title:'<?php echo L('push');?>：',id:'push',iframe:'?m=content&c=push&action=position_list&catid=<?php echo $catid?>&modelid=<?php echo $modelid?>&id='+id,width:'800',height:'500'}, function(){var d = window.top.art.dialog({id:'push'}).data.iframe;// 使用内置接口获取iframe对象
	var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'push'}).close()});
}
function confirm_delete(){
	if(confirm('<?php echo L('confirm_delete', array('message' => L('selected')));?>')) $('#myform').submit();
}
function view_comment(id, name) {
	window.top.art.dialog({id:'view_comment'}).close();
	window.top.art.dialog({yesText:'<?php echo L('dialog_close');?>',title:'<?php echo L('view_comment');?>：'+name,id:'view_comment',iframe:'index.php?m=comment&c=comment_admin&a=lists&show_center_id=1&commentid='+id,width:'800',height:'500'}, function(){window.top.art.dialog({id:'edit'}).close()});
}
function reject_check(type) {
	if(type==1) {
		var str = 0;
		$("input[name='ids[]']").each(function() {
			if($(this).attr('checked')=='checked') {
				str = 1;
			}
		});
		if(str==0) {
			alert('<?php echo L('you_do_not_check');?>');
			return false;
		}
		document.getElementById('myform').action='?m=content&c=content&a=pass&catid=<?php echo $catid;?>&steps=<?php echo $steps;?>&reject=1';
		document.getElementById('myform').submit();
	} else {
		$('#reject_content').css('display','');
		return false;
	}	
}

function update_param(fid, obj) {
	var id_arr = new Array();
	id_arr = fid.split("_");
	var field = id_arr[0];
	var id = id_arr[1];
	var modelid = '<?php echo $modelid;?>';
	var value = $(obj).val();
	var old_data = $(obj).data("vl");
	$.ajaxSettings.async = false;
	$.get('index.php', {m:'content', c:'content', a:'update_param', field:field, id:id, value:value, modelid:modelid, pc_hash:'<?php echo $_SESSION['pc_hash'];?>'}, function (data){
		if (data!=200){
            $(obj).val(old_data);
		}
	})
}

function upthumb(fid) {
	window.top.art.dialog({title:'更换缩略图',id:'update_thumb',iframe:'index.php?m=attachment&c=attachments&a=swfupload&args=<?php echo $args;?>&module=content&catid=<?php echo $catid;?>&authkey=<?php echo $authkey;?>',width:'500',height:'420'}, function(){ var d = window.top.art.dialog({id:'update_thumb'}).data.iframe;var did = d.document.getElementById('att-status');var content = $(did).html();
	var content_arr = new Array(); content_arr = content.split('|');var value = content_arr[1];if (value){var thumb_old = $('#thumb_images_'+fid).attr('src');$.ajaxSettings.async = false;$.get('index.php', {m:'content', c:'content', a:'update_param', field:'thumb', id:fid, value:value, modelid:'<?php echo $modelid;?>', pc_hash:'<?php echo $_SESSION['pc_hash'];?>'}, function (data){
		if (data==200){
            $('#thumb_images_'+fid).attr('src', value);
		}
	});window.top.art.dialog({id:'update_thumb'}).close();} else {alert('请先选择缩略图！');return false;}}, function(){window.top.art.dialog({id:'update_thumb'}).close()});
}

setcookie('refersh_time', 0);
function refersh_window() {
	var refersh_time = getcookie('refersh_time');
	if(refersh_time==1) {
		window.location.reload();
	}
}
setInterval("refersh_window()", 3000);
//-->
</script>
</body>
</html>