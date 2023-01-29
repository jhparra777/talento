
<div class="container">
    <div class="row">
        <table class="table table-bordered">
            <tr>
                <th class='active'>Requisiones Abiertas</th>
                <th class='active'>Requisiones Cerradas a Tiempo</th>
                <th class='active'>N&uacute;mero de contrataciones</th>
                <th class='active'>Enviadas a Aprobaci&oacute;n</th>
            </tr>
            <tr>
                <td>{{$data['abiertas']}}</td>
                <td>{{$data['cerradas']}}</td>
                <td>{{$data['contratadas']}}</td>
                <td>{{$data['enviadas_aprobacion']}}</td>
            </tr>
        </table>
    </div>
</div>


