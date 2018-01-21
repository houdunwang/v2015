<extend file="resource/view/site"/>
<link rel="stylesheet" href="{{view_url()}}/css/package.css">
<block name="content">
    <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="#">扩展模块列表</a></li>
    </ul>
    <div class="row apps">
        <foreach from="$modules" value="$d">
            <div class="col-sm-6 col-md-2">
                <div class="thumbnail">
                    <a href="{{site_url('site.entry.module',['m'=>$d['name'],'mt'=>'default'])}}">
                        <div class="img" style="background: url('addons/{{$d['name']}}/{{$d['preview']}}') center;background-size: cover;"></div>
                        <div class="caption">
                            <h4>
                                {{$d['title']}}
                            </h4>
                        </div>
                    </a>
                </div>
            </div>
        </foreach>
    </div>
</block>