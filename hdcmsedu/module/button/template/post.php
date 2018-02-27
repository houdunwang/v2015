<extend file="resource/view/site"/>
<link rel="stylesheet" href="{{MODULE_PATH}}/template/css.css">
<block name="content">
    <ul class="nav nav-tabs" role="tablist">
        <li><a href="{!! url('site.lists') !!}">微信菜单管理</a></li>
        <li class="active"><a href="javascript:;">添加菜单</a></li>
    </ul>
    <form id="form" class="form-horizontal" v-cloak @submit.prevent="submit">
        <div class="well clearfix">
            <div class="col-sm-8">
                <h4><strong>菜单说明</strong></h4>
                <p>修改微信菜单后微信客户端需要一些时间才可显示,如果要即时看到效果,需要取消关注后再关注一下。</p>
            </div>
            <div class="col-sm-4 text-right">
                <input type="checkbox" name="status" value="1" class="bootstrap-switch" :checked="data.status">
            </div>
        </div>
        <div class="button clearfix">
            <div class="mobile_view col-xs-4">
                <div class="mobile-header text-center">
                    <img src="resource/images/mobile_head_t.png" style="margin-top: 20px;">
                </div>
                <div class="mobile-body">
                    <img src="resource/images/mobile-header.png" style="width: 100%;">
                    <!--菜单显示区域-->
                    <div class="menu_html">
                        <div v-for="(v,k) in data.button">
                            <h5>
                                <i class="fa fa-minus-circle" @click="removeTopButton(v)"></i>
                                <span @click="editTopMenu(k)" v-html="v.name"></span>
                            </h5>
                            <dl>
                                <dt @click="addSubButton(k)"
                                    v-if="!v.sub_button || v.sub_button.length<5">
                                    <i class="fa fa-plus"></i></dt>
                                <dd v-for="(m,i) in v.sub_button">
                                    <i class="fa fa-minus-circle" @click="removeSubButton(k,i)"></i>
                                    <span @click="editSubMenu(k,i)" v-html="m.name"></span>
                                </dd>
                            </dl>
                        </div>
                        <div v-if="data.button.length<3">
                            <h5 @click="addTopButton()">
                                <i class="fa fa-plus"></i> 添加菜单
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="mobile-footer">
                    <div class="home-btn"></div>
                </div>
            </div>

            <div class="slide col-xs-7" style="margin: 80px 0px 0px 10px;">
                <div class="well">
                    <div class="page-header clearfix">
                        <h3>菜单标题</h3>
                    </div>
                    <div class="alert">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">标题</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="title" required
                                       value="{{$field['title']}}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="well">
                    <div class="arrow-left"></div>
                    <div class="page-header clearfix">
                        <h3>菜单设置</h3>
                    </div>
                    <!--菜单设置-->
                    <div class="alert">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">标题</label>
                            <div class="col-sm-10">
                                <input class="form-control" v-model="active.name">
                            </div>
                        </div>
                        <div class="form-group menus_setting" v-if="active.sub_button.length==0">
                            <label class="col-sm-2 control-label">动作</label>
                            <div class="col-xs-10">
                                <!--按钮类型-->
                                <div>
                                    <label class="radio-inline">
                                        <input type="radio" v-model="active.type" value="view">
                                        链接地址
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" v-model="active.type" value="click">
                                        触发关键字
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" v-model="active.type"
                                               value="scancode_push"> 扫码推事件
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" v-model="active.type"
                                               value="scancode_waitmsg"> 扫码带提示
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" v-model="active.type"
                                               value="pic_sysphoto"> 系统拍照发图
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" v-model="active.type"
                                               value="pic_photo_or_album"> 拍照或者相册发图
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" v-model="active.type"
                                               value="pic_weixin"> 微信相册发图
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" v-model="active.type"
                                               value="location_select"> 地理位置
                                    </label>
                                </div>
                                <hr/>
                                <!--链接-->
                                <div v-show="active.sub_button.length==0 && active.type=='view'">
                                    <div class="input-group">
                                        <input class="form-control"
                                               v-model="active.url">
                                        <div class="input-group-btn">
                                            <button class="btn btn-default" type="button" @click="systemLink()">
                                                <i class="fa fa-external-link"></i> 系统链接
                                            </button>
                                        </div>
                                    </div>
                                    <span class="help-block">指定点击此菜单时要跳转的链接（注：链接需加http://）</span>
                                </div>
                                <!--触发关键词-->
                                <div v-show="active.sub_button.length==0 &&(active.type=='click'||active.type=='scancode_push'||active.type=='scancode_waitmsg' ||active.type=='pic_sysphoto' ||active.type=='pic_photo_or_album'||active.type=='pic_weixin'||active.type=='location_select')">
                                    <div class="input-group dropdown" id="btnKeyword">
                                        <input class="form-control"
                                               v-model="active.key">
                                        <ul class="dropdown-menu" id="searchKeyword"
                                            style="width:85%;"></ul>
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button"
                                                    data-toggle="dropdown" href="#btnKeyword"
                                                    @click="searchKeyword($event)">
                                                <i class="fa fa-search"></i> 搜索
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <textarea name="data" v-html="data" hidden></textarea>
                <button class="btn btn-default">保存菜单</button>
                <br/><br/>
            </div>
        </div>
    </form>
    <script type="text/ecmascript">
        require(['vue', 'resource/js/hdcms.js', 'hdjs','resource/js/link.js'], function (Vue, hdcms, hdjs,link) {
            var vm = new Vue({
                el: '#form',
                beforeMount() {
                    this.active = this.data.button[0];
                },
                data: {
                    //菜单数据
                    data: <?php echo $field["data"];?>,
                    //当前编辑菜单
                    active: {}
                },
                computed: {},
                methods: {
                    //添加一级菜单
                    addTopButton() {
                        var menu = {type: 'view', name: '菜单名称', url: '', sub_button: []};
                        this.data.button.push(menu);
                        this.active = _.last(this.data.button);
                    },
                    //删除一级菜单
                    removeTopButton(item) {
                        this.data.button = _.without(this.data.button, item);
                    },
                    //删除二级菜单
                    removeSubButton(k, i) {
                        this.data.button[k].sub_button.splice(i, 1);
                    },
                    //添加子菜单
                    addSubButton(k) {
                        var menu = {type: 'view', name: '菜单名称', url: '', sub_button: []};
                        this.data.button[k].sub_button.push(menu);
                        this.active = menu;
                    },
                    //编辑菜单
                    editTopMenu(k) {
                        this.active = this.data.button[k];
                    },
                    //编辑子菜单
                    editSubMenu(k, i) {
                        this.active = this.data.button[k].sub_button[i];
                    },
                    //系统链接
                    systemLink() {
                        link.system((link) => {
                            this.active.url = link;
                        });
                    },
                    //选择关键字
                    searchKeyword(e) {
                        var btn = e.target;
                        var ipt = $(btn).parents('div').eq(0).find('input');
                        var val = ipt.val();
                        var ul = $("#searchKeyword"); 
                        var This = this;
                        $.post('{!! site_url("site.keyword.getKeywords") !!}', {key: val}, (data) => {
                            var html = '';
                            if (vm.data.length == 0) {
                                html += "<li><a href='javascript:;'>没有匹配到你输入的关键词</a></li>";
                            } else {
                                $(data).each(function (i) {
                                    html += "<li><a href='javascript:;' class='res_key'>" + data[i].content + "</a></li>";
                                })
                                $(ul).delegate('.res_key', 'click', function () {
                                    vm.$set(vm.active, 'key', $(this).text());
                                })
                            }
                            ul.html(html);
                        }, 'json');
                    },
                    submit() {
                        hdjs.submit();
                    }
                }
            })
        });
    </script>
</block>