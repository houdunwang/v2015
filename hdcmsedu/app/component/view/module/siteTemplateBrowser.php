<div class="template clearfix">
    <foreach from="$data" value="$d">
        <div class="thumbnail">
            <h5>{{$d['title']}}</h5>
            <img src="{!! $d['thumb'] !!}">
            <div class="caption">
                <button type="button" onclick="selectModuleItem(this)" tid="{{$d['tid']}}"
                        thumb="{!! $d['thumb'] !!}"
                        title="{{$d['title']}}" name="{{$d['name']}}"
                        class="btn btn-default btn-xs btn-block">选择模板
                </button>
            </div>
        </div>
    </foreach>
</div>
<script>
    function selectModuleItem(obj) {
        obj = $(obj);
        var data = {};
        data.title = obj.attr('title');
        data.tid = obj.attr('tid');
        data.thumb = obj.attr('thumb');
        data.name = obj.attr('name');
        if ($.isFunction(selectTemplateComplete)) {
            selectTemplateComplete(data);
        }
    }

    //选择结束
    function confirmModuleSelectHandler() {
        var modules = [];
        $('.selectModulesBox .btn-primary').each(function () {
            var title = $(this).attr('title');
            var mid = $(this).attr('mid');
            var name = $(this).attr('name');
            modules.push({title: title, mid: mid, name: name});
        })
        if ($.isFunction(selectModuleComplete)) {
            selectModuleComplete(modules);
        }
    }
</script>
<style>
    .template .panel-heading {
        padding: 0px;
    }

    .template .navbar-default {
        margin-bottom: 0px;
        border: none;
    }

    .template .thumbnail {
        height: 300px;
        width: 180px;
        overflow: hidden;
        float: left;
        margin: 3px 7px;
    }

    .template .thumbnail .caption {
        padding: 0px;
    }

    .template .thumbnail h5 {
        font-size: 14px;
        overflow: hidden;
        height: 25px;
        margin: 3px 0px;
        line-height: 2em;
    }

    .template .thumbnail > img {
        height: 225px;
        max-width: 168px;
        border-radius: 3px;
    }

    .template .thumbnail .caption {
        margin-top: 8px;
    }
</style>