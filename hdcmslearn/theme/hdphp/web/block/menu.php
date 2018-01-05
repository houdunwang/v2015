<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="http://www.hdphp.com">HDPHP</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="http://doc.hdphp.com" target="_blank">框架手册</a></li>
                <li><a href="http://www.houdunwang.com" target="_blank">猎人训练</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <if value="memberIsLogin(true)">
                    <li><a href="{{url('member.index',[],'ucenter')}}">会员中心</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> {{v('member.info.nickname')}} <b
                                class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{url('entry/out',['from'=>__URL__],'ucenter')}}">退出</a></li>
                        </ul>
                    </li>
                    <else/>
                    <li>
                        <a href="{{url('entry/login',['from'=>urlencode(__URL__)],'ucenter')}}">登录</a>
                    </li>
                </if>
            </ul>
        </div>
    </div>
</nav>

<link rel="stylesheet" href="{{ARTICLE_URL}}/css/index.css"/>
<script>
    require(['bootstrap']);
</script>