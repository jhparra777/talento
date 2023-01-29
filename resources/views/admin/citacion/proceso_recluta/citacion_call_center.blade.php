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
            {!! Form::hidden("user_id",$codigo_user) !!}
            {!! Form::hidden("return",true) !!}

            @if($codigo_user == 0)
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    Este usuario no tiene registrada su hoja de vida.
                </div>
            @endif

            <div class="bloques_perfilamiento">
                <div class="col-md-4">
                    <div class="bloque" style="background: #FFAA39;">
                        <h4>Información Candidato</h4>

                        <div class="form-group col-md-12">
                            {!! Form::label('identificacion', 'Identificación') !!}
                            {!! Form::text('identificacion',null,['class'=>'form-control','id'=>'identificacion','placeholder'=>'Número Identificación','readonly' => 'true','value'=>old('identificacion')]) !!}
                            <p class="text-danger">{!! FuncionesGlobales::getErrorData("identificacion",$errors) !!}</p>
                        </div>

                        <div class="form-group col-md-12">
                            {!! Form::label('name', 'Nombres') !!}
                            {!! Form::text('nombres',null,['class'=>'form-control','id'=>'name','placeholder'=>'Nombres','readonly' => 'true','value'=>old('name')]) !!}
                            <p class="text-danger">{!! FuncionesGlobales::getErrorData("name",$errors) !!}</p>
                        </div>


                        <div class="form-group col-md-12">
                            {!! Form::label('primer_apellido', 'Primer Apellido') !!}
                            {!! Form::text('primer_apellido',null,['class'=>'form-control','id'=>'primer_apellido','placeholder'=>'Primer Apellido','readonly' => 'true','value'=>old('primer_apellido')]) !!}
                            <p class="text-danger">{!! FuncionesGlobales::getErrorData("primer_apellido",$errors) !!}</p>
                        </div>


                        <div class="form-group col-md-12">
                            {!! Form::label('segundo_apellido', 'Segundo Apellido') !!}
                            {!! Form::text('segundo_apellido',null,['class'=>'form-control','id'=>'segundo_apellido','placeholder'=>'Segundo Apellido','readonly' => 'true','value'=>old('segundo_apellido')]) !!}
                            <p class="text-danger">{!! FuncionesGlobales::getErrorData("segundo_apellido",$errors) !!}</p>
                        </div>

                        <div class="form-group col-md-12">
                            {!! Form::label('telefono_fijo', 'Teléfono Fijo') !!}
                            {!! Form::text('telefono_fijo',null,['class'=>'form-control','id'=>'telefono_fijo','placeholder'=>'Teléfono Fijo','readonly' => 'true','value'=>old('telefono_fijo')]) !!}
                            <p class="text-danger">{!! FuncionesGlobales::getErrorData("telefono_fijo",$errors) !!}</p>
                        </div>

                        <div class="form-group col-md-12">
                            {!! Form::label('telefono_movil', 'Teléfono Móvil') !!}
                            {!! Form::text('telefono_movil',null,['class'=>'form-control','id'=>'telefono_movil','readonly' => 'true','placeholder'=>'Teléfono Móvil']) !!}
                            <p class="text-danger">{!! FuncionesGlobales::getErrorData("telefono_movil",$errors) !!}</p>
                        </div>

                        <div class="form-group col-md-12">
                            {!! Form::label('email', 'Correo Electronico') !!}
                            {!! Form::text('email',null,['class'=>'form-control','id'=>'email','readonly' => 'true','placeholder'=>'Dirección de Correo Electronico']) !!}
                            <p class="text-danger">{!! FuncionesGlobales::getErrorData("email",$errors) !!}</p>
                        </div>

                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="col-md-4" style="background: #FF9600">
                    <div  style="background: #FF9600;">
                        <div class="container_cargos" style="background: #FF9600">

                    <!-- Datos Citación -->
                            <div class="form-group col-md-11" style="background: #f1fe7a;">
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
                <div class="col-md-4">
                    <div class="bloque" style="background: #EA8806;border-radius: 0 5px 5px 0">
                        <h4>Cargos Genericos Asociados</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="divScroll">
                                        <table class="table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Cargo</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($cargos_seleccionados as $count => $cargos)
                                                <tr>
                                                    <td> {{ ++$count }} </td>
                                                    <td>
                                                        <ul>
                                                             <li>
                                                                   {{ $cargos->descripcion }}
                                                            </li>
                                                         </ul>
                                                    </td>
                                                </tr>
                                             @endforeach
                                            </tbody>  
                                         </table>
                                    </div>
                                </div>
                            </div>
                        <div class="clearfix"></div>

                        <h4>Requerimientos Asociados</h4>
                        <div style="display: flex; flex-wrap: wrap; justify-content: center;" id="requerimientos_seleccionados">
                            @foreach($requerimientos_seleccionados as $req)
                            <div class="flex-container-cargo-seleccionado" id="item_cargo_{{$req->tabla_id}}">
                                <div class="flex-item-cargo-seleccionado-texto set-general-font">{{$req->tabla_id}}</div>
                                <div class="flex-item-cargo-seleccionado-icon-pdf">
                                    <a class="fa fa-file-pdf-o" target="_black" href="{{route("admin.ficha_pdf",["id"=>$req->tabla_id])}}">
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <br/>
            <button type="submit" class="btn btn-success">Guardar</button>
            {!! Form::close() !!}
        @endif
    @endif

<script>
    $(function () {

        $("#fecha_cita").datepicker(confDatepicker);

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

        });

       
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

        
    });
</script>

@stop