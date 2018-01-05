<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
        <include file="resource/view/member"/>
	</head>
	<body>
		<tag action="article.lists" cid="$hdcms['cid']" row='1'>
			<script type="text/javascript">
				location.href = '{{$field['url']}}'
			</script>
		</tag>
	</body>
</html>
