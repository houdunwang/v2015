var dn
var jsdir="js/"
c1=new Image(); c1.src=jsdir+"c1.gif"
c2=new Image(); c2.src=jsdir+"c2.gif"
c3=new Image(); c3.src=jsdir+"c3.gif"
c4=new Image(); c4.src=jsdir+"c4.gif"
c5=new Image(); c5.src=jsdir+"c5.gif"
c6=new Image(); c6.src=jsdir+"c6.gif"
c7=new Image(); c7.src=jsdir+"c7.gif"
c8=new Image(); c8.src=jsdir+"c8.gif"
c9=new Image(); c9.src=jsdir+"c9.gif"
c0=new Image(); c0.src=jsdir+"c0.gif"
cb=new Image(); cb.src=jsdir+"cb.gif"
cam=new Image(); cam.src=jsdir+"cam.gif"
cpm=new Image(); cpm.src=jsdir+"cpm.gif"

function ShowTime(h,m,s){
	if (!document.images) return
	if (h<=9){
		document.images.a.src=cb.src
		document.images.b.src=eval("c"+h+".src")
	}else {
		document.images.a.src=eval("c"+Math.floor(h/10)+".src")
		document.images.b.src=eval("c"+(h%10)+".src")
	}
	if (m<=9){
		document.images.d.src=c0.src
		document.images.e.src=eval("c"+m+".src")
	}else {
		document.images.d.src=eval("c"+Math.floor(m/10)+".src")
		document.images.e.src=eval("c"+(m%10)+".src")
	}
	if (s<=9){
		document.g.src=c0.src
		document.images.h.src=eval("c"+s+".src")
	}else {
		document.images.g.src=eval("c"+Math.floor(s/10)+".src")
		document.images.h.src=eval("c"+(s%10)+".src")
	}
}