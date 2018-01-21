<extend file="resource/view/system"/>
<block name="content">
    <ol class="breadcrumb">
        <li><i class="fa fa-home"></i></li>
        <li><a href="?s=system/manage/menu">系统</a></li>
        <li class="active">应用商店</li>
    </ol>
    <ul class="nav nav-tabs">
        <li role="presentation"><a href="{!! u('module.installed') !!}">已经安装模块</a></li>
        <li role="presentation"><a href="?s=system/module/prepared">安装模块</a></li>
        <li role="presentation"><a href="?s=system/module/design">设计新模块</a></li>
        <li role="presentation"><a href="{!! u('shop.lists',['type'=>'module']) !!}">模块商城</a></li>
        <li role="presentation" class="active"><a href="{!! u('shop.upgrade') !!}">模块更新</a></li>
        <li role="presentation"><a href="{!! u('shop.buy',['type'=>'module']) !!}">已购模块</a></li>
    </ul>
    <div class="clearfix" v-cloak id="app">
        <div class="row" v-show="field.message==''">
            <div class="col-sm-12 col-md-12">
                <div class="alert alert-info">
                    <span>正在获取模块更新列表</span>
                </div>
            </div>
        </div>
        <div class="row" v-show="field.message">
            <div class="col-sm-12 col-md-12">
                <div class="alert alert-info">
                    <span v-html="field.message"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4 col-md-2" v-for="(v,k) in field.apps" v-show="field.apps.length>0">
                <div class="thumbnail">
                    <img :src="v.preview" style="height: 200px; width: 100%; display: block;">
                    <div class="caption">
                        <h3 v-html="v.title"></h3>
                        <p v-html="v.resume"></p>
                        <p>
                            <a v-if="v.message=='开始更新'" @click="upgrade(v,k)" class="btn btn-default btn-block btn-sm" v-html="v.message"></a>
                            <a v-if="v.message=='正在更新...'" class="btn btn-info btn-block btn-sm" v-html="v.message"></a>
                            <a v-if="v.message=='模块更新完毕'" class="btn btn-success btn-block btn-sm" v-html="v.message"></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        require(['vue', 'hdjs'], function (Vue, hdjs) {
            var vm = new Vue({
                el: "#app",
                data: {
                    field: {'apps': [], 'page': '','message':''}
                },
                mounted: function () {
                    var This = this;
                    //起始页
                    $.post("{!! u('shop.getModuleUpgradeLists') !!}", function (json) {
                        for (var i = 0; i < json.apps.length; i++) {
                            json.apps[i].message = '开始更新';
                        }
                        This.field = json;
                    }, 'json');
                },
                methods: {
                    //更新模块
                    upgrade: function (v,k) {
                        v.message = '正在更新...';
                        $.post("{!! u('upgrade') !!}&name=" + v.name, function (json) {
                            vm.$set(vm.field.apps[k],'message',json.message);
                        }, 'json');
                    }
                }
            })
        })
    </script>
</block>
