<extend file='UCENTER_MASTER_FILE'/>
<block name="content">
    <tag action="ucenter.header" title="积分列表"></tag>
    <div class="panel panel-default clearfix form-horizontal">
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
            <div class="clearfix row">
                <div class="col-xs-6">支出: {{$expend?:0}}</div>
                <div class="col-xs-6"> 收入: {{$income?:0}}</div>
            </div>
        </div>
    </div>
    <?php if(!$data->toArray()){?>
    <div class="alert alert-info">
        没有记录
    </div>
    <?php }else{?>
    <div class="table-responsive">
        <table class="table table-condensed bg-success">
            <foreach from="$data" value="$d">
                <tr>
                    <td>
                        <if value="v('user.info.icon')">
                            <img src="{{v('user.info.icon')}}" style="width:35px;height: 35px;">
                        </if>
                        <small class="text-muted">{{v('user.info.realname')}}</small>
                    </td>
                    <td>
                        <span>{{$d['remark']}}</span><br/>
                        <small class="text-muted">{{date('Y-m-d h:i',$d['createtime'])}}</small>
                    </td>
                    <td>
                        {{$d['num']}}<br/>
                        <small class="text-muted">交易成功</small>
                    </td>
                </tr>
            </foreach>
        </table>
    </div>
    <?php }?>
    <div class="col-xs-offset-1">
        <ul class="pagination ">
            {!!$data->links()!!}
        </ul>
    </div>
</block>
<line action="uc.quick_menu"/>