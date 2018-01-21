<extend file="resource/view/site"/>
<block name="content">
    <form class="form-horizontal" onsubmit="return post(event)">
        <ul class="nav nav-tabs" role="tablist">
            <li><a href="{!! url('model.lists') !!}">模型管理</a></li>
            <li class="active"><a href="javascript:;">添加模型</a></li>
        </ul>
        <input type="hidden" name="cid" ng-model="field.cid">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">模型设置</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">模型名称</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="model_title" value="{{$field['model_title']}}">
                        <span class="help-block">请输入中文可识别的标题如文章模型</span>
                    </div>
                </div>
                <if value="!Request::get('mid')">
                <div class="form-group">
                    <label class="col-sm-2 control-label">模型表名</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="model_name" value="{{$field['model_name']}}">
                        <span class="help-block">必须输入英文字母不能超过10个字符.添加后不能修改</span>
                    </div>
                </div>
                </if>
            </div>
        </div>
        <button class="btn btn-default" type="submit">保存模型</button>
    </form>
</block>
<script>
    //提交表单
    function post(event) {
        event.preventDefault();
        require(['hdjs'], function (hdjs) {
            hdjs.submit();
        });
    }
</script>