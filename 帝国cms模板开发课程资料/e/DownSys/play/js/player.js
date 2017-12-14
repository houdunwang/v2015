/////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////////

function ShowBuffering(isbuf){
		if(isbuf){
			bufimg.style.visibility = "visible";
			MP.style.visibility = "hidden";
		}else{
			bufimg.style.visibility = "hidden";
			MP.style.visibility = "visible";
			strMsg="";
		}
}


/////////////////////////////////////////////////////////////////////////////////////////////
function WindowMove_Start(){

	if(event.button!=1&&!DRAG_POS) {
		CanMove=false;
	}else{
		mouse_e_x=by_x=window.event.x+document.body.scrollLeft;
		mouse_e_y=by_y=window.event.y+document.body.scrollTop;
		CanMove=true;
	}
}

function WindowMove_End(){

	if (event.button==2){
		event.returnValue = true;
	}
	CanMove=false;
}

function WindowMove(){

	if (!CanMove) return;
	if(event.button!=1){
		CanMove=false;
	}else{
		mouse_e_x=window.event.x+document.body.scrollLeft;
		mouse_e_y=window.event.y+document.body.scrollTop;
		window.moveBy(mouse_e_x-by_x,mouse_e_y-by_y);
	}
}

/////////////////////////////////////////////////////////////////////////////////////////////

function ShowAdv(){

	SHOW_FULL=!SHOW_FULL;
	if (SHOW_FULL){
		myadvPanel.style.top = -86;
		window.resizeBy(0,70);
	}else{
		window.resizeBy(0,-70);
		myadvPanel.style.top = -150;
	}
	ResizePlayer();
}

/////////////////////////////////////////////////////////////////////////////////////////////

function ResizePlayer(){

	if(SHOW_FULL){
		fh=parseInt(document.all.Player.height)+205+2;
		fw=parseInt(document.all.Player.width)+25+2;
	}else{
		fh=parseInt(document.all.Player.height)+140+2;
		fw=parseInt(document.all.Player.width)+25+2;
	}
	window.resizeTo(fw,fh);
}

/////////////////////////////////////////////////////////////////////////////////////////////

function MM_findObj(n, d) { //v3.0
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; 
  document.MM_sr=new Array; 
  for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){
	  document.MM_sr[j++]=x; 
	  if(!x.oSrc)
		  x.oSrc=x.src; x.src=a[i+2];
	}
}

function MM_preloadImages() { //v3.0
 var d=document; 
 if(d.images){
	 if(!d.MM_p) 
		 d.MM_p=new Array();
 var i,j=d.MM_p.length,a=MM_preloadImages.arguments; 
 for(i=0; i<a.length; i++)
   if (a[i].indexOf("#")!=0){ 
	 d.MM_p[j]=new Image; 
	 d.MM_p[j++].src=a[i];
	 }
 }
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; 
  for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) 
	  x.src=x.oSrc;
}