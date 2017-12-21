define([
    'moment',
    'https://cdn.bootcss.com/bootstrap-daterangepicker/2.1.25/daterangepicker.min.js',
    'css!https://cdn.bootcss.com/bootstrap-daterangepicker/2.1.25/daterangepicker.min.css'
], function (moment) {
    return function (param) {
        $('.reservation').daterangepicker({autoUpdateInput: false});
        var options = $.extend({
            autoUpdateInput: false,
            locale: {
                format: "YYYY/MM/DD",
                separator: " 至 ",
                applyLabel: "确定",
                cancelLabel: "取消",
                fromLabel: "From",
                customRangeLabel: '自定义区间',
                //是否显示第几周
                showWeekNumbers: true,
                "daysOfWeek": [
                    "日", "一", "二", "三", "四", "五", "六"
                ],
                "monthNames": [
                    "一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"
                ]
            },
            firstDay: 0
        }, param.options);
        $(param.element).daterangepicker(options, function (start, end, label) {
            var str = start.format('YYYY-MM-DD') + ' 至 ' + end.format('YYYY-MM-DD');
            $(param.element).val(str);
            if (param.callback) {
                param.callback(start, end, label)
            }
        });
    }
})