<extend file="resource/view/system"/>
<block name="content">
    <ol class="breadcrumb">
        <li><i class="fa fa-home"></i></li>
        <li><a href="?s=system/manage/menu">系统</a></li>
        <li class="active">一键更新</li>
    </ol>
    <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="#">系统更新</a></li>
    </ul>
    <form class="form-horizontal" id="app" v-cloak>
        <div class="panel panel-default">
            <div class="panel-heading">
                温馨提示
            </div>
            <div class="panel-body">
                <p style="margin: 0px;">
                    <span ng-show="!data.message">正在更新数据表...</span>
                    <span ng-show="data.message">@{{data.message}}</span>
                </p>
            </div>
        </div>
    </form>
    <script>
        require(['vue', 'hdjs'], function (Vue, hdjs) {
            new Vue({
                el:"#app",
                data:{
                    data:{}
                },
                mounted:function(){
                    this.upgrade();
                },
                methods:{
                    upgrade:function(){
                        var This = this;
                        //执行更新
                        $.post("{!! __URL__ !!}", function (json) {
                            This.data = json;
                            if (json.valid == 1) {
                                location.href = "{!! u('upgrade',['action'=>'finish']) !!}";
                            }
                        }, 'json');
                    }
                }
            })
        })
    </script>
</block>