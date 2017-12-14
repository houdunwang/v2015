if (navigator.appName == "Netscape")
document.ns = navigator.appName == "Netscape"
window.screen.width>800 ? imgheight=160:imgheight=150
window.screen.width>800 ? imgright=20:imgright=30
function threenineload()
{
if (navigator.appName == "Netscape")
{document.DGbanner3.pageY=pageYOffset+window.innerHeight-imgheight;
document.DGbanner3.pageX=imgright;
threeninemove();
}
else
{
DGbanner3.style.top=document.body.scrollTop+document.body.offsetHeight-imgheight;
DGbanner3.style.right=imgright;
threeninemove();
}
}
function threeninemove()
{
if(document.ns)
{
document.DGbanner3.top=pageYOffset+window.innerHeight-imgheight
document.DGbanner3.right=imgright;
setTimeout("threeninemove();",80)
}
else
{
DGbanner3.style.top=document.body.scrollTop+document.body.offsetHeight-imgheight;
DGbanner3.style.right=imgright;
setTimeout("threeninemove();",80)
}
}

function MM_reloadPage(init) { //reloads the window if Nav4 resized
if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true)
threenineload()