@extends("admin.layout.master")
@section('contenedor')

@include('admin.layout.includes._section_header_breadcrumb', ['page_header' => "Lista Especial"])
    
<!-- Mostrar los mensaje de error del cargue de la base de datos excel -->
@if(Session::has("errores_global") && count(Session::get("errores_global")) > 0)
    <div class="col-md-12" id="mensaje-resultado">
        <div class="divScroll">
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                @foreach(Session::get("errores_global") as $key => $value)
                    <p>EL registro de la linea número {{++$key}} tiene los siguientes errores</p>
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

<!-- Mostrar el mensaje del total de registro que se cargaron a la base de datos. -->
@if(Session::has("mensaje_success"))
    <div class="col-md-12" id="mensaje-success">
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {!! Session::get("mensaje_success") !!}
        </div>
    </div>
@endif

<div class="col-md-6">
    <div id="accordion">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <a data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="cursor: pointer;">
                    <h3 class="panel-title text-white">
                        Ingreso de forma individual
                    </h3>
                </a>
            </div>
            <div id="collapseOne" class="collapse in" aria-labelledby="headingUno" data-parent="#accordion">
                <div class="panel-body">
                    <div class="form-group">
                        <label for="cedula" class="control-label">Cédula</label>
                        
                        {!! Form::text("cedula",null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","placeholder"=>"Ingrese la cédula", "id" => "cedula", "required" => "required"]); !!}
                    </div>
                    <div class="form-group">
                        <label for="restriccion_id" class="control-label">Restricción</label>
                        
                        {!! Form::select("restriccion_id", $tipos_restricciones, null, ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "restriccion_id", "required" => "required"]); !!}
                    </div>
                    <button class="btn btn-default btn-block | tri-br-2 tri-txt-green tri-bg-white tri-bd-green tri-transition-200 tri-hover-out-green" id="btn_agregar" type="button">Agregar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-md-6">
    <div id="accordion-2">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <a data-toggle="collapse" data-target="#collapseDos" aria-expanded="true" aria-controls="collapseDos" style="cursor: pointer;">
                    <h3 class="panel-title text-white">
                        Ingreso de forma masiva
                    </h3>
                </a>
            </div>
            <div id="collapseDos" class="collapse in" aria-labelledby="headingDos" data-parent="#accordion-2">
                <div class="panel-body">
                    {!! Form::model(null,["method"=>"post","route"=>"admin.agregar_cedula_lista_negra_masivo","files"=>true]) !!}
                        <div class="row">
                            <div class="col-md-12">
                                <p>
                                    <b>Instrucciones:</b><br>
                                    Para la columna Restricción se debe ingresar el número según se indica a continuación
                                    <ul>
                                        @foreach($tipos_restricciones as $id => $restriccion)
                                            @if($id != '')
                                                <li>Ingresar <b>{{ $id }}</b> para el {{ mb_strtolower($restriccion) }}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </p>
                            </div>
                            <div class="col-md-12">
                                <a href="{{asset('plantilla_lista_especial.xlsx')}}" class="btn btn-blue pull-right | tri-px-2 text-white tri-br-2 tri-border--none tri-transition-200 tri-blue" download="PlantillaListaEspecialMasiva.xlsx">Descargar plantilla</a>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="archivo" class="control-label">Archivo</label>
                                    <input type="file" name="archivo" id="archivo" accept=".xlsx, .xls, .csv" required="required" class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300">
                                </div>
                                {!! Form::submit("Cargar archivo",["class"=>"btn btn-default btn-block | tri-br-2 tri-txt-green tri-bg-white tri-bd-green tri-transition-200 tri-hover-out-green"]) !!}
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12">
    <div id="accordion-3">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <a data-toggle="collapse" data-target="#collapseTres" aria-expanded="true" aria-controls="collapseTres" style="cursor: pointer;">
                    <h3 class="panel-title text-white">
                        Documentos agregados a la lista especial
                    </h3>
                </a>
            </div>
            <div id="collapseTres" class="collapse in" aria-labelledby="headingTres" data-parent="#accordion-3">
                <div class="panel-body">
                    <table class="table table-hover table-bordered" id="table_with_users">
                        <thead>
                            <tr>
                                <th>Cédula</th>
                                <th>Restricción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($datos_lista_especial as $dato)
                                <tr>
                                    <td>{{ $dato->cedula }}</td>
                                    <td>{{ $dato->descripcion }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2">No hay datos</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="clearfix"></div>

<script type="text/javascript">
    $(function() {
        $('#table_with_users').DataTable({
            'stateSave': true,
            "lengthChange": false,
            "responsive": true,
            "paginate": true,
            "autoWidth": true,
            "searching": true,
            "order": [[0,"desc"]],
            "lengthMenu": [[10, 25, -1], [10, 25, "All"]],
            "language": {
                "url": '{{ url("js/Spain.json") }}'
            }
        });

        $('#btn_agregar').click(function() {
            if ($('#cedula').smkValidate() && $('#restriccion_id').smkValidate()) {
                let cedula = $('#cedula').val();
                let restriccion_id = $('#restriccion_id').val();
                let men = "Confirma que deseas agregar a la lista especial la cédula " + cedula;

                swal("¿Estas seguro?", men, "warning", {
                    buttons: {
                        cancelar: {text: "Cancelar", className: 'btn btn-default'},
                        agregar: {text: "Confirmar", className:'btn btn-warning'}
                    },
                    closeOnClickOutside: false,
                    closeOnEsc: false,
                    allowOutsideClick: false,
                }).then((value) => {
                    switch (value) {
                        case "agregar":
                            $.ajax({
                                url: "{{ route('admin.agregar_cedula_lista_negra') }}",
                                type: 'POST',
                                data: {
                                    cedula: cedula,
                                    restriccion_id: restriccion_id
                                },
                                beforeSend: function(){
                                    $.smkAlert({
                                        text: 'Guardando la información...',
                                        type: 'info'
                                    })
                                },
                                success: function(response){
                                    $('#cedula').val('');
                                    $('#restriccion_id').val('');
                                    if (response.rs) {
                                        swal("Operación exitosa!", "Se agregó correctamente la cédula " + cedula + " a la lista especial.", "success");
                                    } else {
                                        $.smkAlert({
                                            text: 'Esta cédula ya se encuentra en la lista especial.',
                                            type: 'info'
                                        })
                                    }
                                },
                                error: function(response){
                                    $.smkAlert({
                                        text: 'Ha ocurrido un error, intente nuevamente.',
                                        type: 'danger'
                                    });
                                }
                            });
                        break;
                    }
                });
            }
        });
    })

</script>
@stop