@extends("home.layout.master")
@section('content')
    <?php
        $color_azul = "#01273A";
        if(isset(FuncionesGlobales::sitio()->color)) {
            if(FuncionesGlobales::sitio()->color != "") {
                $color_azul = FuncionesGlobales::sitio()->color;
            }
        }
    ?>
        <section id="intro" class="section-intro">
            <div class="search-container">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="titulo-principal-home">¡Buscamos Personas como tú!</h1>
                            <br>
                            <h2>¡Más de <strong>12,000</strong> Empleos profesionales!</h2>
                            <div class="content">
                                {!!Form::model(Request::all(), ["route" => "empleos", "method" => "get"]) !!}
                                    @foreach(Request::all() as $key => $filtro)
                                        {!! Form::hidden($key, $filtro) !!}
                                    @endforeach

                                    <div class="row">
                                        <div class="col-12 col-md-4">
                                            <div class="form-group">
                                                {!! Form::text("palabra_clave",null ,[
                                                    "class" => "form-control",
                                                    "placeholder" => "Escriba su área profesional"
                                                    ]) 
                                                !!}

                                                <i class="ti-time"></i>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-7">
                                            <div class="form-group">
                                                <div class="search-category-container">
                                                    <label style='content: "\e651";' class="styled-select">
                                                        {!! Form::hidden("pais_id[]", null, ["class" => "form-control", "id" => "pais_id"]) !!}
                                                        {!! Form::hidden("ciudad_id[]", null, ["class" => "form-control", "id" => "ciudad_id"]) !!}
                                                        {!! Form::hidden("departamento_id[]", null, ["class" => "form-control","id" => "departamento_id"]) !!}

                                                        {!!Form::text("ciudad_autocomplete",null,[
                                                            "class" => "form-control",
                                                            "id" => "ciudad_autocomplete",
                                                            "placeholder" => "Ubicación"
                                                        ])!!}

                                                        <i style="text-align: center;" class="fa fa-map-marker"></i>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                        
                                        <div class="col-12 col-md-1 mt-2" style="text-align: center;">
                                            <button class="btn btn-search-icon"><i class="ti-search"></i></button>
                                        </div>
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="work" name="work" class="find-job section">
            <div class="container">
                <h2 class="section-title">
                    Ofertas de Trabajo 
                </h2>
                
                <div class="row">
                    @foreach($requerimientos as $req)
                        <div class="col-md-12">
                            <div class="job-list">
                                <div class="thumb img-oferta" style="text-align: center;">
                                    @if ($req->tipo_proceso_id == 7) <span class="proceso-backup" style="background: {{ $color_azul }} none repeat scroll 0 0;"> PROCESO BACKUP </span> @endif
                                    @if($req->confidencial != "1")
                                        @if(0)
                                            <img
                                                width="120"
                                                class="mr-auto"
                                                alt="T3RS"
                                                src="{{ url('recursos_clientes_logos/'.$req->logo) }}"
                                            >
                                        @elseif(isset($sitio->logo))
                                            @if($sitio->logo != "")
                                                <img alt="T3RS" src="{{ url('configuracion_sitio') }}/{{ $sitio->logo }}">
                                            @else
                                                <img alt="T3RS" src="{{ url('img/logo.png') }}">
                                            @endif
                                        @else
                                            <img alt="T3RS" src="{{ url('img/logo.png') }}">
                                        @endif
                                    @else
                                        <img alt="Importante empresa" src="{{ url('img/confidencial1.png') }}">
                                    @endif
                                </div>

                                <div class="job-list-content">
                                    <h4>{{ ucfirst(mb_strtolower($req->nombre_subcargo,'UTF-8')) }}</h4>

                                    {{--
                                        @if(route("home") == "https://asuservicio.t3rsc.co" || route("home") == "https://gpc.t3rsc.co" ||
                                        route("home") == "http://localhost:8000")
                                            <h5>
                                                <a href="{{route('home.detalle_oferta',['id'=>$req->id])}}">{{ ucfirst(mb_strtolower($req->nombre_subcargo,'UTF-8'))}}</a>
                                            </h5>
                                        @else
                                            <h5>
                                                <a href="{{route('home.detalle_oferta',['id'=>$req->id])}}">{{ ucfirst(mb_strtolower($req->nombre_cargo,'UTF-8'))}}</a>
                                            </h5>
                                        @endif
                                    --}}

                                    <p maxlength="6"> {!! str_limit($req->descripcion_oferta, 250) !!}</p>

                                        <label>Salario :</label>
                                        <strong class="price">${!! number_format($req->salario,null,null,".") !!}</strong>
                
                                    <div class="job-tag">
                                        <div class="pull-left pull">
                                            <div class="meta-tag">
                                                <span>
                                                    <i class="ti-location-pin"></i>
                                                    {{ ucwords(strtolower($req->ciudad_seleccionada)) }}
                                                </span> 

                                                <span><i class="ti-time"></i>{{ $req->fecha_publicacion }}</span>
                                            </div>
                                        </div>
                  
                                        <div class="pull-right pull">
                                            <?php
                                                $no_se_puede_aplicar = false;
                                                if ($req->fecha_tope_publicacion != null) {
                                                    $fecha_hoy = \Carbon\Carbon::now();
                                                    $fecha_tope = \Carbon\Carbon::parse($req->fecha_tope_publicacion);
                                                    if ($fecha_hoy->greaterThan($fecha_tope)) {
                                                        $no_se_puede_aplicar = true;
                                                    }
                                                }
                                            ?>
                                            @if($no_se_puede_aplicar)
                                                {{-- Esta fuera de la fecha tope de postulacion, no saldra el boton Aplicar --}}
                                            @elseif($req->preguntas_aplica_requerimiento() != 0)
                                                {{-- Si existen preguntas --}}

                                                {{-- Si existen preguntas filtro --}}
                                                @if($req->preguntas_filtro_aplica_requerimiento() != 0)

                                                    {{-- Si ya aplico y no paso --}}
                                                    @if($req->aplicacion_candidato_oferta() == 0)
                                                        {{-- No hay respuestas - Filtro --}}
                                                        @if($req->pregunta_candidato_respuesta_filtro() == 0)
                                                            <a
                                                                target="_blank"
                                                                href="{{
                                                                    route("home.responder_preguntas", ["req_id" => $req->id, "cargo_id" => $req->cargo_id])
                                                                }}"
                                                                class="btn btn-common btn-rm aplicar_oferta"
                                                            >
                                                                Aplicar
                                                            </a>

                                                        {{-- No hay preguntas --}}
                                                        @elseif($req->preguntas_aplica_requerimiento() == 0)
                                                            <a
                                                                target="_blank"
                                                                href="{{ route("home.aplicar_oferta", ["id" => $req->id]) }}"
                                                                class="btn btn-common btn-rm aplicar_oferta"
                                                            >
                                                                Aplicar
                                                            </a>

                                                        {{-- Ha respondido la filtro --}}
                                                        @elseif($req->pregunta_candidato_respuesta_filtro() != 0)
                                                            {{-- No ha respondido las de puntaje --}}
                                                            @if($req->pregunta_candidato_respuesta() == 0)
                                                                <a
                                                                    target="_blank"
                                                                    href="{{ route("home.responder_preguntas_oferta", ["req_id" => $req->id, "cargo_id" => $req->cargo_id]) }}"
                                                                    class="btn btn-common btn-rm aplicar_oferta"
                                                                >
                                                                    Aplicar
                                                                </a>
                                                            @else
                                                                <a
                                                                    target="_blank"
                                                                    href="{{ route("home.aplicar_oferta", ["id" => $req->id]) }}"
                                                                    class="btn btn-common btn-rm aplicar_oferta"
                                                                >
                                                                    Aplicar
                                                                </a>
                                                            @endif

                                                        {{-- No ha respondido las de puntaje --}}
                                                        @elseif($req->pregunta_candidato_respuesta() == 0)
                                                            <a
                                                                target="_blank"
                                                                href="{{ route("home.responder_preguntas_oferta", ["req_id" => $req->id, "cargo_id" => $req->cargo_id]) }}"
                                                                class="btn btn-common btn-rm aplicar_oferta"
                                                            >
                                                                Aplicar
                                                            </a>
                                                        @endif
                                                    @else
                                                        <a
                                                            target="_blank"
                                                            href="{{ route("home.aplicar_oferta", ["id" => $req->id]) }}"
                                                            class="btn btn-common btn-rm aplicar_oferta"
                                                        >
                                                            Aplicar
                                                        </a>
                                                    @endif

                                                @elseif($req->pregunta_candidato_respuesta() == 0)
                                                    <a
                                                        target="_blank"
                                                        href="{{ route("home.responder_preguntas_oferta", ["req_id" => $req->id, "cargo_id" => $req->cargo_id]) }}"
                                                        class="btn btn-common btn-rm aplicar_oferta"
                                                    >
                                                        Aplicar
                                                    </a>
                                                {{-- Aplica directo --}}
                                                @elseif($req->preguntas_aplica_requerimiento() == 0)
                                                    <a
                                                        target="_blank"
                                                        href="{{ route("home.aplicar_oferta", ["id" => $req->id]) }}"
                                                        class="btn btn-common btn-rm aplicar_oferta"
                                                    >
                                                        Aplicar
                                                    </a>

                                                {{-- Aplica directo --}}
                                                @elseif($req->pregunta_candidato_respuesta() != 0)
                                                    <a
                                                        target="_blank"
                                                        href="{{ route("home.aplicar_oferta", ["id" => $req->id]) }}"
                                                        class="btn btn-common btn-rm aplicar_oferta"
                                                    >
                                                        Aplicar
                                                    </a>
                                                @endif

                                            {{-- Preguntas prueba idioma --}}
                                            @elseif($req->pregunta_aplica_idioma() != 0 && $req->preguntas_filtro_aplica_requerimiento() == 0 && $req->pregunta_candidato_respuesta() == 0)
                                                <a
                                                    target="_black"
                                                    href="{{ route("home.responder_preguntas_prueba_idioma", ["req_id" => $req->id, "cargo_id" => $req->cargo_id]) }}"
                                                    class="btn btn-common btn-rm aplicar_oferta"
                                                >
                                                    Aplicar
                                                </a>

                                            {{-- Sin preguntas --}}
                                            @else
                                                <a
                                                    target="_blank"
                                                    href="{{ route("home.aplicar_oferta", ["id" => $req->id]) }}"
                                                    class="btn btn-common btn-rm aplicar_oferta"
                                                >
                                                    Aplicar
                                                </a>
                                            @endif

                                            <a
                                                href="{{ route('home.detalle_oferta', ['id' => $req->id]) }}"
                                                class="btn btn-secundario btn-rm"
                                            >
                                                Ver Más
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="col-md-12">
                  <div class="showing pull-left">
                   {!! $requerimientos->appends(Request::all())->render()!!}
                  </div>
                </div>
            </div>
        </section>

        <section id="counter">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-xs-6">
                            <div class="counting">
                                <div class="icon">
                                    <i class="ti-briefcase"></i>
                                </div>

                                <div class="desc">                
                                    <h2>Ofertas</h2>
                                    @if(isset($ofertas))
                                        <h1 class="counter">{{ $ofertas }}</h1>
                                    @else
                                        <h1 class="counter">0</h1>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 col-xs-6">
                            <div class="counting">
                                <div class="icon">
                                    <i class="ti-user"></i>
                                </div>

                                <div class="desc">
                                    <h2>Vacantes</h2>
                                    @if(isset($vacantes))
                                        <h1 class="counter">{{ $vacantes }}</h1>
                                    @else
                                        <h1 class="counter">0</h1>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 col-xs-6">
                            <div class="counting">
                                <div class="icon">
                                    <i class="ti-write"></i>
                                </div>

                                <div class="desc">
                                    <h2>Candidatos</h2>
                                    @if(isset($candidatos))
                                        <h1 class="counter">{{ $candidatos }}</h1>   
                                    @else
                                        <h1 class="counter">0</h1>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 col-xs-6">
                            <div class="counting">
                                <div class="icon">
                                    <i class="ti-heart"></i>
                                </div>

                                <div class="desc">
                                    <h2>Empresas</h2>
                                    @if(isset($clientes))
                                        <h1 class="counter">{{ $clientes }}</h1>     
                                    @else
                                        <h1 class="counter">0</h1>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>

        <section class="infobox section">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="info-text">
                            <h2>¿En busca de trabajo?</h2>
                            <p>
                                Si actualmente no encuentras las ofertas que se ajustan a tus necesidades, regístrate en nuestro portal y déjanos tu Hoja de vida, nuestro sistema automáticamente te pre-perfilara cuando se tengamos nuevas oportunidades que se ajusten a tu perfil.
                            </p>
                        </div>
                    </div>
                    
                    <div class="col-sm-6">
                        <a href="{{route('registrarse')}}" class="btn btn-border" style="text-transform: none;">!Registra tu hoja de vida!</a>
                    </div>
                </div>
            </div>
        </section>

    <script>
        $(function () {
            $('#ciudad_autocomplete').autocomplete({
                serviceUrl: '{{ route("autocomplete_cuidades") }}',
                autoSelectFirst: true,
                onSelect: function (suggestion) {
                    $("#pais_id").val(suggestion.cod_pais);
                    $("#departamento_id").val(suggestion.cod_departamento);
                    $("#ciudad_id").val(suggestion.cod_ciudad);
                }
            });
        });
    </script>
@stop