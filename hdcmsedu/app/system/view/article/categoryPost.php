<extend file="resource/view/system"/>
<block name="content">
	<ol class="breadcrumb">
		<li><i class="fa fa-home"></i></li>
		<li><a href="?s=system/manage/menu">系统</a></li>
		<li class="active">文章管理</li>
	</ol>
	<ul class="nav nav-tabs">
		<li role="presentation" class="active"><a href="{!! u('lists') !!}">新闻分类</a></li>
		<li role="presentation"><a href="{!! u('articleLists') !!}">新闻列表</a></li>
		<li role="presentation"><a href="{!! u('articlePost') !!}">添加文章</a></li>
	</ul>
	<h5 class="page-header">用户组管理</h5>

	<form action="" class="form-horizontal" method="post">
		<input type="hidden" name="id" value="{{$field['id']}}">
		<div class="panel panel-default">
			<div class="panel-heading">
				新闻分类
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-sm-2 control-label">分类名称</label>

					<div class="col-sm-10">
						<input type="text" class="form-control" name="title" value="{{$field['title']}}">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">排序</label>

					<div class="col-sm-10">
						<input type="text" class="form-control" name="orderby" value="{{$field['orderby']}}">
						<span class="help-block">排序大小介于0~255之间,数字越大,越靠前。</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">模板</label>
					<div class="col-sm-10">
						<select name="template" class="form-control">
							<option value="">使用默认模板</option>
							<foreach from="$template" value="$v">
								<if value="$v==$field['template']">
									<option value="{{$v}}" selected="selected">{{$v}}</option>
									<else/>
									<option value="{{$v}}">{{$v}}</option>
								</if>
							</foreach>
						</select>
					</div>
				</div>
			</div>
		</div>

		<button class="btn btn-primary">提交</button>
	</form>
</block>
