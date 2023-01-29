@extends("home.layout.master")
@section('content')
    <div class="page-header" style="background: url({{ url('assets/img/banner1.jpg') }});">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-wrapper">
                        <h2 class="product-title">Detalle Oferta</h2>
                        
                        <ol class="breadcrumb">
                            <li><a href="{{ route('home') }}"><i class="ti-home"></i> Inicio</a></li>
                            <li style ="color :blue;">Detalle Oferta</li>
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

                        {{-- Mostrar alert si ha compartido la oferta por correo --}}
                        @if(Session::has('status'))
                            <div class="alert alert-info" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>

                                <strong>Se ha enviado el correo a su destinatario.</strong> 
                            </div>
                        @endif

                        <div class="detalle_oferta">
                            <hr>

                            <div class="row">
                                <div class="col-md-3">
                                    @if($requerimientos->confidencial!="1")
                                        @if(isset($sitio->logo))
                                            @if($sitio->logo != "")
                                                <img alt="logo" class="img-responsive" src="{{ url('configuracion_sitio')}}/{{$sitio->logo }}">
                                            @else
                                                <img alt="logo" class="img-responsive" src="{{url('img/logo.png')}}">
                                            @endif
                                        @else
                                            <img alt="logo" class="img-responsive" src="{{url('img/logo.png')}}">
                                        @endif
                                    @else
                                        <img alt="Importante empresa" src="">
                                    @endif
                                </div>

                                <div class="col-md-8">
                                    <h3>{{ ucfirst(mb_strtolower($requerimientos->nombre_subcargo,'UTF-8')) }}</h3>
                                    
                                    @if(route("home") != "https://asuservicio.t3rsc.co")
                                        <h4><b>{!! ucfirst(mb_strtolower($requerimientos->nombre_cargo,'UTF-8')) !!}</b></h4>
                                    @endif

                                    <br>

                                    @if (route('home') != 'http://gpc.t3rsc.co')
                                        <label  class=" control-label"><b>Salario:</b></label>
                                        <strong class="price">${!! number_format($requerimientos->salario, null, null, ".") !!}</strong>
                                    @endif
                                </div>
                            </div>

                            <hr>
                                
                            <div style="text-align: center;" class="form-group">
                                <h3 style="text-align: center;">
                                    <strong><u>Comparte con tus contactos esta oportunidad de empleo</u></strong>
                                </h3>
                                <br>
                                
                                <div class="fb-share-button" data-href="{{ route('home.detalle_oferta', ['oferta_id' => $requerimientos->id]) }}" data-layout="button" data-size="large" data-mobile-iframe="true">
                                    <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fsoluciones.t3rsc.co%2Fdetalle%2F280&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore"></a>
                                </div>

                                <a target="_blank" href="{{ route("enviar_email", ["oferta_id" => $requerimientos->id]) }}" class="btn  btn-sm btn-primary aplicar_oferta">
                                    <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
                                    <strong></strong>
                                </a>

                                <a target="_blank" href="https://api.whatsapp.com/send?phone=numero&text=Hola!%20te comparto%20esta%20oportunidad%20de%20empleo%20{{ route('home.detalle_oferta', ['oferta_id' => $requerimientos->id]) }}" class="btn  btn-sm  btn-success aplicar_oferta">
                                    <span class="fa fa-whatsapp fa-lg" aria-hidden="true"></span>
                                </a>

                                <a href='javascript:void();' class="btn  btn-sm btn-primary aplicar_oferta" onclick='var a=document.createElement(&quot;input&quot;);a.setAttribute(&quot;value&quot;,window.location.href.split(&quot;?&quot;)[0].split(&quot;#&quot;)[0]),document.body.appendChild(a),a.select(),document.execCommand(&quot;copy&quot;),document.body.removeChild(a);var c=document.createElement(&quot;style&quot;),e=document.createTextNode(&quot;#av{position:fixed;z-index:999999;width:120px;top:30%;left:50%;margin-left:-60px;padding:20px;background:gold;border-radius:8px;font-size: 14px;font-family:sans-serif;text-align:center;}&quot;);c.appendChild(e),document.head.appendChild(c);var av=document.createElement(&quot;div&quot;);av.setAttribute(&quot;id&quot;,&quot;av&quot;);var c=document.createTextNode(&quot;URL copiada&quot;);av.appendChild(c),document.body.appendChild(av),window.load=setTimeout(&quot;document.body.removeChild(av)&quot;,2e3);'><span class="glyphicon  glyphicon-duplicate" aria-hidden="true"></span><strong>  URL</strong></a>
                                
                                <div  style="text-align: center;" class="form-group">
                                    <script type="IN/Share" data-url="{{route('home.detalle_oferta',['oferta_id' => $requerimientos->id]) }}"></script>
                                    <div class="g-plus" data-action="share" data-annotation="none"  data-href="{{ route('home.detalle_oferta', ['oferta_id' => $requerimientos->id]) }}">
                                    </div>
                                    <a href="{{route('home.detalle_oferta',['oferta_id' => $requerimientos->id]) }}" class="twitter-share-button" data-show-count="false">Tweet</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                                </div>
                            </div>

                            <hr>
                            
                            <div class="col-md-12 form-group">
                                <label for="inputEmail3" class="col-sm-12 control-label"><b>Localización:</b></label>
                                <div class="col-sm-12">{!! ucwords(mb_strtolower($requerimientos->ciudad_seleccionada, 'UTF-8')) !!}</div>
                            </div>

                            <div class="col-md-12 form-group">
                                <label for="inputEmail3" class="col-sm-12 control-label"><b>Jornada:</b></label>
                                <div class="col-sm-12">
                                    {!! $requerimientos->tipo_jornada !!}
                                </div>
                            </div>

                            <div class="col-md-12 form-group">
                                <label for="inputEmail3" class="col-sm-12 control-label"><b>Tipo de experiencia:</b></label>
                                <div class="col-sm-12">
                                    {!! $requerimientos->tipo_experiencia !!}
                                </div>
                            </div>

                            <div class="col-md-12 form-group">
                                <label for="inputEmail3" class="col-sm-12 control-label"><b>Descripción:</b></label>
                                <div class="col-sm-12">
                                    <p> {!! $requerimientos->descripcion_oferta !!}</p>     
                                </div>
                            </div>

                            @if($candidato == null)
                                <a 
                                    target="_black" 
                                    id="asistencia" 
                                    data-llamada_id="{{ $llamada_id }}" 
                                    data-numero_id="{{ $candidato_numero_id }}" 
                                    class="btn btn-common"
                                >CONFIRMAR</a>
                                
                                <a 
                                    target="_black" 
                                    id="no_asistencia" 
                                    data-llamada_id="{{ $llamada_id }}" 
                                    data-numero_id="{{ $candidato_numero_id }}" 
                                    class="btn btn-danger"
                                >NO CONFIRMAR</a>
                            @else
                                <a target="_black"  class="btn btn-common " disabled>CONFIRMAR</a>
                                <a target="_black"  class="btn btn-danger " disabled>NO CONFIRMAR</a>
                            @endif
                            
                            <div class="clearfix"></div>
                        </div>
                        <br><br>
                        <div>
                            <div class="thumb"></div>
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
                                            <a>
                                                <img alt="logo" src="{{ url('configuracion_sitio')}}/{!! ((FuncionesGlobales::sitio()->logo)) !!}">
                                            </a>
                                        @else
                                            <a><img alt="logo" src="{{ url('img/logo.png') }}"></a>
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
                                                Desarrollo
                                            @endif
                                        </a>
                                    </h4>

                                    <p>
                                        @if(isset(FuncionesGlobales::sitio()->quienes_somos))
                                            @if(FuncionesGlobales::sitio()->quienes_somos != "")
                                                {!! (FuncionesGlobales::sitio()->quienes_somos) !!}
                                            @else
                                                ...
                                            @endif
                                        @else
                                            ...
                                        @endif
                                    </p>

                                    @if(isset(FuncionesGlobales::sitio()->mision))
                                        @if(FuncionesGlobales::sitio()->mision != "")
                                            <h4><strong>Misión</strong></h4>
                                            <p>{!! (FuncionesGlobales::sitio()->mision) !!}</p>
                                        @else
                                            ...
                                        @endif
                                    @else
                                        ...
                                    @endif

                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>
    
    {{-- Modal para compartir oferta por correo --}}
    {!! Form::open(['route' => ['enviar_email',$requerimientos->id]]) !!}
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

    <script src="https://apis.google.com/js/platform.js" async defer>{lang: 'es-419', parsetags: 'explicit'}</script>
    <script src="//platform.linkedin.com/in.js" type="text/javascript"> lang: es_ES</script>
    <script>
        $(function () {
            function mensaje_success(mensaje) {
                $("#modal_success #texto").html(mensaje);
                $("#modal_success").modal("show");
            }

            $("#asistencia").on("click", function () {
                var numero_id = $(this).data("numero_id");
                var llamada_id = $(this).data("llamada_id");

                $.ajax({
                    type: "POST",
                    data: {llamada_id:llamada_id,numero_id: numero_id},
                    url: "{{ route('home.guardar_asistencia_candidato') }}",
                    success: function(response) {
                        mensaje_success("Se ha registrado su asistenia en el sistema.");
                        location.reload();
                    }
                })
            })

            $("#no_asistencia").on("click", function () {
                var numero_id = $(this).data("numero_id");
                var llamada_id = $(this).data("llamada_id");

                $.ajax({
                    type: "POST",
                    data: {llamada_id:llamada_id,numero_id: numero_id},
                    url: "{{ route('home.guardar_inasistencia_candidato') }}",
                    success: function(response) {
                        mensaje_success("Muchas gracias por participar!");
                        location.href= '{{route('home')}}';
                    }
                })
            })
        })

        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = 'https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.12&appId=1419935801389982&autoLogAppEvents=1';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

        $(document).ready(function() {
            window.history.pushState(null, "", window.location.href);        
            window.onpopstate = function() {
                window.history.pushState(null, "", window.location.href);
            }
        });
    </script>
@stop
