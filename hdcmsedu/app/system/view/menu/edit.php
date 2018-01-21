<extend file="resource/view/system"/>
<block name="content">
    <ol class="breadcrumb">
        <li><i class="fa fa-home"></i></li>
        <li><a href="?s=system/manage/menu">系统</a></li>
        <li class="active">菜单列表</li>
    </ol>
    <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="#">菜单列表</a></li>
    </ul>
    <h5 class="page-header">菜单列表</h5>
    <div class="alert alert-info">
        <i class="fa fa-info-circle"></i>
        系统内置的菜单不允许修改 "链接地址"，不允许切换 "显示状态", 不允许 "删除"
    </div>
    <form action="" method="post" id="form" v-cloak @submit.prevent="post">
        <div class="panel panel-default" ng-controller="ctrl">
            <div class="panel-body table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th width="80">排序</th>
                        <th width="300">名称</th>
                        <th width="120">标识</th>
                        <th width="180">图标</th>
                        <th width="180">链接地址</th>
                        <th>显示</th>
                        <th>系统</th>
                        <th width="180">子链接</th>
                        <th width="80">操作</th>
                    </tr>
                    </thead>
                    <tbody v-for="(v,k) in menus">
                    <tr>
                        <td><input v-model="v.orderby" class="form-control"></td>
                        <td>
                            <div :class="{pill:v._level>1}" :style="{'margin-left': v._level==3?'50px':0}">
                                <input v-model="v.title" class="form-control" value="基础设置" :placeholder="v.placeholder"
                                       style="width:150px;">
                            </div>
                        </td>
                        <td>
                            <span v-if="!v.new_add || v._level!=1">@{{v.mark}}</span>
                            <input v-if="v.new_add && v._level==1" v-model="v.mark" class="form-control">
                        </td>
                        <td>
                            <div class="input-group" v-if="v._level==1">
                                <input class="form-control" v-model="v.icon"/>
                                <span class="input-group-addon"><i :class="v.icon"></i></span>
                                <span class="input-group-btn">
                                    <button class="btn btn-default ico-modal" type="button"
                                            @click="changeIcon(v)">图标</button>
                                </span>
                            </div>
                            <span v-if="!v.new_add && v._level!=1">@{{v.permission}}</span>
                            <input v-if="v.new_add && v._level==3" v-model="v.permission" class="form-control"
                                   placeholder="权限标识">
                        </td>
                        <td>
                            <input v-if="v.new_add && v._level==3" v-model="v.url" class="form-control"
                                   placeholder="链接地址">
                        </td>
                        <td>
							<span class="btn btn-success" title="点击切换" @click="changeDisplayStatus(v.id,0)"
                                  v-if="v.is_display==1 && !v.new_add">显示</span>
                            <span class="btn btn-danger" title="点击切换" @click="changeDisplayStatus(v.id,1)"
                                  v-if="v.is_display==0 && !v.new_add">隐藏</span>
                        </td>
                        <td>
                            <span class="label label-danger" v-if="v.is_system==1 && !v.new_add">系统内置</span>
                            <span class="label label-success" v-if="v.is_system==0 && !v.new_add">自定义</span>
                        </td>
                        <td>
                            <input v-if="v.new_add && v._level==3" v-model="v.append_url" class="form-control"
                                   placeholder="子链接地址">
                        </td>
                        <td>
                            <span class="btn btn-danger btn-sm" v-show="v.is_system==0 && v.id"
                                  @click="delMenu(v,k)">删除</span>&nbsp;
                            <i class="fa fa-times-circle" v-if="v.new_add" style="cursor: pointer"
                               @click="menus.splice(k,1)"></i>
                        </td>
                    </tr>
                    <!--对最后一个三级菜单等场景进行判断-->
                    <tr v-if="showAddMenuButton(v,k)">
                        <td>&nbsp;</td>
                        <td colspan="8">
                            <div class="pill-bottom" style="margin-left:50px;cursor: pointer;"
                                 @click="addMenu(v,k,v.pid,3)">
                                &nbsp;&nbsp;<i class="fa fa-plus-circle"></i> 添加菜单
                            </div>
                        </td>
                    </tr>
                    <tr v-if="showAddMenuGroupButton(v,k)">
                        <td>&nbsp;</td>
                        <td colspan="8">
                            <div class="pill-bottom" style="cursor: pointer;" @click="addMenu(v,k,v.pid,2)">
                                &nbsp;&nbsp;<i class="fa fa-plus-circle"></i> 添加菜单组
                            </div>
                        </td>
                    </tr>
                    </tbody>
                    <tbody>
                    <tr>
                        <td>&nbsp;</td>
                        <td colspan="8">
                            <div class="add add_level0" style="cursor: pointer;" @click="addTopMenu()">
                                <i class="fa fa-plus-circle"></i> 添加顶级分类
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <textarea name="menu" hidden>@{{menus}}</textarea>
        <button class="btn btn-primary">保存</button>
    </form>
    <script>
        require(['vue', 'hdjs'], function (Vue, hdjs) {
            new Vue({
                el: '#form',
                data: {
                    menus: <?php echo $menus ?: old('menu');?>,
                },
                computed: {},
                methods: {
                    //显示字体模态框
                    changeIcon: function (item) {
                        hdjs.font(function (icon) {
                            item.icon = icon;
                        });
                    },
                    //更改菜单的显示状态
                    changeDisplayStatus: function (id, state) {
                        $.post("{!! u('changeDisplayState') !!}", {id: id, is_display: state}, function (json) {
                            hdjs.message(json.message, 'refresh', 'message');
                        }, 'json')
                    },
                    //显示添加菜单按钮（三级）
                    showAddMenuButton: function (v, k) {
                        if (v._level == 3 && !this.menus[k + 1]) {
                            return true;
                        }
                        if (v._level == 3 && this.menus[k + 1] && this.menus[k + 1]._level != 3) {
                            return true;
                        }
                        if (v._level == 2 && v.id && this.menus[k + 1]._level != 3) {
                            return true;
                        }
                        return false;
                    },
                    //显示添加菜单组按钮（二级）
                    showAddMenuGroupButton: function (v, k) {
                        if (this.menus[k + 1] && this.menus[k + 1]._level == 1) {
                            return true;
                        }
                        if (v.pid && !this.menus[k + 1]) {
                            return true;
                        }
                        return false;
                    },
                    //添加菜单
                    addMenu: function (item, index, pid, level) {
                        var placeholder = ['', '菜单组名称', '菜单名称'];
                        var data = {
                            id: false,
                            pid: 0,
                            title: '',
                            permission: '',
                            url: '',
                            append_url: '',
                            icon: 'fa fa-cubes',
                            orderby: 0,
                            _level: level,
                            is_display: 1,
                            is_system: 0,
                            new_add: 1,
                            mark: '',
                            placeholder: placeholder[level - 1]
                        };
                        data.pid = pid;
                        this.menus.splice(index + 1, 0, data);
                    },
                    //添加顶级菜单
                    addTopMenu: function () {
                        var data = {
                            id: false,
                            pid: 0,
                            title: '',
                            permission: '',
                            url: '',
                            append_url: '',
                            icon: 'fa fa-cubes',
                            orderby: 0,
                            _level: 1,
                            is_display: 1,
                            is_system: 0,
                            new_add: 1,
                            mark: '',
                            placeholder: '顶级分类名称'
                        };
                        this.menus.push(data);
                    },
                    //删除菜单
                    delMenu: function (item) {
                        hdjs.confirm('删除菜单将删除当前菜单及所有子菜单,确定删除吗?', function () {
                            $.post("{!! u('delMenu') !!}", {id: item.id}, function (res) {
                                if (res.valid == 1) {
                                    hdjs.message(res.message, 'refresh', 'success');
                                } else {
                                    hdjs.message(res.message, '', 'error');
                                }
                            }, 'json');
                        });
                    },
                    post: function () {
                        hdjs.submit({successUrl: 'refresh'});
                    }
                }
            });
        });
    </script>
    <style>
        .table > tbody, .table > tbody + tbody {
            border-top: none;
        }

        div.pill {
            height: 30px;
            padding-left: 50px;
        }

        div.pill-bottom {
            padding-left: 50px;
        }
    </style>
</block>