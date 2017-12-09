<extend file="resource/view/system"/>
<block name="content">
	<ol class="breadcrumb">
		<li><i class="fa fa-home"></i></li>
		<li><a href="?s=system/manage/menu">系统</a></li>
		<li class="active">文章管理</li>
	</ol>
	<ul class="nav nav-tabs">
		<li role="presentation"><a href="{!! u('lists') !!}">新闻分类</a></li>
		<li role="presentation" class="active"><a href="{!! u('articleLists') !!}">新闻列表</a></li>
		<li role="presentation"><a href="{!! u('articlePost') !!}">添加文章</a></li>
	</ul>
	<form action="?s=system/group/remove" class="form-horizontal" method="post">
		<div class="panel panel-default">
			<div class="panel-heading">
				新闻列表
			</div>
			<div class="panel-body">
				<table class="table table-hover">
					<thead>
					<tr>
						<th width="80">编号</th>
						<th>文章标题</th>
						<th>栏目</th>
						<th>排序</th>
						<th>点击数</th>
						<th>创建时间</th>
						<th width="160">操作</th>
					</tr>
					</thead>
					<tbody>
					<foreach from="$data" value="$d">
						<tr>
							<td>{{$d['id']}}</td>
							<td>{{$d['title']}}</td>
							<td>{{$d['cat_title']}}</td>
							<td>{{$d['orderby']}}</td>
							<td>{{$d['click']}}</td>
							<td>{{date('Y-m-d',$d['createtime'])}}</td>
							<td>
								<div class="btn-group" role="group" aria-label="...">
									<a href="{!! u('articlePost',['id'=>$d['id']]) !!}" class="btn btn-success btn-sm">编辑</a>
									<a href="javascript:del({{$d['id']}})" class="btn btn-default btn-sm">删除</a>
									<a href="{!! u('system/article/show',['id'=>$d['id']]) !!}" target="_blank" class="btn btn-default btn-sm">预览</a>
								</div>
							</td>
						</tr>
					</foreach>
					</tbody>
				</table>
			</div>
		</div>
	</form>
</block>
<script>
	function del(id) {
		require(['hdjs'], function (hdjs) {
			hdjs.confirm('确定删除吗?', function () {
				$.get("{!! u('delArticle') !!}", {id: id}, function (res) {
					if (res.valid == 1) {
						hdjs.message(res.message, 'refresh', 'success');
					} else {
						hdjs.message(res.message, '', 'error');
					}
				})
			})
		})
	}
</script>
