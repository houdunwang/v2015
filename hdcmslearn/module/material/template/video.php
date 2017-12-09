<extend file="resource/view/site"/>
<block name="content">
    <ul class="nav nav-tabs" role="tablist">
        <li><a href="{{site_url('site/image')}}">图片</a></li>
        <li><a href="{{site_url('site/voice')}}">语音</a></li>
        <li class="active"><a href="{{site_url('site/video')}}">视频</a></li>
        <li><a href="{{site_url('site/news')}}">图文</a></li>
    </ul>
</block>