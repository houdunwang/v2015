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
    <div class="alert alert-success">
        <i class="fa fa-info-circle"></i>
        新版本的文件已经下载完毕并进行了更新。<br/>
        <i class="fa fa-info-circle"></i>
        旧版本的文件已经移动到了data/upgrade目录中,如果更新出现异常可以进行手动将文件复制回来恢复到旧版本。<br/>
        <i class="fa fa-info-circle"></i>
        如果长时间下载失败，可能是你的网速过慢，这时可以使用手动更新处理，
        查看 <a href="http://www.kancloud.cn/houdunwang/hdcms/294125" target="_blank">手动更新文档</a>
    </div>
    <form class="form-horizontal" v-cloak id="app">
        <div class="panel panel-default" v-show="!data.valid">
            <div class="panel-heading">
                正在下载文件，请不要关闭浏览器窗口...
            </div>
            <div class="panel-body">
                <p style="margin: 0px;">
                    正在更新文件...
                </p>
            </div>
        </div>
        <div class="panel panel-default" v-show="data.valid==1">
            <div class="panel-heading">
                <span v-show="data.valid==0">更新失败</span>
            </div>
            <div class="panel-body">
                <div class="alert alert-warning" v-show="data.valid==0">
                    更新文件失败！本次更新有部分文件无法写入，请检查目录权限。
                </div>
            </div>
        </div>
    </form>
    <script>
        require(['vue','hdjs'],function(Vue,hdjs){
            new Vue({
                el:"#app",
                data:{
                    data:{}
                },
                mounted:function(){
                  this.download();
                },
                methods:{
                    download:function(){
                        var This = this;
                        $.get("{!! u('upgrade',['action'=>'downloadFile']) !!}", {}, function (data) {
                            if (_.isObject(data)) {
                                This.data = data;
                                if (This.data.valid == 1) {
                                    //更新成功时继续更新数据表
                                    setTimeout(function () {
                                        location.href = "{!! u('upgrade',['action'=>'sql']) !!}";
                                    }, 500);
                                } else {
                                    hdjs.message(data.message, '', 'warning');
                                }
                            } else {
                                hdjs.message('下载文件失败，可能是网速太慢', '', 'warning');
                            }
                        }, 'json')
                    }
                }
            })
        })
    </script>
</block>