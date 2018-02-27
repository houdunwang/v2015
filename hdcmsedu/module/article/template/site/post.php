<extend file="resource/view/site"/>
<block name="content">
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="javascript:;">站点设置</a></li>
    </ul>
    <div class="alert alert-info">
        站点链接:<br/>
        <i class="fa fa-adn"></i>
        {{__ROOT__}}?m=article&action=controller/entry/index&siteid={{SITEID}}<br/>
        <i class="fa fa-adn"></i>如果在
        <a href="?s=system/site/edit&siteid={{SITEID}}" target="_blank">
            <strong>站点设置</strong>
        </a>
        中定义了域名,可以直接使用域名进行访问。<br/>
    </div>
    <form id="app" @submit.prevent="submit($event)" class="form-horizontal" v-cloak>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"> 模板风格</h3>
            </div>
            <div class="panel-body">
                <div v-show="field.status==1">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">风格类型</label>
                        <div class="col-sm-9">
                            <label class="radio-inline">
                                <input type="radio" value="1" v-model="field.template_type"> 系统模板
                            </label>
                            <label class="radio-inline">
                                <input type="radio" value="2" v-model="field.template_type"> 自定义模板目录
                            </label>
                        </div>
                    </div>
                    <div class="form-group" v-if="field.template_type==1">
                        <label class="col-sm-2 control-label star">站点风格</label>
                        <div class="col-sm-9">
                            <button class="btn btn-success" type="button" @click="loadTpl(this)">选择风格</button>
                            <span class="help-block">模板分手机端与桌面端, 如果模板风格没有手机端页面将使用系统模板风格(default),桌面端也是一样的。</span>
                        </div>
                    </div>
                    <div class="form-group template" v-show="field.template_tid && field.template_type==1">
                        <label class="col-sm-2 control-label star">当前风格</label>
                        <div class="col-sm-9 box" v-if="field.template_tid">
                            <div class="thumbnail">
                                <h5 v-html="field.template_title"></h5>
                                <img :src="field.template_thumb">
                            </div>
                        </div>
                    </div>
                    <div class="form-group" v-if="field.template_type==2">
                        <label for="" class="col-sm-2 control-label">选择模板目录</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" class="form-control" v-model="field.template_path">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button" @click="selectTemplateDir">选择模板目录</button>
                            </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">站点信息</h3>
            </div>
            <div class="panel-body">
                <if value="q('get.webid')">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">站点链接</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">
                                {{__ROOT__}}/?m=article&action=entry/home&siteid={{$_GET['webid']}}
                            </p>
                        </div>
                    </div>
                </if>
                <div class="form-group">
                    <label class="col-sm-2 control-label star">站点名称</label>
                    <div class="col-sm-9">
                        <input class="form-control" v-model="field.title" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">网站开启</label>
                    <div class="col-sm-9">
                        <label class="radio-inline">
                            <input type="radio" value="1" v-model="field.status"> 是
                        </label>
                        <label class="radio-inline">
                            <input type="radio" value="0" v-model="field.status"> 否
                        </label>
                    </div>
                </div>
                <div class="form-group" v-show="field.status==0">
                    <label class="col-sm-2 control-label star">关闭信息</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" rows="3" v-model="field.close_message"></textarea>
                        <span class="help-block">用于显示网站关闭时的提供信息。</span>
                    </div>
                </div>
                <div v-show="field.status==1">
                    <div class="form-group">
                        <label class="col-sm-2 control-label star">触发关键字</label>
                        <div class="col-sm-9">
                            <input class="form-control" @blur="checkWxKeyword($event)" v-model="field.keyword" placeholder="请输入微信关键词">
                            <span class="text-danger keyword_error"></span>
                            <span class="help-block">用户触发关键字，微信客户端发来这个关键词后系统回复此页面的图文链接</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label star">封面</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input required readonly class="form-control" v-model="field.thumb">
                                <div class="input-group-btn">
                                    <button @click="upImage()" class="btn btn-default" type="button">选择图片</button>
                                </div>
                            </div>
                            <div class="input-group" style="margin-top:5px;">
                                <img src="resource/images/nopic.jpg" class="img-responsive img-thumbnail" width="150" v-show="!field.thumb">
                                <img :src="field.thumb" class="img-responsive img-thumbnail" width="150" v-show="field.thumb">
                            </div>
                            <span class="help-block">用户通过微信客户端触发关键字后，系统回复时的图文消息的封面图片</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label star">页面关键字</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="3" v-model="field.keywords" required></textarea>
                            <span class="help-block">用于SEO的关键词内容</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label star">页面描述</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="3" v-model="field.description" required></textarea>
                            <span class="help-block">用户通过微信分享给朋友时,会自动显示页面描述, 同时也用于页面中SEO的描述内容</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">底部自定义</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="3" v-model="field.footer"></textarea>
                            <span class="help-block">自定义底部信息，支持HTML</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">其他选项</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">首页缓存时间</label>
                    <div class="col-sm-9">
                        <input class="form-control" v-model="field.index_cache_expire"/>
                        <span class="help-block">网站首页缓存时间单位为秒</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">模板分层</label>
                    <div class="col-sm-9">
                        <label class="radio-inline">
                            <input type="radio" value="1" v-model="field.template_dir_part"> 是
                        </label>
                        <label class="radio-inline">
                            <input type="radio" value="0" v-model="field.template_dir_part"> 否
                        </label>
                        <span class="help-block">指桌面端与移动端模板目录不同，移动端目录mobile桌面端目录web</span>
                    </div>
                </div>
            </div>
        </div>
        <textarea name="data" hidden>@{{field}}</textarea>
        <button class="btn btn-primary">确定</button>
    </form>
    <script type="application/ecmascript">
        require(['vue', 'hdjs', 'resource/js/hdcms.js'], function (Vue, hdjs, hdcms) {
            new Vue({
                el: "#app",
                data: {
                    field:<?php echo $field;?>
                },
                methods: {
                    //上传封面图片
                    upImage: function (obj) {
                        hdjs.image((images) => {
                            this.field.thumb = images[0];
                        })
                    },
                    //验证关键词
                    checkWxKeyword: function (elem) {
                        var obj = $(elem.currentTarget);
                        hdcms.checkWxKeyword(obj.val(), this.field.rid)
                    },
                    //选择模板目录
                    selectTemplateDir: function () {
                        hdcms.selectFile((file) => {
                            this.field.template_path = file;
                        })
                    },
                    //加载模板
                    loadTpl: function () {
                        hdcms.siteTemplateBrowser((data) => {
                            this.field.template_tid = data.tid;
                            this.field.template_title = data.title;
                            this.field.template_name = data.name;
                            this.field.template_thumb = data.thumb;
                        })
                    },
                    //提交表单
                    submit: function () {
                        var msg = '';
                        if (!this.field.thumb) {
                            msg += "请选择封面图片<br/>";
                        }
                        if ($(".keyword_error").text()) {
                            msg += "关键词已经存在<br/>";
                        }
                        if (!this.field.template_tid) {
                            msg += "请选择站点风格<br/>";
                        }
                        if (msg) {
                            hdjs.message(msg, '', 'error');
                            return false;
                        }
                        //提交表单
                        hdjs.submit({successUrl: 'refresh'})
                    }
                }
            })
        })
    </script>
    <style>
        .template .thumbnail {
            height: 270px;
            width: 180px;
            overflow: hidden;
            float: left;
            margin: 3px 7px;
        }

        .template .thumbnail .caption {
            padding: 0px;
        }

        .template .thumbnail h5 {
            font-size: 14px;
            overflow: hidden;
            height: 25px;
            margin: 3px 0px;
            line-height: 2em;
        }

        .template .thumbnail > img {
            height: 225px;
            max-width: 168px;
            border-radius: 3px;
        }

        .template .thumbnail .caption {
            margin-top: 8px;
        }
    </style>
</block>