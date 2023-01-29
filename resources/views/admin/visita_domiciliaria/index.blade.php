@extends("admin.layout.master")
@section('contenedor')
    
    {{-- Header --}}
    @include('admin.layout.includes._section_header_breadcrumb', ['page_header' => "Visitas domiciliarias"])

    @if(empty($proceso) && $proceso != 'VISITA_DOMICILIARIA_EVS')
        <div class="container col-md-12">
            <div class="row">
                <button class="btn-success btn pull-right | tri-br-2 tri-fs-12 tri-txt-green tri-bg-white tri-bd-green tri-transition-300 tri-hover-out-greeny pull-right" id="nueva-visita" type="button">
                    <i class="fa fa-plus"></i> Nueva visita
                </button>
            </div>
        </div>
        
        <br>
    @endif

    {!! Form::model(Request::all(), ["id" => "admin.lista_pruebas", "method" => "GET"]) !!}
        <div class="row">
            
            <div class="col-md-6">
                <div class="form-group">
                    <label for="inputEmail3" class="control-label">
                            Número de requerimiento:
                    </label>
                    
                        {!! Form::text("codigo", null, ["class" => "form-control solo-numero | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "placeholder" => ""]); !!}
               </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-4 control-label">Número de cédula:</label>
                   
                        {!! Form::text("cedula", null, ["class" => "form-control solo-numero | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "placeholder" => "# Cédula"]); !!}
                
                </div> 
            </div>
        </div>
         <div class="col-md-12 text-right">
            <button class="btn btn-warning | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" >Buscar</button>
            @if(!empty($slug))
                <a class="btn btn-warning | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-red" href="{{route($slug)}}" >Limpiar</a>
            @else
                <a class="btn btn-warning | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-red" href="{{route("admin.lista_visitas_domiciliarias")}}" >Limpiar</a>
            @endif
            {{--<a class="btn btn-info" href="Javascript:;" onclick="return redireccionar_registro('ref_id[]', this, 'url')">Gestionar Visita</a>--}}
        </div>
    {!! Form::close() !!}

    <br>
    <br>
    <br>
    <br>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped text-center data-table" style="text-align: center;">
                    <thead>
                        <tr>
                            <th>#Visita</th>
                            <th>Clase visita</th>
                            <th>Cédula</th>
                            <th>Nombre</th>
                            <th>Fecha creación</th>
                            <th>Requerimiento</th>
                            <th>Gestionado por candidato</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($candidatos->count() == 0)
                            <tr>
                                <td colspan="12"> No se encontraron registros</td>
                            </tr>
                        @endif

                        @foreach($candidatos as $candidato)
                            <tr>
                                <td>{{$candidato->id_visita}}</td>
                                <td>{{$candidato->clase}}</td>
                                <td>{{ $candidato->numero_id }}</td>
                                <td>{{ $candidato->primer_nombre }} {{ $candidato->segundo_nombre }} {{ $candidato->primer_apellido }} {{ $candidato->segundo_apellido}}</td>
                                <td>{{ $candidato->fecha_creacion }}</td>
                                @if($candidato->requerimiento_id!=null)
                                    <td>{{ $candidato->requerimiento_id }}</td>
                                @else
                                    <td>-</td>
                                @endif
                                <td>
                                    @if($candidato->gestionado_candidato)
                                        <i class="fa fa-check"></i>
                                    @else

                                    @endif
                                </td>
                                <td>
                                    {{--<a
                                        type="button"
                                        class="btn btn-sm btn-info"
                                        href="{{(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co")?route("admin.informe_seleccion",["user_id"=>$candidato->req_cand_id]): route("admin.hv_pdf",["ref_id"=>$candidato->user_id])}}"
                                        target="_blank"
                                    >
                                        HV PDF
                                    </a>--}}
                                    @if(!empty($proceso) && $proceso == 'VISITA_DOMICILIARIA_EVS')
                                        <a
                                            type="button"
                                            class="btn btn-sm btn-warning | tri-br-2 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-200 tri-hover-out-purple"
                                            href='{{route("admin.gestionar_visita_domiciliaria",["id"=>$candidato->id_visita, "tipo"=>"evs"])}}'
                                            
                                        >
                                            Gestionar
                                        </a>
                                    @else
                                        <a
                                            type="button"
                                            class="btn btn-sm btn-warning | tri-br-2 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-200 tri-hover-out-purple"
                                            href='{{route("admin.gestionar_visita_domiciliaria",["id"=>$candidato->id_visita])}}'
                                            
                                        >
                                            Gestionar
                                        </a>
                                    @endif
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-danger cancelar_visita | tri-br-2 tri-fs-12 tri-txt-red tri-bg-white tri-bd-red tri-transition-300 tri-hover-out-redny"
                                        data-id_visita="{{$candidato->id_visita}}"
                                        
                                        
                                    >
                                        Cancelar
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
    {!! $candidatos->appends(Request::all())->render() !!}

    <script>
    $(function(){

        
         $(".cancelar_visita").on("click", function(e){
            e.preventDefault();
            var visita=$(this).data("id_visita");
            var element=$(this);
            $.smkConfirm({
                text:'Seguro de cancelar la visita #'+visita+'?',
                accept:'Aceptar'
                //cancel:'Cancelar'
              },function(res){
                
                if(res){
                    $.ajax({
                    url: "{{ route('admin.visita.cancelar_visita_domiciliaria') }}",
                    data:{
                        id_visita:visita
                    },
                    type: "POST",
                    beforeSend: function(){
                        //imagen de carga
                        /*$.blockUI({
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
                        });*/
                    },
                    success: function(response) {
                        //$.unblockUI();
                        if(response.success){

                        }
                        var table = $('.data-table').DataTable();

                        table
                            .row( element.parents('tr') )
                            .remove()
                            .draw();

                        $.smkAlert({
                            text: 'Visita cancelada con exito',

                            type: 'info',
                            position:'top-right',
                            time:3
                        });
                        //console.log("success");
                        
                    }
                });
            }
            });

            
         });
        $("#nueva-visita").on("click", function(){
            
            $.ajax({
                url: "{{ route('admin.nueva_visita_domiciliaria') }}",
                type: "POST",
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
                    $("#modal_gr").find(".modal-content").html(response);
                    $("#modal_gr").modal("show");
                }
            });
        });
        @if($candidatos->count() != 0)

            $('.data-table').DataTable({
              "responsive": true,
              "columnDefs": [
                  { responsivePriority: 1, targets: 0 },
                  { responsivePriority: 2, targets: -1 }
              ],
              "paginate": true,
              "lengthChange": true,
              "filter": true,
              "sort": true,
              "info": true,
              initComplete: function() {
              //var div = $('#data-table');
              //$("#filtro").prepend("<label for='idDepartamento'>Cliente:</label><select id='idDepartamento' name='idDepartamento' class='form-control' required><option>Seleccione uno...</option><option value='1'>  FRITURAS</option><option value='2'>REFRESCOS</option></select>");
                  this.api().column(0).each(function() {
                      var column = this;
                      console.log(column.data());
                      $('#estado_id').on('change', function() {
                          var val = $(this).val();
                          column.search(val ? '^' + val + '$' : '', true, false)
                              .draw();
                      });
                  });
              },
              "autoWidth": true,
              "order": [[ 1, "desc" ]],
              "language": {
                  "url": '{{ url("js/Spain.json") }}'
              }
          });
        @endif

    });
    
    
</script>
@stop
