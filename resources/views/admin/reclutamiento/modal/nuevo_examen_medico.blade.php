<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    @if ($sitio_modulo->salud_ocupacional != 'si')
        <h4 class="modal-title"><span id="desc_tipo_doc"></span></h4>
    @else
        <h4 class="modal-title">Resultado Examen Médico</h4>
    @endif
</div>
<div class="modal-body">
    {!! Form::model(Request::all(), ["id" => "fr_documento_verificado", "data-smk-icon" => "glyphicon-remove-sign"]) !!}
        {!! Form::hidden("ref_id") !!}

        {!! Form::hidden("orden", $orden) !!}
        
        @if ($sitio_modulo->salud_ocupacional != 'si')
            <div class="form-group">
                <label for="tipo" class="control-label">
                    Tipo resultado:<span class='text-danger'>*</span>
                </label>

                {!! Form::select("tipo", $tipoDocumento, null, ["class" => "form-control", "id" => "tipo", "required" => "required"]) !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo", $errors) !!}</p>
        @else
            {!! Form::hidden("tipo", $tipo) !!}
            {!! Form::hidden("edit", $edit) !!}
        @endif

        <div class="form-group">
            <label for="archivo_documento" class="control-label">
                Archivo Documento:<span class='text-danger'>*</span>
            </label>

            {!! Form::file("archivo_documento", [
                "class" => "form-control",
                "placeholder" => "Archivo Documento",
                "required" => "required"
            ]) !!}
        </div>
        
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("archivo_documento", $errors) !!}</p>

        <div class="form-group">
            <label for="fecha_realizacion" class="control-label">Fecha realización: <span class="text-danger">*</span></label>

            {!! Form::text("fecha_realizacion",null,["class"=>"form-control", "id"=>"fecha_realizacion" ,"placeholder"=>"Fecha realización" ]) !!}
        </div>

        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_realizacion", $errors) !!}</p>

        <div class="form-group">
            <label for="resultado" class="control-label">
                Resultado:<span class='text-danger'>*</span>
            </label>

            {!! Form::select("resultado",$resultados, null, ["class" => "form-control", "id" => "resultado", "required" => "required"]) !!}
        </div>

        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("resultado", $errors) !!}</p>

        @if ($sitio_modulo->salud_ocupacional == 'si')
            <div class="form-group" id="bloque_motivo">
                <label for="motivo" class="control-label">
                    Motivo:<span class='text-danger'>*</span>
                </label>

                {!! Form::select("motivo",$motivos_no_continua, null, ["class" => "form-control", "id" => "motivo"]) !!}
            </div>

            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("motivo", $errors) !!}</p>
        @endif

        <div class="form-group">
            <label for="obrservacion" class="control-label">
                Observación:<span class='text-danger'>*</span>
            </label>
            {{-- {!! Form::textarea("observacion", null, ["class" => "form-control", "id" => "textarea", "rows" => "4"]); !!} --}}

            <div id="observacion" style="background-color: white;"></div>
        </div>

        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observacion", $errors) !!}</p>

    {!! Form::close() !!}

    <div class="clearfix"></div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-success" id="guardar_examen_medico" >Guardar</button>
</div>

<script>
    $(function () {
        $('#observacion').trumbowyg({
            lang: 'es',
            btns: [
                //['viewHTML'],
                ['undo', 'redo'],
                //['formatting'],
                ['strong' /*'em', 'del'*/],
                //['superscript', 'subscript'],
                //['link'],
                //['insertImage'],
                //['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
                //['unorderedList', 'orderedList'],
                //['horizontalRule'],
                ['removeformat'],
                //['fullscreen']
            ],
            removeformatPasted: true,
            tagsToRemove: ['script', 'link']
        });

        var confDatepicker = {
            altFormat: "yy-mm-dd",
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true,
            buttonImage: "img/gifs/018.gif",
            buttonImageOnly: true,
            autoSize: true,
            dayNames: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
            monthNamesShort: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
            dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
            maxDate: '+0d',
            yearRange: "1930:2050"
        };
        
        $("#fecha_realizacion").datepicker(confDatepicker);

        $('#tipo').change(function(){
            $('#desc_tipo_doc').text($("#tipo option:selected").text() != 'Seleccionar' ? $("#tipo option:selected").text() : '');
        });

        @if ($sitio_modulo->salud_ocupacional == 'si')
            if ($('#resultado').val() != 9) {
                $("#bloque_motivo").hide();
            }

            $('#resultado').change(function(){
                if($(this).val()==9){
                    $("#bloque_motivo").show();
                }
                else{
                    $("#bloque_motivo").hide();
                }
            });
        @endif
    });
</script>