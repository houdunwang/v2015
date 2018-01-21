<extend file="resource/view/site"/>
<block name="content">
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="javascript:;">微站会员中心</a></li>
    </ul>
    <script>
        window.modules = <?php echo $modules;?>;
        window.menus = <?php echo $menus; ?>
    </script>
    <div id="app">
        <ucenter></ucenter>
    </div>
    <link rel="stylesheet" href="/resource/build/css/app.css">
    <script src="/resource/build/js/app.js"></script>
</block>