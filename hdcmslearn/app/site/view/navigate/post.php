<extend file="resource/view/site"/>
<block name="content">
    <ul class="nav nav-tabs" role="tablist">
        <li><a href="{{site_url('navigate.lists')}}&entry=home">导航菜单列表</a></li>
        <li class="active"><a href="javascript:;">添加导航菜单</a></li>
    </ul>
    <form class="form-horizontal" id="navigate" v-cloak @submit.prevent="submit($event)">
        <div class="panel panel-default">
            <div class="panel-heading">微站导航菜单</div>
            <div class="panel-body">
                <if value="q('get.entry')=='home'">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">导航显示位置</label>
                        <div class="col-sm-8">
                            <select class="form-control" v-model="field.position">
                                <option :value="v.position" v-for="(v,k) in template_position_data" v-html="v.title"></option>
                            </select>
                            <span class="help-block">
                                设置位置后可以将导航菜单显示到模板对应的位置中。
                                （可以同时设置多个导航在同一个位置中，会根据排序大小依次显示），显示的位置必须要有模板支持。
                            </span>
                        </div>
                    </div>
                </if>
                <div class="form-group">
                    <label class="col-sm-2 control-label star">导航名称</label>
                    <div class="col-sm-8">
                        <input class="form-control" v-model="field.name" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">描述</label>
                    <div class="col-sm-8">
                        <textarea class="form-control" rows="5" v-model="field.description"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">状态</label>
                    <div class="col-sm-8">
                        <label class="radio-inline">
                            <input type="radio" value="1" v-model="field.status" value="1"> 显示
                        </label>
                        <label class="radio-inline">
                            <input type="radio" value="0" v-model="field.status" value="0"> 隐藏
                        </label>
                        <span class="help-block">设置导航菜单的显示状态</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label star">直接链接</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input class="form-control" v-model="field.url" required>
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                    选择链接 <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <a href="javascript:;" @click.prevent="systemLink()">系统菜单</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">排序</label>
                    <div class="col-sm-8">
                        <input class="form-control" v-model="field.orderby" required>
                        <span class="help-block">导航排序，越大越靠前</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                导航样式
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">图标类型</label>
                    <div class="col-sm-9">
                        <label class="radio-inline">
                            <input type="radio" v-model="field.icontype" value="1"> 系统内置
                        </label>
                        <label class="radio-inline">
                            <input type="radio" v-model="field.icontype" value="2"> 自定义上传
                        </label>
                    </div>
                </div>
                <div id="icon" v-if="field.icontype==1">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">系统图标</label>
                        <div class="col-sm-9">
                            <div class="input-group" style="width: 300px;">
                                <input class="form-control iconfontinput" v-model="field.css.icon">
                                <span class="input-group-addon iconfontspan" style="border-left: none">
                                    <i :class="field.css.icon"></i>
                                </span>
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button" @click="upFont()">选择图标</button>
                              </span>
                            </div>
                            <span class="help-block">导航的背景图标，系统提供了丰富的图标ICON。</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">图标颜色</label>
                        <div class="col-sm-9">
                            <div class="input-group" style="width: 340px;">
                                <input class="form-control" v-model="field.css.color">
                                <span class="input-group-addon" id="basic-addon1"
                                      :style="{width: '40px','border-left':'none',background:field.css.color}">
                                </span>
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-default" id="getColor">选择颜色</button>
                                    <button type="button" class="btn btn-default">
                                        <i class="fa fa-remove"></i>
                                    </button>
                                </div>
                            </div>
                            <span class="help-block">图标颜色，上传图标时此设置项无效</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">图标大小</label>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <input class="form-control" v-model="field.css.size">
                                <span class="input-group-addon">px</span>
                            </div>
                            <span class="help-block">图标的尺寸大小，单位为像素，上传图标时此设置项无效</span>
                        </div>
                    </div>
                </div>
                <div id="iconimg" v-if="field.icontype==2">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">上传图标</label>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input class="form-control" v-model="field.css.image">
                                <div class="input-group-btn">
                                    <button @click="upImageIcon()" class="btn btn-default" type="button">选择图片</button>
                                </div>
                            </div>
                            <div class="input-group" style="margin-top:5px;" ng-if="field.css.image">
                                <img :src="field.css.image" class="img-responsive img-thumbnail iconimg"
                                     width="150">
                                <em class="close" style="position:absolute; top: 0px; right: -14px;" title="删除这张图片"
                                    @click="removeImageIcon()">×</em>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <textarea name="data" v-html="field" hidden></textarea>
        <button class="btn btn-default">保存</button>
    </form>
    <script type="text/ecmascript">
        require(['vue', 'hdjs', 'resource/js/hdcms.js','resource/js/link.js'], function (Vue, hdjs, hdcms,link) {
            var vm = new Vue({
                el: '#navigate',
                data: {
                    web: <?php echo json_encode($web, JSON_UNESCAPED_UNICODE);?>,
                    field: <?php echo json_encode($field, JSON_UNESCAPED_UNICODE);?>,
                    template_position_data:<?php echo json_encode($template_position_data, JSON_UNESCAPED_UNICODE);?>
                },
                mounted() {
                    //获取图标颜色
                    hdjs.colorpicker('#getColor',{
                        change:  (color) =>{
                            console.log(color)
                            this.field.css.color = color;
                        }
                    });
                },
                methods: {
                    //选择链接
                    systemLink() {
                        link.system((link) => {
                            vm.$set(vm.field, 'url', link);
                        });
                    },
                    //选择系统图标
                    upFont() {
                        hdjs.font((icon) => {
                            this.field.css.icon = icon;
                        });
                    },
                    //选择上传图片图标
                    upImageIcon() {
                        hdjs.image((images) => {
                            this.field.css.image = images[0];
                        })
                    },
                    //删除图片图标
                    removeImageIcon() {
                        this.field.css.image = '';
                    },
                    //提交表单
                    submit() {
                        hdjs.submit();
                    }
                }
            })
        })
    </script>
</block>