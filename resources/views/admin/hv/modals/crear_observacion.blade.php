<div class="modal-header">
<h2>Crear Observación</h2>
  {{--<button type="button" class="close" data-dismiss="modal"  aria-label="Close"><span aria-hidden="true">&times;</span></button>--}}
</div>
<div class="modal-body modd">
    {!! Form::model(Request::all(),["id"=>"fr_observacion_hv"]) !!}
    {!! Form::hidden("candidato_id",$candidato->id,["id"=>"candidato_req_fr"]) !!}

   
    <h4>{{$candidato->name}}</h4>
     {{-- {{ dd($contra_clientes) }} --}}
    <br>
    <br>
     
    <div class="col-md-12 form-group">
     <label for="inputEmail3" class="col-sm-2 control-label"> Observación: </label>
       <div class="col-sm-8">
        {!! Form::textarea('observacion',null,['class'=>'form-control', 'rows' => 3]) !!}
       </div>
      <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observacion",$errors) !!}</p>
    </div>
    
    {!! Form::close() !!}

<br>
<br>
<br>
<br>


<h3>Observaciones</h3>

<div class="clearfix"></div>
<div class="tabla table-responsive">
    <table class="table table-bordered table-hover ">
        <thead>
            <tr>
                <th style="text-align: center;">N°</th>
                <th style="text-align: center;" >Descripción</th>
                <th style="text-align: center;" >Usuario gestionó</th>
                <th style="text-align: center;" >Fecha Creación</th>
              
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
                <td style="text-align: center;">{{++$key}}</td>
                <td style="text-align: center;">{{$observaciones->observacion}}</td>
                <td style="text-align: center;">{{$observaciones->nombre}}</td>
                <td style="text-align: center;">{{$observaciones->created_at}}</td>
               
             
                
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
    <div class="clearfix"></div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

    <button type="button" class="btn btn-success" id="guardar_observacion" >Guardar</button>

</div>

<style >
    
.modd{
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
