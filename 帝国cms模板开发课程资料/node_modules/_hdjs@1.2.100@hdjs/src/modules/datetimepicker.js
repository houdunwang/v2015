//日期时间选择
import datetimepicker from 'jquery-datetimepicker'
import 'jquery-datetimepicker/build/jquery.datetimepicker.min.css'
export default (el) => {
    jQuery.datetimepicker.setLocale('zh');
    return jQuery(el);
}