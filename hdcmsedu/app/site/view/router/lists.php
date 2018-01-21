<extend file="resource/view/site"/>
<block name="content">
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="javascript:;">路由规则 </a></li>
    </ul>
    <form class="form-horizontal" @submit.prevent="submit" id="app" v-cloak>
        <div class="alert alert-success">
            路由规则: 如: article{siteid}_{aid}.html 必须以 "houdunren{siteid}_"开始，以本例来讲 $_GET['aid'] 变量会传递给方法使用。<br/>
            模块方法: 如: action=controller/entry/lists  所要执行的方法，lists为方法名
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">路由规则</h3>
            </div>
            <div class="panel-body">
                <div class="well" v-for="v in data">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="col-xs-12 col-sm-12 col-md-11">
                                <div class="input-group" style="margin-left:-15px;margin-bottom:10px">
                                    <span class="input-group-addon">功能描述</span>
                                    <input class="form-control" v-model="v.title" placeholder="描述路由的使用场景">
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
                        <div class="col-sm-12">
                            <div class="col-xs-12 col-sm-12 col-md-11">
                                <div class="input-group" style="margin-left:-15px;margin-bottom:10px">
                                    <span class="input-group-addon">路由规则</span>
                                    <input class="form-control" v-model="v.router" placeholder="如: article{siteid}_{aid}_{cid}_{mid}.html">
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="col-xs-12 col-sm-12 col-md-11">
                                <div class="input-group" style="margin-left:-15px;margin-bottom:10px">
                                    <span class="input-group-addon">模块方法</span>
                                    <input class="form-control" v-model="v.url" placeholder="如: action=controller/entry/lists">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12 col-xs-12 col-md-12">
                        <div class="well text-center" style="cursor: pointer;color:#999;" @click="add()">
                            <i class="fa fa-plus-circle fa-4x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <textarea name="data" v-html="data" hidden></textarea>
        <button type="submit" class="btn btn-default">保存修改</button>
    </form>
    <script>
        require(['vue', 'hdjs'], function (Vue, hdjs) {
            new Vue({
                el: "#app",
                data: {
                    data:<?php echo $data;?>
                },
                methods: {
                    add: function () {
                        this.data.push({title: '', router: '', url: ''});
                    },
                    del: function (item) {
                        this.data = _.without(this.data, item);
                    },
                    submit: function () {
                        hdjs.submit({successUrl: 'refresh'});
                    }
                }
            })
        })
    </script>
</block>