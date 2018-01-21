<extend file="resource/view/site"/>
<block name="content">
    <ul class="nav nav-tabs">
        <li role="presentation"><a href="{!! url('site/groupLists') !!}">会员组列表</a></li>
        <if value="q('get.id')">
            <li role="presentation"><a href="{!! url('site/groupPost') !!}"><i class="fa fa-plus"></i>
                添加会员组</a></li>
            <li role="presentation" class="active"><a href="#"><i class="fa fa-plus"></i> 编辑会员组</a>
            </li>
            <else/>
            <li role="presentation" class="active"><a href="#"><i class="fa fa-plus"></i> 添加会员组</a>
            </li>
        </if>
    </ul>
    <form class="form-horizontal" onsubmit="post(event)">
        <div class="panel panel-default">
            <div class="panel-heading">
                会员组参数
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label star">组名称</label>
                    <div class="col-sm-8">
                        <input class="form-control" name="title" value="{{$field['title']}}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label star">
                        所需{{v('site.setting.creditnames.credit1.title')}}
                    </label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" name="credit" value="{{$field['credit']}}" required>
                        <span class="help-block">
                        此项设置升级到该会员组所需积分.如果会员的积分达到该会员组所设置的积分,会员等级会自动提升<br/>
                        <strong class="text-danger">默认会员组的积分需设置为 0</strong>
                    </span>
                    </div>
                </div>
            </div>
        </div>
        <button class="btn btn-primary">保存</button>
    </form>
    <script>
        function post(e) {
            e.preventDefault();
            require(['hdjs'], function (hdjs) {
                hdjs.submit();
            })
        }
    </script>
</block>