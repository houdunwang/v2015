<extend file="resource/view/system"/>
<block name="content">
    <ol class="breadcrumb">
        <li><i class="fa fa-home"></i></li>
        <li><a href="?s=system/manage/menu">系统</a></li>
        <li class="active">应用商店</li>
    </ol>
    <ul class="nav nav-tabs">
        <if value="$_GET['type']=='module'">
            <li role="presentation"><a href="{!! u('module.installed') !!}">已经安装模块</a></li>
            <li role="presentation"><a href="{!! u('module.prepared') !!}">安装模块</a></li>
            <li role="presentation"><a href="{!! u('module.design') !!}">设计新模块</a></li>
            <li role="presentation" class="active"><a href="javascript:;">模块商城</a></li>
            <li role="presentation"><a href="{!! u('shop.upgradeLists') !!}">模块更新</a></li>
            <li role="presentation"><a href="{!! u('shop.buy',['type'=>'module']) !!}">已购模块</a></li>
            <else/>
            <li role="presentation"><a href="{!! u('template.installed') !!}">已经安装模板</a></li>
            <li role="presentation"><a href="{!! u('template.prepared') !!}">安装模板</a></li>
            <li role="presentation"><a href="{!! u('template.design') !!}">设计新模板</a></li>
            <li role="presentation" class="active"><a href="javascript:;">模板商城</a></li>
            <li role="presentation"><a href="{!! u('shop.buy',['type'=>'template']) !!}">已购模板</a></li>
        </if>
    </ul>
    <div class="clearfix" v-cloak id="app">
        <div class="row" v-if="field.valid==0">
            <div class="col-sm-12 col-md-12">
                <div class="alert alert-danger" v-html="field.message"></div>
            </div>
        </div>
        <div class="row" v-show="field.message==''">
            <div class="col-sm-12 col-md-12">
                <div class="alert alert-info">
                    正在获取应用列表
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
        <div class="row" v-show="field.valid==1">
            <div class="col-sm-4 col-md-2" v-for="v in field.apps">
                <div class="thumbnail">
                    <img :src="v.preview" style="height: 150px; width: 100%; display: block;">
                    <div class="caption">
                        <h4 v-html="v.title" style="font-size: 16px;"></h4>
                        <small>
                            价格: <span v-show="v.price>0" v-html="v.price+'元'"></span>
                            <span v-show="v.price<=0" class="label label-info">免费</span>
                            <span v-show="v.audit==0" class="label label-danger">测试版</span>
                        </small>
                        <p class="resume" v-html="v.resume"></p>
                        <p>
                            <a v-if="!v.is_install" @click="install(v)" class="btn btn-primary btn-sm btn-block" role="button">开始安装</a>
                        </p>
                        <p><span v-if="v.is_install" class="disabled btn btn-default btn-sm btn-block">已经安装</span></p>
                    </div>
                </div>
            </div>
        </div>
        <div v-html="field.page" class="pagination"></div>
    </div>
    <style>
        .thumbnail img {
            border: solid 1px #ddd;
            height: 200px;
            width: 100%;
            display: block;
        }

        .thumbnail .resume {
            overflow: hidden;
            text-overflow: ellipsis;
            height: 30px;
            font-size: 12px;
            margin-top: 6px;
        }
    </style>
    <script>
        require(['vue', 'hdjs'], function (Vue, hdjs) {
            var vm = new Vue({
                el: '#app',
                data: {
                    field: {'apps': [], 'page': '', 'message': ''}
                },
                mounted: function () {
                    var This = this;
                    this.get(1);
                    $('.pagination').delegate('li a', 'click', function () {
                        This.get($(this).text());
                        return false;
                    });
                },
                methods: {
                    get: function (page) {
                        var This = this;
                        $.get("{!! u('shop.getAppList',['type'=>$_GET['type']]) !!}&page=" + page, function (json) {
                            This.field = json;
                        }, 'json');
                    },
                    //安装模块
                    install: function (module) {
                        $.post("{!! u('install',['type'=>$_GET['type']]) !!}&module=" + module.name, function (json) {
                            if (json.valid == 0) {
                                hdjs.message(json.message, '', 'warning', 5);
                            } else {
                                hdjs.message(json.message, json.url, 'success', 3);
                            }
                        }, 'json');
                    }
                }
            })
        })
    </script>
</block>