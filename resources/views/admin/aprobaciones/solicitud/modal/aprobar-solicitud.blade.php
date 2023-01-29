<div class="modal-header">
    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
        <span aria-hidden="true">
            ×
        </span>
    </button>
    <h4 class="modal-title">
        Aprobar solicitud
    </h4>
</div>
<div class="modal-body">
    {!! Form::model($solicitud, ["class"=>"form-horizontal", "id"=>"fr_nuevaSolicitud"]) !!}
    <div class="row">
        <div class="col-md-6 form-group">
            <label class="col-sm-12 pull-left" for="inputEmail3">
                Sede trabajo
            </label>
            <div class="col-sm-12">
                {!! Form::select("ciudad_id",$sede,null,["required","class"=>"form-control","id"=>"ciudad_id"]) !!}
            </div>
        </div>
        <div class="col-md-6 form-group">
            <label class="col-sm-12 pull-left" for="inputEmail3">
                Area trabajo
            </label>
            <div class="col-sm-12">
                {!! Form::select("area_id", $areaFunciones, null,["class"=>"form-control","id"=>"area_id"]) !!}
            </div>
        </div>
        <div class="col-md-6 form-group">
            <label class="col-sm-12 pull-left" for="inputEmail3">
                Subarea
            </label>
            <div class="col-sm-12">
                {!! Form::select("subarea_id", $subArea, null, ["class"=>"form-control","id"=>"subarea_id"]); !!}
            </div>
        </div>
        <div class="col-md-6 form-group">
            <label class="col-sm-12" for="inputEmail3">
                Nombre solicitante
            </label>
            <div class="col-sm-12">
                {!! Form::text("solicitado_por", \App\Models\DatosBasicos::nombreUsuario($solicitud->user_id), ["class"=>"form-control","id"=>"solicitado_por"]); !!}
            </div>
        </div>

        <div class="col-md-6 form-group">
            <label class="col-sm-12" for="inputEmail3">
                Cargar archivo
            </label>
            <div class="col-sm-12">
                <a href="{{ route('home') }}/documentos_solicitud/{{ $solicitud->documento }}" target="_black">
                    Ver documentos
                </a>
            </div>
        </div>
        <div class="col-md-6 form-group">
            <label class="col-sm-12" for="inputEmail3">
                Cargo solicitado
            </label>
            <div class="col-sm-12">
                {!! Form::select("cargo_especifico_id",$cargos_especificos,$solicitud->cargo_especifico_id,["class"=>"form-control","id"=>"cargo_especifico_id"]); !!}
            </div>
        </div>
        {{--}}
        @if(isset($solicitud->centrocosto))
             <div class="col-md-6 form-group">
                <label class="col-sm-12" for="inputEmail3">
                    centro costo
                </label>
                <div class="col-sm-12">
                    {!! Form::select("centro_costo_id",$centro_costo,$solicitud->centro_costo_id,["class"=>"form-control","id"=>"centro_costo"]); !!}
                </div>
            </div>
        @endif
        --}}
        {{--
         @if(isset($solicitud->centrobeneficio))
             <div class="col-md-6 form-group">
                <label class="col-sm-12" for="inputEmail3">
                    Centro beneficio
                </label>
                <div class="col-sm-12">
                    {!! Form::select("centro_beneficio_id",$centro_beneficio,$solicitud->centro_beneficio_id,["class"=>"form-control","id"=>"centro_beneficio"]); !!}
                </div>
            </div>
        @endif
        --}}
        <div class="col-md-6 form-group">
            <label class="col-sm-12" for="inputEmail3">
                Jefe inmediato
            </label>
            <div class="col-sm-12">
                {!! Form::select("jefe_inmediato",$jefes_inmediatos,$solicitud->jefe_inmediato,["class"=>"form-control","id"=>"jefe_inmediato"]); !!}
            </div>
        </div>
        <div class="col-md-6 form-group">
            <label class="col-sm-12" for="inputEmail3">
                Email jefe inmediato
            </label>
            <div class="col-sm-12">
                {!! Form::text("email_jefe_inmediato",null,["class"=>"form-control","id"=>"email_jefe_inmediato"]); !!}
            </div>
        </div>

        {{--<div class="col-md-6 form-group">
            <label class="col-sm-12" for="inputEmail3">
                Jornada Laboral
            </label>
            <div class="col-sm-12">
                {!! Form::select("jornada_laboral_id",$tipo_jornada,null,["class"=>"form-control","id"=>"jornada_laboral_id"]); !!}
            </div>
        </div>--}}
        <div class="col-md-6 form-group">
            <label class="col-sm-12" for="inputEmail3">
                Tipo Contrato
            </label>
            <div class="col-sm-12">
                {!! Form::select("tipo_contrato_id",$tipo_contrato,$solicitud->tipo_contrato_id,["class"=>"form-control","id"=>"tipo_contrato_id"]); !!}
            </div>
        </div>
        <div class="col-md-6 form-group">
            <label class="col-sm-12" for="inputEmail3">
                Tiempo Contrato
            </label>
            <div class="col-sm-12">
                {!! Form::text("tiempo_contrato",$solicitud->tiempo_contrato,["class"=>"form-control","id"=>"tiempo_contrato"]); !!}
            </div>
        </div>
        <div class="col-md-6 form-group">
            <label class="col-sm-12" for="inputEmail3">
                Motivo contrato
            </label>
            <div class="col-sm-12">
                {!! Form::select("motivo_requerimiento_id",$motivo,$solicitud->motivo_requerimiento_id,["class"=>"form-control","id"=>"motivo_contrato"]); !!}
            </div>
        </div>
        <div class="col-md-6 form-group">
            <label class="col-sm-12" for="inputEmail3">
                Número Vacantes
            </label>
            <div class="col-sm-12">
                {!! Form::text("numero_vacante", $solicitud->numero_vacante,["class"=>"form-control","id"=>"numero_vacante"]); !!}
            </div>
        </div>
        <!-- Estudios -->

        <!-- Funciones -->
        <div class="col-md-12 col-sm-12 form-group">
            <label class="col-sm-12" for="inputEmail3">
                Justificación
            </label>
            <div class="col-sm-12">
              {!! Form::textarea("funciones_realizar",null,["class"=>"form-control","id"=>"funciones_realizar","rows"=>"3"]); !!}
            </div>
        </div>
        <div class="col-md-12 col-sm-12 form-group">
            <label class="col-sm-12" for="inputEmail3">
                Observaciones
            </label>
            <div class="col-sm-12">
              {!! Form::textarea("observaciones",null,["class"=>"form-control","id"=>"observaciones","rows"=>"3"]); !!}
            </div>
        </div>

       <div class="col-md-12 col-sm-12 form-group">
        
        <label class="col-sm-12" for="inputEmail3">
            Recursos necesarios
        </label>
        
        <?php $modelo = App\Models\SolicitudRecursos::where('recurso_necesario','Computador de mesa')->where('id_solicitud',$solicitud->id)->first(); ?>

            <div class="col-md-3 form-check form-check-inline">
              <input class="form-check-input" name="recurso[]" id="check_1" type="checkbox" value="Computador de mesa" @if(!empty($modelo)) checked="" @endif>
              <label class="form-check-label" for="check_1">Computador de mesa</label>
            </div>

         <?php $modelo = App\Models\SolicitudRecursos::where('recurso_necesario','Computador portatil')->where('id_solicitud',$solicitud->id)->first(); ?>

            <div class="col-md-3 form-check form-check-inline">
              <input class="form-check-input" name="recurso[]" id="check_2" type="checkbox" value="Computador portátil" @if(!empty($modelo)) checked="" @endif >
              <label class="form-check-label" for="check_2">Computador portátil</label>
            </div>

         <?php $modelo = App\Models\SolicitudRecursos::where('recurso_necesario','Celular')->where('id_solicitud',$solicitud->id)->first(); ?>

            <div class="col-md-3 form-check form-check-inline">
              <input class="form-check-input" name="recurso[]" id="check_3" type="checkbox" value="Celular" @if(!empty($modelo)) checked="" @endif >
              <label class="form-check-label" for="check_3">Celular</label>
            </div>

         <?php $modelo = App\Models\SolicitudRecursos::where('recurso_necesario','Licencia SAP')->where('id_solicitud',$solicitud->id)->first(); ?>
         
            <div class="col-md-3 form-check form-check-inline">
              <input class="form-check-input" name="recurso[]" id="check_4" type="checkbox" value="Licencia SAP" @if(!empty($modelo)) checked="" @endif>
              <label class="form-check-label" for="check_4">Licencia SAP</label>
            </div>

         <?php $modelo = App\Models\SolicitudRecursos::where('recurso_necesario','Modem')->where('id_solicitud',$solicitud->id)->first(); ?>

            <div class="col-md-3 form-check form-check-inline">
              <input class="form-check-input" name="recurso[]" id="check_5" type="checkbox" value="Modem" @if(!empty($modelo)) checked="" @endif >
              <label class="form-check-label" for="check_5">Modem</label>
            </div>
            
         <?php $modelo = App\Models\SolicitudRecursos::where('recurso_necesario','Puesto de trabajo')->where('id_solicitud',$solicitud->id)->first(); ?>

            <div class="col-md-3 form-check form-check-inline">
              <input class="form-check-input" name="recurso[]" id="check_6" type="checkbox" value="Puesto de Trabajo" @if(!empty($modelo)) checked="" @endif >
              <label class="form-check-label" for="check_6">Puesto de trabajo</label>
            </div>
            
            <div class="col-md-3 form-check form-check-inline">
              <input class="form-check-input" id="otro" id="otro" type="checkbox" value="otro">
              <label class="form-check-label" for="otro"> Otro</label>
            </div>

        </div>
        
        @if(!empty($vector))
         <div class="col-md-6 form-group">
          <div class="col-sm-12">
            <input class="form-control" name="recurso[]" id="" type="text" placeholder="Otro Recurso" value="{{$vector}}">
          </div>
         </div>
        @endif

         <div class="col-md-6 form-group">
          <div class="col-sm-12">
            <input class="form-control hidden" name="recurso[]" id="NuevoRecurso" type="text" placeholder="Otro Recurso" value="">
          </div>
         </div>


        {!! Form::hidden("observacion_aprobacion",null,["class"=>"form-control","id"=>"observacion_aprobacion"]) !!}
        {!! Form::hidden("id",$solicitud->id) !!}
        <div class="col-md-12 col-sm-12 form-group">
            <h3>Salario valorado por <strong> $ {{$solicitud->salario }} </strong> </h3>
            <table class="col-md-12 table table-hover table-responsive">
                <thead>
                    <th>Usuario</th>
                    <th>Acción</th>
                    <th>Fecha</th>
                    <th>Observación</th>
                </thead>
                <tbody>
                    @foreach($trazabilidad as $item)
                    <tr>
                    <td>{{ \App\Models\DatosBasicos::nombreUsuario($item->user_id) }}</td>
                    <td>{{ $item->accion }}</td>
                    <td>{{ $item->updated_at }}</td>
                    <th>{{ $item->observacion }}</th>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    {{-- @endif--}}
        {!! Form::close() !!}
    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-default" data-dismiss="modal" type="button">
        <i class="fa fa-close">
        </i>
        Cerrar
    </button>
    @if ($solicitud->estado != 8)
        <button class="btn btn-success" id="btn-aprobar" type="button">
            <i class="fa fa-check">
            </i>
            Aprobar
        </button>
    @endif
    @if ($solicitud->estado == 7 || $solicitud->estado == 8)
        <button class="btn btn-success" id="btn-liberar" type="button">
        <i class="fa fa-check">
        </i>
        <i class="fa fa-check">
        </i>
        Liberar
    </button>
    @endif
    <button class="btn btn-danger" id="btn-rechazar" type="button">
        <i class="fa fa-times">
        </i>
        Rechazar
    </button>
</div>
<script>

    $(document).ready(function($) {
        $("#jefe_inmediato").change(function(){
            var valor = $(this).val();
            $.ajax({
                url: "{{ route('admin.selectEmailJefe') }}",
                type: 'POST',
                data: {id: valor},
                success: function(response){
                   
                    $("#email_jefe_inmediato").val(response.email);
                    
                }
            });
        });
        /**
         * Autocompleta ciudad
         **/
        $('#sitio_trabajo_autocomplete').autocomplete({
            serviceUrl: '{{ route("autocomplete_cuidades") }}',
            autoSelectFirst: true,
            onSelect: function (suggestion) {
                console.log(suggestion);
                $("#pais_id").val(suggestion.cod_pais);
                $("#departamento_id").val(suggestion.cod_departamento);
                $("#ciudad_id").val(suggestion.cod_ciudad);
            }
        });
    });

    $(function(){
        /**
         * Guardar salario de la solicitud
         **/
        $("#btn-aprobar").on("click", function(){
            $("#modal_gr").modal('toggle');

             swal("Seguro de Continuar", "Desea Aprobar solicitud ?", "info", {
                  buttons: {
                    cancelar: { text: "Cancelar"
                    },
                    agregar: {
                      text: "Agregar"
                    },
                  },
              }).then((value) => {
                  switch (value) {
                 
                    case "cancelar":
                      
                      swal("Proceso Cancelado","","warning");
                      $("#modal_gr").modal('toggle');
                      
                      //$('#btn-aprobar').removeAttr('disabled');
                       //CODIGO DE NO AGREGADO O LO QUE QUIERAS HACER
                      break;
                 
                    case "agregar":

                        aprobar();
                     // valorar();
                      //AQUI CODIGO DONDE AGREGAS
                      break;
                  }
                });
        });

        /**
         * Rechazar
         **/
         $("#btn-rechazar").on("click", function(){
            $("#modal_gr").modal('toggle');

           swal("Seguro de Continuar", "Desea Rechazar solicitud ?", "info", {
                  buttons: {
                    cancelar: { text: "Cancelar"
                    },
                    agregar: {
                      text: "Agregar"
                    },
                  },
              }).then((value) => {
                  switch (value) {
                 
                    case "cancelar":
                      
                      swal("Proceso Cancelado","","warning");
                      $("#modal_gr").modal('toggle');
                      
                      //$('#btn-rechazar').removeAttr('disabled');
                       //CODIGO DE NO AGREGADO O LO QUE QUIERAS HACER
                      break;
                 
                    case "agregar":

                      //  aprobar();
                      rechazar();
                     // valorar();
                      //AQUI CODIGO DONDE AGREGAS
                      break;
                  }
                });
         });

        function rechazar(){
            swal("Comentario de rechazo:", {
                content: "input",
            })
            .then((value) => {
                //por si esta vacio
                 if (value === false) return false;
                 if (value === "") {
                    swal("Debe escribir un motivo de rechazo!");
                    return false;
                 }

                $("#observacion_aprobacion").val(value);

                $.ajax({
                    url: "{{ route('admin.rechazarSolicitud') }}",
                    type: "POST",
                    data: $("#fr_nuevaSolicitud").serialize(),
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
                    success: function(response) {
                        $("#modal_gr").modal('toggle');
                        $.unblockUI();
                        if(response.success == true){
                            swal("Bien!",response.mensaje, "success");
                            setTimeout('document.location.reload()',6000);
                        }
                        if(response.success == false){
                            swal("Error!",response.mensaje, "danger");
                            setTimeout('document.location.reload()',6000);
                        }
                    }
                });
            });

        }

        function aprobar(){
          
          swal("Comentario de aprobación:", {
                content: "input",
           })
            .then((value) => {

              if (value === false) return false;
                if (value === "") {
                   swal("Debe escribir una observacion de aprobacion!");
                  return false;
                }

                $("#observacion_aprobacion").val(value);
                $.ajax({
                    url: "{{ route('admin.aprobarSolicitud') }}",
                    type: "POST",
                    data: $("#fr_nuevaSolicitud").serialize(),
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
                    success: function(response) {
                        $("#modal_gr").modal('toggle');
                        $.unblockUI();
                        if(response.success == true){
                            swal("Bien!",response.mensaje, "success");
                            setTimeout('document.location.reload()',6000);
                        }
                        if(response.success == false){
                            swal("Error!",response.mensaje, "danger");
                            setTimeout('document.location.reload()',6000);
                        }
                    }
                });
            });

        }

        /**
         * Traer resto del formulario que ta en la vista admin.aprobaciones.solicitud.modal.ajax-solicitud-nueva
         **/
         $('#cargo_especifico_id').on("change", function (e) {
            var id = $(this).val();
            $.ajax({
                url: "{{ route('admin.solicitudAjaxSolicitud') }}",
                type: 'POST',
                data: {cargo_especifico_id: id}
            })
            .done(function (response) {
                $('.here-put-fields-from-ajax').html(response);
            });
        });

         /**
         * Guardar salario de la solicitud
         **/
        $("#btn-liberar").on("click", function(){
            $("#modal_gr").modal('toggle');

           swal("Seguro de Continuar", "Desea Libarar la solicitud ?", "info", {
                  buttons: {
                    cancelar: { text: "Cancelar"
                    },
                    agregar: {
                      text: "Agregar"
                    },
                  },
              }).then((value) => {
                  switch (value) {
                 
                    case "cancelar":
                      $("#modal_gr").modal('toggle');
                      swal("Proceso Cancelado","Solicitud a salvo!!","warning");
                      
                      //$('#btn-aprobar').removeAttr('disabled');
                       //CODIGO DE NO AGREGADO O LO QUE QUIERAS HACER
                      break;
                 
                    case "agregar":

                        liberar();
                        //aprobar();
                     // valorar();
                      //AQUI CODIGO DONDE AGREGAS
                      break;
                  }
                });
            
        });



        function liberar(){
          
           swal("Comentario de liberación:", {
                content: "input",
            })
            .then((value) => {
                $("#observacion_aprobacion").val(value);
                $.ajax({
                    url: "{{ route('admin.liberarSolicitud') }}",
                    type: "POST",
                    data: $("#fr_nuevaSolicitud").serialize(),
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
                    success: function(response) {
                        $("#modal_gr").modal('toggle');
                        $.unblockUI();
                        if(response.success == true){
                            swal("Bien!",response.mensaje, "success");
                            setTimeout('document.location.reload()',6000);
                        }
                        if(response.success == false){
                            swal("Error!",response.mensaje, "warning");
                            setTimeout('document.location.reload()',6000);
                        }
                    }
                });
            });

        }

    });
</script>
