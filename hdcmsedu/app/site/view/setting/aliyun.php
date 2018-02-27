<extend file="resource/view/site"/>
<block name="content">
    <ul class="nav nav-tabs">
        <li role="presentation" class="active">
            <a href="javascript:;">阿里云设置</a>
        </li>
    </ul>
    <form class="form-horizontal" method="post" id="form" v-cloak @submit.prevent="submit">
        <div class="panel panel-default">
            <div class="panel-heading">基本设置</div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">开启</label>
                    <div class="col-sm-10">
                        <label class="radio-inline">
                            <input type="radio" value="1" v-model="field.aliyun.use_site_aliyun"> 是
                        </label>
                        <label class="radio-inline">
                            <input type="radio" value="0" v-model="field.aliyun.use_site_aliyun"> 否
                        </label>
                        <span class="help-block">
                            正确设置阿里云才可以使用OSS等功能
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">regionId</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="field.aliyun.regionId">
                        <span class="help-block">
                            根据服务器所在区域进行选择
                            https://help.aliyun.com/document_detail/40654.html?spm=5176.7114037.1996646101.1.OCtdEo
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">accessId</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" v-model="field.aliyun.accessId">
                        <span class="help-block">
                            如果使用主账号访问，登陆阿里云 AccessKey 管理页面创建、查看 <br>
                            登录阿里云访问控制查看 https://ram.console.aliyun.com
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">accessKey</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" v-model="field.aliyun.accessKey">
                        <span class="help-block">
                            如果使用主账号访问，登陆阿里云 AccessKey 管理页面创建、查看 <br>
                            登录阿里云访问控制查看 https://ram.console.aliyun.com
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="alert alert-success">
            设置了OSS后站点所有储存将使用OSS进行保存。<br>
            必须将上面的基本设置配置正确
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">OSS设置</div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">开启</label>
                    <div class="col-sm-10">
                        <label class="radio-inline">
                            <input type="radio" value="1" v-model="field.oss.use_site_oss"> 是
                        </label>
                        <label class="radio-inline">
                            <input type="radio" value="0" v-model="field.oss.use_site_oss"> 否
                        </label>
                        <span class="help-block">
                            开启后文件将上传到阿里云OSS中
                        </span>
                    </div>
                </div>
                <div class="form-group" v-show="field.oss.use_site_oss==1">
                    <label for="" class="col-sm-2 control-label">储存块</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="field.oss.bucket">
                        <span class="help-block">Bucket块名称 https://oss.console.aliyun.com/index</span>
                    </div>
                </div>
                <div class="form-group" v-show="field.oss.use_site_oss==1">
                    <label for="" class="col-sm-2 control-label">域名</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="field.oss.endpoint">
                        <span class="help-block">请登录阿里云后台查看,可以设置阿里云提供的公共域名，也可以使用自定义域名。<br/>
                            如果使用自定义域名，需要将下面的 "使用自定义域名" 设置为 "是"</span>
                    </div>
                </div>
                <div class="form-group" v-show="field.oss.use_site_oss==1">
                    <label for="" class="col-sm-2 control-label">自定义域名</label>
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
        <textarea name="config" hidden>@{{field}}</textarea>
        <button class="btn btn-primary">提交</button>
    </form>
    <script>
        require(['vue', 'hdjs'], function (vue, hdjs) {
            new vue({
                el: '#form',
                data: {
                    field:<?php echo json_encode(v('site.setting.aliyun'))?>
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


