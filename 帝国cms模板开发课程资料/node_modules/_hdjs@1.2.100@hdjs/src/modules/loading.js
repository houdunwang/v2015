//加载动画
export default (opt) => {
    var modalobj = $('#modal-loading');
    if (modalobj.length == 0) {
        $(document.body).append('<div id="modal-loading" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"></div>');
        modalobj = $('#modal-loading');
        var html =
            '<div class="modal-dialog" style="position: absolute;top:30%;left:35%;">' +
            '	<div style="text-align:center; background-color: transparent;">' +
            '     <i class="fa fa-spinner fa-spin fa-4x fa-fw" style="font-size: 5em;"></i>' +
            '	</div>' +
            '</div>';
        modalobj.html(html);
    }
    modalobj.modal('show');
    modalobj.next().css('z-index', 999999);
    return modalobj;
}