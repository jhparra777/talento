<div class="modal-header">
    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
        <span aria-hidden="true">
            ×
        </span>
    </button>
    <h4 class="modal-title">
        Editar Cargo Genérico
    </h4>
</div>
<div class="modal-body">
    {!! Form::model($registro,["id"=>"fr_cargos_genericos","method"=>"POST"]) !!}
        {!! Form::hidden("id") !!}
    <div class="row">
        <div class="col-md-12 form-group">
            <label class="col-sm-2 control-label" for="inputEmail3">
                Nombre del Cargo:
            </label>
            <div class="col-sm-10">
                {!! Form::text("descripcion",null,["class"=>"form-control","placeholder"=>"descripcion" ]); !!}
            </div>
            <p class="error text-danger direction-botones-center">
                {!! FuncionesGlobales::getErrorData("descripcion",$errors) !!}
            </p>
        </div>
        <div class="col-md-12 form-group">
            <label class="col-sm-2 control-label" for="inputEmail3">
                Estado:
            </label>
            <div class="col-sm-10">
                {!! Form::select("estado",[""=>"Seleccionar","1"=>"Activo","0"=>"Inactivo"],null,["class"=>"form-control" ]); !!}
            </div>
            <p class="error text-danger direction-botones-center">
                {!! FuncionesGlobales::getErrorData("estado",$errors) !!}
            </p>
        </div>
        <div class="col-md-12 form-group">
            <label class="col-sm-2 control-label" for="inputEmail3">
                Categoría:
            </label>
            <div class="col-sm-10">
                {!! Form::select("tipo_cargo_id",$tiposCargos,null,["class"=>"form-control","placeholder"=>"tipo_cargo_id" ]); !!}
            </div>
            <p class="error text-danger direction-botones-center">
                {!! FuncionesGlobales::getErrorData("tipo_cargo_id",$errors) !!}
            </p>
        </div>
    </div>
    {!! Form::close() !!}
</div>
<div class="modal-footer">
    <button class="btn btn-default" data-dismiss="modal" type="button">
        <i class="fa fa-close">
        </i>
        Cerrar
    </button>
    <button class="btn btn-success" id="btn-actualizar" type="button">
        <i class="fa fa-check">
        </i>
        Actualizar
    </button>
</div>
<script>
    $(function(){
        
        /**
         * Actualizar cargo generico
         **/
        $("#btn-actualizar").on('click', function(){
            var formData = new FormData(document.getElementById("fr_cargos_genericos"));
            $.ajax({
                url: "{{ route('admin.cargos_genericos.actualizar') }}",
                type: 'POST',
                data: $("#fr_cargos_genericos").serialize(),
                beforeSend: function(){
                    //imagen de carga
                    $.blockUI({
                        message: '<img src="https://ecuadortoday.media/wp-content/uploads/2018/05/1car-loading-2.gif">',
                        css: {
                            border: "0",
                            background: "transparent"
                        },
                        overlayCSS:  {
                            backgroundColor: "#fff",
                            opacity:         0.6,
                            cursor:          "wait"
                        }
                    });
                },
                success: function(response){
                    $.unblockUI();
                    $("#modal_gr").modal('toggle');
                    swal("Bien","Cargo generico actualizado","success");
                    setTimeout('document.location.reload()',4000);
                    location.reload();
                }
            });
        });
    })
</script>
