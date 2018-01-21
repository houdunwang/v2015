<div class="selectModulesBox">
    <table class="table table-hover">
        <thead>
        <tr>
            <th>标题</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <foreach from="$modules" value="$d">
            <tr>
                <td>{{$d['title']}}</td>
                <td class="text-right">
                    <if value="in_array($d['mid'],$useModules)">
                        <button class="btn btn-primary" title="{{$d['title']}}" name="{{$d['name']}}" mid="{{$d['mid']}}" onclick="selectModuleItem(this)">选择</button>
                        <else/>
                        <button class="btn btn-default" title="{{$d['title']}}" name="{{$d['name']}}" mid="{{$d['mid']}}" onclick="selectModuleItem(this)">选择</button>
                    </if>
                </td>
            </tr>
        </foreach>
        </tbody>
    </table>
</div>

<script>
    function selectModuleItem(obj) {
        if ($(obj).attr('class') == 'btn btn-default') {
            $(obj).removeAttr('class').addClass('btn btn-primary');
        } else {
            $(obj).removeAttr('class').addClass('btn btn-default');
        }
    }

    //选择结束
    function confirmModuleSelectHandler() {
        var modules = [];
        $('.selectModulesBox .btn-primary').each(function () {
            var title = $(this).attr('title');
            var mid = $(this).attr('mid');
            var name = $(this).attr('name');
            modules.push({title: title, mid: mid,name:name});
        })
        if ($.isFunction(selectModuleComplete)) {
            selectModuleComplete(modules);
        }
    }
</script>