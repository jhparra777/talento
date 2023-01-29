@extends("admin.layout.master")
@section("contenedor")
{{-- Header --}}
    @include('admin.layout.includes._section_header_breadcrumb', ['page_header' => "Lista de cargos específicos"])
<div class="row">
    @if(Session::has("mensaje_success"))
        <div class="col-md-12" id="mensaje-resultado">
            <div class="alert alert-success alert-dismissible" role="alert">
                <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                    <span aria-hidden="true">×</span>
                </button>

                {{ Session::get("mensaje_success") }}
            </div>
        </div>
    @endif

    <div class="col-md-12">
        {!! FuncionesGlobales::valida_boton_req(
            "admin.cargos_especificos.nuevo",
            "Nuevo cargo específico <i class='fa fa-plus' aria-hidden='true'></i>",
            "link",
            "btn btn-warning | tri-br-2 tri-fs-12 tri-txt-green tri-bg-white tri-bd-green tri-transition-300 tri-hover-out-greeny pull-right"
        ) !!}
        <br>
    </div>

    <div class="col-md-6" id="filtro">
        <div class="form-group">
            <label for="inputEmail3">Cliente:</label>
        
            {!! Form::select("cliente_id", $clientes, null, ["class" => "form-control js-select-2-basic | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "cliente_id" ]); !!}
        </div>
        
    </div>

    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table-responsive table text-center" id="data-table">
                    <thead>
                        <tr>
                            <th class="hidden">
                                Cliente
                            </th>

                            <th>
                                Código
                            </th>

                            <th>
                                @if(route("home") == "https://gpc.t3rsc.co")
                                    Nombre del cargo
                                @else
                                    Descripción
                                @endif
                            </th>

                            <th>Cliente</th>

                            <th>
                                Plazo días
                            </th>

                            <th>
                                Estado
                            </th>

                            <th>
                                Acción
                            </th>
                        </tr>
                    </thead>
                    
                    <tbody id="table-body">
                       {!! $view !!}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- BRYG Configuración --}}
@include('admin.bryg._modal_configuracion_cuadrantes')

{{-- Configuración BRYG --}}
<script src="{{ asset('js/admin/bryg-scripts/_js_configuracion_cuadrantes.js') }}"></script>

{{-- Guardar configuración BRYG --}}
<script type="text/javascript">
    $(function () {
        $('.js-select-2-basic').select2({
            placeholder: 'Selecciona o busca'
        });
    });
    //Mostrar modal de configuración BRYG
    let cargoIdGlobal = 0;
    const configurarCargoBRYG = (obj, route) => {
        let cargoId = obj.dataset.cargoid
        cargoIdGlobal = cargoId

        $.ajax({
            type: "POST",
            url: route,
            data: {
                cargo_id: cargoId
            },
            success: function(response){
                if (response.configuracion != null) {
                    document.querySelector('#radical').value = response.configuracion.radical
                    document.querySelector('#genuino').value = response.configuracion.genuino
                    document.querySelector('#garante').value = response.configuracion.garante
                    document.querySelector('#basico').value = response.configuracion.basico

                    valoresGrafico.radical = response.configuracion.radical
                    valoresGrafico.genuino = response.configuracion.genuino
                    valoresGrafico.garante = response.configuracion.garante
                    valoresGrafico.basico = response.configuracion.basico

                    panelDescripcionPerfil.innerHTML = `<span class="badge text-uppercase" style="font-size: 15px !important; background-color: gray;">${response.configuracion.perfil}</span>`
                    panelDescripcionPerfil.removeAttribute('hidden')

                    generarRadarBRYG()
                }

                $('#brygConfiguracionCuadrantes').modal('show')
            }
        })
    }

    const guardarConfiguracionCargoBryg = (obj, route) => {
        if (document.querySelector('#radical').value != 0 || document.querySelector('#genuino').value != 0 || document.querySelector('#garante').value != 0 || document.querySelector('#basico').value != 0) {
            $.ajax({
                type: "POST",
                url: route,
                data: {
                    cargo_modulo: true,
                    cargo_id: cargoIdGlobal,
                    radical: valoresGrafico.radical,
                    genuino: valoresGrafico.genuino,
                    garante: valoresGrafico.garante,
                    basico: valoresGrafico.basico,
                    perfil: perfilGlobal
                },
                beforeSend: function() {
                    obj.setAttribute('disabled', true)
                },
                success: function(response) {
                    $.smkAlert({text: 'Configuración guardada con éxito.', type: 'success'})
                    obj.removeAttribute('disabled')

                    setTimeout(() => {
                        $('#brygConfiguracionCuadrantes').modal('hide')
                    }, 800)
                }
            })
        }else {
            $.smkAlert({text: 'Debes completar los valores de cada cuadrante.', type: 'danger'})
        }
    }

    const configurarExcelCargo = (obj, route) => {
        const cargoId = obj.dataset.cargoid

        $.ajax({
            type: "POST",
            url: route,
            data: {
                cargo_id: cargoId
            },
            success: function (response) {
                $("#modal_gr").find(".modal-content").html(response);
                $("#modal_gr").modal("show");
            }
        });
    }

    const configurarEthicalValues = (obj, route) => {
        const cargoId = obj.dataset.cargoid

        $.ajax({
            type: "POST",
            url: route,
            data: {
                cargo_id: cargoId
            },
            success: function (response) {
                $("#modal_gr").find(".modal-content").html(response);
                $("#modal_gr").modal("show");
            }
        });
    }

    const configurarDigitacionCargo = (obj, route) => {
        const cargoId = obj.dataset.cargoid

        $.ajax({
            type: "POST",
            url: route,
            data: {
                cargo_id: cargoId
            },
            success: function (response) {
                $("#modal_gr").find(".modal-content").html(response);
                $("#modal_gr").modal("show");
            }
        });
    }

    //Guardar configuración Digitación
    const guardarConfiguracionDigitacionCargo = (obj, route) => {
        $.ajax({
            type: "POST",
            url: route,
            data: $('#frmConfiguracionReq').serialize(),
            beforeSend: function() {
                obj.setAttribute('disabled', true)
            },
            success: function(response) {
                $.smkAlert({text: 'Configuración guardada con éxito.', type: 'success'})
                obj.removeAttribute('disabled')

                setTimeout(() => {
                    $('#modal_gr').modal('hide')
                }, 800)
            }
        })
    }

    const cargarListaCargos = (cliente) => {

        var cliente_id=cliente;
        $.ajax({
            type: "POST",
            url: "{{ route('admin.cargos_especificos.getCargosAjax') }}",
            data: {
                cliente_id:cliente_id,
            },
            beforeSend: function(){
                    //imagen de carga
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
            success: function(response) {
                $.unblockUI();
                if ($.fn.DataTable.isDataTable('#data-table')) {
                        var datatable = $('#data-table').DataTable();
                        datatable.destroy();
                    }


            $('#table-body').html(response.view);
            var table = $('#data-table').DataTable({

            "responsive": true,
            "paginate": true,
            "lengthChange": true,
            "deferRender":true,
            "filter": true,
            "sort": true,
            "info": true,
            "lengthMenu": [[10,20, 25, -1], [10,20, 25, "All"]],
            "autoWidth": true,
            "language": {
                "url": '{{ url("js/Spain.json") }}'
            }
        });

                    
            }
        })
    }

    //
    const configurarCargoCompetencias = (obj, route) => {
        const cargoId = obj.dataset.cargoid
        const genericoId = obj.dataset.genericoid

        $.ajax({
            type: 'POST',
            data: {
                cargo_id: cargoId,
                cargo_generico_id: genericoId,
                configuracion_cargo: true
            },
            url: route,
            success: function(response) {
                $("#modal_gr").find(".modal-content").html(response);
                $("#modal_gr").modal("show");
            }
        });
    }

    const guardarConfiguracionCargoCompetencias = (obj, route) => {
        $.ajax({
            type: 'POST',
            url: route,
            data: $('#frmConfiguracionCompetencias').serialize(),
            beforeSend: function() {
                obj.setAttribute('disabled', true)
            },
            success: function(response) {
                $.smkAlert({text: 'Configuración guardada con éxito.', type: 'success'})
                obj.removeAttribute('disabled')

                setTimeout(() => {
                    $('#modal_gr').modal('hide')
                }, 500)

            }
        })
    }
</script>

<script>
    $(function(){      
        $('.btn').prop('disabled',false);
        
        var table = $('#data-table').DataTable({
            "responsive": true,
            "paginate": true,
            "lengthChange": true,
            "deferRender":true,
            "filter": false,
            "sort": true,
            "info": true,
            "lengthMenu": [[10,20, 25, -1], [10,20, 25, "All"]],
            initComplete: function() {
                $('.btn').prop('disabled',false);
                    this.api().column(0).each(function() {
                    var column = this;


                    $('#cliente_id,#empresa_id').on('change', function() {
                        
                        
                        /*var val = $(this).val();
                        column.search(val ? '^' + val + '$' : '', true, false).draw();

                        $('.btn').prop('disabled',false);*/
                    });

                });
            },
            "autoWidth": true,
            "language": {
                "url": '{{ url("js/Spain.json") }}'
            }
        });

        /**
        *  Editar cargo generico
        **/
       $('#cliente_id').change(function(){

        cargarListaCargos($(this).val());

       })

        /**
        *  Editar cargo generico
        **/
        $("#data-table tbody").delegate(".cargoEspecifico","click",function () {

            //var id = table.row( $(this).parents('tr') ).id();
            var id= $(this).data("cargo");
            
            $.ajax({
                url: "{{ route('admin.cargos_especificos.editar') }}",
                type: "POST",
                data: {id: id},
                beforeSend: function(){
                    //imagen de carga
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
                success: function(response) {
                    $.unblockUI();
                    console.log("success");
                    $('.btn').prop('disabled', false);
                    $("#modal_gr").find(".modal-content").html(response);
                    $("#modal_gr").modal("show");
                }
            });
        })
    });
</script>
@endsection