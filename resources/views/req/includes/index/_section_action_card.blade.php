<div class="row">
    <div class="col-md-12 mb-2">
        <h4 class="tri-fw-600 tri-txt-gray-400">Acciones y procesos</h4>
    </div>

    @php
        $i = 0;
    @endphp

    @foreach($menu as $opcion_menu)
        {{-- Cuenta primero los sub menús --}}
        @if($opcion_menu->submenu()->count() > 0)
            @foreach($opcion_menu->submenu() as $submenu)
                @if(Route::has($submenu->slug) && $usuario->hasAccess($submenu->slug))
                    <div class="col-md-4">
                        @include('includes.components._card_action_link', [
                            'link' => route($submenu->slug),
                            'color' => $colores[$i],
                            'icon' => $submenu->icono,
                            'title' => $submenu->descripcion,
                            'description' => isset($conteos[$submenu->slug]) ? $conteos[$submenu->slug] : ""
                        ])
                    </div>
                @endif

                @php
                    $i++;
                @endphp
            @endforeach
        @else
            @if(Route::has($opcion_menu->slug) && $usuario->hasAccess($opcion_menu->slug))
                <div class="col-md-4">
                    @include('includes.components._card_action_link', [
                        'link' => route($opcion_menu->slug),
                        'color' => $colores[$i],
                        'icon' => $opcion_menu->icono,
                        'title' => $opcion_menu->descripcion,
                        'description' => isset($conteos[$opcion_menu->slug]) ? $conteos[$opcion_menu->slug] : ""
                    ])
                </div>
            @endif
        @endif
    @endforeach

    {{-- Cambiar Clave --}}
    <div class="col-md-4">
        @include('includes.components._card_action_link', [
            'link' => route("req_cambiar_pass"),
            'color' => '#dd4b39',
            'icon' => '<i class="fas fa-user-lock"></i>',
            'title' => 'Cambiar clave',
            'description' => 'Actualiza tu contraseña periódicamente'
        ])
    </div>
</div>