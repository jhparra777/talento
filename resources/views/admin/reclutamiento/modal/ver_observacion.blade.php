<div class="modal-header">
    <button type="button" class="close" style="overflow-y: scroll;" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    
</div>
<div class="modal-body modd">

<h3>Observaciones</h3>

<div class="clearfix"></div>
<div class="tabla table-responsive  lol">
    <table class="table table-bordered table-hover ">
        <thead>
            <tr>
                <th style="text-align: center;">N°</th>
                <th style="text-align: center;">Descripción</th>
                <th style="text-align: center;">Usuario gestionó</th>
                <th style="text-align: center;">Fecha Creación</th>
               @if(route("home") == "http://desarrollo.t3rsc.co" || route("home") == "https://desarrollo.t3rsc.co" || route("home") == "http://demo.t3rsc.co" || route("home") == "https://demo.t3rsc.co")
                <th style="text-align: center;">Ultima Vista</th>
               @endif
            </tr>
        </thead>
        <tbody>
            @if($observacion->count() == 0)
            <tr>
                <td colspan="5">No se encontraron registros</td>
            </tr>
            @endif

            @foreach($observacion as $key =>  $observaciones)
            <tr>
                <td>{{++$key}}</td>
                <td>{{$observaciones->observacion}}</td>
                <td>{{$observaciones->nombre}}</td>
                <td>{{$observaciones->created_at}}</td>
                @if(route("home") == "http://desarrollo.t3rsc.co" || route("home") == "https://desarrollo.t3rsc.co" || route("home") == "http://demo.t3rsc.co" || route("home") == "https://demo.t3rsc.co")
                <td>{{$observaciones->UltimaVista()}}</td>
               @endif
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
    <div class="clearfix"></div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

    

</div>
<style >
    
.modd {
    height: 400px;
    overflow-y: auto;
}


</style>

<script>
    $(function () {

        var confDatepicker = {
    altFormat: "yy-mm-dd",
    dateFormat: "yy-mm-dd",
    changeMonth: true,
    changeYear: true,
    buttonImage: "img/gifs/018.gif",
    buttonImageOnly: true,
    autoSize: true,
    dayNames: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
    monthNamesShort: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
    dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
    yearRange: "1930:2050"
};
        $("#fecha_fin_contrato, #fecha_inicio_contrato").datepicker(confDatepicker);
    });
</script>
