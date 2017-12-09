<extend file='UCENTER_MASTER_FILE'/>
<block name="content">
    <link rel="stylesheet" type="text/css" href="{!! UCENTER_TEMPLATE_URL !!}/static/css/my_info.css"/>
    <form class="form-horizontal" onsubmit="post(event)">
        <div class="panel panel-default">
            <div class="panel-heading">修改会员资料</div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">会员编号</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" disabled value="{{v('member.info.uid')}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">昵称</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="nickname" value="{{$user['nickname']}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">真实姓名</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="realname" value="{{$user['realname']}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">性别</label>
                    <div class="col-sm-10">
                        <select name="gender" class="form-control">
                            <foreach from="['保密','男','女']" value="$v" key="$k">
                                <if value="$user['gender']==$k">
                                    <option value="{{$k}}" selected="selected">{{$v}}</option>
                                    <else/>
                                    <option value="{{$k}}">{{$v}}</option>
                                </if>
                            </foreach>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">出生日期</label>
                    <div class="col-sm-10">
                        <div class="row tpl-calendar">
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <select name="birthyear" class="form-control"></select>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <select name="birthmonth" class="form-control"></select>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <select name="birthday" class="form-control"></select>
                            </div>
                        </div>
                    </div>
                    <script>
                        require(['hdjs'], function (hdjs) {
                            hdjs.dateselect({
                                year: document.querySelector('[name="birthyear"]'),
                                month: document.querySelector('[name="birthmonth"]'),
                                day: document.querySelector('[name="birthday"]'),
                            }, {
                                year: "{{$user['birthyear']}}",
                                month: "{{$user['birthmonth']}}",
                                day: "{{$user['birthday']}}"
                            });
                        })
                    </script>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">居住地址</label>
                    <div class="col-sm-10">
                        <div class="row address">
                            <div class="col-sm-4">
                                <select name="resideprovince" class="form-control"></select>
                            </div>
                            <div class="col-sm-4">
                                <select name="residecity" class="form-control"></select>
                            </div>
                            <div class="col-sm-4">
                                <select name="residedist" class="form-control"></select>
                            </div>
                            <script>
                                require(['hdjs'], function (hdjs) {
                                    hdjs.city({
                                        //省份标签
                                        province: document.querySelector('[name="resideprovince"]'),
                                        //城市标签
                                        city: document.querySelector('[name="residecity"]'),
                                        //地区标签
                                        area: document.querySelector('[name="residedist"]'),
                                    }, {
                                        //默认省
                                        province: "{{$user['resideprovince']}}",
                                        //默认市
                                        city: "{{$user['residecity']}}",
                                        //默认地区
                                        area: "{{$user['residedist']}}",
                                    });
                                });
                            </script>

                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">详细地址</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="address" value="{{$user['address']}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">QQ</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="qq" value="{{$user['qq']}}">
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                设置头像
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">头像</label>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <input type="text" class="form-control" name="icon" readonly="" value="{{$user['icon']}}">
                            <div class="input-group-btn">
                                <button onclick="upImage(this)" class="btn btn-default" type="button">选择图片</button>
                            </div>
                        </div>
                        <div class="input-group" style="margin-top:5px;">
                            <img src="{{icon($user['icon'])}}" class="img-responsive img-thumbnail" width="150">
                            <em class="close" style="position:absolute; top: 0px; right: -14px;" title="删除这张图片" onclick="removeImg(this)">×</em>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-10">
                        <div class="well">
                            <div class="icon">
                                <ul class="row">
                                    <?php for ($i = 1; $i <= 24; $i++): ?>
                                        <li class="col-xs-1" onclick="icon('resource/images/icon/{{$i}}.jpg',this)">
                                            <img src="{{root_url()}}/resource/images/icon/{{$i}}.jpg" alt="">
                                        </li>
                                    <?php endfor; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-10 col-sm-offset-2">
                <button class="btn btn-primary">保存资料</button>
            </div>
        </div>
    </form>
</block>
<script>
    //选择头像
    function icon(img, obj) {
        $("[name='icon']").val(img);
        $("div.icon ul li").removeClass('sel');
        $(obj).addClass('sel');
        $('.img-thumbnail').attr('src',img)
    }

    function post(event) {
        event.preventDefault();
        require(['hdjs'], function (hdjs) {
            hdjs.submit({successUrl: 'refresh'})
        })
    }

    //上传图片
    function upImage(obj) {
        require(['hdjs'], function (hdjs) {
            var options = {
                multiple: false,//是否允许多图上传 
            };
            hdjs.image(function (images) {             //上传成功的图片，数组类型 
                $("[name='icon']").val(images[0]);
                $(".img-thumbnail").attr('src', images[0]);
            }, options)
        });
    }

    //移除图片 
    function removeImg(obj) {
        require(['hdjs'], function (hdjs) {
            $(obj).prev('img').attr('src', 'resource/images/nopic.jpg');
            $(obj).parent().prev().find('input').val('');
        })
    }
</script>
<style>
    .tpl-calendar div {
        margin-bottom: 10px;
    }

    .address div {
        margin-bottom: 10px;
    }
</style>