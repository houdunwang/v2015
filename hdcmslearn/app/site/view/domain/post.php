<extend file="resource/view/site"/>
<block name="content">
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="javascript:;">域名设置</a></li>
    </ul>
    <div class="alert alert-info">
        如果域名在其他模块或站点使用系统将忽略添加
    </div>
    <form class="form-horizontal" id="app" @submit.prevent="submit()" v-cloak>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">域名设置</h3>
            </div>
            <div class="panel-body">
                <div class="form-group" v-for="v in data">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"></label>
                    <div class="col-sm-10">
                        <div class="col-xs-12 col-sm-12 col-md-11">
                            <div class="input-group" style="margin-left:-15px;margin-bottom:10px">
                                <span class="input-group-addon">域名</span>
                                <input class="form-control" v-model="v.domain" name="domain[]">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-1">
                            <div style="margin-left:-45px;">
                                <label class="checkbox-inline" style="vertical-align:bottom">
                                    <a href="javascript:;" @click="del(v)" class="fa fa-times-circle" title="删除此操作"></a>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-10 col-xs-12 col-md-9 col-md-offset-1">
                        <div class="well well-sm">
                            <a href="javascript:;" @click="add()">
                                添加域名 <i class="fa fa-plus-circle" title="添加菜单"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button class="btn btn-default">保存修改</button>
    </form>
    <script>
        require(['hdjs', 'vue'], function (hdjs, Vue) {
            new Vue({
                el: '#app',
                data: {
                    data:<?php echo json_encode($data);?>,
                },
                methods: {
                    add: function () {
                        this.data.push({domain: ""});
                    },
                    del: function (item) {
                        this.data = _.without(this.data, item);
                    },
                    submit: function (event) {
                        hdjs.submit({successUrl: 'refresh'});
                    }
                }
            })
        })
    </script>
</block>