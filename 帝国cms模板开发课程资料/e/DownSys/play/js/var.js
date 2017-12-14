// 全局变量在此定义
var BROD=0;		//是否是直播流
var WM='wm';
var RM='rm';
var QT='qt';
var WM_STATE=new Array();
var RM_STATE=new Array();
var QT_STATE=new Array();
var MediaType="";

var m_duration=0;	//seconds
var m_current=0;	//seconds
var m_hour=0;
var m_min=0;
var m_sec=0;
var m_volume=0;		
var m_balance=0;
var m_band=0;		//kbps
var m_state_flag=0;	
var m_state_string="";
var m_timer=0;

var EnableRightButton=false;
var CanMove=false;
var mouse_s_x=0;
var mouse_s_y=0;
var mouse_e_x=0;
var mouse_e_y=0;
var by_x=0;
var by_y=0;
// Status
var SHOW_FULL=true;
var DRAG_POS=false;
var DRAG_VOL=false;
var DRAG_BAL=false;
var IS_NUTE=false;
var CAN_SET_POS=false;

//Position
var TRACE_WIDTH=314;
var TRACE_HEIGHT=15;
var TRACE_LEFT=18;
var TRACE_TOP=300;
//Volume
var VOL_TRACE_WIDTH=72
var VOL_TRACE_HEIGHT=11;
var VOL_TRACE_LEFT=256
var VOL_TRACE_TOP=250;
//Balance
var BAL_TRACE_WIDTH=72
var BAL_TRACE_HEIGHT=11;
var BAL_TRACE_LEFT=256
var BAL_TRACE_TOP=250;


var POP_HEIGHT=66;
// 播放控制变量
var player="document.Player.";
var currentpos=0;
var length=0;
var strInfo="";
var strMsg="";
