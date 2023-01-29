@if ($adicionales_cliente->count() > 0)
    @if ($adicionales->count() > 0)
        <div class="col-md-12 mb-1">
            <h5><b>Relacionados con el cliente seleccionado</b></h5>
        </div>
    @endif

    <div>
        <div class="col-md-offset-8 col-md-4 mb-1">
            <input type="text" class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" id="input_adicionales_cliente" onkeyup="filterTable('input_adicionales_cliente',  'table_adicionales_cliente')" placeholder="Buscar">
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th>Descripción</th>
                    <th></th>
                </tr>
            </thead>

            <tbody id="table_adicionales_cliente">
                @foreach($adicionales_cliente as $adicional_cliente)
                    <tr class="item_adicional">
                        <td width="8%">
                            <input type="checkbox" class="contratacion-clausulas" name="clausulas[]" id="check_adicionales" value="{{ $adicional_cliente->id }}"

                            {{ ($adicional_cliente->default) ? 'checked' : '' }}>
                        </td>

                        <td width="40%">
                            {{ $adicional_cliente->descripcion }}
                        </td>

                        @if(preg_match('/{valor_variable}/', $adicional_cliente->contenido_clausula))
                            <td width="40%">
                                <input 
                                    type="text" 
                                    name="valor_adicional[{{ $adicional_cliente->id }}]" 
                                    class="form-control valor_adicional" 
                                    id="valor_adicional" 
                                    placeholder="Valor variable"
                                    maxlength="100"
                                    autocomplete="off" 
                                    disabled

                                    data-toggle="tooltip"
                                    data-placement="top"
                                    data-container="body"
                                    title="Debes definir el valor variable para este documento adicional."
                                >
                            </td>
                        @else
                            {{-- <input type="hidden" name="valor_adicional[]" value="0"> --}}
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if ($adicionales->count() > 0)
        <div class="col-md-12 text-right pd-2">
            <button class="btn btn-sm btn-default" id="vermas_adicionales" type="button" data-toggle="collapse" data-target="#collapseMasAdicionesl" aria-expanded="false" aria-controls="collapseMasAdicionesl">Ver más adicionales</button>
        </div>
    @endif
@endif

@if ($adicionales->count() > 0)
    <div @if($adicionales_cliente->count() > 0) class="collapse" id="collapseMasAdicionesl" @else @endif>
        <div class="col-md-offset-8 col-md-4 mb-1">
            <input type="text" class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" id="input_adicionales_default" onkeyup="filterTable('input_adicionales_default',  'table_adicionales_default')" placeholder="Buscar">
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th>Descripción</th>
                    <th></th>
                </tr>
            </thead>

            <tbody id="table_adicionales_default">
                @foreach($adicionales as $adicional)
                    <tr class="item_adicional">
                        <td width="8%">
                            <input type="checkbox" class="contratacion-clausulas" name="clausulas[]" id="check_adicionales" value="{{ $adicional->id }}"

                            {{ ($adicional->default) ? 'checked' : '' }}>
                        </td>

                        <td width="40%">
                            {{ $adicional->descripcion }}
                        </td>

                        @if(preg_match('/{valor_variable}/', $adicional->contenido_clausula))
                            <td width="40%">
                                <input 
                                    type="text" 
                                    name="valor_adicional[{{ $adicional->id }}]" 
                                    class="form-control valor_adicional" 
                                    id="valor_adicional" 
                                    placeholder="Valor variable"
                                    maxlength="100"
                                    autocomplete="off" 
                                    disabled

                                    data-toggle="tooltip"
                                    data-placement="top"
                                    data-container="body"
                                    title="Debes definir el valor variable para este documento adicional."
                                >
                            </td>
                        @else
                            {{-- <input type="hidden" name="valor_adicional[]" value="0"> --}}
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif