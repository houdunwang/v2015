//剪贴板
import Clipboard from 'clipboard'
export default (elem, options) => {
    return new Clipboard(elem, options);
}