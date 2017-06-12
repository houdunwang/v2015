<extend file='resource/admin/system.php'/>
<block name="content">
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#">备份列表</a></li>
    </ul>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="alert alert-success">
                {{$content}}
            </div>
        </div>
    </div>
    <script>
        setTimeout(function () {
            location.href = "{{$_SERVER['REQUEST_URI']}}"
        }, 500);
    </script>
</block>