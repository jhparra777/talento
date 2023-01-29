@extends("admin.layout.master")
@section('contenedor')
    <h3>Visitas Domiciliarias</h3>

        <div class="row">
            <button class="btn-success btn pull-right" id="nueva-visita" type="button">
                        <i class="fa fa-plus">
                        </i>
                        Nueva visita
            </button>
        </div>
        <br>

    {!! Form::model(Request::all(), ["id" => "admin.lista_pruebas", "method" => "GET"]) !!}
        <div class="row">
            
            <div class="col-md-6  form-group">
                <label for="inputEmail3" class="col-sm-4 control-label">
                        # Requerimiento:
                </label>
                <div class="col-sm-8">
                    {!! Form::text("codigo", null, ["class" => "form-control solo-numero", "placeholder" => ""]); !!}
                </div>  
            </div>

            <div class="col-md-6  form-group">
                <label for="inputEmail3" class="col-sm-4 control-label"># Cédula:</label>
                <div class="col-sm-8">
                    {!! Form::text("cedula", null, ["class" => "form-control solo-numero", "placeholder" => "# Cédula"]); !!}
                </div> 
            </div>
        </div>

        <button class="btn btn-warning" >Buscar</button>
        <a class="btn btn-warning" href="{{route("admin.lista_visitas_domiciliarias")}}" >Limpiar</a>
        <a class="btn btn-info" href="Javascript:;" onclick="return redireccionar_registro('ref_id[]', this, 'url')">Gestionar Visita</a>
    {!! Form::close() !!}

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td></td>
                    <td>Requerimiento</td>
                    @if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co")
                        <td>Sede</td>
                    @else
                        <td>Ciudad</td>
                    @endif
                    <td>Cedula</td>
                    <td>Nombre</td>
                    <td>Estado</td>
                    <td>Acción</td>
                </tr>
            </thead>
            <tbody>
                @if($candidatos->count() == 0)
                    <tr>
                        <td colspan="4"> No se encontraron registros</td>
                    </tr>
                @endif

                @foreach($candidatos as $candidato)
                    <tr>
                        <td>
                            {!! Form::checkbox("ref_id[]", $candidato->ref_id, null, [
                                "data-url" => route('admin.gestionar_visita_domiciliaria', ["ref_id" => $candidato->ref_id])
                            ]) !!}
                        </td>
                        <td>{{ $candidato->requerimiento_id }}</td>

                        @if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co")
                            <td>{{ $candidato->descripcion }}</td>
                        @else
                            <td>{{ $candidato->getUbicacionReq() }}</td>
                        @endif

                        <td>{{ $candidato->numero_id }}</td>
                        <td>{{ $candidato->fullname() }}</td>
                        <td>{{ $candidato->proceso }}</td>
                        <td>
                            <a
                                type="button"
                                class="btn btn-sm btn-info"
                                href="{{(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co")?route("admin.informe_seleccion",["user_id"=>$candidato->req_cand_id]): route("admin.hv_pdf",["ref_id"=>$candidato->user_id])}}"
                                target="_blank"
                            >
                                HV PDF
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    {!! $candidatos->appends(Request::all())->render() !!}
@stop
<script type="text/javascript">
    
    $("#nueva-visita").on("click", function(){
            $.ajax({
                url: "{{ route('admin.visita.nueva_visita') }}",
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
</script>