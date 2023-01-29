@extends("home.layout.master")
@section('content')
    <style>
        .btn-common{
            text-transform: none; border-radius: 5px;
        }

        @media (max-width: 520px) {
            .relacionado_img{
                text-align: center;
            }
        }

        .aplicar_oferta{
            margin-right: 2rem;
        }

        .btn-icon {
            padding: 6px 12px;
            margin:1em;
            justify-content: center;
            overflow: hidden;
            border-radius: 100%;
            flex-shrink: 0;
            /*height: calc( (0.875rem * 1) + (0.875rem * 2) + (2px) ) !important;
            width: calc( (0.875rem * 1) + (0.875rem * 2) + (2px) ) !important;
            */
        }

        .btn-facebook {
            color: #fff;
            background-color: #3b5998;
            border-color: #3b5998;
        }
        
        .btn-facebook:hover {
            color: #fff;
            background-color: #30497c;
            border-color: #2d4373;
        }
            
        .btn-facebook:focus, .btn-facebook.focus {
            color: #fff;
            background-color: #30497c;
            border-color: #2d4373;
            box-shadow: 0 0 0 0.2rem rgba(88, 114, 167, 0.5);
            
        }
            
        .btn-facebook.disabled, .btn-facebook:disabled {
            color: #fff;
            background-color: #3b5998;
            border-color: #3b5998;
            
        }
            
            
        .btn-facebook:not(:disabled):not(.disabled):active, .btn-facebook:not(:disabled):not(.disabled).active, .show > .btn-facebook.dropdown-toggle {
            color: #fff;
            background-color: #2d4373;
            border-color: #293e6a;
           
        }
            
            
        .btn-facebook:not(:disabled):not(.disabled):active:focus, .btn-facebook:not(:disabled):not(.disabled).active:focus, .show > .btn-facebook.dropdown-toggle:focus {
            box-shadow: 0 0 0 0.2rem rgba(88, 114, 167, 0.5);
            
        }

            
        .btn-linkedin {
            color: #fff;
            background-color: #0073b1;
            border-color: #0073b1;
            
        }
            
        .btn-linkedin:hover {
            color: #fff;
            background-color: #005684;
            border-color: #2d4373;
            
        }
            
        .btn-linkedin:focus, .btn-linkedin.focus {
            color: #fff;
            background-color: #005684;
            border-color: #2d4373;
            box-shadow: 0 0 0 0.2rem rgba(88, 114, 167, 0.5);
            
        }
            
        .btn-linkedin.disabled, .btn-linkedin:disabled {
            color: #fff;
            background-color: #0073b1;
            border-color: #0073b1;
            
        }
            
        .btn-linkedin:not(:disabled):not(.disabled):active, .btn-linkedin:not(:disabled):not(.disabled).active, .show > .btn-linkedin.dropdown-toggle {
            color: #fff;
            background-color: #2d4373;
            border-color: #293e6a;
            
        }
            
        .btn-linkedin:not(:disabled):not(.disabled):active:focus, .btn-linkedin:not(:disabled):not(.disabled).active:focus, .show > .btn-linkedin.dropdown-toggle:focus {
            box-shadow: 0 0 0 0.2rem rgba(88, 114, 167, 0.5);
            
        }

        .btn-twitter {
        color: #fff;
        background-color: #1da1f2;
        border-color: #1da1f2;
        }
        .btn-twitter:hover {
        color: #fff;
        background-color: #0d8ddc;
        border-color: #0c85d0;
        }
        .btn-twitter:focus, .btn-twitter.focus {
        color: #fff;
        background-color: #0d8ddc;
        border-color: #0c85d0;
        box-shadow: 0 0 0 0.2rem rgba(63, 175, 244, 0.5);
        }
        .btn-twitter.disabled, .btn-twitter:disabled {
        color: #fff;
        background-color: #1da1f2;
        border-color: #1da1f2;
        }
        .btn-twitter:not(:disabled):not(.disabled):active, .btn-twitter:not(:disabled):not(.disabled).active, .show > .btn-twitter.dropdown-toggle {
        color: #fff;
        background-color: #0c85d0;
        border-color: #0b7ec4;
        }
        .btn-twitter:not(:disabled):not(.disabled):active:focus, .btn-twitter:not(:disabled):not(.disabled).active:focus, .show > .btn-twitter.dropdown-toggle:focus {
        box-shadow: 0 0 0 0.2rem rgba(63, 175, 244, 0.5);
        }

        .btn-dark {
        color: #fff;
        background-color: #212832;
        border-color: #212832;
        }
        .btn-dark:hover {
        color: #fff;
        background-color: #12161b;
        border-color: #0d0f13;
        }
        .btn-dark:focus, .btn-dark.focus {
        color: #fff;
        background-color: #12161b;
        border-color: #0d0f13;
        box-shadow: 0 0 0 0.2rem rgba(66, 72, 81, 0.5);
        }
        .btn-dark.disabled, .btn-dark:disabled {
        color: #fff;
        background-color: #212832;
        border-color: #212832;
        }
        .btn-dark:not(:disabled):not(.disabled):active, .btn-dark:not(:disabled):not(.disabled).active, .show > .btn-dark.dropdown-toggle {
        color: #fff;
        background-color: #0d0f13;
        border-color: #08090c;
        }
        .btn-dark:not(:disabled):not(.disabled):active:focus, .btn-dark:not(:disabled):not(.disabled).active:focus, .show > .btn-dark.dropdown-toggle:focus {
        box-shadow: 0 0 0 0.2rem rgba(66, 72, 81, 0.5);
        }

        .btn-whatsapp {
        color: #fff;
        background-color: #00ac69;
        border-color: #00ac69;
        }
        .btn-whatsapp:hover {
        color: #fff;
        background-color: #008652;
        border-color: #00794a;
        }
        .btn-whatsapp:focus, .btn-whatsapp.focus {
        color: #fff;
        background-color: #008652;
        border-color: #00794a;
        box-shadow: 0 0 0 0.2rem rgba(38, 184, 128, 0.5);
        }
        .btn-whatsapp.disabled, .btn-whatsapp:disabled {
        color: #fff;
        background-color: #00ac69;
        border-color: #00ac69;
        }
        .btn-whatsapp:not(:disabled):not(.disabled):active, .btn-whatsapp:not(:disabled):not(.disabled).active, .show > .btn-whatsapp.dropdown-toggle {
        color: #fff;
        background-color: #00794a;
        border-color: #006c42;
        }
        .btn-whatsapp:not(:disabled):not(.disabled):active:focus, .btn-whatsapp:not(:disabled):not(.disabled).active:focus, .show > .btn-whatsapp.dropdown-toggle:focus {
        box-shadow: 0 0 0 0.2rem rgba(38, 184, 128, 0.5);
        }

        .fa-1ix {
            font-size: 1.5em !important;
        }

        .form-group i{
            position: initial;
            color: #fff;
            padding: .25em;
        }

        .alert-local {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
            text-shadow: 0 1px 0 rgb(255 255 255 / 20%);
            -webkit-box-shadow: inset 0 1px 0 rgb(255 255 255 / 25%), 0 1px 2px rgb(0 0 0 / 5%);
            box-shadow: inset 0 1px 0 rgb(255 255 255 / 25%), 0 1px 2px rgb(0 0 0 / 5%);
        }

        .alert-info-local {
            color: black;
            background-color: #d9edf7;
            border-color: #bce8f1;

            background-image: -webkit-linear-gradient(top,#d9edf7 0,#b9def0 100%);
            background-image: -o-linear-gradient(top,#d9edf7 0,#b9def0 100%);
            background-image: -webkit-gradient(linear,left top,left bottom,from(#d9edf7),to(#b9def0));
            background-image: linear-gradient(to bottom,#d9edf7 0,#b9def0 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffd9edf7', endColorstr='#ffb9def0', GradientType=0);
            background-repeat: repeat-x;
            border-color: #9acfea;
        }
    </style>

    <div class="page-header" style="background: url({{ url('assets/img/banner1.jpg') }});">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-wrapper">
                        <h2 class="product-title">Detalle Oferta</h2>

                        <ol class="breadcrumb">
                            <li>
                                <a href="{{ route('home') }}"><i class="ti-home"></i> Inicio</a>
                            </li>

                            <li class="li-detalle">Detalle Oferta</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="job-detail section">
        <div class="container">
            <div class="row">
                <div class="col-md-9 col-sm-8">
                    <div class="content-area">
                        <h2 class="medium-title">Información de la oferta</h2>

                        @if(Session::has('status'))
                            <div class="alert alert-info" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>

                                <strong>Se ha enviado el correo a su destinatario.</strong> 
                            </div>
                        @endif

                        <div class="detalle_oferta">
                            @if($requerimientos->estado_publico!=0 && $requerimientos->estado_requerimiento != config('conf_aplicacion.C_TERMINADO'))
                                <hr>

                                <div class="row">
                                    <div style="text-align: center;" class="col-md-3">
                                        @if($requerimientos->confidencial != "1")
                                            @if(route("home") == "https://asuservicio.t3rsc.co")
                                                <img alt="T3RS" src="{{ url('configuracion_sitio') }}/logo_asuser.jpg">
                                            @else
                                                @if($requerimientos->logo != "" && $requerimientos->logo != null)
                                                    <img
                                                        width="120"
                                                        class="mr-auto"
                                                        alt="T3RS"
                                                        src="{{ url('recursos_clientes_logos/'.$requerimientos->logo) }}"
                                                    >
                                                @elseif(isset(FuncionesGlobales::sitio()->logo))
                                                    @if(FuncionesGlobales::sitio()->logo != "")
                                                        <img
                                                            alt="T3RS"
                                                            src="{{ url('configuracion_sitio') }}/{!! ((FuncionesGlobales::sitio()->logo)) !!}"
                                                        >
                                                    @else
                                                        <img alt="T3RS" src="{{ url('img/logo.png') }}">
                                                    @endif
                                                @else
                                                    <img alt="T3RS" src="{{ url('img/logo.png') }}">
                                                @endif
                                            @endif
                                        @else
                                            <img alt="Importante empresa" src="{{ url('img/confidencial1.png') }}">
                                        @endif
                                    </div>

                                    <div @if(count($imagen_oferta)) 
                                    class="col-md-6" @else class="col-md-8" @endif>

                                       <h3>{{ ucfirst(mb_strtolower($requerimientos->nombre_subcargo, 'UTF-8')) }}</h3>

                                        <br>
                                        <label  class=" control-label"><b>Salario:</b></label>
                                        <strong class="price">${!! number_format($requerimientos->salario, null, null, ".") !!}</strong>
                                    </div>
                                    @if(count($imagen_oferta))
                                        <div class="col-md-3" style="text-align: center;">
                                            <img
                                                alt="T3RS"
                                                src='{{asset("imagenes_cargos/$imagen_oferta->nombre")}}'
                                                                                        >
                                        </div>
                                    @endif
                                </div>

              					<hr>

                                <?php
                                    $no_se_puede_aplicar = false;
                                    if ($requerimientos->fecha_tope_publicacion != null) {
                                        $fecha_hoy = \Carbon\Carbon::now();
                                        $fecha_tope = \Carbon\Carbon::parse($requerimientos->fecha_tope_publicacion);
                                        if ($fecha_hoy->greaterThan($fecha_tope)) {
                                            $no_se_puede_aplicar = true;
                                        }
                                    }
                                ?>

              					<div style="text-align: center;" class="form-group">
                					<div class="row">
                  						<div style="text-align: left;" class="col-md-12 form-group">
                        					<label for="inputEmail3" class="col-sm-12 control-label"><b>Localización:</b></label>

                        					<div class="col-sm-12">
                            					{!! ucwords(mb_strtolower($requerimientos->ciudad_seleccionada,'UTF-8')) !!}
                        					</div>
                  						</div>

                                        @if(route("home") != "https://expertos.t3rsc.co")
                      						<div style="text-align: left;" class="col-md-12 form-group">
                        						<label for="inputEmail3" class="col-sm-12 control-label"><b>Jornada:</b></label>

                        						<div class="col-sm-12">
                            						{!! $requerimientos->tipo_jornada !!}
                        						</div>
                      						</div>

                      						<div style="text-align: left;" class="col-md-12 form-group">
                        						<label for="inputEmail3" class="col-sm-12 control-label"><b>Tipo de experiencia :</b></label>

                        						<div class="col-sm-12">
                            						{!! $requerimientos->experiencia_req() !!}
                        						</div>
                      						</div>
                                        @endif

                                        <div style="text-align: left;" class="col-md-12 form-group">
                        					<label for="inputEmail3" class="col-sm-12 control-label"><b> Funciones:</b></label>
                        					
                                            <div class="col-sm-12"><!-- Funcionesagregar -->
                            					{!! $requerimientos->funciones !!}
                        					</div>
                      					</div>

                  						<div style="text-align: left;" class="col-md-12 form-group">
                    						<label for="inputEmail3" class="col-sm-12 control-label"><b>Descripción:</b></label>

                    						<div class="col-sm-12">
                      						    <p> {!! $requerimientos->descripcion_oferta !!}</p>
                    						</div>
                  						</div>
                					</div>

                                    @if(!$no_se_puede_aplicar)
                    					<h3 style="text-align: center;">
                    					   <strong>
                                                <u>
                                                    Comparte con tus contactos esta oportunidad de empleo
                                                </u>
                                            </strong>
                    					</h3>

                    					<br>

                    					<!--Facebook-->
                                        <div class="row">
                                            <a target="_blank" title="Compartir en Facebook" href="https://www.facebook.com/sharer/sharer.php?u={{ route('home.detalle_oferta', ['oferta_id' => $oferta_id]) }}" class="btn btn-icon btn-facebook mx-1">
                                                <i class="fa fa-facebook-f fa-1ix"></i>
                                            </a>

                                            <a target="_blank" title="Compartir en Whatsapp" href="https://api.whatsapp.com/send?text=Hola!%20te comparto%20esta%20oportunidad%20de%20empleo%20{{ route('home.detalle_oferta', ['oferta_id' => $oferta_id]) }}" class="btn btn-icon btn-whatsapp mx-1">
                                                <i class="fa fa-whatsapp fa-1ix"></i>
                                            </a>

                                            <a href='javascript:void();' title="Copiar enlace" class="btn btn-icon btn-dark mx-1" onclick='var a=document.createElement(&quot;input&quot;);a.setAttribute(&quot;value&quot;,window.location.href.split(&quot;?&quot;)[0].split(&quot;#&quot;)[0]),document.body.appendChild(a),a.select(),document.execCommand(&quot;copy&quot;),document.body.removeChild(a);var c=document.createElement(&quot;style&quot;),e=document.createTextNode(&quot;#av{position:fixed;z-index:999999;width:120px;top:30%;left:50%;margin-left:-60px;padding:20px;background:gold;border-radius:8px;font-size: 14px;font-family:sans-serif;text-align:center;}&quot;);c.appendChild(e),document.head.appendChild(c);var av=document.createElement(&quot;div&quot;);av.setAttribute(&quot;id&quot;,&quot;av&quot;);var c=document.createTextNode(&quot;URL copiada&quot;);av.appendChild(c),document.body.appendChild(av),window.load=setTimeout(&quot;document.body.removeChild(av)&quot;,2e3);'>
                                                <i class="fa fa-clone fa-1ix"></i>
                                            </a>

                                            <a target="_blank" title="Compartir en Linkedin" href="https://www.linkedin.com/sharing/share-offsite/?url={{ route('home.detalle_oferta', ['oferta_id' => $oferta_id]) }}" class="btn btn-icon btn-linkedin mx-1">
                                                <i class="fa fa-linkedin fa-1ix"></i>
                                            </a>

                                            <a target="_blank" title="Compartir en Twitter" href="https://twitter.com/intent/tweet?text=Hola!%20te comparto%20esta%20oportunidad%20de%20empleo%20{{ rawurlencode(route('home.detalle_oferta', ['oferta_id' => $oferta_id])) }}" class="btn btn-icon btn-twitter mx-1"
                                            >
                                                <i class="fa fa-twitter fa-1ix"></i>
                                            </a>

                                            {{--
                                            <div class="col-sm-3 col-md-2 form-group" style="vertical-align: top;">
                                                <div
                                                    class="fb-share-button"
                                                    data-href="{{ route('home.detalle_oferta', ['oferta_id' => $oferta_id]) }}"
                                                    data-layout="button"
                                                    data-size="small"
                                                    data-mobile-iframe="false"
                                                >
                                                    <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fsoluciones.t3rsc.co%2Fdetalle%2F280&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore"></a>
                                                </div>
                                            </div>

                                            <div class="col-sm-3 col-md-2 form-group">
                                                <a
                                                    target="_blank"
                                                    href="https://api.whatsapp.com/send?phone=numero&text=Hola!%20te comparto%20esta%20oportunidad%20de%20empleo%20{{ route('home.detalle_oferta', ['oferta_id' => $oferta_id]) }}" 
                                                    class="btn  btn-sm  btn-success aplicar_oferta">
                                                    <span class="fa fa-whatsapp fa-lg" aria-hidden="true"></span>
                                                </a>
                                            </div>
                                            
                                            <div class="col-sm-3 col-md-2 form-group">
                                                <a href='javascript:void();' class="btn  btn-sm btn-primary aplicar_oferta" onclick='var a=document.createElement(&quot;input&quot;);a.setAttribute(&quot;value&quot;,window.location.href.split(&quot;?&quot;)[0].split(&quot;#&quot;)[0]),document.body.appendChild(a),a.select(),document.execCommand(&quot;copy&quot;),document.body.removeChild(a);var c=document.createElement(&quot;style&quot;),e=document.createTextNode(&quot;#av{position:fixed;z-index:999999;width:120px;top:30%;left:50%;margin-left:-60px;padding:20px;background:gold;border-radius:8px;font-size: 14px;font-family:sans-serif;text-align:center;}&quot;);c.appendChild(e),document.head.appendChild(c);var av=document.createElement(&quot;div&quot;);av.setAttribute(&quot;id&quot;,&quot;av&quot;);var c=document.createTextNode(&quot;URL copiada&quot;);av.appendChild(c),document.body.appendChild(av),window.load=setTimeout(&quot;document.body.removeChild(av)&quot;,2e3);'>
                                                    <span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span><strong>  URL</strong>
                                                </a>
                                            </div>

                                            <div class="col-sm-3 col-md-2 form-group">
                                                <script type="IN/Share" data-url="{{ route('home.detalle_oferta', ['oferta_id' => $oferta_id]) }}"></script>

                                                <div
                                                    class="g-plus"
                                                    data-action="share"
                                                    data-annotation="none"
                                                    data-href="{{ route('home.detalle_oferta', ['oferta_id' => $oferta_id]) }}"
                                                ></div>
                                            </div>

                                            <div class="col-sm-3 col-md-2 form-group">
                                                <a
                                                    href="{{ route('home.detalle_oferta', ['oferta_id' => $oferta_id]) }}"
                                                    class="twitter-share-button"
                                                    data-show-count="false"
                                                >
                                                    Tweet
                                                </a>
                                                <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                                            </div>
                                            --}}
                                        </div>
                                    @endif
                                </div>

                                <hr>
                                <div class="form-group pull">
                                    @if($no_se_puede_aplicar)
                                        {{-- Esta fuera de la fecha tope de postulacion, no saldra el boton Aplicar --}}
                                        <div class="form-group col-md-12">
                                            <div class="alert-local alert-info-local" role="alert">
                                                Esta oferta de trabajo ha expirado. Ya no puedes postularte. Te invitamos a consultar las nuevas <strong>ofertas de trabajo</strong>.
                                            </div>
                                        </div>
                                    @elseif($requerimientos->preguntas_aplica_requerimiento() != 0)
                                    {{-- Si existen preguntas --}}

                                        {{-- Si existen preguntas filtro --}}
                                        @if($requerimientos->preguntas_filtro_aplica_requerimiento() != 0)

                                            {{-- Si ya aplico y no paso --}}
                                            @if($requerimientos->aplicacion_candidato_oferta() == 0)
                                                {{-- No hay respuestas - Filtro --}}
                                                @if($requerimientos->pregunta_candidato_respuesta_filtro() == 0)
                                                    <a
                                                        target="_blank"
                                                        href="{{
                                                            route("home.responder_preguntas", ["req_id" => $oferta_id, "cargo_id" => $requerimientos->cargo_espe_id])
                                                        }}"
                                                        class="btn btn-common aplicar_oferta"
                                                    >
                                                        Aplicar
                                                    </a>

                                                {{-- No hay preguntas --}}
                                                @elseif($requerimientos->preguntas_aplica_requerimiento() == 0)
                                                    <a
                                                        target="_blank"
                                                        href="{{ route("home.aplicar_oferta", ["id" => $oferta_id]) }}"
                                                        class="btn btn-common aplicar_oferta"
                                                    >
                                                        Aplicar
                                                    </a>

                                                {{-- Ha respondido la filtro --}}
                                                @elseif($requerimientos->pregunta_candidato_respuesta_filtro() != 0)
                                                    {{-- No ha respondido las de puntaje --}}
                                                    @if($requerimientos->pregunta_candidato_respuesta() == 0)
                                                        <a
                                                            target="_blank"
                                                            href="{{ route("home.responder_preguntas_oferta", ["req_id" => $oferta_id, "cargo_id" => $requerimientos->cargo_espe_id]) }}"
                                                            class="btn btn-common aplicar_oferta"
                                                        >
                                                            Aplicar
                                                        </a>
                                                    @else
                                                        <a
                                                            target="_blank"
                                                            href="{{ route("home.aplicar_oferta", ["id" => $oferta_id]) }}"
                                                            class="btn btn-common aplicar_oferta"
                                                        >
                                                            Aplicar
                                                        </a>
                                                    @endif

                                                {{-- No ha respondido las de puntaje --}}
                                                @elseif($requerimientos->pregunta_candidato_respuesta() == 0)
                                                    <a
                                                        target="_blank"
                                                        href="{{ route("home.responder_preguntas_oferta", ["req_id" => $oferta_id, "cargo_id" => $requerimientos->cargo_espe_id]) }}"
                                                        class="btn btn-common aplicar_oferta"
                                                    >
                                                        Aplicar
                                                    </a>
                                                @endif
                                            @else
                                                <a
                                                    target="_blank"
                                                    href="{{ route("home.aplicar_oferta", ["id" => $oferta_id]) }}"
                                                    class="btn btn-common aplicar_oferta"
                                                >
                                                    Aplicar
                                                </a>
                                            @endif

                                        @elseif($requerimientos->pregunta_candidato_respuesta() == 0)
                                            <a
                                                target="_blank"
                                                href="{{ route("home.responder_preguntas_oferta", ["req_id" => $oferta_id, "cargo_id" => $requerimientos->cargo_espe_id]) }}"
                                                class="btn btn-common aplicar_oferta"
                                            >
                                                Aplicar
                                            </a>
                                        {{-- Aplica directo --}}
                                        @elseif($requerimientos->preguntas_aplica_requerimiento() == 0)
                                            <a
                                                target="_blank"
                                                href="{{ route("home.aplicar_oferta", ["id" => $oferta_id]) }}"
                                                class="btn btn-common aplicar_oferta"
                                            >
                                                Aplicar
                                            </a>

                                        {{-- Aplica directo --}}
                                        @elseif($requerimientos->pregunta_candidato_respuesta() != 0)
                                            <a
                                                target="_blank"
                                                href="{{ route("home.aplicar_oferta", ["id" => $oferta_id]) }}"
                                                class="btn btn-common aplicar_oferta"
                                            >
                                                Aplicar
                                            </a>
                                        @endif

                                    {{-- Preguntas prueba idioma --}}
                                    @elseif($requerimientos->pregunta_aplica_idioma() != 0 && $requerimientos->preguntas_filtro_aplica_requerimiento() == 0 && $requerimientos->pregunta_candidato_respuesta() == 0)
                                        <a
                                            target="_black"
                                            href="{{ route("home.responder_preguntas_prueba_idioma", ["req_id" => $oferta_id, "cargo_id" => $requerimientos->cargo_espe_id]) }}"
                                            class="btn btn-common aplicar_oferta"
                                        >
                                            Aplicar
                                        </a>

                                    {{-- Sin preguntas --}}
                                    @else
                                        <a
                                            target="_blank"
                                            href="{{ route("home.aplicar_oferta", ["id" => $oferta_id]) }}"
                                            class="btn btn-common aplicar_oferta"
                                        >
                                            Aplicar
                                        </a>
                                    @endif

                                    <a href="{{ $anterior }}" class="btn btn-secundario aplicar_oferta">Volver</a>
                                </div>
                            @else
                                <br><br><br>
                                <div class="form-group pull">
                                    <div class="form-group col-md-12">
                                        <div class="alert-local alert-info-local" role="alert">
                                            Esta oferta de trabajo ha expirado. Ya no puedes postularte. Te invitamos a consultar las nuevas <strong>ofertas de trabajo</strong>.
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="clearfix"></div>
                        </div>

                        <br><br>

                        <h2 class="medium-title">Empleos relacionados</h2>
                        <div>

                            <div class="thumb"></div>

                            <div class="text-box">
                                @if($requerimientos2->count() == null)
                                    <h2 style="text-align: center;" class="medium-title">No hay empleos</h2>
                                @endif

                                @foreach($requerimientos2 as $req)
                                    <div class="job-list">
                                        <div class="thumb relacionado_img">
                                            <img src="{{ url('configuracion_sitio')}}/{!! ((FuncionesGlobales::sitio()->logo)) !!}" alt="T3RS">
                                        </div>

                                        <div class="job-list-content">
                                            <h4>{{ ucfirst(mb_strtolower($req->nombre_subcargo,'UTF-8'))}}</h4>
                                                
                                            <p maxlength="6"> {!! str_limit($req->descripcion_oferta, 250) !!}</p>

                                            <label>Salario :</label>
                                                    
                                            <strong class="price">${!!number_format($req->salario,null,null,".")!!}</strong>
                                                
                                            <div class="job-tag">
                                                <div class="pull-left pull">
                                                    <div class="meta-tag">
                                                        <span>
                                                            <i class="ti-location-pin"></i>{{ ucwords(mb_strtolower($req->ciudad_seleccionada,'UTF-8')) }}
                                                        </span>

                                                        <span>
                                                            <i class="ti-time"></i>{{$req->fecha_publicacion}}
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="pull-right pull">
                                                    @if( $req->preguntas_aplica_requerimiento() != 0 )

                                                        {{-- <a target="_black"  href="{{route("home.responder",["id"=>$req->id])}}" class="btn btn-common btn-rm">Aplicar</a> --}}
                                                        <a href="{{route("home.detalle_oferta",["id"=>$req->id])}}" class="btn btn-secundario btn-rm">Ver Más</a>
                                                        
                                                    @else
                                    
                                                        {{-- <a target="_black" href="{{route("home.aplicar_oferta",["id"=>$req->id])}}" class="btn btn-common btn-rm aplicar_oferta">Aplicar</a> --}}
                                                            
                                                        <a href="{{route("home.detalle_oferta",["id"=>$req->id])}}" class="btn btn-secundario btn-rm">Ver Más</a>
                                                        
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                {!! $requerimientos2->appends(Request::all())->render() !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-4">
                    <aside>
                        <div class="sidebar">
                            <h2 class="medium-title">Conócenos</h2>

                            <div class="box">
                                <div class="thumb">
                                    @if(isset(FuncionesGlobales::sitio()->logo))
                                        @if(FuncionesGlobales::sitio()->logo != "")
                                            <a><img alt="logo" src="{{ url('configuracion_sitio')}}/{!! ((FuncionesGlobales::sitio()->logo)) !!}"></a>
                                        @else
                                            <a><img alt="logo" src="{{url('img/logo.png')}}"></a>
                                        @endif
                                    @else
                                        <a><img alt="logo" src="{{url('img/logo.png')}}"></a>
                                    @endif
                                </div>
                        
                                <div class="text-box">
                                    <h4>
                                        <a target="_blank" href="{!! FuncionesGlobales::sitio()->web_corporativa !!}">
                                            @if(isset(FuncionesGlobales::sitio()->nombre))
                                                @if(FuncionesGlobales::sitio()->nombre != "")
                                                    {!! (FuncionesGlobales::sitio()->nombre) !!}
                                                @else
                                                    Desarrollo
                                                @endif
                                            @else
                                                {{-- Desarrollo --}}
                                            @endif
                                        </a>
                                    </h4>
                          
                                    <p>
                                        @if(isset(FuncionesGlobales::sitio()->quienes_somos))
                                            {!! (FuncionesGlobales::sitio()->quienes_somos) !!}
                                            @endif
                                    </p>
                                    @if(route("home")!="https://gpc.t3rsc.co")
                                    <h4><strong>Misión</strong></h4>
                          
                                    <p>
                                        @if(isset(FuncionesGlobales::sitio()->mision))
                                            {!! (FuncionesGlobales::sitio()->mision) !!}
                                        @endif
                                    </p>
                                    @endif

                                    <p>
                                        <span><i class="fa fa-map-marker"></i>
                                            @if(route("home") == "https://gpc.t3rsc.co")
                                                Quito, Ecuador.
                                            @else
                                                Bogotá
                                            @endif
                                        </span>
                                    </p>
                                </div>
                            </div>

                            @if(route("home")=="https://expertos.t3rsc.co")
                                <h2 class="medium-title">Otras Oportunidades</h2>
                            @else
                                <h2 class="medium-title">Otros Empleos</h2>
                            @endif
                            
                    
                            <div class="sidebar-jobs box">
                                @if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co")
                                    @foreach($requerimientos1 as $req)
                                        <ul>
                                            <li>
                                                <h4>{{ ucfirst(mb_strtolower($req->nombre_subcargo,'UTF-8')) }}</h4>
                                                
                                                <h5>
                                                    <a href="{{route("home.detalle_oferta",["id"=>$req->id])}}"{{ ucfirst(strtolower($req->nombre_cargo)) }}>
                                                        {!! ucfirst(mb_strtolower($req->nombre_cargo,'UTF-8'))!!}
                                                    </a>
                                                </h5>

                                                <p maxlength="6"> {!! str_limit($req->descripcion_oferta, 150) !!}</p>
                                                <br><br>
                                                <a href="{{route("home.detalle_oferta",["id"=>$req->id])}}" class="btn btn-common btn-sm aplicar_oferta">Ver Oferta </a>
                                                <hr>
                                            </li>
                                        </ul>
                                    @endforeach
                                @else
                                    @if(route('home') == "http://soluciones.t3rsc.co" || route('home') == "http://demo.t3rsc.co")
                                    <!-- aqui comienza con soluciones 3-->
                                        @foreach($requerimientos1 as $req)
                                            <ul>
                                                <li>
                                                    <h4>{{ ucfirst(mb_strtolower($req->cargo_req(),'UTF-8')) }}</h4>
                                                    
                                                    <h5>
                                                        <a href="{{route("home.detalle_oferta",["id"=>$req->id])}}"{{ ucfirst(strtolower($req->pcargo_req())) }}>
                                                            {!! ucfirst(mb_strtolower($req->pcargo_req(),'UTF-8'))!!}
                                                        </a>
                                                    </h5>
                                                    
                                                    <p maxlength="6">{!! str_limit($req->descripcion_oferta, 150) !!}</p>

                                                    <span>
                                                        <i class="fa fa-map-marker"></i>{!!ucwords(strtolower($req->getUbicacion())) !!}
                                                    </span>

                                                    <span>
                                                        <i class="fa fa-calendar"></i>{!!$req->fecha_ingreso !!} - {!!$req->fecha_retiro !!}
                                                    </span>

                                                    <strong class="price">${!!number_format($req->salario,null,null,".")!!}</strong>
                                                    <br><br>
                                                    <a href="{{route("home.detalle_oferta",["id"=>$req->id])}}" class="btn btn-common btn-sm aplicar_oferta">Ver Oferta </a>
                                                    <hr>
                                                </li>
                                            </ul>
                                        @endforeach
                                    @else
                                        @foreach($requerimientos1 as $req)
                                            <ul>
                                                <li>
                                                    <h4>{{ ucfirst(mb_strtolower($req->nombre_subcargo,'UTF-8')) }}</h4>

                                                    @if (route("home") == "https://gpc.t3rsc.co" || route("home") == "http://localhost:8000" ||
                                                        route('home') == "https://asuservicio.t3rsc.co")
                                                        <h5>
                                                            <a href="{{route("home.detalle_oferta",["id"=>$req->id])}}">
                                                                {!! ucfirst(mb_strtolower($req->nombre_subcargo,'UTF-8'))!!}
                                                            </a>
                                                        </h5>
                                                    @else
                                                        <h5>
                                                            <a href="{{route("home.detalle_oferta",["id"=>$req->id])}}"{{ ucfirst(strtolower($req->nombre_cargo)) }}>
                                                                {!! ucfirst(mb_strtolower($req->nombre_cargo,'UTF-8'))!!}
                                                            </a>
                                                        </h5>
                                                    @endif
                                  
                                                    <p maxlength="6"> {!! str_limit($req->descripcion_oferta, 150) !!}</p>

                                                    <span>
                                                        <i class="fa fa-map-marker"></i>{!!ucwords(strtolower($req->ciudad_seleccionada)) !!}
                                                    </span>
                                                    <span>
                                                        <i class="fa fa-calendar"></i>{!!$req->fecha_ingreso !!} - {!!$req->fecha_retiro !!}
                                                    </span>

                                                    @if(route("home")!="https://gpc.t3rsc.co")
                                                         <strong class="price">${!!number_format($req->salario,null,null,".")!!}</strong>
                                                    @endif
                                                    <br><br>
                                                    <a href="{{route("home.detalle_oferta",["id"=>$req->id])}}" class="btn btn-common btn-sm aplicar_oferta"  >Ver Oferta </a>
                                                    <hr>
                                                </li>
                                            </ul>
                                        @endforeach
                                    @endif
                                @endif
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>

    {{-- Enviar email de oferta --}}
    {!! Form::open(['route' => ['enviar_email',$req->id]]) !!}
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Compartir por correo</h5>
                        
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            {!! Form::text('email', null, [
                                'class' => 'form-control',
                                'id' => 'email',
                                'placeholder' => 'Escribe el correo destinatario'
                            ]) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::text('nombre', null, [
                                'class' => 'form-control',
                                'id' => 'email',
                                'placeholder' => 'Escribe tu nombre'
                            ]) !!}
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Enviar correo</button>
                    </div>
                </div>
            </div>
        </div>
    {!! Form::close() !!}

    <script src="https://apis.google.com/js/platform.js" async defer>
        {lang: 'es-419', parsetags: 'explicit'}
    </script>

    <script type="application/ld+json">
        {!! $json_google !!}
    </script>

    <script src="//platform.linkedin.com/in.js" type="text/javascript"> lang: es_ES</script>
    <script>
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = 'https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.12&appId=1419935801389982&autoLogAppEvents=1';
                fjs.parentNode.insertBefore(js, fjs);
        } (document, 'script', 'facebook-jssdk'));
    </script>
@stop