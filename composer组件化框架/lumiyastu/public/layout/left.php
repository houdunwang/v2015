<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" >
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">功能菜单</h3>
		</div>
		<style>
			li.active a{
				color: white;
			}
		</style>
		<ul class="list-group">
			<li class="list-group-item <?php if(CONTROLLER == 'entry'): ?>active<?php endif ?>">
				<a href="?s=admin/entry/index" >后台欢迎</a>
			</li>
			<li class="list-group-item <?php if(CONTROLLER == 'grade'): ?>active<?php endif ?>">
				<a href="?s=admin/grade/lists">班级管理</a>
			</li>
			<li class="list-group-item <?php if(CONTROLLER == 'student'): ?>active<?php endif ?>">
				<a href="?s=admin/student/lists">学生管理</a>
			</li>
            <li class="list-group-item <?php if(CONTROLLER == 'user'): ?>active<?php endif ?>">
                <a href="?s=admin/user/changePassword">修改密码</a>
            </li>
		</ul>
	</div>
</div>