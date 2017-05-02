define(['bootstrap'], function () {
    return {
        change: function () {
            $('body').css({'backgroundColor': 'red'});
        },
        show: function () {
            alert('后盾人')
        },
        message: function () {
            alert('houdunren.com')
        }
    }
});