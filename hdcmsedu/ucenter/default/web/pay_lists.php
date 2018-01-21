<extend file='UCENTER_MASTER_FILE'/>
<block name="content">
    <div class="panel panel-default form-horizontal">
        <div class="panel-heading">
            筛选
        </div>
        <div class="panel-body ">
            <div class="form-group">
                <label class="col-xs-3 control-label">日期范围</label>
                <div class="col-xs-9">
                    <div class="input-group date-range">
                        <input type="text" id="dateinput" class="form-control" value="{{q('get.timerange')}}">
                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                    </div>
                    <script>
                        require(['hdjs'], function (hdjs) {
                            hdjs.daterangepicker({
                                element: '.date-range',
                                options: {},//选项参考插件官网
                                callback: function (start, end, label) {
                                    var str = start.format('YYYY-MM-DD') + '至' + end.format('YYYY-MM-DD');
                                    $('#dateinput').val(str);
                                    location.href = hdjs.get.set('timerange', str);
                                }
                            });
                        });

                    </script>
                </div>
            </div>
        </div>
    </div>
    <?php if ( ! $data->toArray()) { ?>
        <div class="alert alert-info">
            没有记录
        </div>
    <?php } else { ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                支付列表
            </div>
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>编号</th>
                        <th>定单号</th>
                        <th>支付方式</th>
                        <th>金额</th>
                        <th>商品</th>
                        <th>状态</th>
                        <th width="150">支付时间</th>
                        <th width="60">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <foreach from="$data" value="$d">
                        <tr>
                            <td>{{$d['pid']}}</td>
                            <td>{{$d['tid']}}</td>
                            <td>{{$d->payTitle()}}</td>
                            <td>{{$d['fee']}}</td>
                            <td>{{$d['goods_name']}}</td>
                            <td>
                                <if value="$d['status']==1">
                                    <span class="label label-success">已支付</span>
                                    <else/>
                                    <span class="label label-default">未支付</span>
                                </if>
                            </td>
                            <td>{{$d['updated_at']}}</td>
                            <td>
                                <div class="btn-group">
                                    <if value="$d['status']==1">
                                        <button type="button" disabled class="btn btn-default btn-sm">支付</button>
                                        <else/>
                                        <a href="{!! url('account.pay', ['tid' => $d['tid']], 'ucenter') !!}" class="btn btn-default btn-sm">支付</a>
                                    </if>
                                </div>
                            </td>
                        </tr>
                    </foreach>
                    </tbody>
                </table>
            </div>
        </div>
    <?php } ?>
    <ul class="pagination ">
        {!! $data->links() !!}
    </ul>
</block>
<line action="uc.quick_menu"/>