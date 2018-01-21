<extend file="resource/view/site"/>
<block name="content">
    <link rel="stylesheet" href="{{view_url()}}/css/quickmenu.css">
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="javascript:;">微站快捷导航</a></li>
    </ul>
    <form id="form" class="form-horizontal" v-cloak @submit.prevent="submit">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">基本配置</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-11">
                        <h4><strong>快捷导航</strong></h4>
                        <p>微站的各个页面可以通过导航串联起来。通过精心设置的导航，方便访问者在页面或是栏目间快速切换，引导访问者前往您期望的页面。</p>
                    </div>
                    <div class="col-sm-1 text-right">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" class="bootstrap-switch" v-model="menu.status" :true-value="1" :false-value="0">开启
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--        <div class="panel panel-default">-->
        <!--            <div class="panel-heading">选择模板</div>-->
        <!--            <div class="panel-body">-->
        <!--                当前模板: 微信公众号自定义菜单模板-->
        <!--                <button type="button" class="btn btn-default pull-right">选择模板</button>-->
        <!--            </div>-->
        <!--        </div>-->
        <div class="panel panel-default">
            <div class="panel-heading">
                导航应用页面:
            </div>
            <div class="panel-body">
                <div style="">
                    <label class="checkbox-inline">
                        <input type="checkbox" :true-value="1" v-model="menu.params.has_ucenter">会员中心
                    </label>
                    <label class="checkbox-inline">
                        <input type="checkbox" :true-value="1" v-model="menu.params.has_home"> 微站主页
                    </label>
                    <label class="checkbox-inline">
                        <input type="checkbox" :true-value="1" v-model="menu.params.has_article"> 文章及分类
                    </label>
                </div>
                <div style="margin-top: 10px;">
                    将导航隐藏在以下模块:
                    <a href="javascript:;" @click.prevent="moduleBrowsers()">选择模块</a>
                    <div style="margin-top: 10px;">
							<span class="label label-success" v-for="m in menu.params.modules" v-html="m.title"
                                  style="margin: 0px 5px 5px 0px;display: inline-block;"></span>
                        <span class="label label-warning" v-show="menu.params.modules.length==0">未设置，将在全部模块中显示</span>
                    </div>
                </div>
            </div>
        </div>
        <!--选择风格模板-->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">选择导航模板</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert">
                            <label class="radio-inline">
                                <input type="radio" value="quickmenu_normal" ng-model="menu.params.style"> 仿微信菜单模板
                            </label>
                            <div class="quickmenu_normal_img"></div>
                        </div>
                        <div class="alert">
                            <label class="radio-inline">
                                <input type="radio" value="quickmenu_shop" ng-model="menu.params.style"> 商城导航模板
                            </label>
                            <div class="quickmenu_shop_img"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <button type="button" class="btn btn-default" ng-click="select_style()">确定</button>
                    </div>
                </div>
            </div>
        </div>
        <!--选择风格模板 end-->
        <div class="quickmenuBox clearfix">
            <div class="mobile_view col-sm-4">
                <div class="mobile-header text-center">
                    <img src="resource/images/mobile_head_t.png" style="margin-top: 20px;">
                </div>
                <div class="mobile-body">
                    <img src="resource/images/mobile-header.png" style="width: 100%;">
                    <!--菜单显示区域-->
                    <div class="menu_html">
                        <div class="quickmenu">
                            <div class="normal">
                                <div class="home" v-show="menu.params.has_home_button">
                                    <a href=""><i class="fa fa-home"></i></a>
                                </div>
                                <dl v-for="v in menu.params.menus">
                                    <dt href="javascript:;">
                                        <span><i class="fa fa-bars"></i> @{{v.title}}</span>
                                    </dt>
                                    <dd class="sub-menus" v-for="m in v.submenus">
                                        <a href="javascript:;" v-html="m.title"></a>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mobile-footer">
                    <div class="home-btn"></div>
                </div>
            </div>
            <div class="slide col-sm-6">
                <div class="well menus_setting">
                    <div class="arrow-left"></div>
                    <!--菜单设置-->
                    <div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="1" v-model="menu.params.has_home_button"> 显示文章首页按钮
                            </label>
                        </div>
                        <div class="quickmenu_normal_setting">
                            <div class="item" v-for="(v,k) in menu.params.menus">
                                <i class="fa fa-times-circle delete-ico" @click="delMenu(menu.params.menus,k)"></i>
                                <div class="top_menus"><h3>一级导航</h3>
                                    <div class="well">
                                        <div class="form-group"><label class="col-sm-2 control-label">标题</label>
                                            <div class="col-sm-10"><input class="form-control" v-model="v.title"></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">链接到</label>
                                            <div class="col-sm-10">
                                                <div class="input-group">
                                                    <input class="form-control" v-model="v.url">
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                            选择链接 <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-right">
                                                            <li><a href="javascript:;" @click.prevent="systemLink(v)">系统菜单</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="child_menus">
                                    <h3>二级导航</h3>
                                    <div class="well" style="position: relative" v-for="(m,n) in v.submenus">
                                        <i class="fa fa-times-circle delete-ico" @click="delMenu(v.submenus,n)"></i>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">标题</label>
                                            <div class="col-sm-10"><input class="form-control" v-model="m.title"></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">链接到</label>
                                            <div class="col-sm-10">
                                                <div class="input-group">
                                                    <input class="form-control" v-model="m.url">
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                            选择链接 <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-right">
                                                            <li>
                                                                <a href="javascript:;" @click.prevent="systemLink(m)">系统菜单</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="add-child-menu" @click="addSonMenu(v)">
                                        <i class="fa fa-plus"></i>添加二级菜单
                                    </div>
                                </div>
                            </div>
                            <div class="add-top-menu text-center" @click="addTopMenu">
                                <i class="fa fa-plus"></i>添加顶级菜单
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <textarea name="data" hidden>@{{menu}}</textarea>
        <br>
        <div class="text-center">
            <button type="submit" class="btn btn-default">保存菜单</button>
            <button type="button" class="btn btn-default" onclick="location.reload(true)">放弃操作</button>
        </div>
    </form>
</block>
<script>
    require(['vue', 'hdjs', 'resource/js/hdcms.js','resource/js/link.js'], function (Vue, hdjs, hdcms,link) {
        var ve = new Vue({
            el: '#form',
            data: {
                menu: <?php echo $field;?>
            },
            methods: {
                //添加顶级菜单
                addTopMenu: function () {
                    var menu = {"title": "", "url": "", "submenus": []};
                    this.menu.params.menus.push(menu);
                },
                //添加子菜单
                addSonMenu: function (item) {
                    var menu = {"title": "", "url": ""};
                    item.submenus.push(menu)
                },
                //删除菜单
                delMenu: function (menu, key) {
                    menu.splice(key, 1);
                },
                //选择系统链接
                systemLink: function (obj) {
                    link.system(function (link) {
                        obj.url = link;
                    })
                },
                //选择模块
                moduleBrowsers: function (obj) {
                    var mid = [];
                    for (var i = 0; i < this.menu.params.modules.length; i++) {
                        mid.push(this.menu.params.modules[i].mid);
                    }
                    hdcms.moduleBrowser((modules) => {
                        this.menu.params.modules = [];
                        $(modules).each((i) => {
                            this.menu.params.modules.push(modules[i]);
                        })
                    }, mid.join(','));
                },
                //提交表单
                submit: function () {
                    var f = $(".menu_html").html();
                    f = f.replace(/<\!\-\-([^-]*?)\-\->/g, "");
                    f = f.replace(/v\-[a-zA-Z-]+=\"[^\"]*\"/g, "");
                    f = f.replace(/v\-[a-zA-Z]+/g, "");
                    f = f.replace(/[\t\n\n\r]/g, "");
                    f = f.replace(/>\s+</g, "><");
                    this.menu.html = f;
                    hdjs.submit({successUrl: 'refresh'});
                }
            }
        })
    });
</script>