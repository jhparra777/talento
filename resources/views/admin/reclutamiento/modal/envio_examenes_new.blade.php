<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

    <h4 class="modal-title">
        <b>Candidato</b> {{ $candidato->nombres." ".$candidato->primer_apellido." ".$candidato->segundo_apellido }} 
        | <b>{{$candidato->cod_tipo}}</b> {{$candidato->numero_id}}
    </h4>
</div>

<div class="modal-body">
    <div class="row">
        {!! Form::model(Request::all(), ["id" => "fr_enviar_examen", "data-smk-icon" => "fa fa-times-circle"]) !!}
            {!! Form::hidden("candidato_req", $candidato->req_candidato, ["id" => "candidato_req_fr"]) !!}
            {!! Form::hidden("cliente_id", null, ["id" => ""]) !!}
            {!! Form::hidden("lleva_ordenes", $lleva_ordenes, ["id" => "lleva_ordenes"]) !!}

            {{-- Omnisalud --}}
            @if ($sitio_modulo->omnisalud == 'enabled')
                @include('admin.reclutamiento.includes.envio-examenes._form_omnisalud')
            @endif

            @if($lleva_ordenes == 'si')
                <div id="ordenFields">
                    <div class="col-md-12 form-group">
                        <label for="proveedor" class="control-label">Proveedor de exámenes</label>

                        {!! Form::select("proveedor", $proveedores, null, [
                            "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                            "id" => "proveedor",
                            // "required" => "required",
                            "data-smk-msg" => "Debe seleccionar un laboratorio"
                        ]); !!}

                        <p id="proveedor_med_text" style="display: none;" class="error text-danger direction-botones-center">Selecciona proveedor</p>
                    </div>

                    <div class="col-md-12 form-group">
                        <label for="examen" class="control-label">Exámenes a realizar </label>

                        <div class="col-md-12">
                            @foreach($examenes as $examen)
                                <div class="col-sm-6">
                                    @if(in_array($examen->id,$cargo_especifico->examenes->pluck("id")->toArray())  || $examen->id == 1)
                                        <label style="font-weight:initial;">
                                            {!! Form::checkbox("examen[]", $examen->id, true, ["class"=> "examen", "style" => "margin:4px 4px 0;"]) !!} {{ $examen->nombre }}
                                        </label>
                                    @else
                                        <label style="font-weight:initial;">
                                            {!! Form::checkbox("examen[]", $examen->id, false, ["class" => "examen", "style" => "margin:4px 4px 0;"]) !!} {{ $examen->nombre }}
                                        </label>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-md-12 form-group">
                        <label for="observacion" class="control-label">Otros</label>

                        {!! Form::textarea("observacion", null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "observacion", "data-smk-msg" => "Escriba observación"]); !!}
                    </div>
                </div>
            @else
                <div id="ordenFields"></div>

                <div class="col-md-12">
                    Desea enviar a este candidato a exámenes médicos.
                </div>
            @endif

            <div class="col-md-12 form-group">
                <label for="observacion_candidato" class="control-label">Si deseas notificar al candidato, completa el siguiente campo.</label> <span class="small">Observación para el candidato:</span>

                {!! Form::textarea("observacion_candidato",null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "observacion_candidato","data-smk-msg"=>"Escriba observación para el candidato", "id" => "observacion_candidato", "rows" => 3]); !!}
            </div>
        {!! Form::close() !!}
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-300" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" id="guardar_examen" >Enviar</button>
</div>

<script>
    $(function(){
        $(".selectpicker").selectpicker()

        $("#fecha_inicio").datepicker(confDatepicker);
        $("#fecha_fin").datepicker(confDatepicker);
    });
</script>

<script>
    function cambiarLaboratorio(obj) {
        if (obj.checked) {
            document.querySelector('#omnisaludCampos').removeAttribute('hidden')

            document.querySelector('#tipo_admision_omnisalud').removeAttribute('disabled')
            document.querySelector('#examenes_omnisalud').removeAttribute('disabled')
            document.querySelector('#ciudad_omnisalud').removeAttribute('disabled')
            document.querySelector('#observacion_omnisalud').removeAttribute('disabled')

            document.querySelector('.bs-placeholder').classList.remove('disabled')
            document.querySelector('.show-tick').classList.remove('disabled')

            document.querySelector('#ordenFields').setAttribute('hidden', true)

            //msg default
            // document.querySelector('#mensajeDefault').setAttribute('hidden', true)
        }else {
            document.querySelector('#omnisaludCampos').setAttribute('hidden', true)

            document.querySelector('#tipo_admision_omnisalud').setAttribute('disabled', true)
            document.querySelector('#examenes_omnisalud').setAttribute('disabled', true)
            document.querySelector('#ciudad_omnisalud').setAttribute('disabled', true)
            document.querySelector('#observacion_omnisalud').setAttribute('disabled', true)

            document.querySelector('.bs-placeholder').classList.add('disabled')
            document.querySelector('.show-tick').classList.add('disabled')

            document.querySelector('#ordenFields').removeAttribute('hidden')

            //msg default
            // document.querySelector('#mensajeDefault').removeAttribute('hidden')
        }
    }
</script>