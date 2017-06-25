<extend file='resource/admin/article.php'/>
<block name="content">
    <ul class="nav nav-tabs" role="tablist">
        <li><a href="{{u('lists')}}">栏目列表</a></li>
        <li class="active"><a href="{{u('post')}}">添加栏目</a></li>
    </ul>
    <form action="" method="post" role="form" class="form-horizontal">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">栏目数据</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">父级栏目</label>
                    <div class="col-sm-10">
                        <select name="pid" class="form-control">
                            <option value="0">顶级栏目</option>
                            <foreach from="$category" value="$d">
                                    <option value="{{$d['cid']}}" {{$d['_disabled']}} {{$d['_selected']}}>{{$d['_catname']}}</option>
                            </foreach>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">栏目标题</label>
                    <div class="col-sm-10">
                        <input type="text" name="catname" value="{{$model['catname']}}" class="form-control" id="" placeholder="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">栏目描述</label>
                    <div class="col-sm-10">
                        <textarea name="description" class="form-control" rows="10">{{$model['description']}}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">封面图片</label>
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
                        </script>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">外部链接</label>
                    <div class="col-sm-10">
                        <input type="text" name="linkurl" value="{{$model['linkurl']}}" class="form-control" id="" placeholder="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">栏目排序</label>
                    <div class="col-sm-10">
                        <input type="orderby" class="form-control" value="{{$model['orderby']}}" id="" placeholder="">
                    </div>
                </div>
            </div>
        </div>
        <button class="btn btn-primary">保存数据</button>
    </form>
</block>