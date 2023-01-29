<div class="row">
    <div class="col-12">
        <h5 class="titulo1">CANDIDATOS POSTULADOS</h5>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="container" id="postulados">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>No.</th>
                    <th>Nombre</th>
                    <th>Cédula</th>
                    <th>Móvil</th>
                    <th>E-mail</th>
                </tr>
                </thead>
                @foreach ($candidatos_postulados as $count => $candidatos)
                <tbody>
                <tr>
                    <td>{{ ++$count }}</td>
                    <td>{{ $candidatos->nombres }}</td>
                    <td>{{ $candidatos->cedula }}</td>
                    <td>{{ $candidatos->celular }}</td>
                    <td>{{ $candidatos->email }}</td>
                </tr>
                </tbody>
                @endforeach
            </table>
        </div>
    </div>
</div>