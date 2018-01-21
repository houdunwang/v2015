<extend file="resource/view/site"/>
<block name="content">
	<ul class="nav nav-tabs">
		<li role="presentation" class="active"><a href="#">系统设置</a></li>
	</ul>
	<div class="page-header">
		<h4><i class="fa fa-comments"></i> 系统设置</h4>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">系统设置信息</h3>
		</div>
		<table class="table table-bordered table-hover">
			<tbody>
			<tr>
				<th>会员注册类型</th>
				<td>
					<?php
					$register = [1=> '会员手动注册', '系统自动注册' ];
					echo $register[v('site.setting.register.item')]
					?>
				</td>
			</tr>
			<tr>
				<th>微信支付</th>
				<td>
					{{v("site.setting.pay.wechat.open")?'开启':'关闭'}}
				</td>
			</tr>
			</tbody>
		</table>
	</div>
</block>