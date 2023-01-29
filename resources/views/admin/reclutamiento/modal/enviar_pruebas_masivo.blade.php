<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Realizar pruebas a los candidatos: 
    
        @foreach($datos_basicos as $candi)
            <strong><br>{{mb_strtoupper($candi)}}</strong>
        @endforeach 

    </h4>
</div>

<div class="modal-body">
    {!! Form::open(["id"=>"fr_prueba_masi"]) !!}
        {!! Form::hidden("req_can_id",$req_can_id_j,["id"=>"candidato_req_fr"]) !!}
        {!! Form::hidden("req_id",$req_id,["id"=>"req_id"]) !!}

        <p>Selecciona la(s) prueba(s) a realizar:</p>

        <ul class="list-unstyled">
            <li>
                <input type="checkbox" name="pruebas[]" value="1" id="externa_pruebas">
                <label for="externa_pruebas">PRUEBA EXTERNA</label>
            </li>

            @if ($sitio->prueba_bryg == 1 || $sitio->prueba_bryg === 1)
                @if(!empty($configuracionBryg))
                    <li>
                        <input type="checkbox" name="pruebas[]" value="2" id="brig_pruebas">
                        <label for="brig_pruebas">PRUEBA BRYG</label>
                    </li>
                @else
                    <li>
                        <input type="checkbox" id="brig_pruebas" disabled>
                        <label for="brig_pruebas">PRUEBA BRYG (No está configurada para este requerimiento).</label>
                    </li>
                @endif
            @endif

            @if ($sitio->prueba_excel_basico == 1)
                @if ($configuracionExcel != null && $configuracionExcel->excel_basico)
                    <li>
                        <input type="checkbox" name="pruebas[]" value="3" id="excel_basico_pruebas">
                        <label for="excel_basico_pruebas">PRUEBA EXCEL BÁSICO</label>
                    </li>
                @else
                    <li>
                        <input type="checkbox" id="excel_basico_pruebas" disabled>
                        <label for="excel_basico_pruebas">PRUEBA EXCEL BÁSICO (No está configurado para este Requerimiento)</label>
                    </li>
                @endif
            @endif

            @if ($sitio->prueba_excel_intermedio == 1)
                @if ($configuracionExcel != null && $configuracionExcel->excel_intermedio)
                    <li>
                        <input type="checkbox" name="pruebas[]" value="4" id="excel_intermedio_pruebas">
                        <label for="excel_intermedio_pruebas">PRUEBA EXCEL INTERMEDIO</label>
                    </li>
                @else
                    <li>
                        <input type="checkbox" id="excel_intermedio_pruebas" disabled>
                        <label for="excel_basico_pruebas">PRUEBA EXCEL INTERMEDIO (No está configurado para este Requerimiento)</label>
                    </li>
                @endif
            @endif

            @if ($sitioModulo->prueba_competencias == 'enabled')
                @if(!empty($configuracionCompetencias))
                    <li>
                        <input type="checkbox" name="pruebas[]" value="5" id="competencias_pruebas">
                        <label for="competencias_pruebas">PS (Personal Skills)</label>
                    </li>
                @else
                    <li>
                        <input type="checkbox" id="competencias_pruebas" disabled>
                        <label for="competencias_pruebas">PS (Personal Skills) (No está configurada para este requerimiento).</label>
                    </li>
                @endif
            @endif

            @if ($sitioModulo->prueba_valores1 == 'enabled')
                @if ($configuracionPruebaValores1 != null)
                    <li>
                        <input type="checkbox" name="pruebas[]" value="6" id="prueba_valores_1">
                        <label for="prueba_valores_1">EV (ETHICAL VALUES)</label>
                    </li>
                @else
                    <li>
                        <input type="checkbox" id="prueba_valores_1" disabled>
                        <label for="prueba_valores_1">EV (ETHICAL VALUES) (No está configurado para este Requerimiento)</label>
                    </li>
                @endif
            @endif

            @if ($sitioModulo->prueba_digitacion == 'enabled')
                @if(!empty($configuracionDigitacion))
                    <li>
                        <input type="checkbox" name="pruebas[]" value="7" id="digitacion_pruebas">
                        <label for="digitacion_pruebas">PRUEBA DIGITACIÓN</label>
                    </li>
                @else
                    <li>
                        <input type="checkbox" id="digitacion_pruebas" disabled>
                        <label for="digitacion_pruebas">PRUEBA DIGITACIÓN (No está configurada para este requerimiento).</label>
                    </li>
                @endif
            @endif
        </ul>
    {!! Form::close() !!}

    <div class="clearfix"></div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-success" id="confirmar_pruebas_masivo" >Confirmar</button>
</div>