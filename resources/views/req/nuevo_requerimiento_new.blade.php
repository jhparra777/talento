@extends("req.layout.master")
@section("contenedor")
    {{-- Header --}}

    @include('req.layout.includes._section_header_breadcrumb', ['page_header' => "Nuevo requerimiento"])

    <div class="row mt-4">
        {!! Form::open(["route" => "req.guardar_requerimiento", "files"=>true, "id" => "frm_crearReq"]) !!}
        
        {!! Form::hidden("negocio_id",$negocio->id) !!}
        {!! Form::hidden("cliente_id", $cliente->id, ["id"=>"cliente_id"]) !!}

        @include('req.requerimientos.includes._form_requerimiento', ["new" => true])
            
            {!! FuncionesGlobales::valida_boton_req("req.guardar_requerimiento","Enviar Requerimiento","boton","btn btnEnviarRequirimiento btn-default btn-block | tri-br-2 tri-txt-green tri-bg-white tri-bd-green tri-transition-200 tri-hover-out-green","","enviar_requerimiento_btn") !!}
        {!! Form::close()!!}
    </div>
    @include('req.requerimientos.includes._js_nuevo_requerimiento')
@stop