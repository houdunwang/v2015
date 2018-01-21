<extend file="resource/view/system"/>
<block name="content">
    <ol class="breadcrumb">
        <li><i class="fa fa-home"></i></li>
        <li><a href="?s=system/manage/menu">系统</a></li>
        <li class="active">已经安装模块</li>
    </ol>
    <ul class="nav nav-tabs">
        <li role="presentation"><a href="{!! u('installed') !!}">已经安装模板</a></li>
        <li role="presentation" class="active"><a href="?s=system/template/prepared">安装模板</a></li>
        <li role="presentation"><a href="?s=system/template/design">设计新模板</a></li>
        <li role="presentation"><a href="{!! u('shop.lists',['type'=>'template']) !!}">模板商城</a>
    </ul>
    <div class="clearfix">
        <h5 class="page-header">卸载 [{{$field['title']}}] 模板</h5>
        <div class="alert alert-danger">
            删除模板将影响已经使用模板的应用
        </div>
        <form id="app" @submit.prevent="submit">
            <button type="submit" class="btn btn-primary">开始卸载模板</button>
        </form>
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
