<extend file="resource/view/site"/>
<block name="content">
    <ul class="nav nav-tabs" role="tablist">
        <li><a href="{!! url('slide.lists',array('webid'=>$_GET['webid'])) !!}">轮换图片管理</a></li>
        <li class="active"><a href="javascript:;">编辑图片</a></li>
    </ul>
    <form action="" method="post" class="form-horizontal" onsubmit="post(event)">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">幻灯片管理</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label star">排序</label>
                    <div class="col-sm-8">
                        <input type="number" required class="form-control" name="displayorder" value="{{$field['displayorder']?:0}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label star">标题</label>
                    <div class="col-sm-8">
                        <input class="form-control" required name="title" value="{{$field['title']}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label star">图片</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input class="form-control" readonly="readonly" required title="请选择图片" name="thumb" value="{{$field['thumb']}}">
                            <div class="input-group-btn">
                                <button onclick="upImage(this)" class="btn btn-default" type="button">选择图片
                                </button>
                            </div>
                        </div>
                        <div class="input-group" style="margin-top:5px;">
                            <img src="{{pic($field['thumb'])}}" class="img-responsive img-thumbnail" width="150">
                            <em class="close" style="position:absolute; top: 0px; right: -14px;" title="删除这张图片" onclick="removeImg(this)">×</em>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label star">直接链接</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input class="form-control" required id="url" name="url" value="{{$field['url']}}">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">选择链接 <span class="caret"></span></button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="javascript:linkBrowsers(this)">系统菜单</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-default">保存</button>
    </form>
</block>
<script>
    //提交表单
    function post(event) {
        event.preventDefault();
        require(['hdjs'], function (hdjs) {
            hdjs.submit({successUrl:"{!! url('slide.lists') !!}"});
        });
    }

    //上传图片
    function upImage(obj) {
        require(['hdjs'], function (hdjs) {
            var options = {
                multiple: false,//是否允许多图上传 
            };
            hdjs.image(function (images) {             //上传成功的图片，数组类型 
                $("[name='thumb']").val(images[0]);
                $(".img-thumbnail").attr('src', images[0]);
            }, options)
        });
    }

    //移除图片 
    function removeImg(obj) {
        require(['hdjs'], function () {
            $(obj).prev('img').attr('src', 'resource/images/nopic.jpg');
            $(obj).parent().prev().find('input').val('');
        })
    }

    //系统链接
    function linkBrowsers() {
        require(['resource/js/hdcms.js','resource/js/link.js'], function (hdcms,link) {
            link.system(function (link) {
                $('#url').val(link);
            });
        })
    }

    require(['hdjs'], function (hdjs) {
        $('form').submit(function () {
            if ($('[name="thumb"]').val() == '') {
                hdjs.message('请选择图片', '', 'error');
                return false;
            }
            return true;
        });
    })
</script>