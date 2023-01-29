@extends("admin.layout.master")
@section('contenedor')
<h3>Lista de Cargados de Otras Fuentes</h3>
<br>
{!! Form::model(Request::all(),["id"=>"form-filtro"]) !!}
 @if(Session::has("errores_global") && count(Session::get("errores_global")) > 0)
        <div class="col-md-12" id="mensaje-resultado">
            <div class="divScroll">
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                @foreach(Session::get("errores_global") as $key => $value)
                <p>EL registro de la fila numero {{++$key}} tiene los siguientes errores</p>
                <ul>
                    @foreach($value as $key2 => $value2)
                    <li>{{$value2}}</li>
                    @endforeach
                </ul>
                @endforeach
            </div>
            </div>
        </div>
    @endif

@if(Session::has("mensaje_success"))
  <div class="col-md-12" id="mensaje-resultado">
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{Session::get("mensaje_success")}}
    </div>
  </div>
@endif

<div class="col-md-6 form-group">
  <label for="inputEmail3" class="col-sm-2 control-label">Cargos:</label>
   <div class="col-sm-10">
    {!! Form::select("cargo_id",$perfil_candidato,null,["class"=>"form-control" ]); !!}
   </div>
</div>

<div class="col-md-6 form-group">
  <label for="inputEmail3" class="col-sm-2 control-label">Palabras Clave:</label><span>(separados por coma (,))</span>
   <div class="col-sm-10">
    {!! Form::text("claves",null,["class"=>"form-control","id"=>"claves","data-role"=>"tagsinput", "style"=>"text-transform: lowercase;"]);!!}
   </div>
</div>

<div class="col-md-6 form-group">
    <label class="col-sm-2 control-label" for="inputEmail3">
       Fecha inicial
    </label>

    <div class="col-sm-10">
     {!! Form::text("fecha_actualizacion_ini",null,["class"=>"form-control","placeholder"=>"Fecha inicial","id"=>"fecha_actualizacion_ini" ]); !!}
      <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_actualizacion_ini",$errors) !!}</p>
    </div>
</div>

<div class="col-md-6 form-group">
    <label class="col-sm-2 control-label" for="inputEmail3">
       Fecha Final
    </label>
    <div class="col-sm-10">
      {!! Form::text("fecha_actualizacion_fin",null,["class"=>"form-control","placeholder"=>"Fecha final","id"=>"fecha_actualizacion_fin" ]); !!}
     <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_actualizacion_fin",$errors) !!}</p>
    </div>
</div>

<div class="clearfix"></div>
{!! Form::submit("Buscar",["class"=>"btn btn-success","id"=>"buscar"]) !!}
<a class="btn btn-danger" href="{{route("admin.lista_carga_otras_fuentes")}}">Limpiar</a>
{!! Form::close() !!}
<br><br><br>
    
{!! Form::model(Request::all(),["method"=>"POST","id"=>"envio_req"]) !!}
<div class="clearfix"></div>

{!! Form::submit("Enviar a requerimiento",["style"=>"position:relative; left:-30px; top:-5px;","class"=>"btn btn-primary","id"=>"enviar_req"]) !!}

    <div class="col-md-6 form-group">
      <label for="inputEmail3" class="col-sm-3 control-label">Requerimiento:</label>
        <div class="col-sm-8">
         {!! Form::select("req_id",$requerimientos,null,["class"=>"form-control chosen1 id_req" ]); !!}
        <p class="text-danger">{!! FuncionesGlobales::getErrorData("req_id",$errors) !!}</p>
        </div>
    </div>
<br>
<div class="clearfix"></div>
 <div id="lista-carga">

 </div>
 {!! Form::close()!!}

 <div class="modal" id="modal_confirme">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header alert-info">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title"><span class="fa fa-check-circle "></span> Confirmación</h4>
        </div>
          {!! Form::open(["route"=>"admin.transferir_dato","id"=>"transferir"]) !!}
           <input type="hidden" name="req_id" id="nuevo_req">

            <div class="modal-body" id="texto">
            </div>

          {!! Form::close() !!}
            <div class="modal-footer">
             <button type="submit" id="cofirm_transfer" form="transferir" class="btn btn-warning" >Transferir</button>
             <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
          </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
<script>

    $("#envio_req").hide();
    $(".chosen1").chosen();

    $(document).on("change","#seleccionar_todos", function () {
       var obj = $(this);
      $("input[name='user_id[]']").prop("checked", obj.prop("checked"));
    });
    
    $("#buscar").on("click", function(e){
        e.preventDefault();
       cargar_tabla();
    });

    $("#envio_req").on("submit", function (e) {
           e.preventDefault();

        $.ajax({
            type: "POST",
            data: $('#envio_req').serialize(),
            url: "{{route('admin.enviar_requerimiento')}}",
          beforeSend: function(){
            $("#modal_confirme #texto").html('');
            $.blockUI({
               message: '<img src="https://ecuadortoday.media/wp-content/uploads/2018/05/1car-loading-2.gif">',
               css: {
                 border: "0",
                 background: "transparent"
                },
                overlayCSS:  {
                   backgroundColor: "#fff",
                   opacity:         0.6,
                   cursor:          "wait"
                }
            });
          },

          error: function(){
            $.unblockUI();
            swal("ERROR!",'A ocurrido un error', "danger");
            //$("#modal_confirme .close").click();
          },
          success: function (response){
            console.log(response);
           if(response.success){
             cargar_tabla();
            $.unblockUI();
            swal("Bien!",'Candidato afiliado al requerimiento', "success");
            //console.log(response);
          }else{
            $.unblockUI();

           var req = $('.id_req').val();
           
//console.log(req);
             //mensaje_success(response.errores[0]);
            $("#nuevo_req").val(req);
            
         $.each(response.errores, function(index, val) {
              /* iterate through array or object */
            $("#modal_confirme #texto").append(val);
         });
            $("#modal_confirme").modal("show");

           $('#cofirm_transfer').prop('disabled','disabled');
           
            if(response.transferir){
             $('#cofirm_transfer').prop('disabled',false);
            }
            //console.log(response.errores[0]);
          }
          return false;
         }
        });

    });


    $("#transferir").on("submit", function (e) {
           e.preventDefault();

        $.ajax({
            type: "POST",
            data: $('#transferir').serialize(),
            url: "{{route('admin.transferir_dato')}}",
          beforeSend: function(){
            $.blockUI({
               message: '<img src="https://ecuadortoday.media/wp-content/uploads/2018/05/1car-loading-2.gif">',
               css: {
                 border: "0",
                 background: "transparent"
                },
                overlayCSS:  {
                   backgroundColor: "#fff",
                   opacity:         0.6,
                   cursor:          "wait"
                }
            });
          },
          error: function(){
            $.unblockUI();
            swal("ERROR!",'A ocurrido un error', "danger");
            $("#modal_confirme .close").click();
          },
          success: function (response){
           if(response.success ==='success'){
            $.unblockUI();
            $("#modal_confirme .close").click();
             cargar_tabla();
            swal("Bien!",'Candidato afiliado al requerimiento', "success");
            //console.log(response);
          }//fin del si
          return false;
         }//fin de success
        });

    });

    function cargar_tabla(){
      $.ajax({
         type: "POST",
         data: $('#form-filtro').serialize(),
         url: "{{route('admin.filtrar_carga_otras_fuentes')}}",
          beforeSend: function(){
           $('#lista-carga').html('<label> Buscando.....</label>');
          },
          success: function (response){
           if(response.success){
           // mensaje_success("Registro eliminado.");
           $("#envio_req").show();
           $('#lista-carga').html(response.view);

          }
           $('.data-table').DataTable({
                    "responsive": true,
                    "paginate": true,
                    "lengthChange": false,
                    "searching": false,
                    "info": true,
                    "language": {
                        "url": '{{ url("js/Spain.json") }}'
                    }
           });
         }
        });
    }

	$("#fecha_actualizacion_fin").datepicker(confDatepicker);
    $("#fecha_actualizacion_ini").datepicker(confDatepicker);

</script>

<style>
.chosen-container-multi .chosen-choices li.search-field input[type="text"]{
  height: 30px !important;
}

</style>

@stop