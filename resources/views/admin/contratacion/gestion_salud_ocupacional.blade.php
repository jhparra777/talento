@extends("admin.layout.master")
@section('contenedor')

    <h3>Gestion salud ocupacional</h3>
    <br>

    <div class="table-responsive">
        <div class="col-md-12">
            
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"> INFORMACIÓN GENERAL DEL PROCESO </h3>
            
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" type="button">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                
                <div class="box-body">
                    <div class="chart">
                        <table class="table">
                            <tr>
                                <th>Requerimiento</th>
                                <td>{{ $candidatos->requerimiento }}</td>
                                <th>Número de orden</th>
                                <td>{{$candidatos->orden}}</td>
                            </tr>

                            <tr>
                                <th>Candidato</th>
                                <td>{{ $candidatos->candidato }}</td>
                                <th>Cargo</th>
                                <td>{{$candidatos->cargo}}</td>
                            </tr>

                            <tr>
                                <th>Proveedor exámenes</th>
                                <td>{{ $candidatos->proveedor }}</td>
                                <th>Observación laboratorio</th>
                                <td>{!! $candidatos->observacion !!}</td>
                            </tr>

                            <tr>
                                <th>Exámenes de la orden</th>
                                <td>
                                    <ul>
                                        @foreach($examenes as $examen)
                                            <li>{{$examen->nombre}}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <th>
                                    Documento cargado
                                </th>
                                <td>
                                   <a href="{{asset("recursos_documentos_verificados/$candidatos->documento")}}" target="_blank">Ver documento</a>
                                </td>
                            </tr>
                        </table>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">ACCIONES </h3>
                </div>

                <input type="hidden" name="orden_id" id="orden_id" value="{{ $candidatos->orden }}">

                <div class="box-body" class="center" style="text-align: center;">
                    <button
                        class="btn btn-app btn-apto"
                        style="margin-right: 5px; background-color: #00a65a; border-color: #008d4c; color: white;"
                        type="submit"
                        data-orden="{{ $candidatos->orden }}"
                        {{--onclick="cambiar_estado(1)"--}}
                        id="show_moda_esp"
                    >
                        <i class="fa fa-check"></i>
                        Continúa
                    </button>

                    <button
                        class="btn btn-app btn-no-apto"
                        style="margin-right: 5px; background-color: #dd4b39; border-color: #d73925; color: white;"
                        type="submit"
                        data-orden="{{ $candidatos->orden }}"
                        onclick="cambiar_estado(2)"
                    >
                        <i class="fa fa-times"></i>
                        No Continúa
                    </button>

                    {{--<button class="btn btn-app btn-enviar-examenes" style="margin-right: 5px;     background-color: #f39c12; border-color: #e08e0b; color: white;" type="submit" data-candidato_req="{{$candidatos->req_can}}">
                        <i class="fa fa fa-table"></i>
                        Env. Examenes
                    </button>--}}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="especificacionesModal" tabindex="-1" role="dialog" aria-labelledby="espeficacionesModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="espeficacionesModalLabel">Especificar recomendaciones *</h4>
                </div>
                <div class="modal-body">
                    <form action="">
                        <div id="especificaciones" style="background-color: white;"></div>

                        {{--<textarea class="form-control" id="especificaciones" rows="5" placeholder="Especificar recomendaciones">{{ $candidatos->observacion }}</textarea>--}}
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success" onclick="cambiar_estado_modal(1)">Apto</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelector('#show_moda_esp').addEventListener('click', () => {
            $('#especificacionesModal').modal('show')
        });

        const cambiar_estado_modal = (id) => {
            const especificaciones = document.querySelector('textarea[name="especificaciones"]');

            if(especificaciones.value == ''){
                especificaciones.style.borderColor = 'red';
            }else{
                $.ajax({
                    type: "POST",
                    data : {
                        accion : id,
                        orden : {{ $candidatos->orden }},
                        especificaciones : especificaciones.value
                    },
                    url: "{{ route('admin.cambiar_estado_salud') }}",
                        success: function(response) {
                        mensaje_success(response.mensaje);

                        setTimeout(() => {
                            window.location.href = '{{ route("admin.salud_ocupacional") }}';
                        }, 3000);
                    }
                });
            }
        }

        function cambiar_estado(id){
            $.ajax({
                type: "POST",
                data: "accion=" + id + "&orden=" + {{$candidatos->orden}},
                url: "{{ route('admin.cambiar_estado_salud') }}",
                    success: function(response) {
                    mensaje_success(response.mensaje);

                    setTimeout(() => {
                        window.location.href = '{{ route("admin.salud_ocupacional") }}';
                    }, 3000);
                }
            });
        }

        $(function () {            
            $('#especificaciones').trumbowyg({
                lang: 'es',
                btns: [
                    //['viewHTML'],
                    ['undo', 'redo'],
                    //['formatting'],
                    ['strong' /*'em', 'del'*/],
                    //['superscript', 'subscript'],
                    //['link'],
                    //['insertImage'],
                    //['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
                    //['unorderedList', 'orderedList'],
                    //['horizontalRule'],
                    ['removeformat'],
                    //['fullscreen']
                ],
                removeformatPasted: true,
                tagsToRemove: ['script', 'link']
            });

            $('#especificaciones').trumbowyg('html', `{!! $candidatos->observacion !!}`)
            $('textarea[name="especificaciones"]').val(`{!! $candidatos->observacion !!}`)

            $(".btn-enviar-examenes").on("click", function() {
                var id         = $(this).data("candidato_req");
                var cliente    = $(this).data("cliente");
                var orden_id   = $('#orden_id').val();
     
                $.ajax({
                    type: "POST",
                    data: {"candidato_req" : id, "cliente_id" : cliente, "orden_id" : orden_id},
                    url: "{{ route('admin.enviar_examenes_again_view') }}",
                    success: function(response) {
                        $("#modal_gr").find(".modal-content").html(response.view);
                        $("#modal_gr").modal("show");
                    }
                });
            });

            $(document).on("click", "#guardar_examen", function() {
                
                if($('#proveedor').val() === ""){
                    $('#proveedor_med_text').show();
                }else{
                    var obj = $(this);
                        
                    $.ajax({
                        type: "POST",
                        data: $("#fr_enviar_examen").serialize(),
                        url: "{{ route('admin.enviar_examenes_salud_ocup') }}",
                        success: function(response) {
                            if (response.success) {                                
                                $("#modal_peq").modal("hide");
                                mensaje_success("El candidato se ha enviado a exámenes médicos.");
                                obj.prop("disabled", true);
                                var candidato_req = $("#candidato_req_fr").val();
                                $("#grupo_btn_" + candidato_req + "").find(".btn-enviar-examenes").prop("disabled", true);
                                location.reload();
                            } else {
                                $("#modal_peq").find(".modal-content").html(response.view);
                            }
                        }
                    });
                }

            });
        });
    </script>
@stop