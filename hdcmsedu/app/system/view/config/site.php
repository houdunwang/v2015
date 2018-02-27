<extend file="resource/view/system"/>
<block name="content">
    <ol class="breadcrumb">
        <li><i class="fa fa-home"></i></li>
        <li><a href="?s=system/manage/menu">系统</a></li>
        <li class="active">站点设置</li>
    </ol>
    <ul class="nav nav-tabs">
        <li role="presentation" class="active">
            <a href="javascript:;">站点选项</a>
        </li>
    </ul>
    <form class="form-horizontal" method="post" id="form" v-cloak @submit.prevent="submit">
        <div class="panel panel-default">
            <div class="panel-heading">
                基本设置
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">开启站点</label>
                    <div class="col-sm-10">
                        <label class="radio-inline">
                            <input type="radio" value="1" v-model="field.is_open"> 是
                        </label>
                        <label class="radio-inline">
                            <input type="radio" value="0" v-model="field.is_open"> 否
                        </label>
                    </div>
                </div>
                <div class="form-group" ng-show="field.is_open==0">
                    <label class="col-sm-2 control-label">关闭原因</label>
                    <div class="col-sm-6">
                        <textarea class="form-control" v-model="field.close_message" rows="6"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">系统更新提示</label>
                    <div class="col-sm-10">
                        <label class="radio-inline">
                            <input type="radio" value="1" v-model="field.hdcms_update_notice"> 是
                        </label>
                        <label class="radio-inline">
                            <input type="radio" value="0" v-model="field.hdcms_update_notice"> 否
                        </label>
                        <span class="help-block">当HDCMS系统有更新时站内进行通知</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                上传配置
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">上传大小</label>
                    <div class="col-sm-5">
                        <div class="input-group">
                            <input class="form-control" v-model="field.upload.size">
                            <span class="input-group-addon">KB</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">上传类型</label>
                    <div class="col-sm-5">
                        <input class="form-control" v-model="field.upload.type">
                        <span class="help-block">请用英文半角逗号分隔文件类型</span>
                    </div>
                </div>
                <div class="form-group" v-if="false">
                    <label class="col-sm-2 control-label">上传类型</label>
                    <div class="col-sm-10">
                        <label class="radio-inline">
                            <input type="radio" value="local" v-model="field.upload.mold"> 本地上传
                        </label>
                        <label class="radio-inline">
                            <input type="radio" value="oss" v-model="field.upload.mold"> 阿里云OSS
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">上传目录</label>
                    <div class="col-sm-5">
                        <input class="form-control" v-model="field.upload.path">
                        <span class="help-block">上传到本地服务器的目录名称</span>
                    </div>
                </div>
                <div class="well" v-if="false">
                    <div class="form-group" v-if="field.upload.mold=='oss'">
                        <label class="col-sm-2 control-label">bucket</label>
                        <div class="col-sm-5">
                            <input class="form-control" v-model="field.oss.bucket">
                            <span class="help-block">Bucket块名称 https://oss.console.aliyun.com/index</span>
                        </div>
                    </div>
                    <div class="form-group" v-if="field.upload.mold=='oss'">
                        <label class="col-sm-2 control-label">域名</label>
                        <div class="col-sm-5">
                            <input class="form-control" v-model="field.oss.endpoint">
                            <span class="help-block">请登录阿里云后台查看,可以设置阿里云提供的公共域名，也可以使用自定义域名。<br/>
                            如果使用自定义域名，需要将下面的 "使用自定义域名" 设置为 "是"</span>
                        </div>
                    </div>
                    <div class="form-group" v-if="field.upload.mold=='oss'">
                        <label class="col-sm-2 control-label">自定义域名</label>
                        <div class="col-sm-10">
                            <label class="radio-inline">
                                <input type="radio" value="1" v-model="field.oss.custom_domain"> 是
                            </label>
                            <label class="radio-inline">
                                <input type="radio" value="0" v-model="field.oss.custom_domain"> 否
                            </label>
                            <span class="help-block">是否使用自定义域名，需要先在阿里云后台OSS业务处解析好域名</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">开发模式</div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">调试模式</label>
                    <div class="col-sm-10">
                        <label class="radio-inline">
                            <input type="radio" value="1" v-model="field.app.debug"> 开启
                        </label>
                        <label class="radio-inline">
                            <input type="radio" value="0" v-model="field.app.debug"> 关闭
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">伪静态</label>

                    <div class="col-sm-10">
                        <label class="radio-inline">
                            <input type="radio" value="1" v-model="field.http.rewrite"> 开启
                        </label>
                        <label class="radio-inline">
                            <input type="radio" value="0" v-model="field.http.rewrite"> 关闭
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <textarea name="site" hidden>@{{field}}</textarea>
        <button class="btn btn-primary">提交</button>
    </form>
    <script>
        require(['vue', 'hdjs'], function (vue, hdjs) {
            new vue({
                el: '#form',
                data: {
                    field:<?php echo json_encode(v('config.site'))?>
                },
                methods: {
                    submit: function () {
                        hdjs.submit({successUrl: 'refresh'});
                    }
                }
            });
        })
    </script>
</block>


