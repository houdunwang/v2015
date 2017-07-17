# hdjs
基本模块化的前端组件库

##后台签名

```
<?php
class Oss
{
    //生成供前台使用的签名
    public static function sign()
    {
        //阿里云 AccessKeyId
        $id = 'xxxxxx';
        //阿里云  AccessKeySecret
        $key = 'xxxxx';
        //OSS外网域名: 在阿里云后台OSS bucket中查看
        $host = 'http://hdxj.oss-cn-hangzhou.aliyuncs.com';
        //oss中本次上传存放文件的目录
        $dir = $_GET['dir'];
        function gmt_iso8601($time)
        {
            $dtStr      = date("c", $time);
            $mydatetime = new \DateTime($dtStr);
            $expiration = $mydatetime->format(\DateTime::ISO8601);
            $pos        = strpos($expiration, '+');
            $expiration = substr($expiration, 0, $pos);
            return $expiration."Z";
        }

        $now        = time();
        $expire     = 30; //设置该policy超时时间是10s. 即这个policy过了这个有效时间，将不能访问
        $end        = $now + $expire;
        $expiration = gmt_iso8601($end);

        //最大文件大小.用户可以自己设置
        $condition    = [0 => 'content-length-range', 1 => 0, 2 => 1048576000];
        $conditions[] = $condition;

        //表示用户上传的数据,必须是以$dir开始, 不然上传会失败,这一步不是必须项,只是为了安全起见,防止用户通过policy上传到别人的目录
        $start        = [0 => 'starts-with', 1 => '$key', 2 => $dir];
        $conditions[] = $start;

        $arr = ['expiration' => $expiration, 'conditions' => $conditions];
        //return;
        $policy         = json_encode($arr);
        $base64_policy  = base64_encode($policy);
        $string_to_sign = $base64_policy;
        $signature      = base64_encode(hash_hmac('sha1', $string_to_sign, $key, true));

        $response              = [];
        $response['accessid']  = $id;
        $response['host']      = $host;
        $response['policy']    = $base64_policy;
        $response['signature'] = $signature;
        $response['expire']    = $end;
        //这个参数是设置用户上传指定的前缀
        $response['dir'] = $dir;
        return json_encode($response);
    }
}
echo Oss::sign();
```

##前台

```
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OSS上传</title>
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.css" rel="stylesheet">
    <script>
        //模块配置项
        var hdjs = {
            //框架目录
            'base': '../../',
        };
    </script>
    <script src="../../app/util.js"></script>
    <script src="../../require.js"></script>
    <script src="../../config.js"></script>
</head>
<body>
<div class="input-group">
    <input type="text" class="form-control" v-model="v.path">
    <span class="input-group-btn">
        <button class="btn btn-default" type="button" id="pickVideo">上传文件</button>
   </span>
</div>
</div>
<script>
    function upload() {
        require(['oss'], function (oss) {
            var id = '#pickVideo';
            var uploader = oss.upload({
                //获取签名
                serverUrl: 'sign.php?',
                //上传目录
                dir: 'houdunwang/',
                //按钮元素
                pick: id,
                accept: {
                    title: 'Images',
//                  extensions: 'mp4',
//                  mimeTypes: 'video/mp4'
                }
            });
            //上传开始
            uploader.on('startUpload', function () {
                console.log('开始上传');
            });
            //上传成功
            uploader.on('uploadSuccess', function (file, response) {
                console.log('上传完成,文件名:' + oss.oss.host + '/' + oss.oss.object_name);
            });
            //上传中
            uploader.on('uploadProgress', function (file, percentage) {
                console.log('上传中,进度:' + parseInt(percentage * 100));
            })
            //上传结束
            uploader.on('uploadComplete', function () {
                console.log('上传结束');
            })
        });
    }
    upload();
</script>
</body>
</html>
```
