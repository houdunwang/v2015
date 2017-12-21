//光标定位
import caret from 'jquery-caret'

export default (el, pos) => {
    return pos?$(el).caret(pos):$(el).caret();
}