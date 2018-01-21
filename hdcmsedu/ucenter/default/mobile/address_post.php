<extend file='UCENTER_MASTER_FILE'/>
<block name="title">地址管理 - HDCMS开源免费三网系统</block>
<block name="content">
    <tag action="ucenter.header" title="{!! isset($_GET['id'])?'编辑':'新增' !!}收货地址" url="{!! url('address.lists') !!}"></tag>
    <div class="panel panel-default">
        <div class="panel-body address">
            <form method="post" class="form-horizontal" onsubmit="post(event)">
                <div class="form-group">
                    <label class="col-sm-2 control-label">姓名</label>
                    <div class="col-sm-10">
                        <input name="username" value="{{$field['username']}}" class="form-control input-sm" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">电话</label>
                    <div class="col-sm-10">
                        <input name="mobile" value="{{$field['mobile']}}" class="form-control input-sm" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">邮编</label>
                    <div class="col-sm-10">
                        <input type="number" name="zipcode" value="{{$field['zipcode']}}" class="form-control input-sm">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">收货地址</label>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <select name="province" class="form-control" required></select>
                            <br>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <select name="city" class="form-control" required></select>
                            <br>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <select name="district" class="form-control" required></select>
                        </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">详细地址</label>
                    <div class="col-sm-10">
                        <input name="address" value="{{$field['address']}}" class="form-control input-sm" required>
                    </div>
                </div>
                <button class="btn btn-success btn-block btn-lg"> 保存地址</button>
            </form>
        </div>
    </div>
    <parent name="copyright"/>
    <script>
        require(['hdjs'], function (hdjs) {
            hdjs.city.render({
                //省份标签
                province: document.querySelector('[name="province"]'),
                //城市标签
                city: document.querySelector('[name="city"]'),
                //地区标签
                area: document.querySelector('[name="district"]'),
            }, {
                province: "{{$field['province']}}",
                city: "{{$field['city']}}",
                area: "{{$field['district']}}",
            });
        });

        function post(event) {
            event.preventDefault();
            require(['hdjs'], function (hdjs) {
                hdjs.submit();
            })
        }
    </script>
</block>