{!! Form::open(["id"=>"fr_nueva_prueba","files"=>true]) !!}
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Pruebas Realizadas</h4>
</div>
<div class="modal-body">

    @foreach($pruebas as $prueba)
    <div class="container_referencia">
        <div class="referencia">
            <table class="table table-bordered tbl_info" style="margin-bottom: 0px">
                <tr>
                    <th>Prueba</th>
                    <td>{{$prueba->prueba_desc}}</td>

                    <th>Fecha creación</th>
                    <td>{{$prueba->created_at}}</td>
                </tr>

                <tr>
                    <th>Archivo</th>
                    <td><a href="{{url("recursos_pruebas/".$prueba->nombre_archivo)}}" target="_blanck">Archivo</a></td>
                    <th>Fecha Vencimiento</th>
                    <td>{{$prueba->fecha_vencimiento}}</td>
                </tr>
                <tr>
                    <td colspan="4">
                        @if($prueba->fecha_vencimiento >= $fecha)
                            <div class="alert alert-success">
                                <strong>Prueba Vigente.</strong> 
                            </div>
                        @else
                            <div class="alert alert-danger">
                                <strong>Prueba vencida.</strong> 
                            </div>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
      
    </div>
    @endforeach
</div>
    

    <div class="clearfix"></div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

</div>

{!! Form::close() !!}