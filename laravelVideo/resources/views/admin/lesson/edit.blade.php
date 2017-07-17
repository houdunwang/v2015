@extends('admin.layout.master')
@section('content')
    <ul class="nav nav-tabs">
        <li><a href="/admin/lesson">课程列表</a></li>
        <li class="active"><a href="#">编辑课程</a></li>
    </ul>
    <form action="/admin/lesson/{{$lesson['id']}}" method="post" class="form-horizontal" role="form">
        {{csrf_field()}}
        {{ method_field('PUT') }}
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">课程管理</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">课程</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="title" required value="{{$lesson['title']}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">介绍</label>
                    <div class="col-sm-10">
                        <textarea name="introduce" class="form-control" rows="5"
                                  required>{{$lesson['introduce']}}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">预览图</label>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <input type="text" class="form-control" name="preview" readonly=""
                                   v required value="{{$lesson['preview']}}">
                            <div class="input-group-btn">
                                <button onclick="upImage(this)" class="btn btn-default"
                                        type="button">选择图片
                                </button>
                            </div>
                        </div>
                        <div class="input-group" style="margin-top:5px;">
                            <img src="{{$lesson['preview']}}"
                                 class="img-responsive img-thumbnail" width="150">
                            <em class="close" style="position:absolute; top: 0px; right: -14px;"
                                title="删除这张图片" onclick="removeImg(this)">×</em>
                        </div>
                    </div>
                    <script>
                        //上传图片
                        function upImage(obj) {
                            require(['util'], function (util) {
                                options = {
                                    multiple: false,//是否允许多图上传
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
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">推荐</label>
                    <div class="col-sm-10">
                        <label class="radio-inline">
                            <input type="radio" name="iscommend" value="1" {{$lesson['iscommend']==1?'checked':''}}> 是
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="iscommend" value="0"  {{$lesson['iscommend']==0?'checked':''}}> 否
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">热门</label>
                    <div class="col-sm-10">
                        <label class="radio-inline">
                            <input type="radio" name="ishot" value="1" {{$lesson['ishot']==1?'checked':''}}> 是
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="ishot" value="0"  {{$lesson['ishot']==0?'checked':''}}> 否
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">点击数</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="click" required value="{{$lesson['click']}}">
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default" id="app">
            <div class="panel-heading">
                <h3 class="panel-title">视频管理</h3>
            </div>
            <div class="panel-body">
                <div class="panel panel-default" v-for="(v,k) in videos">
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">视频标题</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" v-model="v.title">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">视频地址</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <input type="text" class="form-control" v-model="v.path">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button" :id="v.id">上传视频</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-sm-2">
                                <button class="btn btn-success btn-sm" @click.prevent="del(k)">
                                    删除视频
                                </button>
                            </div>
                            <div class="col-sm-8" :id="'percentage'+v.id" hidden>
                                上传进度 <b></b>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <button class="btn btn-default" @click.prevent="add">添加视频</button>
            </div>
            <textarea name="videos" hidden>@{{videos}}</textarea>
        </div>

        <button class="btn btn-primary">保存数据</button>
    </form>
    <script>
        require(['vue'], function (Vue) {
            new Vue({
                el: '#app',
                data: {
                    videos: JSON.parse('{!! $videos !!}')
                },
                mounted:function(){
                    this.videos.forEach(function(v){
                        upload(v);
                    })
                },
                methods: {
                    add: function () {
                        var field = {title: '', path: '', id: 'hd' + Date.parse(new Date())};
                        this.videos.push(field);
                        setTimeout(function () {
                            upload(field);
                        }, 200);
                    },
                    del: function (k) {
                        this.videos.splice(k, 1);
                    }
                }
            })
        });
        function upload(field) {
            require(['oss'], function (oss) {
                var id = '#' + field.id;
                var uploader = oss.upload({
                    //获取签名
                    serverUrl: '/component/oss?',
                    //上传目录
                    dir: 'hdphp/',
                    //按钮元素
                    pick: id,
                    accept: {
                        title: 'video',
                        extensions: 'mp4',
                        mimeTypes: 'video/mp4'
                    }
                });
                //上传开始
                uploader.on('startUpload', function () {
//                    console.log('开始上传');
                });
                //上传成功
                uploader.on('uploadSuccess', function (file, response) {
                    field.path = oss.oss.host + '/' + oss.oss.object_name;
//                    console.log('上传完成,文件名:' + oss.oss.host + '/' + oss.oss.object_name);
                });
                //上传中
                uploader.on('uploadProgress', function (file, percentage) {
                    $("#percentage" + field.id).show().find('b').text(parseInt(percentage * 100) + '%');
//                    console.log('上传中,进度:' + parseInt(percentage * 100));
                })
                //上传结束
                uploader.on('uploadComplete', function () {
                    $("#percentage" + field.id).hide();
//                    console.log('上传结束');
                })
            });
        }
    </script>
@endsection