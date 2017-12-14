/////////////////////////////////////////////////////////////////////////////////////////////
function Init(){

	// Initicalize State String

	WM_STATE[0]="播放已经停止";
	WM_STATE[1]="暂停播放";
	WM_STATE[2]="正在播放";
	WM_STATE[3]="等待媒体流开始……";
	WM_STATE[4]="正在快进……";
	WM_STATE[5]="正在快退……";
	WM_STATE[6]="正在搜索……";
	WM_STATE[7]="正在搜索……";
	WM_STATE[8]="没有打开的媒体流";
	WM_STATE[9]="Transitioning";
	WM_STATE[10]="Ready";

}

///////////////////////////////////////////////////////////////////////////////////////////
function GetStateFlag(){
	return Player.PlayState;
}
/////////////////////////////////////////////////////////////////////////////////////////////
function GetStateString(flag){
	return WM_STATE[flag];
}

/////////////////////////////////////////////////////////////////////////////////////////////
function StartStreamMonitor(){
	m_timer=window.setInterval("StreamMonitor()",1000);
}

/////////////////////////////////////////////////////////////////////////////////////////////

function StreamMedia(){
	Play();
}


/////////////////////////////////////////////////////////////////////////////////////////////

function StreamMonitor(){
	if(Player.DisplaySize!=3){
		strInfo="WindowsMedia 格式 ";
		if (BROD!=1){
			strInfo+="……视频点播";
			if(!DRAG_POS&&GetStateFlag()==2){
				myPosBar.style.left= TRACE_LEFT + Player.CurrentPosition/Player.Duration*TRACE_WIDTH-8;
			}
		}else{
			strInfo+="……网络直播";
		}
		strInfo+= GetStateString(GetStateFlag());//+(TRACE_LEFT+Player.CurrentPosition/Player.Duration*TRACE_WIDTH);
		if(Player.PlayState==2){
			m_current=Player.CurrentPosition;
			m_sec=Math.round(m_current)%60;
			m_min=Math.floor(m_current/60);
			m_hour=Math.floor(m_min/60);
			m_min=Math.round(m_min)%60;
			ShowTime(m_hour,m_min,m_sec);
			strInfo+="<BR>"
			strInfo+= (" 带宽："+Math.round(Player.Bandwidth/1000)+"Kbps ");
			strInfo+=strMsg;
		}
		info.innerHTML=strInfo;
	}

}

/////////////////////////////////////////////////////////////////////////////////////////////
//function _ShowInfo(){
//	strInfo="状态：";
//	strInfo=strInfo + GetStateString(GetStateFlag());
//	info.innerHTML=strInfo;
//	if(!DRAG_POS) 
//		myPosBar.style.left= TRACE_LEFT + m_current*(TRACE_WIDTH/m_duration)-8;
//
//	setTimeout("ShowInfo()",500);
//}
//
/////////////////////////////////////////////////////////////////////////////////////////////
function ShowBufferingPro(){
	if(Player.BufferingProgress<100){
		strMsg="正在缓冲……"+Player.BufferingProgress+"%";
		info.innerHTML=strMsg;
		setTimeout('ShowBufferingPro()',100);
	}else{
		strMsg="";
	}
}

function SetPos_Start(){

	if(Player.PlayState){
		DRAG_POS=true;
		CAN_SET_POS=false;
	}
	event.cancelBubble=true;
}

function SetPos(){

	if ((!DRAG_POS)&&(BROD!=1))
	{
		event.cancelBubble=true;
		event.returnValue=false;
		return false;
	}

	mouse_e_x=window.event.x;
	
	myPosBar.style.left=
		((mouse_e_x>=(TRACE_LEFT+TRACE_WIDTH)) ? (TRACE_LEFT+TRACE_WIDTH):
		((mouse_e_x<=TRACE_LEFT) ? TRACE_LEFT:mouse_e_x))-10;

	event.cancelBubble=true;
}

function SetPos_End(){

	if((!DRAG_POS)&&(BROD!=1))return;
//	Pause();
	CAN_SET_POS=true;
	Player.CurrentPosition =
		Math.round( Player.Duration * 
		(parseInt(myPosBar.style.left)+10-TRACE_LEFT)/TRACE_WIDTH);
//	Play();
	DRAG_POS=false;
	event.cancelBubble=true;
}

/////////////////////////////////////////////////////////////////////////////////////////////
function SetVol_Start(){

	DRAG_VOL=true;
	event.cancelBubble=true;

}

function SetVol(){

	if (!DRAG_VOL||event.button!=1)
	{
		event.cancelBubble=true;
		event.returnValue=false;
		return false;
	}
	mouse_e_x=window.event.x;
	myVolBar.style.left=mouse_e_x;
	
	myVolBar.style.left=(( mouse_e_x >= (VOL_TRACE_LEFT + VOL_TRACE_WIDTH )) ? 
		( VOL_TRACE_LEFT + VOL_TRACE_WIDTH ) : 
		(( mouse_e_x <= VOL_TRACE_LEFT ) ? 
		VOL_TRACE_LEFT : mouse_e_x ))-6;
	
	Player.Volume = 
		5000 * (( parseInt(myVolBar.style.left) + 6 - VOL_TRACE_LEFT ) / 
		VOL_TRACE_WIDTH - 1);
	
	event.cancelBubble=true;
}

function SetVol_End(){

	DRAG_VOL=false;
	event.cancelBubble=true;
}

/////////////////////////////////////////////////////////////////////////////////////////////
function SetMute(){

	IS_NUTE=!IS_NUTE;
	Player.Mute=IS_NUTE;
	mutebar.alt=(IS_NUTE)?"解除静音":"静音";
}

/////////////////////////////////////////////////////////////////////////////////////////////
function SetBal_Start(){

	DRAG_BAL=true;
	event.cancelBubble=true;

}

function SetBal(){

	if (!DRAG_BAL)
	{
		event.cancelBubble=true;
		event.returnValue=false;
		return false;
	}
	mouse_e_x=window.event.x;
	myBalBar.style.left=mouse_e_x;
	
	myBalBar.style.left=(( mouse_e_x >= (BAL_TRACE_LEFT + BAL_TRACE_WIDTH )) ? 
		( BAL_TRACE_LEFT + BAL_TRACE_WIDTH ) : 
		(( mouse_e_x <= BAL_TRACE_LEFT ) ? BAL_TRACE_LEFT : mouse_e_x ))-6;

	Player.Balance = -20000 * (( parseInt(myBalBar.style.left) + 6 
		- BAL_TRACE_LEFT ) / BAL_TRACE_WIDTH )+10000;

	event.cancelBubble=true;
}

function SetBal_End(){

	DRAG_BAL=false;
	event.cancelBubble=true;
}

/////////////////////////////////////////////////////////////////////////////////////////////
function FullScreen(){

	if (Player.PlayState!=2)  return;//if not playing
	else{
		Player.DisplaySize=3;
	}
}

/////////////////////////////////////////////////////////////////////////////////////////////
function SetPosition(pos){

	var seekpos=pos;
	
	if (seekpos<0) seekpos=Player.Duration-1;
//	Pause();
	seekpos=(seekpos>=Player.Duration)?Player.Duration:seekpos;
	seekpos=(seekpos<=0)?0:seekpos;
	Player.CurrentPosition=seekpos;
//	Play();
}

/////////////////////////////////////////////////////////////////////////////////////////////
function _Seek(offset){

	var curpos=0;
	var seekpos=0;

	Pause();
	curpos=Player.CurrentPosition;
	seekpos=curpos+offset;
	seekpos=(seekpos>=Player.Duration)?Player.Duration:seekpos;
	seekpos=(seekpos<=0)?0:seekpos;
	Player.CurrentPosition=seekpos;
	Play();
}

/////////////////////////////////////////////////////////////////////////////////////////////
function Play(){

	if (document.all.Player.PlayState==2||document.all.Player.OpenState<5) return;//if is playing
	document.all.Player.Play();
	document.all.playpause.alt="播放";
//	document.all.playpause.src="images/pause_d.gif";

}

/////////////////////////////////////////////////////////////////////////////////////////////
function Pause(){

	if (document.all.Player.PlayState!=2)  return;//if not playing	
	document.all.Player.Pause();
	document.all.playpause.alt="暂停";
//	document.all.playpause.src="images/play_d.gif";
}

/////////////////////////////////////////////////////////////////////////////////////////////
function Stop(){

	if (document.all.Player.PlayState==0||document.all.Player.PlayState==8)
		return;
	document.all.Player.Stop();
	document.all.playpause.alt="播放";
}

/////////////////////////////////////////////////////////////////////////////////////////////
//function PlayPause(){

//	if (document.all.Player.PlayState==2){
//		Pause();
//	}else {
//		if (document.all.Player.PlayState<2){
//		Play();
//		}
//	}
//}

/////////////////////////////////////////////////////////////////////////////////////////////
function ClosePlayer(){

	if(document.all.Player.PlayState>1)
		Stop();
	window.close();
}