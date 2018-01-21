<extend file='UCENTER_MASTER_FILE'/>
<block name="content">
    <tag action="ucenter.header" title="地址列表"></tag>
    <foreach from="$data" value="$d">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="user">
                    <span class="username">{{$d['username']}}</span>
                    <span class="tel">{{$d['mobile']}}</span>
                </div>
                <div class="address">
                    {{$d['province']}}{{$d['city']}}{{$d['district']}}{{$d['address']}}
                </div>
            </div>
            <div class="panel-body">
                <div class="pull-left">
                    <if value="$d['isdefault']">
                        <i class="fa fa-check-circle"></i> 默认地址
                        <else/>
                        <label>
                            <input type="radio" name="isdefault" value="{{$d['id']}}"> 默认地址
                        </label>
                    </if>
                </div>
                <div class="pull-right">
                    <a href="{!! url('address/post',['id'=>$d['id']]) !!}"><i class="fa fa-pencil-square-o"></i> 编辑</a>
                    <a href="javascript:;" onclick="del({{$d['id']}})"><i class="fa fa-trash-o"></i> 删除</a>
                </div>
            </div>
        </div>
    </foreach>
    <div style="height: 50px;"></div>
    <button class="btn btn-danger btn-block btn-lg navbar-fixed-bottom">
        <a href="{!! url('address/post') !!}"><i class="fa fa-plus"></i> 新建地址</a>
    </button>
    <script>
        require(['hdjs'], function () {
            //设置默认地址
            $("[name='isdefault']").click(function () {
                var id = $(this).val();
                $.get("{!! url('address/changeDefault') !!}", {id: id}, function (json) {
                    require(['hdjs'], function (hdjs) {
                        if (json.valid == 1) {
                            hdjs.message(json.message, 'refresh', 'success', 2, {width: {}});
                        } else {
                            hdjs.message(json.message, '', 'warning');
                        }
                    });
                }, 'json')
            });
        })

        //删除地址
        function del(id) {
            require(['hdjs'], function (hdjs) {
                hdjs.confirm('确定删除吗', function () {
                    $.get("{!! url('address/remove') !!}", {id: id}, function (json) {
                        if (json.valid == 1) {
                            hdjs.message(json.message, 'refresh', 'success');
                        } else {
                            hdjs.message(json.message, '', 'warning');
                        }
                    }, 'json')
                })
            })
        }
    </script>
    <style>
        body {
            background: #f5f5f5;
        }

        div.user {
            font-size: 14px;
            margin-bottom: 5px;
        }

        div.address {
            font-size: 12px;
        }

        .panel {
            border-radius: 0px;
            border: none;
        }

        .panel-default > .panel-heading {
            background: #ffffff;
        }

        .panel-body {
            padding: 6px 15px;
            font-size: 12px;
        }

        .panel-body a {
            color: #999999;
        }

        .btn {
            border-radius: 0px;
        }

        .btn a {
            color: #ffffff;
        }
    </style>
</block>