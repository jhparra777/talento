@extends("admin.layout.master")
@section('contenedor')

   <h3>Examenes Médicos</h3>

    {{--{!! Form::model(Request::all(),["route"=>"admin.contratacion.lista_examenes", "method"=>"GET"]) !!}

        @if(Session::has("mensaje_success"))

            <div class="col-md-12" id="mensaje-resultado">
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{Session::get("mensaje_success")}}
                </div>
            </div>

        @endif

        <div class="row">

            <div class="col-md-6 form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">ID:</label>

                <div class="col-sm-10">
                    {!! Form::text("id_proveedor",null,["class"=>"form-control solo-numero","id"=>"time"]); !!}
                </div>
            </div>--}}

              

   
            {{--<div class="col-md-6 form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Tipo Proveedor:</label>
                
                <div class="col-sm-10">
                    {!! Form::select('tipo_proveedor',$tipo_proveedores, null, ['id'=>'tipo_proveedor','class'=>'form-control']) !!}
                </div>
            </div>

       
        </div>

        <div class="clearfix"></div>
        
        {!! Form::submit("Buscar",["class"=>"btn btn-success"]) !!}

        <a class="btn btn-danger" href="{{route("admin.contratacion.lista_examenes")}}">Limpiar</a>
        

    {!! Form::close() !!}--}}
    <button class="btn btn-success pull-right" id="nuevo_examen">
            <span class="glyphicon glyphicon-plus-sign"></span> Nuevo examen
    </button>

    <br>



        <div class="clearfix"></div>
         
        <div class="tabla table-responsive">
            <table class="table table-bordered table-hover ">
                <thead>
                    <tr>
                        
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th>Acción</th>
                       
                    </tr>
                </thead>
                <tbody>
                	   @foreach($examenes as $examen)
                	   	<tr @if($examen->status==0)style="background-color: rgb(210,210,210,.4)"  @endif>
                	   		<td>{{$examen->nombre}}</td>
                	   		<td>{{$examen->descripcion}}</td>
                	   		<td>
                                @if($examen->status==1)
                                    ACTIVO
                                @else
                                    INACTIVO
                                @endif      
                            </td>
                	   		<td><button class="btn btn-warning editar-examen" data-id="{{$examen->id}}">Editar</button></td>
                	   	</tr>
                	   @endforeach
                   
                </tbody>
            </table>

        </div>

    
            </table>

        </div>



</script>
    <script type="text/javascript">

        $(function () {

            $('.js-select-2-basic').select2({
                placeholder: 'Selecciona o busca'
            });
            
            $(document).on("click",".asignar_psicologo", function () {

            var req_id = $(this).data("req_id");
            
            var cliente_id = $(this).data("cliente_id");
                $.ajax({
                    data: {req_id: req_id, cliente_id: cliente_id},
                    url: "{{route('admin.asignar_psicologo')}}",
                    success: function (response) {
                        $("#modal_peq").find(".modal-content").html(response);
                        $("#modal_peq").modal("show");
                    }
                });
            }); 
       
            $

            $(document).on("click", "#nuevo_examen", function () {
                
                $.ajax({
                    type: "POST",
                    data:{
                    	valor:"valor"
                    },
                    url: "{{ route('admin.contratacion.nuevo-examen')}}",
                    success: function(response) {

                        
                            $("#modal_gr").find(".modal-content").html(response);
                            $("#modal_gr").modal("show");
                            //$("#modal_med").modal("hide");
                             //mensaje_success("Proveedor creado");
                             //location.reload();
                         
                    }
                });
            });

            $(document).on("click", "#guardar_examen", function () {
                
                $.ajax({
                    type: "POST",
                    data: $("#fr_nuevo_examen").serialize(),
                    url: "{{ route('admin.contratacion.guardar-examen')}}",
                    success: function(response) {

                        
                           
                            $("#modal_gr").modal("hide");
                            //$("#modal_med").modal("hide");
                             mensaje_success("Examen creado");
                             location.reload();
                         
                    }
                });
            });
            $(document).on("click", ".editar-examen", function () {
                
               var id=$(this).data("id");
                $.ajax({
                    type: "POST",
                    data:{
                        id:id
                    },
                    url: "{{ route('admin.contratacion.editar-examen')}}",
                    success: function(response) {

                            $("#modal_gr").find(".modal-content").html(response);
                            $("#modal_gr").modal("show");
                         
                    }
                });
            });
             $(document).on("click", "#confirmar_editar_examen", function () {
                
                $.ajax({
                    type: "POST",
                    data: $("#fr_editar_examen").serialize(),
                    url: "{{ route('admin.contratacion.confirmar-editar-examen')}}",
                    success: function(response) {

                        
                           
                            $("#modal_gr").modal("hide");
                            //$("#modal_med").modal("hide");
                             mensaje_success("Examen modificado");
                             location.reload();
                         
                    }
                });
            });

            
             $('#time').timepicker();


       });
     
    </script>

@stop