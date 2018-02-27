<include file="resource/view/member"/>
<script>
    //只选择一个用户
    var single = "{{$_GET['single']}}";
    var siteid = "{{$_GET['siteid']}}";
</script>
<div id="_userApp" class="form-horizontal">
    <div class="form-group">
        <label for="" class="col-sm-2 control-label">搜索内容</label>
        <div class="col-sm-10">
            <div class="input-group">
                <input type="text" class="form-control" v-model.trim="searchName"
                       placeholder="请输入搜索内容">
                <span class="input-group-addon btn btn-default" @click="load">
                    <i class="fa fa-search"></i> 搜索
                </span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="" class="col-sm-2 control-label">搜索类型</label>
        <div class="col-sm-10">
            <label class="radio-inline">
                <input type="radio" v-model="type" value="mobile"> 电话
            </label>
            <label class="radio-inline">
                <input type="radio" v-model="type" value="email"> 邮箱
            </label>
            <label class="radio-inline">
                <input type="radio" v-model="type" value="uid"> 会员编号
            </label>
        </div>
    </div>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>编号</th>
            <th>昵称</th>
            <th>真实姓名</th>
            <th>用户组</th>
            <th>电话</th>
            <th>邮箱</th>
            <th>注册时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody id="getUsers">
        <tr v-for="v in lists">
            <td v-html="v.uid"></td>
            <td v-html="v.nickname"></td>
            <td v-html="v.realname"></td>
            <td v-html="v.group_title"></td>
            <td v-html="v.mobile"></td>
            <td v-html="v.email"></td>
            <td v-html="v.created_at"></td>
            <td>
                <div class="btn-group">
                    <button type="button" class="btn btn-default" @click="select(v)">选择</button>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</div>
<script>
    require(['vue', 'hdjs'], function (Vue, hdjs) {
        var vm = new Vue({
            el: "#_userApp",
            data: {
                lists: [],
                searchName: '',
                type: 'email'
            },
            methods: {
                load: function () {
                    if (this.searchName == '') {
                        hdjs.message('没有内容用于搜索', '', 'warning');
                        return;
                    }
                    axios.post("{!! __URL__ !!}", {
                        name: this.searchName,
                        type: this.type
                    }).then((response) => {
                        this.lists = response.data;
                    })
                },
                select: function (v) {
                    window._selectMemberUser(v);
                }
            }
        })
    })
</script>