<div class="col-md-12 mt-2">
    <div class="panel panel-default">
        <div class="panel-body container_grilla">
            @if(method_exists($data, 'total'))
            <h4 class="box-title">Total de Registros: <span>{{$data->total()}}</span>
            </h4>
            @endif
            <div class="tabla table-responsive">
                <table class="table table-hover table-striped text-center">
                    <thead>
                        <tr>
                            @each('admin.reportes.includes.partials._header_grilla_detalle_validacion_documental', $headersr, 'value')
                        </tr>
                    </thead>
                    <tbody>
                        @each('admin.reportes.includes.partials._body_grilla_detalle_validacion_documental', $data, 'field')
                    </tbody>
                </table>
            </div>
            <div>
                @if(method_exists($data, 'appends'))
                 {!! $data->appends(Request::all())->render() !!}
                 @endif
            </div>
        </div>
    </div>
</div>
    	
    
    
    
    
    