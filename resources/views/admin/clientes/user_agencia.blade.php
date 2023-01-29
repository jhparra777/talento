@extends("admin.layout.master")
@section("contenedor")
{!! Form::model($usuario,["route"=>"admin.actualizar_usuario_cliente","id"=>"frm_usuarios","method"=>"POST","autocomplete"=>"off"]) !!}

{!! Form::hidden("id") !!}
 
 <h3>Agencias</h3>

    <div class="table-responsive">

        <table class="table table-bordered">
            <thead>
             <tr>
              <th>
                <input type="checkbox" name="seleccionar_todos2" id="seleccionar_todos2">
              </th>
              <th>Seleccionar todos</th>
             </tr>
            </thead>
            <tbody>
             @foreach($agencias as $agencia)
              <tr>
                <td>
                 {!! Form::checkbox("agencias[]",$agencia->id,((in_array($agencia->id,$agencias_user))?true:false))  !!}
                </td>
                <td>{{$agencia->descripcion}}</td>
              </tr>
             @endforeach
            </tbody>
        </table>
<!-- {!! $clientes->appends(Request::all())->render() !!} -->
    </div>

{!! Form::close() !!}
<script>
    $(function () {

        $('#autocomplete_cliente').autocomplete({
                serviceUrl: '{{ route("autocomplete_cliente") }}',
                autoSelectFirst: true,
                onSelect: function (suggestion) {
                    $("#cliente_id").val(suggestion.id);
                }
            });

        $('#ciudad_autocomplete').autocomplete({
            serviceUrl: '{{ route("autocomplete_cuidades") }}',
            autoSelectFirst: true,
            onSelect: function (suggestion) {
                $("#pais_id").val(suggestion.cod_pais);
                $("#departamento_id").val(suggestion.cod_departamento);
                $("#ciudad_id").val(suggestion.cod_ciudad);
            }
        });

        $("#seleccionar_todos").on("change", function (){
            var obj = $(this);
            $("input[name='permiso[]']").prop("checked", obj.prop("checked"));
        });

        $(".padre").on("change", function () {
            var obj = $(this);

            $(".padre" + obj.data("id") + "").prop("checked", obj.prop("checked"));
        });

        $("#seleccionar_todos2").on("change", function () {
            var obj = $(this);
            $("input[name='clientes[]']").prop("checked", obj.prop("checked"));
        });

    });
</script>

@stop
