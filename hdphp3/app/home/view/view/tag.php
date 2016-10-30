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

<!--<list from='$data' name='$d'>-->
<!--	<if value="$hd['list']['d']['index']<=3">-->
<!--		<strong style="color: red">{{$d['id']}}=>{{$d['username']}}</strong><br/>-->
<!--		<else/>-->
<!--		{{$d['id']}}=>{{$d['username']}}<br/>-->
<!--	</if>-->
<!--</list>-->
<!--<if value='count($data)==1'>-->
<!--	有一条数据-->
<!--	<elseif value='count($data)==2'/>-->
<!--	有二条数据-->
<!--	<else/>-->
<!--	有{{count($data)}}条-->
<!--</if>-->
<if value="$errors">
	{{dd($errors)}}
</if>
<form action="" method="post">
	{{csrf_field()}}
	<input type="text" name="ab">
	<input type="submit">
</form>

















