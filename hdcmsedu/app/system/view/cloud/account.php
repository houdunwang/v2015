<extend file="resource/view/system"/>
<block name="content">
    <ol class="breadcrumb">
        <li><i class="fa fa-home"></i></li>
        <li><a href="?s=system/manage/menu">系统</a></li>
        <li class="active">云帐号</li>
    </ol>
    <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="#">云帐号</a></li>
    </ul>
    <form class="form-horizontal" v-cloak id="app" @submit.prevent="submit">
        <!--云帐号-->
        <div class="panel panel-default">
            <div class="panel-heading">
                绑定信息
                <span class="label label-danger" v-if="field.status==0">与云平台绑定失败</span>
                <span class="label label-success" v-if="field.status==1">与云平台绑定成功</span>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">云帐号</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" required v-model="field.username">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">云密码</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" required v-model="field.password">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">网站名称</label>
                    <div class="col-sm-8">
                        <input type="text" v-model="field.webname" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">网站URL</label>
                    <div class="col-sm-8">
                        <input type="text" value="{{__ROOT__}}" disabled class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">应用密钥(secret)</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" class="form-control" readonly v-model="field.secret" required>
                            <span class="input-group-addon" style="cursor: pointer" @click="createAppSecret()">生成新的</span>
                        </div>
                    </div>
                </div>
                <textarea name="data" hidden="hidden" v-html="field"></textarea>
                <div class="btn-group col-sm-offset-2">
                    <button class="btn btn-success">重新与云平台绑定</button>
                    <a href="http://hdcms.hdcms.com/?m=ucenter&action=controller/entry/login" target="_blank" class="btn btn-default">注册云帐号</a>
                </div>

            </div>
        </div>
    </form>
    <script>
        require(['vue', 'hdjs'], function (Vue, hdjs) {
            new Vue({
                el: "#app",
                data: {
                    field:<?php echo json_encode($field);?>
                },
                methods: {
                    changAction: function (action) {
                        this.action = action;
                    },
                    //生成createAppSecret
                    createAppSecret: function () {
                        this.field.secret = hdjs.md5(Math.random());
                    },
                    submit: function () {
                        hdjs.submit();
                    }
                }
            })
        })
    </script>
</block>