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
    <style>
        .scroll{ max-height: 120px; overflow-y:scroll; }
    </style>

    <section id="work" name="work" class="find-job section">    
        <div class="container ">
            <h2 class="section-title" style="text-align: center;">Ofertas de Trabajo</h2>

            <div class="row">
                <div class="col-sm-3">
                    <div class="job-list">
                        <h5 style="text-align: center; ">FILTROS</h5>
                        <hr>
                            
                        <div>
                            <h5>Palabras claves</h5>

                            {!! Form::model(Request::all(),["route"=>"empleos","method"=>"get"]) !!}
                            <br>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::text("palabra_clave", null, [
                                            "class" => "form-control",
                                            "placeholder" => "Escriba su área de interés"
                                        ]) !!}
                                    </div>
                                </div>

                                <div class="col-md-12 ">
                                    <button class="btn btn-sm  btn-block btn-common"><strong>Filtrar</strong></button>
                                </div>

                                <hr>
                                <div class="ciudades">
                                    <h5 style="text-align: center; ">Ciudades</h5>
                                    <hr>

                                    <div class="scroll">
                                        @foreach( $ciudades as $ciu )
                                            <ul>
                                                <li>
                                                    <span>
                                                        {!! Form::checkbox("ciudad_id[]",$ciu->cod_ciudad,null) !!}
                                                        {{ ucfirst(strtolower($ciu->nombre)) }}
                                                    </span>
                                                </li>
                                            </ul>
                                        @endforeach
                                    </div>
                                </div>

                                <hr>

                                <div class="departamentos">
                                    <h5 style="text-align: center; ">Departamentos</h5>
                                    <hr>
                                          
                                    <div class="scroll">
                                        @foreach( $departamentos as $depa )
                                            <ul>
                                                <li>
                                                    <span>
                                                        {!! Form::checkbox("departamento_id[]",$depa->cod_departamento,null) !!}
                                                        {{ ucfirst(strtolower($depa->nombre)) }}
                                                    </span>
                                                </li>
                                            </ul> 
                                        @endforeach
                                    </div>
                                </div>

                                <hr>

                                <div class="jornadas">
                                    <h5 style="text-align: center; ">Tipo de jornada</h5>
                                    <hr>

                                    <div class="scroll">
                                        @foreach( $jornadas as $jor )
                                            <ul>
                                                <li>
                                                    <span>
                                                        {!! Form::checkbox("jornada_id[]",$jor->id,null) !!}
                                                        {{  ucfirst(strtolower($jor->descripcion)) }}
                                                    </span>
                                                </li>
                                            </ul> 
                                        @endforeach
                                    </div>
                                </div>
                                                
                                <hr>

                                <div class="contratos">
                                    <h5 style="text-align: center; ">Tipo de Contrato</h5>
                                    <hr>
                                              
                                    <div class="scroll">
                                        @foreach( $contratos as $con )
                                            <ul>
                                                <li>
                                                    <span>
                                                        {!! Form::checkbox("contrato_id[]",$con->id,null) !!}
                                                        {{ ucfirst(strtolower($con->descripcion)) }}
                                                    </span>
                                                </li>
                                            </ul>                                 
                                        @endforeach
                                    </div>
                                </div>

                                <hr>

                                <div class="cargos">
                                    <h5 style="text-align: center; ">Cargos</h5>
                                    <hr>

                                    <div class="scroll">
                                        @foreach($cargos as $car)
                                            <ul>
                                                <li>
                                                    <span>
                                                        {!! Form::checkbox("cargo_id[]",$car->id,null) !!}
                                                        {{ ucfirst(mb_strtolower($car->descripcion,'UTF-8')) }}
                                                    </span>
                                                </li>
                                            </ul>
                                        @endforeach
                                    </div>
                                </div>

                                <hr>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>

                <div class="col-sm-9">
                    @foreach($requerimientos as $req)
                    <div class="">
                        <div class="job-list">
                            <div class="thumb">
                                @if ($req->tipo_proceso_id == 7) <span class="proceso-backup" style="background: {{ $color_azul }} none repeat scroll 0 0;"> PROCESO BACKUP </span> @endif
                                @if($req->confidencial != "1")
                                    @if($req->logo != "" && $req->logo != null  )
                                        <img
                                            width="120"
                                            class="mr-auto"
                                            alt="T3RS"
                                            src="{{ url('recursos_clientes_logos/'.$req->logo) }}"
                                        >
                                    @elseif(isset($sitio->logo))
                                        @if($sitio->logo != "")
                                            <img alt="T3RS" src="{{ url('configuracion_sitio')}}/{{ $sitio->logo }}">
                                        @else
                                            <img alt="T3RS" src="{{url('img/logo.png')}}">
                                        @endif
                                    @else
                                        <img alt="T3RS" src="{{url('img/logo.png')}}">
                                    @endif
                                @else
                                    <img alt="Importante empresa" src="{{url('img/confidencial1.png')}}">
                                @endif
                            </div>

                            <div class="job-list-content">
                                <h4>{{ ucfirst(mb_strtolower($req->nombre_subcargo,'UTF-8'))}}</h4>
                                
                                <h5>
                                    <a href="{{ route("home.detalle_oferta", ["id" => $req->id]) }}">
                                        
                                    {{ ucfirst(mb_strtolower($req->nombre_cargo,'UTF-8')) }}</a>
                                </h5>

                                <p maxlength="6">
                                    {!! str_limit($req->descripcion_oferta, 250) !!}
                                </p>
                                
                                <label>Salario :</label>

                                <strong class="price">${!!number_format($req->salario,null,null,".")!!}</strong>

                                <div class="job-tag">
                                    <div class="pull-left pull">
                                        <div class="meta-tag">
                                            <span>
                                                <i class="ti-location-pin"></i>
                                                {{ ucwords(ucfirst(mb_strtolower($req->ciudad_seleccionada,'UTF-8'))) }}
                                            </span>

                                            <span>
                                                <i class="ti-time"></i>{{$req->fecha_publicacion}}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="pull-right pull">
                                        {{-- Si existen preguntas --}}
                                        @if($req->preguntas_aplica_requerimiento() != 0)

                                            {{-- Si existen preguntas filtro --}}
                                            @if($req->preguntas_filtro_aplica_requerimiento() != 0)

                                                {{-- Si ya aplico y no paso --}}
                                                @if($req->aplicacion_candidato_oferta() == 0)
                                                    {{-- No hay respuestas - Filtro --}}
                                                    @if($req->pregunta_candidato_respuesta_filtro() == 0)
                                                        <a
                                                            target="_blank"
                                                            href="{{
                                                                route("home.responder_preguntas", ["req_id" => $req->id, "cargo_id" => $req->cargo_especifico_id])
                                                            }}"
                                                            class="btn btn-common btn-rm"
                                                            style="border-radius: 5px;"
                                                        >
                                                            Aplicar
                                                        </a>

                                                    {{-- No hay preguntas --}}
                                                    @elseif($req->preguntas_aplica_requerimiento() == 0)
                                                        <a
                                                            target="_blank"
                                                            href="{{ route("home.aplicar_oferta", ["id" => $req->id]) }}"
                                                            class="btn btn-common btn-rm"
                                                            style="border-radius: 5px;"
                                                        >
                                                            Aplicar
                                                        </a>

                                                    {{-- Ha respondido la filtro --}}
                                                    @elseif($req->pregunta_candidato_respuesta_filtro() != 0)
                                                        {{-- No ha respondido las de puntaje --}}
                                                        @if($req->pregunta_candidato_respuesta() == 0)
                                                            <a
                                                                target="_blank"
                                                                href="{{ route("home.responder_preguntas_oferta", ["req_id" => $req->id, "cargo_id" => $req->cargo_especifico_id]) }}"
                                                                class="btn btn-common btn-rm"
                                                                style="border-radius: 5px;"
                                                            >
                                                                Aplicar
                                                            </a>
                                                        @else
                                                            <a
                                                                target="_blank"
                                                                href="{{ route("home.aplicar_oferta", ["id" => $req->id]) }}"
                                                                class="btn btn-common btn-rm"
                                                                style="border-radius: 5px;"
                                                            >
                                                                Aplicar
                                                            </a>
                                                        @endif

                                                    {{-- No ha respondido las de puntaje --}}
                                                    @elseif($req->pregunta_candidato_respuesta() == 0)
                                                        <a
                                                            target="_blank"
                                                            href="{{ route("home.responder_preguntas_oferta", ["req_id" => $req->id, "cargo_id" => $req->cargo_especifico_id]) }}"
                                                            class="btn btn-common btn-rm"
                                                            style="border-radius: 5px;"
                                                        >
                                                            Aplicar
                                                        </a>
                                                    @endif
                                                @else
                                                    <a
                                                        target="_blank"
                                                        href="{{ route("home.aplicar_oferta", ["id" => $req->id]) }}"
                                                        class="btn btn-common btn-rm"
                                                        style="border-radius: 5px;"
                                                    >
                                                        Aplicar
                                                    </a>
                                                @endif

                                            @elseif($req->pregunta_candidato_respuesta() == 0)
                                                <a
                                                    target="_blank"
                                                    href="{{ route("home.responder_preguntas_oferta", ["req_id" => $req->id, "cargo_id" => $req->cargo_especifico_id]) }}"
                                                    class="btn btn-common btn-rm"
                                                    style="border-radius: 5px;"
                                                >
                                                    Aplicar
                                                </a>
                                            {{-- Aplica directo --}}
                                            @elseif($req->preguntas_aplica_requerimiento() == 0)
                                                <a
                                                    target="_blank"
                                                    href="{{ route("home.aplicar_oferta", ["id" => $req->id]) }}"
                                                    class="btn btn-common btn-rm"
                                                    style="border-radius: 5px;"
                                                >
                                                    Aplicar
                                                </a>

                                            {{-- Aplica directo --}}
                                            @elseif($req->pregunta_candidato_respuesta() != 0)
                                                <a
                                                    target="_blank"
                                                    href="{{ route("home.aplicar_oferta", ["id" => $req->id]) }}"
                                                    class="btn btn-common btn-rm"
                                                    style="border-radius: 5px;"
                                                >
                                                    Aplicar
                                                </a>
                                            @endif

                                        {{-- Preguntas prueba idioma --}}
                                        @elseif($req->pregunta_aplica_idioma() != 0 && $req->preguntas_filtro_aplica_requerimiento() == 0 && $req->pregunta_candidato_respuesta() == 0)
                                            <a
                                                target="_black"
                                                href="{{ route("home.responder_preguntas_prueba_idioma", ["req_id" => $req->id, "cargo_id" => $req->cargo_especifico_id]) }}"
                                                class="btn btn-common btn-rm"
                                                style="border-radius: 5px;"
                                            >
                                                Aplicar
                                            </a>

                                        {{-- Sin preguntas --}}
                                        @else
                                            <a
                                                target="_blank"
                                                href="{{ route("home.aplicar_oferta", ["id" => $req->id]) }}"
                                                class="btn btn-common btn-rm"
                                                style="border-radius: 5px;"
                                            >
                                                Aplicar
                                            </a>
                                        @endif

                                        <a href="{{ route("home.detalle_oferta", ["id" => $req->id]) }}" class="btn btn-rm btn-secundario">Ver Más</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>        
        </div>

        <div class="col-md-12">
            <div class="showing" style="text-align: center;">
                {!! $requerimientos->appends(Request::all())->render()!!}
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
                            <p>Si actualmente no encuentras las ofertas que se ajustan a tus necesidades, regístrate en nuestro portal y déjanos tu Hoja de vida, nuestro sistema automáticamente te pre-perfilara cuando se tengamos nuevas oportunidades que se ajusten a tu perfil.</p>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <a href="{{ route('registrarse') }}" class="btn btn-border" style="text-transform: none;">!Registra tu hoja de vida!</a>
                    </div>
                </div>
            </div>
        </section>

@stop
