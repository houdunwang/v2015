<extend file="resource/view/site"/>
<block name="content">
    <ul class="nav nav-tabs">
        <li><a href="{{site_url('site.setting.credit')}}">积分列表</a></li>
        <li class="active"><a href="#">积分策略</a></li>
    </ul>
    <form method="post" class="form-horizontal" onsubmit="post(event)">
        {{csrf_field()}}
        <div class="panel panel-default">
            <div class="panel-heading">
                积分行为参数
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">基本&营销</label>
                    <div class="col-sm-10">
                        <select name="creditbehaviors[activity]" class="form-control">
                            <foreach from="v('site.setting.creditnames')" key="$name" value="$v">
                                <if value="$v['title'] && $v['status']">
                                    <if value="$name == v('site.setting.creditbehaviors.activity')">
                                        <option value="{{$name}}" selected>{{$v['title']}}</option>
                                        <else/>
                                        <option value="{{$name}}">{{$v['title']}}</option>
                                    </if>
                                </if>
                            </foreach>
                        </select>
                          <span class="help-block">
                              请设置使用系统内置营销功能时, 默认关联的积分类型. (具体功能或模块可能会提供独立的设置选项, 这里设置的是没有特殊选项时系统的默认值)
                          </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">交易&支付(余额)</label>
                    <div class="col-sm-10">
                        <select name="creditbehaviors[currency]" class="form-control">
                            <foreach from="v('site.setting.creditnames')" key="$name" value="$v">
                                <if value="$v['title'] && $v['status'] ">
                                    <if value="$name == v('site.setting.creditbehaviors.currency')">
                                        <option value="{{$name}}" selected>{{$v['title']}}</option>
                                        <else/>
                                        <option value="{{$name}}">{{$v['title']}}</option>
                                    </if>
                                </if>
                            </foreach>
                        </select>
                          <span class="help-block">
                                请设置系统支付或者购买时使用的积分, 这个积分一般是使用实际货币购买(充值)的.
                          </span>
                    </div>
                </div>
            </div>
        </div>
        <button class="col-lg-1 btn btn-default">保存</button>
    </form>
    <script>
        function post(event) {
            event.preventDefault();
            require(['hdjs'], function (hdjs) {
                hdjs.submit({successUrl: 'refresh'});
            })
        }
    </script>
</block>