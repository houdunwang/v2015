<extend file="resource/view/system"/>
<block name="content">
    <ol class="breadcrumb">
        <li><i class="fa fa-home"></i></li>
        <li><a href="?s=system/manage/menu">系统</a></li>
        <li class="active">设置公众号基本信息</li>
    </ol>
    <ul class="nav nav-tabs nav-justified">
        <li role="presentation" class="active"><a href="?s=system/site/wechat&step=wechat&siteid={{siteid()}}">设置公众号信息</a></li>
        <li role="presentation"><a href="?s=system/site/wechat&step=explain&siteid={{siteid()}}">微信平台设置信息</a></li>
    </ul>
    <form class="form-horizontal" onsubmit="post(event)">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">设置公众号基本信息</h4>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label star">公众号名称</label>
                    <div class="col-sm-10">
                        <input name="wename" class="form-control" value="{{$field['wename']}}" required>
                        <span class="help-block">填写公众号的帐号名称</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label star">微信号</label>
                    <div class="col-sm-10">
                        <input name="account" class="form-control" value="{{$field['account']}}" required="required">
                        <span class="help-block">填写公众号的帐号，一般为英文帐号</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label star">原始ID</label>
                    <div class="col-sm-10">
                        <input class="form-control" name="original" value="{{$field['original']}}" required="required">
                        <span class="help-block">在给粉丝发送客服消息时,原始ID不能为空,以gh_开始的</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label star">类型</label>
                    <div class="col-sm-10">
                        <label class="radio-inline">
                            <input type="radio" name="level" value="1" {{$field['level']==1?'checked="checked"':''}}> 普通订阅号
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="level" value="2" {{$field['level']==2?'checked="checked"':''}}> 普通服务号
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="level" value="3" {{$field['level']==3?'checked="checked"':''}}> 认证订阅号
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="level" value="4" {{$field['level']==4?'checked="checked"':''}}> 认证服务号/认证媒体/政府订阅号
                        </label>
                        <span class="help-block">注意：即使公众平台显示为“未认证”, 但只要【公众号设置】/【账号详情】下【认证情况】显示资质审核通过, 即可认定为认证号.</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label star">AppId</label>
                    <div class="col-sm-10">
                        <input class="form-control" name="appid" value="{{$field['appid']}}" required="required">
                        <span class="help-block">请填写微信公众平台后台的AppId</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label star">AppSecret</label>

                    <div class="col-sm-10">
                        <input class="form-control" name="appsecret" value="{{$field['appsecret']}}" required="required">
                        <span class="help-block">请填写微信公众平台后台的AppSecret, 只有填写这两项才能管理自定义菜单</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Oauth 2.0</label>

                    <div class="col-sm-10">
                        <p class="form-control-static">在微信公众号请求用户网页授权之前，开发者需要先到公众平台网站的【开发者中心】网页服务中配置授权回调域名。</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">二维码</label>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <input class="form-control ng-pristine ng-untouched ng-valid" name="qrcode" value="{{$field['qrcode']}}" readonly>
                            <div class="input-group-btn">
                                <button onclick="upImage(this)" class="btn btn-default" type="button">选择图片</button>
                            </div>
                        </div>
                        <div class="input-group" style="margin-top:5px;">
                            <img src="{{pic($field['qrcode'])}}" class="img-responsive img-thumbnail" width="150" id="thumb">
                            <em class="close" style="position:absolute; top: 0px; right: -14px;" title="删除这张图片">×</em>
                        </div>
                        <span class="help-block">只支持JPG图片</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">头像</label>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <input class="form-control ng-pristine ng-untouched ng-valid" name="icon" value="{{$field['icon']}}" readonly>
                            <div class="input-group-btn">
                                <button onclick="upImage(this)" class="btn btn-default" type="button">选择图片</button>
                            </div>
                        </div>
                        <div class="input-group" style="margin-top:5px;">
                            <img src="{{pic($field['icon'])}}" class="img-responsive img-thumbnail" width="150" id="thumb">
                            <em class="close" style="position:absolute; top: 0px; right: -14px;" title="删除这张图片">×</em>
                        </div>
                        <span class="help-block">只支持JPG图片</span>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">下一步</button>
    </form>
    <script>
        function upImage(obj) {
            require(['hdjs'], function (hdjs) {
                hdjs.image(function (images) {
                    //上传成功的图片，数组类型
                    if (images.length > 0) {
                        $(obj).parent().prev().val(images[0]);
                        $(obj).parent().parent().next().find('img').eq(0).attr('src', images[0]);
                    }
                })
            })
        }

        //提交表单
        function post(event) {
            event.preventDefault();
            require(['hdjs'], function (hdjs) {
                hdjs.submit({successUrl:"{!! u('wechat', ['step' => 'explain', 'siteid' => siteid()]) !!}"});
            })
        }
    </script>
    <style>
        .nav li.normal {
            background: #eee;
        }

        .nav li.normal a, .nav li.normal a:active, .nav li.normal a:focus {
            border: none;
        }
    </style>
</block>
