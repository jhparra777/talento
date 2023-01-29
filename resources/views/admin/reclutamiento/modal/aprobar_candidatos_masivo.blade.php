<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">
        Aprobar candidatos enviados al cliente
    </h4>
</div>

<div class="modal-body">
    {!! Form::model(Request::all(),["method"=>"post","route"=>"admin.reclutamiento_db","files"=>true, "id"=>"fr_aprobar_candidatos_masivo"]) !!}
        {!! Form::hidden("req_id", $req_id, ["id" => "req_id"]) !!}
        <div class="col-md-12">
            <div class="form-group">
                <button class="btn btn-sm btn-primary pull-right d-none" id="export_excel_aprobar_candidatos_btn" type="button" data-req="{{ $req_id }}" onclick="exportarExcel('{{ route('admin.aprobar_candidatos_req_masivo_excel')}}?req={{$req_id}}')" title="Descargará la plantilla con los candidatos pendientes por aprobar por el cliente">
                    <i aria-hidden="true" class="fa fa-file-excel-o"></i> Descargar Plantilla
                </button>
            </div>
        </div>

        <div class="col-md-12 mt-2">
            <div class="alert alert-info text-black" role="alert">
                <ol>
                    <p>Pasos para aprobar candidatos de forma masiva:</p>
                    <li>Descargar la plantilla que incluye los candidatos que esperan por aprobación del cliente</li>
                    <li>Abre el archivo descargado y coloca una <b>X</b> en la columna <b>apto</b> si el candidato fue aprobado por el cliente, en caso contrario coloca una <b>X</b> en la columna <b>no_apto</b>. <small><b>Importante debe quedar una columna vacia (entre apto y no_apto).</b></small></li>
                    <li>Sube el archivo, espera y obtendrás la respuesta de la solicitud realizada.</li>
                </ol>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label" for="archivo">Archivo Plano Excel</label>
        
                {!! Form::file('archivo',["class"=>"form-control", "accept" => ".xlsx, .xls, .csv", "required" => "required"]) !!}
                
                <p class="text-danger">{!! FuncionesGlobales::getErrorData("archivo",$errors) !!}</p>
            </div>
        </div>
    {!! Form::close() !!}

    <div class="clearfix"></div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-success" id="confirmar_aprobar_candidatos_masivo" >Confirmar</button>
</div>