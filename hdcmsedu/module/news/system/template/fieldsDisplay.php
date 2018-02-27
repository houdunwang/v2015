<link rel="stylesheet" href="{{MODULE_PATH}}/system/template/reply.css">
<div class="panel panel-default" id="newVue" v-cloak="">
    <div class="panel-heading">
        回复内容
    </div>
    <div class="panel-body">
        <div class="row clearfix reply">
            <div class="col-xs-6 col-xm-3 col-md-3 left-list">
                <div class="panel-group item-group">
                    <div class="panel panel-default item" :id="'new'+key"
                         v-for="(item,key) in contents" v-if="key==0">
                        <div class="panel-body">
                            <div class="img">
                                <i class="default" v-if="!item.thumb">封面图片</i>
                                <img :src="item.thumb" v-if="item.thumb">
                                <span class="text-left" v-html="item.title"></span>
                                <div class="mask">
                                    <a href="javascript:;" @click="editItem(key)">
                                        <i class="fa fa-edit"></i>编辑
                                    </a>
                                    <a href="javascript:;" @click="removeItem(key)">
                                        <i class="fa fa-times"></i>删除
                                    </a>
                                    <a href="javascript:;" @click="up(key)">
                                        <i class="fa fa-caret-square-o-up"></i> 上移
                                    </a>
                                    <a href="javascript:;" @click="down(key)">
                                        <i class="fa fa-caret-square-o-down"></i> 下移
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default item child_news" :id="'new'+key"
                         v-for="(item,key) in contents" v-if="key>0">
                        <div class="panel-body">
                            <h4 class="text-left" v-html="item.title"></h4>
                            <div class="img">
                                <i class="default" v-if="!item.thumb">封面图片</i>
                                <img :src="item.thumb" v-if="item.thumb">
                            </div>
                            <div class="mask">
                                <a href="javascript:;" @click="editItem(key)">
                                    <i class="fa fa-edit"></i>编辑
                                </a>
                                <a href="javascript:;" @click="removeItem(key)">
                                    <i class="fa fa-times"></i>删除
                                </a>
                                <a href="javascript:;" @click="up(key)">
                                    <i class="fa fa-caret-square-o-up"></i> 上移
                                </a>
                                <a href="javascript:;" @click="down(key)">
                                    <i class="fa fa-caret-square-o-down"></i> 下移
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="add-item" @click="addItem()">
                                <span><i class="fa fa-plus"></i> 添加</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-xm-9 col-md-9">
                <div id="content-area">
                    <div class="arrow-left"></div>
                    <div>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">标题</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" required
                                               v-model="activeItem.title" placeholder="请添加图文消息的标题">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">作者</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" required
                                               v-model="activeItem.author"
                                               placeholder="请添加图文消息的作者">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">排序</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" required
                                               v-model="activeItem.rank" placeholder="添加排序">
                                        <span class="help-block">
                                              排序只能在提交后显示。按照从大到小的顺序对图文排序
                                          </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">封面图片</label>
                                    <div class="col-sm-10">
                                        <div class="col-xs-3 img" @click="uploadThumb()"
                                             v-if="!activeItem.thumb">
                                            <span class="thumb">
                                                <i class="fa fa-plus-circle green"></i>&nbsp;添加图片
                                            </span>
                                        </div>
                                        <div class="col-xs-3 img" v-if="activeItem.thumb"
                                             @click="uploadThumb()">
                                            <img :src="activeItem.thumb">
                                            <h3>重新上传</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"></label>
                                    <div class="col-sm-10">
                                        <span class="help-block clearfix">封面（大图片建议尺寸：360像素 * 200像素）</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">描述</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" rows="3" required
                                                  v-model="activeItem.description"
                                                  placeholder="请输入图文消息的简短描述"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"></label>
                                    <div class="col-sm-10">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" v-model="activeItem.type" true-value="1" false-value="0">
                                                是否编辑图文消息
                                            </label>
                                        </div>
                                        <span class="help-block">
                                          编辑详情可以展示这条图文的详细内容, 可以选择不编辑详情, 那么这条图文将直接链接至下方的原文地址中.
                                      </span>
                                    </div>
                                </div>
                                <div class="form-group" v-show="activeItem.type==1">
                                    <label class="col-sm-2 control-label">详情</label>
                                    <div class="col-sm-10">
                                        <textarea id="container" style="height:300px;width:100%;"
                                                  v-model="activeItem.content"></textarea>
                                    </div>
                                </div>
                                <div class="form-group" v-if="activeItem.type==0">
                                    <label class="col-sm-2 control-label">链接</label>
                                    <div class="col-sm-10">
                                        <div class="input-group">
                                            <input placeholder="图文消息页面地址"
                                                   class="form-control"
                                                   v-model="activeItem.url">
                                            <div class="input-group-btn">
                                                <button type="button"
                                                        class="btn btn-default dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">选择链接 <span
                                                            class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li>
                                                        <a @click.prevent="linkBrowsers()">系统菜单</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--序列化所有数据用于post提交-->
    <textarea name="content" v-html="contents" hidden></textarea>
</div>
<script type="application/ecmascript">
    require(['vue', 'hdjs', 'resource/js/hdcms.js', 'resource/js/link.js'], function (Vue, hdjs, hdcms, link) {
        var vm = new Vue({
            el: '#newVue',
            data: {
                contents: <?php echo  $contents;?>,
                //当前操作的子新闻
                activeItem: {},
            },
            mounted() {
                //加载后定义当前操作的图文
                this.current(0);
                //显示隐藏左侧列表编辑菜单
                $("body").delegate('.left-list .panel', 'mouseover', function () {
                    $(this).find('.mask').show();
                }).delegate('.left-list .panel', 'mouseout', function () {
                    $(this).find('.mask').hide();
                });
                //图文编辑器
                var This = this;
                hdjs.ueditor('container', {}, function (editor) {
                    editor.addListener('contentChange', function () {
                        vm.$set(vm.activeItem, 'content', editor.getContent());
                    });
                    editor.addListener('ready', function () {
                        if (editor && editor.getContent() != This.activeItem.content) {
                            editor.setContent(This.activeItem.content);
                        }
                        vm.$watch('activeItem', function (item) {
                            if (editor && editor.getContent() != item.content) {
                                editor.setContent(item.content ? item.content : '');
                            }
                        });
                        editor.addListener('clearRange', function () {
                            vm.$set(vm.activeItem, 'content', editor.getContent());
                        });
                    });
                });
            },
            methods: {
                //当前操作新闻
                current(index) {
                    if (this.contents.length == 0) {
                        this.contents.push({
                            title: '',
                            author: '',
                            description: '',
                            thumb: '',
                            type: 0,
                            url: '',
                            rank: 0,
                            content: ''
                        });
                    }
                    this.activeItem = this.contents[index];
                },
                //更改右侧编辑区位置
                changePositon(index) {
                    $("#content-area").css({'marginTop': $('#new' + index).position().top + 50});
                },
                //添加图文
                addItem() {
                    if (this.contents.length == 5) {
                        hdjs.message('只能添加五篇文章', '', 'info');
                        return;
                    }
                    this.contents.push({
                        title: '',
                        author: '',
                        description: '',
                        thumb: '',
                        type: 0,
                        url: '',
                        rank: 0,
                        content: ''
                    });
                    this.current(this.contents.length - 1);
                    setTimeout(() => {
                        this.changePositon(this.contents.length - 1);
                    }, 200);
                },
                //编辑图文
                editItem(key) {
                    this.current(key);
                    this.changePositon(key);
                },
                //删除元素
                removeItem(key) {
                    this.contents.splice(key, 1);
                },
                //添加封面图片
                uploadThumb() {
                    hdjs.image((images) => {
                        if (images.length > 0) {
                            //上传成功的图片，数组类型
                            this.activeItem.thumb = images[0];
                        }
                    }, {data: {mold: 'local'}})
                },
                //文章下移
                down(key) {
                    var item = this.contents[key];
                    if (this.contents[key + 1]) {
                        vm.$set(vm.contents, key, this.contents[key + 1]);
                        vm.$set(vm.contents, key + 1, item);
                    }
                },
                //文章上移
                up(key) {
                    var item = this.contents[key];
                    if (this.contents[key - 1]) {
                        vm.$set(vm.contents, key, this.contents[key - 1]);
                        vm.$set(vm.contents, key - 1, item);
                    }
                },
                //选择系统菜单
                linkBrowsers() {
                    link.system(function (link) {
                        vm.$set(vm.activeItem, 'url', link);
                    });
                }
            }
        })
    });
</script>