<extend file="resource/view/site"/>
<block name="content">
    <ul class="nav nav-tabs">
        <li class="active"><a href="{{site_url('setting.credit')}}">积分列表</a></li>
        <li><a href="{{site_url('setting.tactics')}}">积分策略</a></li>
    </ul>
    <div class="alert alert-success">
        注意: credit2余额用于货币支付使用如微信支付，红包，支付宝等使用
    </div>
    <form method="post" onsubmit="post(event)">
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th width="80">启用否？</th>
                        <th>积分</th>
                        <th>积分名称</th>
                        <th>单位</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <input type="checkbox" name="creditnames[credit1][status]" value="1" checked="checked" disabled>
                        </td>
                        <td>credit1</td>
                        <td>
                            <input name="creditnames[credit1][title]" value="{{$creditnames['credit1']['title']}}" class="form-control" >
                        </td>
                        <td>
                            <input name="creditnames[credit1][unit]" value="个" class="form-control" >
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" name="creditnames[credit2][status]" value="1" checked="checked" disabled>
                        </td>
                        <td>credit2</td>
                        <td>
                            <input name="creditnames[credit2][title]" value="{{$creditnames['credit2']['title']}}" class="form-control" >
                        </td>
                        <td>
                            <input name="creditnames[credit2][unit]" value="元" class="form-control" >
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" name="creditnames[credit3][status]" value="1" {{$creditnames['credit3']['status']?'checked="checked"':''}}>
                        </td>
                        <td>credit3</td>
                        <td>
                            <input name="creditnames[credit3][title]" value="{{$creditnames['credit3']['title']}}" class="form-control">
                        </td>
                        <td>
                            <input name="creditnames[credit3][unit]" value="{{$creditnames['credit3']['unit']}}" class="form-control">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" name="creditnames[credit4][status]" value="1" {{$creditnames['credit4']['status']?'checked="checked"':''}}>
                        </td>
                        <td>credit4</td>
                        <td>
                            <input name="creditnames[credit4][title]" value="{{$creditnames['credit4']['title']}}" class="form-control">
                        </td>
                        <td>
                            <input name="creditnames[credit4][unit]" value="{{$creditnames['credit4']['unit']}}" class="form-control" >
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" name="creditnames[credit5][status]" value="1" {{$creditnames['credit5']['status']?'checked="checked"':''}}>
                        </td>
                        <td>credit5</td>
                        <td>
                            <input name="creditnames[credit5][title]" value="{{$creditnames['credit5']['title']}}" class="form-control">
                        </td>
                        <td>
                            <input name="creditnames[credit5][unit]" value="{{$creditnames['credit5']['unit']}}" class="form-control" >
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <button class="col-lg-1 btn btn-default">保存</button>
    </form>
</block>
<script>
    function post(event) {
        event.preventDefault();
        require(['hdjs'], function (hdjs) {
            hdjs.submit({successUrl: 'refresh'});
        })
    }
</script>