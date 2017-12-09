<extend file="resource/view/site"/>
<block name="content">
    <ul class="nav nav-tabs">
        <li><a href="{!! url('site/MemberLists') !!}">会员列表</a></li>
        <li><a href="{!! url('site/MemberPost') !!}">添加会员</a></li>
        <li class="active"><a href="javascript:;">编辑会员</a></li>
    </ul>
    <form action="{!! url('site.changePassword') !!}" method="post" id="userPasswordFrom"
          class="form-horizontal" onsubmit="userPasswordFrom(event)">
        <input type="hidden" name="uid" value="{{$user['uid']}}">
        <div class="panel panel-default">
            <div class="panel-heading">
                修改密码
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">新密码</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" name="password" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">重复新密码</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" name="password2" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-8 col-sm-offset-2">
                        <button class="btn btn-primary">修改密码</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <form method="post" class="form-horizontal" id="userInfoFrom" onsubmit="submitInfo(event)">
        <div class="panel panel-default">
            <div class="panel-heading">
                基本资料
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">编号UID</label>
                    <div class="col-sm-8">
                        <input class="form-control" name="uid" readonly="readonly"
                               value="{{$user['uid']}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">会员组</label>
                    <div class="col-sm-8">
                        <select name="group_id" class="form-control">
                            <foreach from="$group" value="$g">
                                <if value="$user['group_id']==$g['id']">
                                    <option value="{{$g['id']}}" selected="selected">
                                        {{$g['title']}}
                                    </option>
                                    <else/>
                                    <option value="{{$g['id']}}">{{$g['title']}}</option>
                                </if>
                            </foreach>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">昵称</label>
                    <div class="col-sm-8">
                        <input class="form-control" name="nickname"
                               value="{{$user['nickname']}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">真实姓名</label>
                    <div class="col-sm-8">
                        <input class="form-control" name="realname"
                               value="{{$user['realname']}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">性别</label>
                    <div class="col-sm-8">
                        <select name="gender" class="form-control">
                            <option value="0">保密</option>
                            <option value="1">男</option>
                            <option value="2">女</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">
                        {{v('site.setting.creditnames.credit1.title' )}}</label>
                    <div class="col-sm-8">
                        <input class="form-control" name="credit1" value="{{$user['credit1']}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">
                        {{v('site.setting.creditnames.credit2.title' )}}</label>
                    <div class="col-sm-8">
                        <input class="form-control" name="credit2" value="{{$user['credit2']}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">生日</label>
                    <div class="col-sm-8">
                        <div class="row">
                            <div class="col-sm-4">
                                <select name="birthyear" class="form-control"></select>
                            </div>
                            <div class="col-sm-4">
                                <select name="birthmonth" class="form-control"></select>
                            </div>
                            <div class="col-sm-4">
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
                    <label class="col-sm-2 control-label">户籍</label>
                    <div class="col-sm-8">
                        <div class="row">
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
                                    hdjs.city.render({
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
                    <div class="col-sm-8">
                        <input class="form-control" name="address"
                               value="{{$user['address']}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">手机</label>
                    <div class="col-sm-8">
                        <input class="form-control" name="mobile"
                               value="{{$user['mobile']}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">QQ</label>
                    <div class="col-sm-8">
                        <input class="form-control" name="qq" value="{{$user['qq']}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-8">
                        <input class="form-control" name="email"
                               value="{{$user['email']}}">
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary col-xs-1"> 保存</button>
    </form>
</block>
<script>
    /**
     * 修改密码
     * @returns {boolean}
     */
    function userPasswordFrom(event) {
        event.preventDefault();
        require(['hdjs'], function (hdjs) {
            hdjs.submit({
                el: '#userPasswordFrom',
                url: "{!! url('site.changePassword') !!}",
                successUrl: "{!! url('site.memberLists') !!}"
            });
        })
    }

    /**
     * 修改用户信息
     * @returns {boolean}
     */
    function submitInfo(event) {
        event.preventDefault();
        require(['hdjs'], function (hdjs) {
            hdjs.submit({
                el: '#userInfoFrom',
            });
        })
    }
</script>