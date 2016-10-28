<!--<table border="1">-->
<!--	<tr>-->
<!--		<th>编号</th>-->
<!--		<th>用户名</th>-->
<!--		<th>邮箱</th>-->
<!--	</tr>-->
<!--	<foreach from='$data' key='$a' value='$v'>-->
<!--		<tr>-->
<!--			<td>{{$v['id']}}</td>-->
<!--			<td>{{$v['username']}}</td>-->
<!--			<td>{{$v['email']}}</td>-->
<!--		</tr>-->
<!--	</foreach>-->
<!--</table>-->

<!--<list from='$data' name='$d' row="3">-->
<!--	<strong style="color: red">{{$d['id']}}=>{{$d['username']}}</strong><br/>-->
<!--</list>-->
<!--<list from='$data' name='$d' start="4">-->
<!--	{{$d['id']}}=>{{$d['username']}}<br/>-->
<!--</list>-->

<list from='$data' name='$d'>
	<if value="$hd['list']['d']['index']<=3">
		<strong style="color: red">{{$d['id']}}=>{{$d['username']}}</strong><br/>
		<else/>
		{{$d['id']}}=>{{$d['username']}}<br/>
	</if>
</list>