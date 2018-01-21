<ul class="nav nav-tabs" role="tablist">
	<li role="presentation" class="active"><a href="#module" aria-controls="home" role="tab" data-toggle="tab">模块</a></li>
	<li role="presentation"><a href="#tpl" aria-controls="profile" role="tab" data-toggle="tab">模板</a></li>
</ul>
<div class="tab-content" id="ajaxModulesTemplate">
	<div role="tabpanel" class="tab-pane active" id="module">
		<table class="table table-hover">
			<thead>
			<tr>
				<th>模块名称</th>
				<th>模块标识</th>
				<th>&nbsp;</th>
			</tr>
			</thead>
			<tbody>
			<foreach from="$modules" value="$m">
				<tr>
					<td>{{$m['title']}}</td>
					<td>{{$m['name']}}</td>
					<td>
						<button class="btn btn-default pull-right" mid="{{$m['mid']}}" title="{{$m['title']}}" name="{{$m['name']}}"">选择</button>
					</td>
				</tr>
			</foreach>
			</tbody>
		</table>
	</div>
	<div role="tabpanel" class="tab-pane" id="tpl">
		<table class="table table-hover">
			<thead>
			<tr>
				<th>模块名称</th>
				<th>模块标识</th>
				<th>&nbsp;</th>
			</tr>
			</thead>
			<tbody>
			<foreach from="$templates" value="$t">
				<tr>
					<td>{{$t['title']}}</td>
					<td>{{$t['name']}}</td>
					<td>
						<button class="btn btn-default pull-right" tid="{{$t['tid']}}" title="{{$t['title']}}" name="{{$t['name']}}">选择</button>
					</td>
				</tr>
			</foreach>
			</tbody>
		</table>
	</div>
</div>
<script>
	$("#ajaxModulesTemplate button").click(function () {
		if ($(this).hasClass('btn-default')) {
			$(this).attr('class', 'btn btn-primary pull-right');
		} else {
			$(this).attr('class', 'btn btn-default pull-right');
		}
	})
	var modules = "<?php echo q( 'get.module', '' );?>".split('|');
	var templates = "<?php echo q( 'get.template', '' );?>".split('|');
	for (var i = 0; i < modules.length; i++) {
		$("#module button[name='" + modules[i] + "']").attr('class', 'btn btn-primary pull-right');
	}
	for (var i = 0; i < templates.length; i++) {
		$("#tpl button[name='" + templates[i] + "']").attr('class', 'btn btn-primary pull-right');
	}

</script>