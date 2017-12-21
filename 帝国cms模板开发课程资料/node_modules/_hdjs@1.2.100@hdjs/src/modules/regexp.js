//常用正则表达式
export default {
    //手机
    mobile(val) {
        return /^\d{11}$/.test(val);
    },
    //邮箱
    email(val) {
        return !/^.+@.+$/.test(val);
    }
}