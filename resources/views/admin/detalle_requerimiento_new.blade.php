@extends("admin.layout.master")
@section("contenedor")
<style>

.titulo1{
    background: #f0f0f0 none repeat scroll 0 0;
    font-weight: bold;
    padding: 10px;
    text-align: center;
}

</style>
    {{-- Header --}}
    @include('admin.layout.includes._section_header_breadcrumb', ['page_header' => "Detalle requerimiento"])

    <div class="row">
        <div class="col-md-12">
        <a type="button" 
            class="btn btn-primary btn-sm pull-right  | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple status" 
            href="{{route("admin.mis_requerimiento")}}">
            Volver listado
        </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mt-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    @include("admin.requerimientos.includes._informacion_requerimiento")

                    @include("admin.requerimientos.includes._candidatos_postulados_requerimiento")
                </div>

                <div class="panel-footer">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <a class="btn btn-default | tri-br-2 tri-fs-12 tri-txt-gray tri-bg-white tri-bd-gray tri-transition-300 tri-hover-out-gray"  href="{{route("admin.mis_requerimiento")}}">Volver listado</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop