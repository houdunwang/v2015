<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
    <!-- Latest compiled and minified CSS & JS -->
    <link rel="stylesheet" media="screen" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">
    <script src="./node_modules/jquery-pjax/jquery.pjax.js"></script>
    <script src="./static/layer/layer.js"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <nav class="navbar navbar-default" role="navigation">
            	<!-- Brand and toggle get grouped for better mobile display -->
            	<div class="navbar-header">
            		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            			<span class="sr-only">Toggle navigation</span>
            			<span class="icon-bar"></span>
            			<span class="icon-bar"></span>
            			<span class="icon-bar"></span>
            		</button>
            		<a class="navbar-brand" href="http://www.houdunren.com">后盾人</a>
            	</div>
            
            	<!-- Collect the nav links, forms, and other content for toggling -->
            	<div class="collapse navbar-collapse navbar-ex1-collapse">
            		<ul class="nav navbar-nav">
            			<li class="active"><a data-pjax href="?action=index">首页</a></li>
            			<li><a data-pjax href="?action=php">php</a></li>
            			<li><a data-pjax href="?action=linux">linux</a></li>
            			<li><a data-pjax href="?action=nodejs">nodejs</a></li>
            		</ul>
            		<form data-pjax class="navbar-form navbar-left" method="get" action="?action=search" role="search">
            			<div class="form-group">
            				<input type="text" name="search" class="form-control" placeholder="Search">
            			</div>
            			<button type="submit" class="btn btn-default">Submit</button>
            		</form>

            	</div><!-- /.navbar-collapse -->
            </nav>
            <div id="pjax-container">
                <div id="content">
                <table class="table table-hover" >
                	<thead>
                		<tr>
                			<th>编号</th>
                			<th>网站</th>
                			<th>地址</th>
                		</tr>
                	</thead>
                	<tbody>
                		<tr>
                			<td>1</td>
                			<td>后盾人</td>
                			<td>www.houdunren.com</td>
                		</tr>
                	</tbody>
                </table>
                </div>
            </div>
            <div class="panel panel-default" >
            	  <div class="panel-footer" style="text-align: center">
            			后盾人@copyright2018
            		</div>
            </div>
        </div>
    </div>
    <script>
        // 使用方式一
        // $(document).pjax('a[data-pjax]', '#pjax-container',{
        //     timeout:650,
        //     fragment:'#content'
        // })

        //方式二
        if ($.support.pjax) {
            $(document).on('click', 'a[data-pjax]', function(event) {
                $(this).parents('li').addClass('active').siblings('li').removeClass('active');
                $.pjax.click(event, {container: '#pjax-container'})
            })
            $(document).on('submit', 'form[data-pjax]', function(event) {
                $.pjax.submit(event, '#pjax-container')
            })
            $(document).on('pjax:send', function() {
                layer.load();
            })
            $(document).on('pjax:complete', function() {
                layer.closeAll('loading');
            })
        }
    </script>
</body>
</html>