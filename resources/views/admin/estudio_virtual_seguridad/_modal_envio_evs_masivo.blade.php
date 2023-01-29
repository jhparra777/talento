<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Enviar a Estudio Virtual de Seguridad: 

        @foreach($datos_basicos as $candi)
            <strong><br>{{ mb_strtoupper($candi['nombres']) . ' ' . mb_strtoupper($candi['primer_apellido']) . ' Nro. documento ' . $candi['numero_id'] }}</strong>
        @endforeach 
    </h4>
</div>
<div class="modal-body">
    {!! Form::open(["id"=>"fr_evs_masi"]) !!}
        {!! Form::hidden("req_can_id",$req_can_id_j,["id"=>"candidato_req_fr"]) !!}


        <div class="col-md-12 form-group">
            <label for="tipo_evs_id" class="control-label | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300">Tipo de estudio virtual de seguridad <span class='text-danger sm-text-label'>*</span></label>

            <select class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" id="tipo_evs_id" name="tipo_evs_id" required="">
                <option value="">Seleccione</option>
                @foreach ($tipos_evs as $tipo)
                    <?php
                        if ($requerimiento->tipo_evs_id == $tipo->id && $tipo->visita_domiciliaria == 'enabled') {
                            $visita_domiciliaria_enabled = true;
                        }
                    ?>
                    <option value="{{$tipo->id}}" data-visita="{{$tipo->visita_domiciliaria}}" {{($requerimiento->tipo_evs_id == $tipo->id ? 'selected' : '')}}>{{$tipo->descripcion}}</option>
                @endforeach
            </select>
        </div>

        <div id="div-clase" class="col-md-12 form-group" {{(!empty($visita_domiciliaria_enabled) && $visita_domiciliaria_enabled ? '' : 'hidden')}}>
            <label for="clase_visita_id" class="control-label | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300">Clase visita domiciliaria <span class='text-danger sm-text-label'>*</span></label>

            {!! Form::select("clase_visita_id", $clases_visita, null, [
                "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                "id" => "clase_visita_id"
                ]);
            !!}
        </div>
    {!! Form::close() !!}

    <div class="clearfix"></div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-300" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" id="confirmar_evs_masivo" >Confirmar</button>
</div>

<script type="text/javascript">
    $(function() {
        $('#tipo_evs_id').change(function () {
            if ($('#tipo_evs_id option:selected').data('visita') == 'enabled') {
                $('#div-clase').show();
                $('#clase_visita_id').prop('required', true);
            } else {
                $('#div-clase').hide();
                $('#clase_visita_id').prop('required', false);
            }
        })
    })
</script>
