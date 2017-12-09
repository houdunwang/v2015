<extend file="resource/view/site"/>
<block name="content">
    <ul class="nav nav-tabs">
        <li><a href="{!! url('site/Fieldlists') !!}">字段管理</a></li>
        <li class="active"><a href="javascript:;"><i class="fa fa-plus"></i> 编辑字段</a></li>
    </ul>
    <form method="post" role="form" class="form-horizontal" onsubmit="post(event)">
        <input type="hidden" name="id" value="{{$_GET['id']}}">
        <div class="panel panel-default">
            <div class="panel-heading">编辑字段</div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label star">排序</label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" name="orderby" value="{{$field['orderby']}}" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label star">名称</label>
                    <div class="col-sm-8">
                        <input type="title" class="form-control" name="title" value="{{$field['title']}}" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label star">启用</label>
                    <div class="col-sm-8">
                        <label class="radio-inline">
                            <input type="radio" name="status" value="1" {{$field['status']==1?'checked="checked"':''}}> 是
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="status" value="0" {{$field['status']==0?'checked="checked"':''}}> 否
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">保存</button>
    </form>
    <script>
        function post(e) {
            e.preventDefault();
            require(['hdjs'],function(hdjs){
                hdjs.submit();
            })
        }
    </script>
</block>