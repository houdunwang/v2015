var over=false,down=false,divleft,divtop,n;
function clase(x){
	document.all[x].style.visibility='hidden'
	}
function down1(m){
	n=m;
	down=true;
	divleft=event.clientX-parseInt(m.style.left);
	divtop=event.clientY-parseInt(m.style.top)
	}
function move(){
	if(down){
		n.style.left=event.clientX-divleft;n.style.top=event.clientY-divtop;
		}
	}