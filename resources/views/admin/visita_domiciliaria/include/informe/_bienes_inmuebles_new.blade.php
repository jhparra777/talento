<section class="secciones-titulos-2 center">
    <h2 style="color: #6F3795;">BIENES INMUEBLES Y VEHÍCULOS</h2>
    <hr align="left" class="divider-hd" style="margin-top: -.5rem;">
</section>

<section class="center">

    {{-- Subtitulo inmuebles --}}
    
    <div class="ml-1">
        <p class="color fw-700" style="font-size: 12pt;">Inmuebles</p>
        <hr align="left" class="divider-25" style="margin-top: -.6rem;">
    </div>
    @if(count($inmuebles) > 0)
        {{-- tabla sub-seccion centrales de riesgo --}}
        <table class="table table-striped" style="width: 60%; margin: 0 auto;">
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Dirección</th>
                    <th>Ciudad</th>
                    <th>Precio</th>
                </tr>     
            </thead>
            <tbody>
                @foreach($inmuebles as $in)
                    <tr>
                        <td>{{ $tipoPropiedad[$in->tipo_inmueble] }}</td>
                        <td>{{ $in->direccion_inmueble }}</td>
                        <td>{{ $ciudades_general[$in->ciudad_inmueble] }}</td>
                        <td>{{ $in->valor_inmueble_bienes }} COP</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="ml-1">
            <p>No posee</p>
        </div>
    @endif

    {{-- Observaciones de inmuebles --}}
    @if (!empty($visita->inm_observaciones))
        <div class="ml-1">
            <p class="color fw-700" style="font-size: 12pt;">Observaciones inmuebles:  </p>
            <hr align="left" class="divider-25" style="margin-top: -.6rem;">
        </div>

        <div class="m-auto" style="width: 95%;">
            <p class="text-justify color-sec">

                {{ $visita->inm_observaciones }}
            
            </p>
        </div>    
    @endif


    {{-- Subtitulo vehiculos --}}
    <div class="ml-1">
        <p class="color fw-700" style="font-size: 12pt;">Vehiculos</p>
        <hr align="left" class="divider-25" style="margin-top: -.6rem;">
    </div>
    @if(count($vehiculos) > 0)
        {{-- tabla sub-seccion vehiculos --}}
        <table class="table table-striped" style="width: 60%; margin: 0 auto;">
            <thead>
                <tr>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Placa</th>
                    <th>Precio</th>
                </tr>     
            </thead>
            <tbody>
                @foreach($vehiculos as $ve)
                    <tr>
                        <td>{{ $ve->Marca }}</td>
                        <td>{{ $ve->modelo_vehiculo_bienes }}</td>
                        <td>{{ $ve->placas_vehiculos_bienes }}</td>
                        <td>{{ $ve->valor_vehiculo_bienes }} COP</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="ml-1">
            <p>No posee</p>
        </div>
    @endif
    <br>
    {{-- Observaciones de vehiculos --}}
    @if (!empty($visita->veh_observaciones))
        <div class="ml-1">
            <p class="color fw-700" style="font-size: 12pt;">Observaciones Vehiculo:  </p>
            <hr align="left" class="divider-25" style="margin-top: -.6rem;">
        </div>

        <div class="m-auto" style="width: 95%;">
            <p class="text-justify color-sec">

                {{ $visita->veh_observaciones }}
            
            </p>
        </div>    
    @endif

    {{-- subtitulo Concepto(Admin) --}}
    <div class="ml-1">
        <p class="color fw-700" style="font-size: 12pt;">Concepto del evaluador:  </p>
        <hr align="left" class="divider-25" style="margin-top: -.6rem;">
    </div>

    <div class="m-auto" style="width: 95%;">
        <p class="text-justify color-sec">

            {{ $visita->inm_veh_concepto }}
        
        </p>
    </div>
</section>

{{-- En caso de campos diferentes --}}
@if ($inmuebles_diferentes == false || $vehiculos_diferentes == false)
    <section class="center">
        <section class="secciones-titulos-2">
            <p class="color fw-700" style="font-size: 12pt;">Novedades</p>
            {{-- <h2 style="color: #6F3795;">Observaciones</h2> --}}
            <hr align="left" class="divider-hd" style="margin-top: -.5rem;">
        </section>

        {{-- Seccion dinamica de inmuebles --}}
        @if ($inmuebles_diferentes == false)
            <section class="row col-md-12" style="margin:0; margin-bottom: 30px;">

                <div class="ml-1">
                    <p class="color fw-700" style="font-size: 12pt;">Inmuebles:  </p>
                    <hr align="left" class="divider-25" style="margin-top: -.6rem;">
                </div>

                <div class="col-md-6" style="max-width: 50%;float: left;">
                    <section class="secciones-titulos-2">
                        <p class="color fw-700" style="font-size: 12pt;">Información suministrada por el candidato</p>
                        <hr align="left" class="divider-hd" style="margin-top: -.5rem;">

                        <?php
                            $inmuebles_cand = (array)json_decode($visita->visita_candidato->inmuebles);
                        ?>

                        @foreach ($inmuebles_cand as $in)
                            <ul>
                                @if (!empty($in->tipo_inmueble))
                                    <li>
                                        Tipo: {{ $tipoPropiedad[$in->tipo_inmueble] }}
                                    </li>                                    
                                @endif

                                @if (!empty($in->direccion_inmueble))
                                    <li>
                                        Dirección: {{ $in->direccion_inmueble }}
                                    </li>                                    
                                @endif

                                @if (!empty($in->ciudad_inmueble))
                                    <li>
                                        Ciudad: {{ $ciudades_general[$in->ciudad_inmueble] }}
                                    </li>                                    
                                @endif

                                @if (!empty($in->direccion_inmueble))
                                    <li>
                                        Precio: {{ $in->valor_inmueble_bienes }} COP
                                    </li>                                    
                                @endif
                            </ul>
                        @endforeach
                    </section>
                </div>
        
                <div class="col-md-6" style="max-width: 50%;float: left;">
                    <section class="secciones-titulos-2">
                        <p class="color fw-700" style="font-size: 12pt;">Información verificada</p>
                        <hr align="left" class="divider-hd" style="margin-top: -.5rem;">

                        @foreach ($inmuebles as $in)
                            <ul>
                                @if (!empty($in->tipo_inmueble))
                                    <li>
                                        Tipo: {{ $tipoPropiedad[$in->tipo_inmueble] }}
                                    </li>                                    
                                @endif

                                @if (!empty($in->direccion_inmueble))
                                    <li>
                                        Dirección: {{ $in->direccion_inmueble }}
                                    </li>                                    
                                @endif

                                @if (!empty($in->ciudad_inmueble))
                                    <li>
                                        Ciudad: {{ $ciudades_general[$in->ciudad_inmueble] }}
                                    </li>                                    
                                @endif

                                @if (!empty($in->direccion_inmueble))
                                    <li>
                                        Precio: {{ $in->valor_inmueble_bienes }} COP
                                    </li>                                    
                                @endif
                            </ul>
                        @endforeach
                    </section>
                </div>
        
            </section>
        @endif 

        {{-- Seccion campos dinamicos vehiculos--}}
        @if ($vehiculos_diferentes == false)
            <section class="row col-md-12" style="margin:0; margin-bottom: 30px;">

                <div class="ml-1">
                    <p class="color fw-700" style="font-size: 12pt;">Vehiculos:  </p>
                    <hr align="left" class="divider-25" style="margin-top: -.6rem;">
                </div>

                <div class="col-md-6" style="max-width: 50%;float: left;">
                    <section class="secciones-titulos-2">
                        <p class="color fw-700" style="font-size: 12pt;">Información suministrada por el candidato</p>
                        <hr align="left" class="divider-hd" style="margin-top: -.5rem;">

                        <?php
                            $vehiculos_cand = (array)json_decode($visita->visita_candidato->vehiculos);
                        ?>

                        @foreach ($vehiculos_cand as $ve)
                            <ul>
                                @if (!empty($ve->Marca))
                                    <li>
                                        Marca: {{ $ve->Marca }}
                                    </li>                                    
                                @endif

                                @if (!empty($ve->modelo_vehiculo_bienes))
                                    <li>
                                        Modelo: {{ $ve->modelo_vehiculo_bienes }}
                                    </li>                                    
                                @endif

                                @if (!empty($ve->placas_vehiculos_bienes))
                                    <li>
                                        Placa: {{ $ve->placas_vehiculos_bienes }}
                                    </li>                                    
                                @endif

                                @if (!empty($ve->placas_vehiculos_bienes))
                                    <li>
                                        Precio: {{ $ve->valor_vehiculo_bienes }} COP
                                    </li>                                    
                                @endif
                            </ul>
                        @endforeach
                    </section>
                </div>
        
                <div class="col-md-6" style="max-width: 50%;float: left;">
                    <section class="secciones-titulos-2">
                        <p class="color fw-700" style="font-size: 12pt;">Información verificada</p>
                        <hr align="left" class="divider-hd" style="margin-top: -.5rem;">

                        @foreach ($vehiculos as $ve)
                            <ul>
                                @if (!empty($ve->Marca))
                                    <li>
                                        Marca: {{ $ve->Marca }}
                                    </li>                                    
                                @endif

                                @if (!empty($ve->modelo_vehiculo_bienes))
                                    <li>
                                        Modelo: {{ $ve->modelo_vehiculo_bienes }}
                                    </li>                                    
                                @endif

                                @if (!empty($ve->placas_vehiculos_bienes))
                                    <li>
                                        Placa: {{ $ve->placas_vehiculos_bienes }}
                                    </li>                                    
                                @endif

                                @if (!empty($ve->placas_vehiculos_bienes))
                                    <li>
                                        Precio: {{ $ve->valor_vehiculo_bienes }} COP
                                    </li>                                    
                                @endif
                            </ul>
                        @endforeach
                    </section>
                </div>
        
            </section>
        @endif 
    </section>

@endif
<br>
