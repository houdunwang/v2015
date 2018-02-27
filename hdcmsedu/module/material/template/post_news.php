<extend file="resource/view/site"/>
<block name="content">
    <link rel="stylesheet" href="{{MODULE_TEMPLATE_PATH}}/css.css">
    <ul class="nav nav-tabs" role="tablist">
        <li><a href="{!! url('site/image') !!}">图片素材列表</a></li>
        <li><a href="{!! url('site/news') !!}">图文消息列表</a></li>
        <li class="active"><a href="{!! url('site/news') !!}">编辑图文消息</a></li>
    </ul>
    <form method="post" id="app" class="form-horizontal" v-cloak @submit.prevent="submit">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                图文消息管理
            </div>
            <div class="panel-body preview">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="lists">
                            <ul>
                                <li v-for="(v,i) in data.articles" @click="setActionItem(i)"
                                    v-if="i==0">
                                    <div class="pic"
                                         :style="{backgroundImage:'url('+(v.pic?v.pic:'resource/images/nopic.jpg')+')'}">
                                        <h3 v-html="v.title"></h3>
                                    </div>
                                    <div class="action">
                                        <div class="pull-left">
                                            <a href="javascript:;" @click="moveDown(i)"><i
                                                        class="fa fa-long-arrow-down"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                        </div>
                                        <a href="javascript:;" class="pull-right"
                                           @click="remove(v)"><i
                                                    class="fa fa-trash-o"></i></a>
                                    </div>
                                </li>
                                <li class="small clearfix" v-for="(v,i) in data.articles"
                                    @click="setActionItem(i)" v-if="i>0">
                                    <p v-html="v.title"></p>
                                    <div class="pic"
                                         :style="{backgroundImage:'url('+(v.pic?v.pic:'resource/images/nopic.jpg')+')'}"></div>
                                    <div class="action">
                                        <div class="pull-left">
                                            <a href="javascript:;" @click="moveDown(i)"
                                               v-show="i<data.articles.length-1">
                                                <i class="fa fa-long-arrow-down"></i>
                                            </a>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <a href="javascript:;" @click="moveUp(i)">
                                                <i class="fa fa-long-arrow-up"></i>
                                            </a>
                                        </div>
                                        <a href="javascript:;" class="pull-right"
                                           @click="remove(v)"><i
                                                    class="fa fa-trash-o"></i></a>
                                    </div>
                                </li>
                                <li class="add" @click="addItem()">
                                    <i class="fa fa-plus-circle"></i>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-9" v-show="action.title!=undefined">
                        <div class="form-group">
                            <label class="col-sm-2 control-label star">标题</label>
                            <div class="col-sm-10">
                                <input class="form-control" required v-model="action.title">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label star">封面图片</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <button type="button" class="btn btn-default" @click="upImage()">
                                        选择图片
                                    </button>
                                </div>
                                <div class="input-group" style="margin-top:5px;">
                                    <img :src="action.pic" class="img-responsive img-thumbnail" width="150">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label star">作者</label>
                            <div class="col-sm-10">
                                <input class="form-control" required v-model="action.author">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label star">摘要</label>
                            <div class="col-sm-10">
                                <textarea rows="5" class="form-control" required
                                          v-model="action.digest"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">内容</label>
                            <div class="col-sm-10">
                                <textarea id="container" style="height:300px;width:100%;"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">链接</label>
                            <div class="col-sm-10">
                                <input class="form-control" v-model="action.content_source_url">
                                <span class="help-block"> <i class="fa fa-info-circle"></i> 设置链接时将跳转到此链接</span>
                            </div>
                        </div>
                        <textarea name="data" v-html="data" hidden></textarea>
                        <div class="form-group">
                            <div class="btn-group col-sm-offset-2" role="group" aria-label="...">
                                <button type="submit" class="btn btn-success"> 保存</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script type="application/ecmascript">
        require(['hdjs', 'vue'], function (hdjs, Vue) {
            var ve = new Vue({
                el: '#app',
                data: {
                    data: <?php echo $field;?>,
                    action: {},
                    //编辑器对象
                    ueditor: {}
                },
                mounted: function () {
                    this.action = this.data.articles[0];
                    //设置编辑器内容
                    this.ueditor = hdjs.ueditor('container', {}, (ueditor) => {
                        ueditor.addListener('contentChange', () => {
                            this.action.content = ueditor.getContent();
                        });
                        ueditor.addListener('ready', () => {
                            ueditor.setContent(this.action.content);
                            //监听数据变化
                            ve.$watch('action', function (n) {
                                if (ueditor && ueditor.getContent() != this.action.content) {
                                    ueditor.setContent(n.content ? n.content : '');
                                }
                            })
                        });
                        //失去焦点时处罚
                        ueditor.addListener('blur', () => {
                            this.action.content = ueditor.getContent();
                        });
                        ueditor.addListener('clearRange', () => {
                            this.action.content = ueditor.getContent();
                        });
                    });
                },
                methods: {
                    //设置当前元素
                    setActionItem: function (i) {
                        this.action = this.data.articles[i];
                    },
                    //移除图文
                    remove: function (item) {
                        this.data.articles = _.without(this.data.articles, item);
                        if (this.data.articles.length > 0) {
                            this.action = this.data.articles[0];
                        } else {
                            this.action = {};
                        }
                    },
                    //下移
                    moveDown: function (i) {
                        if (this.data.articles[i + 1]) {
                            var tmp = this.data.articles[i + 1];
                            this.data.articles[i + 1] = this.data.articles[i];
                            this.data.articles[i] = tmp;
                        }
                    },
                    //上移
                    moveUp: function (i) {
                        var tmp = this.data.articles[i - 1];
                        this.data.articles[i - 1] = this.data.articles[i];
                        this.data.articles[i] = tmp;
                    },
                    //添加
                    addItem: function () {
                        if (this.data.articles.length > 5) {
                            hdjs.message('只能添加5个图文消息', '', 'error');
                        } else {
                            this.data.articles.push({
                                "title": '',
                                "thumb_media_id": '',
                                "author": '{{v("site.name")}}',
                                "digest": '',
                                "show_cover_pic": 1,
                                "content": '',
                                "content_source_url": '',
                                'pic': ''
                            });
                        }
                        this.action = _.last(this.data.articles);
                    },
                    //上传图片
                    upImage: function () {
                        var This = this;
                        hdjs.image(function (images) {
                            var modal = hdjs.loading();
                            if (images[0]) {
                                $.post('{!! url("site/getMediaId") !!}', {file: images[0]}, function (res) {
                                    if (res.valid == 1) {
                                        This.action.pic = images[0];
                                        This.action.thumb_media_id = res.media_id;
                                    } else {
                                        hdjs.message(res.message, '', 'error');
                                    }
                                    modal.modal('hide');
                                }, 'json');
                            }
                        }, {data: {mold: 'local'}});
                    },
                    //提交表单
                    submit: function () {
                        var msg = '';
                        var k;
                        this.data.articles.forEach(function (v, k) {
                            var pos = k + 1;
                            if (v.title == '') {
                                msg += "第" + pos + "个图文标题为空<br/>";
                            }
                            if (v.thumb_media_id == '') {
                                msg += "第" + pos + "个图文缺少封面图片<br/>";
                            }
                            if (v.author == '') {
                                msg += "第" + pos + "个图文作者为空<br/>";
                            }
                            if ($.trim(v.digest) == '') {
                                msg += "第" + pos + "个图文摘要为空<br/>";
                            }
                            if (v.content_source_url == '' && $.trim(v.content) == '') {
                                msg += "第" + pos + "个内容或链接没有设置<br/>";
                            }
                        })
                        if (msg) {
                            hdjs.message(msg, '', 'error');
                            return false;
                        }
                        hdjs.submit();
                    }
                }
            })
        })
    </script>
</block>