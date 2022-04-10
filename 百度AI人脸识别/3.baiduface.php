<?php
//引入人脸识别类
require_once 'AipFace.php';

// 你的 APPID AK SK
const APP_ID = '11225840';
const API_KEY = 'O1UkIDI6Dy7FcPrRwQ2FabH1';
const SECRET_KEY = 'HHQwy0IGdTDRnoMTvQEKdk2oGNsrpnoN';

$client = new AipFace(APP_ID, API_KEY, SECRET_KEY);

//定义需要检测的图片
$img = base64_encode(file_get_contents('pic/all.jpg'));

//如果有选填项存在,可以先设置选填从参数
$opstion = [];
$opstion['max_face_num'] = 5;
$opstion['face_field'] = 'age,beauty,gender';


//调用人脸检测方法得到检测数据
$result = $client->detect($img, 'BASE64',$opstion);

//echo '<pre>';
//print_r($result);



?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">人脸识别结果</h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>编号</th>
                        <th>性别</th>
                        <th>人脸图像</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($result['result']['face_list'] as $k => $v) {
                        ?>
                        <tr>
                            <td><?php echo $k + 1; ?></td>
                            <td><?php echo $v['gender']['type']; ?></td>
                            <td><span style="display:block;width: <?php echo $v['location']['width'] ?>px;height:<?php echo $v['location']['height'] ?>px;background: url('pic/all.jpg') no-repeat -<?php echo $v['location']['left'] ?>px -<?php echo $v['location']['top'] ?>px"></span></td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>


