 {{-- Menu de opciones para reclutamiento externo--}}

 <ul>
      @foreach($menu as $menu)
        <li class="{!! FuncionesGlobales::activeLink($menu->ruta) !!}">
             <a href="{{route($menu->ruta)}}">
                  <i class="{{$menu->icono}}"></i>
                   {{$menu->descripcion}}
             </a>
        </li>
      @endforeach
       @if(route('home') != "https://tiempos.t3rsc.co" && route('home') != "http://tiempos.t3rsc.co" &&
                                            route('home') != "https://expertos.t3rsc.co" && route('home') != "https://gpc.t3rsc.co")
                                            {{--<li data-target="#cargar_hv" data-toggle="modal">
                                                <a class="cargar_hv">
                                                    <i class="fa fa-suitcase"></i>
                                                    @if(route("home")=="https://humannet.t3rsc.co")
                                                      Cargar Currículo
                                                    @else
                                                       Cargar Hoja de Vida
                                                    @endif
                                                   
                                                </a>
                                            </li>--}}
                                        @endif
       <li class="">
             <a href="{{ route('logout_reclutamiento')}}">
                     <i class="fa fa-sign-out"></i> Salir
              </a>
        </li>
 </ul>