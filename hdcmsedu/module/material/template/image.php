<extend file="resource/view/site"/>
<block name="content">
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="{!! url('site/image') !!}">图片素材列表</a></li>
        <li><a href="{!! url('site/news') !!}">图文消息列表</a></li>
    </ul>
    <br/>
    <div class="panel panel-default">
        <div class="panel-heading clearfix">
            <div class="btn-group" role="group" aria-label="...">
                <button onclick="upImage(this)" class="btn btn-info" type="button">添加图片</button>
            </div>
        </div>
        <div class="panel-body">
            <ul class="image">
                <foreach from="$data" value="$v">
                    <li>
                        <img src="{{pic($v['file'])}}"><br/>
                        <div class="footer-btn">
                            <a href="{{pic($v['file'])}}" title="预览" target="_blank">
                                <i class="fa fa-video-camera"></i>
                            </a>
                            <a href="javascript:del({{$v['id']}})" title="删除">
                                <i class="fa fa-trash-o"></i>
                            </a>
                        </div>
                    </li>
                </foreach>
            </ul>
            <style>
                ul.image {
                    list-style: none;
                    padding: 0px !important;
                }

                .image li {
                    float: left;
                    list-style: none;
                    margin-bottom: 20px;
                    margin-right: 15px;
                    border: 1px solid #e7e7eb;
                }

                .image li .footer-btn {
                    height: 28px;
                    line-height: 2em;
                    background: #f4f5f9;
                    border-top: 1px solid #e7e7eb;
                    overflow: hidden;
                }

                .image li .footer-btn a {
                    width: 50%;
                    display: block;
                    float: left;
                    text-align: center;
                    font-size: 18px;
                    color: #bbbbbb;
                }

                .image li .footer-btn a:first-child {
                    border-right: solid 1px #e7e7eb;
                }

                .image li img {
                    width: 169px;
                    height: 169px;
                }
            </style>
        </div>
        <div class="pull-right">{{$data['links']}}</div>
    </div>

</block>
<script>
    //上传图片
    function upImage() {
        require(['hdjs'], function (hdjs) {
            hdjs.image(function (images) {
                hdjs.message('正在上传中...');
                $.ajax({
                    type: 'POST',
                    url: '{!! url("site.upload_material") !!}',
                    data: {type: 'image', file: images[0]},
                    dataType: 'JSON',
                    success: function (res) {
                        if (res.valid == 1) {
                            location.reload(true);
                        } else {
                            hdjs.message(res.message, '', 'error');
                        }
                    }
                })
            }, {data: {mold: 'local'}})
        });
    }

    //删除图片
    function del(id) {
        require(['hdjs'], function (hdjs) {
            hdjs.confirm('删除图片可能影响图文消息的图片显示,确定删除吗?', function () {
                $.post('{!! url("site/delMaterial") !!}', {id: id}, function (res) {
                    if (res.valid == 1) {
                        hdjs.message(res.message, 'refresh', 'success');
                    } else {
                        hdjs.message(res.message, '', 'error');
                    }
                }, 'json');
            })
        })
    }
</script>