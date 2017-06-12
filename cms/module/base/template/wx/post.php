<extend file='resource/admin/wechat.php'/>
<block name="content">
    <ul class="nav nav-tabs" role="tablist">
        <li class=""><a href="{{url('wx.lists')}}">管理基本文字回复</a></li>
        <li class="active"><a href="{{url('wx.post')}}">添加基本文字回复</a></li>
    </ul>
    <form action="" method="post" role="form" class="form-horizontal">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">回复内容</h3>
            </div>
            <include file="resource/view/keyword.php"/>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">回复内容</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">栏目描述</label>
                    <div class="col-sm-10">
                        <textarea name="content" class="form-control" rows="5">{{$model['content']}}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <button class="btn btn-primary">保存数据</button>
    </form>
</block>