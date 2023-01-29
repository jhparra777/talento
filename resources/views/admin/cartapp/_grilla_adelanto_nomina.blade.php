<div class="container">
    <div class="row">
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th>Cuenta Origen</th>
                    <th>Subcuenta</th>
                    <th>Id Destino</th>
                    <th>Beneficiario</th>
                    <th>Tipo Cuenta</th>
                    <th>Cuenta Destino</th>
                    <th>Código Entidad</th>
                    <th>Valor</th>
                    <th>Concepto</th>
                    <th>Correo</th>
                </tr>

                <tbody>
                    @forelse($solicitudes as $count => $lista)
                        <tr>
                            <td>58030004675</td>
                            <td>{{-- En blanco subcuenta --}}</td>
                            <td>{{ $lista->numero_id }}</td>
                            <td>{{ $lista->nombres." ".$lista->primer_apellido." ".$lista->segundo_apellido }}</td>
                            <td>
                                @if(is_null($lista->tipo_cuenta))
                                    @if($lista->banco_nomina->descripcion == 'Nequi' || $lista->banco_nomina->descripcion == Daviplata)
                                        CH
                                    @endif
                                @else
                                    {{ $lista->tipo_cuenta_banco()->cod_tipo }}
                                @endif
                            </td>
                            <td>{{ $lista->banco_nomina->descripcion }}</td>
                            <td>{{ $lista->banco_nomina->homologa_id }}</td>
                            <td>{{ $lista->valor_solicitud }}</td>
                            <td>Adelanto de nómina CartApp</td>
                            <td>{{ $lista->email }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">No se encontraron registros.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>