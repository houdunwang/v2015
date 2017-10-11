import Message from './message'

export default (option) => {
    option = Object.assign({
        //后台发送地址
        url: '',
        //发送间隔时间
        timeout: 60,
    }, option);

    //上次发送的时间
    let obj = {
        //按钮
        el: $(option.el),
        //定时器编号
        intervalId: 0,
        //初始化
        init: function () {
            let This = this;
            this.el.on('click', () => {
                This.send();
            })
            this.update();
        },

        //更改状态
        update: function () {
            var This = this;
            This.intervalId = setInterval(function () {
                if (This.getWaitTime() > option.timeout) {
                    clearInterval(This.intervalId);
                    This.el.removeAttr('disabled').text('发送验证码');
                } else {
                    let diff = option.timeout - This.getWaitTime();
                    This.el.text(diff + "秒后再发送").attr('disabled', 'disabled');
                }
            }, 100);
        },

        //发送验证码
        send: function () {
            var This = this;
            var username = $.trim($(option.input).val());
            //验证手机号或邮箱
            if (!/^\d{11}$/.test(username) && !/^.+@.+$/.test(username)) {
                Message('帐号格式错误', '', 'info');
                return;
            }
            This.setSendTime();
            $.post(option.url, {username: username}, function (response) {
                Message(response.message);
                if (response.valid == 1) {
                    This.setSendTime();
                    This.update();
                }
            }, 'json');
        },
        //获取发送间隔时间
        getWaitTime: () => {
            let time = localStorage.getItem('validCodeSendTime');
            let diff = $.now() * 1 - (time * 1);
            return Math.floor(diff / 1000)
        },
        //设置间隔时间
        setSendTime: () => {
            localStorage.setItem('validCodeSendTime', $.now());
        },
    }
    obj.init();
}