<extend file='master'/>
<block name="content">
	<form action="" method="post" class="form-horizontal">
		<input type="hidden" name="cid" value="{{$field['cid']}}">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">商铺设置</h3>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-sm-2 control-label">分类名称</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="catname" value="{{$field['catname']}}">
					</div>
				</div>
			</div>
		</div>
		<button type="submit" class="btn btn-primary">保存</button>
	</form>
</block>