<table class="table table-hover">
	<thead>
	<tr>
		<th>模块名称</th>
		<th>类型</th>
		<th>标识</th>
		<th>选择</th>
	</tr>
	</thead>
	<tbody>
	<foreach from="$modules" value="$m">
		<tr>
			<td>{{$m['title']}}</td>
			<td>
				<if value="$m['is_system']==0">
					<span class="label label-success">插件</span>
					<else/>
					<span class="label label-primary">系统</span>
				</if>
			</td>
			<td>
				<span class="label label-info">{{$m['name']}}</span>
			</td>
			<td>
				<button class="btn btn-default" title="{{$m['title']}}" name="{{$m['name']}}" mid="{{$m['mid']}}"
				        onclick="selectModuleItem(this)">选择
				</button>
			</td>
		</tr>
	</foreach>
	</tbody>
</table>
<script>
	function selectModuleItem(obj) {
		var module = {};
		module.title = $(obj).attr('title');
		module.mid = $(obj).attr('mid');
		module.name = $(obj).attr('name');
		if ($.isFunction(selectHasWebModuleComplete)) {
			selectHasWebModuleComplete(module);
		}
	}
</script>