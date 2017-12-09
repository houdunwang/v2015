<extend file="resource/view/site"/>
<block name="content">
    <ul class="nav nav-tabs" role="tablist">
        <if value="Request::get('entry')=='home'&& v('module.is_system')==1">
            <li class="active">
                <a href="javascript:;"><?= $NavigateModel->title(); ?></a>
            </li>
            <li>
                <a href="{{site_url('navigate.post')}}&entry=home">添加菜单</a>
            </li>
            <else/>
            <li class="active">
                <a href="javascript:;"><?= $NavigateModel->title(); ?></a>
            </li>
        </if>
    </ul>
    <form method="post" id="form" class="form-horizontal" v-cloak @submit.prevent="submit($event)">
        <if value="Request::get('entry')=='home'">
            <div class="alert alert-info">
                <div v-show="template.position">
                    当前使用的风格为：@{{template.title}}，模板目录：theme/@{{template.name}}。此模板提供 @{{template.position}}
                    个导航位置，您可以指定导航在特定的位置显示，未指位置的导航将无法显示
                </div>
                <div v-show="!template.position">
                    当前使用的风格为：@{{template.title}}，模板目录：theme/@{{template.name}}。此模板未提供导航位置
                </div>
            </div>
        </if>
        <div class="panel panel-default">
            <div class="panel-heading">
                这里提供了能够显示的导航菜单, 你可以选择性的自定义或显示隐藏, 所有操作更改后需要点击保存按钮才有效。
            </div>
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th width="50">编号</th>
                        <th>图标</th>
                        <th width="150">标题</th>
                        <th>链接</th>
                        <th width="80">排序</th>
                        <if value="Request::get('entry')=='home'">
                            <!--模块链接时不显示位置,位置在文章系统有效-->
                            <th width="90">位置</th>
                        </if>
                        <th>开启</th>
                        <th>可用会员组</th>
                        <th width="150">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(field,key) in nav">
                        <td v-html="field.id"></td>
                        <td>
                            <i @click="upFont(field)" v-if="field.icontype==1" class="fa-2x" :class="field.css.icon"
                               :style="{color:field.css.color}"></i>
                            <img v-if="field.icontype==2" :src="field.css.image" style="width:35px;">
                        </td>
                        <td>
                            <input type="text" class="form-control" v-model="field.name">
                        </td>
                        <td>
                            <div class="input-group">
                                <input type="text" class="form-control" v-model="field.url">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                            aria-haspopup="true"
                                            aria-expanded="false">选择链接 <span class="caret"></span></button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="javascript:;" @click="url.linkBrowsers(field)">系统菜单</a></li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                        <td>
                            <input type="number" class="form-control" v-model="field.orderby"/>
                        </td>
                        <if value="Request::get('entry')=='home'">
                            <!--模块链接时不显示位置,位置在文章系统有效-->
                            <td>
                                <select class="form-control" v-model="field.position">
                                    <option v-for="(v,k) in template_position" :value="v.position" v-html="v.title"></option>
                                </select>
                            </td>
                        </if>
                        <td>
                            <div class="switch" data-on="primary" data-off="info">
                                <input type="checkbox" :data="key" :true-value="1" :false-value="0"  class="bootstrap-switch" v-model="field.status">
                            </div>
                        </td>
                        <td v-if="field.id">
                            <select name="" class="form-control" v-model="field.groups" multiple size="3">
                                <option v-for="v in groups" :value="v.id" v-html="v.title"></option>
                            </select>
                        </td>
                        <td v-if="field.id">
                            <div class="btn-group">
                                <a class="btn btn-default" @click.prevent="edit(field)">
                                    编辑
                                </a>
                                <a href="javascript:;" @click="del(field.id)" class="btn btn-default">删除</a>
                            </div>
                        </td>
                        <td v-if="!field.id"></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <textarea name="data" v-html="nav" hidden></textarea>
        <button type="submit" class="btn btn-default">保存修改</button>
    </form>
    <script>
        require(['hdjs'],function(hdjs){
            hdjs.bootstrapswitch('.bootstrap-switch');
        })
    </script>
    <script type="text/ecmascript">
        require(['hdjs', 'resource/js/hdcms.js','resource/js/link.js', 'vue'], function (hdjs, hdcms, link,Vue) {
            var vm = new Vue({
                el: '#form',
                mounted() {
                    //更改状态
                    setTimeout(() => {
                        $(".bootstrap-switch").bootstrapSwitch();
                        $('.bootstrap-switch').on('switchChange.bootstrapSwitch', (event, state) => {
                            var data = this.nav[$(event.currentTarget).attr('data')];
                            if (!data) return;
                            data.status = state ? 1 : 0;
                        });
                    }, 100);
                },
                computed: {
                    //只有在菜单类型为封面菜单即GET参数entry='home'有template数据
                    template_position() {
                        if (this.template) {
                            var position = [];
                            for (var i = 1; i <= this.template.position; i++) {
                                position.push({position: i, title: '位置' + i});
                            }
                            return position;
                        }
                    }
                },
                data: {
                    template:<?php echo empty($template) ? 'null' : json_encode($template);?>,
                    nav:<?php echo json_encode($nav);?>,
                    groups:<?php echo json_encode($groups);?>
                },
                methods: {
                    //编辑导航
                    edit(field) {
                        var url = "{{site_url('navigate.post')}}&entry=" + field.entry + "&id=" + field.id;
                        location.href = url;
                    },
                    //提交表单
                    submit() {
                        hdjs.submit({successUrl: 'refresh'});
                    },
                    //获取系统链接
                    systemLink: function (field) {
                        link.system(function (link) {
                            field.url = link;
                        });
                    },
                    //删除菜单
                    del(id) {
                        hdjs.confirm('确定删除菜单吗?', () => {
                            $.get("{{site_url('navigate.del')}}", {id: id}, function (res) {
                                if (res.valid) {
                                    hdjs.message(res.message, 'refresh', 'success')
                                } else {
                                    hdjs.message(res.message, '', 'error');
                                }
                            }, 'json');
                        })
                    },
                    //选择系统图标
                    upFont(item) {
                        hdjs.font(function (icon) {
                            item.css.icon = icon;
                        });
                    }
                }
            })
        });
    </script>
</block>
