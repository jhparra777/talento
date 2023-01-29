<div class="modal-header">
    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
        <span aria-hidden="true">×</span>
    </button>

    <h4 class="modal-title">Carga de soporte {{$tipo}}</h4>
</div>

<div class="modal-body">
  {!! Form::model(Request::all(),["id" => "fr_soportes", "files" => true]) !!}
        <div class="modal-body">
            {!! Form::hidden("ref_id",$referencia) !!}
            {!! Form::hidden("id_visita",$id_visita) !!}
            {!! Form::hidden("tipo_soporte",$tipo) !!}
            <input type="hidden" name="cand_id" id="cand_id" value="{{$cand_id}}">

            

            <div class="col-md-12 form-group">
                <label for="inputEmail3" class="col-sm-4 control-label"> Archivos</label>

                <div class="col-sm-8">
                    {!! Form::file("archivo_documento[]", ["class" => "form-control", "accept" => ".png,.jpg,.jpeg","multiple"=>true,"required"=>true]); !!}
                    <p><b>Archivos permitidos:</b> png, jpg y jpeg</p>
                </div>
                <p id="error_tipo" style="color: red;text-align: center;"></p>

            </div>

            <div class="clearfix"></div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-success"  id="guardar_soporte">Guardar</button>
        </div>
    {!! Form::close() !!}

<script>
    $(function(){
       $("#guardar_soporte").on("click", function(){
            var formData = new FormData(document.getElementById("fr_soportes"));

        if($('#fr_soportes').smkValidate()){
            $.ajax({
                url: "{{route('admin.visita.guardar_soporte')}}",
                type: "post",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            }).done(function (res) {
                var success = JSON.parse(res);
                
                if(success.success == false){
                    
                }
                else{
                    $("#modal_gr").modal("hide");
                    $.smkAlert({
                            text: success.num_soportes+' Soportes guardados con exito',

                            type: 'success',
                            position:'top-right',
                            time:3
                    });
                }
            });
        }
        })
    })
</script>

</div>