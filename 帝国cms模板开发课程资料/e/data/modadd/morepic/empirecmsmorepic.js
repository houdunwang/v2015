
//showsmallpics
function yecmsShowSmallPics(){
	var str='';
	var selectpages='';
	var listpages='';
	var i;
	var cname='';
	var lname='';
	var sname='';
	for(i=0;i<ecmspicnum;i++)
	{
		cname='';
		lname='';
		sname='';
		if(i==0)
		{
			cname=' class="espiccss"';
			lname=' class="epiclpcss"';
			sname=' selected';
		}
		str+='<td bgcolor="#cccccc" align="center" id="espicid'+i+'"'+cname+'><a href="#empirecms" onclick="ecmsShowPic('+i+');"><img src="'+ecmspicr[i][0]+'" width="'+epicswidth+'" height="'+epicsheight+'" border="0"></a><br>'+(i+1)+'/'+ecmspicnum+'</td>';

		selectpages+='<option value="'+i+'"'+sname+'>第 '+(i+1)+' 页</option>';

		listpages+='<a href="#empirecms" id="epiclpid'+i+'" onclick="ecmsShowPic('+i+');"'+lname+'>'+(i+1)+'</a> ';
	}
	if(eopensmallpics==1)
	{
		document.getElementById("ecmssmallpicsid").innerHTML='<table><tr>'+str+'</tr></table>';
	}
	if(eopenselectpage==1)
	{
		document.getElementById("ecmsselectpagesid").innerHTML='<select name="tothepicpage" id="tothepicpage" onchange="ecmsShowPic(this.options[this.selectedIndex].value);">'+selectpages+'</select>';
	}
	if(eopenlistpage==1)
	{
		document.getElementById("ecmslistpagesid").innerHTML=listpages;
	}
	document.getElementById("ethispage").value=0;
}

//showpic
function ecmsShowPic(page){
	var thispage=document.getElementById("ethispage").value;
	var sdivwidth=document.getElementById("ecmssmallpicsid").offsetWidth;
	if(document.getElementById("ecmssmallpicid")!=null)
	{
		document.getElementById("ecmssmallpicid").src=ecmspicr[page][0];
	}
	document.getElementById("ecmsbigpicid").src=ecmspicr[page][1];
	if(document.getElementById("ecmspicnameid")!=null)
	{
		document.getElementById("ecmspicnameid").innerHTML=ecmspicr[page][2];
	}
	//document.getElementById("ecmssmallpicsid").scrollLeft+=120;
	if(page>thispage)
	{
		if(epicswidth*(page+1)>sdivwidth-epicswidth)
		{
			document.getElementById("ecmssmallpicsid").scrollLeft+=epicswidth;
		}
	}
	else
	{
		if(epicswidth*(page-1)<document.getElementById("ecmssmallpicsid").scrollLeft)
		{
			document.getElementById("ecmssmallpicsid").scrollLeft-=epicswidth;
		}
	}
	document.getElementById("ethispage").value=page;
	
	if(eopensmallpics==1)
	{
		document.getElementById("espicid"+page).className='espiccss';
		document.getElementById("espicid"+thispage).className='';
	}
	if(eopenlistpage==1)
	{
		document.getElementById("epiclpid"+page).className='epiclpcss';
		document.getElementById("epiclpid"+thispage).className='';
	}
	if(eopenselectpage==1)
	{
		document.getElementById("tothepicpage").options[page].selected=true;
	}
}

//shownextpic
function ecmsShowNextPic(){
	var thispage=parseInt(document.getElementById("ethispage").value);
	if(thispage+1>=ecmspicnum)
	{
		return false;
	}
	ecmsShowPic(thispage+1);
}

//showprepic
function ecmsShowPrePic(){
	var thispage=parseInt(document.getElementById("ethispage").value);
	if(thispage<=0)
	{
		return false;
	}
	ecmsShowPic(thispage-1);
}

//showtruepic
function ecmsShowTruePic(){
	var thispage=parseInt(document.getElementById("ethispage").value);
	window.open(ecmspicr[thispage][1]);
}

//movespic
function ecmsMoveSmallPics(scrollwidth){
	document.getElementById("ecmssmallpicsid").scrollLeft+=scrollwidth;
}

//autoshowpic
function ecmsPicAutoPlay(){
	var sec=parseInt(document.getElementById("autoplaysec").value);
	var i;
	for(i=1;i<=sec;i++)
	{
		if(document.getElementById("autoplaystop").value==0)
		{
			window.setTimeout("ecmsPicAutoPlayDo("+i+","+sec+")",i*1000);
		}
		else
		{
			break;
		}
	}
}

function ecmsPicAutoPlayDo(num,sec){
	var t;
	if(document.getElementById("autoplaystop").value==1)
	{
		return "";
	}
	if(num==sec) 
	{
		t=ecmsShowNextPic();
		if(t==false)
		{
			ecmsShowPic(0);
		}
		ecmsPicAutoPlay();
	}
}


document.onkeydown=function(event){
	var e = event || window.event || arguments.callee.caller.arguments[0];
	if(e && e.keyCode==37)
	{
		ecmsShowPrePic();
	}
	if(e && e.keyCode==39)
	{
		ecmsShowNextPic();
	}
}; 
