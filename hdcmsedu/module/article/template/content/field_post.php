<extend file="resource/view/site"/>
<block name="content">
    <ul class="nav nav-tabs" role="tablist">
        <li><a href="{!! url('field.lists',['mid'=>$_GET['mid']]) !!}">字段列表</a></li>
        <li class="active"><a href="javascript:;">修改字段</a></li>
    </ul>
    <form method="post" @submit.prevent="submit($event)" class="form-horizontal" id="form" v-cloak>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">基本信息</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">中文名称</label>
                    <div class="col-sm-9">
                        <input class="form-control" v-model="active.title">
                        <span class="help-block">用于在表单中录入数据时提示的中文名称</span>
                    </div>
                </div>
                <if value="!Request::get('id')">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">英文标识</label>
                        <div class="col-sm-9">
                            <input class="form-control" v-model="active.name">
                            <span class="help-block">就是表中的字段名只能输入不超过10个字符的英文</span>
                        </div>
                    </div>
                </if>
                <div class="form-group">
                    <label class="col-sm-2 control-label">字段排序</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" v-model="active.orderby">
                        <span class="help-block">排序只能输入0~255的数字</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">必须录入</label>
                    <div class="col-sm-9">
                        <label class="radio-inline">
                            <input type="radio" v-model="active.required" value="1"> 是
                        </label>
                        <label class="radio-inline">
                            <input type="radio" v-model="active.required" value="0"> 否
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <if value="!Request::get('id')">
            <div class="alert alert-info">
                <i class="fa fa-exclamation-triangle"></i>
                为了数据安全字段类型只允许添加时设置, 所以请认真斟酌选择字段类型。
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">字段类型</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">中文名称</label>
                        <div class="col-sm-9">
                            <select name="" class="form-control" v-model="type">
                                <option value="string">字符串</option>
                                <option value="text">长文本</option>
                                <option value="int">数字类型</option>
                                <option value="image">图片</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">选项</label>
                        <div class="col-sm-9">
                            <!--字符串类型-->
                            <div class="well well-sm" v-show="type=='string'">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">字段类型</label>
                                    <div class="col-sm-10">
                                        <label class="radio-inline">
                                            <input type="radio" v-model="active.field" value="char">char
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" v-model="active.field" value="varchar"> varchar
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">字符长度</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" v-model="active.length">
                                    </div>
                                </div>
                            </div>
                            <!--长文本类型-->
                            <div class="well well-sm" v-show="type=='text'">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">显示类型</label>
                                    <div class="col-sm-10">
                                        <label class="radio-inline">
                                            <input type="radio" v-model="active.form" value="textarea"> 文本域
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" v-model="active.form" value="ueditor"> 百度编辑器
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!--数值类型-->
                            <div class="well well-sm" v-show="type=='int'">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">字段类型</label>
                                    <div class="col-sm-10">
                                        <label class="radio-inline">
                                            <input type="radio" v-model="active.field" value="tinyInteger"> tinyint
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" v-model="active.field" value="smallint"> smallint
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" v-model="active.field" value="integer"> integer(int)
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!--图片-->
                            <div class="well well-sm" v-show="type=='image'">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">允许大小</label>
                                    <div class="col-sm-10">
                                        <div class="input-group">
                                            <input class="form-control" v-model="active.size">
                                            <span class="input-group-addon">MB</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </if>
        <textarea name="options" v-html="active" hidden></textarea>
        <button class="btn btn-default">保存字段</button>
    </form>
    <script type="text/ecmascript">
        require(['vue', 'hdjs'], function (Vue, hdjs) {
            new Vue({
                el: '#form',
                data: {
                    //字段类型
                    type: "string",
                    options: {
                        string: {
                            title: '',
                            name: '',
                            orderby: 0,
                            required: 0,
                            type: 'string',
                            field: 'varchar',
                            form: 'input',
                            length: 100
                        },
                        image: {
                            title: '',
                            name: '',
                            orderby: 0,
                            required: 0,
                            type: 'image',
                            field: 'varchar',
                            form: 'input',
                            length: 300,
                            size: 2
                        },
                        text: {
                            title: '',
                            name: '',
                            orderby: 0,
                            required: 0,
                            type: 'text',
                            field: 'text',
                            form: 'ueditor'
                        },
                        int: {
                            title: '',
                            name: '',
                            orderby: 0,
                            required: 0,
                            type: 'int',
                            field: 'integer',
                            form: 'input'
                        }
                    },
                    //当前选择的类型
                    active:<?php echo $options;?>,
                },
                watch: {
                    type(n, o) {
                        var old = this.active;
                        this.active = this.options[n];
                        this.active.title = old.title;
                        this.active.name = old.name;
                        this.active.orderby = old.orderby;
                        this.active.required = old.required;
                    }
                },
                methods: {
                    submit() {
                        var msg = '';
                        if (this.active.title == '') {
                            msg += '中文名称不能为空<br/>';
                        }
                        if (this.active.name == '') {
                            msg += '英文标识不能为空<br/>';
                        }
                        if (this.active.orderby > 255) {
                            msg += '排序不能超过255<br/>';
                        }
                        if (msg) {
                            hdjs.message(msg, '', 'error');
                            return false;
                        }
                        hdjs.submit();
                    }
                }
            })
        });
    </script>
    <style>
        .form-group {
            margin-bottom: 5px;
        }
    </style>
</block>