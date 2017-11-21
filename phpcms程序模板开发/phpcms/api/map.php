<?php
defined('IN_PHPCMS') or exit('No permission resources.');
$field = remove_xss(safe_replace(trim($_GET['field'])));
$modelid = intval($_GET['modelid']);
$data = getcache('model_field_'.$modelid,'model');
$setting = string2array($data[$field]['setting']);
$key = $_GET['api_key'] ? safe_replace($_GET['api_key']) : $setting['api_key'];
$key = str_replace(array('/','(',')','&',';'),'',$key);
$maptype = $_GET['maptype'] ? intval($_GET['maptype']) : ($setting['maptype'] ? $setting['maptype'] : 1);
$defaultcity = $_GET['defaultcity'] ? $_GET['defaultcity'] : ($setting['defaultcity'] ? $setting['defaultcity'] : '北京');
$defaultcity = remove_xss(safe_replace($defaultcity));

if(CHARSET=="utf-8" && !is_utf8($defaultcity)) exit('-1');
if(CHARSET=="gbk" && is_utf8($defaultcity)) exit('-2');
$hotcitys = explode(",",$setting['hotcitys']);
if(!isset($_GET['city'])) {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"<?php if(isset($addbg)) { ?> class="addbg"<?php } ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET ?>">
<?php if($maptype == 1) {?>
<script src="http://app.mapabc.com/apis?&t=flashmap&v=2.4&key=<?php echo $key?>&hl=zh-CN" type="text/javascript"></script>
<?php } elseif($maptype == 2) {?>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.2&key=<?php echo $key?>"></script></script>
<?php }?>
<script type="text/javascript" src="<?php echo JS_PATH ?>jquery.min.js"></script>

<style type="text/css">
*{ padding:0; margin:0}
body{font-size: 12px;}
#toolbar{ background-color:#E5ECF9;zoom:1; height:24px; line-height:24px; padding:0 12px; margin-top:3px; position:relative}
#toolbar a{display:inline-block;zoom:1;*display:inline; color:#4673CC}
#toolbar a.mark,#toolbar a.map{ background: url(<?php echo IMG_PATH ?>icon/map_mark.png) no-repeat left 50%; padding:0 0 0 20px}
#toolbar a.map{ background-image:url(<?php echo IMG_PATH ?>icon/map.png); margin-left:12px}
#toolbar .right{ float:right;}
#toolbar .CityBox{position:absolute; left:40px; top:30px; background-color:#fff; border:1px solid #8BA4D8; padding:2px; z-index:1; width:200px; display:none}
#toolbar .CityBox h4{background-color:#E5ECF9; line-height:20px; height:20px; padding:0 6px; color:#6688CC; position:relative}
#toolbar .CityBox h4 div.top{background: url(<?php echo IMG_PATH ?>topo.png) no-repeat; height:6px; width:11px; position:absolute; top:-9px; left:38px; line-height:normal; font-size:0}
#toolbar .CityBox .content{ padding:6px; height:150px;overflow-y:auto; padding-bottom:8px}
#toolbar .CityBox a.close{background: url(<?php echo IMG_PATH ?>cross.png) no-repeat left 3px; display:block; width:16px; height:16px;position: absolute;outline:none;right:3px; bottom:1px}
#toolbar .CityBox a.close:hover{background-position: left -46px}
#toolbar .CityBox .line{ height:6px; border-bottom:1px solid #EBEBEB; margin-bottom:5px;}
#mapObj{width:699px;height:388px; padding-top:1px}

</style>
</head>
<body>
<div id="toolbar">
	<div class="selCity">
    	<div class="right"><a href="javascript:;" class="mark" onClick="addMarker();"><?php echo L('api_addmark','','map')?></a><a href="javascript:;" onClick="removeMarker();" class="map"><?php echo L('api_resetmap','','map')?></a></div>
    	<strong id="curCity"><?php echo $defaultcity?></strong> [<a onClick="mapClose();" id="curCityText" href="javascript:;"><?php echo L('api_changecity','','map')?></a>]
    </div>
    <div class="CityBox">
    	<h4><?php echo L('api_citylist','','map')?><div class="top"></div><a href="javascript:;" class="close" onClick="mapClose();"></a></h4>
        <div class="content">
			<p>
			<?php foreach($hotcitys as $n=>$city) {?>
        	<a href="javascript:;" onClick="keywordSearch('<?php echo trim($city)?>')"><?php echo $city?></a> 
			<?php } ?>
			</p>
            <div class="line"></div>
			<input type="text" value="<?php echo L('api_inputcity','','map')?>" style=" width:140px; height:18px" name="citywd" id="citywd" onclick="$(this).val('');">
			<input type="submit" value="<?php echo L('api_citysear_submit','','map')?>" class="city_submit" onClick="keywordSearch()">
        </div>
    </div>
</div>
<div id="mapObj" class="view"></div>
<?php if($maptype == 1) {?>
<SCRIPT LANGUAGE="JavaScript">
  //设置中心点为北京
  //设置地图初始化参数对象
  var mapOptions = new MMapOptions();
  var defaultcity = "<?php echo $defaultcity;?>";
  mapOptions.toolbar = MConstants.MINI;
  mapOptions.scale = new MPoint(20,20);  
  mapOptions.zoom = 10;
  mapOptions.overviewMap = MConstants.SHOW;  
  mapOptions.scale = MConstants.SHOW; 
  mapOptions.mapComButton = MConstants.SHOW_NO
  //创建地图对象
  var mapObj = new MMap("mapObj", mapOptions);
  var  maptools = new MMapTools(mapObj);
  maptools.setCenterByCity(defaultcity);
  if(window.top.$('#<?php echo $field?>').val()) {
	drawPoints();
  } 
	//设置切换城市
	function keywordSearch(city) {
		if(city==null || city=='') {
			var city=$("#citywd").val();
		}
		var cn_city = city;
		var city = encodeURI(city);
		var url = "api.php?op=map&city="+city;
		$.get(url,function(data){
			if(data) {
				maptools.setCenterByCity(data);
				mapObj.setZoomLevel(10);
				$("#curCity").html(cn_city);
			}
		})
	}
	
	function addMarker(){ 	  
		var address = $(window.parent.document).find("input[id='address']").val();
		var tipOption=new MTipOptions();//添加信息窗口 
		tipOption.tipType = MConstants.HTML_BUBBLE_TIP;//信息窗口标题  
		tipOption.title = address;//信息窗口标题  
		tipOption.content = address;//信息窗口内容   
		var markerOption = new MMarkerOptions(); 		
		markerOption.imageUrl='<?php echo IMG_PATH ?>icon/mak.png';		
		markerOption.picAgent=false;   
		markerOption.imageAlign=MConstants.BOTTOM_CENTER; 	   
		markerOption.isBounce=false; 	  
		markerOption.isEditable=true;   		

		markerOption.tipOption = tipOption; 		 
		markerOption.canShowTip= address ? true : false; 	  
		markerOption.rotation="0"; 		  	
		markerOption.dimorphicColor="0x00A0FF"; 	  
		var center = mapObj.getCenter();
		var ZoomLevel = mapObj.getZoomLevel();
		Mmarker = new MMarker(new MLngLat(center.lngX,center.latY),markerOption);  
		Mmarker.id="mark101";  
		mapObj.addOverlay(Mmarker,true) ; 		
		mapObj.addEventListener(mapObj,MConstants.MOUSE_UP,mouseUp);
		window.top.$('#<?php echo $field?>').val(center.lngX+'|'+center.latY+'|'+ZoomLevel);
	} 
	
	function removeMarker() {
		mapObj.removeAllOverlays();
		maptools.setCenterByCity(defaultcity);
		$("#curCity").html('<?php echo $defaultcity?>');
		mapOptions.zoom = 10;
		window.top.$('#<?php echo $field?>').val('');
	}

	function mouseUp(param){ 
		var object=mapObj.getOverlayById('mark101');
		var lngX = object.lnglat.lngX;
		var latY = object.lnglat.latY;
		var ZoomLevel = mapObj.getZoomLevel();
		window.top.$('#<?php echo $field?>').val(lngX+'|'+latY+'|'+ZoomLevel);
	}
	
	function mapClose(){
		var CityBox=$(".CityBox");
		if(CityBox.css('display')=='none'){
			CityBox.show();
		}else{
			CityBox.hide();
		}
	}
	
	function drawPoints(){
		var data = window.top.$('#<?php echo $field?>').val();
		var data = data.split('|');
		var lngX = data[0];
		var latY = data[1];
		var zoom = data[2]? data[2] : 10
		mapObj.setZoomAndCenter(zoom,new MLngLat(lngX,latY));
		var markerOption = new MMarkerOptions();
		var tipOption=new MTipOptions();//添加信息窗口 
		var address = "";
		tipOption.tipType = MConstants.HTML_BUBBLE_TIP;//信息窗口标题  
		tipOption.title = address;//信息窗口标题  
		tipOption.content = address;//信息窗口内容     
		var markerOption = new MMarkerOptions(); 		
		markerOption.imageUrl="<?php echo IMG_PATH ?>icon/mak.png";		
		markerOption.picAgent=false;   
		markerOption.isEditable=true;  
		markerOption.imageAlign=MConstants.BOTTOM_CENTER; 	   
		markerOption.tipOption = tipOption; 		  
		markerOption.canShowTip= address ? true : false; 	  	
		markerOption.dimorphicColor="0x00A0FF"; 			 			
		Mmarker = new MMarker(new MLngLat(lngX,latY),markerOption);
		Mmarker.id="mark101";
		mapObj.addOverlay(Mmarker,true);
		mapObj.addEventListener(mapObj,MConstants.MOUSE_UP,mouseUp);
	}	
</script>
<style>
.MFMP_pngImg0{ left:0; bottom:0; display:none}
</style>
<?php } elseif($maptype == 2) {?>
<script type="text/javascript">  
var mapObj = new BMap.Map("mapObj");          // 创建地图实例  
//向地图中添加缩放控件
var ctrl_nav = new BMap.NavigationControl({anchor:BMAP_ANCHOR_TOP_LEFT,type:BMAP_NAVIGATION_CONTROL_LARGE});
mapObj.addControl(ctrl_nav);
mapObj.enableDragging();//启用地图拖拽事件，默认启用(可不写)
mapObj.enableScrollWheelZoom();//启用地图滚轮放大缩小
mapObj.enableDoubleClickZoom();//启用鼠标双击放大，默认启用(可不写)
mapObj.enableKeyboard();//启用键盘上下左右键移动地图
//mapObj.centerAndZoom("<?php echo $defaultcity?>");
if(window.top.$('#<?php echo $field?>').val()) {
	drawPoints();
} else {
	mapObj.centerAndZoom("<?php echo $defaultcity?>");
} 
//设置切换城市
function keywordSearch(city) {
	if(city==null || city=='') {
		var city=$("#citywd").val();
	}
	mapObj.setCenter(city);
	$("#curCity").html(city);
}

function drawPoints(){
	var data = window.top.$('#<?php echo $field?>').val();
	var data = data.split('|');
	var lngX = data[0];
	var latY = data[1];
	var zoom = data[2] ? data[2] : 10;
	mapObj.centerAndZoom(new BMap.Point(lngX,latY),zoom);
	// 创建图标对象
	var myIcon = new BMap.Icon('<?php echo IMG_PATH ?>icon/mak.png', new BMap.Size(27, 45));

	// 创建标注对象并添加到地图
	var center = mapObj.getCenter();
	var point = new BMap.Point(lngX,latY);
	var marker = new BMap.Marker(point, {icon: myIcon});
	marker.enableDragging();
	mapObj.addOverlay(marker);
	var ZoomLevel = mapObj.getZoom();
	marker.addEventListener("dragend", function(e){  
		window.top.$('#<?php echo $field?>').val(e.point.lng+'|'+e.point.lat+'|'+ZoomLevel); 
	}) 
}

function addMarker(){ 
	  mapObj.clearOverlays();
	  // 创建图标对象
	  var myIcon = new BMap.Icon('<?php echo IMG_PATH ?>icon/mak.png', new BMap.Size(27, 45));
	
	  // 创建标注对象并添加到地图
	  var center = mapObj.getCenter();
	  var point = new BMap.Point(center.lng,center.lat);
	  var marker = new BMap.Marker(point, {icon: myIcon});
	  marker.enableDragging();
	  mapObj.addOverlay(marker);
	  var ZoomLevel = mapObj.getZoom();
	  window.top.$('#<?php echo $field?>').val(center.lng+'|'+center.lat+'|'+ZoomLevel);
	  marker.addEventListener("dragend", function(e){  
		window.top.$('#<?php echo $field?>').val(e.point.lng+'|'+e.point.lat+'|'+ZoomLevel); 
	}) 
}

function mapClose(){
	var CityBox=$(".CityBox");
	if(CityBox.css('display')=='none'){
		CityBox.show();
	}else{
		CityBox.hide();
	}
}

function removeMarker() {
	mapObj.clearOverlays();
	mapObj.centerAndZoom("<?php echo $defaultcity?>");
	$("#curCity").html('<?php echo $defaultcity?>');
	window.top.$('#<?php echo $field?>').val('');
}
</script>  
<?php }?>
</body>
</html>
<?php 
} elseif(!empty($_GET['city']) && $maptype==1) {
	if(!$_GET['city'])  showmessage(L('error'));
	$city = urldecode(trim($_GET['city']));
	$city = str_replace(array('<','>','"',"'",'/','(',')','&',';'),'',$city);
	echo $city;
}
?>