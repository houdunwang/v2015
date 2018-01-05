<extend file="resource/view/system"/>
<block name="content">
    <ol class="breadcrumb">
        <li><i class="fa fa-home"></i></li>
        <li><a href="?s=system/manage/menu">系统</a></li>
        <li class="active">模块数据表管理</li>
    </ol>
    <ul class="nav nav-tabs">
        <li role="presentation"><a href="{!! u('module.installed') !!}">已经安装模块</a></li>
        <li role="presentation"><a href="?s=system/module/prepared">安装模块</a></li>
        <li role="presentation"><a href="?s=system/module/design">设计新模块</a></li>
        <li role="presentation"><a href="{!! u('shop.lists',['type'=>'module']) !!}">模块商城</a></li>
        <li role="presentation"><a href="{!! u('shop.upgradeLists') !!}">模块更新</a></li>
        <li role="presentation" class="active"><a href="#">数据表管理</a></li>
    </ul>
    <form class="form-horizontal" id="app">
        <div class="alert alert-info">
            1. 请查看 <a href="http://doc.hdphp.com/215684#_12" target="_blank">数据迁移文档</a> 学习使用方法 <br>
            2. 请查看 <a href="http://doc.hdphp.com/217074" target="_blank">数据填充文档</a> 学习使用方法 <br>
            3. 迁移文件在安装或卸载模块时执行<br/>
            4. 填充文件用于开发时测试使用，安装模块时不会执行<br/>
            5. 表名称设置规则：如我们的模块是shop 现在要创建表 hd_shop_user，我们只需要填写 user 系统会自动补上 hd_shop <br>
            6. 迁移重置会执行所有迁移文件的down方法 <br>
            7. 迁移回滚只执行最近一次的迁移文件的down方法 <br>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">数据迁移</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">表名称</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="migrate_table">
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <div class="btn-group col-sm-offset-2" role="group" aria-label="...">
                    <button type="button" class="btn btn-default" @click="createMigrate">创建新表迁移文件</button>
                    <button type="button" class="btn btn-default" @click="fieldMigrate">创建字段维护迁移文件</button>
                    <button type="button" class="btn btn-default" @click="makeMigrate">执行迁移</button>
                    <button type="button" class="btn btn-default" @click="resetMigrate">迁移重置</button>
                    <button type="button" class="btn btn-default" @click="resetRollback">迁移回滚</button>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">数据填充</h3>
            </div>
            <div class="panel-body table-responsive">
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">表名称</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" v-model="seed_table">
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <div class="btn-group col-sm-offset-2" role="group" aria-label="...">
                    <button type="button" class="btn btn-default" @click="createSeed">创建填充文件</button>
                    <button type="button" class="btn btn-default" @click="makeSeed">执行数据填充</button>
                    <button type="button" class="btn btn-default" @click="resetSeed">填充重置</button>
                </div>
            </div>
        </div>
        <textarea name="data" v-html="$data" hidden></textarea>
    </form>
    <script>
        require(['vue', 'hdjs'], function (Vue, hdjs) {
            var vm = new Vue({
                el: "#app",
                data: {
                    'migrate_table': '',
                    'seed_table': '',
                },
                methods: {
                    //创建新表迁移文件
                    createMigrate: function () {
                        hdjs.submit({url: "{!! u('createMigrate',[name=>$_GET['name']]) !!}", successUrl: ''})
                    },
                    //创建字段迁移文件
                    fieldMigrate: function () {
                        hdjs.submit({url: "{!! u('fieldMigrate',[name=>$_GET['name']]) !!}", successUrl: ''})
                    },
                    makeMigrate: function () {
                        hdjs.confirm('确定执行迁移文件吗?',function() {
                            hdjs.submit({url: "{!! u('makeMigrate',[name=>$_GET['name']]) !!}", successUrl: ''})
                        })
                    },
                    resetMigrate: function () {
                        hdjs.confirm('确定执行迁移重置吗?',function() {
                            hdjs.submit({url: "{!! u('resetMigrate',[name=>$_GET['name']]) !!}", successUrl: ''})
                        })
                    },
                    resetRollback: function () {
                        hdjs.confirm('确定执行迁移会滚吗?',function(){
                        hdjs.submit({url: "{!! u('rollbackMigrate',[name=>$_GET['name']]) !!}", successUrl: ''})
                        })
                    },
                    createSeed: function () {
                        hdjs.submit({url: "{!! u('createSeed',[name=>$_GET['name']]) !!}", successUrl: ''})
                    },
                    makeSeed: function () {
                        hdjs.confirm('确定执行数据填充吗?',function() {
                            hdjs.submit({url: "{!! u('makeSeed',[name=>$_GET['name']]) !!}", successUrl: ''})
                        });
                    },
                    resetSeed: function () {
                        hdjs.confirm('确定执行填充重置吗?',function() {
                            hdjs.submit({url: "{!! u('resetSeed',[name=>$_GET['name']]) !!}", successUrl: ''})
                        });
                    }
                }
            })
        })

    </script>
</block>
