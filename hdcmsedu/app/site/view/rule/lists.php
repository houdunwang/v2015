<extend file="resource/view/site"/>
<block name="content">
    <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="#">管理{{v('module.title')}}</a></li>
        <li role="presentation">
            <a href="{{site_url('site.rule.post')}}">
                <i class="fa fa-plus"></i> 添加{{v('module.title')}}
            </a>
        </li>
    </ul>
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">筛选</h3>
        </div>
        <div class="panel-body">
            <form action="" method="post" role="form" class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-2 control-label">状态</label>
                    <div class="col-sm-10">
                        <div class="btn-group" role="group" aria-label="...">
                            <a class="btn {{q('get.status')?'btn-default':'btn-primary'}}"
                               href="{{site_url('site.rule.lists')}}">所有</a>
                            <a class="btn {{q('get.status')=='close'?'btn-primary':'btn-default'}}"
                               href="{{site_url('site.rule.lists')}}&status=close">禁用</a>
                            <a class="btn {{q('get.status')=='open'?'btn-primary':'btn-default'}}"
                               href="{{site_url('site.rule.lists')}}&status=open">启用</a>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">关键词</label>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <input type="text" name="content" class="form-control" placeholder="输入搜索关键词...">
                            <span class="input-group-btn">
                                  <button class="btn btn-default" type="submit"><i class="fa fa-search"></i> 搜索</button>
                              </span>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <form action="" method="post" class="form-horizontal" role="form">
        <foreach from="$data" value="$r">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" value="">
                            {{$r['name']}}
                        </label>
                    </div>
                </div>
                <div class="panel-body">
                    <foreach from="$r['keywords']" value="$k">
                        <span class="label label-default">{{$k}}</span>
                    </foreach>
                </div>
                <div class="panel-footer clearfix">
                    <div class="btn-group pull-right" role="group" aria-label="...">
                        <a href="{{site_url('site.rule.post')}}&rid={{$r['rid']}}" class="btn btn-default"><i
                                    class="fa fa-edit"></i> 编辑</a>
                        <button type="button" onclick="removeRule('{{$r['rid']}}','{{$r['name']}}',this)"
                                class="btn btn-default"><i
                                    class="fa fa-times"></i> 删除
                        </button>
                    </div>
                </div>
            </div>
        </foreach>
    </form>
</block>
<script>
    /**
     * 删除规则
     * @param rid
     * @param title
     * @param obj
     */
    function removeRule(rid, title, obj) {
        require(['hdjs'], function (hdjs) {
            hdjs.confirm('确定删除规则 [' + title + '] 吗?', function () {
                $.get("{{site_url('site.rule.remove')}}&rid=" + rid, function (json) {
                    hdjs.message(json.message, '', 'info');
                    if (json.valid == 1) {
                        $(obj).parents('.panel').eq(0).remove();
                    }
                }, 'json')
            });
        })
    }
</script>