
<?php
    $i = 0;
    $boton_editar = FuncionesGlobales::valida_boton_req("admin.cargos_especificos.editar", "Editar ", "boton", "btn btn-primary cargoEspecifico");
?>

@foreach($listas as $lista)
    <tr id="{{ $lista->id }}">
        <td class="hidden">
            {{ $lista->clt_codigo }}
        </td>

        <td>
            {{ $lista->id }}
        </td>

        <td>
            {{ $lista->descripcion }}
        </td>

        <td>
            {{ $lista->cliente }}
        </td>

        <td>
            {{ $lista->plazo_req }}
        </td>

        <td>
            @if($lista->active == 1)
                <span class="label label-success">Activo</span>
            @else
                <span class="label label-danger">Inactivo</span>
            @endif
        </td>


        <td>
            {{--@if ($boton_editar != '')
                {!! $boton_editar !!}
            @endif--}}

            <button class="btn btn-primary cargoEspecifico | tri-br-2 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-200 tri-hover-out-purple" type="button" data-cargo="{{$lista->id}}">
                Editar
            </button>

            @if($sitio->prueba_bryg == 1 || $sitio->prueba_excel_basico || $sitio->prueba_excel_intermedio || $sitioModulo->prueba_valores1 == 'enabled' || $sitioModulo->prueba_digitacion == 'enabled' || $sitioModulo->prueba_competencias == 'enabled')
                <div class="btn-group">
                    <button class="btn btn-primary | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" type="button">
                        <i class="fa fa-cog" aria-hidden="true"></i> Configurar Pruebas
                    </button>

                    <button class="btn btn-primary dropdown-toggle | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" data-toggle="dropdown" type="button">
                        <span class="caret"></span>
                        <span class="sr-only">
                            Toggle Dropdown
                        </span>
                    </button>

                    <ul class="dropdown-menu pd-0" role="menu">
                        @if($sitio->prueba_bryg == 1)
                            <li>
                                <button 
                                    type="button" 
                                    class="btn btn-sm btn-default btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" 
                                    data-toggle="tooltip" 
                                    data-placement="top" 
                                    title="Configuración bryg del cargo."
                                    onclick="configurarCargoBRYG(this, '{{ route("admin.configuracion_bryg_requerimiento") }}')" 
                                    data-cargoid="{{ $lista->id }}"
                                >
                                    <i class="fa fa-cog" aria-hidden="true"></i>
                                    Configurar BRYG-A
                                </button>
                            </li>
                        @endif

                        @if ($sitioModulo->prueba_valores1 == 'enabled')
                            <li>
                                <button 
                                    type="button" 
                                    class="btn btn-sm btn-default btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" 
                                    data-toggle="tooltip" 
                                    data-placement="top" 
                                    title="Configuración de la prueba Ethical Values."
                                    onclick="configurarEthicalValues(this, '{{ route("admin.configuracion_prueba_ethical_values") }}')" 
                                    data-cargoid="{{ $lista->id }}"
                                >
                                    <i class="fa fa-cog" aria-hidden="true"></i>
                                    Ethical Values
                                </button>
                            </li>
                        @endif

                        @if ($sitio->prueba_excel_basico || $sitio->prueba_excel_intermedio)
                            <li>
                                <button 
                                    type="button" 
                                    class="btn btn-sm btn-default btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" 
                                    data-toggle="tooltip" 
                                    data-placement="top" 
                                    title="Configuración prueba Excel del cargo."
                                    onclick="configurarExcelCargo(this, '{{ route("admin.configuracion_excel_cargo") }}')" 
                                    data-cargoid="{{ $lista->id }}"
                                >
                                    <i class="fa fa-cog" aria-hidden="true"></i>
                                    Prueba Excel
                                </button>
                            </li>
                        @endif

                        @if($sitioModulo->prueba_digitacion == 'enabled')
                            <li>
                                <button 
                                    type="button" 
                                    class="btn btn-sm btn-default btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" 
                                    data-toggle="tooltip" 
                                    data-placement="top" 
                                    title="Configuración prueba digitación."
                                    onclick="configurarDigitacionCargo(this, '{{ route("admin.configuracion_digitacion_cargo") }}')" 
                                    data-cargoid="{{ $lista->id }}"
                                >
                                    <i class="fa fa-cog" aria-hidden="true"></i>
                                    Prueba Digitación
                                </button>
                            </li>
                        @endif

                        @if($sitioModulo->prueba_competencias == 'enabled')
                            <li>
                                <button 
                                    type="button" 
                                    class="btn btn-sm btn-default btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none" 
                                    data-toggle="tooltip" 
                                    data-placement="top" 
                                    title="Editar configuración prueba competencias."
                                    onclick="configurarCargoCompetencias(this, '{{ route("admin.configuracion_competencias_cargo") }}')" 
                                    data-cargoid="{{ $lista->id }}"
                                    data-genericoid="{{ $lista->cargo_generico_id }}"
                                >
                                    <i class="fa fa-cog" aria-hidden="true"></i>
                                    Prueba P. Skills
                                </button>
                            </li>
                        @endif
                    </ul>
                </div>
            @endif
        </td>
    </tr>
@endforeach
