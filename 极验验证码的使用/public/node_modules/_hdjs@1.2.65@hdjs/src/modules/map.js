import modal from './modal'
let instance={};
export default (val, callback) => {
    $.getScript('http://api.map.baidu.com/getscript?v=2.0&ak=WcqLYXBH2tHLhYNfPNpZCD4s&services=&t=20160708193109',function(){
        if (!val) {
            val = {};
        }
        if (!val.lng) {
            val.lng = 116.403851;
        }
        if (!val.lat) {
            val.lat = 39.915177;
        }
        var point = new BMap.Point(val.lng, val.lat);
        var geo = new BMap.Geocoder();

        var modalobj = $('#map-dialog');
        if (modalobj.length == 0) {
            var content =
                '<style>.tangram-suggestion-main { z-index : 9999; }/*搜索样式*/</style>' +
                '<div class="form-group">' +
                '<div class="input-group">' +
                '<input type="text" class="form-control" id="suggestId" placeholder="请输入地址来直接查找相关位置">' +
                '<input type="text" id="coordinate" class="form-control" style="display: none;">' +
                '<div id="searchResultPanel" style="border:1px solid #c0c0c0;width:150px;height:auto; display:none;z-index:2000"></div>' +
                '<div class="input-group-btn">' +
                '<button class="btn btn-default"><i class="icon-search"></i> 搜索</button>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<div id="map-container" style="height:400px;"></div>';
            var footer =
                '<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>' +
                '<button type="button" class="btn btn-primary">确认</button>';
            modalobj = modal({
                title: '请选择地点',
                content: content,
                footer: footer,
                id: 'map-dialog'
            });
            modalobj.find('.modal-dialog').css('width', '80%');
            modalobj.modal({'keyboard': false});

            map = instance.map = new BMap.Map('map-container');
            map.centerAndZoom(point, 12);
            map.enableScrollWheelZoom();
            map.enableDragging();
            map.enableContinuousZoom();
            map.addControl(new BMap.NavigationControl());
            map.addControl(new BMap.OverviewMapControl());
            marker = instance.marker = new BMap.Marker(point);
            marker.setLabel(new BMap.Label('可移动标记设置坐标', {'offset': new BMap.Size(10, -20)}));
            map.addOverlay(marker);
            marker.enableDragging();

            marker.addEventListener('dragend', function (e) {
                var point = marker.getPosition();
                geo.getLocation(point, function (address) {
                    modalobj.find('#suggestId').val(address.address);
                    modalobj.find('#coordinate').val(e.point.lng + "," + e.point.lat);
                });
            });

            function searchAddress(address) {
                geo.getPoint(address, function (point) {
                    map.panTo(point);
                    marker.setPosition(point);
                    marker.setAnimation(BMAP_ANIMATION_BOUNCE);
                    setTimeout(function () {
                        marker.setAnimation(null)
                    }, 3600);
                });
            }

            modalobj.find('.input-group :text').keydown(function (e) {
                if (e.keyCode == 13) {
                    var kw = $(this).val();
                    searchAddress(kw);
                }
            });
            modalobj.find('.input-group button').click(function () {
                var kw = $(this).parent().prev().prev().prev().val();
                searchAddress(kw);
            });

            //百度地图API功能
            function G(id) {
                return document.getElementById(id);
            }

            //建立一个自动完成的对象
            var ac = new BMap.Autocomplete({
                "input": "suggestId"
                , "location": map
            });

            ac.addEventListener("onhighlight", function (e) {  //鼠标放在下拉列表上的事件
                var str = "";
                var _value = e.fromitem.value;
                var value = "";
                if (e.fromitem.index > -1) {
                    value = _value.province + _value.city + _value.district + _value.street + _value.business;
                }
                str = "FromItem<br />index = " + e.fromitem.index + "<br />value = " + value;

                value = "";
                if (e.toitem.index > -1) {
                    _value = e.toitem.value;
                    value = _value.province + _value.city + _value.district + _value.street + _value.business;
                }
                str += "<br />ToItem<br />index = " + e.toitem.index + "<br />value = " + value;
                G("searchResultPanel").innerHTML = str;
            });

            var myValue;
            ac.addEventListener("onconfirm", function (e) {
                //鼠标点击下拉列表后的事件
                var _value = e.item.value;
                myValue = _value.province + _value.city + _value.district + _value.street + _value.business;
                G("searchResultPanel").innerHTML = "onconfirm<br />index = " + e.item.index + "<br />myValue = " + myValue;
                setPlace();
            });

            function setPlace() {
                //map.clearOverlays();    //清除地图上所有覆盖物a
                function myFun() {
                    var pp = local.getResults().getPoi(0).point;    //获取第一个智能搜索的结果
                    var coordinate = pp.lng + "," + pp.lat;
                    modalobj.find('#coordinate').val(coordinate);
                }

                var local = new BMap.LocalSearch(map, { //智能搜索
                    onSearchComplete: myFun
                });
                local.search(myValue);
            }

        }
        modalobj.off('shown.bs.modal');
        modalobj.on('shown.bs.modal', function () {
            marker.setPosition(point);
            map.panTo(marker.getPosition());
        });

        modalobj.find('button.btn-primary').off('click');
        modalobj.find('button.btn-primary').on('click', function () {
            if ($.isFunction(callback)) {
                var point = instance.marker.getPosition();
                geo.getLocation(point, function (address) {
                    var val = {lng: point.lng, lat: point.lat, address: address.address};
                    callback(val);
                });
            }
            modalobj.modal('hide');
        });
        modalobj.modal('show');
    });
}