<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Detalle Rol</h4>
</div>
<div class="modal-body">
    <div class="row">
        <form action="{{ route('admin.actualizar_rol') }}" id="frm_usuarios" method="POST" autocomplete="off">
            <input type="hidden" name="id" value="{{ $rol->id }}">
 
            <div class="col-md-12 form-group">
                <label class="control-label">Nombre</label>

                <input type="text" name="name" value="{{ $rol->name }}" class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" readonly>
            </div>

            <div class="col-md-12">
                <h4>Permisos </h4>

                {{-- <div class="checkbox" hidden>
                    <label>
                        <input type="checkbox" name="seleccionar_todos_admin" id="seleccionar_todos_admin"> Seleccionar todos
                    </label>
                </div> --}}
            </div>

            <div class="col-md-12">
                {!! FuncionesGlobales::getPermisosAdminModal(0, $rol->permissions, true) !!}
            </div>
        </form>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-200" data-dismiss="modal">Cerrar</button>
</div>