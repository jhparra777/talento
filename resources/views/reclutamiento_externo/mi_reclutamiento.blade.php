@extends("reclutamiento_externo.layout.master")
@section("menu_candidato")
    @include("reclutamiento_externo.layout.include.menu_reclutamiento")
@endsection
<style type="text/css">
    th{
        text-align: center;
    }
</style>

@section('content')
<div class="row">
            <div class="col-md-12">
                <h3  class="h3-t3">Mi reclutamiento</h3>

                <div class="grid-container">
                </div>
            </div>
</div>
<div class="col-md-12">
    {!! Form::model(Request::all(),["route"=>"reclutamiento_externo.mi_reclutamiento","method"=>"GET","accept-charset"=>"UTF-8"]) !!}
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="col-sm-6 col-lg-6" style="text-align: initial;">
                                        <div class="form-group">
                                            <label for="descripcion_documentos" class="control-label">Cedula:<span class='text-danger sm-text-label'>*</span> </label>

                                            {!! Form::text("cedula", null, ["class" => "form-control solo-numero", "placeholder" => "Cedula de candidato", "id" => "cedula"]) !!}
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-lg-6" style="text-align: initial;">
                                        <div class="form-group">
                                            <label for="descripcion_documentos" class="control-label">#Oferta:<span class='text-danger sm-text-label'>*</span> </label>

                                            {!! Form::text("oferta", null, ["class" => "form-control solo-numero", "placeholder" => "Número de la oferta", "id" => "id_oferta"]) !!}
                                        </div>
                                    </div>

                                    

                                    

                                    

                                    <div class="col-md-12 text-center">
                                        

                                        {{--  --}}
                                        <div class="display-contents text-center" id="save-document-box" style="width: 164px;text-align: center;">
                                            <button class="btn-quote" type="submit" id="guardar_documento" style="display: initial;">
                                                <i class="fa fa-floppy-o"></i> Buscar
                                            </button>
                                        </div>

                                        {{--  --}}
                                        
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
<div class="row">
                        <div class="col-md-12">
                                <div class="grid-container table-responsive">
                                    <table class="table table-striped" id="tbl_reclutamiento">
                                        <thead>
                                            <tr>
                                                <th>#Oferta</td>
                                                <th>Cédula</th>
                                                <th>Candidato</th>
                                                <th>Fecha reclutamiento</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($reclutamiento as $candidato)
                                                <tr>
                                                    <td>{{$candidato->requerimiento}}</td>
                                                    <td>{{$candidato->cedula}}</td>
                                                    <td>{{$candidato->primer_nombre}} {{$candidato->segundo_nombre}} {{$candidato->primer_apellido}}
                                                    {{$candidato->segundo_apellido}}</td>
                                                    <td>{{$candidato->fecha_reclutamiento}}</td>
                                                    <td>
                                                       <a type="button" class="btn btn-primary btn-peq editar_ disabled_estudios" type="button" href="{{route('admin.actualizar_hv_admin',['user_id'=>$candidato->user_id])}}"> <i class="fa fa-address-card-o" ></i>                           <!--Editar-->
                                                        </a>                     <!--Editar-->
                                                    
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                        </div>
</div>
<div>
            @if(method_exists($reclutamiento, 'appends'))
                {!! $reclutamiento->appends(Request::all())->render() !!}
            @endif
        </div>

@stop