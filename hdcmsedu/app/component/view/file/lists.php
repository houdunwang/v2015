<div id="fileBox"></div>
<script>
    function selectFileCompase(file) {
        require(['hdjs'], function (hdjs) {
            window.selectFileComplete(file);
        })
    }

    function getDirFiles(name) {
        require(['hdjs'], function (hdjs) {
            $.post("{!! u('component.file.get') !!}", {dir: name}, function (response) {
                $("#fileBox").html(response);
            })
        })
    }

    window.getDirFiles('.');
</script>