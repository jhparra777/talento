@extends("admin.layout.master")
@section("contenedor")
    <div class="col-right-item-container">
      <div class="container-fluid">
        <div id="container_documentos">
         {!! Form::open(["class"=>"form-horizontal form-datos-basicos", "role"=>"form","files"=>true,"id"=>"fr_documento"]) !!}
         {!! Form::hidden("user_id",$usuario->user_id) !!}
         {!! Form::hidden("numero_id",$usuario->numero_id) !!}
                    
                    <div class="row">
                        <h3 class="header-section-form">Documentos <span class='text-danger sm-text'> Campos con asterisco(*) son obligatorios</span></h3>
                        
                        <div class="col-md-12">
                            <p class="text-primary set-general-font-bold">
                                En este módulo tu podrás cargar el soporte de todos los documentos que acreditan cada uno de tus estudios, documento de identidad, experiencias laborales, etc. Esta etapa es opcional, pero en caso de que seas llamado a un proceso, estos documentos agilizaran tu proceso de selección y contratación.
                                </br>
                                Para incluir otro documento; llene los campos y haga clic en el botón &quot;Guardar&quot;.
                                </br>
                                <span class='text-danger'>* El sistema solo soporta imágenes y formato PDF</span>
                                </br>
                                El sistema soporta imágenes o preferiblemente en PDF; recuerda tener en cuenta los siguientes tips de ayuda en el cargue de tus documentos.
                            </p>
                    
                            <p class="direction-botones-left">
                                <a href="#grilla-datos" class="btn btn-defecto btn-peq"><i class="fa fa-file-text"></i>&nbsp;Mis Documentos</a>
                            </p>
                        </div>

                        <div class="col-sm-6 col-lg-12">
                         <div class="form-group">
                          <label for="tipo_documento" class="col-md-4 control-label">Tipo Documento:<span class='text-danger sm-text-label'>*</span></label>
                                
                            <div class="col-md-6">
                             {!! Form::select("tipo_documento_id",$tipoDocumento,null,["class"=>"form-control","id"=>"tipo_documento"]) !!}
                            </div>
                         </div>
                        </div>

                        <div class="col-sm-6 col-lg-12">
                            <div class="form-group">
                                <label for="archivo_documento" class="col-md-4 control-label">Archivo Documento (jpg,png,pdf):<span class='text-danger sm-text-label'>*</span> </label>
                                
                                <div class="col-md-6">
                                    {!! Form::file("archivo_documento[]",["class"=>"form-control","placeholder"=>"Archivo Documento","accept"=>".jpg,.jpeg,.png,.pdf","multiple"=>"true"]) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-12">
                            <div class="form-group">
                                <label for="descripcion_documentos" class="col-md-4 control-label">Descripción:<span class='text-danger sm-text-label'>*</span> </label>
                                
                                <div class="col-md-6">
                                    {!! Form::text("descripcion_archivo",null,["class"=>"form-control","placeholder"=>"Descripción Documento","id"=>"descripcion_documento"]) !!}
                                </div>
                            </div>
                        </div>
                
                        <div class="col-sm-6 col-lg-12">
                            <div class="form-group">
                                <label for="fecha_vencimiento" class="col-md-4 control-label">Fecha Vencimiento:<span class='text-danger sm-text-label'></span> </label>
                                
                                <div class="col-md-6">
                                    {!! Form::text("fecha_vencimiento",null,["class"=>"form-control","id"=>"fecha_vencimiento","placeholder"=>"Fecha Vencimiento"]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 separador"></div>

                    <p class="direction-botones-center set-margin-top">
                        <button class="btn btn-primario btn-gra" type="button" id="guardar_documento"><i class="fa fa-floppy-o"></i>&nbsp;Guardar</button>
                    </p>
                {!! Form::close() !!}
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    {!! Form::open(["id"=>"grilla-datos"]) !!}
                        <p class="direction-botones-left">
                            <button type="button" class="btn btn-primario btn-peq" id="editar_documento"><i class="fa fa-pen"></i>&nbsp;Editar</button>
                            <button type="button" class="btn btn-defecto btn-peq" id="ver_documento" ><i class="fa fa-eye"></i>&nbsp;Ver Documento</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <button type="button" class="btn btn-danger-t3 btn-peq" id="eliminar_documento"><i class="fa fa-trash"></i>&nbsp;Eliminar</button>
                        </p>

                        <div class="grid-container table-responsive">
                            <table class="table table-striped" id="tbl_documentos">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Documento</th>
                                        <th>Descripción</th>
                                        <th>Fecha Creación</th>
                                        <th>Fecha Vencimiento</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($documentos->count() == 0)
                                        @if(route("home")!="http://colpatria.t3rsc.co" && route("home")!="https://colpatria.t3rsc.co")
                                            <tr id="no_registros">
                                                <td colspan="5">No hay registros</td>
                                            </tr>
                                        @endif
                                    @endif

                                    @foreach($documentos as $documento)
                                        <tr id="tr_{{$documento->id}}">
                                            <td scope="row"><input type="radio" value="{{$documento->id}}" name="id" /></td>
                                            <td>{{$documento->tipo_doc}}</td>
                                            <td>{{$documento->descripcion_archivo}}</td>
                                            <td>{{$documento->created_at}}</td>
                                            <td>{{$documento->fecha_vencimiento}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <div class="container">
            <h3>Documentos Grupo Familiar</h3>
            <div id="container_documentos_familiares">
                        {!! Form::open(["class"=>"form-horizontal form-datos-basicos", "role"=>"form","files"=>true,"id"=>"fr_documento_familiar"]) !!}
                    
                    <div class="row">
                        <div class="col-sm-6 col-lg-12">
                         <div class="form-group">
                          <label for="tipo_documento" class="col-md-4 control-label">Tipo Documento:<span class='text-danger sm-text-label'>*</span></label>
                                
                            <div class="col-md-6">
                             {!! Form::select("tipo_documento_id",$tipoDocumentoFamiliar,null,["class"=>"form-control","id"=>"tipo_documento"]) !!}
                            </div>
                         </div>
                        </div>

                        <div class="col-sm-6 col-lg-12">
                         <div class="form-group">
                          <label for="tipo_documento" class="col-md-4 control-label">Familiar:<span class='text-danger sm-text-label'>*</span></label>
                                
                            <div class="col-md-6">
                                <select name="grupo_familiar_id" id="grupo_familiar_id" class="form-control">
                                    <option value="">Seleccionar</option>
                                    @foreach($gruposFamiliares as $familiar)
                                    <option value="{{ $familiar->id }}">{{ $familiar->parentesco }} - {{ $familiar->nombres }} {{ $familiar->primer_apellido }} {{ $familiar->segundo_apellido }}</option>
                                    @endforeach
                                </select>
                            </div>
                         </div>
                        </div>

                        <div class="col-sm-6 col-lg-12">
                            <div class="form-group">
                                <label for="documento" class="col-md-4 control-label">Archivo Documento (jpg,png,pdf):<span class='text-danger sm-text-label'>*</span> </label>
                                
                                <div class="col-md-6">
                                    {!! Form::file("documento",["class"=>"form-control","placeholder"=>"Archivo Documento","accept"=>".jpg,.jpeg,.png,.pdf"]) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-12">
                            <div class="form-group">
                                <label for="descripcion_documentos" class="col-md-4 control-label">Descripción:<span class='text-danger sm-text-label'>*</span> </label>
                                
                                <div class="col-md-6">
                                    {!! Form::text("descripcion",null,["class"=>"form-control","placeholder"=>"Descripción Documento","id"=>"descripcion"]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 separador"></div>

                    <p class="direction-botones-center set-margin-top">
                        <button class="btn btn-primario btn-gra" type="button" id="guardar_documento_familiar"><i class="fa fa-floppy-o"></i>&nbsp;Guardar</button>
                    </p>
                {!! Form::close() !!}
            </div>
                <div class="row">
                    <div class="col-12">
                        <table class="table table-striped custab">
                            <thead>
                                <tr>
                                    <th><strong>Tipo Documento</strong></th>
                                    <th><strong>Descripción</strong></th>
                                    <th><strong>Parentesco</strong></th>
                                    <!--<th><strong>Documento</strong></th>-->
                                    <th><strong>Fecha Cargado</strong></th>
                                    <th class="text-center"><strong>Acción</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($documentosFamiliares as $doc_familiar)
                                <tr id="{{$doc_familiar->id}}">
                                    <td>{{$doc_familiar->tipo_documento}}</td>
                                    <td>{{ $doc_familiar->descripcion }}</td>
                                    <td>{{$doc_familiar->parentesco}}</td>
                                    <td>{{$doc_familiar->created_at}}</td>
                                    <td class="text-center">
                                        <a class='btn btn-info btn-sm ver_documento_familiar' href="#"><span class="glyphicon glyphicon-eye-open"></span></a>
                                        <a href="#" class="btn btn-danger btn-sm eliminar_documento_familiar" type="button"><span class="glyphicon glyphicon-remove"></span></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        @if(route("home")=="http://colpatria.t3rsc.co" || route("home")=="https://colpatria.t3rsc.co")
            <div class="container">
                <h3>Hojas de Vida</h3>
                <div class="row col-md-6">
                    <table class="table table-striped custab">
                        <thead>
                            <tr>
                                <th><strong>#</strong></th>
                                <th><strong>Archivo HV</strong></th>
                                <th><strong>Fecha Cargado</strong></th>
                                <th class="text-center"><strong>Acción</strong></th>
                            </tr>
                        </thead>
                        @foreach($archivos as $documento)
                            <tr id="tr_{{$documento->id}}">
                                <td><div class="col-md-1">{{$documento->id}}</div></td>
                                <td><div class="col-md-4">{{ $documento->archivo }}</div></td>
                                <td>{{ $documento->created_at }}</td>
                                <td class="text-center">
                                    <a class='btn btn-info btn-xs ver_hv' id="{{ $documento->id }}" href="#"><span class="glyphicon glyphicon-edit"></span> ver</a>
                                    <a href="#" class="btn btn-danger btn-xs eliminar_hv" id="{{ $documento->id }}" type="button"><span class="glyphicon glyphicon-remove"></span> eliminar</a>
                                </td>
                            </tr>
                        @endforeach 
                    </table>
                </div>
            </div>
        @endif
    </div>

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

        $(document).on("click", "input[name=id]", function () {
            $("#tbl_documentos tbody tr").removeClass("oferta_aplicada");

            if ($(this).prop("checked")) {
                $(this).parents("tr").addClass("oferta_aplicada");
            }
        });

        $("#fecha_vencimiento").datepicker(confDatepicker);

        $("#guardar_documento_familiar").on("click", function () {
            var formData = new FormData(document.getElementById("fr_documento_familiar"));
            
            $.ajax({
                type: "POST",
                data: formData,
                url: "{{ route('guardar_documento_familiar') }}",
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                  console.log(response)
                    if (response.success) {
                      mensaje_success(response.mensaje);
                      location.reload();
                    }else{
                        mensaje_danger(response.mensaje);
                      
                    }
                },
                errors: function(error) {
                  console.log(error)
                }
            });
        });

        $(document).on("click", "#guardar_documento", function () {
            $(this).prop("disabled", true);
            var formData = new FormData(document.getElementById("fr_documento"));

            $.ajax({
                type: "POST",
                data: formData,
                url: "{{ route('guardar_documento_candidato')}}",
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                }
                }).done(function (response, data) {
                    

                    if (response.success) {
                        $("#container_documentos").html(response.view);
                        var documentos = response.documentos;
                        $("#no_registros").remove();

                        for (var i = 0; i < documentos.length; i++) {
                            var tr = $("<tr id='tr_" + documentos[i].id + "' ></tr>");
                            tr.append($("<td></td>").append($("<input />", {type: "radio", name: "id", value: documentos[i].id})));
                            tr.append($("<td></td>", {text: documentos[i].tipo_doc}));
                            tr.append($("<td></td>", {text: documentos[i].descripcion_archivo}));
                            tr.append($("<td></td>", {text: documentos[i].created_at}));
                            tr.append($("<td></td>", {text: documentos[i].fecha_vencimiento}));
                            $("#tbl_documentos tbody").append(tr);
                        }
                        if (response.success) {
                            mensaje_success(response.mensaje_success);
                        } else {
                            mensaje_danger(response.mensaje_success);
                        }
                        $(document).scrollTop(0);
                        setTimeout(() => {
                            location.reload();
                        }, 1500)
                    }

                    else {
                        mensaje_danger("Tipo de documento no soportado");

                        $(document).scrollTop(0);
                    }
                });
            });

        //Eliminar archiv HV
        $(".eliminar_documento_familiar").on("click", function (e) {
            e.preventDefault();

            var row = $(this).parents('td').parents('tr');
            var id = row.attr("id");

            if (confirm("Desea eliminar este documento?")) {
                $.ajax({
                    type: "POST",
                    data: {id: id},
                    url: "{{ route('eliminar_documento_familiar') }}",
                    success: function (response) {
                      if(response.success)
                      {
                        mensaje_success("Documento eliminado correctamente.");
                        row.remove();

                      }else{
                          mensaje_danger("problemas al eliminar el documento.");
                      }
                    }
                });
            }
        });

        //Ver archivo HV
        $(".ver_documento_familiar").on("click", function (e) {
            e.preventDefault();

            let row = $(this).parents('td').parents('tr');
            let id = row.attr("id");

            if (id) {
                $.ajax({
                    type: "POST",
                    data: {id: id},
                    url: "{{ route('ver_documento_familiar') }}",
                    success: function (response) {
                        var campos = response.documento;
                        window.open("{{ url('documentos_grupo_familiar/') }}/" + campos.nombre);
                    }
                });
            }
        });

        $("#editar_documento").on("click", function () {
            $("#eliminar_documento").prop("disabled", true);
            if(seleccionarLista("id")) {
                $.ajax({
                    type: "POST",
                    data: $("#grilla-datos").serialize(),
                    url: "{{ route('editar_documento_candidato') }}",
                    success: function (response) {
                        $("#container_documentos").html(response.view);
                    }
                });
            }else{
                mensaje_danger("No se puedo editar, favor intentar nuevamente.");
            }
        });
        
        $(document).on("click", "#actualizar_documento", function () {
            $("#eliminar_documento").prop("disabled", false);
            var formData = new FormData(document.getElementById("fr_documento"));

            $.ajax({
                type: "POST",
                data: formData,
                url: "{{ route('actualizar_documento')}}",
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                 
                 $("#container_documentos").html(response.view);
                    
                    if (response.success) {
                        var campos = response.documento;
                        var tr = $("#tr_" + campos.id + " td");
                        tr.eq(0).html($("<input />", {type: "radio", name: "id", value: campos.id}));
                        tr.eq(1).html(campos.tipo_doc);
                        tr.eq(2).html(campos.descripcion_archivo);
                        tr.eq(3).html(campos.created_at);
                        tr.eq(4).html(campos.fecha_vencimiento);
                        mensaje_success(response.mensaje_success);
                        $(document).scrollTop(0);
                    }

                    if (response.success == false) {
                        mensaje_success(response.mensaje_success);
                    }
                }
            });
        });

        $(document).on("click", "#cancelar_documento", function () {
            $("#eliminar_documento").prop("disabled", false);
            $.ajax({
                type: "POST",
                data: $("#grilla-datos").serialize(),
                url: "{{ route('cancelar_documento') }}",
                success: function (response) {
                    $("#container_documentos").html(response.view);
                }
            });
        });

        $("#eliminar_documento").on("click", function () {
            if (seleccionarLista("id") && confirm("Desea eliminar este registro?")) {
                $.ajax({
                    type: "POST",
                    data: $("#grilla-datos").serialize(),
                    url: "{{ route('eliminar_documento') }}",
                    success: function (response) {
                        $("#tr_" + response.id).remove();
                        alert("Se ha eliminado el registro.");
                    }
                });
            }
        });

        $("#ver_documento").on("click", function () {
            if (seleccionarLista("id")) {

                let datos = $("#grilla-datos").serializeArray();
                console.log(datos)
                if ( datos.find(dato => dato.name == "grupo_familiar_id") ) {
                    console.log("si entro")
                }

                //return false;
                $.ajax({
                    type: "POST",
                    data: $("#grilla-datos").serialize(),
                    url: "{{ route('ver_file_documento') }}",
                    success: function (response) {
                        var campos = response.documento;
                        window.open("{{ url('recursos_documentos/') }}/" + campos.nombre_archivo);
                    }
                });
            }
        });

        $(document).on("change","#tipo_documento",function(){
            $("#descripcion_documento").val($("#tipo_documento").find("option:selected").text())
        });
    });
</script>
@stop