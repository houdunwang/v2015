<extend file="resource/view/system"/>
<block name="content">
    <div class="clearfix">
        <ol class="breadcrumb">
            <li><i class="fa fa-home"></i></li>
            <li><a href="?s=system/manage/menu">系统</a></li>
            <li class="active">设置新模板</li>
        </ol>
        <ul class="nav nav-tabs">
            <li role="presentation"><a href="{!! u('installed') !!}">已经安装模板</a></li>
            <li role="presentation"><a href="?s=system/template/prepared">安装模板</a></li>
            <li role="presentation" class="active"><a href="javascript:;">设计新模板</a></li>
            <li role="presentation"><a href="{!! u('shop.lists',['type'=>'template']) !!}">模板商城</a>
        </ul>
        <form class="form-horizontal" method="post" id="form" v-cloak @submit.prevent="submit()">
            <h5 class="page-header">模板基本信息
                <small>这里来定义你自己模板的基本信息</small>
            </h5>
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label star">模板名称</label>
                <div class="col-sm-10 col-xs-12">
                    <input class="form-control" v-model="field.title" required>
                    <span class="help-block">模板的名称, 由于显示在用户的模板列表中. 不要超过10个字符 </span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label star">模板标识</label>
                <div class="col-sm-10 col-xs-12">
                    <input class="form-control" v-model="field.name" required>
                    <span class="help-block">模板标识符, 对应模板文件夹的名称, 系统按照此标识符查找模板定义, 只能由英文字母组成 </span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label star">模板类型</label>
                <div class="col-sm-10 col-xs-12">
                    <select v-model="field.industry" class="form-control">
                        <option :value="c.name" v-for="c in industry">@{{c.title}}</option>
                    </select>
                    <span class="help-block">模板的类型, 用于分类展示和查找你的模板 </span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label star">模板简述</label>
                <div class="col-sm-10 col-xs-12">
                    <input class="form-control" v-model="field.resume" required>
                    <span class="help-block">模板功能描述, 使用简单的语言描述模板, 来吸引用户 </span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label star">作者</label>
                <div class="col-sm-10 col-xs-12">
                    <input class="form-control" v-model="field.author" required>
                    <span class="help-block">模板的作者, 留下你的大名吧 </span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label star">发布页</label>
                <div class="col-sm-10 col-x s-12">
                    <input class="form-control" v-model="field.url" required>
                    <span class="help-block">模板的发布页, 用于发布模板更新信息的页面 </span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label star">微站导航菜单数量</label>
                <div class="col-sm-10 col-xs-12">
                    <input type="number" class="form-control" v-model="field.position" required>
                    <span class="help-block">微站导航菜单数量 </span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label star">官网预览图</label>
                <div class="col-sm-10">
                    <div class="input-group">
                        <input class="form-control" readonly v-model="field.thumb" required>
                        <div class="input-group-btn">
                            <button @click="uploadPreview()" class="btn btn-default" type="button">选择图片</button>
                        </div>
                    </div>
                    <div class="input-group" style="margin-top:5px;">
                        <img :src="field.thumb?field.thumb:'resource/images/nopic.jpg'"
                             class="img-responsive img-thumbnail img-cover" width="150">
                        <em class="close" style="position:absolute; top: 0px; right: -14px;" title="删除这张图片"
                            @click="field.thumb=''">×</em>
                    </div>
                    <span class="help-block">模块封面, 大小为 600*350, 更好的设计将会获得官方推荐位置</span>
                </div>
            </div>
            <textarea name="data" v-html="field" hidden></textarea>
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"></label>
                <div class="col-sm-10 col-xs-12">
                    <button class="btn btn-primary">生成模板</button>
                    <p class="help-block">点此直接在源码目录 theme<span class="identifie"></span> 处生成模板文件, 方便快速开发</p>
                </div>
            </div>
        </form>
    </div>
    <script>
        require(['vue', 'hdjs'], function (Vue, hdjs) {
            new Vue({
                el: '#form',
                data: {
                    industry: [
                        {title: '常用模板', name: 'often'},
                        {title: '酒店', name: 'rummery'},
                        {title: '汽车', name: 'car'},
                        {title: '旅游', name: 'tourism'},
                        {title: '餐饮', name: 'drink'},
                        {title: '房地产', name: 'realty'},
                        {title: '医疗保健', name: 'medical'},
                        {title: '教育', name: 'education'},
                        {title: '健身美容', name: 'cosmetology'},
                        {title: '婚纱摄影', name: 'shoot'},
                        {title: '其他', name: 'other'}
                    ],
                    field:<?php echo old('data', '{
                        "title": "",
                        "name": "",
                        "industry": "often",
                        "resume": "",
                        "author": "",
                        "detail": "",
                        "url": "http://www.hdcms.com",
                        "position": 0,
                        "thumb": "",
                    }');?>
                },
                methods: {
                    uploadPreview: function () {
                        hdjs.image( (images) =>{
                            this.field.thumb = images[0];
                        }, {data: {uploadMold: 'local'}})
                    },
                    submit: function () {
                        var msg = ''
                        if (this.field.title == '') {
                            msg += '模板名称不能为空<br/>';
                        }
                        if (this.field.name == '' || !/^[a-z]+$/.test(this.field.name)) {
                            msg += '模板标识必须为英文小写字母<br/>';
                        }
                        if (!/^\d+$/.test(this.field.position)) {
                            msg += '微站导航菜单数量必须为数字<br/>';
                        }
                        if (this.field.resume == '') {
                            msg += '模板简述不能为空<br/>';
                        }
                        if (this.field.author == '') {
                            msg += '模板作者不能为空<br/>';
                        }
                        if (this.field.url == '') {
                            msg += '发布网址不能为空<br/>';
                        }
                        if (this.field.thumb == '') {
                            msg += '官网预览图不能为空<br/>';
                        }
                        if (msg != '') {
                            hdjs.message(msg, '', 'warning');
                            return false;
                        }
                        hdjs.submit({
                            successUrl:"{!! u('prepared') !!}"
                        });
                    }
                }
            })
        })
    </script>
</block>