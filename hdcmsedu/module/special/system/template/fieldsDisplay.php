<div class="panel panel-default">
    <div class="panel-heading">
        回复内容
    </div>
    <ul class="list-group">
        <li class="list-group-item row" ng-repeat="value in content" ng-init="initEmotion(this)">
            <div class="col-xs-12">
                <textarea class="form-control" rows="3" id="aa3" ng-model="value.content"
                          ng-show="!value.saved"></textarea>
                <p ng-bind="value.content" ng-show="value.saved"></p>
                <p class="help-block" ng-show="!value.saved">
                    您还可以使用表情和链接。
                    <a href="javascript:;" class="text-danger emotionLink">
                        <i class="fa fa-github-alt"></i> 表情
                    </a>
                </p>
            </div>
            <div class="col-xs-12">
                <div class="btn-group pull-right">
                    <button type="button" class="btn btn-default" ng-click="saveContentItem(value)">
                        @{{value.saved?'编辑':'保存'}}
                    </button>
                    <button type="button" class="btn btn-default"
                            ng-click="removeContentItem(value);">删除
                    </button>
                </div>
            </div>
        </li>
    </ul>
    <div class="panel-footer clearfix">
        <button class="btn btn-default" type="button" ng-click="addContentItem();">添加回复条目</button>
        <span class="help-block">添加多条回复内容时, 随机回复其中一条</span>
        <input type="hidden" name="content">
    </div>
</div>
<script>
    //模块控制器
    function moduleController($scope, _) {
        $scope.content = <?php echo $contents;?>;
        angular.forEach($scope.content, function (v, k) {
            $scope.content[k].saved = true;
        });

        //添加表情
        $scope.initEmotion = function (obj) {
            var item = $('.emotionLink').eq(obj.$index);
            hdjs.emotion({
                btn: item[0],
                input: item.parents('div').eq(0).find('textarea')[0],
                callback: function (con, btn, input) {
                    obj.value.content = $(input).val();
                    $scope.$apply();
                }
            });
        }
        if ($scope.content.length == 0) {
            $scope.content = [{content: ''}];
        }
        $scope.saveContentItem = function (item) {
            item.saved = !item.saved;
        }
        $scope.addContentItem = function () {
            $scope.content.push({content: '', saved: false});
        }
        $scope.removeContentItem = function (item) {
            $scope.content = _.without($scope.content, item);
        }
    }

    //验证表单
    function validateForm(form, $, $scope, hdjs, _) {
        var val = [];
        angular.forEach($scope.content, function (v, k) {
            if ($.trim(v.content) != '') {
                this.push(v)
            }
        }, val);
        if (val.length == 0) {
            hdjs.message('请输入回复内容');
            return false;
        }
        val = angular.toJson(val);
        $("[name='content']").val(val);
        return true;
    }
</script>