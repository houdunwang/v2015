<extend file="resource/view/system"/>
<block name="content">
    <ol class="breadcrumb">
        <li><i class="fa fa-home"></i></li>
        <li><a href="?s=system/manage/menu">系统</a></li>
        <li class="active">一键更新</li>
    </ol>
    <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="#">系统更新</a></li>
    </ul>
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-info">
                <div class="panel-body alert-info">
                    <h5 style="margin-top: 0px;"><i class="fa fa-refresh"></i> <strong>更新日志</strong></h5>
                    <foreach from="$upgradeLists" value="$v">
                        <p>
                            <span>{{$v['version']}} {{$v['logs']}}</span>
                            <span class="pull-right">{{date('Y-m-d',strtotime($v['build']))}}</span>
                        </p>
                    </foreach>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-info">
                <div class="panel-body alert-info">
                    <h5 style="margin-top: 0px;"><i class="fa fa-bullhorn"></i> <strong>系统公告</strong></h5>
                    <foreach from="$systemNotice" value="$v">
                        <p>
                            <a href="{{$v['url']}}" target="_blank">{{$v['title']}}</a>
                            <span class="pull-right">{{date('Y-m-d',$v['createtime'])}}</span>
                        </p>
                    </foreach>
                </div>
            </div>
        </div>
    </div>
    <div class="form-horizontal">
        <div class="alert alert-danger">
            <i class="fa fa-exclamation-triangle"></i> 更新时请注意备份网站数据和相关数据库文件！官方不强制要求用户跟随官方意愿进行更新尝试！
        </div>
        <div class="form-group">
            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">当前版本</label>
            <div class="col-sm-10">
                <p class="form-control-static"><span class="fa fa-square-o"></span> &nbsp;
                    Build  {{$current['version']}}【{{$current['build']}}】
                </p>
                <div class="help-block text-danger">
                    系统会检测当前程序文件的变动, 如果被病毒或木马非法篡改, 会自动警报并提示恢复至默认版本, 因此可能修订日期未更新而文件有变动
                </div>
            </div>
        </div>
    </div>
    <form class="form-horizontal" v-cloak id="app" @submit.prevent="submit">
        <if value="$upgrade['valid']==1">
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">更新版本</label>
                <div class="col-sm-10">
                    <p class="form-control-static">
                        <span class="fa fa-square-o"></span> &nbsp;
                        Build {{$upgrade['hdcms']['version']}}
                        【{{$upgrade['hdcms']['build']}}】
                    </p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">更新日志</label>
                <div class="col-sm-10">
                    <p class="form-control-static">
                        <?php foreach (preg_split('@\n@', $upgrade['hdcms']['logs']) as $d): ?>
                            <span class="fa fa-square-o"></span> {{$d}}<br/>
                        <?php endforeach; ?>
                    </p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">更新协议</label>
                <div class="col-sm-10">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" v-model="cp1"> 我已经做好了相关文件的备份工作
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" v-model="cp2"> 认同官方的更新行为并自愿承担更新所存在的风险
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" v-model="cp3"> 理解官方的辛勤劳动并报以感恩的心态点击更新按钮
                        </label>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-default col-lg-offset-1" disabled v-show="!cp1 || !cp2 ||!cp3">请接受所有更新协议
            </button>
            <button type="button" class="btn btn-success col-lg-offset-1" @click="send()" v-show="cp1 && cp2 &&cp3">
                开始执行更新
            </button>
            <else/>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">温馨提示</h3>
                </div>
                <div class="panel-body">
                    {{$upgrade['message']}}
                </div>
            </div>
        </if>
    </form>
    <script>
        require(['vue', 'hdjs'], function (Vue, hdjs) {
            new Vue({
                el: "#app",
                data: {
                    cp1: 0, cp2: 0, cp3: 0
                },
                methods: {
                    send: function () {
                        location.href = "{!! u('upgrade',['action'=>'download']) !!}";
                    }
                }
            })
        })
    </script>
</block>