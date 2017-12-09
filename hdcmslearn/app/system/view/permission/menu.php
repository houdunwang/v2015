<extend file="resource/view/system"/>
<block name="content">
    <ol class="breadcrumb">
        <li><i class="fa fa-home"></i></li>
        <li><a href="?s=system/manage/menu">系统</a></li>
        <li>
            <a href="?s=system/permission/users&siteid={{$_GET['siteid']}}">帐号操作人员列表</a>
        </li>
        <li class="active">权限设置</li>
    </ol>
    <h5 class="page-header">设置 <strong>{{$user['username']}}</strong> 操作权限</h5>
    <div class="alert alert-info" role="alert">
        <span class="fa fa-info-circle"></span>
        默认未勾选任何菜单时，用户拥有全部权限。
    </div>
    <form v-cloak @submit.prevent="submit" id="app">
        <input type="hidden" name="uid" value="{{$_GET['fromuid']}}">
        <div class="panel panel-default" v-for="(v,k) in menusAccess" v-show="v.mark!='package'">
            <div class="panel-heading">
                <label><input type="checkbox" @click="selectAll($event)"> @{{v.title}}</label>
            </div>
            <div class="panel-body">
                <div v-for="m in v._data">
                    <p class="col-sm-2 col-md-2 col-lg-2" v-for="d in m._data">
                        <label>
                            <input type="checkbox" :name="'system[]'" :value="d.permission" :checked="d._status"> @{{d.title}}
                        </label>
                    </p>
                </div>
            </div>
        </div>
        <!--扩展模块权限-->
        <div class="panel panel-default extModule" v-for="v in moduleAccess">
            <div class="panel-heading">
                <label><input type="checkbox" @click="selectAll($event)"> @{{v.module.title}}</label>
            </div>
            <div class="panel-body">
                <div v-for="t in v['access']">
                    <p class="col-sm-2 col-md-2 col-lg-2" v-for="d in t">
                        <label>
                            <input type="checkbox" :name="'modules['+v.module.name+'][]'" :value="d.identifying" :checked="d._status" @click="selectExtModule($event)"> @{{d.title}}
                        </label>
                    </p>
                </div>
            </div>
        </div>
        <div class="btn-group" role="group" aria-label="...">
            <button type="button" class="btn btn-default" @click="cancelSelectAllCheckbox()">取消选择</button>
            <button type="button" class="btn btn-default" @click="selectAllCheckbox()">选择全部</button>
            <button type="submit" class="btn btn-primary">保存修改</button>
        </div>
    </form>
    <script>
        require(['vue', 'hdjs', 'resource/js/hdcms.js'], function (Vue, hdjs, hdcms) {
            new Vue({
                el: '#app',
                data: {
                    menusAccess: <?php echo json_encode($menusAccess, JSON_UNESCAPED_UNICODE);?>,
                    moduleAccess: <?php echo json_encode($moduleAccess, JSON_UNESCAPED_UNICODE);?>,
                },
                methods: {
                    selectAll: function (obj) {
                        var elem = $(obj.currentTarget);
                        var status = elem.is(":checked");
                        elem.parent().parent().next().find('input').prop('checked', status);
                    },
                    selectExtModule: function () {
                        var status = $(".extModule input:checked").length > 0;
                        $("input[value='package_managa']").prop('checked', status);
                    },
                    selectAllCheckbox: function () {
                        $("input:checkbox").prop('checked', true);
                    },
                    //选择所有表单
                    cancelSelectAllCheckbox: function () {
                        $("input:checkbox").prop('checked', false);
                    },
                    submit: function () {
                        hdjs.submit({successUrl: 'refresh'});
                    }
                }
            })
        })
    </script>
</block>