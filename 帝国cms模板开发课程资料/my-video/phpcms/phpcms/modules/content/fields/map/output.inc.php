	function map($field, $value) {
		$str = '';
		$setting = string2array($this->fields[$field]['setting']);
		$setting[width] = $setting[width] ? $setting[width] : '600';
		$setting[height] = $setting[height] ? $setting[height] : '400';
		list($lngX, $latY,$zoom) = explode('|', $value);
		if($setting['maptype']==1) {
			$str = "<script src='http://app.mapabc.com/apis?&t=flashmap&v=2.4&key=$setting[api_key]&hl=zh-CN' type='text/javascript'></script>";
		} elseif($setting['maptype']==2) {
			$str = "<script type='text/javascript' src='http://api.map.baidu.com/api?v=1.2&key=$setting[api_key]'></script>";
		}
		$str .= '<div id="mapObj" class="view" style="width: '.$setting[width].'px; height:'.$setting[height].'px"></div>';
		$str .='<script type="text/javascript">';
		if($setting['maptype']==1) {
		$str .='
		var mapObj=null;
		lngX = "'.$lngX.'";
		latY = "'.$latY.'";
		zoom = "'.$zoom.'";
		var mapOptions = new MMapOptions();
		mapOptions.toolbar = MConstants.MINI;
		mapOptions.scale = new MPoint(20,20);  
		mapOptions.zoom = zoom;
		mapOptions.mapComButton = MConstants.SHOW_NO
		mapOptions.center = new MLngLat(lngX,latY);
		var mapObj = new MMap("mapObj", mapOptions);
		var  maptools = new MMapTools(mapObj);
		drawPoints();
		';
		$str .='
		function drawPoints(){
			var markerOption = new MMarkerOptions();
			var tipOption=new MTipOptions();//添加信息窗口 
			var address = "'.$address.'";
			tipOption.tipType = MConstants.HTML_BUBBLE_TIP;//信息窗口标题  
			tipOption.title = address;//信息窗口标题  
			tipOption.content = address;//信息窗口内容     
			var markerOption = new MMarkerOptions(); 		
			markerOption.imageUrl="'.IMG_PATH.'icon/mak.png";		
			markerOption.picAgent=false;   
			markerOption.imageAlign=MConstants.BOTTOM_CENTER; 	   
			markerOption.tipOption = tipOption; 		  
			markerOption.canShowTip= address ? true : false; 	  	
			markerOption.dimorphicColor="0x00A0FF"; 			 			
			Mmarker = new MMarker(new MLngLat(lngX,latY),markerOption);
			Mmarker.id="mark101";
			mapObj.addOverlay(Mmarker,true) 
		}';
		} elseif($setting['maptype']==2) {
			$str .='
			var mapObj=null;
			lngX = "'.$lngX.'";
			latY = "'.$latY.'";
			zoom = "'.$zoom.'";		
			var mapObj = new BMap.Map("mapObj");
			var ctrl_nav = new BMap.NavigationControl({anchor:BMAP_ANCHOR_TOP_LEFT,type:BMAP_NAVIGATION_CONTROL_LARGE});
			mapObj.addControl(ctrl_nav);
			mapObj.enableDragging();
			mapObj.enableScrollWheelZoom();
			mapObj.enableDoubleClickZoom();
			mapObj.enableKeyboard();//启用键盘上下左右键移动地图
			mapObj.centerAndZoom(new BMap.Point(lngX,latY),zoom);
			drawPoints();
			';
			$str .='
			function drawPoints(){
				var myIcon = new BMap.Icon("'.IMG_PATH.'icon/mak.png", new BMap.Size(27, 45));
				var center = mapObj.getCenter();
				var point = new BMap.Point(lngX,latY);
				var marker = new BMap.Marker(point, {icon: myIcon});
				mapObj.addOverlay(marker);
			}';	
		}
		$str .='</script>';
		return $str;
	}
