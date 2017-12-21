//生成二维码
import QRCode from 'qrcode'
export default (el, text) => {
    var canvas = $(el)[0];
    QRCode.toCanvas(canvas, text, function (error) {
        if (error) console.error(error)
    })
} 