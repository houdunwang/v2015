<form action="" method="post">
	{{ csrf_field() }}
	<input type="text" name="username">
	<button type="button" onclick="send()">submit</button>
</form>

<script src="//cdn.bootcss.com/jquery/3.1.1/jquery.min.js"></script>
<script>
	function send() {
		$.post('{{__URL__}}', $("form").serialize(), function (res) {

		}, 'json')
	}
</script>