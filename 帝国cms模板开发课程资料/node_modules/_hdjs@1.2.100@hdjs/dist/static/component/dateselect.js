//日期时间选择
define(['moment'], function (moment) {
    return function (elem, val) {
        val = val ? val : {};
        $(elem.year).append("<option value=''>年</option>");
        for (var i = 2019; i >= 1915; i--) {
            $(elem.year).append("<option value='" + i + "'>" + i + "</option>");
        }
        //处理年
        if (val.year > 0) {
            $(elem.year).val(val.year);
        }
        readerMonth(elem, val);
        if (val.month > 0) {
            $(elem.month).val(val.month);
        }
        $(elem.year).change(function () {
            readerMonth(elem, val);
        })

        //渲染月
        function readerMonth(elem, val) {
            elem.month.options.length = 0;
            $(elem.month).append("<option value=''>月</option>");
            for (var i = 1; i <= 12; i++) {
                $(elem.month).append("<option value='" + i + "'>" + i + "</option>");
            }
            if (val.day > 0) {
                $(elem.day).val(val.day);
            }
            readerDay(elem, val);
            $(elem.month).change(function () {
                readerDay(elem, val);
            })
        }

        //渲染日
        function readerDay(elem, val) {
            if (elem.day) {
                var dayNum = moment($(elem.year).val() + "-" + $(elem.month).val(), "YYYY-MM").daysInMonth();
                elem.day.options.length = 0;
                $(elem.day).append("<option value=''>日</option>");
                for (var i = 1; i <= dayNum; i++) {
                    elem.day.options.add(new Option(i, i));
                }
                if (val.day > 0) {
                    $(elem.day).val(val.day);
                }
            }
        }
    }
})
