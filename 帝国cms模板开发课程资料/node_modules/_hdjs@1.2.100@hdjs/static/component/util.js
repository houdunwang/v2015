//工具函数
define([
    'https://cdn.bootcss.com/spark-md5/3.0.0/spark-md5.min.js'
], function (md5) {
    return {
        //移动端检测
        isMobile: function () {
            var userAgentInfo = navigator.userAgent;
            var Agents = new Array("Android", "iPhone", "SymbianOS", "Windows Phone", "iPad", "iPod");
            var flag = false;
            for (var v = 0; v < Agents.length; v++) {
                if (userAgentInfo.indexOf(Agents[v]) > 0) {
                    flag = true;
                    break;
                }
            }
            return flag;
        },
        //md5加密
        md5: function (content) {
            return md5.hash(content);
        }
    }
})