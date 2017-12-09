<form action="" method="post" id="changeCreditForm">
    <table class="table table-hover table-bordered">
        <tbody>
        <tr>
            <td>会员uid</td>
            <td>
                <input type="text" class="form-control" readonly="readonly" name="uid" value="{{$uid}}">
            </td>
        </tr>
        <tr>
            <td>修改{{v( "site.setting.creditnames.$type.title" )}}(增减)</td>
            <td>
                <input type="number" class="form-control" name="num" value="0">
                输入500,则标识增加500;输入-500则表示减少500
            </td>
        </tr>
        <tr>
            <td>备注</td>
            <td>
                <textarea name="remark" class="form-control" rows="3"></textarea>
            </td>
        </tr>
        </tbody>
    </table>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="submit" class="btn btn-primary">提交</button>
    </div>
</form>
<script>
    require(['hdjs'],function(hdjs){
        $("#changeCreditForm").submit(function () {
            var data = $(this).serialize();
            var loading = hdjs.loading();
            $.post("{!! __URL__ !!}", data, function (response) {
                if (response.valid) {
                    hdjs.message('数据更新成功, 页面将重新加载', 'refresh', 'success', 1);
                } else {
                    loading.modal('hide');
                    hdjs.message(response.message, '', 'error');
                }
            }, 'json');
            return false;
        })
    })
</script>