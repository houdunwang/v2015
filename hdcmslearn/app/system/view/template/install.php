<extend file="resource/view/system"/>
<block name="content">
    <ol class="breadcrumb">
        <li><i class="fa fa-home"></i></li>
        <li><a href="?s=system/manage/menu">系统</a></li>
        <li class="active">已经安装模板</li>
    </ol>
    <ul class="nav nav-tabs">
        <li role="presentation"><a href="{!! u('installed') !!}">已经安装模板</a></li>
        <li role="presentation" class="active"><a href="?s=system/template/prepared">安装模板</a></li>
        <li role="presentation"><a href="?s=system/template/design">设计新模板</a></li>
        <li role="presentation"><a href="{!! u('shop.lists',['type'=>'template']) !!}">模板商城</a>
    </ul>
    <div class="clearfix">
        <h5 class="page-header">安装 {{$config['name']}}</h5>
        <div class="alert alert-info" role="alert">您正在安装 [{{$config['title']}}] 模板. 请选择哪些公众号服务套餐组可使用 [{{$config['title']}}] 模板 .</div>
        <h5 class="page-header">可用的公众号服务套餐组
            <small>这里来定义哪些公众号服务套餐组可使用 测试模板 功能</small>
        </h5>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">公众号服务套餐组</label>
            <form id="app" @submit.prevent="submit">
                <div class="col-sm-10">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" disabled>
                            基础服务 <span class="label label-success">系统</span>
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" disabled="disabled" checked>所有服务 <span class="label label-success">系统</span>
                        </label>
                    </div>
                    <foreach from="$package" value="$p">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="package[]" value="{{$p['name']}}">{{$p['name']}}
                            </label>
                        </div>
                    </foreach>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">确定继续安装 [{{$config['title']}}] 模板</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        require(['vue', 'hdjs'], function (Vue, hdjs) {
            new Vue({
                el: "#app",
                methods: {
                    submit: function () {
                        hdjs.submit({successUrl: "{!! u('installed') !!}"});
                    }
                }
            })
        })
    </script>
</block>
