<extend file="resource/view/site"/>
<block name="content">
    <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="#">管理会员组</a></li>
        <li role="presentation"><a href="{!! url('site/groupPost') !!}"><i class="fa fa-plus"></i> 添加会员组</a></li>
    </ul>
    <div class="alert alert-info">
        <strong class="text-danger">
            <i class="fa fa-info-circle"></i> 管理员不能直接修改会员所在的会员组.
            如果需要修改会员组,请通过设置积分或者贡献的值来影响总积分,系统会根据影响后的总积分自动算出对应的会员组<br/>
        </strong>
        <i class="fa fa-info-circle"></i> 默认会员组的积分需设置为 0<br/>
        <i class="fa fa-info-circle"></i> 系统会根据会员的总积分多少自动对会员的分组进行调整<br/>
    </div>
    <form onsubmit="post(event)">
        <div class="panel panel-default">
            <div class="panel-heading">
                会员组变更设置
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">会员组变更设置</label>
                    <div class="col-sm-10">
                        <label class="radio-inline">
                            <input type="radio" name="grouplevel" value="1" {{$grouplevel==1?'checked="checked"':''}}>
                            不自动变更
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="grouplevel" value="2" {{$grouplevel==2?'checked="checked"':''}}>
                            根据总积分多少自动升降
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="grouplevel" value="3" {{$grouplevel==3?'checked="checked"':''}}>
                            根据总积分多少只升不降
                        </label>
                        <span class="help-block">不自动变更：
                            <strong class="text-danger">会员组的变更只能通过管理员来变更</strong>
                        </span>
                        <span class="help-block">根据积分多少自动升降：
                            <strong class="text-danger">系统根据当前会员的总积分，按照每个会员组所需总积分的设置进行变更。可自动升降会员组</strong>
                        </span>
                        <span class="help-block">根据积分多少只升不降：
                            <strong class="text-danger">
                                系统根据当前会员的总积分，如果会员的总积分达到更高一级的会员组，则变更会员组，如果积分少于当前所在会员组所需总积分，保持当前会员组不变，不会降级。
                            </strong>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>编号</th>
                        <th width="80">排序</th>
                        <th>会员组名称</th>
                        <th></th>
                        <th>所需总积分(积分+贡献)</th>
                        <th>会员数</th>
                        <th class="text-right">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <foreach from="$groups" value="$g">
                        <tr>
                            <td>{{$g['id']}}</td>
                            <td>
                                <input class="form-control" name="rank[]" required value="{{$g['rank']}}">
                            </td>
                            <td>
                                <input type="hidden" class="form-control" name="id[]" required value="{{$g['id']}}">
                                <input class="form-control" name="title[]" required value="{{$g['title']}}">
                            </td>
                            <td>
                                <if value="$g['isdefault']==1">
                                    <span class="label label-info">默认组</span>
                                </if>
                            </td>
                            <td>
                                <input class="form-control" name="credit[]" value="{{$g['credit']}}">
                            </td>
                            <td>{{$g['uid']?$g['user_count']:0}}人</td>
                            <td class="text-right">
                                <div class="btn-group">
                                    <a href="{!! url('site/GroupPost',['id'=>$g['id']]) !!}" class="btn btn-default">编辑</a>
                                    <if value="$g['is_system']==0">
                                        <a href="javascript:;" onclick="del({{$g['id']}})" class="btn btn-default">
                                            删除
                                        </a>
                                    </if>
                                    <a href="javascript:;" onclick="setDefaut({{$g['id']}})" class="btn btn-default">
                                        设为默认组
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </foreach>
                    </tbody>
                </table>
            </div>
        </div>
        <button class="btn btn-primary">保存设置</button>
    </form>
</block>
<script>
    //保存设置
    function post(e) {
        e.preventDefault();
        require(['hdjs'], function (hdjs) {
            hdjs.submit({successUrl: 'refresh'});
        })
    }
    /**
     * 设置会员默认组
     * @param id
     */
    function setDefaut(id) {
        require(['hdjs'], function (hdjs) {
            $.get("{!! url('site.setDefaultGroup') !!}", {id: id}, function (res) {
                if (res.valid) {
                    hdjs.message(res.message, 'refresh', 'success');
                } else {
                    hdjs.message(res.message, '', 'error');
                }
            }, 'json');
        })
    }

    /**
     * 删除会员组
     * @param id
     */
    function del(id) {
        require(['hdjs'], function (hdjs) {
            hdjs.confirm('确定删除会员组吗?', function () {
                $.get("{!! url('site.delGroup') !!}", {id: id}, function (res) {
                    if (res.valid) {
                        hdjs.message(res.message, 'refresh', 'success');
                    } else {
                        hdjs.message(res.message, '', 'error');
                    }
                }, 'json');
            });
        })
    }
</script>