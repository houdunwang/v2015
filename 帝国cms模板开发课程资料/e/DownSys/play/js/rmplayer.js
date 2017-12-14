/////////////////////////////////////////////////////////////////////////////////////////////
function Init(){

	// Initicalize State String

	RM_STATE[0]="播放停止";
	RM_STATE[1]="正在连接媒体流……";
	RM_STATE[2]="正在缓冲……";
	RM_STATE[3]="正在播放";
	RM_STATE[4]="暂停播放";
	RM_STATE[5]="正在搜索流……";

	Player.SetEnableContextMenu(false);
	Player.SetImageStatus(false);
	Player.SetWantErrors(true);
}

/////////////////////////////////////////////////////////////////////////////////////////////
function GetStateFlag(){
	return Player.GetPlayState();
}

function GetStateString(flag){
	return RM_STATE[flag];
}
 
/////////////////////////////////////////////////////////////////////////////////////////////

function StreamMonitor(){
	if(!Player.GetFullScreen()){
		strInfo="Real 格式，";
		strInfo=strInfo + GetStateString(GetStateFlag())+ "<BR>";//+(TRACE_LEFT+Player.GetPosition()/Player.GetLength()*TRACE_WIDTH);
		strInfo=strInfo + "带宽：" + Math.round(Player.GetbandWidthCurrent()/1000) + "Kbps ";
		strInfo=strInfo+strMsg
		info.innerHTML=strInfo;
		if(!DRAG_POS&&GetStateFlag()==3){
			myPosBar.style.left= TRACE_LEFT + Player.GetPosition()/Player.GetLength()*TRACE_WIDTH-8;
		}
		if(GetStateFlag()==3){
			m_current=Player.GetPosition()/1000;
			m_sec=Math.round(m_current)%60;
			m_min=Math.floor(m_current/60);
			m_hour=Math.floor(m_min/60);
			m_min=Math.round(m_min)%60;
			ShowTime(m_hour,m_min,m_sec);
		}

	}
	setTimeout("StreamMonitor()",1000);
}

/////////////////////////////////////////////////////////////////////////////////////////////
function StreamMedia(){
	Init();
//	ShowTime();
	Play();
}

/////////////////////////////////////////////////////////////////////////////////////////////
function SetPos_Start(){

	if(Player.GetPlayState()>2){
		DRAG_POS=true;
	}
	event.cancelBubble=true;
}

function SetPos(){

	if (!DRAG_POS||event.button!=1)
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

	if(!DRAG_POS)return;
//	ShowBuffering(true);
//	Pause();
	Player.SetPosition(Math.round( Player.GetLength()*(parseInt(myPosBar.style.left)+10-TRACE_LEFT)/TRACE_WIDTH));
//	Play();
//	ShowBuffering(false);
	DRAG_POS=false;
	event.cancelBubble=true;
}



/////////////////////////////////////////////////////////////////////////////////////////////
function SetVol_Start(){

	DRAG_VOL=true;
	event.cancelBubble=true;

}

function SetVol(){

	if (!DRAG_VOL)
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
	
	Player.SetVolume(
		100 * (( parseInt(myVolBar.style.left) + 6 - VOL_TRACE_LEFT ) / 
		VOL_TRACE_WIDTH)
		);
	
	event.cancelBubble=true;
}

function SetVol_End(){

	DRAG_VOL=false;
	event.cancelBubble=true;
}

/////////////////////////////////////////////////////////////////////////////////////////////
function SetMute(){

	IS_NUTE=Player.GetMute();
	Player.SetMute(!IS_NUTE);
	mute.alt=(IS_NUTE)?"解除静音":"静音";
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

	if (Player.GetPlayState()!=3)  return;//if not playing
	else{
		Player.SetFullScreen();
	}
}

/////////////////////////////////////////////////////////////////////////////////////////////
function SetPosition(pos){

	var seekpos=pos;
	
	if (seekpos<0) seekpos=Player.GetLength()-1000;
	Pause();
	seekpos=(seekpos>=Player.GetLength())?Player.GetLength():seekpos;
	seekpos=(seekpos<=0)?0:seekpos;
	Player.SetPosition(seekpos);
	Play();
}

/////////////////////////////////////////////////////////////////////////////////////////////
function Seek(offset){

	var curpos=0;
	var seekpos=0;

	Pause();
	curpos=Player.GetPosition();
	seekpos=curpos+offset;
	seekpos=(seekpos>=Player.GetLength())?Player.GetLength():seekpos;
	seekpos=(seekpos<=0)?0:seekpos;
	Player.SetPosition(seekpos);
	Play();
}

/////////////////////////////////////////////////////////////////////////////////////////////
function Play(){

	if (Player.GetPlayState()==3) return;//if is playing	
	Player.DoPlay();
	document.all.playpause.alt="暂停";
	document.all.playpause.src="images/pause_d.gif";
}

/////////////////////////////////////////////////////////////////////////////////////////////
function Pause(){

	if (Player.GetPlayState()!=3)  return;//if not playing	
	Player.DoPause();
	document.all.playpause.alt="播放";
	document.all.playpause.src="images/play_d.gif";
}

/////////////////////////////////////////////////////////////////////////////////////////////
function Stop(){

	if (Player.GetPlayState()==0&&Player.CanStop())
		return;
	Player.DoStop();
	playpause.alt="播放";
	document.all.playpause.src="images/play_d.gif";
}

/////////////////////////////////////////////////////////////////////////////////////////////
function PlayPause(){

	if (Player.GetPlayState()==3)
		Pause();
	else 
		Play();
}

/////////////////////////////////////////////////////////////////////////////////////////////
function ClosePlayer(){

	if(Player.GetPlayState()>0)
		Stop();
	window.close();
}