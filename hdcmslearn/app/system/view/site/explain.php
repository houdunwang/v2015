<extend file="resource/view/system"/>
<block name="content">
    <ol class="breadcrumb">
        <li><i class="fa fa-home"></i></li>
        <li><a href="?s=system/manage/menu">系统</a></li>
        <li class="active">接入到公众平台</li>
    </ol>
    <ul class="nav nav-tabs nav-justified">
        <li role="presentation"><a href="?s=system/site/wechat&step=wechat&siteid={{SITEID}}">设置公众号信息</a></li>
        <li role="presentation" class="active">
            <a href="?s=system/site/wechat&step=explain&siteid={{SITEID}}">微信平台设置信息</a></li>
    </ul>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">接入到公众平台</h3>
        </div>
        <div class="panel-body">
            <div class="alert alert-info">
                您绑定的微信公众号：<strong class="text-danger">{{$wechat['wename']}}</strong>，请按照下列引导完成配置。
            </div>
            <ul class="list-group">
                <li class="list-group-item">
                    <h5 class="page-header">登录 <a href="https://mp.weixin.qq.com/" class="text-danger">微信公众平台</a>，点击左侧菜单最后一项，进入
                        [ <span class="text-info">开发者中心</span> ]</h5>
                    <img src="resource/images/weichat/Snip20160308_5.png" class="img-thumbnail">

                    <h5># 如果您未成为开发者，请勾选页面上的同意协议，再点击 [ 成为开发者 ] 按钮</h5>
                </li>
                <li class="list-group-item">
                    <h5 class="page-header">在开发者中心，找到［ 服务器配置 ］栏目下URL和Token设置</h5>
                    <img src="resource/images/weichat/Snip20160308_8.png" class="img-thumbnail">
                    <h5># 将以下链接链接填入对应输入框：</h5>
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">URL</label>
                            <div class="col-sm-10">
                                <p class="form-control-static">
                                    <a href="javascript:;" class="text-info copy" data-clipboard-text="{{root_url()}}/index.php?s=site/api/handle&siteid={{siteid()}}">
                                        {{root_url()}}/index.php?s=site/api/handle&siteid={{siteid()}}
                                    </a>
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Token</label>
                            <div class="col-sm-10">
                                <p class="form-control-static">
                                    <a href="javascript:;" class="text-info copy" data-clipboard-text="{{$wechat['token']}}">{{$wechat['token']}}</a>
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">EncodingAESKey</label>
                            <div class="col-sm-10">
                                <p class="form-control-static">
                                    <a href="javascript:;" class="text-info copy" data-clipboard-text="{{$wechat['encodingaeskey']}}">{{$wechat['encodingaeskey']}}</a>
                                </p>
                            </div>
                        </div>
                    </form>
                </li>
                <li class="list-group-item">
                    <h5 class="page-header">
                        公众号 <strong class="text-info">{{$wechat['wename']}}</strong>
                        正在等待接入……请及时按照以上步骤操作接入公众平台
                    </h5>
                    <p>编辑公众号 <a href="?s=system/site/wechat&step=wechat&siteid={{siteid()}}">{{$wechat['wename']}}</a></p>
                    <button class="btn btn-success" onclick="checkConnect();">检测公众号【{{$wechat['wename']}}】是否接入成功
                    </button>
                    <a href="?s=system/site/lists" class="btn btn-info">返回站点列表</a>
                </li>
            </ul>
        </div>
    </div>
    <script>
        //复制链接
        require(['hdjs'], function (hdjs) {
            var clipboard = hdjs.clipboard('.copy', {},function (e) {
                hdjs.notify('复制成功');
            })
        })
    </script>
    <script>
        //检测公众号接入
        function checkConnect() {
            require(['hdjs'], function (hdjs) {
                axios.get("?s=system/site/connect&siteid={{SITEID}}", {params: {}}).then(function (response) {
                    if (_.isObject(response.data)) {
                        if (response.data.valid) {
                            hdjs.message(response.data.message, '', 'success');
                        } else {
                            hdjs.message(response.data.message, '', 'error');
                        }
                    } else {
                        hdjs.message(response.data.data, '', 'info');
                    }
                }).catch(function (error) {
                    console.log(error);
                })
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