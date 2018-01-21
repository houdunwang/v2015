<extend file="resource/view/system"/>
<block name="content">
    <ol class="breadcrumb">
        <li><i class="fa fa-home"></i></li>
        <li><a href="?s=system/manage/menu">系统</a></li>
        <li class="active">编辑站点资料</li>
    </ol>
    <form class="form-horizontal" onsubmit="post(event)">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">网站基本信息</h4>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label star">网站名称</label>
                    <div class="col-sm-10">
                        <input type="text" name="name" class="form-control" value="{{$site['name']}}">
                        <span class="help-block">网站中显示的网站名称,可以使用中文等任意字符</span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label star">网站描述</label>
                    <div class="col-sm-10">
                        <textarea name="description" class="form-control" cols="30" rows="5">{{$site['description']}}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">会员中心风格</label>
                    <div class="col-sm-10">
                        <input type="text" name="ucenter_template" readonly="readonly" class="form-control" value="{{$site['ucenter_template']}}">
                        <span class="help-block">网站会员中心使用的模板风格</span>
                    </div>
                </div>
            </div>
        </div>
        <button class="btn btn-primary">保存修改</button>
    </form>
</block>
<script>
    function post(event){
        event.preventDefault();
        require(['hdjs'],function(hdjs){
            hdjs.submit();
        })
    }
</script>