@extends("admin.layout.master")
@section('contenedor')

    <style>
        .dropdown-menu{
            left: -80px;
            padding: 0;
        }

        .form-control-feedback{
            display: none !important;
        }

        .smk-error-msg{
            position: unset !important;
            float: right;
            margin-right: 14px !important;
        }

        .text-center {
            text-align: center;
        }
    </style>

     @include('admin.layout.includes._section_header_breadcrumb', ['page_header' => "Tipos documentos clientes"])

    

    <div class="clearfix"></div>

    <div class="row">
    

   

    {!! Form::model(Request::all(), ["route" => "admin.gestion_documental.clientes.tipos_documentos.index", "method" => "GET"]) !!}
        @if(Session::has("mensaje_success"))
            <div class="col-md-12" id="mensaje-resultado">
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{ Session::get("mensaje_success") }}
                </div>
            </div>
        @endif

        

        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="control-label">Categoría:</label>

                    
            {!! Form::select("categoria_id", $categorias, null,["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" ]); !!}
                    
        </div>

        <div class="clearfix"></div>
        
        
        <div class="clearfix"></div>

        <div class="col-md-12 text-right">
    
             <button type="submit" class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green">
                Buscar <i aria-hidden="true" class="fa fa-search"></i>
            </button>

             <a class="btn btn-success | tri-px-2 text-white tri-br-2 tri-border--none tri-transition-200 tri-green" href="{{ route('admin.gestion_documental.clientes.tipos_documentos.create') }}">
                   Nuevo tipo <i aria-hidden="true" class="fas fa-plus"></i>
                </a>

            <a class="btn btn-danger | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-red" href="{{ route('admin.gestion_documental.clientes.tipos_documentos.index') }}">
                    Limpiar
            </a>
        </div>

        
    {!! Form::close() !!}
    <br>
    <br>
       

       
    </div>

    <br>

    <div class="clearfix"></div>

    

    <div class="clearfix"></div>
   
    <div class="col-md-12 mt-2">
            <div class="panel panel-default">
                <div class="panel-body">
        
            <table class="table table-bordered table-hover" id="data-table">
                <thead>
                    <tr>
                        {{--<th>
                            {!! Form::checkbox("seleccionar_todos_candidatos_vinculados", null, false, ["id" => "seleccionar_todos_candidatos_vinculados"]) !!}
                        </th>--}}
                        <th>ID</th>
                        <th>DESCRIPCIÓN</th>
                        <th>ESTADO</th>
                        <th>CATEGORÍA</th>
                       
           
                        <th style="text-align: center;">ACCIÓN</th>
                    </tr>
                </thead>

                <tbody>
                    @if($listas->count() == 0)
                        <tr>
                            <td colspan="5">No se encontraron registros</td>
                        </tr>
                    @endif

                    @foreach($listas as $tipo)
                        <tr>
                            {{--<td>
                                {!! Form::hidden("req_id", $candidato_req->req_id) !!}
                                <input
                                    class="check_candi"
                                    data-candidato_req="{{ $candidato_req->req_can_id }}"
                                    data-cliente=""
                                    name="req_candidato[]"
                                    type="checkbox"
                                    value="{{ $candidato_req->req_can_id }}"
                                >
                            </td>--}}
                             <td>
                                {{ $tipo->id }}
                            </td>
                            <td>
                                {{ $tipo->descripcion}}
                            </td>
                            <td>
                                @if($tipo->active)
                                    Activo
                                @else
                                    Inactivo
                                @endif
                            </td>
                            <td>
                                {{ $tipo->tipo_categoria->descripcion}}
                            </td>
             
                            <td class="text-center">
                                <div class="btn-group-vertical" role="group" aria-label="...">
                                    
                              
                                    <a
                                        class="btn btn-primary btn-sm btn-block | tri-br-2 tri-fs-12 tri-txt-gray tri-bg-white tri-bd-gray tri-transition-300 tri-hover-out-gray"
                                        href="{{ route('admin.gestion_documental.clientes.tipos_documentos.edit', ['id' => $tipo->id]) }}"
                                        
                                    >
                                        Editar
                                    </a>

                                    
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

    

    {{--<div>
        {!! $lista_clientes->appends(Request::all())->render() !!}
    </div>--}}

    <script type="text/javascript">
    

        //Pausar firma contrato
        

        $(function () {

             table=$('#data-table').DataTable({
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

             allPages = table.cells( ).nodes( );

            

  

            $(".editar-tipo").on("click", function(){
                let id=$(this).data('id');
                $.ajax({
                    url: "{{ route('admin.gestion_documental.clientes.tipos_documentos.edit') }}",
                    data: {
                        id:id
                       
                    },
                    type: 'POST',
                    beforeSend: function(){
                    },
                    success: function(response) {
                        console.log("success");
                        $("#modalTriLarge").find(".modal-content").html(response);
                        $("#modalTriLarge").modal("show");
                    }
                });
             });
      
            
        });
    </script>
@stop