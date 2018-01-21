function video_store_select(uploadid, name, textareaid, funcName, pc_hash) {
	window.top.art.dialog({title:name,id:uploadid,iframe:'index.php?m=video&c=video&a=video2content&pc_hash='+pc_hash,width:'565',height:'420'}, function(){ if(funcName) {funcName.apply(this,[uploadid,textareaid]);}else {submit_ckeditor(uploadid,textareaid);}}, function(){window.top.art.dialog({id:uploadid}).close()});
}