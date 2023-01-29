@extends("admin.layout.master")
@section('contenedor')
<h3><i class="fa fa-line-chart" aria-hidden="true"></i> Indicadores</h3>
<hr/>

  <!--SE DEJAN COMENTADO LOS FILTROS PARA FUTURA PETICON-->

{{--
{!! Form::model(Request::all(),["route"=>"admin.reporte.indicadores_eficacia","method"=>"GET","accept-charset"=>"UTF-8"]) !!}
 {!! Form::hidden("cierre","",["id"=>"cierre"]) !!}

    <div class="col-sm-12 form-group">
       <button type="submit" class="btn btn-info pull-right" id="cerrar_mes">Cerrar mes</button>
    </div>
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Fecha Creacion Inicial:</label>
        <div class="col-sm-10">
            
            {!! Form::text("fecha_carga_ini",null,["class"=>"form-control","placeholder"=>"Fecha Inicio","id"=>"fecha_carga_ini" ]); !!}
        </div>
    </div>
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Fecha Creacion Final:</label>
        <div class="col-sm-10">
            {!! Form::text("fecha_carga_fin",null,["class"=>"form-control","placeholder"=>"Fecha Final","id"=>"fecha_carga_fin" ]); !!}
            
        </div>
    </div>
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Fecha Tentativa Inicial:</label>
        <div class="col-sm-10">
            
            {!! Form::text("fecha_tenta_ini",null,["class"=>"form-control","placeholder"=>"Fecha Inicio","id"=>"fecha_tenta_ini" ]); !!}
        </div>
    </div>

     <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Fecha Tentativa Final:</label>
        <div class="col-sm-10">
            {!! Form::text("fecha_tenta_fin",null,["class"=>"form-control","placeholder"=>"Fecha Final","id"=>"fecha_tenta_fin" ]); !!}
            
        </div>
    </div>

    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Tipo Proceso:</label>
        <div class="col-sm-10">
           {!! Form::select("proceso_id",$tipo_solicitud,null,["class"=>"form-control" ]); !!}
        </div>
    </div>

    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Usuarios:</label>
        <div class="col-sm-10">
           {!! Form::select("user_id",$usuarios_gestionan,null,["class"=>"form-control" ]); !!}
        </div>
    </div>
     <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Estado req:</label>
        <div class="col-sm-10">
           {!! Form::select("estado_id",$estados_requerimiento,null,["class"=>"form-control"]); !!}
        </div>
    </div>
      <div class="col-md-6 form-group">
       
    </div>
    
    <button type="submit" class="btn btn-success">Generar</button>

    <div class="clearfix"></div>
        
    <!--<a class="btn btn-success" href="#" role="button" id="export_excel_btn"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</a>
    <a class="btn btn-danger" href="#" role="button" id="export_pdf_btn"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF</a>-->
{!! Form::close() !!}
</br>
--}}
<div class="container">
    
    <div class="row">
{!! Form::model(Request::all(),["route"=>"admin.distribucion_perfilamiento","method"=>"GET","accept-charset"=>"UTF-8"]) !!}
  
    <div class="col-md-6 form-group">
      <label class="col-sm-2 control-label" for="inputEmail3">
          Fecha Inicio:
      </label>
      
      <div class="col-sm-10">
        {!! Form::text("fecha_inicio",null,["class"=>"form-control","placeholder"=>"Fecha Inicio","id"=>"fecha_inicio" ]); !!}
      </div>
    </div>

    <div class="col-md-6 form-group">
      <label class="col-sm-2 control-label" for="inputEmail3">
        Fecha Final:
      </label>
      <div class="col-sm-10">
        {!! Form::text("fecha_final",null,["class"=>"form-control","placeholder"=>"Fecha Final","id"=>"fecha_final" ]); !!}
      </div>
    </div>
</div>
 <div class="row">
         <div class="col-sm-12 col-offset-sm-6" style="text-align: center;">
             <button class="btn btn-success" type="submit">Buscar</button>
         </div>
     </div>
{!! Form::close() !!}
   

    
    
</div>
<div class="container">
       
    <div class="row">

        <div class="tabla table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Cargo</th>
                        <th class="text-left">Candidatos</th>
                    </tr>
                </thead>
                <tbody>
                     @foreach($cargos as $cargo)
                           <tr>
                              <td>{{$cargo->cargo}}</td>
                              <td class="text-left cantidad">
                                <a class="btn btn-success cantidad" href="#" id="export_excel_btn" role="button" data-id="{{$cargo->id_cargo}}">
                                    
                                   {{$cargo->cantidad}}
                                </a>
                                
                              </td>

                            </tr>

                        @endforeach
                            <tr>
                              <td>SIN PERFILAMIENTO</td>
                              <td>{{$otros}}</td>
                            </tr>

                            <tr>
                              <th>Total</th>
                              <th class="text-left">{{$total+$otros}}</th>
                            </tr>
                </tbody>

            </table>


        </div>
  
    </div>
</div>


<script type="text/javascript">
    $(function(){
          $("#fecha_inicio, #fecha_final").datepicker(confDatepicker);

         

          $('.cantidad').click(function(){
            //$data_form = $('#filter_form').serialize();
            $fecha_inicio = $("#fecha_inicio").val();
            $fecha_final = $("#fecha_final").val();
            $cargo_id = $(this).data("id");
          
            
            $(this).prop("href","{{ route('admin.distribucion_perfilamiento_excel') }}"+"?&fecha_inicio="+$fecha_inicio+"&fecha_final="+$fecha_final+"&cargo_id="+$cargo_id);
        });
    })
</script>
 @stop