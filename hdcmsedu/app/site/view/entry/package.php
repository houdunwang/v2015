<extend file="resource/view/site"/>
<link rel="stylesheet" href="{{__VIEW__}}/entry/css/package.css">
<block name="content">
	<ul class="nav nav-tabs">
		<li role="presentation" class="active"><a href="#">扩展功能管理</a></li>
	</ul>
	<div class="row apps">
		<foreach from="$data" value="$m">
			<if value="$m['is_system']==0">
				<div class="col-sm-6 col-md-4 col-lg-2">
					<div class="thumbnail">
						<div class="img">
							<img src="addons/{{$m['name']}}/{{$m['preview']}}">
						</div>
						<div class="caption">
							<h4>
								<a href="?s=site/entry/module&m={{$m['name']}}&mark=package&siteid={{siteid()}}">{{$m['title']}}</a>
							</h4>
						</div>
					</div>
				</div>
			</if>
		</foreach>
	</div>
</block>