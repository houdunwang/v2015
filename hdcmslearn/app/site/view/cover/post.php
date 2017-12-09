<extend file="resource/view/site"/>
<block name="content">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#">{{$field['name']}}</a></li>
    </ul>
    <form class="form-horizontal" role="form">
        <include file="app/site/view/rule/keyword"/>
        <div class="panel panel-default">
            <div class="panel-heading">
                链接地址
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">URL地址</label>
                    <div class="col-sm-7 col-md-8">
                        <input type="text" class="form-control" readonly="readonly" value="{{__ROOT__}}{{$field['url']}}">
                        <span class="help-block">您可以在微信自定义菜单或其他任何位置直接使用这个链接地址</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">功能封面 {{$module['title']}}</div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">封面参数</label>
                    <div class="col-sm-8">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">标题</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="title" value="{{$field['title']}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">描述</label>
                                    <div class="col-sm-10">
                                        <textarea name="description" class="form-control" rows="3">{{$field['description']}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">封面</label>
                                    <div class="col-sm-10">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="thumb" readonly="" value="{{$field['thumb']}}">
                                            <div class="input-group-btn">
                                                <button onclick="upImage(this)" class="btn btn-default" type="button" onclick="upImage(this)">选择图片
                                                </button>
                                            </div>
                                        </div>
                                        <div class="input-group" style="margin-top:5px;">
                                            <img src="{{$field['thumb']?:'resource/images/nopic.jpg'}}" class="img-responsive img-thumbnail"
                                                 width="150">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">直接URL</label>
                                    <div class="col-sm-10">
                                        <p class="form-control-static">{{root_url()}}/{{$field['url']}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        {{$moduleForm}}
        <button class="btn btn-primary">保存</button>
    </form>
</block>
<script>
    function upImage(obj) {
        require(['hdjs'], function (hdjs) {
            hdjs.image(function (images) {
                $("[name='thumb']").val(images[0]);
                $(".img-thumbnail").attr('src', images[0]);
            })
        })
    }
    require(['hdjs'], function (hdjs) {
        $('form').submit(function () {
            var msg = '';
            if ($.trim($("[name='title']").val()) == '') {
                msg += '标题不能为空<br/>';
            }
            if ($.trim($("[name='description']").val()) == '') {
                msg += '描述不能为空<br/>';
            }
            if ($.trim($("[name='thumb']").val()) == '') {
                msg += '封面图片不能为空<br/>';
            }
            if (msg) {
                hdjs.message(msg, '', 'error');
                return false;
            }
        })
    })
</script>

