define(['angular', 'bootstrap', 'underscore', 'util', 'jquery-ui'], function (angular, $, _, util) {
    var m = angular.module('app', []);
    //服务
    m.factory('uc', function () {
        return {
            //菜单数据
            menu: window.menu,
        }
    });
    m.controller('commonCtrl', ['$scope', 'uc', function ($scope, uc) {
        $scope.menu = uc.menu;
        //改变菜单风格模板
        $scope.select_style = function () {
            //隐藏模态框
            $('#myModal').modal('hide');
            //界面显示模板
            $scope.tpl = $scope.menu.params.style + '_display.html';
            //数据编辑模板
            $scope.tplEdit = $scope.menu.params.style + '_edit.html';
        }
        $scope.link = {
            system: function (item) {
                util.linkBrowser(function (link) {
                    item.url=link;
                    $scope.$apply();
                });
            }
        }
        //选择模块
        $scope.moduleBrowsers = function (obj) {
            var mid = [];
            for (var i = 0; i < uc.menu.params.modules.length; i++) {
                mid.push(uc.menu.params.modules[i].mid);
            }
            util.moduleBrowser(function (modules) {
                uc.menu.params.modules = [];
                $(modules).each(function (i) {
                    uc.menu.params.modules.push({title: this.title, mid: this.mid});
                })
                $scope.$apply();
            }, mid.join(','));
        };
        //提交表单
        $scope.submit = function () {
            var f = $(".menu_html").html();
            f = f.replace(/<\!\-\-([^-]*?)\-\->/g, "");
            f = f.replace(/ng\-[a-zA-Z-]+=\"[^\"]*\"/g, "");
            f = f.replace(/ng\-[a-zA-Z]+/g, "");
            f = f.replace(/[\t\n\n\r]/g, "");
            f = f.replace(/>\s+</g, "><")
            $scope.menu.html = f;
            $("[name='data']").val(angular.toJson($scope.menu));
        }
    }]);
    //默认菜单管理控制器
    m.controller('normal', ['$scope', 'uc', function ($scope, uc) {
        //添加一级菜单
        $scope.addTopMenu = function () {
            if (uc.menu.params.menus.length == 3) {
                util.message('只能添加三个一级菜单', '', 'warning');
            } else {
                menu = {title: '', url: '', submenus: []};
                uc.menu.params.menus.push(menu);
            }
        }
        //添加二级菜单
        $scope.addChildMenu = function (pos) {
            if (uc.menu.params.menus[pos].submenus.length == 5) {
                util.message('只能添加三个五级菜单', '', 'warning');
            } else {
                menu = {title: '', url: ''};
                uc.menu.params.menus[pos].submenus.push(menu);
            }
        }
        //删除一级菜单
        $scope.removeTopMenu = function (item) {
            uc.menu.params.menus = _.without(uc.menu.params.menus, item);
        }
        //删除二级菜单
        $scope.removeChildMenu = function (pos, item) {
            uc.menu.params.menus[pos].submenus = _.without(uc.menu.params.menus[pos].submenus, item);
        }
    }]);
    m.run(function ($templateCache) {
        //--------------------------------------------------------商城导航菜单--------------------------------------------------------------------
        $templateCache.put('quickmenu_shop_display.html', '<div class="alert alert-info">新模板即将发布</div>');
        $templateCache.put('quickmenu_shop_edit.html', '<div class="alert alert-info">新模板即将发布</div>');
        //--------------------------------------------------------默认菜单normal--------------------------------------------------------------------
        //显示区域
        $templateCache.put('quickmenu_normal_display.html', '' +
            '<div class="quickmenu_normal" ng-controller="normal">\
            <div class="home" ng-if="menu.params.has_home_button">\
            <a href="?a=entry/home&m=article&t=web&siteid=' + sys.siteid + '&mobile=1"><i class="fa fa-home"></i></a>\
            </div>\
            <ul>\
            <li ng-repeat="v in menu.params.menus">\
            <a ng-href="{{v.url}}" ng-if="v.submenus.length==0" ng-bind="v.title"></a>\
            <a href="javascript:;" ng-if="v.submenus.length>0">\
            <i class="fa fa-bars" ng-if="v.submenus.length>0"></i> {{v.title}}\
        </a>\
        <div class="sub-menus" ng-if="v.submenus.length>0">\
            <a ng-href="{{m.url}}" ng-repeat="m in v.submenus" ng-bind="m.title"></a>\
        </div>\
            </li>\
            </ul>\
            </div>');
        //编辑区域
        $templateCache.put('quickmenu_normal_edit.html', '' +
        '<div class="checkbox"><label>\
            <input type="checkbox" value="1" ng-model="menu.params.has_home_button" ng-checked="menu.params.has_home_button">\
                        显示文章首页按钮\
            </label>\
        </div>\
            <div class="quickmenu_normal_setting" ng-controller="normal">\
            <div class="item" ng-repeat="(k,v) in menu.params.menus">\
            <i class="fa fa-times-circle delete-ico" ng-click="removeTopMenu(v)"></i>\
            <div class="top_menus">\
            <h3>一级导航</h3>\
            <div class="well">\
            <div class="form-group">\
            <label class="col-sm-2 control-label">标题</label>\
            <div class="col-sm-10">\
            <input type="text" class="form-control" ng-model="v.title">\
            </div>\
            </div>\
            <div class="form-group">\
            <label class="col-sm-2 control-label">链接到</label>\
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
            <div class="child_menus">\
            <h3>二级导航</h3>\
            <div class="well" ng-repeat="m in v.submenus" style="position: relative">\
            <i class="fa fa-times-circle delete-ico" ng-click="removeChildMenu(k,m)"></i>\
            <div class="form-group">\
            <label class="col-sm-2 control-label">标题</label>\
            <div class="col-sm-10">\
            <input type="text" class="form-control" ng-model="m.title">\
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
            <li><a href="javascript:;" ng-click="link.system(m)">系统菜单</a></li>\
            </ul>\
            </div>\
            </div>\
            </div>\
            </div>\
            </div>\
            <div class="add-child-menu" ng-click="addChildMenu($index)">\
            <i class="fa fa-plus"></i>添加二级菜单\
            </div>\
            </div>\
            </div>\
            <div class="add-top-menu text-center" ng-click="addTopMenu()">\
            <i class="fa fa-plus"></i>添加顶级菜单\
            </div><!--菜单设置 end-->\
        </div>');
    });
});