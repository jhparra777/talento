<section class="header">
    <div id="intro">
        <div class="logo-menu">
            <nav class="navbar navbar-default" data-offset-top="50" data-spy="affix" role="navigation">
                <div class="container">
                    <div class="navbar-header">
                        <button class="navbar-toggle" data-target="#navbar" data-toggle="collapse" type="button">
                            <span class="sr-only">
                                Toggle navigation
                            </span>
                            <span class="icon-bar">
                            </span>
                            <span class="icon-bar">
                            </span>
                            <span class="icon-bar">
                            </span>
                        </button>
                        <a class="navbar-brand" href="{{route('home')}}">
                            @if(isset($sitio->logo))
                                @if($sitio->logo != "")
                                    @if(route("home")=="https://gpc.t3rsc.co")
                                        <img alt="" height="80" src="{{ url('configuracion_sitio')}}/{{ $sitio->logo }}" style="margin-top: -2rem;">
                                    @else
                                        <img alt="" height="50" src="{{ url('configuracion_sitio')}}/{{ $sitio->logo }}">
                                    @endif
                                    
                                @else
                                    <img alt="" height="50" src="{{url('img/logo.png')}}">
                                @endif
                            @else
                                <img alt="" height="50" src="{{url('img/logo.png')}}">
                            @endif
                        </a>
                    </div>
                    <div class="collapse navbar-collapse" id="navbar">
                        <!-- Start Navigation List -->
                        <ul class="nav navbar-nav">

                            @foreach($menu as $m)

                                <li>
                                    <a class='active' href="{{route($m->ruta)}}">
                                        {{$m->descripcion}}
                                    </a>
                                </li>


                            @endforeach
                            {{--<li>
                                <a class="active" href="{{route('home')}}">
                                    Inicio
                                </a>
                            </li>
                            <li>
                                <a class="active" href="{{route('registrarse')}}">
                                    @if(route("home")=="https://expertos.t3rsc.co")
                                        Registrar Datos
                                    @else

                                    Registrar Hoja de Vida

                                    @endif
                                </a>
                            </li>
                            <li>
                                <a class="active" href="{{route('empleos')}}">
                                     @if(route("home")=="https://expertos.t3rsc.co")
                                        Buscar Oportunidades
                                    
                                    @elseif(route("home")=="https://gpc.t3rsc.co")
                                        Oportunidades

                                     @else
                                        Buscar Empleo

                                    @endif
                                </a>
                            </li>
                            --}}
                            <li class="web-corporativa">
                                @if(isset($sitio->web_corporativa))
                                    @if($sitio->web_corporativa != "")
                                        <a class="active" href="{{ $sitio->web_corporativa }}" target="_blank">
                                            Sobre Nosotros
                                        </a>
                                    @else
                                        <a class="active" href="http://desarrollo.t3rsc.co" target="_blank">
                                            Sobre Nosotros
                                        </a>
                                    @endif
                                @else
                                    <a class="active" href="http://desarrollo.t3rsc.co" target="_blank">
                                        Sobre Nosotros
                                    </a>
                                @endif
                            </li>
                        </ul>
                        @if (Sentinel::check())
                        <ul class="nav navbar-nav navbar-right float-right">
                            <li class="left">
                                <a href="{{route('dashboard')}}" style="text-transform: none;">
                                    <i class="glyphicon glyphicon-user">
                                    </i>
                                    Mi perfil
                                </a>
                            </li>
                            <li class="right">
                                <a href="{{route('logout_cv')}}" style="text-transform: none;">
                                    <i class="glyphicon glyphicon-log-out">
                                    </i>
                                    Salir
                                </a>
                            </li>
                        </ul>
                        @else
                        <ul class="nav navbar-nav navbar-right float-right">
                            <li class="left">
                                <a href="{{route('registrarse')}}" style="text-transform: none;">
                                    <i class="ti-pencil-alt">
                                    </i>
                                    @if(route("home")=="https://gpc.t3rsc.co")
                                    Regístrate
                                    @else

                                    Registro

                                    @endif
                                </a>
                            </li>
                            <li class="right">
                                <a href="{{route('login')}}" style="text-transform: none;color:white !important;" class="btn-common btn-primario active">
                                    <i class="ti-lock">
                                    </i>
                                    Iniciar sesión
                                </a>
                            </li>
                        </ul>
                        @endif
                    </div>
                </div>
                <!-- Mobile Menu Start -->
                <ul class="wpb-mobile-menu">
                    <li>
                        <a class="active" href="{{route('home')}}">
                            Inicio
                        </a>
                    </li>
                    <li>
                        <a href="{{route('registrarse')}}">
                            Registrar Hoja de Vida
                        </a>
                    </li>
                    <li>
                        <a href="{{route('empleos')}}">
                            Buscar Empleo
                        </a>
                    </li>
                    <li>
                        @if(isset($sitio->web_corporativa))
                            @if($sitio->web_corporativa != "")
                                <a href="{{ $sitio->web_corporativa }}" target="_blank">
                                    Sobre Nosotros
                                </a>
                            @else
                                <a href="http://desarrollo.t3rsc.co" target="_blank">
                                    Sobre Nosotros
                                </a>
                            @endif
                        @else
                            <a href="http://desarrollo.t3rsc.co" target="_blank">
                                Sobre Nosotros
                            </a>
                        @endif
                    </li>
                    <li class="btn-m">
                        <a href="{{route('registrarse')}}">
                            <i class="ti-pencil-alt">
                            </i>
                            Registro
                        </a>
                    </li>
                    <li class="btn-m">
                        <a href="{{route('login')}}" style="text-transform: none;color:white !important;" class="btn-common btn-primario active">
                            <i class="ti-lock">
                            </i>
                            Iniciar sesión
                        </a>
                    </li>
                </ul>
                <!-- Mobile Menu End -->
            </nav>
        </div>
    </div>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-116394427-1">
    </script>
    <script>
        window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-116394427-1');
    </script>
</section>
