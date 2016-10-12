<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>温馨提示</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <script src="{{__ROOT__}}/resource/hdjs/js/jquery.min.js"></script>
    <script src="{{__ROOT__}}/resource/hdjs/app/util.js"></script>
    <script src="{{__ROOT__}}/resource/hdjs/require.js"></script>
    <script src="{{__ROOT__}}/resource/hdjs/app/config.js"></script>
    <link href="{{__ROOT__}}/resource/hdjs/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{__ROOT__}}/resource/hdjs/css/font-awesome.min.css" rel="stylesheet">
</head>

<body>
<div class="panel panel-default">
	  <div class="panel-heading">
			<h3 class="panel-title">温馨提示</h3>
	  </div>
	  <div class="panel-body">
          {{v('config.site.close_message')}}
	  </div>
</div>

</body>
</html>