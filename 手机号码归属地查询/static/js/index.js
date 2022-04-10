$(function () {
    $('form').find('button[type=button]').click(function(){
        //获取用户输入的电话
        var phone = $('input[name=phone]').val();
        layer.load();
        $.post('api.php',{phone:phone},function(res){
            layer.closeAll('loading');
            if(res.status==1){
                    $('table').show();
                    $('#phone').text(phone);
                    $('#types').text(res.data.types);
                    $('#city').text(res.data.area);
                    $('#zip_code').text(res.data.zip_code);
                    $('#city_code').text(res.data.city_code);
            }else{
                $('table').hide();
                layer.alert(res.msg, {icon: 3});
            }
        },'json');
    })
})