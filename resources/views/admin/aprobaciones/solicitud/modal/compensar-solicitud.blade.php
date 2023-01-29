<div class="modal-header">
    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
        <span aria-hidden="true">
            ×
        </span>
    </button>
    <h4 class="modal-title">
        Valorar solicitud
    </h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <h3>
                <strong>
                    Detalle solicitud
                </strong>
            </h3>
        </div>
        <div class="col-md-6">
            <div class="col-md-6">
                <strong>
                    Código solicitud
                </strong>
            </div>
            <div class="col-md-6">
                {{ $solicitudes->id }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="col-md-6">
                <strong>
                    Sede trabajo
                </strong>
            </div>
            <div class="col-md-6">
                {{ \App\Models\SolicitudSedes::nombreSede($solicitudes->ciudad_id) }}
            </div>
        </div>
        <!-- -->
        <div class="col-md-6">
            <div class="col-md-6">
                <strong>
                    Aréa
                </strong>
            </div>
            <div class="col-md-6">
                {{ \App\Models\SolicitudAreaFuncional::nombreAreaFunciones($solicitudes->area_id) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="col-md-6">
                <strong>
                    Subarea
                </strong>
            </div>
            <div class="col-md-6">
                {{ \App\Models\SolicitudSubArea::nombreSubArea($solicitudes->subarea_id) }}
            </div>
        </div>
        <!-- -->
        <div class="col-md-6">
            <div class="col-md-6">
                <strong>
                    Nombre solicitante
                </strong>
            </div>
            <div class="col-md-6">
                {{ \App\Models\DatosBasicos::nombreUsuario($solicitudes->user_id) }}
            </div>
        </div>
        <!-- -->
        <div class="col-md-6">
            <div class="col-md-6">
                <strong>
                    Cargo solicitado
                </strong>
            </div>
            <div class="col-md-6">
                {{ $solicitudes->cargoGenerico()->descripcion }}
            </div>
        </div>
        <!-- -->
        <div class="col-md-6">
            <div class="col-md-6">
                <strong>
                    Jefe inmediato
                </strong>
            </div>
            <div class="col-md-6">
               @if($solicitudes->jefeInmediato())
                {{ $solicitudes->jefeInmediato()->nombre }}
               @endif
            </div>
        </div>
        @if(isset($solicitudes->centrocosto))
            <div class="col-md-6">
                <div class="col-md-6">
                    <strong>
                        Centro de costo
                    </strong>
                </div>
                <div class="col-md-6">
                    {{ $solicitudes->centrocosto->descripcion }}
                </div>
            </div>
        @endif
         @if(isset($solicitudes->centrobeneficio))
        <div class="col-md-6">
            <div class="col-md-6">
                <strong>
                    Centro beneficio
                </strong>
            </div>
            <div class="col-md-6">
                {{ $solicitudes->centrobeneficio->descripcion }}
            </div>
        </div>
        @endif
        <div class="col-md-6">
            <div class="col-md-6">
                <strong>
                    Email jefe inmediato
                </strong>
            </div>
            <div class="col-md-6">
                {{ $solicitudes->email_jefe_inmediato }}
            </div>
        </div>
        {{--<div class="col-md-6">
            <div class="col-md-6">
                <strong>
                    Clase de riesgo
                </strong>
            </div>
            <div class="col-md-6">
                {{ $solicitudes->riesgo_id }}
            </div>
        </div>--}}
        <!-- -->
        <div class="col-md-6">
            <div class="col-md-6">
                <strong>
                    Tipo contrato
                </strong>
            </div>
            <div class="col-md-6">
                {{ $solicitudes->tipoContrato()->descripcion }}
            </div>
        </div>

        @if(!empty($solicitudes->tiempo_contrato))
         <div class="col-md-6">
            <div class="col-md-6">
                <strong>
                    Tiempo Contrato
                </strong>
            </div>
            <div class="col-md-6">
                {{ $solicitudes->tiempo_contrato }}
            </div>
         </div>
        @endif
        
        <div class="col-md-6">
          <div class="col-md-6">
             <strong>
                   Motivo contrato
                </strong>
            </div>
            <div class="col-md-6">
              @if($solicitudes->motivo_requerimiento_id!=20)
             @if(!empty($solicitudes->motivoRequerimiento()))
               {{$solicitudes->motivoRequerimiento()->descripcion}}
             @endif
              @else
               <strong>{{$solicitudes->motivoRequerimiento()->descripcion}}</strong>:{{$solicitudes->desc_motivo}}
               @endif
                
            </div>
        </div>
        <!-- -->
        <div class="col-md-6">
            <div class="col-md-6">
                <strong>
                    Número vacantes
                </strong>
            </div>
            <div class="col-md-6">
                {{ $solicitudes->numero_vacante }}
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="col-md-6">
                <strong>
                    Documento adjunto
                </strong>
            </div>
            <div class="col-md-6">
                <a href="{{ route('home') }}/documentos_solicitud/{{ $solicitudes->documento }}" target="_black">
                    Ver documentos
                </a>
            </div>
        </div>
        <!-- -->
        <div class="col-md-12">
            <div class="col-md-12">
                <strong>
                  Justificación
                </strong>
            </div>
            <div class="col-md-12">
                {{ $solicitudes->funciones_realizar }}
            </div>
        </div>
        <div class="col-md-12">
            <div class="col-md-12">
                <strong>
                    Observaciones
                </strong>
            </div>
            <div class="col-md-12">
                {{ $solicitudes->observaciones }}
            </div>
        </div>
        
        <div class="col-md-12">
            <div class="col-md-12">
                <strong>
                    Recursos necesarios
                </strong>
            </div>
            <div class="col-md-12">
              @if($solicitudes->recursosNecesarios)

               @foreach($solicitudes->recursosNecesarios as $recurso)
               
                {{$recurso->recurso_necesario}},
                
               @endforeach
              @endif
            </div>
        </div>

        {!!  Form::open(["id"=>"fr_salario"]) !!}
        <div class="col-md-12">
            <div class="form-group has-success">
                <label class="control-label" for="inputSuccess">
                    <i class="fa fa-dollar">
                    </i>
                    Salario
                </label>
                {!! Form::text("salario", $solicitudes->salario,["id"=>"salario", "class"=>"form-control salario"]) !!}
                <span class="help-block">
                    Ingresar el salario para poder liberar
                </span>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-default" data-dismiss="modal" type="button">
        <i class="fa fa-close">
        </i>
        Cerrar
    </button>
    <button class="btn btn-success" id="btn-valorar" type="button">
        <i class="fa fa-check">
        </i>
        Valorar
    </button>
    <button class="btn btn-danger" id="btn-pendiente" type="button">
        <i class="fa fa-calendar">
        </i>
        Pendiente
    </button>
</div>
<div class="compensar" style="display: none;">
    <h1>
        Valorar
    </h1>
    <span>
        Se realizo la valoración de la solicitud.
    </span>
</div>
<script>
    $(document).ready(function(){

        $("#btn-liberado").prop('disabled', true);
        /**
         * Si el salario tiene mas de 0 caracteres lo activa btn-liberado
         **/
        $("#salario").change(function() {
            var salario = $("#salario").val();
            if(salario.length <= 0){
                $("#btn-liberado").prop('disabled', true);
            }else{
                $("#btn-liberado").prop('disabled', false);
            }
        });
    });


    $(function(){
        /**
         * Guardar salario de la solicitud
         **/
        $("#btn-valorar").on("click", function(){
           // var id = ;
           // var salario = $("#salario").val();
            
          {{--@if(route('home') =="http://demo.t3rsc.co")--}}
                     //   console.log(id+'//'+salario);
            $(this).attr('disabled','disabled');

             swal("Seguro de Continuar", "Desea enviar solicitud a valorar?", "info", {
                  buttons: {
                    cancelar: { text: "Cancelar"
                    },
                    agregar: {
                      text: "Agregar"
                    },
                  },
              })
                .then((value) => {
                  switch (value) {
                 
                    case "cancelar":
                      
                      swal("Proceso Cancelado","","warning");
                      
                      $('#btn-valorar').removeAttr('disabled');
                       //CODIGO DE NO AGREGADO O LO QUE QUIERAS HACER
                      break;
                 
                    case "agregar":

                        //console.log(value);
                      //swal("Agreado", "La cantidad era mayor pero fue agregada por su solicitud", "success");
                      var id = {{ $solicitudes->id }};
                      var salario = $("#salario").val();
                        //console.log(id+'//'+salario);
                      $.ajax({
                        url: "{{ route('admin.actualizarSolicitud') }}",
                        type: "POST",
                        data: {id: id, salario : salario},
                        beforeSend: function(){
                            //imagen de carga
                            $.blockUI({ 
                                message: '<img src="http://www.fundacionprotejer.com/wp-content/plugins/filtros/img/loading.gif">', 
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
                        error: function(response){
                           // console.log('error en el reguistro');
                            $('#btn-valorar').removeAttr('disabled');
                        },
                        success: function(response) {
                            $("#modal_gr").modal('toggle');
                            $.blockUI({
                                 message: $('div.compensar'),
                                 fadeIn: 700,
                                 fadeOut: 700,
                                 timeout: 2000,
                                 showOverlay: false,
                                 centerY: false,
                                 css: {
                                     width: '350px',
                                     button: '10px',
                                     left: '',
                                     right: '10px',
                                     border: 'none',
                                     padding: '5px',
                                     backgroundColor: '#000',
                                         '-webkit-border-radius': '10px',
                                         '-moz-border-radius': '10px',
                                     opacity: .6,
                                     color: '#fff'
                                }
                            }); 
                            location.reload();
                        }
                    });
                     // valorar();
                      //AQUI CODIGO DONDE AGREGAS
                      break;
                  }
                });

          {{--  @else --}}
            /* swal({
              title: 'Esta Seguro?',
              text: "Desea Valorar la solicitud?",
              type: 'warning',
              showCancelButton: true,
              cancelButtonText: "No, cancel",
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              closeOnConfirm: false,
              showLoaderOnConfirm: true,
              confirmButtonText: 'Rechazar'
            }).then(function() {*/
                //rechazar();
          {{--   @endif--}}
           // })
        });

        /**
         * Solicitud estado pendiente
         **/
        $("#btn-pendiente").on("click", function(){
            

         {{--  @if(route('home') =="http://demo.t3rsc.co") --}}

            $(this).attr('disabled','disabled');

            swal("Seguro de Continuar", "Desea enviar solicitud a pendiente?", "info", {
                  buttons: {
                    cancelar: { text: "Cancelar"
                    },
                    agregar: {
                      text: "Agregar"
                    },
                  },
              })
                .then((value) => {
                  switch (value) {
                 
                    case "cancelar":
                      
                      swal("Proceso Cancelado","","warning");
                      
                      $('#btn-valorar').removeAttr('disabled');
                       //CODIGO DE NO AGREGADO O LO QUE QUIERAS HACER
                      break;
                 
                    case "agregar":

                        //console.log(value);
                      //swal("Agreado", "La cantidad era mayor pero fue agregada por su solicitud", "success");
                      //var salario = $("#salario").val();
                        //console.log(id+'//'+salario);
             swal("Comentario de aprobación:", {
                content: "input",
             })
            .then((value) => {

              if (value === false) return false;
                if (value === "") {
                   swal("Debe escribir una observacion!");
                  return false;
                }
                
                var id = {{ $solicitudes->id }};

                //$("#observacion_aprobacion").val(value);
                  
                  $.ajax({
                     url: "{{ route('admin.pendienteSolicitud') }}",
                     type: "POST",
                     data: {id: id, observacion: value},
                      beforeSend: function(){
                       //imagen de carga
                        $.blockUI({ 
                            message: '<img src="http://www.fundacionprotejer.com/wp-content/plugins/filtros/img/loading.gif">', 
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
                     error: function(response){

                          $('#btn-pendiente').removeAttr('disabled');
                     },
                     success: function(response) {
                            $.unblockUI();
                            $("#modal_gr").modal('toggle');
                            swal("Pendiente","Fecha asignación pendiente "+response.fecha);
                            setTimeout('document.location.reload()',4000);
                     }
                  });
              });
                    
                     // valorar();
                      //AQUI CODIGO DONDE AGREGAS
                      break;
                  }
                });


{{--    @else --}}
          
          /* swal({
              title: 'Esta Seguro?',
              text: "Desea cambiar a Pendiente?",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              cancelButtonText: "No, cancel",
              closeOnConfirm: false,
              showLoaderOnConfirm: true,
              confirmButtonText: 'Rechazar'
            }).then(function() { */

               // rechazar();
            //})
           {{--@endif --}}
        });
        
    });
</script>