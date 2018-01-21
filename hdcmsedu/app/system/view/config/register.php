<extend file="resource/view/system"/>
<block name="content">
    <ol class="breadcrumb">
        <li><i class="fa fa-home"></i></li>
        <li><a href="?s=system/manage/menu">系统</a></li>
        <li class="active">注册选项</li>
    </ol>
    <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="javascript:;">注册选项</a></li>
    </ul>
    <h5 class="page-header">注册设置</h5>
    <form class="form-horizontal" id="vue" v-cloak @submit.prevent="submit">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">是否开启用户注册</label>
                    <div class="col-sm-10">
                        <label class="radio-inline">
                            <input type="radio" value="1" v-model="field.is_open"> 是
                        </label>
                        <label class="radio-inline">
                            <input type="radio" value="0" v-model="field.is_open"> 否
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">是否审核新用户</label>

                    <div class="col-sm-10">
                        <label class="radio-inline">
                            <input type="radio" value="1" v-model="field.audit"> 是
                        </label>
                        <label class="radio-inline">
                            <input type="radio" value="0" v-model="field.audit"> 否
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">开启注册验证码</label>

                    <div class="col-sm-10">
                        <label class="radio-inline">
                            <input type="radio" value="1" v-model="field.enable_register_code"> 是
                        </label>
                        <label class="radio-inline">
                            <input type="radio" value="0" v-model="field.enable_register_code"> 否
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">开启登录验证码</label>
                    <div class="col-sm-10">
                        <label class="radio-inline">
                            <input type="radio" value="1" v-model="field.enable_login_code"> 是
                        </label>
                        <label class="radio-inline">
                            <input type="radio" value="0" v-model="field.enable_login_code"> 否
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">默认所属用户组</label>

                    <div class="col-sm-6">
                        <select class="form-control" v-model="field.groupid">
                            <option :value="v.id" v-for="v in group">@{{v.name}}</option>
                        </select>
                        <span class="help-block">当开启用户注册后，新注册用户将会分配到该用户组里，并直接拥有该组的模块操作权限。</span>
                    </div>
                </div>
            </div>
        </div>
        <textarea name="register" hidden>@{{field}}</textarea>
        <button class="btn btn-primary">提交</button>
    </form>
</block>

<script>
    require(['hdjs', 'vue'], function (hdjs, Vue) {
        new Vue({
            el: '#vue',
            data: {
                field:<?php echo json_encode(v('config.register'));?>,
                group:<?php echo json_encode($group);?>
            },
            methods: {
                submit: function () {
                    hdjs.submit({successUrl: 'refresh'});
                }
            }
        })
    })
</script>
