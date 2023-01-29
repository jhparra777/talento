@extends("admin.layout.master")
@section("contenedor")
    <style>
        .btn-icon {
            padding: 5px 10px;
            margin:.4em;
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
    </style>
    {{-- Header --}}
    @include('admin.layout.includes._section_header_breadcrumb', ['page_header' => "Ofertas"])

    @if(Session::has("mensaje_success"))
        <div class="col-md-12" id="mensaje-resultado">
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {{Session::get("mensaje_success")}}
            </div>
        </div>
    @endif

    {!! Form::model(Request::all(), ["id" => "admin.lista_clientes", "method" => "GET"]) !!}
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="numReq">
                        @if(route('home') == "https://gpc.t3rsc.co") Nombre del Proceso @else Num Req @endif:
                    </label>

                    {!! Form::text("codigo", null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300 solo-numero", "placeholder" => ""]); !!}
                </div>
            </div>
            

            @if(route('home') == "http://komatsu.t3rsc.co" || route('home') == "https://komatsu.t3rsc.co")
                

            @else
                <div class="col-md-6">
                    <div class="form-group">
                         <label for="inputEmail3">Clientes:</label>
                        
                            {!! Form::select('cliente_id', $clientes, null, ['id' => 'cliente_id','class' => 'form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300 js-select-2-basic']) !!}
                       
                        
                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombre", $errors) !!}</p>
                    </div>
                   
                </div>
                @endif

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="inputEmail3">Publicada:</label>
                    
                    
                        {!! Form::select("publicada", ["" => "Seleccionar", "1" => "Si", 2 => "No"], null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300"]); !!}
                    

                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombre", $errors) !!}</p>
                    </div>
                    
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="inputEmail3">Tipo Proceso:</label>
                        
                            {!! Form::select('tipo_proceso_id', $tipoProcesos, null, ['id' => 'tipo_proceso_id','class' => 'form-control |tri-br-1 tri-fs-12 tri-input--focus tri-transition-300 js-select-2-basic']) !!}
                        
                        
                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo_proceso_id", $errors) !!}</p>
                    </div>
                    
                </div>

                <div class="col-md-12 text-right">
                    <button class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" >Buscar
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                    
                    <a class="btn btn-danger | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-red" href="{{ route("admin.ofertas") }}" >Limpiar</a>
                    {{--<a class="btn btn-info" href="Javascript:;" onclick="return redireccionar_registro('req_id[]', this, 'url')">Editar Oferta</a>--}}
                </div>
            </div>

            <br>
            
        {!! Form::close() !!}

    @if(route('home') == "http://komatsu.t3rsc.co" || route('home') == "https://komatsu.t3rsc.co")
    

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th></th>
                        <th>Num Oferta</th>
                        <th>Cargo</th>
                        <th>Área</th>
                        <th>Sub-área</th>
                        <th>Sede</th>
                        <th># Vacantes</th>
                        <th>Fecha Oportuna</th>
                        <th>Dias gestión</th>
                        <th>Publicada</th>
                        <th style="text-align: center;"> Compartir </th>
                    </tr>
                </thead>

                <tbody>
                    @if($requerimientos->count() == 0)
                        <tr>
                            <td colspan="5">No se encontraron registros</td>
                        </tr>
                    @endif  

                    @foreach($requerimientos as $requerimiento)
                        <tr>
                            <td>
                                {!! Form::checkbox("req_id[]", $requerimiento->req_id, null, [
                                    "data-url" => route('admin.editar_oferta', [
                                        "req_id" => $requerimiento->req_id, "cargo_id" => $requerimiento->cargo_id
                                    ])
                                ]) !!}
                            </td>
                            <td>{{ $requerimiento->req_id }}</td>
                            <td>{{ $requerimiento->cargo }}</td>
                            <td>
                                @if(isset($requerimiento->solicitud->area->descripcion))
                                    {{ $requerimiento->solicitud->area->descripcion }}
                                @endif
                            </td>
                            <td>
                                @if(isset($requerimiento->solicitud->subarea->descripcion))
                                    {{ $requerimiento->solicitud->subarea->descripcion }}
                                @endif
                            </td>
                            <td>
                                @if(isset($requerimiento->solicitud->subarea->descripcion))
                                    {{ $requerimiento->solicitud->sede->descripcion }}
                                @endif
                            </td>
                            <td>{{ $requerimiento->num_vacantes }}</td>
                            <td>{{ $requerimiento->fecha_terminacion }}</td>
                            <td>{{ $requerimiento->dias_gestion }}</td>
                            
                            <td>{{ (($requerimiento->estado_publico == 0 ) ? "NO" : "SI") }}</td>

                            @if($requerimiento->estado_publico == 1)
                                <td>
                                    <div class="container" style="width: 250px;">
                                        <div class="row" style="width: 250px; text-align: center;">
                                            <div style="width:250px;">

                                                <div style="top: 5px;" class="fb-share-button" data-href="{{route('home.detalle_oferta',['oferta_id' => $requerimiento->req_id]) }}" data-layout="button" data-size="large" data-mobile-iframe="true">
                                                 <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fsoluciones.t3rsc.co%2Fdetalle%2F280&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore"></a>

                                                </div>

                                                <a target="_blank" href="https://api.whatsapp.com/send?text=Hola!%20te comparto%20esta%20oportunidad%20de%20empleo%20{{ route('home.detalle_oferta',['oferta_id' => $requerimiento->req_id]) }}" class="btn  btn-sm  btn-success aplicar_oferta">
                                                    <span class="fa fa-whatsapp fa-lg " aria-hidden="true">
                                                </a>

                                                <a target="_blank" href="{{ route("enviar_email",["id"=>$requerimiento->req_id]) }}" class="btn  btn-sm btn-primary aplicar_oferta"  >
                                                    <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
                                                </a>

                                                {{-- URL --}}
                                                <a href='javascript:void();' class="btn  btn-sm btn-primary aplicar_oferta" onclick='var copiar="{{route('home')}}"+"/detalle/"+"{{$requerimiento->req_id}}";var a=document.createElement(&quot;input&quot;);a.setAttribute(&quot;value&quot;,copiar),document.body.appendChild(a),a.select(),document.execCommand(&quot;copy&quot;),document.body.removeChild(a);var c=document.createElement(&quot;style&quot;),e=document.createTextNode(&quot;#av{position:fixed;z-index:999999;width:120px;top:30%;left:50%;margin-left:-60px;padding:20px;background:gold;border-radius:8px;font-size: 14px;font-family:sans-serif;text-align:center;}&quot;);c.appendChild(e),document.head.appendChild(c);var av=document.createElement(&quot;div&quot;);av.setAttribute(&quot;id&quot;,&quot;av&quot;);var c=document.createTextNode(&quot;URL copiada&quot;);av.appendChild(c),document.body.appendChild(av),window.load=setTimeout(&quot;document.body.removeChild(av)&quot;,2e3);'>
                                                        <span class="glyphicon  glyphicon-duplicate" aria-hidden="true"></span>
                                                        <strong>  URL</strong>
                                                </a>
                                
                                                {{-- 
                                                    <button type="button" class="btn btn-warning btn-sm btnCopy" data="MyText">
                                                        <i class="fa fa-clipboard" aria-hidden="true"></i></span>
                                                    </button>
                                
                                                    <label style="display: none;" class="font-normal MyText{{$requerimiento->id}}">{{route('home.detalle_oferta',['oferta_id' => $requerimiento->req_id])}}</label>&nbsp;
                                                --}}
                                            </div>
                                        </div>

                                        <div class="row" style="width: 250px;">
                                            <div style="width:250px; ">
                                                <script type="IN/Share" data-url="{{ route('home.detalle_oferta',['oferta_id' => $requerimiento->req_id]) }}"></script>
                                                       
                                                <div class="g-plus" data-action="share" data-annotation="none"  data-href="{{ route('home.detalle_oferta',['oferta_id' => $requerimiento->req_id]) }}"></div>
                                      
                                                <a href="{{ route('home.detalle_oferta',['oferta_id' => $requerimiento->req_id]) }}" class="twitter-share-button" data-show-count="false">Tweet</a>

                                                <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                                            </div>
                                        </div>
                                </td>
                            @else
                                <td style="text-align: center;">
                                    NO SE HA PUBLICADO
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
    <div class="panel panel-default">
        <div class="table-responsive">
            <table class="table table-hover" style="text-align: center;">
                <thead>
                    <tr>
                        <th>Num Oferta</th>
                        <th>Num Negocio</th>
                        <th>Cliente</th>
                        <th>Tipo Proceso</th>                        
                        <th>Cargo</th>
                        <th># Vacantes</th>
                        <th>Fecha radicación</th>
                        <th>Fecha limite</th>
                        <th>Días gestión</th>
                        <th>Publicada</th>
                        <th style="text-align: center;"> Compartir </th>
                        <th>Acción</th>
                    </tr>
                </thead>

                <tbody>
                    @if($requerimientos->count() == 0)
                        <tr>
                            <td colspan="5">No se encontraron registros</td>
                        </tr>
                    @endif

                    @foreach($requerimientos as $requerimiento)
                        <tr>
                            {{--<td>
                                {!! Form::checkbox("req_id[]", $requerimiento->req_id, null, [
                                    "data-url" => route('admin.editar_oferta', [
                                        "req_id" => $requerimiento->req_id,
                                        "cargo_id" => $requerimiento->cargo_id
                                    ])
                                ]) !!}
                            </td>--}}

                            <td><b>{{ $requerimiento->req_id }}</b></td>
                            <td>{{ $requerimiento->num_negocio }}</td>
                            <td>{{ $requerimiento->nombre_cliente }}</td>
                            <td>{{ $requerimiento->tipo_proceso_desc }}</td>
                            <td>{{ $requerimiento->cargo }}</td>
                            <td>{{ $requerimiento->num_vacantes }}</td>
                            <td>{{ $requerimiento->created_at }}</td>
                            <td>{{ $requerimiento->fecha_ingreso }}</td>
                            <td>{{ $requerimiento->dias_gestion }}</td>
                            
                            <td>
                                {{ (($requerimiento->estado_publico == 0 ) ? "NO" : "SI") }}
                            </td>

                            @if($requerimiento->estado_publico == 1 && $requerimiento->estado_requerimiento != config('conf_aplicacion.C_TERMINADO'))
                                <td>
                                    <div class="container" style="width: 250px;">
                                        <div class="row" style="width: 250px; text-align: center;">
                                            <div style="width:250px;">

                                                <a target="_blank" title="Compartir en Facebook" href="https://www.facebook.com/sharer/sharer.php?u={{ route('home.detalle_oferta', ['oferta_id' => $requerimiento->req_id]) }}" class="btn btn-icon btn-facebook mx-1">
                                                    <i class="fa fa-facebook-f fa-1ix"></i>
                                                </a>

                                                <a target="_blank" title="Compartir en Whatsapp" href="https://api.whatsapp.com/send?text=Hola!%20te comparto%20esta%20oportunidad%20de%20empleo%20{{ route('home.detalle_oferta', ['oferta_id' => $requerimiento->req_id]) }}" class="btn btn-icon btn-whatsapp mx-1 aplicar_oferta">
                                                    <i class="fa fa-whatsapp fa-1ix"></i>
                                                </a>

                                                <a target="_blank" href="{{ route('enviar_email', ['id'=>$requerimiento->req_id]) }}"  class="btn btn-icon btn-email btn-primary mx-1 aplicar_oferta">
                                                    <i class="fa fa fa-envelope fa-1ix"></i>
                                                </a>

                                                {{-- URL --}}
                                                <a href='javascript:void();' title="Copiar enlace" class="btn btn-icon btn-dark mx-1 aplicar_oferta" onclick='var copiar="{{route('home')}}"+"/detalle/"+"{{$requerimiento->req_id}}";var a=document.createElement(&quot;input&quot;);a.setAttribute(&quot;value&quot;,copiar),document.body.appendChild(a),a.select(),document.execCommand(&quot;copy&quot;),document.body.removeChild(a);var c=document.createElement(&quot;style&quot;),e=document.createTextNode(&quot;#av{position:fixed;z-index:999999;width:120px;top:30%;left:50%;margin-left:-60px;padding:20px;background:gold;border-radius:8px;font-size: 14px;font-family:sans-serif;text-align:center;}&quot;);c.appendChild(e),document.head.appendChild(c);var av=document.createElement(&quot;div&quot;);av.setAttribute(&quot;id&quot;,&quot;av&quot;);var c=document.createTextNode(&quot;URL copiada&quot;);av.appendChild(c),document.body.appendChild(av),window.load=setTimeout(&quot;document.body.removeChild(av)&quot;,2e3);'>
                                                    <i class="fa fa-clone fa-1ix"></i>
                                                </a>

                                                <input type="hidden" id="url" value="{{ route('home.detalle_oferta', ['oferta_id' => $requerimiento->req_id]) }}">
                                        
                                                <a target="_blank" title="Compartir en Linkedin" href="https://www.linkedin.com/sharing/share-offsite/?url={{ route('home.detalle_oferta', ['oferta_id' => $requerimiento->req_id]) }}" class="btn btn-icon btn-linkedin mx-1">
                                                    <i class="fa fa-linkedin fa-1ix"></i>
                                                </a>

                                                <a target="_blank" title="Compartir en Twitter" href="https://twitter.com/intent/tweet?text=Hola!%20te comparto%20esta%20oportunidad%20de%20empleo%20{{ rawurlencode(route('home.detalle_oferta', ['oferta_id' => $requerimiento->req_id])) }}" class="btn btn-icon btn-twitter mx-1">
                                                    <i class="fa fa-twitter fa-1ix"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            @else
                                <td style="text-align: center;">
                                    NO SE HA PUBLICADO
                                </td>
                            @endif
                            <td>
                                <a class="btn btn-default | tri-br-2 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-200 tri-hover-out-purple"  href='{{ route("admin.editar_oferta", ["req_id" => $requerimiento->req_id,"cargo_id"=>$requerimiento->cargo_id]) }}'>
                                    Editar
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
    @endif

    {{-- {!! $requerimientos->appends(Request::all())->render() !!} --}}

    @if(Session::has("mensaje_no_postulados") && Session::get("mensaje_no_postulados") != null)
        <?php
            $mensaje = Session::get("mensaje_no_postulados");
        ?>
        <script>
            $(function () {
                mensaje_danger("{!! $mensaje !!}");
            });
        </script>
    @endif

    <script>
        $(function(){
            $('.js-select-2-basic').select2({
                placeholder: 'Selecciona o busca un cliente'
            });

            // Executa o evento click no button
            /*$('.copy').click(function(){
                // Seleciona o conteúdo do input
                var ruta = $(this).data('ruta');
                //alert(ruta);
                //ruta.select();
                // Copia o conteudo selecionado
                var copiar = document.execCommand('copy');
                // Verifica se foi copia e retona mensagem
                if(copiar){
                    alert('Copiado');
                }else {
                    alert('Erro ao copiar, seu navegador pode não ter suporte a essa função.');
                }
                // Cancela a execução do formulário
                return false;
            });*/
        });
    </script>

    <script src="https://apis.google.com/js/platform.js" async defer>
        {lang: 'es-419', parsetags: 'explicit'}
    </script>
    
    <script src="//platform.linkedin.com/in.js" type="text/javascript"> lang: es_ES</script>

    <script>
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            
            js = d.createElement(s); js.id = id;
            js.src = 'https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.12&appId=1419935801389982&autoLogAppEvents=1';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
@stop
