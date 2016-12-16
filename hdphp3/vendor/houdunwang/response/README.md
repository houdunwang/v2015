# 服务器状态码与数据响应组件

##介绍

Response服务是对 http响应的处理。 

##操作

####响应状态码

```
Response::sendHttpStatus(404);
```

####发送异步

**语法：**

```
public function ajax( $data, $type = "JSON" ) 

type指返回数据类型包括：TEXT XML JSON 默认为JSON
```

**示例**

```
$data=['name'=>'后盾网','url'=>'houdunwang.com']
Response::ajax($data);
```
