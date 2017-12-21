//图表
define(['https://cdn.bootcss.com/Chart.js/2.7.1/Chart.min.js','lodash'], function (Chart,_) {
    return function (el, opt) {
        var options = _.assign({}, opt);
        return new Chart($(el), options);
    }
})