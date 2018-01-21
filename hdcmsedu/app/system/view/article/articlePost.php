<extend file="resource/view/system"/>
<block name="content">
	<ol class="breadcrumb">
		<li><i class="fa fa-home"></i></li>
		<li><a href="?s=system/manage/menu">系统</a></li>
		<li class="active">文章管理</li>
	</ol>
	<ul class="nav nav-tabs">
		<li role="presentation"><a href="{!! u('lists') !!}">新闻分类</a></li>
		<li role="presentation"><a href="{!! u('articleLists') !!}">新闻列表</a></li>
		<li role="presentation" class="active"><a href="{!! u('articlePost') !!}">添加文章</a></li>
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
					<label class="col-sm-2 control-label star">文章标题</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="title" value="{{$field['title']}}">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label star">栏目</label>
					<div class="col-sm-10">
						<select name="cid" class="form-control">
							<option value="">选择栏目</option>
							<foreach from="$category" value="$v">
								<option value="{{$v['id']}}" {{$v['id']==$field['cid']?'selected="selected"':''}}>{{$v['title']}}</option>
							</foreach>
						</select>
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
				<div class="form-group">
					<label class="col-sm-2 control-label">点击数</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="click" value="{{$field['click']}}">
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-2 control-label">缩略图</label>

					<div class="col-sm-10">
						<div class="input-group">
							<input type="text" class="form-control" name="thumb" readonly="" value="{{$field['thumb']}}">
							<div class="input-group-btn">
								<button onclick="upImage(this)" class="btn btn-default" type="button">选择图片</button>
							</div>
						</div>
						<div class="input-group" style="margin-top:5px;">
							<img src="{{$field['thumb']?:'resource/images/nopic.jpg'}}" class="img-responsive img-thumbnail" width="150">
							<em class="close" style="position:absolute; top: 0px; right: -14px;" title="删除这张图片" onclick="removeImg(this)">×</em>
						</div>
					</div>
					<script>
						//上传图片
						function upImage(obj) {
							require(['hdjs'], function (hdjs) {
								options = {
									multiple: false,//是否允许多图上传 
								};
								hdjs.image(function (images) {             //上传成功的图片，数组类型 
									$("[name='thumb']").val(images[0]);
									$(".img-thumbnail").attr('src', images[0]);
								}, options)
							});
						}

						//移除图片 
						function removeImg(obj) {
							$(obj).prev('img').attr('src', 'resource/images/nopic.jpg');
							$(obj).parent().prev().find('input').val('');
						}
					</script>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">跳转链接</label>

					<div class="col-sm-10">
						<input type="text" class="form-control" name="url" value="{{$field['url']}}">
						<span class="help-block">添加链接时,将不显示正文内容</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">内容</label>

					<div class="col-sm-10">
						<textarea id="container" name="content" style="height:300px;width:100%;">{{$field['content']}}</textarea>
						<script>
							hdjs.ueditor('container', {}, function (editor) {
								//这是回调函数 editor是百度编辑器实例
							});
						</script>
					</div>
				</div>
			</div>
		</div>

		<button class="btn btn-primary">提交</button>
	</form>
</block>
