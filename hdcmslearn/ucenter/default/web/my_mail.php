<extend file='UCENTER_MASTER_FILE'/>
<block name="content">
    <div class="alert alert-info">
        如果修改邮箱，登录将使用新邮箱登录。原有邮箱将废弃，请慎重设置。<br/>
        发送的验证码可能会在垃圾箱中，请注意查看。
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                绑定邮箱
                <if value="v('member.info.email_valid')">
                    <span class="label label-success">邮箱已经绑定</span>
                </if>
            </h4>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" onsubmit="post(event)">
                <div class="form-group">
                    <label class="col-sm-2 control-label">邮箱</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="email" value="{{v('member.info.email')}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">验证</label>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <input type="text" class="form-control" name="code"
                                   placeholder="请输入邮箱中的验证码" required="required">
                            <span class="input-group-btn">
                                <button class="btn btn-success" id="sendValidCode" type="button">
                                    发送验证码
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-10 col-sm-offset-2">
                        <button class="btn btn-primary">保存资料</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        require(['hdjs'], function (hdjs) {
            var option = {
                //按钮
                el: '#sendValidCode',
                //后台链接
                url: '{{site_url("tool.sendValidCode")}}',
                //验证码等待发送时间
                timeout: '60',
                //表单，手机号或邮箱的INPUT表单
                input: '[name="email"]'
            }
            hdjs.validCode(option);
        })

        function post(event) {
            event.preventDefault();
            require(['hdjs'], function (hdjs) {
                hdjs.submit({
                    successUrl: 'refresh'
                });
            })
        }
    </script>
</block>
