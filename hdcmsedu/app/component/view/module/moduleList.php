<table class="table table-hover">
	<thead>
	<tr>
		<th>选择</th>
		<th>模块名称</th>
		<th>类型</th>
		<th>标识</th>
	</tr>
	</thead>
	<tbody>
	<foreach from="$modules" value="$m">
		<tr>
			<td>
				<input type="checkbox" name="nid[]" value="{{$m['mid']}}" title="{{$m['title']}}" module_name="{{$m['name']}}">
			</td>
			<td>
				{{$m['title']}}
			</td>
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
		</tr>
	</foreach>
	</tbody>
</table>