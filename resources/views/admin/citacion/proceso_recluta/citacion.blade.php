@extends("admin.layout.master")
@section("contenedor")

    <div class="clearfix"></div>

    @if($candidato->estado_reclutamiento ==  config('conf_aplicacion.PROBLEMA_SEGURIDAD'))
        <div style="background-color: red; height: 50px"></div>
    @else
        @if(isset($candidato) && Request::get("numero_id") != "" )
            {!! Form::model($candidato,["method"=>"post","route"=>"admin.guardar_proceso_candidato","id"=>"fr_candidatos"]) !!}
            {!! Form::hidden("numero_id",Request::get("numero_id")) !!}
            {!! Form::hidden("db_carga_id",Request::get("db_carga_id")) !!}
            {!! Form::hidden("return",false) !!}
            {!! Form::hidden("user_id",null) !!}

            @if($candidato->user_id == 0)
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    Este usuario no tiene registrada su hoja de vida.
                </div>
            @endif

            <div class="bloques_perfilamiento">
                <div class="col-md-3">
                    <div class="bloque" style="background: #FFAA39;">
                        <h4>Información candidato</h4>

                        <div class="form-group col-md-12">
                            {!! Form::label('identificacion', 'Identificación') !!}
                            {!! Form::text('identificacion',null,['class'=>'form-control','id'=>'identificacion','placeholder'=>'Número Identificación','value'=>old('identificacion')]) !!}
                            <p class="text-danger">{!! FuncionesGlobales::getErrorData("identificacion",$errors) !!}</p>
                        </div>

                        <div class="form-group col-md-12">
                            {!! Form::label('name', 'Nombres') !!}
                            {!! Form::text('nombres',null,['class'=>'form-control','id'=>'name','placeholder'=>'Nombres','value'=>old('name')]) !!}
                            <p class="text-danger">{!! FuncionesGlobales::getErrorData("name",$errors) !!}</p>
                        </div>


                        <div class="form-group col-md-12">
                            {!! Form::label('primer_apellido', 'Primer Apellido') !!}
                            {!! Form::text('primer_apellido',null,['class'=>'form-control','id'=>'primer_apellido','placeholder'=>'Primer Apellido','value'=>old('primer_apellido')]) !!}
                            <p class="text-danger">{!! FuncionesGlobales::getErrorData("primer_apellido",$errors) !!}</p>
                        </div>


                        <div class="form-group col-md-12">
                            {!! Form::label('segundo_apellido', 'Segundo Apellido') !!}
                            {!! Form::text('segundo_apellido',null,['class'=>'form-control','id'=>'segundo_apellido','placeholder'=>'Segundo Apellido','value'=>old('segundo_apellido')]) !!}
                            <p class="text-danger">{!! FuncionesGlobales::getErrorData("segundo_apellido",$errors) !!}</p>
                        </div>

                        <div class="form-group col-md-12">
                            {!! Form::label('telefono_fijo', 'Teléfono Fijo') !!}
                            {!! Form::text('telefono_fijo',null,['class'=>'form-control','id'=>'telefono_fijo','placeholder'=>'Teléfono Fijo','value'=>old('telefono_fijo')]) !!}
                            <p class="text-danger">{!! FuncionesGlobales::getErrorData("telefono_fijo",$errors) !!}</p>
                        </div>


                        <div class="form-group col-md-12">
                            {!! Form::label('telefono_movil', 'Teléfono Móvil') !!}
                            {!! Form::text('telefono_movil',null,['class'=>'form-control','id'=>'telefono_movil','placeholder'=>'Teléfono Móvil']) !!}
                            <p class="text-danger">{!! FuncionesGlobales::getErrorData("telefono_movil",$errors) !!}</p>
                        </div>

                        <div class="form-group col-md-12">
                            {!! Form::label('email', 'Correo Electronico') !!}
                            {!! Form::text('email',null,['class'=>'form-control','id'=>'email','placeholder'=>'Dirección de Correo Electronico']) !!}
                            <p class="text-danger">{!! FuncionesGlobales::getErrorData("telefono_movil",$errors) !!}</p>
                        </div>

                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="col-md-3" style="background: #FF9600">
                    <div  style="background: #FF9600;">
                        <div class="container_cargos" style="background: #FF9600">
                            <div class="bloque" style="background: #FF9600">
                                <h4>Cargos genericos</h4>

                                @foreach($cargos_seleccionados as $cargos_s)
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-10">{!! Form::select("cargos_genericos[]",$cargos,$cargos_s->tabla_id,["class"=>"form-control cargos_genericos id_cargo"]) !!}</div>    
                                        <div class="col-md-2 button_action">
                                            {!! FuncionesGlobales::valida_boton_req("admin.reclutamiento_elimina_cargo","-","boton","btn btn-danger btn_eliminar",["data-id" => $cargos_s->id]) !!}
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-10">
                                        {!! Form::hidden("cargos_genericos[]",null,["class"=>"form-control cargos_genericos id_cargo","id"=>"cargos_genericos"]) !!}
                                        {!! Form::text("cargo_autocomplete",null,["class"=>"form-control cargo_autocomplete","id"=>"cargo_autocomplete", "placeholder"=>"Digita el cargo"]) !!}
                                        </div>
                                        <div class="col-md-2 button_action"><button type="button" class="btn btn-primary btn_agregar">+</button></div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>

                    <!-- Datos Citación -->
                            <div class="form-group col-md-12" style="background: #FFAA39;">
                                <h4>Datos Citación</h4>
                                    {!! Form::label('id_motivo', 'Motivo') !!}
                                    {!! Form::select("id_motivo",$tipos_motivos,null,["class"=>"form-control","id"=>"id_motivo","onclick"=>"mostrarReferencia();"]) !!}
                                    <p class="text-danger">{!! FuncionesGlobales::getErrorData("id_motivo",$errors) !!}</p>

                                    {!! Form::label('tipificacion', 'Tipificación') !!}
                                    {!! Form::select("tipificacion",$tipificacion,null,["class"=>"form-control","id"=>"tipificacion"]) !!}
                                    <p class="text-danger">{!! FuncionesGlobales::getErrorData("tipificacion",$errors) !!}</p>
                                

                                    {!! Form::label('direccion_cita', 'Dirección') !!}
                                    {!! Form::text('direccion_cita',null,['class'=>'form-control','id'=>'direccion_cita','placeholder'=>'Dirección Cita']) !!}
                                    <p class="text-danger">{!! FuncionesGlobales::getErrorData("direccion_cita",$errors) !!}</p>

                                    {!! Form::label('fecha_cita', 'Fecha Cita') !!}
                                    {!! Form::text("fecha_cita",null,["class"=>"form-control", "id"=>"fecha_cita" ,"placeholder"=>"Fecha Expedición" ]) !!}
                                    <p class="text-danger">{!! FuncionesGlobales::getErrorData("fecha_cita",$errors) !!}</p>

                                    {!! Form::label('hora', 'Hora Citación') !!}
                                    {!! Form::select("hora_cita",$franja_hora,null,["class"=>"form-control","id"=>"hora_cita"]) !!}
                                    <p class="text-danger">
                                        {!! FuncionesGlobales::getErrorData("hora_cita",$errors) !!}
                                    </p>

                                    {!! Form::label('observaciones', 'Observacion') !!}
                                    {!! Form::textarea("observaciones",null,["class"=>"form-control", "id"=>"observaciones" ,"placeholder"=>"Observaciones para la cita..." ]) !!}
                                    <p class="text-danger">{!! FuncionesGlobales::getErrorData("observaciones",$errors) !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="bloque" style="background: #EA8806;border-radius: 0 5px 5px 0">
                        <h4>Requerimientos Priorizados</h4>
                        <div style="display: flex; flex-wrap: wrap; justify-content: center;">
                            @foreach($requerimientos_priorizados as $priorizado)
                            <div class="flex-container-cargo-seleccionado" id="item_cargo_{{$priorizado->id}}">
                                <div class="flex-item-cargo-seleccionado-texto set-general-font">{{$priorizado->id}}</div>
                                <div class="flex-item-cargo-seleccionado-icon-pdf">
                                    <a class="fa fa-file-pdf-o" target="_black" href="{{route("admin.ficha_pdf",["id"=>$priorizado->id])}}">
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <h4>Requerimientos Seleccionados</h4>
                        <div style="display: flex; flex-wrap: wrap; justify-content: center;" id="requerimientos_seleccionados">
                            @foreach($requerimientos_seleccionados as $req)
                            <div class="flex-container-cargo-seleccionado" id="item_cargo_{{$req->tabla_id}}">
                                <div class="flex-item-cargo-seleccionado-texto set-general-font">{{$req->tabla_id}}</div>
                                <div class="flex-item-cargo-seleccionado-icon-pdf">
                                    <a class="fa fa-file-pdf-o" target="_black" href="{{route("admin.ficha_pdf",["id"=>$req->tabla_id])}}">
                                    </a>
                                </div>
                                {!! FuncionesGlobales::valida_boton_req('admin.reclutamiento_elimina_req','<i class="fa fa-times"></i>','boton','flex-item-cargo-seleccionado-icon eliminar_req',["data-id" => $req->id]) !!}
                                <input type="hidden" value="{{$req->tabla_id}}" name="requerimientos_sugeridos[]">
                            </div>
                            @endforeach
                        </div>
                        <h4>Requerimientos</h4>
                        <div class="form-group col-md-12">
                            <div class="col-md-8">
                                {!! Form::label('requerimiento', 'Requerimiento') !!}
                                {!! Form::text('requerimiento_id',null,['class'=>'form-control solo_numeros','id'=>'requerimiento_id','placeholder'=>'No. Requerimiento']) !!}
                                <p class="text-danger">{!! FuncionesGlobales::getErrorData("telefono_fijo",$errors) !!}</p>
                            </div>
                            <div class="col-md-4">
                                <br/>
                                <button type="button" class="btn btn-primary" id="btn_buscar_requerimiento" >Buscar</button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div id="requerimientos">

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
                                        @foreach($requerimientos as $req)
                                        <tr>
                                            <td>{!! Form::checkbox("req[]",$req->id,null,["class"=>"seleccionar_requerimiento"]) !!}</td>
                                            <td>{{$req->id}}</td>
                                            <td>{{$req->empresa()->nombre}}</td>
                                            <td>{{$req->getUbicacion()->ciudad}}</td>
                                            <td>{{$req->cargo()->descripcion}}</td>
                                            <td>
                                                <a class="btn btn-danger btn-sm" target="_black" href="{{route("admin.ficha_pdf",["id"=>$req->id])}}">
                                                    <span class="fa fa-file-pdf-o"></span>Ficha
                                                </a>
                                            </td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {!! $requerimientos->render() !!}

                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <br/>
            <button type="submit" class="btn btn-success">Guardar</button>
            <a href="{{route("admin.enviar_call_center",["identificacion" => $candidato->identificacion, "id_carga" => $candidato->id])}}" class="btn btn-warning">Enviar Call Center</a>
            {!! Form::close() !!}
        @endif
    @endif

<script>
    $(function () {

        $("#fecha_cita").datepicker(confDatepicker);

        $(document).on("click", ".cargo_autocomplete", function () {
            var obj = $(this).parent();
            $(this).autocomplete({
                serviceUrl: '{{ route("autocomplete_cargos") }}',
                autoSelectFirst: true,
                onSelect: function (suggestion) {
                    obj.find(".id_cargo").val(suggestion.id);
                    cargar_requerimientos(1);
                },
                onSearchStart: function () {
                }, onSearchComplete: function (query, suggestions) {
                    if (suggestions.length <= 0) {
                    }
                }
            });
        });

        $(document).on("click", ".btn_eliminar", function () {
            //VALIDAR SI ES UN REGISTRO EXISTENTE
            var data_id = $(this).data("id");
            var obj = $(this);
            if (typeof data_id != "undefined") {
                //ELIMINA REGISTRO
                $.ajax({
                    type: "POST",
                    data: {id: data_id},
                    url: "{{route('admin.reclutamiento_elimina_cargo')}}",
                    success: function () {
                        obj.parents(".row").remove();
                        cargar_requerimientos(1);
                    }

                });
            } else {
                $(this).parents(".row").remove();
                cargar_requerimientos(1);
            }



        });
        $(document).on("click", ".btn_agregar", function () {
            var selector = $(".container_cargos .id_cargo").last().val();
            if (selector == "") {
                alert("Debe seleccionar un cargo")
            } else {
                var control = $(this).parents(".row").eq(0).clone();
                var padre = $(this).parents(".button_action");
                padre.append("{!! FuncionesGlobales::valida_boton_req('admin.reclutamiento_elimina_cargo','-','boton','btn btn-danger btn_eliminar') !!}");
                $(this).remove();


                $(".container_cargos .bloque").append(control);
            }

            //console.log("add");

        });

        $(document).on("change", ".cargos_genericos", function () {
            cargar_requerimientos(1);
        });

        $(document).on("click", ".pagination a", function (e) {
            e.preventDefault();
            var page = $(this).attr("href").split("?");
            page = page[1].split("=");
            console.log(page);
            cargar_requerimientos(page[1]);
        });

        $(document).on("click", "#btn_buscar_requerimiento", function () {
            cargar_requerimientos(1);
        });

        function cargar_requerimientos(page) {
            $("#requerimientos").html("Buscando requerimientos....");
            $.ajax({
                type: "POST",
                data: $(".container_cargos .id_cargo").serialize() + "&" + $("input[name='requerimientos_sugeridos[]']").serialize() + "&page=" + page + "&requerimiento_id=" + $("#requerimiento_id").val(),
                url: "{{ route('admin.cargar_requerimientos_perfil') }}",
                success: function (response) {
                    $("#requerimientos").html(response);
                }
            });
        }
        
        $(document).on("click", ".seleccionar_requerimiento", function () {
            var id = $(this).val();
            var div = $("<div></div>", {"class": "flex-container-cargo-seleccionado", "id": "item_cargo_" + id});
            div.append($("<div></div>", {"class": "flex-item-cargo-seleccionado-texto set-general-font", "text": id}));
            div.append($("<div></div>", {"class": "flex-item-cargo-seleccionado-icon-pdf"}).append($("<i></i>", {"class": "fa fa-file-pdf-o"})));
            div.append("{!! FuncionesGlobales::valida_boton_req('admin.reclutamiento_elimina_req','<i class=\'fa fa-times\'></i>','boton','flex-item-cargo-seleccionado-icon eliminar_req') !!}");
            div.append($("<input />", {"type": "hidden", "value": id, "name": "requerimientos_sugeridos[]"}));
            $("#requerimientos_seleccionados").append(div);
            $(this).parents("tr").remove();
        });

        $(document).on("click", ".eliminar_req", function () {
            //VALIDAR SI ES UN REGISTRO EXISTENTE
            var data_id = $(this).data("id");
            var obj = $(this);
            if (typeof data_id != "undefined") {
                //ELIMINA REGISTRO
                $.ajax({
                    type: "POST",
                    data: {id: data_id},
                    url: "{{route('admin.reclutamiento_elimina_req')}}",
                    success: function () {
                        obj.parents(".flex-container-cargo-seleccionado").remove();
                        cargar_requerimientos(1);
                    }

                });
            }
            else {
                $(this).parents(".flex-container-cargo-seleccionado").remove();
                cargar_requerimientos(1);
            }


        });
    });
</script>

@stop