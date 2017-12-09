/**
 * 前台手机端顶部栏目菜单控制
 * 用于显示文章系统的子栏目
 */
$(function () {
    $(".cat_menu_list").click(function () {
        if ($(".child_menu_list:hidden").length) {
            $(".child_menu_list").slideDown('fast');
            $('.head-bg-gray').show();
        } else {
            $(".child_menu_list").slideUp('fast');
            $('.head-bg-gray').hide();
        }
    });
    $(".head-bg-gray").click(function () {
        $('.child_menu_list').hide();
        $('.head-bg-gray').hide();
    })
});
