import daterangepicker from 'bootstrap-daterangepicker'
import moment from 'moment'
import 'bootstrap-daterangepicker/daterangepicker.css'

export default (options) => {
    var options = Object.assign({
        //自动关闭,有timePicker属性时无效
        // "autoApply": true,
        "locale": {
            "format": "YYYY/MM/DD",//YYYY/MM/DD H:m
            "separator": " 至 ",
            "applyLabel": "确定",
            "cancelLabel": "取消",
            "fromLabel": "From",
            "daysOfWeek": [
                "日", "一", "二", "三", "四", "五", "六"
            ],
            "monthNames": [
                "一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"
            ],
            "firstDay": 0
        },
    }, options);
    $(options.element).daterangepicker(options, function (start, end, label) {
        if (options.callback) {
            options.callback(start, end, label)
        }
    });
}