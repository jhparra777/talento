<div class="container">
    <div class="row">
        <div class="table-responsive">
            <table class="table">
                <tr>
                    @foreach($headers as $key => $value)
                        <th class="active">
                            {{ $value }}
                        </th>
                    @endforeach
                </tr>

                @foreach($consulta as $field)
                    <tr>
                        <td>
                            {{ $field->name }}
                        </td>

                        <td>{{ $field->email }}</td>

                        <td>
                            @if($field->inRole("admin"))
                                <span class="badge"> Administración</span>
                            @endif

                            @if($field->inRole("req"))
                                <span class="badge">Requisición</span>
                            @endif

                            @if($field->inRole("hv"))
                                <span class="badge">Hoja de vida</span>
                            @endif
                        </td>
                           
                        <td>
                            {{ $field->estado }}
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>