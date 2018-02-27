<div class="panel panel-default" id="baseVue" v-cloak="">
    <div class="panel-heading">
        回复内容
    </div>
    <ul class="list-group">
        <li class="list-group-item row" v-for="(item,key) in content">
            <div class="col-xs-12">
                <textarea class="form-control" rows="3" v-model="item.content"
                          v-show="!item.saved"></textarea>
                <p v-html="item.content" v-show="item.saved"></p>
                <p class="help-block" v-show="!item.saved">
                    您还可以使用表情和链接。
                    <a href="javascript:;" class="text-danger emotionLink" :index="key">
                        <i class="fa fa-github-alt"></i> 表情
                    </a>
                </p>
            </div>
            <div class="col-xs-12">
                <div class="btn-group pull-right">
                    <button type="button" class="btn btn-default" @click="saveContentItem(item)"
                            v-html="item.saved?'编辑':'保存'">
                    </button>
                    <button type="button" class="btn btn-default" @click="removeContentItem(key);">
                        删除
                    </button>
                </div>
            </div>
        </li>
    </ul>
    <div class="panel-footer clearfix">
        <button class="btn btn-default" type="button" @click="addContentItem();">添加回复条目</button>
        <span class="help-block">添加多条回复内容时, 随机回复其中一条</span>
        <textarea name="content" v-html="content" hidden></textarea>
    </div>
</div>
<script type="application/ecmascript">
    require(['vue', 'hdjs', 'resource/js/hdcms.js'], function (Vue, hdjs, hdcms) {
        var ve = new Vue({
            el: '#baseVue',
            data: {
                content: <?php echo $contents;?>
            },
            mounted: function () {
                this.emotion();
            },
            updated:function(){
                this.emotion();
            },
            methods: {
                emotion:function(){
                    var This = this;
                    //表情选择动作设置
                    $('.emotionLink').each(function () {
                        hdjs.emotion({
                            btn: this,
                            input: $(this).parents('div').eq(0).find('textarea')[0],
                            callback: function (con, btn, input) {
                                var index = $(btn).attr('index');
                                This.content[index].content = $(input).val();
                            }
                        });
                    });
                },
                saveContentItem: function (item) {
                    item.saved = !item.saved;
                },
                addContentItem: function () {
                    this.content.push({content: '', saved: false});
                },
                removeContentItem: function (index) {
                    this.content.splice(index, 1);
                }
            }
        });
    });
</script>