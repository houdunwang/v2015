<extend file="resource/view/site"/>
<block name="content">
    <form method="post" onsubmit="post(event)">
        <div class="row">
            <div class="col-sm-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        发表栏目
                    </div>
                    <div class="panel-body" style="padding: 0px;">
                        <select class="form-control" onchange="selectCategory(this)"
                                multiple="multiple" size="29"
                                style="border: none;font-family: 'Microsoft Yahei', '微软雅黑', Helvetica">
                            <foreach from="$category" value="$v">
                                <if value="$v['ishomepage']">
                                    <option cid="{{$v['cid']}}" mid="{{$v['mid']}}">
                                        {{$v['catname']}}(封)
                                    </option>
                                    <else/>
                                    <option cid="{{$v['cid']}}" mid="{{$v['mid']}}">
                                        {!! $v['_catname'] !!}
                                    </option>
                                </if>
                            </foreach>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-10">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="active"><a href="javascript:;">文章管理</a></li>
                    <li>
                        <a href="{!! url('content.post',['mid'=>Request::get('mid'),'cid'=>Request::get('cid')]) !!}">发表文章</a>
                    </li>
                </ul>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th width="60">编号</th>
                                <th width="100">排序</th>
                                <th>栏目</th>
                                <th>标题</th>
                                <th>属性</th>
                                <th width="180">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <foreach from="$data" value="$d">
                                <tr>
                                    <td>{{$d['aid']}}</td>
                                    <td>
                                        <input type="text" class="form-control" name="orderby[{{$d['aid']}}]" value="{{$d['orderby']}}">
                                    </td>
                                    <td>
                                        <a href="{!! url('content.post',['mid'=>$d['mid'],'cid'=>$d['cid']])!!}">{!! $d['catname'] !!}</a>
                                    </td>
                                    <td>{{$d['title']}}</td>
                                    <td>
                                        <if value="$d['ishot']">
                                            <span class="label label-danger">头条</span>
                                        </if>
                                        <if value="$d['iscommend']">
                                            <span class="label label-success">推荐</span>
                                        </if>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="...">
                                            <a href="{{$d->url()}}" target="_blank" class="btn btn-default btn-sm">预览</a>
                                            <a href="{!! url('content.post',['aid'=>$d['aid'],'mid'=>$d['mid'],'cid'=>$d['cid']]) !!}" class="btn btn-default btn-sm">编辑</a>
                                            <button onclick="del({{$d['aid']}},{{$d['mid']}})" type="button" class="btn btn-default btn-sm">
                                                删除
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </foreach>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php if($data->toArray()):?>
                    <button type="submit" class="btn btn-default">更新排序</button>
                <?php endif;?>
            </div>
        </div>
    </form>
    {!! $data->links() !!}
</block>
<script>
    function post(event) {
        event.preventDefault();
        require(['hdjs'], function (hdjs) {
            hdjs.submit();
        })
    }

    //删除文章
    function del(aid, mid) {
        require(['hdjs'],function(hdjs){
            hdjs.confirm('确定删除文章吗?', function () {
                $.get('{!! url("content.del") !!}', {aid: aid, mid: mid}, function (res) {
                    if (res.valid) {
                        hdjs.message(res.message, 'refresh', 'success');
                    } else {
                        hdjs.message(res.message, '', 'error');
                    }
                }, 'json');
            })
        })
    }

    //选择发表栏目
    function selectCategory(obj) {
        var opt = $(obj).find(':selected');
        location.href = "{!! url('content.lists&') !!}&mid=" + opt.attr('mid') + "&cid=" + opt.attr('cid');
    }
</script>