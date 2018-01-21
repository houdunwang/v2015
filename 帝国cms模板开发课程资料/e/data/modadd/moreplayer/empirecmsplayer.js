
//show
function EmpireCMSPlayVideo(vtype,furl,width,height,autostart,baseurl){
	var filetype;
	var cfiletype;
	var playstr='';
	var filetypeflash='|.swf|';
	var filetypeflv='|.flv|';
	var filetypemediaplayer='|.wmv|.asf|.wma|.mp3|.asx|.mid|.midi|';
	var filetyperealplayer='|.rm|.ra|.rmvb|.mp4|.mov|.avi|.wav|.ram|.mpg|.mpeg|';
	var filetypejwplayer='|.flv|.mp4|';
	if(vtype=='auto'||vtype=='')
	{
		filetype=EmpireCMSPlayerGetFiletype(furl);
		cfiletype='|'+filetype+'|';
		if(filetypejwplayer.indexOf(cfiletype)!=-1)//jwplayer
		{
			playstr=EmpireCMSShowJwplayer(furl,width,height,autostart,baseurl);
		}
		else if(filetypeflash.indexOf(cfiletype)!=-1)//flash
		{
			playstr=EmpireCMSShowFlash(furl,width,height,autostart,baseurl);
		}
		else if(filetyperealplayer.indexOf(cfiletype)!=-1)//realplayer
		{
			playstr=EmpireCMSShowRealPlayer(furl,width,height,autostart,baseurl);
		}
		else//mediaplayer
		{
			playstr=EmpireCMSShowMediaPlayer(furl,width,height,autostart,baseurl);
		}
	}
	else
	{
		if(vtype=='jwplayer')//jwplayer
		{
			playstr=EmpireCMSShowJwplayer(furl,width,height,autostart,baseurl);
		}
		else if(vtype=='flash')//flash
		{
			playstr=EmpireCMSShowFlash(furl,width,height,autostart,baseurl);
		}
		else if(vtype=='realplayer')//realplayer
		{
			playstr=EmpireCMSShowRealPlayer(furl,width,height,autostart,baseurl);
		}
		else//mediaplayer
		{
			playstr=EmpireCMSShowMediaPlayer(furl,width,height,autostart,baseurl);
		}
	}
	document.write(playstr);
}

//filetype
function EmpireCMSPlayerGetFiletype(sfile){
	var filetype,s;
	s=sfile.lastIndexOf(".");
	filetype=sfile.substring(s+1).toLowerCase();
	return '.'+filetype;
}

//flash
function EmpireCMSShowFlash(furl,width,height,autostart,baseurl){
	var str='';
	str='<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="'+width+'" height="'+height+'"><param name="movie" value="'+furl+'"><param name="quality" value="high"><embed src="'+furl+'" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="'+width+'" height="'+height+'" autostart="'+autostart+'"></embed></object>';
	return str;
}

//flv
function EmpireCMSShowFlv(furl,width,height,autostart,baseurl){
	var str='';
	var fname='';
	str='<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="'+width+'" height="'+height+'"><param name="movie" value="'+baseurl+'e/data/modadd/moreplayer/flv/flvplayer.swf?vcastr_file='+furl+'&vcastr_title='+fname+'&BarColor=0xFF6600&BarPosition=1&IsAutoPlay='+autostart+'"><param name="quality" value="high"><param name="allowFullScreen" value="true" /><embed src="flv/flvplayer.swf?vcastr_file='+furl+'&vcastr_title='+fname+'&BarColor=0xFF6600&BarPosition=1&IsAutoPlay='+autostart+'" allowFullScreen="true"  quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="'+width+'" height="'+height+'"></embed></object>';
	return str;
}

//mediaplayer
function EmpireCMSShowMediaPlayer(furl,width,height,autostart,baseurl){
	var str='';
	str='<object align="middle" classid="CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95" class="OBJECT" id="MediaPlayer" width="'+width+'" height="'+height+'"><PARAM NAME="AUTOSTART" VALUE="'+autostart+'"><param name="ShowStatusBar" value="-1"><param name="Filename" value="'+furl+'"><embed type="application/x-oleobject codebase=http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701" flename="mp" src="'+furl+'" width="'+width+'" height="'+height+'"></embed></object>';
	return str;
}

//realplayer
function EmpireCMSShowRealPlayer(furl,width,height,autostart,baseurl){
	var str='';
	str='<object classid="clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA" HEIGHT="'+height+'" ID="Player" WIDTH="'+width+'" VIEWASTEXT><param NAME="_ExtentX" VALUE="12726"><param NAME="_ExtentY" VALUE="8520"><param NAME="AUTOSTART" VALUE="'+autostart+'"><param NAME="SHUFFLE" VALUE="0"><param NAME="PREFETCH" VALUE="0"><param NAME="NOLABELS" VALUE=0><param NAME=CONTROLS VALUE=ImageWindow><param NAME=CONSOLE VALUE=_master><param NAME=LOOP VALUE=0><param NAME=NUMLOOP VALUE=0><param NAME=CENTER VALUE=0><param NAME=MAINTAINASPECT VALUE="'+furl+'"><param NAME=BACKGROUNDCOLOR VALUE="#000000"></object><br><object CLASSID="clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA" HEIGHT=32 ID="Player" WIDTH="'+width+'" VIEWASTEXT><param NAME=_ExtentX VALUE=18256><param NAME=_ExtentY VALUE=794><param NAME=AUTOSTART VALUE="'+autostart+'"><param NAME=SHUFFLE VALUE=0><param NAME=PREFETCH VALUE=0><param NAME=NOLABELS VALUE=0><param NAME=CONTROLS VALUE=controlpanel><param NAME=CONSOLE VALUE=_master><param NAME=LOOP VALUE=0><param NAME=NUMLOOP VALUE=0><param NAME=CENTER VALUE=0><param NAME=MAINTAINASPECT VALUE=0><param NAME=BACKGROUNDCOLOR VALUE="#000000"><param NAME=SRC VALUE="'+furl+'"></object>';
	return str;
}

//jwplayer
function EmpireCMSShowJwplayer(furl,width,height,autostart,baseurl){
	var str='';
	str='<scri'+'pt type="text/javascript" src="'+baseurl+'e/data/modadd/moreplayer/jwplayer/jwplayer.js"></scri'+'pt><div id="EmpireCMSmyElement">Loading the player...</div><scri'+'pt type="text/javascript">jwplayer("EmpireCMSmyElement").setup({ autostart:'+autostart+',file: "'+furl+'",height:'+height+',width:'+width+' });</scri'+'pt>';
	return str;
}
