<extend file="resource/view/system"/>
<block name="content">
    <div class="clearfix">
        <ol class="breadcrumb">
            <li><i class="fa fa-home"></i></li>
            <li><a href="?s=system/manage/menu">系统</a></li>
            <li class="active">设置新模块</li>
        </ol>
        <ul class="nav nav-tabs">
            <li role="presentation"><a href="{!! u('module.installed') !!}">已经安装模块</a></li>
            <li role="presentation"><a href="?s=system/module/prepared">安装模块</a></li>
            <li role="presentation" class="active"><a href="{!! u('system.module.design') !!}">设计新模块</a></li>
            <li role="presentation"><a href="{!! u('shop.lists',['type'=>'module']) !!}">模块商城</a></li>
            <li role="presentation"><a href="{!! u('shop.upgradeLists') !!}">模块更新</a></li>
            </li>
        </ul>
        <form class="form-horizontal" id="form" @submit.prevent="submit">
            <h5 class="page-header">模块基本信息
                <small>这里来定义你自己模块的基本信息</small>
            </h5>
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label star">模块名称</label>
                <div class="col-sm-10 col-xs-12">
                    <input class="form-control" v-model="field.title">
                    <span class="help-block">模块的名称, 由于显示在用户的模块列表中, 请输入中文发便记忆并有吸引力的名称, 不要超过10个字符 </span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label star">模块标识</label>
                <div class="col-sm-10 col-xs-12">
                    <input class="form-control" v-model="field.name">
                    <span class="help-block">模块标识符, 对应模块文件夹的名称, 系统按照此标识符查找模块定义, 只能由英文字母组成 </span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label star">模块版本</label>
                <div class="col-sm-10 col-xs-12">
                    <input class="form-control" v-model="field.version">
                    <span class="help-block">模块当前版本, 方便使用者识别此模块。此版本号用于模块的版本更新 </span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label star">模块类型</label>
                <div class="col-sm-10 col-xs-12">
                    <select v-model="field.industry" class="form-control">
                        <option v-for="(v,k) in industry" :value="v.name">@{{v.title}}</option>
                    </select>
                    <span class="help-block">模块的类型, 用于分类展示和查找你的模块 </span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label star">模块简述</label>
                <div class="col-sm-10 col-xs-12">
                    <input class="form-control" v-model="field.resume">
                    <span class="help-block">模块功能描述, 使用简单的语言描述模块的作用, 来吸引用户 </span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label star">模块介绍</label>
                <div class="col-sm-10 col-xs-12">
                    <textarea v-model="field.detail" cols="30" rows="3" class="form-control"></textarea>
                    <span class="help-block">模块详细描述, 详细介绍模块的功能和使用方法 </span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label star">模块作者</label>
                <div class="col-sm-10 col-xs-12">
                    <input class="form-control" v-model="field.author">
                    <span class="help-block">模块的作者, 留下你的大名吧 </span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label star">发布网址</label>
                <div class="col-sm-10 col-xs-12">
                    <input class="form-control" v-model="field.url">
                    <span class="help-block">模块的发布页, 用于发布模块更新信息的页面 </span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">模块配置</label>
                <div class="col-sm-10 col-xs-12">
                    <label class="checkbox-inline">
                        <input type="checkbox" value="true" v-model="field.setting">存在全局设置项
                    </label>
                    <span class="help-block">此模块是否存在配置参数, 系统会对每个模块设置独立的配置项模块间互不影响</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">模板标签</label>
                <div class="col-sm-10 col-xs-12">
                    <label class="checkbox-inline">
                        <input type="checkbox" value="true" v-model="field.tag"> 设置模板标签
                    </label>
                    <span class="help-block">用于创建模板使用的自定义标签, 模板标签在 system/tag.php 文件中实现</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">定时任务</label>
                <div class="col-sm-10 col-xs-12">
                    <label class="checkbox-inline">
                        <input type="checkbox" value="true" v-model="field.crontab"> 开启定时任务功能
                    </label>
                    <span class="help-block">用于管理站点中间件中的模块动作</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">独立域名</label>
                <div class="col-sm-10 col-xs-12">
                    <label class="checkbox-inline">
                        <input type="checkbox" value="true" v-model="field.domain"> 开启独立域名访问
                    </label>
                    <span class="help-block">当访问域名时直接访问到模块</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">路由规则</label>
                <div class="col-sm-10 col-xs-12">
                    <label class="checkbox-inline">
                        <input type="checkbox" value="true" v-model="field.router"> 设置路由规则
                    </label>
                    <span class="help-block">用于管理模块链接的路由器设置</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">支付功能</label>
                <div class="col-sm-10 col-xs-12">
                    <label class="checkbox-inline">
                        <input type="checkbox" value="true" v-model="field.pay"> 开启支付功能
                    </label>
                    <span class="help-block">用于管理微信、支付宝等支付功能</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">中间件</label>
                <div class="col-sm-10 col-xs-12">
                    <label class="checkbox-inline">
                        <input type="checkbox" value="true" v-model="field.middleware"> 开启中间件功能
                    </label>
                    <span class="help-block">中间件是程序运行过程中的不同节点,模块可以在不同中间件中设置功能</span>
                </div>
            </div>
            <h5 class="page-header">
                公众平台消息处理选项
                <small>这里来定义公众平台消息相关处理</small>
            </h5>
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">订阅消息类型</label>
                <div class="col-md-10 col-xs-12">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" v-model="field.subscribes.text" value="text">文本消息(重要)
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" v-model="field.subscribes.image" value="image">图片消息
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" v-model="field.subscribes.voice" value="voice">语音消息
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" v-model="field.subscribes.video" value="video">视频消息
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" v-model="field.subscribes.shortvideo" value="shortvideo">小视频消息
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" v-model="field.subscribes.location" value="location">位置消息
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" v-model="field.subscribes.link" value="link">链接消息
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" v-model="field.subscribes.subscribe" value="subscribe">粉丝开始关注
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" v-model="field.subscribes.unsubscribe" value="unsubscribe">粉丝取消关注
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" v-model="field.subscribes.scan" value="scan">扫描二维码
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" v-model="field.subscribes.track" value="track">追踪地理位置
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" v-model="field.subscribes.click" value="click">点击菜单(模拟关键字)
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" v-model="field.subscribes.view" value="view">点击菜单(链接)
                        </label>
                    </div>
                    <span class="help-block">
						订阅特定的消息类型后, 此消息类型的消息到达系统后将会以通知的方式(消息数据只读,
						并不能返回处理结果)调用模块的接受器, 用这样的方式可以实现全局的数据统计分析等功能
					</span>
                    <span class="help-block"><strong>注意: 订阅消息在 system/subscribe.php 文件中实现</strong></span>
                    <div class="alert-warning alert">注意: 订阅的消息信息是只读的, 只能用作分析统计</div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">直接处理消息</label>
                <div class="col-md-10 col-xs-12">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" v-model="field.processors.text" value="text">文本消息(重要)
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" v-model="field.processors.image" value="image">图片消息
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" v-model="field.processors.voice" value="voice">语音消息
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" v-model="field.processors.video" value="video">视频消息
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" v-model="field.processors.shortvideo" value="shortvideo">小视频消息
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" v-model="field.processors.location" value="location">位置消息
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" v-model="field.processors.link" value="link">链接消息
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" v-model="field.processors.subscribe" value="subscribe">粉丝开始关注
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" v-model="field.processors.unsubscribe" value="unsubscribe">粉丝取消关注
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" v-model="field.processors.scan" value="scan">扫描二维码
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" v-model="field.processors.track" value="track">追踪地理位置
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" v-model="field.processors.click" value="click">点击菜单(模拟关键字)
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" v-model="field.processors.view" value="view">点击菜单(链接)
                        </label>
                    </div>
                    <span class="help-block">
                        当前模块能够直接处理的消息类型. 如果公众平台传递过来的消息类型不在设定的类型列表中, 那么系统将不会把此消息路由至此模块
                    </span>
                    <span class="help-block"><strong>注意: 直接处理消息在 system/processor.php 文件中实现</strong></span>
                    <div class="alert-warning alert">
                        注意: 关键字路由只能针对文本消息有效, 文本消息最为重要. 其他类型的消息并不能被直接理解, 多数情况需要使用文本消息来进行语境分析, 再处理其他相关消息类型
                    </div>
                </div>
            </div>
            <h5 class="page-header">微信回复设置
                <small>微信公众号回复内容设置</small>
            </h5>
            <div v-for="v in field.cover">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">功能封面</label>
                    <div class="col-sm-10">
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="input-group" style="margin-left:-15px;margin-bottom:10px">
                                <span class="input-group-addon">操作名称</span>
                                <input class="form-control" v-model="v.title" placeholder="请输入中文操作名称">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="input-group" style="margin-left:-15px;margin-bottom:10px">
                                <span class="input-group-addon">入口标识</span>
                                <input class="form-control" v-model="v.do" placeholder="请输入操作入口">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="input-group" style="margin-left:-15px;margin-bottom:10px">
                                <span class="input-group-addon">参数</span>
                                <input class="form-control" v-model="v.params" placeholder="请输入链接参数">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-1">
                            <div style="margin-left:-45px;">
                                <label class="checkbox-inline" style="vertical-align:bottom">
                                    <a href="#" @click.prevent="delCover(v)" class="fa fa-times-circle"
                                       title="删除此操作"></a>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10 col-xs-12 col-md-9 col-md-offset-1">
                    <div class="well well-sm">
                        <a href="javascript:;" @click="addCover()">
                            添加操作 <i class="fa fa-plus-circle" title="添加菜单"></i>
                        </a>
                    </div>
                    <span class="help-block">
						功能封面是定义微站里一个独立功能的入口(微信客户端操作), 将呈现为一个图文消息,
						点击后进入微站系统中对应的功能,
					</span>
                    <span class="help-block"><strong>注意: 功能封面在 system/cover.php 文件中实现</strong></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">回复规则</label>

                <div class="col-sm-10 col-xs-12">
                    <label class="checkbox-inline">
                        <input type="checkbox" v-model="field.rule"> 需要回复规则
                    </label>
                    <span class="help-block">
						注意: 如果需要回复规则, 那么模块必须能够处理文本类型消息,
						模块安装后系统会自动添加 “回复规则列表” 菜单，用户可以设置关键字触发到模块中。
					</span>
                </div>
            </div>

            <!--业务功能-->
            <h5 class="page-header">模块业务设置
                <small>设置模块的业务功能菜单</small>
            </h5>
            <div v-for="(v,key) in field.business"
                 style="padding-top: 20px;margin-bottom: 10px;background-color: #efefef;border:solid 1px #dedede;">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">业务功能</label>
                    <div class="col-sm-10">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="input-group" style="margin-left:-15px;margin-bottom:10px">
                                <span class="input-group-addon">操作名称</span>
                                <input class="form-control" v-model="v.title" type="text"
                                       placeholder="请输入中文操作名称">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-5">
                            <div class="input-group" style="margin-left:-15px;margin-bottom:10px">
                                <span class="input-group-addon">入口标识</span>
                                <input class="form-control" v-model="v.controller" type="text"
                                       placeholder="请输入控制器文件名称">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-1">
                            <div style="margin-left:-45px;">
                                <label class="checkbox-inline" style="vertical-align:bottom">
                                    <a href="javascript:;" @click="delBusiness(v)" class="fa fa-times-circle"
                                       title="删除此操作"></a>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <!--动作方法-->
                <div class="form-group" v-for="d in v.action">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">动作方法</label>
                    <div class="col-sm-10">
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="input-group" style="margin-left:-15px;margin-bottom:10px">
                                <span class="input-group-addon">操作名称</span>
                                <input class="form-control" v-model="d.title" type="text"
                                       placeholder="请输入中文操作名称">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="input-group" style="margin-left:-15px;margin-bottom:10px">
                                <span class="input-group-addon">入口标识</span>
                                <input class="form-control" v-model="d.do" placeholder="请输入动作操作名称">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="input-group" style="margin-left:-15px;margin-bottom:10px">
                                <span class="input-group-addon">参数</span>
                                <input class="form-control" v-model="d.params" placeholder="请输入链接参数">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-1">
                            <div style="margin-left:-45px;">
                                <label class="checkbox-inline" style="vertical-align:bottom">
                                    <a href="javascript:;" @click="delBusinessAction(key,d)"
                                       class="fa fa-times-circle"
                                       title="删除此操作"></a>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-10 col-xs-12 col-md-9 col-md-offset-1">
                        <div class="well well-sm">
                            <a href="javascript:;" @click="addBusinessAction(v)">
                                添加操作 <i class="fa fa-plus-circle" title="添加菜单"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <!--动作方法end-->
            </div>
            <div class="form-group">
                <div class="col-sm-10 col-xs-12 col-md-12">
                    <div class="well well-sm">
                        <a href="javascript:;" @click="addBusiness()">
                            添加业务 <i class="fa fa-plus-circle" title="添加菜单"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">权限标识</label>
                <div class="col-xs-12 col-sm-12 col-md-10">
					<textarea cols="30" rows="6" class="form-control" v-model="field.permissions"
                              placeholder="添加商品:shop_add"></textarea>
                    <span class="help-block col-md-11">
                        如果您设计的模块添加的业务需要权限设置(后台管理使用)，您可以在这里输入权限标识，
权限标识由：controller/控制器名/方法名组成。例如,商城模块的添加商品权限标识：controller/goods/add",说明:控制器名称为：goods,方法为：add,则对应标识为：controller/goods/add
,多个权限标识使用换行隔开。模块方法中使用 auto('controller/goods/add') 进行权限验证。<br/>
                        <strong>上面的业务功能不需要设置权限标签，系统会自动进行处理，权限标识用于设置没有在上面的"模块业务设置" 中体现的动作。</strong>
                    </span>
                </div>
            </div>
            <!--模块入口设置-->
            <h5 class="page-header">模块入口设置
                <small>模块的桌面访问入口导航设置</small>
            </h5>
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">桌面入口</label>
                <div class="col-sm-10">
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="input-group" style="margin-left:-15px;margin-bottom:10px">
                            <span class="input-group-addon">操作名称</span>
                            <input class="form-control" v-model="field.web.entry.title" type="text"
                                   placeholder="请输入中文操作名称">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="input-group" style="margin-left:-15px;margin-bottom:10px">
                            <span class="input-group-addon">入口标识</span>
                            <input class="form-control" v-model="field.web.entry.do" placeholder="请输入操作入口">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3">
                        <div class="input-group" style="margin-left:-15px;margin-bottom:10px">
                            <span class="input-group-addon">参数</span>
                            <input class="form-control" v-model="field.web.entry.params" type="text"
                                   placeholder="请输入链接参数">
                        </div>
                    </div>
                    <span class="help-block" style="clear: both;">
						开启 "独立域名" 功能后本功能才有效, 当通过域名访问时会员执行这个动作。
					</span>
                    <span class="help-block"><strong>注意: 桌面入口导航在 system/Navigate.php 文件中实现</strong></span>
                </div>
            </div>
            <h5 class="page-header">桌面导航设置
                <small>这里定义桌面访问时的导航菜单</small>
            </h5>
            <div v-for="v in field.web.member">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">会员中心</label>
                    <div class="col-sm-10">
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="input-group" style="margin-left:-15px;margin-bottom:10px">
                                <span class="input-group-addon">操作名称</span>
                                <input class="form-control" v-model="v.title" placeholder="请输入中文操作名称">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="input-group" style="margin-left:-15px;margin-bottom:10px">
                                <span class="input-group-addon">入口标识</span>
                                <input class="form-control" v-model="v.do" placeholder="请输入操作入口">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="input-group" style="margin-left:-15px;margin-bottom:10px">
                                <span class="input-group-addon">参数</span>
                                <input class="form-control" v-model="v.params" placeholder="请输入链接参数">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-1">
                            <div style="margin-left:-45px;">
                                <label class="checkbox-inline" style="vertical-align:bottom">
                                    <a href="javascript:;" @click="delWebMember(v)" class="fa fa-times-circle"
                                       title="删除此操作"></a>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10 col-xs-12 col-md-9 col-md-offset-1">
                    <div class="well well-sm">
                        <a href="javascript:;" @click="addWebMember()">
                            添加操作 <i class="fa fa-plus-circle" title="添加菜单"></i>
                        </a>
                    </div>
                    <span class="help-block">在PC桌面端的会员中心上显示相关功能的链接入口</span>
                    <span class="help-block"><strong>注意: 桌面个人中心导航在 system/navigate.php 文件中实现</strong></span>
                </div>
            </div>
            <!--移动端首页导航-->
            <h5 class="page-header">移动端导航设置
                <small>移动端的导航菜单设置</small>
            </h5>
            <div v-for="v in field.mobile.home">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">首页导航</label>
                    <div class="col-sm-10">
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="input-group" style="margin-left:-15px;margin-bottom:10px">
                                <span class="input-group-addon">操作名称</span>
                                <input class="form-control" v-model="v.title" placeholder="请输入中文操作名称">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="input-group" style="margin-left:-15px;margin-bottom:10px">
                                <span class="input-group-addon">入口标识</span>
                                <input class="form-control" v-model="v.name" placeholder="请输入操作入口">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="input-group" style="margin-left:-15px;margin-bottom:10px">
                                <span class="input-group-addon">参数</span>
                                <input class="form-control" v-model="v.params" placeholder="请输入链接参数">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-1">
                            <div style="margin-left:-45px;">
                                <label class="checkbox-inline" style="vertical-align:bottom">
                                    <a href="javascript:;" @click="delMobileHome(v)" class="fa fa-times-circle"
                                       title="删除此操作"></a>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10 col-xs-12 col-md-9 col-md-offset-1">
                    <div class="well well-sm">
                        <a href="javascript:;" @click="addMobileHome()">
                            添加操作 <i class="fa fa-plus-circle" title="添加菜单"></i>
                        </a>
                    </div>
                    <span class="help-block">
                        在微站的首页上显示相关功能的链接入口(手机端操作), 一般用于通用功能的展示.
                    </span>
                    <span class="help-block"><strong>注意: 微站首页导航扩展功能定义于 site 类的实现中</strong></span>
                </div>
            </div>
            <!--微站会员中心导航-->
            <div v-for="v in field.mobile.member">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">会员中心</label>
                    <div class="col-sm-10">
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="input-group" style="margin-left:-15px;margin-bottom:10px">
                                <span class="input-group-addon">操作名称</span>
                                <input class="form-control" v-model="v.title" placeholder="请输入中文操作名称">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="input-group" style="margin-left:-15px;margin-bottom:10px">
                                <span class="input-group-addon">入口标识</span>
                                <input class="form-control" v-model="v.do" placeholder="请输入操作入口">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="input-group" style="margin-left:-15px;margin-bottom:10px">
                                <span class="input-group-addon">参数</span>
                                <input class="form-control" v-model="v.params" placeholder="请输入链接参数">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-1">
                            <div style="margin-left:-45px;">
                                <label class="checkbox-inline" style="vertical-align:bottom">
                                    <a href="javascript:;" @click="delMobileMember(v)" class="fa fa-times-circle"
                                       title="删除此操作"></a>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10 col-xs-12 col-md-9 col-md-offset-1">
                    <div class="well well-sm">
                        <a href="javascript:;" @click="addMobileMember()">
                            添加操作 <i class="fa fa-plus-circle" title="添加菜单"></i>
                        </a>
                    </div>
                    <span class="help-block">
                        在微站的个人中心上显示相关功能的链接入口(手机端操作), 一般用于个人信息, 或针对个人的数据的展示.
                    </span>
                    <span class="help-block"><strong>注意: 微站个人中心导航扩展功能定义于 site 类的实现中</strong></span>
                </div>
            </div>

            <h5 class="page-header">模块发布
                <small>这里来定义模块发布时需要的配置项</small>
            </h5>
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">兼容的版本</label>
                <div class="col-sm-10 col-xs-12">
                    <label class="checkbox-inline">
                        <input v-model="field.compatible_version.version2" type="checkbox">hdcms 2.0</label>
                    <span class="help-block">当前模块兼容的系统版本, 安装时会判断版本信息, 不兼容的版本将无法安装</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label star">预览图</label>
                <div class="col-sm-10">
                    <div class="input-group">
                        <input class="form-control" readonly="" v-model="field.preview">
                        <div class="input-group-btn">
                            <button @click="uploadPreview()" class="btn btn-default" type="button">选择图片</button>
                        </div>
                    </div>
                    <div class="input-group" style="margin-top:5px;">
                        <img :src="field.preview?field.preview:'resource/images/nopic.jpg'"
                             class="img-responsive img-thumbnail img-cover" width="150">
                        <em class="close" style="position:absolute; top: 0px; right: -14px;" title="删除这张图片"
                            @click="field.preview=''">×</em>
                    </div>
                    <span class="help-block">模块预览图宽度最好不要超过600px, 更好的设计将会获得官方推荐位置</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"></label>
                <div class="col-sm-10 col-xs-12">
                    <input type="submit" class="btn btn-primary" value="点击生成模块文件结构">
                    <p class="help-block">点此直接在源码目录 addons/<span class="identifie"></span> 处生成模块开发的模板文件, 方便快速开发</p>
                </div>
            </div>
            <textarea name="data" v-html="field" hidden></textarea>
        </form>
    </div>

    <script>
        require(['vue', 'hdjs'], function (Vue, hdjs) {
            new Vue({
                el: '#form',
                data: {
                    industry: [
                        {title: '主要业务', name: 'business'},
                        {title: '客户关系', name: 'customer'},
                        {title: '营销与活动', name: 'marketing'},
                        {title: '常用服务与工具', name: 'tools'},
                        {title: '行业解决方案', name: 'industry'},
                        {title: '其他', name: 'other'}
                    ],
                    field:<?php echo old('data', '{
                        "title": "",
                        "name": "",
                        "version": "",
                        "industry": "business",
                        "resume": "",
                        "detail": "",
                        "author": "",
                        "url": "http://www.hdcms.com",
                        "setting": true,
                        "tag": false,
                        "crontab": false,
                        "router": false,
                        "domain": false,
                        "middleware": false,
                        "pay": false,
                        "rule": false,
                        "web": {
                            "entry": {
                                "title": "",
                                "do": "",
                                "params":""
                            }, 
                            "member": [
                                {
                                    "title": "",
                                    "do": "",
                                    "params":""
                                }
                            ]
                        },
                        "mobile": {
                            "home": [
                                {
                                    "title": "",
                                    "do": "",
                                    "params":""
                                }
                            ],
                            "member": [
                                {
                                    "title": "",
                                    "do": "",
                                    "params":""
                                }
                            ]
                        },
                        "subscribes": {
                            "text": false,
                            "image": false,
                            "voice": false,
                            "video": false,
                            "shortvideo": false,
                            "location": false,
                            "link": false,
                            "subscribe": false,
                            "unsubscribe": false,
                            "scan": false,
                            "track": false,
                            "click": false,
                            "view": false
                        },
                        "processors": {
                            "text": false,
                            "image": false,
                            "voice": false,
                            "video": false,
                            "shortvideo": false,
                            "location": false,
                            "link": false,
                            "subscribe": false,
                            "unsubscribe": false,
                            "scan": false,
                            "track": false,
                            "click": false,
                            "view": false
                        },
                        "cover": [
                            {
                                "title": "",
                                "do": "",
                                "params": ""
                            }
                        ],
                        "business": [
                            {
                                "title": "",
                                "controller": "",
                                "action": [
                                    {
                                        "title": "",
                                        "do": "",
                                        "params": ""
                                    }
                                ]
                            }
                        ],
                        "permissions": "",
                        "compatible_version": {
                            "version2": true
                        },
                        "thumb": "",
                        "preview": "",
                        "install": "",
                        "uninstall": "",
                        "upgrade": ""
                    }');?>
                },
                methods: {
                    //预览图片
                    uploadPreview: function () {
                        hdjs.image((images) => {
                            this.field.preview = images[0];
                        })
                    },
                    //封面导航
                    addCover: function () {
                        this.field.cover.push({"title": "", "do": ""});
                    },
                    delCover: function (item) {
                        this.field.cover = _.without(this.field.cover, item);
                    },
                    //桌面会员导航
                    delWebMember: function (item) {
                        this.field.web.member = _.without(this.field.web.member, item);
                    },
                    addWebMember: function () {
                        this.field.web.member.push({"title": "", "do": ""})
                    },
                    //移动端主页导航
                    addMobileHome: function () {
                        this.field.mobile.home.push({"title": "", "do": ""})
                    },
                    delMobileHome: function (item) {
                        this.field.mobile.home = _.without(this.field.mobile.home, item);
                    },
                    //移动端会员中心导航
                    addMobileMember: function () {
                        this.field.mobile.member.push({"title": "", "do": ""})
                    },
                    delMobileMember: function (item) {
                        this.field.mobile.member = _.without(this.field.mobile.member, item);
                    },
                    //业务管理
                    addBusiness: function () {
                        var business = {
                            "title": "",
                            "controller": "",
                            "action": [{
                                "title": "",
                                "do": "",
                                "directly": false
                            }]
                        }
                        this.field.business.push(business);
                    },
                    delBusiness: function (item) {
                        this.field.business = _.without(this.field.business, item);
                    },
                    //添加业务动作
                    addBusinessAction: function (item) {
                        item.action.push({"title": "", "do": "", "directly": false});
                    },
                    delBusinessAction: function (key, item) {
                        this.field.business[key].action = _.without(this.field.business[key].action, item);
                    },
                    submit: function () {
                        var msg = ''
                        if (this.field.title == '') {
                            msg += '模块名称不能为空<br/>';
                        }
                        if (this.field.name == '' || !/^[a-z]+$/.test(this.field.name)) {
                            msg += '模块标识必须为英文小写字母<br/>';
                        }
                        if (this.field.resume == '') {
                            msg += '模块简述不能为空<br/>';
                        }
                        if (this.field.detail == '') {
                            msg += '模块介绍不能为空<br/>';
                        }
                        if (this.field.author == '') {
                            msg += '模块作者不能为空<br/>';
                        }
                        if (this.field.url == '') {
                            msg += '发布网址不能为空<br/>';
                        }
                        if (this.field.preview == '') {
                            msg += '预览图不能为空<br/>';
                        }
                        if (!/^[0-9\.]+$/.test(this.field.version)) {
                            msg += '版本号只能为数字<br/>';
                        }
                        if (msg != '') {
                            hdjs.message(msg, '', 'warning');
                            return false;
                        }
                        hdjs.submit();
                    }
                }
            })
        })
    </script>
</block>