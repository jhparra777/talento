<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

    <h4 class="modal-title">
        <b>Aspectos Relevantes</b><br>
        <b>Candidato</b> {{ $candidato->nombres." ".$candidato->primer_apellido." ".$candidato->segundo_apellido }} 
        | <b>{{$candidato->cod_tipo}}</b> {{$candidato->numero_id}}
    </h4>
</div>

<div class="modal-body">
    <div class="row">
        {!! Form::model(Request::all(), ["id" => "fr_aspectos_relevantes_evs", "data-smk-icon" => "fa fa-times-circle", "multiple" => true]) !!}
            {!! Form::hidden("id_evs", $candidato->id_evs, ["id" => "id_evs_fr"]) !!}
            {!! Form::hidden("req_cand_id", $candidato->req_cand_id, ["id" => "candidato_req_fr"]) !!}
            {!! Form::hidden("candidato_id", $candidato->candidato_id, ["id" => "candidato_fr"]) !!}
            {!! Form::hidden("requerimiento_id", $candidato->requerimiento_id, ["id" => "req_fr"]) !!}

            @if(!empty($candidato) && $candidato->tipo_evs->analisis_financiero == 'enabled')
                <div class="col-md-6 form-group">
                    <label for="aspecto_rel_analisis_financiero" class="control-label">Resultado análisis financiero </label>

                    {!! Form::text("aspecto_rel_analisis_financiero",$candidato->aspecto_rel_analisis_financiero,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "placeholder" => "Resultado aspecto relevante análisis financiero", "id" => "aspecto_rel_analisis_financiero"]); !!}
                </div>
            @endif
            @if(!empty($candidato) && $candidato->tipo_evs->consulta_antecedentes == 'enabled')
                <div class="col-md-6 form-group">
                    <label for="aspecto_rel_consulta_antecedentes" class="control-label">Resultado consulta antecedentes  </label>

                    {!! Form::text("aspecto_rel_consulta_antecedentes",$candidato->aspecto_rel_consulta_antecedentes,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "placeholder" => "Resultado aspecto relevante consulta antecedentes", "id" => "aspecto_rel_consulta_antecedentes"]); !!}
                </div>
            @endif
            @if(!empty($candidato) && $candidato->tipo_evs->referenciacion_academica == 'enabled')
                <div class="col-md-6 form-group">
                    <label for="aspecto_rel_referencia_academica" class="control-label">Resultado referenciación académica </label>

                    {!! Form::text("aspecto_rel_referencia_academica",$candidato->aspecto_rel_referencia_academica,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "placeholder" => "Resultado aspecto relevante referenciación académica", "id" => "aspecto_rel_referencia_academica"]); !!}
                </div>
            @endif
            @if(!empty($candidato) && $candidato->tipo_evs->referenciacion_laboral == 'enabled')
                <div class="col-md-6 form-group">
                    <label for="aspecto_rel_referencia_laboral" class="control-label">Resultado referenciación laboral </label>

                    {!! Form::text("aspecto_rel_referencia_laboral",$candidato->aspecto_rel_referencia_laboral,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "placeholder" => "Resultado aspecto relevante referenciación laboral", "id" => "aspecto_rel_referencia_laboral"]); !!}
                </div>
            @endif
            @if(!empty($candidato) && $candidato->tipo_evs->visita_domiciliaria == 'enabled')
                <div class="col-md-6 form-group">
                    <label for="aspecto_rel_visita_domiciliaria" class="control-label">Resultado visita domiciliaria </label>

                    {!! Form::text("aspecto_rel_visita_domiciliaria",$candidato->aspecto_rel_visita_domiciliaria,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "placeholder" => "Resultado aspecto relevante visita domiciliaria", "id" => "aspecto_rel_visita_domiciliaria"]); !!}
                </div>
            @endif
            <div class="col-md-6 form-group">
                <label for="add_otros_aspectos" class="control-label">Agregar otros aspectos relevantes </label>

                {!! Form::select('add_otros_aspectos', [0 => 'NO', 1 => 'SI'], (count($candidato->aspectos_relevantes) > 0 ? 1 : null), ['id'=>'add_otros_aspectos','class'=>'form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300']) !!}
            </div>
            <div class="add-otros-aspectos" {{(count($candidato->aspectos_relevantes) > 0 ? '' : 'hidden')}}>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <h4><b>Otros aspectos relevantes adicionales</b></h4>
                        </div>
                    </div>
                </div>
                <div id="otros_aspectos">
                    @if (count($candidato->aspectos_relevantes) > 0)
                        @foreach($candidato->aspectos_relevantes as $asp_rel)
                            <div class="row otros-aspectos-solicitud">
                                <div class="col-md-12">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Tipo <span class='text-danger sm-text-label'>*</span></label> <br>
                                            {!! Form::select("tipo_aspecto_relevante_id_$asp_rel->id", $tipos_aspectos_relevantes, $asp_rel->tipo_aspecto_relevante_id, ['id'=>'tipo_aspecto_relevante_id','class'=>'form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300', 'required']) !!}
                                        </div>
                                    </div>

                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Resultado: <span class='text-danger sm-text-label'>*</span></label>

                                           {!! Form::text("resultado_$asp_rel->id", $asp_rel->resultado,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "placeholder" => "Resultado aspecto relevante adicional", "id" => "resultado_aspecto_relevante", 'required']); !!}
                                        </div>
                                    </div>

                                    <div class="col-md-2 last-child">
                                        <button type="button" class="btn btn-danger rem-aspecto-rel-solicitud mt-2 | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-red">-</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="row otros-aspectos">
                            <div class="col-md-12">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Tipo <span class='text-danger sm-text-label'>*</span></label> <br>
                                        {!! Form::select('tipo_aspecto_relevante_id[]', $tipos_aspectos_relevantes, null, ['id'=>'tipo_aspecto_relevante_id','class'=>'form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300', 'required']) !!}
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Resultado: <span class='text-danger sm-text-label'>*</span></label>

                                       {!! Form::text("resultado[]",null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "placeholder" => "Resultado aspecto relevante adicional", "id" => "resultado_aspecto_relevante", 'required']); !!}
                                    </div>
                                </div>

                                <div class="col-md-2 last-child">
                                    <button type="button" class="btn btn-success add-aspecto-rel mt-2 | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green">+</button>
                                    <button type="button" class="btn btn-danger rem-aspecto-rel mt-2 | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-red">-</button>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="row otros-aspectos">
                            <div class="col-md-12">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Tipo <span class='text-danger sm-text-label'>*</span></label> <br>
                                        {!! Form::select('tipo_aspecto_relevante_id[]', $tipos_aspectos_relevantes, null, ['id'=>'tipo_aspecto_relevante_id','class'=>'form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300', 'required']) !!}
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Resultado: <span class='text-danger sm-text-label'>*</span></label>

                                       {!! Form::text("resultado[]",null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "placeholder" => "Resultado aspecto relevante adicional", "id" => "resultado_aspecto_relevante", 'required']); !!}
                                    </div>
                                </div>

                                <div class="col-md-2 last-child">
                                    <button type="button" class="btn btn-success add-aspecto-rel mt-2 | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green">+</button>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-300" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" id="guardar_aspectos_relevantes" >Guardar</button>
</div>

<script type="text/javascript">
    $(function () {
        $(document).on('click', '.add-aspecto-rel', function (e) {
            fila_nuevo_aspecto = $(this).parents('#otros_aspectos').find('.row.otros-aspectos').eq(0).clone();
            fila_nuevo_aspecto.find('select').val('');
            fila_nuevo_aspecto.find('input').val('');
            @if (count($candidato->aspectos_relevantes) == 0)
                fila_nuevo_aspecto.find('div.last-child').append('<button type="button" class="btn btn-danger rem-aspecto-rel mt-2 | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-red">-</button>');
            @endif

            $('#otros_aspectos').append(fila_nuevo_aspecto);
        });

        $(document).on('click', '.rem-aspecto-rel', function (e) {
            $(this).parents('.otros-aspectos').remove();
        });

        $(document).on('click', '.rem-aspecto-rel-solicitud', function (e) {
            $(this).parents('.otros-aspectos-solicitud').remove();
        });

        $('#add_otros_aspectos').change(function() {
            if ($('#add_otros_aspectos').val() == 0) {
                $('.add-otros-aspectos').hide();
                $('.add-otros-aspectos input').prop('required', false);
                $('.add-otros-aspectos select').prop('required', false);
            } else {
                $('.add-otros-aspectos').show();
                $('.add-otros-aspectos input').prop('required', true);
                $('.add-otros-aspectos select').prop('required', true);
            }
        })

        $('#add_otros_aspectos').trigger('change');

        $(document).on("click", "#guardar_aspectos_relevantes", function() {
            if ($('#fr_aspectos_relevantes_evs').smkValidate()) {
                $.ajax({
                    type: "POST",
                    data: $("#fr_aspectos_relevantes_evs").serialize(),
                    url: "{{ route('admin.guardar_aspectos_relevantes_evs') }}",
                    beforeSend: function(){
                        mensaje_success("Espere mientras se carga la información");
                    },
                    error: function(){
                        $("#modalTriLarge").modal('hide');
                        $("#modal_success").modal('hide');
                        mensaje_danger("Ha ocurrido un error. Verifique los datos.");
                    },
                    success: function(response){
                        if(response.success) {
                            $("#modalTriLarge").modal("hide");

                            mensaje_success("La información se ha guardado correctamente.");
                            setTimeout(function(){ location.reload(); }, 2000);
                        } else {
                            $("#modalTriLarge").modal('hide');
                            $("#modal_success").modal('hide');
                            mensaje_danger("Ha ocurrido un error. Intente nuevamente.");
                        }
                    }
                });
            }
        });
    });
</script>