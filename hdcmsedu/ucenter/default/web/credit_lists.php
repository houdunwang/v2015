<extend file='UCENTER_MASTER_FILE'/>
<block name="content">
    <ul class="nav nav-tabs" role="tablist">
        <foreach from="$credits" value="$c">
            <li class="{{$c['name']==$_GET['type']?'active':''}}">
                <a href="/?m=ucenter&action=controller/credit/lists&type={{$c['name']}}">{{$c['title']}}</a>
            </li>
        </foreach>
    </ul>

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
    <div class="alert alert-success">
        支出: {{$expend?:0}} {{$credits[$_GET['type']]['unit']}} &nbsp;&nbsp;&nbsp;
        收入: {{$income?:0}} {{$credits[$_GET['type']]['unit']}}
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
                        <th>描述</th>
                        <th>创建时间</th>
                        <th>金额</th>
                    </tr>
                    </thead>
                    <tbody>
                    <foreach from="$data" value="$d">
                        <tr>
                            <td>{{$d['id']}}</td>
                            <td>{{$d['remark']}}</td>
                            <td>{{date('Y-m-d h:i',$d['createtime'])}}</td>
                            <td>{{$d['num']}}</td>
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