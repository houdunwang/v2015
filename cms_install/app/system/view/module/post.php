<extend file='resource/admin/article.php'/>
<block name="content">
    <ul class="nav nav-tabs" role="tablist">
        <li class=""><a href="{{u('lists')}}" >模块列表</a></li>
        <li class="active"><a href="{{u('post')}}">设计模块</a></li>
    </ul>
    <form action="" method="post" role="form" class="form-horizontal">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">设计模块</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">模块标识</label>
                    <div class="col-sm-10">
                        <input type="text" name="name" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">模块名称</label>
                    <div class="col-sm-10">
                        <input type="text" name="title" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">模块描述</label>
                    <div class="col-sm-10">
                        <textarea name="resume" class="form-control" rows="10"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">作者</label>
                    <div class="col-sm-10">
                        <input type="text" name="author" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">预览图片</label>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <input type="text" class="form-control" name="preview" readonly="" value="">
                            <div class="input-group-btn">
                                <button onclick="upImage(this)" class="btn btn-default" type="button">选择图片</button>
                            </div>
                        </div>
                        <div class="input-group" style="margin-top:5px;">
                            <img src="resource/images/nopic.jpg" class="img-responsive img-thumbnail" width="150">
                            <em class="close" style="position:absolute; top: 0px; right: -14px;" title="删除这张图片" onclick="removeImg(this)">×</em>
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
                                        $("[name='preview']").val(images[0]);
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
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">处理微信</label>
                    <div class="col-sm-10">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="is_wechat" value="1"> 是
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <button class="btn btn-primary">保存数据</button>
    </form>
</block>