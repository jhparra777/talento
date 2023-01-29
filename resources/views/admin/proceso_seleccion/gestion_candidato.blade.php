@extends("admin.layout.master_full")
@section("contenedor")
@if(Session::has("mensaje_error"))
<div class="col-md-12" id="mensaje-resultado">
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {!! Session::get("mensaje_error") !!}
    </div>
</div>
@endif
@if(Session::has("mensaje_success"))
<div class="col-md-12" id="mensaje-resultado">
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {!! Session::get("mensaje_success") !!}
    </div>
</div>
@endif

{!! Form::model($datos_basicos,["route"=>"admin.guardar_entrevista_seleccion","method"=>"POST"]) !!}
{!!  Form::hidden("candidato_id",$datos_basicos->user_id)!!}
{!!  Form::hidden("user_id",null,["id"=>"user_id"]) !!}
{!!  Form::hidden("turno_id",$turnoAsoc->id,["id"=>"turno_id"])!!}
<div class="row">

    <div class="col-md-6">
        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">Cedula:</label>
            <div class="col-sm-9">
                {!! Form::text("numero_id",null,["class"=>"form-control","placeholder"=>"descripcion" ]); !!}
            </div>
        </div>
        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">Nombres:</label>
            <div class="col-sm-9">
                {!! Form::text("nombres",null,["class"=>"form-control","placeholder"=>"descripcion" ]); !!}
            </div>
        </div>
        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">Primer Apellido:</label>
            <div class="col-sm-9">
                {!! Form::text("primer_apellido",null,["class"=>"form-control","placeholder"=>"descripcion" ]); !!}
            </div>
        </div>
        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">Segundo Apellido:</label>
            <div class="col-sm-9">
                {!! Form::text("segundo_apellido",null,["class"=>"form-control","placeholder"=>"descripcion" ]); !!}
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="col-md-6 text-center">
            <a  target="_black" class="btn btn-success btn-lg" href="{{route("admin.hv_pdf",["id"=>$datos_basicos->user_id])}}">
                <small class="fa fa-file-pdf-o" aria-hidden="true""></small> HV PDF
            </a>
        </div>
        <div class="col-md-6 text-center">
            <button type="button" class="btn btn-warning btn-lg" id="ver_pruebas">
                <small class="fa fa-check" aria-hidden="true""></small> PRUEBAS
            </button>
        </div>
        

        <div class="clearfix"></div>
        <br>
        <br>
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Fuente de Reclutamiento </label>
            <div class="col-sm-12">
                {!! Form::select("fuentes_publicidad_id",$fuentes,null,["class"=>"form-control","id"=>"textarea"]); !!}
            </div>
            <p class="error text-danger ">{!! FuncionesGlobales::getErrorData("fuentes_publicidad_id",$errors) !!}</p>
        </div>
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Aspecto Familiar</label>
            <div class="col-sm-12">
                {!! Form::textarea("aspecto_familiar",null,["class"=>"form-control","id"=>"textarea","rows"=>"3"]); !!}
            </div>
            <p class="error text-danger ">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
        </div>
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Aspectos Académicos</label>
            <div class="col-sm-12">
                {!! Form::textarea("aspecto_academico",null,["class"=>"form-control","id"=>"textarea","rows"=>"3"]); !!}
            </div>
            <p class="error text-danger ">{!! FuncionesGlobales::getErrorData("aspecto_academico",$errors) !!}</p>
        </div>
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Aspectos Experiencia</label>
            <div class="col-sm-12">
                {!! Form::textarea("aspectos_experiencia",null,["class"=>"form-control","id"=>"textarea","rows"=>"3"]); !!}
            </div>
            <p class="error text-danger ">{!! FuncionesGlobales::getErrorData("aspectos_experiencia",$errors) !!}</p>
        </div>
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Aspectos de Personalidad</label>
            <div class="col-sm-12">
                {!! Form::textarea("aspecto_familiar",null,["class"=>"form-control","id"=>"textarea","rows"=>"3"]); !!}
            </div>
            <p class="error text-danger ">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
        </div>

        <h3>Concepto de las competencias</h3>
        <div class="col-md-12">
            <table class="table table-bordered tbl_info">
                <thead>
                    <tr>
                        <th>Nombre Competencia</th>
                        <th >No la evidencia</th>
                        <th style="width:10px">Débil</th>
                        <th style="width:10px">Aceptable</th>
                        <th style="width:10px">Fuerte</th>
                        <th style="width:40%">Observaciones</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td>Interés por el cliente</td>
                        <td width="10">{!!  Form::radio("competencia[1]",1) !!}</td>
                        <td>{!!  Form::radio("competencia[1]",2) !!}</td>
                        <td>{!!  Form::radio("competencia[1]",3) !!}</td>
                        <td>{!!  Form::radio("competencia[1]",4) !!}</td>
                        <td>{!!  Form::textarea("descripcion[1]",null,["class"=>"form-control","rows"=>3]) !!}</td>
                    </tr>
                    <tr>
                        <td>Trabajo en equipo</td>
                        <td width="10">{!!  Form::radio("competencia[2]",1) !!}</td>
                        <td>{!!  Form::radio("competencia[2]",2) !!}</td>
                        <td>{!!  Form::radio("competencia[2]",3) !!}</td>
                        <td>{!!  Form::radio("competencia[2]",4) !!}</td>
                        <td>{!!  Form::textarea("descripcion[2]",null,["class"=>"form-control","rows"=>3]) !!}</td>
                    </tr>
                    <tr>
                        <td>Liderazgo</td>
                        <td width="10">{!!  Form::radio("competencia[3]",1) !!}</td>
                        <td>{!!  Form::radio("competencia[3]",2) !!}</td>
                        <td>{!!  Form::radio("competencia[3]",3) !!}</td>
                        <td>{!!  Form::radio("competencia[3]",4) !!}</td>
                        <td>{!!  Form::textarea("descripcion[3]",null,["class"=>"form-control","rows"=>3]) !!}</td>
                    </tr>
                    <tr>
                        <td>Pensamiento Estrategico</td>
                        <td width="10">{!!  Form::radio("competencia[4]",1) !!}</td>
                        <td>{!!  Form::radio("competencia[4]",2) !!}</td>
                        <td>{!!  Form::radio("competencia[4]",3) !!}</td>
                        <td>{!!  Form::radio("competencia[4]",4) !!}</td>
                        <td>{!!  Form::textarea("descripcion[4]",null,["class"=>"form-control","rows"=>3]) !!}</td>
                    </tr>
                    <tr>
                        <td>Aprendizaje y agregacion de valor</td>
                        <td width="10">{!!  Form::radio("competencia[5]",1) !!}</td>
                        <td>{!!  Form::radio("competencia[5]",2) !!}</td>
                        <td>{!!  Form::radio("competencia[5]",3) !!}</td>
                        <td>{!!  Form::radio("competencia[5]",4) !!}</td>
                        <td>{!!  Form::textarea("descripcion[5]",null,["class"=>"form-control","rows"=>3]) !!}</td>
                    </tr>
                    <tr>
                        <td>Obtención de resultados</td>
                        <td width="10">{!!  Form::radio("competencia[6]",1) !!}</td>
                        <td>{!!  Form::radio("competencia[6]",2) !!}</td>
                        <td>{!!  Form::radio("competencia[6]",3) !!}</td>
                        <td>{!!  Form::radio("competencia[6]",4) !!}</td>
                        <td>{!!  Form::textarea("descripcion[6]",null,["class"=>"form-control","rows"=>3]) !!}</td>
                    </tr>


                </tbody>
            </table>
        </div>

        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Fortalezas frente al Cargo</label>
            <div class="col-sm-12">
                {!! Form::textarea("fortalezas_cargo",null,["class"=>"form-control","id"=>"textarea","rows"=>"3"]); !!}
            </div>
            <p class="error text-danger ">{!! FuncionesGlobales::getErrorData("fortalezas_cargo",$errors) !!}</p>
        </div>
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Oportunidades de mejora frente al cargo</label>
            <div class="col-sm-12">
                {!! Form::textarea("oportunidad_cargo",null,["class"=>"form-control","id"=>"textarea","rows"=>"3"]); !!}
            </div>
            <p class="error text-danger ">{!! FuncionesGlobales::getErrorData("oportunidad_cargo",$errors) !!}</p>
        </div>
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Concepto General</label>
            <div class="col-sm-12">
                {!! Form::textarea("concepto_general",null,["class"=>"form-control","id"=>"textarea","rows"=>"3"]); !!}
            </div>
            <p class="error text-danger ">{!! FuncionesGlobales::getErrorData("concepto_general",$errors) !!}</p>
        </div>
        <div class="col-sm-6 col-lg-6">
            <div class="form-group">
                <label for="trabajo-empresa-temporal" class="col-md-5 control-label">Evaluación por competencias:</label>
                <div class="col-md-7">
                {!! Form::checkbox("evaluacion_si_no",0,null,["class"=>"fantasma" ]) !!}
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-lg-12 ocultar">
            <div class="form-group">
                <div class="col-md-12">
                    {!! Form::textarea("evaluacion_competencias",null,["class"=>"form-control","id"=>"textarea","rows"=>"3"]); !!}
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-6">
            <div class="form-group">
                <label for="trabajo-empresa-temporal" class="col-md-5 control-label">Apto:</label>
                <div class="col-md-7">
                    {!! Form::checkbox("apto",1,null,["class"=>"checkbox-preferencias" ]) !!}

                </div>
            </div>
            <p class="error text-danger ">{!! FuncionesGlobales::getErrorData("apto",$errors) !!}</p>
        </div>

    </div>
    <div class="col-md-6">
        <div class="col-md-8 form-group">
            <label for="inputEmail3" class="col-sm-3 control-label"># Req</label>
            <div class="col-sm-9">
                {!! Form::text("busq_req",null,["class"=>"form-control","id"=>"busq_req"]); !!}
            </div>
            <p class="error text-danger ">{!! FuncionesGlobales::getErrorData("fortalezas_cargo",$errors) !!}</p>
        </div>
        <div class="col-md-4 form-group">
            <button class="btn btn-success" type="button" id="buscar_requerimiento">Buscar</button>
        </div>
        <div class="clearfix"></div>
        <hr>
        <div id="bloque_requerimientos">
            <p class="error text-danger ">{!! FuncionesGlobales::getErrorData("req_id",$errors) !!}</p>    
            <div class="col-md-12">
                <h4>Requerimientos Prioritarios</h4>
                <div class="clearfix"></div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" style="background: #fff">
                        <thead>
                            <tr>
                                <td></td>
                                <td># Req</td>
                                <td>Cliente</td>
                                <td>Ciudad</td>
                                <td>Cargo</td>
                                <td>Acción</td>
                            </tr>
                        </thead>
                        <tbody>
                            @if($req_prioritarios->count() == 0)
                            <tr>
                                <td colspan="6">No se encontraron registros</td>
                            </tr>
                            @endif
                            @foreach($req_prioritarios as $req)
                            <tr>
                                <td>{!! Form::radio("req_id",$req->req_id) !!}</td>
                                <td>{{$req->req_id}}</td>
                                <td>{{$req->nombre_cliente}}</td>
                                <td>{{$req->getUbicacion()->ciudad}}</td>
                                <td>{{$req->desc_cargo}}</td>
                                <td>
                                    <a class="btn btn-danger btn-sm" target="_black" href="{{route("admin.ficha_pdf",["id"=>$req->id])}}">
                                        <span class="fa fa-file-pdf-o"></span>Ficha
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-12">
                <h4>Requerimientos sugeridos por reclutador</h4>
                <div class="clearfix"></div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" style="background: #fff">
                        <thead>
                            <tr>
                                <td></td>
                                <td># Req</td>
                                <td>Cliente</td>
                                <td>Ciudad</td>
                                <td>Cargo</td>
                                <td>Acción</td>
                            </tr>
                        </thead>
                        <tbody>
                    <tbody>
                        @if($req_reclutadores->count() == 0)
                        <tr>
                            <td colspan="6">No se encontraron registros</td>
                        </tr>
                        @endif
                        @foreach($req_reclutadores as $req)
                        <tr>
                            <td>{!! Form::radio("req_id",$req->req_id) !!}</td>
                            <td>{{$req->req_id}}</td>
                            <td>{{$req->nombre_cliente}}</td>
                            <td>{{$req->getUbicacion()->ciudad}}</td>
                            <td>{{$req->desc_cargo}}</td>
                            <td>
                                <a class="btn btn-danger btn-sm" target="_black" href="{{route("admin.ficha_pdf",["id"=>$req->id])}}">
                                    <span class="fa fa-file-pdf-o"></span>Ficha
                                </a>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <div class="col-md-12">
                <h4>Requerimientos Sugeridos por enlace</h4>
                <!-- -->
                <div class="clearfix"></div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" style="background: #fff">
                        <thead>
                            <tr>
                                <td></td>
                                <td># Req</td>
                                <td>Cliente</td>
                                <td>Ciudad</td>
                                <td>Cargo</td>
                                <td>Acción</td>
                            </tr>
                        </thead>
                        <tbody>
                            @if($req_sueridos->count() == 0)
                                <tr>
                                    <td colspan="6">No se encontraron registros</td>
                                </tr>
                            @endif
                            @foreach($req_sueridos as $req)
                                <tr>
                                    <td>
                                        {!! Form::radio("req_id",$req->req_id) !!}
                                    </td>
                                    <td>{{$req->req_id}}</td>
                                    <td>{{$req->nombre_cliente}}</td>
                                    <td>{{$req->getUbicacion()->ciudad}}</td>
                                    <td>{{$req->desc_cargo}}</td>
                                    <td>
                                        <a class="btn btn-danger btn-sm" target="_black" href="{{route("admin.ficha_pdf",["id"=>$req->id])}}">
                                            <span class="fa fa-file-pdf-o"></span>Ficha
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- -->
            </div>
        </div>
    </div>
</div>
{!! Form::submit("Guardar",["class"=>"btn btn-success"]) !!}
{!! Form::close() !!}
<script>
    $(function () {
        $("#buscar_requerimiento").on("click", function () {
            $.ajax({
                type: "POST",
                data: "req=" + $("#busq_req").val() + "&turno_id=" + $("#turno_id").val(),
                url: "{{ route('admin.lista_req_proceso_seleccion') }}",
                success: function (response) {
                    $("#bloque_requerimientos").html(response);
                }
            });
        });
    });

    //Modal ver pruebas
    $("#ver_pruebas").on("click", function () {
            user_id = $("#user_id").val();
            $.ajax({
                type: "POST",
                data: {"user_id":user_id},
                url: "{{ route('admin.detalle_prueba_seleccion') }}",
                success: function (response) {
                    $("#modal_peq").find(".modal-content").html(response);
                    $("#modal_peq").modal("show");
                }
            });
        });

     //Ocultar textarea evaluacion competencias
    $(function(){
        $('.ocultar').hide();

        $('.fantasma').change(function(){
            if(!$(this).prop('checked')){
                $('.ocultar').hide();
            }else{
                $('.ocultar').show();
            }
  
        })

    })
</script>
@stop