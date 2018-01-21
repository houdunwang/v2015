<extend file='UCENTER_MASTER_FILE'/>
<block name="content">
    <tag action="ucenter.header" title="会员卡充值"></tag>
    <div class="ticket">
        <div class="panel panel-default">
            <form action="" method="post" role="form">
                <div class="panel-body">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-money"></i></span>
                            <input type="number" name="fee" class="form-control input-lg" required="required"
                                   aria-label="Amount (to the nearest dollar)">
                            <span class="input-group-addon">元</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block btn-lg">确定支付</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</block>
<script>
    require(['hdjs'], function (hdjs) {
        $("form").submit(function () {
            if ($.trim($("[name='fee']").val()) == '') {
                hdjs.message('请输入充值金额', '', 'warning',2, {
                    width: '95%'
                });
                return false;
            }
        })
    });
</script>