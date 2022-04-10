<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- Latest compiled and minified CSS & JS -->
    <link rel="stylesheet" media="screen" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">
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
                    <li ><a href="?action=index">首页</a></li>
                    <li class="active"><a href="?action=php">php</a></li>
                    <li><a href="?action=linux">linux</a></li>
                    <li><a href="?action=nodejs">nodejs</a></li>
                </ul>
                <form class="navbar-form navbar-left" method="post" action="?action=search" role="search">
                    <div class="form-group">
                        <input type="text" name="search" class="form-control" placeholder="Search">
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>

            </div><!-- /.navbar-collapse -->
        </nav>
        <div id="content">
            <div style="text-align: center;padding: 100px;font-size: 60px">
                php栏目
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-footer" style="text-align: center">
                后盾人@copyright2018
            </div>
        </div>
    </div>
</div>
</body>
</html>