<extend file='resource/admin/system.php'/>
<block name="content">
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#" role="tab" data-toggle="tab">网站配置</a></li>
    </ul>
    <form action="" method="post" role="form" class="form-horizontal">
        <div class="alert alert-success">
            配置项可以在模板与控制器中使用，使用方法如: v('config.webname')<br/>如果我们在模板中使用时: { {v('config.webname')}}
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">网站配置</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">网站名称(webname)</label>
                    <div class="col-sm-10">
                        <input type="text" name="webname" value="{{$field['webname']}}" class="form-control" id="" placeholder="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">网站描述(description)</label>
                    <div class="col-sm-10">
                        <textarea name="description" class="form-control" name="description" rows="5">{{$field['description']}}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">ICP备案号(icp)</label>
                    <div class="col-sm-10">
                        <input type="text" name="icp" value="{{$field['icp']}}" class="form-control" id="" placeholder="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">客服电话(tel)</label>
                    <div class="col-sm-10">
                        <input type="text" name="tel" value="{{$field['tel']}}" class="form-control" id="" placeholder="">
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">文章配置</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">列表页条数</label>
                    <div class="col-sm-10">
                        <input type="text" name="article_row" value="{{$field['article_row']}}" class="form-control" id="" placeholder="">
                    </div>
                </div>
            </div>
        </div>
        <button class="btn btn-primary">保存数据</button>
    </form>
</block>