<div class="modal-header">
    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
        <span aria-hidden="true">
            ×
        </span>
    </button>

    <h4 class="modal-title" style="color: black;">
        Carga de documento
    </h4>
</div>

<div class="modal-body">
	{!! Form::model(Request::all(), ["id" => "fr_nuevo_documento_contratacion", "files" => true]) !!}
        <div class="modal-body">
            {!! Form::hidden("ref_id") !!}

            <div class="col-md-6 form-group">
                <label for="inputEmail3" class="control-label" style="color: black;" > Tipo documento</label>
                
                    {!! Form::select("tipo_documento_id", $tipo_documento, null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "tipo_documento_id", "required"=>"required"]); !!}
                
                <p class="error text-danger direction-botones-center tipo_documento_id">{!! FuncionesGlobales::getErrorData("tipo_documento_id", $errors) !!}</p>
            </div>

            {{--
                <div class="col-md-12 form-group">
                    <label for="inputEmail3" class="col-sm-4 control-label" style="color: black;" > Puntaje</label>
                    
                    <div class="col-sm-8">
                        {!! Form::text("puntaje",null,["class"=>"form-control"]); !!}
                    </div>
                    
                    <p class="error text-danger direction-botones-center">{! FuncionesGlobales::getErrorData("puntaje",$errors) !!}</p>
                </div>
            --}}
   
            <div class="col-md-6 form-group">
                <label for="inputEmail3" class="control-label" style="color: black;">Archivo</label>
                

                    {!! Form::file("archivo_documento", ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "required"=>"required"]); !!}

                 <p class="error text-danger direction-botones-center archivo_documento">@if ($errors->has('archivo_documento'))
                     {{ $errors->first('archivo_documento') }}
                    @endif</p>
            </div>

             <div class="col-md-12 form-group">
                <label for="inputEmail3" class="control-label" style="color: black;" > Descripción</label>
                

                    {!! Form::textarea("descripcion_archivo",null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "descripcion_archivo"]); !!}
            
                
                <p class="error text-danger direction-botones-center descripcion_archivo">{!! FuncionesGlobales::getErrorData("descripcion_archivo", $errors) !!}</p>
            </div>


            <div class="clearfix"></div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-success"  id="guardar_nuevo">Guardar</button>
        </div>

        <script>
            $(function() {
                $(document).on("change","#tipo_documento_id",function() {
                    $("#descripcion_archivo").val($("#tipo_documento_id").find("option:selected").text())
                })
            })

            $('#guardar_nuevo').on("click", function() {
                event.preventDefault()

                if ($('#fr_nuevo_documento_contratacion').smkValidate()) {
                    $('#guardar_nuevo').hide()

                    let formData = new FormData(document.getElementById("fr_nuevo_documento_contratacion"));

                    $.ajax({
                        type: "POST",
                        data: formData,
                        url: "{{ route('guardar_documento') }}",
                        cache: false,
                        contentType: false,
                        processData: false,
                        beforeSend: function(){
                            $.smkAlert({
                                text: 'Guardando los datos.',
                                type: 'info'
                            })
                        },
                        error: function(response){
                            if(response.status == 500) {
                                swal("Aviso", "Ha ocurrido un error, intenta nuevamente", "error", {
                                    button: {
                                        text: "Cerrar",
                                        closeModal: true,
                                    },
                                    animation: false
                                })
                            }else {
                                let errors = response.responseJSON.errors

                                for (const key in errors) {
                                    document.querySelector(`.${key}`).textContent = errors[key][0]
                                }

                                $('#guardar_nuevo').show()
                            }
                        },
                        success: function(response){
                            if(response.success) {
                                $.smkAlert({
                                    text: 'Datos guardados correctamente!',
                                    type: 'success'
                                })
                                
                                setTimeout(function(){
                                    window.location.href = '{{ route("admin.carga_archivos_contratacion") }}';
                                }, 2500);
                            } else {
                                $.smkAlert({
                                    text: response.mensaje,
                                    type: 'danger'
                                })

                                $('#guardar_nuevo').show()
                            }
                        }
                    })
                }
            })
        </script>
    {!! Form::close() !!}
</div>