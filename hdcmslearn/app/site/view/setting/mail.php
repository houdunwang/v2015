<extend file="resource/view/site"/>
<block name="content">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#">邮件通知</a></li>
    </ul>
    <form class="form-horizontal" onsubmit="post(event)">
        <div class="panel panel-default">
            <div class="panel-heading">邮件通知选项</div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">SMTP服务器地址</label>
                    <div class="col-sm-10">
                        <input class="form-control" name="smtp[host]" value="{{v('site.setting.smtp.host')}}">
                        <span class="help-block">指定SMTP服务器的地址
                            <a href="https://help.aliyun.com/knowledge_detail/36687.html?spm=5176.7836659.2.15.QsbtO4" target="_blank">阿里邮箱</a>
                            <a href="http://service.exmail.qq.com/cgi-bin/help?subtype=1&id=28&no=1000585" target="_blank">腾讯邮箱</a>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">SMTP服务器端口</label>
                    <div class="col-sm-10">
                        <input class="form-control" name="smtp[port]" value="{{v('site.setting.smtp.port')}}">
                        <span class="help-block">指定SMTP服务器的地址, 如: 126邮箱为25</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">使用SSL加密</label>
                    <div class="col-sm-10">
                        <label class="radio-inline">
                            <input type="radio" name="smtp[ssl]" value="1" {{v('site.setting.smtp.ssl')==1?'checked="checked"':''}}> 是
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="smtp[ssl]" value="0" {{v('site.setting.smtp.ssl')==0?'checked="checked"':''}}> 否
                        </label>
                        <span class="help-block">开启此项后，连接将用SSL的形式，此项需要SMTP服务器支持</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">发送帐号用户名</label>
                    <div class="col-sm-10">
                        <input class="form-control" name="smtp[username]" value="{{v('site.setting.smtp.username')}}">
                        <span class="help-block">指定发送邮件的用户名</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">密码</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="smtp[password]" value="{{v('site.setting.smtp.password')}}">
                        <span class="help-block">指定发送邮件的密码</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">发件人名称</label>
                    <div class="col-sm-10">
                        <input class="form-control" name="smtp[fromname]" value="{{v('site.setting.smtp.fromname')}}">
                        <span class="help-block">指定发送邮件发信人名称</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">回复邮箱地址</label>
                    <div class="col-sm-10">
                        <input class="form-control" name="smtp[frommail]" value="{{v('site.setting.smtp.frommail')}}">
                        <span class="help-block">指定发送邮件发信人名称</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">测试接收人</label>
                    <div class="col-sm-10">
                        <label>
                            <input type="checkbox" name="smtp[testing]" value="1" {{v('site.setting.smtp.testing')==1?'checked="checked"':''}}> 保存后测试邮件
                        </label>
                        <input class="form-control" name="smtp[testusername]" value="{{v('site.setting.smtp.testusername')}}">
                        <span class="help-block">你可以指定一个收件邮箱, 系统将在保存参数成功后尝试发送一条测试性的邮件, 来检测邮件通知是否正常工作,邮件可能会发送到垃圾邮件中.</span>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="col-lg-1 btn btn-default">保存</button>
    </form>
    <script>
        function post(event){
            event.preventDefault();
            require(['hdjs'],function(hdjs){
                hdjs.submit({successUrl:''});
            })
        }
    </script>
</block>