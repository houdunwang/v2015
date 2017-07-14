<div id="flash-overlay-modal" class="modal fade {{ $modalClass or '' }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>

                <h4 class="modal-title">后盾人 - 友情提示</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">
                        <i class="fa fa-info-circle fa-4x"></i>
                    </div>
                    <div class="col-sm-9">
                        {!! $body !!}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
<script>
    require(['bootstrap'],function($){
        setTimeout(function(){
            $('#flash-overlay-modal').modal('hide');
        },3000);
    })
</script>
