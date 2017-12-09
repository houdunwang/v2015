<div class="tab-content">
    <div class="active tab-pane fade in" id="template1">
        <table class="table table-hover">
            <tbody>
            <foreach from="$web" value="$v">
                <tr>
                    <td>{{$v}}</td>
                    <td>
                        <button class="btn btn-default btn-sm" onclick="select('{{basename($v)}}')">选择</button>
                    </td>
                </tr>
            </foreach>
            </tbody>
        </table>
    </div>
</div>
<script>
    //选择模板文件
    function select(file) {
        if ($.isFunction(selectArticleTemplateComplete)) {
            selectArticleTemplateComplete(file);
        }
    }
</script>