@if(!empty($adicionales))
    <div class="box box-info collapsed">
        <div class="box-header with-border">
            <h4 class="box-header with-border">ADICIONALES AL REQUERIMIENTO</h4>

            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" type="button"><i class="fa fa-plus"></i></button>
            </div>
        </div>

        <div class="box-body">
            <div class="col-md-12">
                <table class="table">
                    <tr>
                        <th>Descripción</th>
                        <th></th>
                    </tr>

                    @foreach($adicionales as $key => $adicional)
                        @if(preg_match('/{valor_variable}/', $adicional->adicional->contenido_clausula))
                            <tr class="item_adicional">
                                <td>
                                    {{ $adicional->adicional->descripcion }}
                                </td>

                                <td>
                                    <input type="hidden" name="clausulas[]" value="{{ $adicional->adicional->id }}">

                                    <input 
                                        type="text" 
                                        name="valor_adicional[]" 
                                        class="valor_adicional" 
                                        placeholder="Valor variable"
                                        value="{{ $adicional->variableCargo()->valor }}"
                                        maxlength="100"
                                        autocomplete="off" 

                                        data-toggle="tooltip"
                                        data-placement="top"
                                        data-container="body"
                                        title="Debes definir el valor variable para este documento adicional."
                                    >

                                    @if(!preg_match('/{valor_variable}/', $adicional->adicional->contenido_clausula))
                                        <input type="hidden" name="valor_adicional[]" value="0">
                                    @endif
                                </td>
                            </tr>
                        @else
                        @endif
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endif