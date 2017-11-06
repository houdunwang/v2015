<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
	<?php include "./layout/head.php" ?>

    <div class="container">
        <div class="row">
			<?php include "./layout/left.php" ?>

            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">学生管理</h3>
                    </div>
                    <div class="panel-body">
                        <!-- TAB NAVIGATION -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li><a href="?s=admin/student/lists">列表</a></li>
                            <li class="active"><a href="?s=admin/student/add">添加/编辑</a></li>
                        </ul>
                        <br>
                        <form action="" method="post" class="form-horizontal" role="form">
                            <div class="form-group">
                                <label for="inputID" class="col-sm-2 control-label">姓名:</label>
                                <div class="col-sm-10">
                                    <input type="text" name="sname" id="inputID" class="form-control" value="<?php echo $data['sname'] ?>" title=""
                                           required="required">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputID" class="col-sm-2 control-label">班级:</label>
                                <div class="col-sm-10">
                                    <select name="gid" id="inputID" class="form-control">
                                        <option value=""> -- 所属班级 --</option>
										<?php foreach ( $gradeData as $v ): ?>
                                            <option value="<?php echo $v['gid'] ?>" <?php if($data['gid'] == $v['gid']): ?>selected <?php endif ?>  ><?php echo $v['gname'] ?></option>
										<?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputID" class="col-sm-2 control-label">生日:</label>
                                <div class="col-sm-10">
                                    <input type="date" name="birthday" id="inputID" class="form-control" value="<?php echo $data['birthday'] ?>"
                                           title=""
                                           required="required">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputID" class="col-sm-2 control-label">性别:</label>
                                <div class="col-sm-10">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="sex" id="inputID" value="男" <?php if($data['sex'] == '男'): ?>checked<?php endif ?> >
                                            男
                                        </label>
                                        <label>
                                            <input type="radio" name="sex" id="inputID" value="女" <?php if($data['sex'] == '女'): ?>checked<?php endif ?> >
                                            女
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputID" class="col-sm-2 control-label">爱好:</label>
                                <div class="col-sm-10">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="hobby[]" value="篮球" <?php if(in_array('篮球',$data['_hobby'])): ?>checked<?php endif ?>>
                                            篮球
                                        </label>
                                        <label>
                                            <input type="checkbox" name="hobby[]" value="足球" <?php if(in_array('足球',$data['_hobby'])): ?>checked<?php endif ?>>
                                            足球
                                        </label>
                                        <label>
                                            <input type="checkbox" name="hobby[]" value="乒乓球" <?php if(in_array('乒乓球',$data['_hobby'])): ?>checked<?php endif ?>>
                                            乒乓球
                                        </label>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-2">
                                    <input type="hidden" name="sid" value="<?php echo $data['sid'] ?>">
                                    <button type="submit" class="btn btn-primary">保存</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    </body>
</html>