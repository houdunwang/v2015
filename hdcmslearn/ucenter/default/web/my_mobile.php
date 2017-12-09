<extend file='UCENTER_MASTER_FILE'/>
<block name="content">
    <div class="alert alert-info">
        如果修改手机，登录将使用新手机号登录。原有手机号将废弃，请慎重设置。
    </div>
    <div class="panel panel-default" id="app">
        <div class="panel-heading">
            <h4 class="panel-title">
                绑定手机
                <if value="v('member.info.mobile_valid')">
                    <span class="label label-success">手机号已经绑定</span>
                </if>
            </h4>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" onsubmit="post(event)">
                <div class="form-group">
                    <label class="col-sm-2 control-label">手机号</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="mobile"
                               value="{{v('member.info.mobile')}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">验证码</label>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <input type="text" class="form-control" name="code"
                                   placeholder="请输入发送到手机上的验证码">
                            <span class="input-group-btn">
                                <button class="btn btn-success" type="button" id="sendValidCode">发送验证码</button>
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
                url: '{!! url("my.mobile",["sendCode"=>1]) !!}',
                //验证码等待发送时间
                timeout: '60',
                //表单，手机号或邮箱的INPUT表单
                input: '[name="mobile"]',
                before: function () {
                    if (window.user.mobile_valid == 1 && window.user.mobile == $("[name='mobile']").val()) {
                        hdjs.message('手机号已经验证通过');
                        return false;
                    }
                    return true;
                }
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
