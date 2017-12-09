<extend file="resource/view/site"/>
<block name="content">
    <ul class="nav nav-tabs" role="tablist">
        <li>
            <a href="{!! url('content.lists',['mid'=>Request::get('mid'),'cid'=>Request::get('cid')]) !!}">文章管理</a>
        </li>
        <li class="active"><a href="javascript:;">发表文章</a></li>
    </ul>
    <form class="form-horizontal" onsubmit="post(event)">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">基本字段</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">排序</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" name="orderby" required value="{{$field['orderby']?:0}}">
                        <span class="help-block">文章的显示顺序只能输入0~255间的数字，越大则越靠前</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label star">标题</label>
                    <div class="col-sm-9">
                        <input class="form-control" name="title" required value="{{$field['title']}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label ">所属栏目</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="cid">
                            <foreach from="$category" value="$v">
                                <if value="$v['mid']==$_GET['mid']">
                                    <if value="$_GET['cid']==$v['cid']">
                                        <option value="{{$v['cid']}}" selected="selected">{{$v['catname']}}</option>
                                        <elseif value="$v['ishomepage']">
                                            <option value="{{$v['cid']}}">{{$v['catname']}}(封)</option>
                                            <else/>
                                            <option value="{{$v['cid']}}">{{$v['_catname']}} {{$v['cid']}}</option>
                                    </if>
                                </if>
                            </foreach>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">微信触发关键字</label>
                    <div class="col-sm-9">
                        <input class="form-control" name="keyword" value="{{$field['keyword']}}">
                        <span class="help-block">
                            添加关键字以后,系统将生成一条图文规则,用户可以通过输入关键字来阅读文章。<br/>
                            设置关键词必须要同时设置缩略图
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">自定义属性</label>
                    <div class="col-sm-9">
                        <label class="checkbox-inline">
                            <if value="$field['ishot']">
                                <input type="checkbox" name="ishot" value="1" checked value="1"> 头条
                                <else/>
                                <input type="checkbox" name="ishot" value="1" value="1"> 头条
                            </if>

                        </label>
                        <label class="checkbox-inline">
                            <if value="$field['iscommend']">
                                <input type="checkbox" name="iscommend" value="1" checked> 推荐
                                <else/>
                                <input type="checkbox" name="iscommend" value="1"> 推荐
                            </if>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">文章来源</label>
                    <div class="col-sm-9">
                        <input class="form-control" name="source" value="{{$field['source']}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">文章作者</label>
                    <div class="col-sm-9">
                        <input class="form-control" name="author"
                               value="{{$field['author']}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">缩略图</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <input class="form-control" name="thumb" value="{{$field['thumb']}}" readonly>
                            <div class="input-group-btn">
                                <button onclick="uploadImage(this)" class="btn btn-default" type="button">选择图片</button>
                            </div>
                        </div>
                        <div class="input-group" style="margin-top:5px;">
                            <img src="{{pic($field['thumb'])}}" class="img-responsive img-thumbnail"
                                 width="150">
                            <em class="close" style="position:absolute; top: 0px; right: -14px;" title="删除这张图片" onclick="removeImg(this)">×</em>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">摘要</label>
                    <div class="col-sm-9">
                        <textarea name="description" rows="4" class="form-control">{{$field['description']}}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label star">内容</label>
                    <div class="col-sm-9">
                        <textarea id="content" style="height:300px;width:100%;" name="content">{{$field['content']}}</textarea>
                        <script>
                            require(['hdjs'], function (hdjs) {
                                hdjs.ueditor('content');
                            })
                        </script>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">直接链接</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <input class="form-control" aria-label="..." name="linkurl" value="{{$field['linkurl']}}">
                            <div class="input-group-btn">
                                <button type="button" name="linkurl"
                                        class="btn btn-default dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">选择链接 <span
                                            class="caret"></span></button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="javascript:;" onclick="link.system(this)">系统菜单</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">阅读次数</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" name="click" required value="{{$field['click']?:0}}">
                        <span class="help-block">默认为0。您可以设置一个初始值,阅读次数会在该初始值上增加。</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">文章模板</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <input class="form-control" name="template" value="{{$field['template']}}">
                            <span class="input-group-btn">
								<button class="btn btn-default" type="button" onclick="getTemplate(this)">选择模板</button>
							</span>
                        </div>
                        <span class="help-block">如果文章模板为空时将使用栏目定义的内容页模板</span>
                    </div>
                </div>
            </div>
        </div>
        <if value="$extField">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">扩展字段</h3>
                </div>
                <div class="panel-body">
                    {{$extField}}
                </div>
            </div>
        </if>
        <button class="btn btn-default" type="submit">确定</button>
    </form>
    <script>
        //提交表单
        function post(event) {
            event.preventDefault();
            require(['hdjs'], function (hdjs) {
                hdjs.submit();
            })
        }

        //提交表单
        require(['hdjs'], function (hdjs) {
            $('form').submit(function () {
                var msg = '';
                if ($('.wechat_keyword_error').text() != '') {
                    msg = '微信关键词已经被使用<br/>';
                }
                if (msg) {
                    hdjs.message(msg, '', 'error');
                    return false;
                }
            })
        })

        //选择模板
        function getTemplate(obj) {
            require(['resource/js/hdcms.js'], function (hdcms) {
                hdcms.template(function (file) {
                    $(obj).parent().prev().val(file);
                })
            })
        };
        //链接选择
        window.link = {
            system: function (obj) {
                require(['resource/js/link.js'], function (link) {
                    link.system(function (link) {
                        $(obj).parent().parent().parent().prev().val(link);
                    })
                })
            }
        }

        //上传图片
        function uploadImage(obj) {
            require(['hdjs'], function (hdjs) {
                hdjs.image(function (images) {
                    $(obj).parent().prev().val(images[0]);
                    if (!/^http(s)?/i.test(images[0])) {
                        images[0] = '{{__ROOT__}}' + '/' + images[0];
                    }
                    $(obj).parent().parent().next().find('img').attr('src', images[0]);
                })
            });
        }
    </script>
</block>