{{-- Menu de opciones para candidato--}}

<?php
    $sitioModulo = FuncionesGlobales::sitioModulo();
?>
<ul>
    @foreach($menu as $menu)
        @if (\Route::has($menu->ruta))
            @if ($menu->ruta == 'cv.adelantos_nomina' && $sitioModulo->carta_app != 'enabled' && !$sitioModulo->tieneContrato())
                <?php
                    //Si la ruta es adelantos de nomina y el modulo no esta activo y el candidato no ha sido contratado; entonces no muestra el menu
                    continue;  //Siguiente iteracion del ciclo
                ?>
            @endif
            <li class="{!! FuncionesGlobales::activeLink($menu->ruta) !!}">
                <a href="{{route($menu->ruta)}}" @if($menu->ruta == 'cv.hv_pdf') target="_blank" @endif>
                    @if($menu->check)
                        @if($porcentaje[$menu->ruta]==100)
                            <i class="fa fa-check-circle-o" style="color: green;float: left;"></i>
                        @else
                            <i class="fa fa-circle-thin" style="float: left;"></i>
                        @endif
                    @endif
                    <i class="{{$menu->icono}}"></i>
                    {{$menu->descripcion}}
                </a>
            </li>
        @endif
    @endforeach
    <li data-target="#cargar_hv" data-toggle="modal">
        <a class="cargar_hv">
            <i class="fa fa-suitcase"></i>
            @if(route("home")=="https://humannet.t3rsc.co")
                Cargar Currículo
            @else
                Cargar Hoja de Vida
            @endif
        </a>
    </li>

    <li class="">
        <a href="{{ route('logout_cv')}}">
            <i class="fa fa-sign-out"></i> Salir
        </a>
    </li>
</ul>
