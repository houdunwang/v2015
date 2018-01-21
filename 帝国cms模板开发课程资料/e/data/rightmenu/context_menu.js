var MenuWidth = 120;
var ItemHeight = 17;
var ItemNumber = 0;

ContextMenu.intializeContextMenu=function()
{
	document.body.insertAdjacentHTML("BeforeEnd", '<iframe src="#" scrolling="no" class="WebFX-ContextMenu" marginwidth="0" marginheight="0" frameborder="0" style="position:absolute;display:none;z-index:50000000;" id="WebFX_PopUp"></iframe>');
	WebFX_PopUp    = self.frames["WebFX_PopUp"]
	WebFX_PopUpcss = document.getElementById("WebFX_PopUp")
	document.body.attachEvent("onmousedown",function(){WebFX_PopUpcss.style.display="none"})
	WebFX_PopUpcss.onfocus  = function(){WebFX_PopUpcss.style.display="inline"};
	WebFX_PopUpcss.onblur  = function(){WebFX_PopUpcss.style.display="none"};
	self.attachEvent("onblur",function(){WebFX_PopUpcss.style.display="none"})
}



function ContextSeperator(){}

function ContextMenu(){}

ContextMenu.showPopup=function(x,y)
{
	WebFX_PopUpcss.style.display = "block"
}

ContextMenu.display=function(popupoptions,h)
{
  var eobj,x,y;
	eobj = window.event;
	x    = eobj.x;
	y    = eobj.y
	
	/*
	not really sure why I had to pass window here
	it appears that an iframe inside a frames page
	will think that its parent is the frameset as
	opposed to the page it was created in...
	*/
	ContextMenu.populatePopup(popupoptions,window)	
	ContextMenu.showPopup(x,y);
	ContextMenu.fixSize();
	ContextMenu.fixPos(x,y);
  eobj.cancelBubble = true;
  eobj.returnValue  = false;
}

//TODO
 ContextMenu.getScrollTop=function()
 {
 	return document.body.scrollTop;
	//window.pageXOffset and window.pageYOffset for moz
 }
 
 ContextMenu.getScrollLeft=function()
 {
 	return document.body.scrollLeft;
 }
 

ContextMenu.fixPos=function(x,y)
{
	var docheight,docwidth,dh,dw;	
	docheight = document.body.clientHeight;
	docwidth  = document.body.clientWidth;
	dh = (WebFX_PopUpcss.offsetHeight+y) - docheight;
	dw = (WebFX_PopUpcss.offsetWidth+x)  - docwidth;
	if(dw>0)
	{ WebFX_PopUpcss.style.left = (x - dw) + ContextMenu.getScrollLeft() + "px"; }
	else
	{ WebFX_PopUpcss.style.left = x + ContextMenu.getScrollLeft(); }
	//
	if(dh>0)
	{ WebFX_PopUpcss.style.top = (y - dh) + ContextMenu.getScrollTop() + "px" }
	else
	{ WebFX_PopUpcss.style.top  = y + ContextMenu.getScrollTop(); }
}

ContextMenu.fixSize=function()
{
	//var body;
	//WebFX_PopUpcss.style.width = "120px";
	//body = WebFX_PopUp.document.body; 
	//var dummy = WebFX_PopUpcss.offsetHeight + " dummy";
	//h = body.scrollHeight + WebFX_PopUpcss.offsetHeight - body.clientHeight;
	//w = body.scrollWidth + WebFX_PopUpcss.offsetWidth - body.clientWidth;
	WebFX_PopUpcss.style.height = ItemHeight * ItemNember + "px";
	WebFX_PopUpcss.style.width =  MenuWidth + "px";
	ItemNember = 0;
}

ContextMenu.populatePopup=function(arr,win)
{
	var alen,i,tmpobj,doc,height,htmstr;
	alen = arr.length;
	ItemNember = alen;
	doc  = WebFX_PopUp.document;
	doc.body.innerHTML  = ""
	if (doc.getElementsByTagName("LINK").length == 0) {
		doc.open();
		doc.write('<html><head><link rel="StyleSheet" type="text/css" href="../data/rightmenu/contextmenu.css"></head><body></body></html>');
		doc.close();
	}
	for(i=0;i<alen;i++)
	{
		if(arr[i].constructor==ContextItem)
		{
			tmpobj=doc.createElement("DIV");
			tmpobj.noWrap = true;
			tmpobj.className = "WebFX-ContextMenu-Item";
			if(arr[i].disabled)
			{
				htmstr  = '<span class="WebFX-ContextMenu-DisabledContainer">'
				htmstr += arr[i].text+'</span>'
				tmpobj.innerHTML = htmstr
				tmpobj.className = "WebFX-ContextMenu-Disabled";
				tmpobj.onmouseover = function(){this.className="WebFX-ContextMenu-Disabled-Over"}
				tmpobj.onmouseout  = function(){this.className="WebFX-ContextMenu-Disabled"}
			}
			else
			{
				tmpobj.innerHTML = arr[i].text;
				tmpobj.onclick = (function (f)
				{
				   	return function () {
			    			win.WebFX_PopUpcss.style.display='none'
								if (typeof(f)=="function"){ f(); }
             };
				})(arr[i].action);
					
				tmpobj.onmouseover = function(){this.className="WebFX-ContextMenu-Over"}
				tmpobj.onmouseout  = function(){this.className="WebFX-ContextMenu-Item"}
			}
			doc.body.appendChild(tmpobj);
		}
		else
		{
			doc.body.appendChild(doc.createElement("DIV")).className = "WebFX-ContextMenu-Separator";
		}
	}
	doc.body.className  = "WebFX-ContextMenu-Body" ;
	doc.body.onselectstart = function(){return false;}
}

function ContextItem(str,fnc,disabled)
{
	this.text     = str;
	this.action   = fnc; 
	this.disabled = disabled || false;
}