<table class="table table-hover">
    <tr>
        <th>Competencia</th>
        <th>Nivel esperado</th>
        <th>Rango asertividad</th>
        <th>Margen asertividad</th>
    </tr>

    @foreach($nivelCompetencias as $competencia)
        <tr>
            @if($configuracion[$competencia->competencia_id]->competencia_id === $competencia->competencia_id)
                <td>
                    <div class="checkbox">
                        <label>
                            <input 
                                type="checkbox" 
                                name="competencias[]" 
                                id="competenciaCheck{{ $competencia->competencia_id }}" 
                                value="{{ $competencia->competencia_id }}" 
                                onchange="competenciaCheck(this)" 
                                checked 

                                data-margen-acertividad="margenAcertividad{{ $competencia->competencia_id }}"
                                data-esperado-id="nivelEsperado{{ $competencia->competencia_id }}"> {{ $competencia->competencia->descripcion }}
                        </label>
                    </div>
                </td>

                <td>
                    <input 
                        type="text" 
                        class="form-control solo-numero" 
                        name="nivel_esperado[]" 
                        id="nivelEsperado{{ $competencia->competencia_id }}" 
                        maxlength="3" 
                        placeholder="Nivel esperado de 0 a 100"
                        onkeyup="inputEsperado(this)" 

                        value="{{ $configuracion[$competencia->competencia_id]->nivel_esperado }}" 

                        data-rango-acertividad="badgeAcertividad{{ $competencia->competencia_id }}"
                        data-margen-acertividad="margenAcertividad{{ $competencia->competencia_id }}">

                    <small>Nivel esperado de la competencia</small>
                </td>

                <td class="text-center">
                    <h4>
                        <span class="label label-default" id="badgeAcertividad{{ $competencia->competencia_id }}">
                            {{ $configuracion[$competencia->competencia_id]->nivel_esperado - $configuracion[$competencia->competencia_id]->margen_acertividad }} 
                            - 
                            {{ $configuracion[$competencia->competencia_id]->nivel_esperado + $configuracion[$competencia->competencia_id]->margen_acertividad }} 
                        </span>
                    </h4>
                </td>

                <td class="text-center">
                    <input 
                        type="range" 
                        name="margen_acertividad[]" 
                        id="margenAcertividad{{ $competencia->competencia_id }}" 
                        value="{{ $configuracion[$competencia->competencia_id]->margen_acertividad }}" 
                        min="3" 
                        max="10" 
                        oninput="rangeValue(this)"

                        data-esperado-id="nivelEsperado{{ $competencia->competencia_id }}"
                        data-rango-acertividad="badgeAcertividad{{ $competencia->competencia_id }}">

                    <span class="badge" id="badgeRangeValue{{ $competencia->competencia_id }}">
                        {{ $configuracion[$competencia->competencia_id]->margen_acertividad }}
                    </span>
                </td>
            @else
                <td>
                    <div class="checkbox">
                        <label>
                            <input 
                                type="checkbox" 
                                name="competencias[]" 
                                id="competenciaCheck{{ $competencia->competencia_id }}" 
                                value="{{ $competencia->competencia_id }}" 
                                onchange="competenciaCheck(this)" 

                                {{ (empty($configuracion)) ? 'checked' : '' }}

                                data-margen-acertividad="margenAcertividad{{ $competencia->competencia_id }}"
                                data-esperado-id="nivelEsperado{{ $competencia->competencia_id }}"> {{ $competencia->competencia->descripcion }}
                        </label>
                    </div>
                </td>

                <td>
                    <input 
                        type="text" 
                        class="form-control solo-numero" 
                        name="nivel_esperado[]" 
                        id="nivelEsperado{{ $competencia->competencia_id }}" 
                        maxlength="3" 
                        placeholder="Nivel esperado de 0 a 100"
                        onkeyup="inputEsperado(this)"

                        {{ (empty($configuracion)) ? '' : 'disabled' }}

                        data-rango-acertividad="badgeAcertividad{{ $competencia->competencia_id }}"
                        data-margen-acertividad="margenAcertividad{{ $competencia->competencia_id }}">

                    <small>Nivel esperado de la competencia</small>
                </td>

                <td class="text-center">
                    <h4><span class="label label-default" id="badgeAcertividad{{ $competencia->competencia_id }}">0 - 0</span></h4>
                </td>

                <td class="text-center">
                    <input 
                        type="range" 
                        name="margen_acertividad[]" 
                        id="margenAcertividad{{ $competencia->competencia_id }}" 
                        value="3" 
                        min="3" 
                        max="10" 
                        oninput="rangeValue(this)" 

                        {{ (empty($configuracion)) ? '' : 'disabled' }}

                        data-esperado-id="nivelEsperado{{ $competencia->competencia_id }}"
                        data-rango-acertividad="badgeAcertividad{{ $competencia->competencia_id }}">

                    <span class="badge" id="badgeRangeValue{{ $competencia->competencia_id }}">3</span>
                </td>
            @endif
        </tr>
    @endforeach
</table>