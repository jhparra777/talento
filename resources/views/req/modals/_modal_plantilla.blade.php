{{-- <style type="text/css">
    .confirmacion{ background:#C6FFD5; border:1px solid green; }
    .negacion{ background:#ffcccc; border:1px solid red; }
</style> --}}

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <div class="modal-title">
        @yield("title")
    </div>
</div>

<div class="modal-body">
    @yield("body")
    <div class="clearfix"></div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-300" data-dismiss="modal">Cerrar</button>
    @yield("footer")  
</div>

{{-- @include("admin.reclutamiento.includes._scripts_contratacion") --}}