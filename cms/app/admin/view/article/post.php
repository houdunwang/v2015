<extend file='resource/admin/article.php'/>
<block name="content">
    <ul class="nav nav-tabs" role="tablist">
        <li><a href="{{u('lists')}}" role="tab" data-toggle="tab">文章列表</a></li>
        <li class="active"><a href="{{u('post')}}" role="tab" data-toggle="tab">发表文章</a></li>
    </ul>
    <form action="" method="post" role="form" class="form-horizontal">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">文章管理</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">所属栏目</label>
                    <div class="col-sm-10">
                        <select name="category_cid" class="form-control">
                            <foreach from="$category" value="$d">
                                <if value="$model['category_cid']==$d['cid']">
                                    <option value="{{$d['cid']}}" selected="selected">{{$d['_catname']}}</option>
                                    <else/>
                                    <option value="{{$d['cid']}}">{{$d['_catname']}}</option>
                                </if>
                            </foreach>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">标题</label>
                    <div class="col-sm-10">
                        <input type="text" name="title" value="{{$model['title']}}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">属性</label>
                    <div class="col-sm-10">
                        <label class="checkbox-inline">
                            <if value="$model['iscommend']==1">
                                <input type="checkbox" name="iscommend" value="1" checked> 推荐
                                <else/>
                                <input type="checkbox" name="iscommend" value="1"> 推荐
                            </if>
                        </label>
                        <label class="checkbox-inline">
                            <if value="$model['ishot']==1">
                                <input type="checkbox" name="ishot" value="1" checked> 热门
                                <else/>
                                <input type="checkbox" name="ishot" value="1"> 热门
                            </if>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">缩略图</label>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <input type="text" class="form-control" name="thumb" readonly="" value="{{$model['thumb']}}">
                            <div class="input-group-btn">
                                <button onclick="upImage(this)" class="btn btn-default" type="button">选择图片</button>
                            </div>
                        </div>
                        <div class="input-group" style="margin-top:5px;">
                            <img src="{{pic($model['thumb'])}}" class="img-responsive img-thumbnail" width="150">
                            <em class="close" style="position:absolute; top: 0px; right: -14px;" title="删除这张图片" onclick="removeImg(this)">×</em>
                        </div>
                    </div>
                    <script>
                        //上传图片
                        function upImage(obj) {
                            require(['util'], function (util) {
                                options = {
                                    multiple: false,//是否允许多图上传
                                    //data是向后台服务器提交的POST数据
                                    data:{name:'后盾人',year:2099},
                                };
                                util.image(function (images) {          //上传成功的图片，数组类型
                                    $("[name='thumb']").val(images[0]);
                                    $(".img-thumbnail").attr('src', images[0]);
                                }, options)
                            });
                        }

                        //移除图片
                        function removeImg(obj) {
                            $(obj).prev('img').attr('src', 'resource/images/nopic.jpg');
                            $(obj).parent().prev().find('input').val('');
                        }
                    </script>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">描述</label>
                    <div class="col-sm-10">
                        <textarea name="description" class="form-control" rows="5">{{$model['description']}}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">正文</label>
                    <div class="col-sm-10">
                        <textarea id="container" name="content" style="height:300px;width:100%;">{{$model['content']}}</textarea>
                        <script>
                            util.ueditor('container', {hash:2,data:'hd'}, function (editor) {
                                //这是回调函数 editor是百度编辑器实例
                            });
                        </script>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">点击数</label>
                    <div class="col-sm-10">
                        <input type="text" name="click" value="{{$model['click']}}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">来源</label>
                    <div class="col-sm-10">
                        <input type="orderby" name="source" class="form-control" value="{{$model['source']}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">作者</label>
                    <div class="col-sm-10">
                        <input type="orderby" name="author" class="form-control" value="{{$model['author']}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">排序</label>
                    <div class="col-sm-10">
                        <input type="orderby" name="orderby" class="form-control" value="{{$model['orderby']}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">链接</label>
                    <div class="col-sm-10">
                        <input type="orderby" name="linkurl" class="form-control" value="{{$model['linkurl']}}">
                        <span class="help-block">添加链接时将直接跳转到指定的链接，否则显示文章内容</span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">关键字</label>
                    <div class="col-sm-10">
                        <input type="orderby" name="keyword" class="form-control" value="{{$model['keyword']}}">
                        <span class="help-block">微信回复使用的关键词</span>
                    </div>
                </div>

            </div>
        </div>
        <button class="btn btn-primary">保存数据</button>
    </form>
</block>