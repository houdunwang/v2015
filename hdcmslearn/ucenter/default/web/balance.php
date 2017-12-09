<extend file='UCENTER_MASTER_FILE'/>
<block name="content">
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#tab1" role="tab" data-toggle="tab">会员余额充值</a></li>
    </ul>
    <form action="" method="post" role="form">
        <div class="panel panel-default">
            <div class="panel-heading">
                充值金额
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-money"></i></span>
                        <input type="number" name="fee" class="form-control input-lg" required="required"
                               aria-label="Amount (to the nearest dollar)">
                        <span class="input-group-addon">元</span>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <button type="submit" class="btn btn-primary btn-block btn-lg">确定支付</button>
            </div>
        </div>
    </form>
    <script>
        require(['hdjs'], function (hdjs) {
            $("form").submit(function () {
                if ($.trim($("[name='fee']").val()) == '') {
                    hdjs.message('请输入充值金额', '', 'warning', 2, {
                        width: '95%'
                    });
                    return false;
                }
            })
        });
    </script>
</block>