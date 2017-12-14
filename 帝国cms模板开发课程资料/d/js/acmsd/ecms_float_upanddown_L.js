if (navigator.appName == "Netscape")
document.ns = navigator.appName == "Netscape"
window.screen.width>800 ? imgheight=160:imgheight=150
window.screen.width>800 ? imgleft=20:imgleft=30
function threenineload_L()
{
if (navigator.appName == "Netscape")
{document.DGbanner10.pageY=pageYOffset+window.innerHeight-imgheight;
document.DGbanner10.pageX=imgleft;
threeninemove_L();
}
else
{
DGbanner10.style.top=document.body.scrollTop+document.body.offsetHeight-imgheight;
DGbanner10.style.left=imgleft;
threeninemove_L();
}
}
function threeninemove_L()
{
if(document.ns)
{
document.DGbanner10.top=pageYOffset+window.innerHeight-imgheight
document.DGbanner10.left=imgleft;
setTimeout("threeninemove_L();",80)
}
else
{
DGbanner10.style.top=document.body.scrollTop+document.body.offsetHeight-imgheight;
DGbanner10.style.left=imgleft;
setTimeout("threeninemove_L();",80)
}
}

function MM_reloadPage_L(init) { //reloads the window if Nav4 resized
if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage_L(true)
threenineload_L()