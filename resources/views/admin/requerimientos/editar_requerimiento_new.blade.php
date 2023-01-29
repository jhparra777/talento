@extends("admin.layout.master")
@section("contenedor")
    {{-- Header --}}
    @include('admin.layout.includes._section_header_breadcrumb', ['page_header' => "Editar requerimiento $requermiento->id",'more_info' => "Cliente $cliente->nombre"])
    <input type="hidden" id="cliente_id" value="{{ $cliente->id }}">

    <div class="row mb-3">
        {!! Form::model($requermiento, ["route" => "admin.actualizar_requerimiento","files" => true, "id" => "frm_crearReq"]) !!}
            {!! Form::hidden("id",null) !!}
            {!! Form::hidden("modulo",$modulo) !!}

            @include('admin.requerimientos.includes._form_requerimiento', ['editar' => true])
          

            <div class="col-md-12">
                <button type="button" id="enviar_requerimiento_btn" class="btn btn-default btn-block | tri-br-2 tri-txt-green tri-bg-white tri-bd-green tri-transition-200 tri-hover-out-green">Actualizar</button>
            </div>
        {!! Form::close() !!}
    </div>

    @include("admin.requerimientos.includes._js_editar_requerimiento")
@stop