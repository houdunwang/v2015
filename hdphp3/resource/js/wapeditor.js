define(['angular', 'bootstrap', 'underscore', 'util', 'angular.drag', 'jquery-ui'], function (angular, $, _, util) {
    var m = angular.module('app', ['dndLists']);
    //服务
    m.factory('uc', function () {
        return {
            //动态菜单
            menus: window.menus ? window.menus : [],
            //组件数据
            modules: {
                //所有组件参数
                all: window.modules ? window.modules : [],
                //当前操作的组件
                active: window.modules ? _.first(window.modules) : [],
                //可使用的组件
                config: [
                    {id: 'UCheader', name: '会员中心'},
                    {id: 'wireLine', name: '辅助空白'},
                    {id: 'textNav', name: '文本导航'},
                ]
            },
            //在添加/删除元素时更新索引值
            updateIndex: function () {
                for (var i = 0; i < this.modules.all.length; i++) {
                    this.modules.all[i].index = i;
                }
            },
            //添加组件
            addWidget: function (id) {
                len = this.modules.all.length;
                switch (id) {
                    case 'wireLine':
                        data = {id: 'wireLine', name: '辅助空白', params: [{height: 20}], issystem: 0, orderby: len, index: len};
                        break;
                    case 'textNav':
                        data = {id: 'textNav', name: '文本导航', params: [{title: '', url: ''}], issystem: 0, orderby: len, index: len};
                        break;
                }
                this.modules.all.push(data);
                this.modules.active = _.last(this.modules.all);
                this.updateIndex();
                //编辑框位置
                $("#" + data.id).css({'margin-top': $("#module-lists").position().top + $("#module-lists").height() - 20});
            },
            //删除组件
            delWidget: function (index) {
                this.modules.all = _.filter(this.modules.all, function (item) {
                    return item.index != index;
                });
                this.modules.active = _.last(this.modules.all);
                this.updateIndex();
                var top = $("[index=" + this.modules.active.index + "]").offset().top - $("#mobile").offset().top - 20;
                $("#" + this.modules.active.id).css({'margin-top': top});
            },
            //编辑组件
            editWidget: function (index) {
                var item = _.find(this.modules.all, function (item) {
                    return item.index == index;
                })
                this.modules.active = item;
                var top = $("[index=" + item.index + "]").offset().top - $("#mobile").offset().top - 20;
                $("#" + item.id).css({'margin-top': top});
            },
        }
    });
    //添加模块按钮控制器,用于管理模块添加按钮
    m.controller('moduleManage', ['$scope', 'uc', function ($scope, uc) {
        //添加动态元素
        $scope.addWidget = function (id) {
            uc.addWidget(id);
        }
    }]);

    //公共控制器
    m.controller('commonCtrl', ['$scope', 'uc', function ($scope, uc) {
        $scope.active = uc.modules.active;
        $scope.menus = uc.menus;
        uc.updateIndex();
        $scope.modules = uc.modules;
        $scope.delWidget = function (index) {
            uc.delWidget(index);
        }
        $scope.editWidget = function (index) {
            uc.editWidget(index);
        }
        //鼠标放在模块上时显示编辑与删除按钮
        $("body").delegate('.module_item', 'mouseenter', function () {
            $(this).addClass('hover_module_active');
        }).delegate('.module_item', 'mouseleave', function () {
            $(this).removeClass('hover_module_active');
        })
        //添加菜单
        $scope.addMenu = function () {
            $scope.menus.push({icon: 'fa fa-cubes', name: '', url: '',css:{"icon":"fa fa-external-link"}});
        };
        //删除菜单
        $scope.delMenu = function (item) {
            $scope.menus = _.without($scope.menus, item);
        };
        //提交表单
        $scope.submit = function () {
            widgets = [];
            for (var i = 0; i < $scope.modules.all.length; i++) {
                if ($scope.modules.all[i].id == 'UCheader') {
                    widgets.push($scope.modules.all[i]);
                }
            }
            for (var i = 0; i < $scope.modules.all.length; i++) {
                if ($scope.modules.all[i].id != 'UCheader') {
                    widgets.push($scope.modules.all[i]);
                }
            }
            var modules = "<textarea name='modules' hidden='hidden'>" + angular.toJson(widgets) + "</textarea>";
            $('form').append(modules);
            var f = $("#module-lists").find('div').remove('.module-edit-action').html();
            f = f.replace(/<\!\-\-([^-]*?)\-\->/g, "");
            f = f.replace(/ng\-[a-zA-Z-]+=\"[^\"]*\"/g, "");
            f = f.replace(/ng\-[a-zA-Z]+/g, "");
            f = f.replace(/[\t\n\n\r]/g, "");
            f = f.replace(/>\s+</g, "><")
            var html = "<textarea name='html' hidden='hidden'>" + f + "</textarea>";
            $('form').append(html);
            //菜单
            var menus = "<textarea name='menus' hidden='hidden'>" + angular.toJson($scope.menus) + "</textarea>";
            $('form').append(menus);
        }
        //选择系统菜单
        $scope.link = {
            system: function () {
                var item = $(event.srcElement).parent().parents('div').eq(0).prev('input');
                util.linkBrowser(function (link) {
                    item.val(link);
                    item.trigger('change');
                });
            }
        }
        //选择字体图标
        $scope.iconFont = function () {
            util.font(function (ico) {
                var item = $(event.srcElement).parent().prev('input');
                item.val(ico);
                item.trigger('change');
            });
        }
    }]);

    //菜单管理
    m.controller('UCheader', ['$scope', 'uc', function ($scope, uc) {
        $scope.menuIcon = function (menu) {
            util.font(function (icon) {
                menu.css.icon = icon;
                $scope.$apply();
            });
        }
        //封面图片
        $scope.thumb = function () {
            util.image(function (images) {
                uc.modules.active.params.thumb = images[0];
                $scope.$apply();
            }, {})
        }
        //背景图片
        $scope.bgimg = function () {
            util.image(function (images) {
                uc.modules.active.params.bgimg = images[0];
                $scope.$apply();
            }, {})
        }
    }]);
    //辅助空白控制器
    m.controller('wireCtrl', ['$scope', 'uc', function ($scope, uc) {
        $scope.editWidget = function (index) {
            var item = _.find(uc.modules.all, function (item) {
                return item.index == index;
            });
            uc.editWidget(index);
            //滑动元素时改变编辑区滑块宽度
            $(".slider").slider({
                value: item.params[0].height,
                stop: function (event, ui) {
                    uc.modules.active.params[0].height = ui.value;
                    $scope.$apply();
                }
            });
        }
    }]);

    //文本导航控制器
    m.controller('textNavCtrl', ['$scope', 'uc', function ($scope, uc) {
        $scope.addNav = function () {
            uc.modules.active.params.push({title: '', url: ''});
        }
        $scope.remove = function (item) {
            uc.modules.active.params = _.without(uc.modules.active.params, item);
            if (uc.modules.active.params.length == 0) {
                uc.delWidget(uc.modules.active);
            }
        }
    }]);

    m.run(function ($templateCache) {
        //--------------------------------------------------------会员中心顶部内容--------------------------------------------------------------------
        $templateCache.put('widget-ucheader-display.html', '\
        <div ng-click="editWidget(m.index)" index="{{m.index}}" ng-controller="UCheader">\
        <div class="header" style="background-image: url({{m.params.bgimg?m.params.bgimg:\'resource/images/mobile-center-bg.jpg\'}})">\
                                <div class="col-xs-3 ico">\
                                    <img src="resource/images/user.jpg" alt="">\
                                </div>\
                                <div class="col-xs-7 user">\
                                    <h2 class="col-xs-12">后盾网向军老师</h2>\
                                    <div class="col-xs-6">普通会员</div>\
                                    <div class="col-xs-6">100积分</div>\
                                </div>\
                                <div class="col-xs-2">\
                                    <a href="javascript:;" class="pull-right setting"><i class="fa fa-angle-right"></i></a>\
                                </div>\
                            </div>\
                            <div class="well pay clearfix">\
                                <div class="col-xs-3">\
                                    <a href="">\
                                        <i class="fa fa-credit-card"></i>\
                                        <span>折扣券</span>\
                                    </a>\
                                </div>\
                                <div class="col-xs-3">\
                                    <a href="">\
                                        <i class="fa fa-diamond"></i>\
                                        <span>代金券</span>\
                                    </a>\
                                </div>\
                                <div class="col-xs-3">\
                                    <a href="">\
                                        <i class="fa fa-flag-o"></i>\
                                        <span>积分</span>\
                                    </a>\
                                </div>\
                                <div class="col-xs-3">\
                                    <a href="">\
                                        <i class="fa fa-money"></i>\
                                        <span>余额</span>\
                                    </a>\
                                </div>\
                            </div>\
</div>\
       ');

        $templateCache.put('widget-ucheader-editor.html', '\
        <div ng-controller="UCheader" class="ucheader">\
                    <div class="form-group">\
                        <label class="col-sm-3 control-label star">页面名称</label>\
                        <div class="col-sm-9">\
                            <input type="text" class="form-control" ng-model="active.params.title" required="required">\
                        </div>\
                    </div>\
                    <div class="form-group">\
                        <label class="col-sm-3 control-label">背景图片</label>\
                        <div class="col-sm-9">\
                            <input type="hidden" ng-model="active.params.bgimg"/>\
                            <button ng-click="bgimg()" class="btn btn-default" type="button">选择图片</button>\
                        </div>\
                    </div>\
                    <div class="form-group">\
                        <label class="col-sm-3 control-label star">触发关键字</label>\
                        <div class="col-sm-9">\
                            <input type="text" class="form-control" ng-model="active.params.keyword" required="required" onblur="util.checkWxKeyword(this,rid)">\
                            <span class="help-block"></span>\
                            <span class="help-block">用户触发关键字，系统回复此页面的图文链接</span>\
                        </div>\
                    </div>\
                    <div class="form-group">\
                        <label class="col-sm-3 control-label star">封面</label>\
                        <div class="col-sm-9">\
                            <input type="hidden" ng-model="active.params.thumb"/>\
                            <button ng-click="thumb()" class="btn btn-default" type="button">选择图片</button>\
                            <div class="input-group" style="margin-top:5px;" ng-show="active.params.thumb">\
                                <img ng-if="active.params.thumb" ng-src="{{active.params.thumb}}" class="img-responsive img-thumbnail" width="150">\
                                <em class="close" style="position:absolute; top: 0px; right: -14px;" title="删除这张图片" ng-click="active.params.thumb=\'\'">×</em>\
                            </div>\
                        </div>\
                    </div>\
                    <div class="form-group">\
                        <label class="col-sm-3 control-label star">页面描述</label>\
                        <div class="col-sm-9">\
                            <input type="text" class="form-control" ng-model="active.params.description" required="required">\
                        </div>\
                    </div>\
                    <div class="page-header">\
                        个人中心扩展菜单\
                    </div>\
                    <div class="col-sm-12 ext-menus" ng-repeat="(k,v) in menus">\
                        <div ng-click="delMenu(v)" class="del-menu"><i class="fa fa-times-circle delete-ico"></i></div>\
                        <div class="alert">\
                            <div class="form-group">\
                                <label class="col-sm-2 control-label">标题</label>\
                                <div class="col-sm-10">\
                                    <div class="input-group">\
                                        <input type="text" class="form-control" ng-model="v.name">\
                                          <span class="input-group-btn">\
                                              <input type="hidden" ng-model="v.icon">\
                                              <button class="btn btn-default" type="button" ng-click="menuIcon(v)">选择图标</button>\
                                          </span>\
                                    </div>\
                                </div>\
                            </div>\
                            <div class="form-group">\
                                <label for="" class="col-sm-2 control-label">链接到</label>\
                                <div class="col-sm-10">\
                                    <div class="input-group">\
                                        <input type="text" class="form-control" ng-model="v.url">\
                                        <div class="input-group-btn">\
                                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">选择链接 <span class="caret"></span></button>\
                                            <ul class="dropdown-menu dropdown-menu-right">\
                                                <li><a href="javascript:;" ng-click="link.system(v)">系统菜单</a></li>\
                                            </ul>\
                                        </div>\
                                    </div>\
                                </div>\
                            </div>\
                        </div>\
                    </div>\
                    <div class="add_item col-sm-12" ng-click="addMenu()">\
                        <i class="fa fa-plus"></i> 添加导航\
                    </div>\
        </div>\
        ');
        //--------------------------------------------------------空白线--------------------------------------------------------------------
        $templateCache.put('widget-wireline-display.html', '\
            <div ng-controller="wireCtrl">\
                <div ng-style="{height:d.height}" ng-repeat="d in m.params" ng-click="editWidget(m.index)" index="{{m.index}}">\
                    <div class="module-edit-action">\
                        <a href="javascript:;" ng-click="editWidget(m.index)">编辑</a>\
                        <a href="javascript:;" ng-click="delWidget(m.index)">删除</a>\
                    </div>\
                </div>\
            </div>\
        ');
        $templateCache.put('widget-wireline-editor.html', '\
            <div class="form-group" ng-controller="wireCtrl" >\
                <label class="col-sm-3 control-label">空白高度</label>\
                <div class="col-sm-9" style="margin-top:8px;">\
                    <div class="slider"></div>\
                </div>\
            </div>\
        ');
        //--------------------------------------------------------文本导航--------------------------------------------------------------------
        $templateCache.put('widget-textnav-display.html', '\
            <div ng-controller="textNavCtrl" class="textNavDisplay" index="{{m.index}}" ng-click="editWidget(m.index)">\
                <ul class="list-group">\
                    <li class="list-group-item" ng-repeat="m in m.params">\
                        <a ng-href="{{m.url}}" style="padding-left:0px;">{{m.title}}</a>\
                        <i class="fa fa-angle-right pull-right"></i>\
                    </li>\
                </ul>\
                <div class="module-edit-action">\
                    <a href="javascript:;" ng-click="editWidget(m.index)">编辑</a>\
                    <a href="javascript:;" ng-click="delWidget(m.index)">删除</a>\
                </div>\
            </div>\
        ');
        $templateCache.put('widget-textnav-editor.html', '\
            <div ng-controller="textNavCtrl" class="navTextEditor textnav">\
                <div class="navBox" ng-repeat="m in modules.active.params">\
                    <i class="fa fa-times-circle delete-ico" ng-click="remove(m)"></i>\
                    <div class="form-group">\
                        <label class="col-sm-2 control-label">标题</label>\
                        <div class="col-sm-10">\
                            <input type="text" class="form-control" ng-model="m.title" placeholder="请输入标题">\
                        </div>\
                    </div>\
                    <div class="form-group">\
                        <label class="col-sm-2 control-label">链接到</label>\
                        <div class="col-sm-10">\
                            <div class="input-group">\
                                <input type="text" class="form-control" ng-model="m.url">\
                                <div class="input-group-btn">\
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">选择链接 <span class="caret"></span></button>\
                                    <ul class="dropdown-menu dropdown-menu-right">\
                                        <li><a href="#" ng-click="link.system()">系统菜单</a></li>\
                                    </ul>\
                                </div>\
                            </div>\
                        </div>\
                    </div>\
                </div>\
                <div class="addTextNav" ng-click="addNav()"><i class="fa fa-plus"></i> 添加一个文本导航</div>\
            </div>\
        ');
    });
});