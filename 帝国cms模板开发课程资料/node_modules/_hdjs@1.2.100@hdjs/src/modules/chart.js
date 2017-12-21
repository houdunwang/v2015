//图表
import Chart from 'chart.js';

export default (el,opt) => {
    var options = Object.assign({}, opt);
    return new Chart($(el), options);
}