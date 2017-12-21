//图片预览
import Modal from './modal'

export default (url, option) => {
    var option = option ? option : {};
    var opt = Object.assign({
        title: '图片预览',
        width: 700,
        height: 500,
        content: '<div style="text-align: center">' +
        '<img style="max-width: 100%;" src="' + url + '"/>' +
        '</div>'
    }, option)
    Modal(opt)
}