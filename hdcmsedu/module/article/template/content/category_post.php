<extend file="resource/view/site"/>
<block name="content">
    <form method="post" class="form-horizontal" v-cloak id="form" @submit.prevent="submit($event)">
        <ul class="nav nav-tabs" role="tablist">
            <li><a href="{!! url('category.lists') !!}">栏目管理</a></li>
            <li class="active" v-if="field.cid"><a href="javascript:;">编辑栏目</a></li>
            <li class="active" v-if="!field.cid"><a href="javascript:;">添加栏目</a></li>
        </ul>
        <ul class="nav nav-tabs" role="tablist">
            <li class="active"><a href="#tab1" role="tab" data-toggle="tab">基本信息</a></li>
            <li><a href="#tab2" role="tab" data-toggle="tab">模板设置</a></li>
        </ul>
        <div class="tab-content">
            <div class="active tab-pane fade in" id="tab1">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">分类名称</label>
                            <div class="col-sm-9">
                                <input class="form-control" v-model="field.catname" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">栏目状态</label>
                            <div class="col-sm-9">
                                <label class="radio-inline">
                                    <input type="radio" v-model="field.status" value="1"> 开启
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" v-model="field.status" value="0"> 关闭
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">栏目排序</label>
                            <div class="col-sm-9">
                                <input class="form-control" v-model="field.orderby" required>
                            </div>
                        </div>
                        <if value="!Request::get('cid')">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">栏目模型</label>
                                <div class="col-sm-9">
                                    <select class="form-control" v-model="field.mid" required>
                                        <option :value="v.mid" v-for="(v,k) in model" v-html="v.model_title"></option>
                                    </select>
                                    <span class="help-block">为了数据完整性模型选择后不允许修改,请仔细认真选择</span>
                                </div>
                            </div>
                        </if>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">父级栏目</label>
                            <div class="col-sm-9">
                                <select class="js-example-basic-single form-control" v-model="field.pid" required>
                                    <option value="0">顶级栏目</option>
                                    <option :value="v.cid" v-for="(v,k) in category" v-html="v._catname"></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">封面栏目</label>
                            <div class="col-sm-9">
                                <label class="radio-inline">
                                    <input type="radio" value="1" v-model="field.ishomepage"> 是
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" value="0" v-model="field.ishomepage"> 否
                                </label>
                                <span class="help-block">封面栏目不能添加文章,主要用于栏目数据的集中展示,类似专题页</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">分类描述</label>
                            <div class="col-sm-9">
                                <textarea name="description" rows="5" class="form-control"
                                          v-model="field.description"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">直接链接</label>
                            <div class="col-sm-9">
                                <input class="form-control" v-model="field.linkurl">
                                <span class="help-block">链接必须是以http://或是https://开头。没有直接链接，请留空</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="tab2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">封面模板</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input class="form-control" v-model="field.index_tpl" readonly>
                                    <span class="input-group-btn">
									<button class="btn btn-default" type="button" @click="template('index_tpl')">选择模板</button>
								  </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">栏目模板</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input class="form-control" v-model="field.category_tpl"
                                           readonly>
                                    <span class="input-group-btn">
									<button class="btn btn-default" type="button"
                                            @click="template('category_tpl')">选择模板</button>
								  </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">文章模板</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input class="form-control" v-model="field.content_tpl" readonly>
                                    <span class="input-group-btn">
									    <button class="btn btn-default" type="button" @click="template('content_tpl')">选择模板</button>
								    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <textarea name="data" v-html="field" hidden></textarea>
        <button class="btn btn-default" type="submit">保存数据</button>
    </form>
</block>
<script type="text/ecmascript">
    require(['resource/js/hdcms.js', 'hdjs', 'vue'], function (hdcms, hdjs, Vue) {
        var vm = new Vue({
            el: '#form',
            data: {
                category:<?php echo json_encode($category);?>,
                model:<?php echo json_encode($model);?>,
                field:<?php echo json_encode($field);?>
            },
            mounted() {
                if (this.field.length == 0) {
                    this.field = {
                        cid: 0,
                        catname: '',
                        orderby: 0,
                        pid: 0,
                        status: 1,
                        mid: this.model[0].mid,
                        description: '',
                        linkurl: '',
                        ishomepage: 0,
                        index_tpl: 'article_index.php',
                        category_tpl: 'article_list.php',
                        content_tpl: 'article.php',
                        html_category: 'article{siteid}-{cid}-{page}.html',
                        html_content: 'article{siteid}-{aid}-{cid}-{mid}.html',
                    };
                }
            },
            methods: {
                //选择模板
                template(type) {
                    hdcms.template((file) => {
                        this.field[type] = file;
                    })
                },
                submit(event) {
                    var msg = '';
                    if (this.field.catname == '') {
                        msg += '栏目标题不能为空';
                    }
                    if (msg) {
                        hdjs.message(msg, '', 'error');
                    }
                    require(['hdjs'], function (hdjs) {
                        hdjs.submit();
                    });
                }
            }
        })
    });
</script>