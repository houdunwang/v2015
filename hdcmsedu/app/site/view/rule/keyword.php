<div class="panel panel-default" id="hdcmsRuleKeywordForm" v-cloak>
    <div class="panel-heading">添加回复规则</div>
    <div class="panel-body">
        <div class="form-group">
            <label class="col-sm-2 control-label">回复规则名称</label>
            <div class="col-sm-7 col-md-8">
                <input class="form-control" v-model="rule.name" required>
                <span class="help-block">选择高级设置: 将会提供一系列的高级选项供专业用户使用.</span>
            </div>
            <div class="col-sm-3 col-md-2">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" v-model="advSetting" value="1">高级设置
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group" v-show="advSetting">
            <label class="col-sm-2 control-label">状态</label>
            <div class="col-sm-10">
                <div class="radio">
                    <label>
                        <input type="radio" value="1" v-model="rule.status">启用
                    </label>
                    <label>
                        <input type="radio" value="0" v-model="rule.status">禁用
                    </label>
                    <span class="help-block">您可以临时禁用这条回复.</span>
                </div>
            </div>
        </div>
        <div class="form-group" v-show="advSetting">
            <label class="col-sm-2 control-label">排序</label>
            <div class="col-sm-10">
                <input name="rank" class="form-control" required v-model="rule.rank">
                <span class="help-block">规则优先级，越大则越靠前，最大不得超过255</span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">触发关键字</label>
            <div class="col-sm-7 col-md-8" v-for="item in rule.keyword" v-if="item.type==1">
                <input class="form-control" v-model="item.content" id="keywordInput" required @blur="checkWxKeyword(item,rid,$event)">
                <span class="help-block">
                当用户的对话内容符合以上的关键字定义时，会触发这个回复定义。多个关键字请使用逗号隔开。
                <a href="javascript:;" id="keywordEmotion"><i class="fa fa-github-alt"></i> 表情</a>
                选择高级触发: 将会提供一系列的高级触发方式供专业用户使用(注意: 如果你不了解, 请不要使用).
            </span>
            </div>
            <div class="col-sm-3 col-md-2">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" v-model="advancedTriggering">高级触发
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group" v-show="advancedTriggering">
            <label class="col-sm-2 control-label">高级触发列表</label>
            <div class="col-sm-10">
                <div class="panel panel-default tab-content">
                    <div class="panel-heading">
                        <ul class="nav nav-pills" role="tablist">
                            <li role="presentation" class="active" @click="currentKeyType='contain'">
                                <a href="#contain" aria-controls="contain" role="tab" data-toggle="tab">包含关键词</a>
                            </li>
                            <li role="presentation" @click="currentKeyType='regexp'">
                                <a href="#regexp" aria-controls="regexp" role="tab" data-toggle="tab">正则表达式模式匹配</a>
                            </li>
                        </ul>
                    </div>
                    <ul role="tabpanel" class="list-group tab-pane active" id="contain">
                        <li class="list-group-item row" v-for="(item,key) in rule.keyword" v-if="item.type==2">
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <input class="form-control" v-model="item.content"
                                           @blur="checkWxKeyword(item,rid,$event)"/>
                                    <span class="input-group-btn">
                                   <button class="btn btn-default" type="button"
                                           @click="removeKeywordItem(key)">删除</button>
                                </span>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <ul role="tabpanel" class="list-group tab-pane" id="regexp">
                        <li class="list-group-item row" v-for="(item,key) in rule.keyword" v-if="item.type==3">
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <input class="form-control" v-model="item.content"
                                           @blur="checkWxKeyword(item,rid,$event)"/>
                                    <span class="input-group-btn">
                                   <button class="btn btn-default" type="button"
                                           @click="removeKeywordItem(key)">删除</button>
                                </span>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="panel-footer advFooter">
                        <button type="button" class="btn btn-default" @click="addKeywordItem()">添加包含关键字</button>
                        <div v-html="help"></div>
                    </div>
                </div>
            </div>
        </div>
        <textarea name="hdcms_wechat_keyword" hidden>@@{{rule}}</textarea>
    </div>
    <div class="panel-footer">
        <span class="text-danger">
            如果其他模块使用了关键词，关键词将被忽略
        </span>
    </div>
</div>

<style>
    /*表情选择框*/
    .popover {
        max-width: none;
    }

    .row {
        margin-right: 0px;
        margin-left: 0px;
    }
</style>
<script type="application/ecmascript">
    require(['vue', 'hdjs', 'resource/js/hdcms.js'], function (Vue, hdjs, hdcms) {
        new Vue({
            el: '#hdcmsRuleKeywordForm',
            data: {
                //规则编号
                rid:<?php echo q('get.rid', 0)?>,
                //当前操作的关键词类型
                currentKeyType: 'contain',
                footer: {
                    contain: '<span class="help-block"> 用户进行交谈时，对话中包含上述关键字就执行这条规则。</span>',
                    regexp: '<span class="help-block">用户进行交谈时，对话内容符合述关键字中定义的模式才会执行这条规则。' +
                    '<br><strong>注意：如果你不明白正则表达式的工作方式，请不要使用正则匹配</strong> ' +
                    '<br><strong>注意：正则匹配使用MySQL的匹配引擎，请使用MySQL的正则语法</strong> ' +
                    '<br><strong>示例: </strong><br><em>^微信</em>匹配以“微信”开头的语句' +
                    '<br><em>微信$</em>匹配以“微信”结尾的语句<br><em>^微信$</em>匹配等同“微信”的语句' +
                    '<br><em>微信</em>匹配包含“微信”的语句<br><em>[0-9.-]</em>匹配所有的数字，句号和减号' +
                    '<br><em>^[a-zA-Z_]$</em>所有的字母和下划线<br><em>^[[:alpha:]]{3}$</em>所有的3个字母的单词' +
                    '<br><em>^a{4}$</em>aaaa<br><em>^a{2,4}$</em>aa，aaa或aaaa<br><em>^a{2,}$</em>匹配多于两个a的字符串</span>',
                },
                rule: <?php echo $rule ? json_encode($rule)
                : old('hdcms_wechat_keyword', "{name: '', rank: 0, status: 1, keyword: [{content: '', type: 1}]}");?>,
                //高级设置
                advSetting: false,
                //高级触发
                advancedTriggering: false
            },
            mounted() {
                //选择表情用于触发关键字
                hdjs.emotion({btn: '#keywordEmotion', input: '#keywordInput',
                    callback: function () {
                        console.log('选择表情后的执行的回调函数');
                    }});
                //编辑时如果不存在基本触发关键词时添加
                var hasBaseKeyword = false;
                for (let i in this.rule.keyword) {
                    if (this.rule.keyword[i].type == 1) {
                        hasBaseKeyword = true;
                    }
                }
                if (hasBaseKeyword == false) {
                    this.rule.keyword.push({content: '', type: 1});
                }
            },
            computed: {
                help: function () {
                    return this.footer[this.currentKeyType];
                }
            },
            methods: {
                //添加关键词
                addKeywordItem: function () {
                    var item = '';
                    switch (this.currentKeyType) {
                        case 'contain':
                            item = {content: '', type: 2, edited: true};
                            break;
                        case 'regexp':
                            item = {content: '', type: 3, edited: true};
                            break;
                    }
                    if (item) {
                        this.rule.keyword.push(item);
                    }
                },
                //删除关键词
                removeKeywordItem: function (index) {
                    this.rule.keyword.splice(index, 1);
                },
                //检测关键词是否已经使用
                checkWxKeyword: function (item, rid, e) {
                    var obj = $(e.target);
                    hdcms.checkWxKeyword(item.content, rid, function (res) {
                        if (res.valid == 0) {
                            hdjs.message(res.message);
                        }
                    })
                }
            }
        })
    });
</script>