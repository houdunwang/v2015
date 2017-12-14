function zoomimg(o){
	var zoom=parseInt(o.style.zoom, 10)||100;zoom+=event.wheelDelta/12;if (zoom>0) o.style.zoom=zoom+'%';
	return false;
}

function autosimg(o){
	if(o.width>screen.width*0.5)
	{
		o.width=screen.width*0.5;
	}
}