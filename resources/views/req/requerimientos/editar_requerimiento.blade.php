@extends("req.layout.master")
@section('contenedor')
    <style>
        .autocomplete-suggestions {
            border: 1px solid #999;
            background: #FFF;
            overflow: auto;
        }

        .input-group-bt4{
          position: relative;
          display: -webkit-box;
          display: -ms-flexbox;
          display: flex;
          -ms-flex-wrap: wrap;
          flex-wrap: wrap;
          -webkit-box-align: stretch;
          -ms-flex-align: stretch;
          align-items: stretch;
        }

        .input-group-bt4 select {
          position: relative;
          -webkit-box-flex: 1;
          -ms-flex: 1 1 auto;
          flex: 1 1 auto;
          width: 1%;
          margin-bottom: 0;
        }

        .input-group-append {
          margin-left: -1px;
          display: -webkit-box;
          display: -ms-flexbox;
          display: flex;
        }
    </style>

    <h3>
        Requerimiento  <strong># {{$requermiento->id}}</strong> <a class="btn btn-danger pull-right" href="{{route("req.lista_requerimientos")}}" onclick="">Volver listado</a>
        <input type="hidden" id="cliente_id" value="{{ $cliente->id }}">
    </h3>

        {!! Form::model($requermiento, ["route" => "req.actualizar_requerimiento","files" => true]) !!}
            {!! Form::hidden("id",null) !!}
            {!! Form::hidden("modulo","req") !!}
            @include("admin.requerimientos.includes._inputs_requerimiento", ["modulo" => "req", "editar" => true])

            <a class="btn btn-danger" href="{{route("req.lista_requerimientos")}}" onclick="">Volver listado</a>
            <button class="btn btn-success" onclick="">Actualizar</button>
        {!! Form::close() !!}

    @include("admin.requerimientos.includes._scripts_edicion_requerimiento")
@stop