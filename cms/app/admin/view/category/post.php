<extend file='resource/admin/article.php'/>
<block name="content">
    <ul class="nav nav-tabs" role="tablist">
        <li><a href="{{u('lists')}}">栏目列表</a></li>
        <li class="active"><a href="{{u('post')}}">添加栏目</a></li>
    </ul>
    <form action="" method="post" role="form" class="form-horizontal">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">栏目数据</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">父级栏目</label>
                    <div class="col-sm-10">
                        <select name="pid" class="form-control">
                            <option value="0">顶级栏目</option>
                            <foreach from="$category" value="$d">
                                    <option value="{{$d['cid']}}" {{$d['_disabled']}} {{$d['_selected']}}>{{$d['_catname']}}</option>
                            </foreach>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">栏目标题</label>
                    <div class="col-sm-10">
                        <input type="text" name="catname" value="{{$model['catname']}}" class="form-control" id="" placeholder="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">栏目描述</label>
                    <div class="col-sm-10">
                        <textarea name="description" class="form-control" rows="10">{{$model['description']}}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">外部链接</label>
                    <div class="col-sm-10">
                        <input type="text" name="linkurl" value="{{$model['linkurl']}}" class="form-control" id="" placeholder="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">栏目排序</label>
                    <div class="col-sm-10">
                        <input type="orderby" class="form-control" value="{{$model['orderby']}}" id="" placeholder="">
                    </div>
                </div>
            </div>
        </div>
        <button class="btn btn-primary">保存数据</button>
    </form>
</block>