function bbimg(o){
	var zoom=parseInt(o.style.zoom, 10)||100;zoom+=event.wheelDelta/12;if (zoom>0) o.style.zoom=zoom+'%';
	return false;
}
function getCookieVal (offset) {var endstr=document.cookie.indexOf (";",offset);if (endstr==-1) endstr=document.cookie.length;return unescape(document.cookie.substring(offset, endstr));} 
function GetCookie (name){var arg=name+"=";var alen=arg.length;var clen=document.cookie.length;var i = 0;while (i<clen){var j=i+alen;if (document.cookie.substring(i,j)==arg) return getCookieVal (j);i = document.cookie.indexOf(" ",i)+1;if (i==0) break;} return null;} 
function DeleteCookie (name) {var exp=new Date(); exp.setTime (exp.getTime()-1); var cval=GetCookie (name); document.cookie=name+"="+cval+"; expires="+exp.toGMTString();}
var currentpos,timer; 
function initialize() { timer=setInterval("scrollwindow()",20);} 
function sc(){clearInterval(timer);}
function scrollwindow() {currentpos=document.body.scrollTop;window.scroll(0,++currentpos);if (currentpos != document.body.scrollTop) sc();} 
document.onmousedown=sc
document.ondblclick=initialize
ie = (document.all)? true:false
if (ie){function ctlent(eventobject){if(event.ctrlKey && window.event.keyCode==13){this.document.FORM.submit();}}}
clckcnt = 0;
function clckcntr() {clckcnt++;if(clckcnt > 1) {if(clckcnt > 2) { return false; }alert('贴子已经发出了......\n\n' + '请等待片刻......\n\n' + '不要重复按提交键，谢谢！');return false;}return true;}
var nn = !!document.layers;
var ie = !!document.all;
if (nn) {netscape.security.PrivilegeManager.enablePrivilege("UniversalSystemClipboardAccess");  var fr=new java.awt.Frame();  var Zwischenablage = fr.getToolkit().getSystemClipboard();}
function copy(textarea){if (nn) {textarea.select();Zwischenablage.setContents(new java.awt.datatransfer.StringSelection(textarea.value), null);} else if (ie) {textarea.select();cbBuffer=textarea.createTextRange();cbBuffer.execCommand('Copy');}}
function paste(textarea){ if (nn) {var Inhalt=Zwischenablage.getContents(null); if (Inhalt!=null) textarea.value=Inhalt.getTransferData(java.awt.datatransfer.DataFlavor.stringFlavor);} else if (ie) {textarea.select(); cbBuffer=textarea.createTextRange(); cbBuffer.execCommand('Paste');}}
function openScript(url, width, height){var Win = window.open(url,"openScript",'width=' + width + ',height=' + height + ',resizable=1,scrollbars=yes,menubar=yes,status=yes' );}
function runEx(){var winEx = window.open("", "winEx", "width=300,height=200,status=yes,menubar=yes,scrollbars=yes,resizable=yes"); winEx.document.open("text/html", "replace"); winEx.document.write(unescape(event.srcElement.parentElement.children[2].value)); winEx.document.close(); }
//******************************默认设置定义******************************
tPopWait=50;		//停留tWait豪秒后显示提示
tPopShow=5000;		//显示tShow豪秒后关闭提示，1000为1秒
showPopStep=20;
popOpacity=90;		//提示框的透明度,百分比，数字越小越透明
fontcolor="#000000";
bgcolor="#ffffff";
bordercolor="#cccccc";

//******************************内部变量定义******************************
sPop=null;curShow=null;tFadeOut=null;tFadeIn=null;tFadeWaiting=null;

document.write("<style type='text/css'id='defaultPopStyle'>");
document.write(".cPopText {  background-color: " + bgcolor + ";color:" + fontcolor + "; border: 2px " + bordercolor + " solid;font-color: font-size: 12px; padding-right: 4px; padding-left: 4px; height: 20px; padding-top: 2px; padding-bottom: 2px; filter: Alpha(Opacity=0)}");
document.write("</style>");
document.write("<div id='dypopLayer' style='position:absolute;z-index:1000;' class='cPopText'></div>");

function showPopupText()
{
  var o=event.srcElement;MouseX=event.x;MouseY=event.y;
  if(o.alt!=null && o.alt!=""){o.dypop=o.alt;o.alt=""};
    if(o.title!=null && o.title!=""){o.dypop=o.title;o.title=""};
  if(o.dypop!=sPop)
  {
    sPop=o.dypop;clearTimeout(curShow);clearTimeout(tFadeOut);clearTimeout(tFadeIn);clearTimeout(tFadeWaiting);  
    if(sPop==null || sPop=="")
    {
      dypopLayer.innerHTML="";dypopLayer.style.filter="Alpha()";dypopLayer.filters.Alpha.opacity=0;  
    }
    else
    {
      if(o.dyclass!=null) popStyle=o.dyclass 
      else popStyle="cPopText";
        curShow=setTimeout("showIt()",tPopWait);
    }
  }
}

function showIt()
{
  dypopLayer.className=popStyle;dypopLayer.innerHTML=sPop;
  popWidth=dypopLayer.clientWidth;popHeight=dypopLayer.clientHeight;
  if(MouseX+12+popWidth>document.body.clientWidth) popLeftAdjust=-popWidth-24
  else popLeftAdjust=0;
  if(MouseY+12+popHeight>document.body.clientHeight) popTopAdjust=-popHeight-24
  else popTopAdjust=0;
  dypopLayer.style.left=MouseX+12+document.body.scrollLeft+popLeftAdjust;
  dypopLayer.style.top=MouseY+12+document.body.scrollTop+popTopAdjust;
  dypopLayer.style.filter="Alpha(Opacity=0)";fadeOut();
}

function fadeOut()
{
  if(dypopLayer.filters.Alpha.opacity<popOpacity)
  { dypopLayer.filters.Alpha.opacity+=showPopStep;tFadeOut=setTimeout("fadeOut()",1); }
  else
  { dypopLayer.filters.Alpha.opacity=popOpacity;tFadeWaiting=setTimeout("fadeIn()",tPopShow); }
}

function fadeIn()
{
  if(dypopLayer.filters.Alpha.opacity>0)
  { dypopLayer.filters.Alpha.opacity-=1;tFadeIn=setTimeout("fadeIn()",1); }
}
document.onmouseover=showPopupText;