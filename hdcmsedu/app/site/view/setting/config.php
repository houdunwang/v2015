<extend file="resource/view/site"/>
<block name="content">
    <ul class="nav nav-tabs">
        <li role="presentation" class="active">
            <a href="javascript:;">站点全局配置</a>
        </li>
    </ul>
    <form class="form-horizontal" method="post" id="form" v-cloak @submit.prevent="submit">
        <div class="panel panel-default">
            <div class="panel-heading">会员中心</div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">会员必须设置昵称</label>
                    <div class="col-sm-10">
                        <label class="radio-inline">
                            <input type="radio" value="1" v-model="field.must_set_nickname"> 是
                        </label>
                        <label class="radio-inline">
                            <input type="radio" value="0" v-model="field.must_set_nickname"> 否
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">会员必须设置头像</label>
                    <div class="col-sm-10">
                        <label class="radio-inline">
                            <input type="radio" value="1" v-model="field.must_set_icon"> 是
                        </label>
                        <label class="radio-inline">
                            <input type="radio" value="0" v-model="field.must_set_icon"> 否
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">其他设置</div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">模板目录独立</label>
                    <div class="col-sm-10">
                        <label class="radio-inline">
                            <input type="radio" value="1" v-model="field.template_dir_diff"> 是
                        </label>
                        <label class="radio-inline">
                            <input type="radio" value="0" v-model="field.template_dir_diff"> 否
                        </label>
                        <span class="help-block">用于设置移动端与桌面端模板目录是否独立</span>
                    </div>
                </div>
            </div>
        </div>
        <textarea name="config" hidden>@{{field}}</textarea>
        <button class="btn btn-primary">提交</button>
    </form>
    <script>
        require(['vue', 'hdjs'], function (vue, hdjs) {
            new vue({
                el: '#form',
                data: {
                    field:<?php echo json_encode($field)?>
                },
                methods: {
                    submit: function () {
                        hdjs.submit({successUrl: 'refresh'});
                    }
                }
            });
        })
    </script>
</block>


