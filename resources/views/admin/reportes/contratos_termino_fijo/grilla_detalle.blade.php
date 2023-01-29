<div class="container">
    <div class="row">
        @if(method_exists($data, 'total'))
            <h4>
                Total de Registros :
                <span>
                    {{ $data->total() }}
                </span>
            </h4>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    @foreach($headers as $key => $header)
                        <th class="active" >
                            {{ $header }}
                        </th>
                    @endforeach
                </tr>

                @foreach($data as $field)
                    <tr>
                        <td>{{ $field->numero_req }}</td> {{-- Num req --}}
                        <td>{{ $field->fecha_creacion_req }}</td>
                        <td>{{ $field->tipo_proceso }}</td> {{-- Tipo de proceso --}}
                        <td>{{ $field->agencia }}</td> {{-- Agencia --}}
                        <td>{{ $field->ciudad_trabajo }}</td> {{-- Ciudad de trabajo --}}
                        <td>{{ $field->cliente }}</td> {{-- Cliente --}}
                        <td>{{ $field->cargo }}</td> {{-- Cargo --}}
                        <td>{{$field->tipo_identificacion}}</td>{{--  tipo identificación--}}
                        <td>{{ $field->cedula }}</td> {{-- Cédula contratado --}}
                        <td>{{ $field->nombre_completo }}</td> {{-- Nombre contratado --}}
                        <td>{{ $field->numero_celular }}</td> {{-- Celular contratado --}}
                        
                        <td>{{ $field->fecha_ingreso }}</td>  {{-- Fecha de ingreso --}}
                        <td>{{ $field->fecha_fin_contrato }}</td>  {{-- Fecha de fin contrato --}}
                        <td>{{ $field->fecha_envio_contrato }}</td> {{-- Fecha de envío a contratación --}}

                        <td> {{-- Fecha de firma de contrato --}}
                            {{ $field->fecha_firma_contrato }}
                        </td>


                        <td> {{-- Estado de contrato --}}
                            @if($field->estado_global == 1)
                                @if ($field->estado_contrato === '0')
                                    Cancelado
                                @elseif($field->estado_contrato == 1)
                                    Firmado
                                @else
                                    Pendiente
                                @endif
                            @else
                                Anulado
                            @endif
                        </td>
                        
                        <td>{{ $field->nombre_completo_gestion }}</td> {{-- Usuario que solicitó contratación --}}

                        <td>
                            @if( $field->notificacion_finalizacion_contrato != null && $field->notificacion_finalizacion_contrato != "")
                                <ul style="padding-left: 15px;">
                                    @foreach(explode("*",$field->notificacion_finalizacion_contrato) as $notificacion)
                                    
                                        <li>
                                            {!! $notificacion !!}
                                        </li>
                                   
                                    @endforeach
                                 </ul>
                            @endif
                        </td>

                        @if( !isset($formato) )
                                <td>
                                    <a type="button" data-contrato_id="{{$field->contrato_id}}" class="btn btn-block btn-info btn_enviar_carta_modal"> Enviar carta</a>
                                </td>
                        @endif
                    </tr>
                @endforeach
            </table>
        </div>

        <div>
            @if(method_exists($data, 'appends'))
                {!! $data->appends(Request::all())->render() !!}
            @endif
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function(){

        $(document).on("click", ".btn_enviar_carta_modal", function() {

            //var req_id = $(this).data("req_id");
            //var user_id = $(this).data("user_id");
            var id = $(this).data("contrato_id");
            //var cliente = $(this).data("cliente");
            
            $.ajax({
                type: "POST",
                data:    "contrato_id=" + id,
                url: "{{ route('admin.modal_enviar_carta_terminacion_contrato') }}",
                success: function(response) {
                    $("#modalTriLarge").modal("hide");
                    $("#modalTriLarge").find(".modal-content").html(response);
                    $("#modalTriLarge").modal("show");
                }
            });
        });

        $(document).on("click", "#enviar_carta_terminacion_contrato", function() {
            $(this).prop("disabled",true);
            var btn_id = $(this).prop("id");

            $.ajax({
                type: "POST",
                data: $("#fr_envio_carta_terminacion_contrato").serialize(),
                url: "{{ route('admin.envio_carta_terminacion_contrato') }}",
                success: function(response) {
                    if (response.success) {
                        $("#modalTriLarge").modal("hide");
                        mensaje_success("Se ha enviado la carta con éxito!");
                        setTimeout(() => {
                            $("#modal_success").modal("hide");
                            window.location.reload();
                        }, 1500)
                    } else {
                        mensaje_error("¡Ocurrio un error al enviar la carta!");
                    }

                }
            });
        });
    })
</script>
  
  